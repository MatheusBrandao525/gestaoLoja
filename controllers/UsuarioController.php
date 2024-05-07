<?php
require_once "core/Conexao.php";
require_once 'models/entities/Usuario.php';
require_once 'models/DAO/UsuarioDAO.php';
require_once 'utils/Utilidades.php';
class UsuarioController 
{
    public function telaCadastrarUsuarios()
    {
        include ROOT_PATH . '/views/cadastroUsuario.php';
    }

    public function telaTodosOsUsuarios()
    {
        include ROOT_PATH . '/views/todosUsuarios.php';
    }

    public function cadastrarUsuario()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
            $classe = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
            $foto = $_FILES['foto'];
    
            $validar = new Utilidades();
    
            try {
                $validar->validarCampoVazio($nome, "Nome");
                $validar->validarCampoVazio($email, "Email");
                $validar->validarCampoVazio($senha, "Senha");
                $validar->validarCampoVazio($classe, "Classe");
    
                if (isset($foto) && $foto['error'] === UPLOAD_ERR_OK) {
                    $nomeFoto = $foto['name'];
                    $tmpFoto = $foto['tmp_name'];
                    $destinoFoto = "public/assets/img/usuarios/";
                    $caminhoCompletoFoto = $destinoFoto . $nomeFoto;
                    move_uploaded_file($tmpFoto, $caminhoCompletoFoto);
                } else {
                    echo json_encode(["error" => "Erro ao carregar a foto: " . $foto['error']]);
                    return;
                }
    
                $usuario = new Usuario($nome, $email, $senha, $classe, $nomeFoto);
    
                $conexao = Conexao::getInstance()->getConexao();
                $usuarioDao = new UsuarioDao($conexao);
                $success = $usuarioDao->cadastrarUsuarioDatabase($usuario);
                echo json_encode($success);
            } catch (Exception $e) {
                echo json_encode(["error" => $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "Método de requisição não permitido."]);
        }
    }
    
    public function exibirTodosOsUsuarios()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $usuarioDAO = new UsuarioDAO($conexao);
        return $usuarioDAO->buscarTodosOsUsuariosCadastrados();
    }
    

}