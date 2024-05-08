<?php
require_once "core/Conexao.php";
require_once 'utils/Utilidades.php';
require_once 'models/entities/Categoria.php';
require_once 'models/DAO/CategoriaDAO.php';

class CategoriaController
{
    public function telaCadastrarCategoria()
    {
        include ROOT_PATH . '/views/cadastroCategoria.php';
    }

    public function telaEditarCategoria()
    {
        include ROOT_PATH . '/views/editarCategoria.php';
    }

    public function telaCategorias()
    {
        include ROOT_PATH . '/views/categorias.php';
    }

    public function cadastrarCategoria()
    {
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomeCategoria = filter_input(INPUT_POST, 'nomeCategoria', FILTER_SANITIZE_STRING);
    
            $validarSeCamposEstaoVazios = new utilidades();
            $validarSeCamposEstaoVazios->validarCampoVazio($nomeCategoria, "Nome");

    
            $nomeImagemCategoria = null;
            if (isset($_FILES['imagemCategoria']) && $_FILES['imagemCategoria']['error'] === UPLOAD_ERR_OK) {
                $arquivoTmp = $_FILES['imagemCategoria']['tmp_name'];
                $extensao = pathinfo($_FILES['imagemCategoria']['name'], PATHINFO_EXTENSION);
                $nomeUnico = md5(uniqid(time())) . '.' . $extensao;
                $diretorioDestino = "public/assets/img/categorias/";
                $caminhoCompleto = $diretorioDestino . $nomeUnico;
                if (move_uploaded_file($arquivoTmp, $caminhoCompleto)) {
                    $nomeImagemCategoria = $nomeUnico;
                } else {
                    echo json_encode(['error' => "Erro ao salvar a imagem no servidor."]);
                    return;
                }
            } else {
                echo json_encode(['error' => "Erro ao carregar a imagem. Error Code: " . $_FILES['imagemCategoria']['error']]);
                return;
            }
    
            $conexao = Conexao::getInstance()->getConexao();
            $categoria = new Categoria($nomeCategoria, $nomeImagemCategoria);
            $categoriaDAO = new CategoriaDAO($conexao);
            $cadastrarCategoria = $categoriaDAO->cadastro($categoria);
        } else {
            http_response_code(405);
            echo json_encode(['error' => "Invalid request method. Only POST is allowed."]);
        }
    }
    

    public function exibirTodasAsCategorias()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $categoriaDAO = new CategoriaDAO($conexao);
        return $categoriaDAO->buscarTodasCategoriasDatabase();
    }

    public function mostraDadosCategoria()
    {
        $conexao = Conexao::getInstance()->getConexao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoriaId = filter_input(INPUT_POST, "categoria_id", FILTER_SANITIZE_NUMBER_INT);
            $categoriaDAO = new CategoriaDAO($conexao);

            $dadosCategoria = $categoriaDAO->buscarDadosCategoriaPorId($categoriaId);

            return $dadosCategoria;
        } else {
            echo json_encode(['success' => false, 'error' => 'Houve um erro ao tentar buscar os dados da categoria.']);
        }
    }

    public function mostarNomeCategoria($categoriaId)
    {
        $conexao = Conexao::getInstance()->getConexao();
        $categoriaDAO = new CategoriaDAO($conexao);
        $resultado = $categoriaDAO->buscarNomeCategoriaPorId($categoriaId);
        return $resultado['nome_categoria'] ?? "Categoria não encontrada";
    }

    public function excluirCategoria()
    {
        $conexao = Conexao::getInstance()->getConexao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $categoriaId = $data['categoriaId'] ?? null;
            $imagemCategoria = $data['imagemCategoria'] ?? null;
            $categoriaDAO = new CategoriaDAO($conexao);
            if ($categoriaId && $imagemCategoria) {
                $resultado = $categoriaDAO->excluirCategoriaDatabase($categoriaId, $imagemCategoria);
                echo json_encode($resultado);
            } else {
                echo json_encode(['success' => false, 'error' => 'Dados insuficientes fornecidos.']);
            }
            exit;
        }
    }

    public function editarCategoria() {
        $conexao = Conexao::getInstance()->getConexao();
        $categoriaDAO = new CategoriaDAO($conexao);
        header('Content-Type: application/json');
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $categoriaId = filter_input(INPUT_POST, 'categoriaId', FILTER_SANITIZE_NUMBER_INT);
                $categoriaAtual = $categoriaDAO->buscarDadosCategoriaPorId($categoriaId);
    
                $nomeCategoria = filter_input(INPUT_POST, 'nomeCategoria', FILTER_SANITIZE_STRING);
                $dadosParaAtualizar = [];
    
                if ($nomeCategoria && $nomeCategoria !== $categoriaAtual['nome_categoria']) {
                    $dadosParaAtualizar['nome_categoria'] = $nomeCategoria;
                }
    
                if (isset($_FILES['imagemCategoria']) && $_FILES['imagemCategoria']['error'] === UPLOAD_ERR_OK) {
                    $arquivoAntigo = $categoriaAtual['imagem_categoria'] ?? null;
                    if ($arquivoAntigo) {
                        @unlink("public/assets/img/categorias/" . $arquivoAntigo);
                    }
                    $arquivoTmp = $_FILES['imagemCategoria']['tmp_name'];
                    $nomeOriginal = pathinfo($_FILES['imagemCategoria']['name'], PATHINFO_FILENAME);
                    $extensao = pathinfo($_FILES['imagemCategoria']['name'], PATHINFO_EXTENSION);
                    $nomeUnico = md5(uniqid(time())) . '.' . $extensao;
                    $diretorioDestino = "public/assets/img/categorias/";
                    $caminhoCompleto = $diretorioDestino . $nomeUnico;
                    move_uploaded_file($arquivoTmp, $caminhoCompleto);
                    $dadosParaAtualizar['imagem_categoria'] = $nomeUnico;
                }
    
                if (!empty($dadosParaAtualizar)) {
                    $categoria = new Categoria(
                        $dadosParaAtualizar['nome_categoria'] ?? $categoriaAtual['nome_categoria'],
                        $dadosParaAtualizar['imagem_categoria'] ?? $categoriaAtual['imagem_categoria']
                    );
                    $resposta = $categoriaDAO->atualizarCategoriaDatabase($categoriaId, $categoria);
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
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => "Invalid request method."]);
        }
    }
    
}
