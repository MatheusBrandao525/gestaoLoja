<?php

require_once "core/Conexao.php";
require_once 'utils/Utilidades.php';
require_once 'models/entities/Produto.php';
require_once 'models/DAO/ProdutoDao.php';

class ProdutoController 
{

    public function cadastrarProduto()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
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
            $imagem1 = filter_input(INPUT_POST, 'imagem1', FILTER_SANITIZE_STRING);
            $imagem2 = filter_input(INPUT_POST, 'imagem2', FILTER_SANITIZE_STRING);
            $imagem3 = filter_input(INPUT_POST, 'imagem3', FILTER_SANITIZE_STRING);
            $categoriaId = filter_input(INPUT_POST, 'categoriaid', FILTER_SANITIZE_STRING);

            $conexao = Conexao::getInstance()->getConexao();

            // var_dump($nome)

            $validarSeCamposEstaoVazios = new utilidades();
            $validarSeCamposEstaoVazios->validarCampoVazio($nome);
            $validarSeCamposEstaoVazios->validarCampoVazio($codigo);
            $validarSeCamposEstaoVazios->validarCampoVazio($exibePreco);
            $validarSeCamposEstaoVazios->validarCampoVazio($precoCusto);
            $validarSeCamposEstaoVazios->validarCampoVazio($precoUnitario);
            $validarSeCamposEstaoVazios->validarCampoVazio($modelos);
            $validarSeCamposEstaoVazios->validarCampoVazio($cor);
            $validarSeCamposEstaoVazios->validarCampoVazio($destaque);
            $validarSeCamposEstaoVazios->validarCampoVazio($tamanhos);
            $validarSeCamposEstaoVazios->validarCampoVazio($descricao);
            $validarSeCamposEstaoVazios->validarCampoVazio($imagem1);
            $validarSeCamposEstaoVazios->validarCampoVazio($imagem2);
            $validarSeCamposEstaoVazios->validarCampoVazio($imagem3);
            $validarSeCamposEstaoVazios->validarCampoVazio($categoriaId);
        
            // Criação do objeto Produto
            $produto = new Produto($nome, $codigo, $exibePreco, $precoCusto, $precoUnitario, $modelos, $cor, $destaque, $tamanhos, $descricao, $imagem1, $imagem2, $imagem3, $categoriaId);

            $produtoDao = new ProdutoDao($conexao);
            $produtoDao->cadastro($produto);
        }
    }
}