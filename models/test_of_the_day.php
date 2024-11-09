<?php
require_once __DIR__ . '/../lib/funciones.php';

class test_of_the_day
{
    public $idTestOfTheDay;
    public $idTest;
    public $date;

    public static function getTest()
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM railway.test_of_the_day ORDER BY idTestOfTheDay DESC LIMIT 1");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $ultimoRegistro = $res->fetch_object('test_of_the_day');
        $res->free();
        $st->close();
        $bd->close();

        return $ultimoRegistro;
    }

    public static function deleteById($idTest)
    {
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM railway.test_of_the_day WHERE idTest = ?");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param("i", $idTest);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }
}
