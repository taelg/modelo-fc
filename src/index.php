<?php
/*
* É recomendado que todo o carregamente seja feito apartir desse arquivo.
*/


    session_unset();  
    require_once  'controller/medicoController.php';
    require_once  'controller/horarioController.php';
    
    $medicoController = new medicoController();
    $horarioController = new horarioController();
    
        $act = isset($_GET['act']) ? $_GET['act'] : NULL;
        switch ($act) {
            
            case 'registrarMedico' :
                $medicoController->insert();
                break;
            case 'editarMedico':
                $medicoController->update();
                break;
            
            case 'registrarHorario' :
                $horarioController->schedule();
                break;
            case 'editarHorarios' :
                $horarioController->update();
                break;
            case 'marcarHorario' :
                $horarioController->scheduleDate();
                break;
            
            default:
                $medicoController->listDoctors();
        }
    
    
    