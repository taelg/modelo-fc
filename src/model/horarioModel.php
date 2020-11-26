<?php

require_once 'model/horario.php';
require_once 'model/config-banco-dados.php';

class horarioModel {

    public function open_db() {
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
            $this->open_db();
            $query = $this->condb->prepare("INSERT INTO horario (id_medico, data_horario) VALUES (?, ?)");
            $query->bind_param("is", $obj->id_medico, $obj->data_horario);
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
            $this->open_db();
            $query = $this->condb->prepare("UPDATE horario SET id_medico=?, data_horario=?, horario_agendado=? WHERE id=?");
            $query->bind_param("issi", $obj->id_medico, $obj->data_horario, $obj->horario_agendado, $obj->id);
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
            $this->open_db();
            $query = $this->condb->prepare("DELETE FROM horario WHERE id=?");
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
            $this->open_db();
            if ($id > 0) {
                $query = $this->condb->prepare("SELECT * FROM horario WHERE id=?");
                $query->bind_param("i", $id);
            } else {
                $query = $this->condb->prepare("SELECT * FROM horario");
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

    public function switchAvaliability($id) {

        if ($id > 0) {
            $res = mysqli_fetch_array($this->selectRecord($id));           
            $horario = new horario();
            $horario->id = $res['id'];
            $horario->id_medico = $res['id_medico'];
            $horario->data_horario = $res['data_horario'];
            $horario->horario_agendado = $res['horario_agendado'];

            if ($horario->horario_agendado === 0) {
                $horario->horario_agendado = 1;
            } else {
                $horario->horario_agendado = 0;
            }
            
            $this->updateRecord($horario);
        }
    }

}
