<?php

class PedidosController
{
    public function telaGeralPedidos()
    {
        include ROOT_PATH . '/views/dashboardGeralPedidos.php';
    }

    public function telaPedidosRealizados()
    {
        include ROOT_PATH . '/views/pedidosRealizados.php';
    }

    public function telaAtualizarPedidos()
    {
        include ROOT_PATH . '/views/atualizarPedidos.php';
    }

    public function telaPedidosEntregues()
    {
        include ROOT_PATH . '/views/pedidosEntregues.php';
    }
}