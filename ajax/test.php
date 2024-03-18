<?php
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/user_answers.php';
require_once __DIR__ . '/../models/answer.php';
require_once __DIR__ . '/../models/question.php';
session_start();

$data = array();
$status = 200;
$errors = array();

// obtener los datos
$idAnswer = $_POST['answer'];
$idQuestion = $_POST['question'];
$message = $_POST['message'];
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// verificar si el idQuestion corresponde con idTest guardado
$question = Question::getById($idQuestion);
if ($question->idTest != $_SESSION['test']['idTest']) {
    $status = 400;
    $_SESSION['error'] = 'La pregunta no corresponde con el test seleccionado.';
}

// verificar si hay un mensaje que tambien haya un user logueado
if ($message != '' && $user == null) {
    $status = 400;
    $_SESSION['error'] = 'Tiene que haber un usuario logueado para poder enviar un mensaje o comentar.';
}

if ($status == 200) {
    // guardar las respuestas en SESSION
    $_SESSION['test']['answers'][$idQuestion] = [$idAnswer];
    if ($message != '') {
        $_SESSION['test']['answers'][$idQuestion][] = $message;
    }

    // gudar en BD todas las respuestas
    if ($_SESSION['test']['lastQuestion'] == 1) {
        $idTest = $_SESSION['test']['idTest'];
        foreach ($_SESSION['test']['answers'] as $idQ => $ansArray) {
            $user_answers = new User_answers;
            $existingEntry = $user != null ? User_answers::getUserAnswer($user->idUser, $idQuestion) : false;
            if ($existingEntry != false) {
                $user_answers = $existingEntry;
            }
            $user_answers->idUser = $user != null ? $user->idUser : null;
            $user_answers->idTest = $idTest;
            $user_answers->idQuestion = $idQ;
            $user_answers->idSelectedAnswer = $ansArray[0];
            $user_answers->message = isset($ansArray[1]) ? $ansArray[1] : null;
            $user_answers->date = date("Y-m-d H:i:s");

            $existingEntry != false ? $user_answers->update() : $user_answers->insert();
            unset($_SESSION['test']);
        }
    }
}

$data['status'] = $status;
$data['errors'] = $errors;

header('Content-Type: application/json');
echo json_encode($data);
