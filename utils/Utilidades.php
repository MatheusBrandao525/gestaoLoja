<?php

class Utilidades
{

    public function validarCampoVazio($campo, $nomeCampo)
    {
        if ($campo === '') {
            throw new Exception("O campo {$nomeCampo} deve ser preenchido!");
        }
    }

    function formatarDataParaMySQL($dateStr)
    {
        if ($dateStr === null) {
            return null;
        }
        $date = new DateTime($dateStr);
        return $date->format('Y-m-d H:i:s');
    }

    public function verificaSeSessaoExiste()
    {
        if (!isset($_SESSION['ID']) && $_SERVER['REQUEST_URI'] !== '/gestaoLoja/login') {
            header("Location: login");
            exit;
        }
    }
}
