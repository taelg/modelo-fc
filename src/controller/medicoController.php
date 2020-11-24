<?php

require_once 'model/medicoModel.php';
require_once 'model/medico.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class medicoController {

    function __construct() {
        $this->objsm = new medicoModel();
    }

    // mvc handler request
    public function mvcHandler() {
        $act = isset($_GET['act']) ? $_GET['act'] : NULL;
        switch ($act) {
            case 'add' :
                $this->insert();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete' :
                $this->delete();
                break;
            default:
                $this->list();
        }
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
            $medicotb->email_msg = "Field is empty.";
            $noerror = false;
        } elseif (!filter_var($medicotb->email, FILTER_VALIDATE_EMAIL)) {
            $medicotb->category_msg = "Invalid entry.";
            $noerror = false;
        } else {
            $medicotb->category_msg = "";
        }
        
        // Validate name
        if (empty($medicotb->nome)) {
            $medicotb->nome_msg = "Nome vazio.";
            $noerror = false;
        } elseif (preg_match("/([%\$#\*@!¨&(\)]+)/", $medicotb->nome)) {
            $medicotb->nome_msg = "Nome não pode conter símbolos.";                                                        
            $noerror = false;
        } elseif (preg_match("/([0-9]+)/", $medicotb->nome)) {
            $medicotb->nome_msg = "Nome não pode conter números.";                                                        
            $noerror = false;
        } elseif (strlen($medicotb->nome) < 3) {
            $medicotb->nome_msg = "Nome deve conter ao menos 2 dígitos.";                                                        
            $noerror = false;
        } elseif (strlen($medicotb->nome) > 40) {
            $medicotb->nome_msg = "Nome deve conter no máximo 40 dígitos.";                                                        
            $noerror = false;
        } else {
            $medicotb->nome_msg = "";
        }
        
         //Validate password
//        if (empty($medicotb->senha)) {
//            $medicotb->senha_msg = "Field is empty.";
//            $noerror = false;
//        } elseif (!filter_var($medicotb->senha, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "^[a-zA-Z0-9_\]\[?\/<~#`!@$%^&*()+=}|:\";\',>{ -]{4,20}$")))) {
//            $medicotb->senha_msg = "Invalid entry.";
//            $noerror = false;
//        } else {
//            $medicotb->senha_msg = "";
//        }
        
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
                        $this->list();
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
                //CHECK IF OLD PASSWORD MATCHES.
                
                $medicotb->id = trim($_POST['id']);
                $medicotb->nome = trim($_POST['nome']);
                $medicotb->email = "getOldEmail@gmail.com";
                $medicotb->senha = trim($_POST['senha_nova']);
                
                // check validation  
                $chk = $this->checkValidation($medicotb);
                if ($chk) {
                    $res = $this->objsm->updateRecord($medicotb);
                    if ($res) {
                        $this->list();
                    } else {
                        echo "Somthing is wrong..., try again.";
                    }
                } else {
                    $_SESSION['medicotbl0'] = serialize($medicotb);
                    $this->pageRedirect("view/editarMedico.php");
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

    public function list() {
        $medicos = $this->objsm->selectRecord(0);
        $result = $this->objsm->selectHorarios();
        include "view/listagem.php";
    }

}

?>