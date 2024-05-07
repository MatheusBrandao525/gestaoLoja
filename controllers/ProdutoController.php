<?php

require_once "core/Conexao.php";
require_once 'utils/Utilidades.php';
require_once 'models/entities/Produto.php';
require_once 'models/DAO/ProdutoDao.php';
require_once 'controllers/CategoriaController.php';

class ProdutoController
{

    public function telaImportarJsonProdutos()
    {
        include ROOT_PATH . '/views/importarJsonProdutos.php';
    }

    public function mostrarTelaCadastroProduto()
    {
        include ROOT_PATH . '/views/cadastroProduto.php';
    }

    public function telaTodosOsProdutos()
    {
        include ROOT_PATH . '/views/produtos.php';
    }

    public function telaEditarProduto()
    {
        include ROOT_PATH . '/views/editarProduto.php';
    }

    public function telaProdutosPorCategoria()
    {
        include ROOT_PATH . '/views/produtosPorCategoria.php';
    }

    public function exibirTodosOsProdutos()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $produtosDAO = new ProdutoDao($conexao);
        return $produtosDAO->buscarTodosOsProdutosDatabase();
    }

    public function cadastrarProduto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_STRING);
            $exibePreco = filter_input(INPUT_POST, 'exibirPreco', FILTER_SANITIZE_STRING);
            $precoCusto = filter_input(INPUT_POST, 'precoCusto', FILTER_SANITIZE_NUMBER_FLOAT);
            $precoUnitario = filter_input(INPUT_POST, 'precoUnitario', FILTER_SANITIZE_NUMBER_FLOAT);
            $modelos = filter_input(INPUT_POST, 'modelos', FILTER_SANITIZE_STRING);
            $cor = filter_input(INPUT_POST, 'cor', FILTER_SANITIZE_STRING);
            $destaque = filter_input(INPUT_POST, 'destaque', FILTER_SANITIZE_STRING);
            $tamanhos = filter_input(INPUT_POST, 'tamanhos', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
            $categoriaId = filter_input(INPUT_POST, 'categoriaid', FILTER_SANITIZE_STRING);

            $validarSeCamposEstaoVazios = new Utilidades();

            $validarSeCamposEstaoVazios->validarCampoVazio($nome, "Nome");
            $validarSeCamposEstaoVazios->validarCampoVazio($codigo, "Código");
            $validarSeCamposEstaoVazios->validarCampoVazio($exibePreco, "Exibir Preço");
            $validarSeCamposEstaoVazios->validarCampoVazio($precoCusto, "Preço de Custo");
            $validarSeCamposEstaoVazios->validarCampoVazio($precoUnitario, "Preço Unitário");
            $validarSeCamposEstaoVazios->validarCampoVazio($modelos, "Modelos");
            $validarSeCamposEstaoVazios->validarCampoVazio($cor, "Cor");
            $validarSeCamposEstaoVazios->validarCampoVazio($destaque, "Destaque");
            $validarSeCamposEstaoVazios->validarCampoVazio($tamanhos, "Tamanhos");
            $validarSeCamposEstaoVazios->validarCampoVazio($descricao, "Descrição");
            $validarSeCamposEstaoVazios->validarCampoVazio($categoriaId, "Categoria ID");

            if (isset($_FILES['imagem1']) && $_FILES['imagem1']['error'] === UPLOAD_ERR_OK) {
                $imagem1 = $_FILES['imagem1']['tmp_name'];
                $nomeImagem1 = $_FILES['imagem1']['name'];
                $diretorioDestino = "public/assets/img/produtos/";
                $caminhoCompleto = $diretorioDestino . $nomeImagem1;
                move_uploaded_file($imagem1, $caminhoCompleto);
            } else {
                throw new Exception("Erro ao carregar a imagem: " . $_FILES['imagem1']['error']);
            }

            if (isset($_FILES['imagem2']) && $_FILES['imagem2']['error'] === UPLOAD_ERR_OK) {
                $imagem2 = $_FILES['imagem2']['tmp_name'];
                $nomeImagem2 = $_FILES['imagem2']['name'];
                $diretorioDestino = "public/assets/img/produtos/";
                $caminhoCompleto = $diretorioDestino . $nomeImagem2;
                move_uploaded_file($imagem2, $caminhoCompleto);
            } else {
                throw new Exception("Erro ao carregar a imagem: " . $_FILES['imagem2']['error']);
            }

            if (isset($_FILES['imagem3']) && $_FILES['imagem3']['error'] === UPLOAD_ERR_OK) {
                $imagem3 = $_FILES['imagem3']['tmp_name'];
                $nomeImagem3 = $_FILES['imagem3']['name'];
                $diretorioDestino = "public/assets/img/produtos/";
                $caminhoCompleto = $diretorioDestino . $nomeImagem3;
                move_uploaded_file($imagem3, $caminhoCompleto);
            } else {
                throw new Exception("Erro ao carregar a imagem: " . $_FILES['imagem2']['error']);
            }

            $conexao = Conexao::getInstance()->getConexao();
            $produtoDao = new ProdutoDao($conexao);

            $produto = new Produto($nome, $codigo, $exibePreco, $precoCusto, $precoUnitario, $modelos, $cor, $destaque, $tamanhos, $descricao, $nomeImagem1, $nomeImagem2, $nomeImagem3, $categoriaId);
            $produtoDao->cadastro($produto);
        } else {
            throw new Exception("Invalid request method.");
        }
    }

    public function mostraDadosProduto()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $produtoDAO = new ProdutoDAO($conexao);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produtoId = filter_input(INPUT_POST, 'produtoId', FILTER_SANITIZE_NUMBER_INT);
            $dadosProduto = $produtoDAO->buscarDadosProdutoPorId($produtoId);
            $categoriaController = new CategoriaController();
            if (!isset($dadosProduto['error'])) {
                $dadosProduto['status_destaque'] = $dadosProduto['destaque'] ? 'Sim' : 'Não';
                $dadosProduto['status_exibe_preco'] = $dadosProduto['exibe_preco'] ? 'Sim' : 'Não';
                $dadosProduto['nome_categoria'] = $categoriaController->mostarNomeCategoria($dadosProduto['categoria_id']);
            }

            return $dadosProduto;
        } else {
            echo json_encode(['success' => false, 'error' => 'Houve um erro ao tentar buscar os dados do produto.']);
        }
    }


    public function excluirProduto()
    {
        $conexao = Conexao::getInstance()->getConexao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                $produtoId = $data['produtoId'] ?? null;
                $produtoDAO = new ProdutoDAO($conexao);
                if (isset($produtoId)) {
                    $resultado = $produtoDAO->excluirProdutoDatabase($produtoId);
                    echo json_encode($resultado);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Dados insuficientes fornecidos.']);
                }
                exit;
            }
        }
    }

    public function alterarDadosProduto()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $produtoDAO = new ProdutoDAO($conexao);
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $produtoId = filter_input(INPUT_POST, 'produtoId', FILTER_SANITIZE_NUMBER_INT);
                $produtoAtual = $produtoDAO->buscarDadosProdutoPorId($produtoId);
    
                $nome = filter_input(INPUT_POST, 'altera-nome', FILTER_SANITIZE_STRING);
                $codigo = filter_input(INPUT_POST, 'altera-codigo', FILTER_SANITIZE_STRING);
                $exibePreco = filter_input(INPUT_POST, 'altera-exibirPreco', FILTER_SANITIZE_STRING);
                $precoCusto = filter_input(INPUT_POST, 'altera-precoCusto', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $precoUnitario = filter_input(INPUT_POST, 'altera-precoUnitario', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $modelos = filter_input(INPUT_POST, 'altera-modelos', FILTER_SANITIZE_STRING);
                $cor = filter_input(INPUT_POST, 'altera-cor', FILTER_SANITIZE_STRING);
                $destaque = filter_input(INPUT_POST, 'altera-destaque', FILTER_SANITIZE_STRING);
                $tamanhos = filter_input(INPUT_POST, 'altera-tamanhos', FILTER_SANITIZE_STRING);
                $descricao = filter_input(INPUT_POST, 'altera-descricao', FILTER_SANITIZE_STRING);
                $categoriaId = filter_input(INPUT_POST, 'altera-categoriaid', FILTER_SANITIZE_NUMBER_INT);
    
                $dadosParaAtualizar = [];
                foreach (['nome', 'codigo', 'exibe_preco', 'preco_custo', 'preco_unitario', 'modelos', 'cor', 'destaque', 'tamanhos', 'descricao', 'categoria_id'] as $campo) {
                    if (isset($$campo) && $$campo != $produtoAtual[$campo]) {
                        $dadosParaAtualizar[$campo] = $$campo;
                    }
                }
    
                $imagens = ['altera-imagem1', 'altera-imagem2', 'altera-imagem3'];
                foreach ($imagens as $key => $imagem) {
                    if (isset($_FILES[$imagem]) && $_FILES[$imagem]['error'] === UPLOAD_ERR_OK) {
                        $nomeCampoImagem = 'imagem' . ($key + 1);
                        $arquivoAntigo = $produtoAtual[$nomeCampoImagem];
                        if ($arquivoAntigo) {
                            @unlink("public/assets/img/produtos/" . $arquivoAntigo);
                        }
                        $arquivoTmp = $_FILES[$imagem]['tmp_name'];
                        $nomeImagem = $_FILES[$imagem]['name'];
                        $diretorioDestino = "public/assets/img/produtos/";
                        $caminhoCompleto = $diretorioDestino . $nomeImagem;
                        move_uploaded_file($arquivoTmp, $caminhoCompleto);
                        $dadosParaAtualizar[$nomeCampoImagem] = $nomeImagem;
                    }
                }
    
                if (!empty($dadosParaAtualizar)) {
                    $produto = new Produto(
                        $dadosParaAtualizar['nome'] ?? $produtoAtual['nome'],
                        $dadosParaAtualizar['codigo'] ?? $produtoAtual['codigo'],
                        $dadosParaAtualizar['exibe_preco'] ?? $produtoAtual['exibe_preco'],
                        $dadosParaAtualizar['preco_custo'] ?? $produtoAtual['preco_custo'],
                        $dadosParaAtualizar['preco_unitario'] ?? $produtoAtual['preco_unitario'],
                        $dadosParaAtualizar['modelos'] ?? $produtoAtual['modelos'],
                        $dadosParaAtualizar['cor'] ?? $produtoAtual['cor'],
                        $dadosParaAtualizar['destaque'] ?? $produtoAtual['destaque'],
                        $dadosParaAtualizar['tamanhos'] ?? $produtoAtual['tamanhos'],
                        $dadosParaAtualizar['descricao'] ?? $produtoAtual['descricao'],
                        $dadosParaAtualizar['imagem1'] ?? $produtoAtual['imagem1'],
                        $dadosParaAtualizar['imagem2'] ?? $produtoAtual['imagem2'],
                        $dadosParaAtualizar['imagem3'] ?? $produtoAtual['imagem3'],
                        $dadosParaAtualizar['categoria_id'] ?? $produtoAtual['categoria_id']
                    );
                    $resposta = $produtoDAO->atualizarProdutoDatabase($produtoId, $produto);
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

    
        public function excluirImagemProduto()
        {
            $conexao = Conexao::getInstance()->getConexao();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $produtoId = filter_input(INPUT_POST, 'produtoId', FILTER_SANITIZE_NUMBER_INT);
                $imagem = filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_STRING);
            
                $conexao = Conexao::getInstance()->getConexao();
                $produtoDAO = new ProdutoDAO($conexao);
                
                $resultado = $produtoDAO->excluirImagemProdutoDatabase($produtoId, $imagem);
            
                header('Content-Type: application/json');
                if ($resultado) {
                    echo json_encode(['success' => true, 'message' => 'Imagem excluída com sucesso.']);
                } else {
                    echo json_encode(['error' => 'Falha ao excluir a imagem.']);
                }
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método de requisição não permitido.']);
            }

        }
        
        public function buscarProdutosPorCategoria()
        {
            $conexao = Conexao::getInstance()->getConexao();
            $produtos = null; // Inicializar com null
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $categoriaId = filter_input(INPUT_POST, 'categoriaId', FILTER_SANITIZE_NUMBER_INT);
                $produtoDAO = new ProdutoDAO($conexao);
                $produtos = $produtoDAO->buscarProdutosPorCategoriaDatabase($categoriaId);
            } else {
                $produtos = ['error' => 'Método de requisição não permitido.'];
            }
            return $produtos; // Retornar produtos ou erro
        }
        
}