<?php

class UsuarioController 
{
    public function telaCadastrarUsuarios()
    {
        include ROOT_PATH . '/views/cadastroUsuario.php';
    }

    public function exibirTodosOsUsuarios()
    {
        include ROOT_PATH . '/views/todosUsuarios.php';
    }
}