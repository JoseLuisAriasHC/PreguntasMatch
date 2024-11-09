<?php
function e($s)
{
    return htmlspecialchars($s, ENT_QUOTES);
}

const BD_HOST = 'junction.proxy.rlwy.net:34905';
const BD_USER = 'root';
const BD_PWD = 'tbEPsqHJObnDQYIgZjRjSNbPcXMNoOqj';
const BD_SCHEME = 'railway';

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
