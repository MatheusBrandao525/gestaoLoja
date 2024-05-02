<?php

class Utilidades
{

    public function validarCampoVazio($campo, $nomeCampo)
    {
        if ($campo === '') {
            throw new Exception("O campo {$nomeCampo} deve ser preenchido!");
        }
    }
}
