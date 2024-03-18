<?php
require_once __DIR__ . '/../lib/funciones.php';

class Question
{
    public $idQuestion;
    public $text;
    public $idTest;
    public $idCategory;

    public function insert()
    {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO preguntasmatch.questions(text, idTest, idCategory)
                         VALUES (?, ?, ?)");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param(
            "sii",
            $this->text,
            $this->idTest,
            $this->idCategory
        );
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $this->idQuestion = $bd->insert_id;
        $st->close();
        $bd->close();
    }

    public static function list($idTest)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.questions WHERE idTest = ?");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param("i", $idTest);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $listQuestions = [];

        while ($question = $res->fetch_object('Question')) {
            $listQuestions[] = $question;
        }

        $res->free();
        $st->close();
        $bd->close();

        return $listQuestions;
    }

    public static function getById($idQuestion)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.questions WHERE idQuestion = ?");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param('i', $idQuestion);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $question = $res->fetch_object('Question');

        $res->free();
        $st->close();
        $bd->close();

        return $question;
    }

    public static function listCategories($idTest)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT c.name AS name, COUNT(q.idQuestion) AS num_questions
                            FROM categories c
                            INNER JOIN questions q ON c.idCategory = q.idCategory
                            WHERE q.idTest = ?
                            GROUP BY c.idCategory;");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param("i", $idTest);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $listQuestions = [];

        while ($question = $res->fetch_assoc()) {
            $listQuestions[] = $question;
        }

        $res->free();
        $st->close();
        $bd->close();

        return $listQuestions;
    }

    public static function deleteByIdTest($idTest)
    {
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM preguntasmatch.questions WHERE idTest = ?");
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

    public function update() {
        if (!isset($this->idQuestion)) {
            die("Error: idUser no está definido");
        }
        $bd = abrirBD();
        $st = $bd->prepare("UPDATE preguntasmatch.questions SET idCategory=? WHERE idQuestion=?");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param("ii", $this->idCategory, $this->idQuestion);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }
}
