<?php
require_once "core/Conexao.php";
require_once "models/DAO/UsuarioDAO.php";
class LoginController
{
    public function telaLogin()
    {
        include ROOT_PATH . '/views/login.php';
    }

    public function autenticarUsuario()
    {
        $conexao = Conexao::getInstance()->getConexao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING);
    
            $usuarioDAO = new UsuarioDAO($conexao);
    
            $usuario = $usuarioDAO->loginDoUsuario($email, $senha);
    
            if($usuario){
                header('Location: home');
                exit();
            }else{
                header('Location: erroLogin');
                exit();
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método de requisição não permitido.']);
        }
    }
    
}