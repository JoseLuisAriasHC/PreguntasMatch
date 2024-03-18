<?php
require_once __DIR__ . '/../lib/funciones.php';
require_once __DIR__ . '/test_of_the_day.php';
require_once __DIR__ . '/user_answers.php';
require_once __DIR__ . '/question.php';
require_once __DIR__ . '/answer.php';

class Test
{
    public $idTest;
    public $title;
    public $description;
    public $image;
    public $idUser;
    public $date;

    public function insert()
    {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO preguntasmatch.test(title, description, image, idUser, date)
                         VALUES (?, ?, ?, ?, ?)");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param(
            "sssis",
            $this->title,
            $this->description,
            $this->image,
            $this->idUser,
            $this->date
        );
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $this->idTest = $bd->insert_id;
        $st->close();
        $bd->close();
    }

    public static function list($idCategory, $title = '', $orderCadena = '')
    {
        $orderBy = '';
        if ($orderCadena !== '') {
            $orderArrary = explode('-', $orderCadena);
            $colum = $orderArrary[0];
            $order = $orderArrary[1];
            $columnasPermitidas = ['date', 'title'];
            if (!in_array($colum, $columnasPermitidas) && $colum !== '') {
                die("Error: Orden inválido");
            }
            $orderBy = 'ORDER BY ' . $colum . ' ' . $order;
        }

        $bd = abrirBD();
        $st = $bd->prepare("SELECT DISTINCT t.*
                        FROM test t
                        INNER JOIN questions q ON t.idTest = q.idTest
                        WHERE q.idCategory IN (
                            SELECT idCategory
                            FROM questions
                            WHERE idCategory = ?
                        ) AND t.title LIKE CONCAT('%', ?, '%') " .
            $orderBy);
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param('is', $idCategory, $title);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $listTest = [];

        while ($test = $res->fetch_object('Test')) {
            $listTest[] = $test;
        }

        $res->free();
        $st->close();
        $bd->close();

        return $listTest;
    }

    public static function listByUserId($idUser)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM test WHERE idUser = ?");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param("i", $idUser);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $tests = [];
        while ($row = $res->fetch_object('Test')) {
            $tests[] = $row;
        }
        $res->free();
        $st->close();
        $bd->close();
        return $tests;
    }

    public static function getById($idTest){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.test where idTest=?");
        if ($st === FALSE) {
            die("Error BD: " + $bd->error);
        }
        $st->bind_param("i", $idTest);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " + $bd->error);
        }
        $res = $st->get_result();
        $user = $res->fetch_object('Test');   
        $res->free();
        $st->close();
        $bd->close();
        return $user;
    }

    public static function deleteById($idTest)
    {
        // borrar test_of_the_day
        test_of_the_day::deleteById($idTest);

        // borrar user_answers
        User_answers::deleteByIdTest($idTest);

        // borrar answers
        Answer::deleteByIdTest($idTest);
        
        // borrar questions
        Question::deleteByIdTest($idTest);

        // borrar test
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM preguntasmatch.test WHERE idTest = ?");
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
        if (!isset($this->idUser)) {
            die("Error: idUser no está definido");
        }
        $bd = abrirBD();
        $st = $bd->prepare("UPDATE preguntasmatch.test SET title=?, description=?, image=?, date=? WHERE idTest=?");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param("ssssi", $this->title, $this->description, $this->image, $this->date, $this->idTest);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

}
