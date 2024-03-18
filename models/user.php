<?php
require_once __DIR__ . '/../lib/funciones.php';

class User {
    public $idUser;
    public $name;
    public $email;
    public $pwd;
    public $icon;

    public function insert(){
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO preguntasmatch.users(name, email, pwd, icon)
                         values(?,?,?,?)");
        if ($st === FALSE) {
            die("Error BD: " + $bd->error);
        }
        $st->bind_param("ssss", 
                            $this->name,
                            $this->email,
                            $this->pwd,
                            $this->icon);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " + $bd->error);
        }
        $this->idUser = $bd->insert_id;
        $st->close();
        $bd->close();
    }

    public static function getByName($name){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.users where name=?");
        if ($st === FALSE) {
            die("Error BD: " + $bd->error);
        }
        $st->bind_param("s", $name);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " + $bd->error);
        }
        $res = $st->get_result();
        $user = $res->fetch_object('User');   
        $res->free();
        $st->close();
        $bd->close();
        return $user;
    }

    public static function getByEmail($email){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.users where email=?");
        if ($st === FALSE) {
            die("Error BD: " + $bd->error);
        }
        $st->bind_param("s", $email);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " + $bd->error);
        }
        $res = $st->get_result();
        $user = $res->fetch_object('User');   
        $res->free();
        $st->close();
        $bd->close();
        return $user;
    }

    public static function getById($iduser){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM preguntasmatch.users where iduser=?");
        if ($st === FALSE) {
            die("Error BD: " + $bd->error);
        }
        $st->bind_param("i", $iduser);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " + $bd->error);
        }
        $res = $st->get_result();
        $user = $res->fetch_object('User');   
        $res->free();
        $st->close();
        $bd->close();
        return $user;
    }

    public function update() {
        if (!isset($this->idUser)) {
            die("Error: idUser no está definido");
        }
        $bd = abrirBD();
        $st = $bd->prepare("UPDATE preguntasmatch.users SET name=?, email=?, pwd=?, icon=? WHERE idUser=?");
        if ($st === FALSE) {
            die("Error BD: " . $bd->error);
        }
        $st->bind_param("ssssi", $this->name, $this->email, $this->pwd, $this->icon, $this->idUser);
        $ok = $st->execute();
        if (!$ok) {
            die("Error: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }
}