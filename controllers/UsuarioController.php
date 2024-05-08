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
                    $nomeOriginalFoto = $foto['name'];
                    $extensao = pathinfo($nomeOriginalFoto, PATHINFO_EXTENSION);
                    $nomeFoto = md5(time() . rand()) . "." . $extensao; // Gera um nome único usando MD5
                    $tmpFoto = $foto['tmp_name'];
                    $destinoFoto = "public/assets/img/usuarios/";
                    $caminhoCompletoFoto = $destinoFoto . $nomeFoto;

                    if (!move_uploaded_file($tmpFoto, $caminhoCompletoFoto)) {
                        echo json_encode(["error" => "Erro ao mover a foto para o diretório."]);
                        return;
                    }
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

    public function excluirUsuario()
    {
        $conexao = Conexao::getInstance()->getConexao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lendo o corpo da requisição JSON
            $jsonInput = file_get_contents('php://input');
            $data = json_decode($jsonInput, true); // Convertendo JSON em array

            $usuarioId = $data['usuarioId'] ?? null;
            $fotoUsuario = $data['fotoUsuario'] ?? null;

            $usuarioDAO = new UsuarioDAO($conexao);

            if ($usuarioId && $fotoUsuario) {
                $resultado = $usuarioDAO->excluirUsuarioDatabase($usuarioId, $fotoUsuario);
                echo json_encode($resultado);
            } else {
                echo json_encode(['success' => false, 'error' => 'Dados insuficientes fornecidos.']);
            }
            exit;
        } else {
            echo json_encode(["error" => "Método de requisição não permitido."]);
        }
    }
}
