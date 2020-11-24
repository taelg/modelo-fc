<?php

class medico {

    //campos do banco
    public $id;
    public $email;
    public $nome;
    public $senha;
    public $data_criacao;
    public $data_alteracao;
    //msgs  
    public $id_msg;
    public $email_msg;
    public $nome_msg;
    public $senha_msg;

    public function __construct() {
        $id = 0;
        $email = $nome = $senha = "";
        $data_criacao = $data_alteracao = null;
    }

}
