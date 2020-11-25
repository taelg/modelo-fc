<?php

require_once 'model/medico.php';
require_once 'model/config-banco-dados.php';

class medicoModel {

    public function abrir_conexao_db() {
        $this->condb = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->condb->connect_error) {
            die("Erron in connection: " . $this->condb->connect_error);
        }
    }

    public function close_db() {
        $this->condb->close();
    }

    public function insertRecord($obj) {
        try {
            $this->abrir_conexao_db();
            $query = $this->condb->prepare("INSERT INTO medico (email, nome, senha) VALUES (?, ?, ?)");
            $obj->senha = md5($obj->senha);
            $query->bind_param("sss", $obj->email, $obj->nome, $obj->senha);
            $query->execute();
            $res = $query->get_result();
            $last_id = $this->condb->insert_id;
            $query->close();
            $this->close_db();
            return $last_id;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

    public function updateRecord($obj) {
        try {
            $this->abrir_conexao_db();
            $query = $this->condb->prepare("UPDATE medico SET email=?, nome=?, senha=? WHERE id=?");
            $obj->senha = md5($obj->senha);
            $query->bind_param("sssi", $obj->email, $obj->nome, $obj->senha, $obj->id);
            $query->execute();
            $res = $query->get_result();
            $query->close();
            $this->close_db();
            return true;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

    public function deleteRecord($id) {
        try {
            $this->abrir_conexao_db();
            $query = $this->condb->prepare("DELETE FROM medico WHERE id=?");
            $query->bind_param("i", $id);
            $query->execute();
            $res = $query->get_result();
            $query->close();
            $this->close_db();
            return true;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function selectRecord($id) {
        try {
            $this->abrir_conexao_db();
            if ($id > 0) {
                $query = $this->condb->prepare("SELECT * FROM medico WHERE id=?");
                $query->bind_param("i", $id);
            } else {
                $query = $this->condb->prepare("SELECT * FROM medico");
            }
            $query->execute();
            $res = $query->get_result();
            $query->close();
            $this->close_db();
            return $res;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

    public function selectSchedule($id) {

        $queryTxt = "SELECT horario.id AS horid, medico.id AS medid, medico.nome AS medico, horario.data_horario AS data, horario.horario_agendado AS agendado FROM medico INNER JOIN horario ON medico.id = horario.id_medico ORDER BY medico.id";
        if ($id !== 0) {
            $queryTxt = "SELECT horario.id AS id, horario.data_horario AS data, horario.horario_agendado AS agendado FROM medico INNER JOIN horario ON medico.id = horario.id_medico WHERE medico.id = " . $id;
        }
        try {
            $this->abrir_conexao_db();
            $query = $this->condb->prepare($queryTxt);
            $query->execute();
            $res = $query->get_result();
            $query->close();
            $this->close_db();
            return $res;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

}
