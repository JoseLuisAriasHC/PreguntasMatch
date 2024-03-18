<?php
require_once __DIR__ . '/../lib/funciones.php';

class Category
{
    public $idCategory;
    public $name;
    public $description;

    public static function list()
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT
                            c.idCategory,
                            c.name,
                            c.description,
                            COUNT(DISTINCT t.idTest) AS num_Tests
                            FROM
                                categories c
                            LEFT JOIN
                                questions q ON c.idCategory = q.idCategory
                            LEFT JOIN
                                test t ON q.idTest = t.idTest
                            GROUP BY
                                c.idCategory, c.name, c.description");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $res = $st->get_result();
        $categories = [];

        while ($row = $res->fetch_assoc()) {
            $categories[] = $row;
        }

        $res->free();
        $st->close();
        $bd->close();

        return $categories;
    }
}
