<?php
function e($s)
{
    return htmlspecialchars($s, ENT_QUOTES);
}

const BD_HOST = '127.0.0.1';
const BD_USER = 'root';
const BD_PWD = 'jo12se34';
const BD_SCHEME = 'preguntasmatch';

function abrirBD()
{
    $bd = new mysqli(
        BD_HOST,    // servidor
        BD_USER,         // usuario
        BD_PWD,          // contraseña
        BD_SCHEME
    );
    if ($bd->connect_errno != 0) {
        printf(
            "Error de conexión a la BD: %s\n",
            $bd->connect_error
        );
        die();
    }
    $bd->set_charset('utf8mb4');
    return $bd;
}

function prearray($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function contarArchivosPNG($carpeta)
{
    $archivos = glob($carpeta . "/*.png");
    return count($archivos);
}
