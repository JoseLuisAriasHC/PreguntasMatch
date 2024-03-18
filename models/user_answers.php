<?php
require_once __DIR__ . '/../lib/funciones.php';

class User_answers
{
    public $idUserAnswer;
    public $idUser;
    public $idTest;
    public $idQuestion;
    public $idSelectedAnswer;
    public $message;
    public $date;

    public function insert()
    {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO preguntasmatch.user_answers (idUser,idTest, idQuestion, idSelectedAnswer, message, date)
                         VALUES (?, ?, ?, ?, ?, ?)");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param(
            "iiiiss",
            $this->idUser,
            $this->idTest,
            $this->idQuestion,
            $this->idSelectedAnswer,
            $this->message,
            $this->date,
        );
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $this->idUserAnswer = $bd->insert_id;
        $st->close();
        $bd->close();
    }

    public static function list($idSelectedAnswer)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.user_answers WHERE idSelectedAnswer = ? ORDER BY date DESC;");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param('i', $idSelectedAnswer);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $answersList = [];

        while ($answer = $res->fetch_object('User_answers')) {
            $answersList[] = $answer;
        }

        $res->free();
        $st->close();
        $bd->close();

        return $answersList;
    }

    public static function getLastMessage($idSelectedAnswer, $idUser)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.user_answers 
                            WHERE idSelectedAnswer = ? AND idUser != ? AND message IS NOT NULL AND message != ''
                            ORDER BY date DESC
                            LIMIT 1;");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param('ii', $idSelectedAnswer, $idUser);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $userAnswer = $res->fetch_object('User_answers');

        $res->free();
        $st->close();
        $bd->close();

        return $userAnswer;
    }

    public function update()
    {
        if (!isset($this->idUserAnswer)) {
            die("Error: idUserAnswer no está definido");
        }

        $bd = abrirBD();
        $st = $bd->prepare("UPDATE preguntasmatch.user_answers 
                        SET idUser = ?, idTest = ?, idQuestion = ?, idSelectedAnswer = ?, message = ?, date = ?
                        WHERE idUserAnswer = ?");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param(
            "iiiissi",
            $this->idUser,
            $this->idTest,
            $this->idQuestion,
            $this->idSelectedAnswer,
            $this->message,
            $this->date,
            $this->idUserAnswer
        );
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

    public static function getUserAnswer($idUser, $idQuestion)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.user_answers WHERE idUser = ? AND idQuestion = ? LIMIT 1");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param('ii', $idUser, $idQuestion);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $userAnswer = $res->fetch_object('User_answers');

        $res->free();
        $st->close();
        $bd->close();

        return $userAnswer;
    }

    public static function deleteByIdTest($idTest)
    {
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM preguntasmatch.user_answers WHERE idTest = ?");
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
