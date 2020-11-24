<?php

/*
* É recomendado que todo o carregamente seja feito apartir desse arquivo.
*/


    session_unset();  
    require_once  'controller/medicoController.php';          
    $controller = new medicoController();     
    $controller->mvcHandler();  