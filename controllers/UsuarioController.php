<?php
require_once "core/Conexao.php";
require_once 'models/entities/Usuario.php';
require_once 'models/DAO/UsuarioDAO.php';
require_once 'utils/Utilidades.php';
class UsuarioController
{
    public function telaCadastrarUsuarios()
    {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['ID'])) {
            header("Location: /login");
            exit;
        }

        $usuarioId = $_SESSION['ID'];
        $usuario = $this->verificarClasseUsuarioPorId($usuarioId);

        // Verifica a classe do usuário
        if ($usuario['classe'] === 'admin' || $usuario['classe'] === 'sup') {
        include ROOT_PATH . '/views/cadastroUsuario.php';
        } else {
            header("Location: /acessoNegado");
            exit;
        }
    }

    public function telaTodosOsUsuarios()
    {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['ID'])) {
            header("Location: /login");
            exit;
        }

        $usuarioId = $_SESSION['ID'];
        $usuario = $this->verificarClasseUsuarioPorId($usuarioId);

        // Verifica a classe do usuário
        if ($usuario['classe'] === 'admin' || $usuario['classe'] === 'sup') {
            include ROOT_PATH . '/views/todosUsuarios.php';
        } else {
            header("Location: /acessoNegado");
            exit;
        }
    }
    
    public function telaAcessoNegado()
    {
        include ROOT_PATH . '/views/acessoNegado.php';
    }

    public function telaEditarUsuario()
    {
        include ROOT_PATH . '/views/editarUsuario.php';
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

    public function dadosUsuarioPorId()
    {
        $conexao = Conexao::getInstance()->getConexao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioId = filter_input(INPUT_POST, 'usuario_id', FILTER_SANITIZE_NUMBER_INT);

            $usuarioDAO = new UsuarioDAO($conexao);

            $dadosUsuario = $usuarioDAO->buscarDadosUsuarioPorId($usuarioId);

            return $dadosUsuario;
        } else {
            echo json_encode(["error" => "Método de requisição não permitido."]);
        }
    }

    public function alterarDadosUsuario()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $usuarioDAO = new UsuarioDAO($conexao);
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $usuarioId = filter_input(INPUT_POST, 'usuarioId', FILTER_SANITIZE_NUMBER_INT);
                $usuarioAtual = $usuarioDAO->buscarDadosUsuarioPorId($usuarioId);

                if ($usuarioAtual === false) {
                    throw new Exception("Falha ao obter dados do usuário.");
                }

                $nome = filter_input(INPUT_POST, 'altera-nome', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'altera-email', FILTER_SANITIZE_EMAIL);
                $senha = filter_input(INPUT_POST, 'altera-senha', FILTER_SANITIZE_STRING);
                $status = filter_input(INPUT_POST, 'altera-status', FILTER_SANITIZE_STRING);
                $dadosParaAtualizar = [
                    'nome' => $nome,
                    'email' => $email,
                    'senha' => $senha,
                    'status' => $status,
                    'foto' => $usuarioAtual['foto']
                ];

                if (isset($_FILES['altera-foto']) && $_FILES['altera-foto']['error'] === UPLOAD_ERR_OK) {
                    $arquivoAntigo = $usuarioAtual['foto'] ?? null;
                    if ($arquivoAntigo) {
                        @unlink("public/assets/img/usuarios/" . $arquivoAntigo);
                    }
                    $arquivoTmp = $_FILES['altera-foto']['tmp_name'];
                    $nomeOriginal = pathinfo($_FILES['altera-foto']['name'], PATHINFO_FILENAME);
                    $extensao = pathinfo($_FILES['altera-foto']['name'], PATHINFO_EXTENSION);
                    $nomeUnico = md5(uniqid(time())) . '.' . $extensao;
                    $diretorioDestino = "public/assets/img/usuarios/";
                    $caminhoCompleto = $diretorioDestino . $nomeUnico;
                    move_uploaded_file($arquivoTmp, $caminhoCompleto);
                    $dadosParaAtualizar['foto'] = $nomeUnico;
                }

                if (!empty($dadosParaAtualizar)) {
                    $resposta = $usuarioDAO->atualizarDadosUsuarioDatabase($usuarioId, $dadosParaAtualizar);
                    if (isset($resposta['success'])) {
                        echo json_encode(['Status' => 'success', 'message' => $resposta['message']]);
                    } elseif (isset($resposta['error'])) {
                        echo json_encode(['error' => $resposta['error']]);
                    } else {
                        echo json_encode(['error' => "Erro desconhecido."]);
                    }
                } else {
                    echo json_encode(['error' => "Nenhuma alteração foi feita."]);
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => "Invalid request method."]);
        }
    }

    public function exibirQuantidadeDeUsuariosCadastrados()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $usuarioDAO = new UsuarioDAO($conexao);

        return $quantidadeUsuarios = $usuarioDAO->contarUsuariosCadastrados();
    }
    
    public function verificarClasseUsuarioPorId($usuarioId)
    {
        $conexao = Conexao::getInstance()->getConexao();
        if (!empty($usuarioId) && $usuarioId != null) {
            $id = $usuarioId;

            $usuarioDAO = new UsuarioDAO($conexao);

            $dadosUsuario = $usuarioDAO->buscarDadosUsuarioPorId($id);

            return $dadosUsuario;
        } else {
            echo json_encode(["error" => "Id do usuário é inválido."]);
        }
    }
}
