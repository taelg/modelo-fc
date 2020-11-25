<?php

//require_once 'model/medicoModel.php';
//require_once 'model/medico.php';
require_once 'model/horarioModel.php';
require_once 'model/horario.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class horarioController {

    function __construct() {
        $this->objsm = new horarioModel();
    }

    // page redirection
    public function pageRedirect($url) {
        header('Location:' . $url);
    }

    // check validation
    public function checkValidation($horariotb) {
        $noerror = true;

        // Validate data/hora
        if (empty($horariotb->data_horario)) {
            $horariotb->data_horario_msg = "Field is empty.";
            $noerror = false;
        } elseif (DateTime::createFromFormat('Y-m-d H:i:s', $horariotb->data_horario) === false) {
            $horariotb->data_horario_msg = "Invalid entry.";
            $noerror = false;
        } else {
            $horariotb->data_horario_msg = "";
        }

        return $noerror;
    }

    public function insert() {
        try {
            $horariotb = new medico();
            if (isset($_POST['addbtn'])) {
                // read form value
                $horariotb->id_medico = trim($_POST['id_medico']);
                $horariotb->data_horario = trim($_POST['data_horario']);
                //call validation
                $chk = $this->checkValidation($horariotb);
                if ($chk) {
                    //call insert record            
                    $pid = $this->objsm->insertRecord($horariotb);
                    if ($pid > 0) {
                        $this->list();
                    } else {
                        echo "Somthing is wrong..., try again.";
                    }
                } else {
                    $_SESSION['horariotbl0'] = serialize($horariotb); //add session obj           
                    $this->pageRedirect("view/insert.php");
                }
            }
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

    // update record
    public function update() {
        try {

            if (isset($_POST['updatebtn'])) {
                $horariotb = unserialize($_SESSION['horariotbl0']);
                $horariotb->id = trim($_POST['id']);
                $horariotb->id_medico = trim($_POST['id_medico']);
                $horariotb->data_horario = trim($_POST['data_horario']);
                // check validation
                $chk = $this->checkValidation($horariotb);
                if ($chk) {
                    $res = $this->objsm->updateRecord($horariotb);
                    if ($res) {
                        $this->list();
                    } else {
                        echo "Somthing is wrong..., try again.";
                    }
                } else {
                    $_SESSION['horariotbl0'] = serialize($horariotb);
                    $this->pageRedirect("view/update.php");
                }
            } elseif (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
                $id = $_GET['id'];
                $result = $this->objsm->selectRecord($id);
                $row = mysqli_fetch_array($result);
                $horariotb = new horario();
                $horariotb->id = $row["id"];
                $horariotb->id_medico = $row["id_medico"];
                $horariotb->data_horario = $row["data_horario"];
                $_SESSION['horariotbl0'] = serialize($horariotb);
                $this->pageRedirect('view/editarHorarios.php');
            } else {
                echo "Invalid operation.";
            }
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

    // delete record
    public function delete() {
        try {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $res = $this->objsm->deleteRecord($id);
                if ($res) {
                    $this->pageRedirect('index.php');
                } else {
                    echo "Somthing is wrong..., try again.";
                }
            } else {
                echo "Invalid operation.";
            }
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

    public function list() {
        $result = $this->objsm->selectRecord(0);
        include "view/list.php";
    }

    public function schedule() {

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $result = $this->objsm->switchAvaliability($id);
            $this->pageRedirect("index.php");
        } else {
            echo "Algo deu errado ao marcar/desmarcar o horário.";
        }
    }

}

?>