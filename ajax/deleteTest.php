<?php
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/test.php';
session_start();

// obtener los datos
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$idTest = $_GET['idTest'];

// verificar si hay un user logueado
if ($user == null) {
    $_SESSION['error'] = "Necesitas estar logueado para acceder a esta función.";
    prearray($_SESSION['user']);
    header('Location: ../index.php');
    exit;
}

// verificar si el test pertenece al usuario logueado
$test = Test::getById($idTest);
if ($test->idUser != $user->idUser) {
    $_SESSION['error'] = "No puedes borrar un test que no te pertenece.";
    header('Location: ../user.php?idUser=' . $user->idUser);
    exit;
}

if ($test->image != null) {
    unlink('../uploads/usuarios/' . $user->idUser . '/test/'.$test->idTest.'-'.$test->image);
}

// borrar test
Test::deleteById($idTest);
header('Location: ../user.php?idUser='.$user->idUser);
