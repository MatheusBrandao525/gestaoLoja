<?php

class ProdutoDao
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function cadastro(Produto $produto)
    {
        $resposta = '';
        $query = "INSERT INTO produtos (nome, codigo, exibe_preco, preco_custo, preco_unitario, modelos, cor, destaque, tamanhos, descricao, imagem1, imagem2, imagem3, categoria_id) VALUES (:nome, :codigo, :exibePreco, :precoCusto, :precoUnitario, :modelos, :cor, :destaque, :tamanhos, :descricao, :imagem1, :imagem2, :imagem3, :categoriaId)";

        $nome = $produto->getNome();
        $codigo = $produto->getCodigo();
        $exibePreco = $produto->getExibePreco();
        $precoCusto = $produto->getPrecoCusto();
        $precoUnitario = $produto->getPrecoUnitario();
        $modelos = $produto->getModelos();
        $cor = $produto->getCor();
        $destaque = $produto->getDestaque();
        $tamanhos = $produto->getTamanhos();
        $descricao = $produto->getDescricao();
        $imagem = $produto->getImagem();
        $imagem2 = $produto->getImagem2();
        $imagem3 = $produto->getImagem3();
        $categoriaId = $produto->getCategoriaId();
        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':exibePreco', $exibePreco);
            $stmt->bindParam(':precoCusto', $precoCusto);
            $stmt->bindParam(':precoUnitario', $precoUnitario);
            $stmt->bindParam(':modelos', $modelos);
            $stmt->bindParam(':cor', $cor);
            $stmt->bindParam(':destaque', $destaque);
            $stmt->bindParam(':tamanhos', $tamanhos);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':imagem1', $imagem);
            $stmt->bindParam(':imagem2', $imagem2);
            $stmt->bindParam(':imagem3', $imagem3);
            $stmt->bindParam(':categoriaId', $categoriaId);

            $stmt->execute();
            echo json_encode(['message' => 'Produto cadastrado com sucesso!']);
        } catch (Exception $e) {
            echo json_encode(['message' => "Erro ao cadastrar o produto. '$e'"]);
        }
    }
}
