<?php

class Utilidades
{

    public function validarCampoVazio($campo, $nomeCampo)
    {
        if ($campo === '') {
            throw new Exception("O campo {$nomeCampo} deve ser preenchido!");
        }
    }

    function formatarDataParaMySQL($dateStr) {
        if ($dateStr === null) {
            return null;
        }
        $date = new DateTime($dateStr);
        return $date->format('Y-m-d H:i:s');
    }
    
}
