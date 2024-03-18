<?php
require_once __DIR__ . '/../lib/funciones.php';

class Answer
{
    public $idAnswer;
    public $text;
    public $idQuestion;

    public function insert()
    {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO preguntasmatch.answers(text, idQuestion) VALUES (?, ?)");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param(
            "si",
            $this->text,
            $this->idQuestion
        );
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $this->idAnswer = $bd->insert_id;
        $st->close();
        $bd->close();
    }

    public static function list($idQuestion)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.answers WHERE idQuestion = ?");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param("i", $idQuestion);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $listAnswers = [];

        while ($answer = $res->fetch_object('Answer')) {
            $listAnswers[] = $answer;
        }

        $res->free();
        $st->close();
        $bd->close();

        return $listAnswers;
    }

    public static function getById($id)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.answers WHERE idAnswer = ?");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param("i", $id);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        if ($res->num_rows === 0) {
            return null; // No se encontró ninguna respuesta con ese ID
        }
        $answer = $res->fetch_object('Answer');
        $res->free();
        $st->close();
        $bd->close();

        return $answer;
    }

    public static function deleteByIdTest($idTest)
    {
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM preguntasmatch.answers WHERE idQuestion IN (SELECT idQuestion FROM questions WHERE idTest = ?)");
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
