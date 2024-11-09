<?php
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/user_answers.php';
require_once __DIR__ . '/../models/answer.php';
require_once __DIR__ . '/../models/question.php';
session_start();

$data = array();
$status = 200;
$errors = array();

$idAnswer = $_POST['answer'];
$idQuestion = $_POST['question'];
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Obtener la pregunt y respuestas
$question = Question::getById($idQuestion);
$answers = Answer::list($idQuestion);
$lastMessage = User_answers::getLastMessage($idAnswer, $user ? $user->idUser : '');

// Inicializar variable
$answerTxt = [];
$answerCount = [];
$result = false;

//Guardar valores: txt de la pregunta y respuestas y el número de personas que respondieron.
foreach ($answers as $k => $answer) {
    $answerSelectedList = User_answers::list($answer->idAnswer);
    $answerTxt[] = $answer->text;
    $answerCount[] = count($answerSelectedList);
    if ($answer->idAnswer == $idAnswer) {
        $res['sameOpinion'] = count($answerSelectedList);
    }
    if (count($answerSelectedList) > 0) {
        $result = true;
    }
}
$res['title'] = $result  != false ? $question->text : "No se ha encontrado resultados,\n¡Eres el primero en responder!";
$res['message'] = $lastMessage  != '' ? $lastMessage->message : '';
$res['labels'] = $answerTxt;
$res['data'] = $answerCount;
$res['lastQuestion'] = $_SESSION['test']['lastQuestion'];
// para ver si puede comentar o necesita loguearse
$res['user'] = $user;
// enviar el numero de archivos para los icones del register 
$rutaCarpetaIcons = '../assets/img/icons';
$res['numIcons'] = contarArchivosPNG($rutaCarpetaIcons);


$data['status'] = $status;
$data['errors'] = $errors;
$data['response'] = $res;

header('Content-Type: application/json');
echo json_encode($data);
