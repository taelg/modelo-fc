<?php

require_once 'model/medicoModel.php';
require_once 'model/horarioModel.php';
require_once 'model/medico.php';
require_once 'model/horario.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class medicoController {

    function __construct() {
        $this->objsm = new medicoModel();
    }

    // page redirection
    public function pageRedirect($url) {
        header('Location:' . $url);
    }

    // check validation
    public function checkValidation($medicotb) {
        $noerror = true;

        // Validate email
        if (empty($medicotb->email)) {
            $medicotb->email_msg = "O email não pode ser vazio.";
            $noerror = false;
        } elseif (!filter_var($medicotb->email, FILTER_VALIDATE_EMAIL)) {
            $medicotb->category_msg = "O email não é valido.";
            $noerror = false;
        } else {
            $medicotb->category_msg = "";
        }

        // Validate name
        if (empty($medicotb->nome)) {
            $medicotb->nome_msg = "O nome não pode ser vazio.";
            $noerror = false;
        } elseif (preg_match("/([%\$#\*@!¨&(\)]+)/", $medicotb->nome)) {
            $medicotb->nome_msg = "O nome não pode conter símbolos.";
            $noerror = false;
        } elseif (preg_match("/([0-9]+)/", $medicotb->nome)) {
            $medicotb->nome_msg = "O nome não pode conter números.";
            $noerror = false;
        } elseif (strlen($medicotb->nome) < 5) {
            $medicotb->nome_msg = "O nome deve conter ao menos 6 dígitos.";
            $noerror = false;
        } elseif (strlen($medicotb->nome) > 40) {
            $medicotb->nome_msg = "O nome deve conter no máximo 40 dígitos.";
            $noerror = false;
        } else {
            $medicotb->nome_msg = "";
        }

        //Validate senha
        if (strlen($medicotb->senha) < 5) {
            $medicotb->senha_msg = "A senha deve conter ao menos 6 dígitos.";
            $noerror = false;
        } else {
            $medicotb->senha_msg = "";
        }

        return $noerror;
    }

    public function insert() {
        try {
            $medicotb = new medico();
            if (isset($_POST['addbtn'])) {
                // read form value
                $medicotb->email = trim($_POST['email']);
                $medicotb->nome = trim($_POST['nome']);
                $medicotb->senha = trim($_POST['senha']);
                //call validation
                $chk = $this->checkValidation($medicotb);
                if ($chk) {
                    //call insert record            
                    $pid = $this->objsm->insertRecord($medicotb);
                    if ($pid > 0) {
                        $this->listDoctors();
                    } else {
                        echo "Somthing is wrong..., try again.";
                    }
                } else {
                    $_SESSION['medicotbl0'] = serialize($medicotb); //add session obj           
                    $this->pageRedirect("view/cadastroMedico.php");
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
                $medicotb = unserialize($_SESSION['medicotbl0']);

                $senha_antiga = trim($_POST['senha_antiga']);
                $medico = mysqli_fetch_array($this->objsm->selectRecord(trim($_POST['id'])));

                $medicotb->id = trim($_POST['id']);
                $medicotb->nome = trim($_POST['nome']);
                $medicotb->email = $medico['email'];

                if ($medico['senha'] !== md5($senha_antiga)) {
                    $medicotb->senha_msg = "Sua senha antiga está incorreta.";
                    $_SESSION['medicotbl0'] = serialize($medicotb);
                    $this->pageRedirect("view/editarMedico.php");
                } else {
                    $medicotb->senha = trim($_POST['senha_nova']);

                    // check validation  
                    $chk = $this->checkValidation($medicotb);
                    if ($chk) {
                        $res = $this->objsm->updateRecord($medicotb);
                        if ($res) {
                            $this->listDoctors();
                        } else {
                            echo "Somthing is wrong..., try again.";
                        }
                    } else {
                        $_SESSION['medicotbl0'] = serialize($medicotb);
                        $this->pageRedirect("view/editarMedico.php");
                    }
                }
            } elseif (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
                $id = $_GET['id'];
                $result = $this->objsm->selectRecord($id);
                $row = mysqli_fetch_array($result);
                $medicotb = new medico();
                $medicotb->id = $row["id"];
                $medicotb->nome = $row["nome"];
                $_SESSION['medicotbl0'] = serialize($medicotb);
                $this->pageRedirect('view/editarMedico.php');
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

    public function listDoctors() {
        $medicos = $this->objsm->selectRecord(0);
        $dates = $this->objsm->selectSchedule(0);
        include "view/listagem.php";
    }

    public function editSchedule2() {
        try {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $medicos = $this->objsm->selectRecord($id);
                $dates = $this->objsm->selectSchedule($id);
                include "view/editarHorarios.php";
            } else {
                echo "Invalid operation.";
            }
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

    public function editSchedule() {
        try {
            if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
                $id = $_GET['id'];
                $result = $this->objsm->selectRecord($id);
                $row = mysqli_fetch_array($result);
                $medicotb = new medico();
                $horariotb = new horario();
                $medicotb->id = $row["id"];
                $medicotb->nome = $row["nome"];

                $dateArr = array();
                $dates = $this->objsm->selectSchedule($medicotb->id);
                while ($row = mysqli_fetch_array($dates)) {
                    $dateArr[] = $row;
                }

                $_SESSION['medicotb10'] = serialize($medicotb);
                $_SESSION['horariotb10'] = serialize($horariotb);
                $_SESSION['datestb10'] = serialize($dateArr);
                $this->pageRedirect('view/editarHorarios.php');
            } else {
                echo "Invalid operation.";
            }
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

}

?>