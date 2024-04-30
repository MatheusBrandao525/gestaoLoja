<?php

class Utilidades {

    public function validarCampoVazio($campo)
    {
        if($campo === '')
        {
            return 'Você deve preencher todos os campos!';
        }
    }
}