<?php

class CategoriaDAO
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function cadastro(Categoria $categoria)
    {
        $query = "INSERT INTO categorias (nome_categoria, imagem_categria) VALUES (:nomeCategoria, :imagemCategoria)";

        $nome = $categoria->getNome();
        $imagem = $categoria->getImagem();

        try
        {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':nomeCategoria', $nome);
            $stmt->bindParam(':imagemCategoria', $imagem);
            $stmt->execute();
            
            echo json_encode(['message' => 'Categoria cadastrada com sucesso!']);
        }catch (Exception $e)
        {
            echo json_encode(['message' => "Erro ao cadastrar categoria. '$e'"]);
        }
    }
}