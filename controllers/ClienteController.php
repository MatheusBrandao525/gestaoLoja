<?php

class ClienteController
{

    public function telaCadastroCliente()
    {
        include ROOT_PATH . '/views/cadastroCliente.php';
    }

    public function telaTodosOsClientes()
    {
        include ROOT_PATH . '/views/todosClientes.php';
    }
}