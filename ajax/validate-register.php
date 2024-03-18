<?php
require_once __DIR__ . '/../models/user.php';
session_start();

$data = array();
$status = 200;
$errors = array();

if (isset($_POST['iconRegister']) && $status == 200) {
    $icon = $_POST['iconRegister'];
    if (empty($icon)) {
        $status = 400;
        $errors['iconRegister'] = 'Error al cargar el icono.';
    } else if (!file_exists('../assets/img/icons/' . $icon)) {
        $status = 400;
        $errors['iconRegister'] = 'Ese icono no existe.';
    }
}
if (isset($_POST['idUser'])  && $status == 200) {
    $idUser = $_POST['idUser'];
    if (!isset($_SESSION['user'])) {
        $status = 401;
        $errors['idUser'] = 'Debes iniciar sesión para poder modificar tus datos.';
    } elseif (isset($_SESSION['user']) && $_SESSION['user']->idUser != $idUser) {
        $status = 401;
        $errors['idUser'] = 'No puedes modificar los datos de otro usuario.';
    }
}
if (isset($_POST['nameRegister']) && $status == 200) {
    $name = $_POST['nameRegister'];
    if (empty($name)) {
        $status = 400;
        $errors['nameRegister'] = 'Introduce un nombre.';
    } else {
        $user = User::getByName($name);
        if (isset($_POST['idUser']) && $user != null && $user->idUser != $_POST['idUser']) {
            $status = 400;
            $errors['nameRegister'] = 'El nombre ' . $name . ' se encuentra en uso. 1';
        } else if (!isset($_POST['idUser']) && $user != null) {
            $status = 400;
            $errors['nameRegister'] = 'El nombre ' . $name . ' se encuentra en uso.';
        }
    }
}
if (isset($_POST['emailRegister']) && $status == 200) {
    $email = $_POST['emailRegister'];
    if (empty($email)) {
        $status = 400;
        $errors['emailRegister'] = 'Introduce un correo electrónico.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $status = 400;
        $errors['emailRegister'] = 'Por favor, introduce un correo electrónico valido.';
    } else {
        $user = User::getByEmail($email);
        if (isset($_POST['idUser']) && $user != null && $user->idUser != $_POST['idUser']) {
            $status = 400;
            $errors['emailRegister'] = 'El correo electrónico ' . $email . ' se encuentra en uso. 1';
        } else if (!isset($_POST['idUser']) && $user != null) {
            $status = 400;
            $errors['emailRegister'] = 'El correo electrónico ' . $email . ' se encuentra en uso. 2';
        }
    }
}
if (isset($_POST['pwdRegister']) && $status == 200) {
    $pwd = $_POST['pwdRegister'];
    if (empty($pwd)) {
        $status = 400;
        $errors['pwdRegister'] = 'Introduce una contraseña.';
    } else if (strlen($pwd) < 5) {
        $status = 400;
        $errors['pwdRegister'] = 'La contraseña debe tener al menos 5 caracteres.';
    }
}


$data['status'] = $status;
$data['errors'] = $errors;

// Crear o guardar un usuario
if (
    isset($_POST['nameRegister']) && isset($_POST['emailRegister']) && isset($_POST['pwdRegister'])
    && isset($_POST['iconRegister']) && $status == 200
) {
    $user = isset($_POST['idUser']) ? User::getById($_POST['idUser']) : new User();
    $user->name = $name;
    $user->email = $email;
    $user->pwd = password_hash($pwd, PASSWORD_DEFAULT);;
    $user->icon = $icon;

    isset($_POST['idUser']) ? $user->update() : $user->insert();
    $_SESSION['user'] = $user;
}

header('Content-Type: application/json');
echo json_encode($data);
