<?php
require_once __DIR__ . '/../models/user.php';
session_start();

$data = array();
$status = 200;
$errors = array();

if (isset($_POST['emailLogin'])) {
    $email = $_POST['emailLogin'];
    if (empty($email)) {
        $status = 400;
        $errors['emailLogin'] = 'Introduce un correo electrónico.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $status = 400;
        $errors['emailLogin'] = 'Por favor, introduce un correo electrónico valido.';
    }
}
if (isset($_POST['pwdLogin']) && empty($_POST['pwdLogin'])) {
    $status = 400;
    $errors['pwdLogin'] = 'Introduce una contraseña.';
}

if (!empty($_POST['emailLogin']) && !empty($_POST['pwdLogin'])) {
    $email = $_POST['emailLogin'];
    $pwd = $_POST['pwdLogin'];
    $user = User::getByEmail($email);
    if ($user && password_verify($pwd, $user->pwd)) {
        $_SESSION['user'] = $user;
    } else {
        $status = 401;
        $errors['login'] = 'El correo y la contraseña no coinciden.';
    }
}

$data['status'] = $status;
$data['errors'] = $errors;

header('Content-Type: application/json');
echo json_encode($data);
