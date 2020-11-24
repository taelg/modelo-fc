<?php

class horario {

    //database fields
    public $id;
    public $id_medico;
    public $data_horario;
    public $horario_agendado;
    public $data_criacao;
    public $data_alteracao;
    //msgs  
    public $id_msg;
    public $id_medico_msg;
    public $data_horario_msg;
    public $horario_agendado_msg;

    public function __construct() {
        $id = $id_medico = $horario_agendado = 0;
        $data_horario = $data_criacao = $data_alteracao = null;
    }

}
