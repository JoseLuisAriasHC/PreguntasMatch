<?php
require_once __DIR__ . '/../models/test.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../models/question.php';
require_once __DIR__ . '/../models/answer.php';
require_once __DIR__ . '/../models/user_answers.php';
require_once __DIR__ . '/../models/test_of_the_day.php';

session_start();

$userLog = $_SESSION['user'];
$data = array();
$status = 200;
$errors = array();

// verificar que el titutlo no este vacio
if (isset($_POST['title']) && empty($_POST['title'])) {
    $status = 400;
    $errors['title'] = 'Por favor, introduce un título.';
}
// verificar que el description no este vacio
if (isset($_POST['description']) && empty($_POST['description'])) {
    $status = 400;
    $errors['description'] = 'Por favor, añade una descripción.';
}

// verificar que el image sea un archivo de imagen
if (isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $extensionesImagen = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array(strtolower($extension), $extensionesImagen)) {
        $status = 400;
        $errors['image'] = 'El archivo subido no corresponde a una imagen.';
    }
}

// verificar que ninguna preguna o respueste este vacio
foreach ($_POST as $key => $value) {
    if (strpos($key, 'question-') !== false) {
        if (empty($value)) {
            $status = 400;
            $errors["answer-question"] = "Las preguntas y las respuestas tienen que estar rellenados.";
        }
    }
}

if (isset($_POST['title']) && isset($_POST['description']) && $status == 200) {
    $test = isset($_POST['idTest']) ? Test::getById($_POST['idTest']) : new Test;
    $check = false;
    // UPDATE Test
    if (isset($_POST['idTest'])) {
        $idTest = $_POST['idTest'];
        $check = checkQuestionsAnswers($idTest);
        // se ha modificado
        if (!$check) {
            // borrar todos los datos relacionados con este Test
            test_of_the_day::deleteById($idTest);
            User_answers::deleteByIdTest($idTest);
            Answer::deleteByIdTest($idTest);
            Question::deleteByIdTest($idTest);
        }
        // Borrar img si tiene
        if ($_POST['checkImageStatus'] == 1 || isset($_FILES['image'])) {
            $ruta = './../uploads/usuarios/' . $userLog->idUser . '/test/' . $test->idTest . '-' . $test->image;
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
    }

    $test->title = $_POST['title'];
    $test->description = $_POST['description'];
    $test->idUser = $userLog->idUser;
    $test->date = date("Y-m-d");
    // si estan actualizando y borraron en algun momento la imagen que tenian que se cambia de nombre 
    // o que sea null en caso de que no hayan puesto otra imagen
    if (isset($_POST['idTest']) && $_POST['checkImageStatus'] == 1) {
        $test->image = isset($_FILES['image']) ? $_FILES['image']['name'] : null;
    } else {
        // que se actulice la imagen si han subido un fichero o que se mantegan si no ha detectado que borro algun momento la imagen
        $test->image = isset($_FILES['image']) ? $_FILES['image']['name'] : $test->image;
    }

    isset($_POST['idTest']) ? $test->update() : $test->insert();

    // descargar imagen
    if (isset($_FILES['image'])) {
        downloadImg($test, $userLog);
    }

    if (!$check) {
        insetQuestions($test);
    } else {
        $questionList = Question::list($idTest);
        $categories = [];
        foreach ($_POST as $key => $value) {
            // Verificar si la clave comienza por "category-"
            if (strpos($key, 'category-') === 0) {
                // Si la clave cumple con el patrón, añadir el elemento al resultado
                $categories[] = $value;
            }
        }
        for ($i = 0; $i < count($questionList); $i++) {
            $questionList[$i]->idCategory = $categories[$i];
            $questionList[$i]->update();
        }
    }
}

function insetQuestions($test)
{
    $questions = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question-') === 0) {
            $questions[$key] = $value;
        }
    }

    // insertar las questions
    foreach ($questions as $key => $value) {
        $category = $_POST['category-' . $key];
        $answers = explode(",", $_POST['answer-' . $key]);

        $question = new Question;
        $question->text = $value;
        $question->idTest = $test->idTest;
        $question->idCategory = $category;
        $question->insert();

        // insertar las answers
        foreach ($answers as $k => $v) {
            $answer = new Answer;
            $answer->text = $v;
            $answer->idQuestion = $question->idQuestion;
            $answer->insert();
        }
    }
}

// verificar que ninguna pregunta o respuesta se ha modificado o eliminado
function checkQuestionsAnswers($idTest)
{
    $result = true;
    $questionsList = Question::list($idTest);
    $i = 0;
    foreach ($_POST as $k => $value) {
        if (strpos($k, 'question-') === 0) {
            // verificar las preguntas
            $question = $value;

            if (isset($questionsList[$i])) {
                if (strcasecmp($questionsList[$i]->text, $question) !== 0) {
                    // ha cambiado el texto de alguna pregunta
                    $result = false;
                    return;
                }
            } else {
                // ha insertado nuevas preguntas
                $result = false;
                return;
            }

            // verificar las respuestas
            $answersPost = explode(",", $_POST['answer-' . $k]);
            $answersList = Answer::list($questionsList[$i]->idQuestion);
            if (count($answersPost) != count($answersList)) {
                // hay nuevas respuestas
                $result = false;
                return false;
            }
            for ($j = 0; $j < count($answersList); $j++) {
                if (strcasecmp($answersList[$j]->text, $answersPost[$j]) !== 0) {
                    // ha cambiado el texto de alguna respuesta
                    $result = false;
                    return;
                }
            }
            $i++;
        }
    }

    if ($i != count($questionsList)) {
        $result = false;
    }
    return $result;
}

function downloadImg($test, $userLog)
{
    $image = $_FILES['image'];
    /*Crea la carpeta del usuario */
    if (!file_exists('../uploads/usuarios/' . $userLog->idUser)) mkdir('../uploads/usuarios/' . $userLog->idUser);
    /*Crea la carpeta de test */
    if (!file_exists('../uploads/usuarios/' . $userLog->idUser . '/test')) mkdir('../uploads/usuarios/' . $userLog->idUser . '/test');

    /*Descargo la foto nueva */
    $nameIMG = $test->idTest . '-' . $image['name'];
    move_uploaded_file($image['tmp_name'], '../uploads/usuarios/' . $userLog->idUser . '/test/' . $nameIMG);
}

$data['status'] = $status;
$data['errors'] = $errors;

header('Content-Type: application/json');
echo json_encode($data);
