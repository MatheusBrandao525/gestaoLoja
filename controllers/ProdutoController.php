<?php

require_once "core/Conexao.php";
require_once 'utils/Utilidades.php';
require_once 'models/entities/Produto.php';
require_once 'models/DAO/ProdutoDao.php';

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
}
