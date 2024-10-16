<?php

class SubCategoriaDAO
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function buscarSubCategorias($categoriaPaiId)
    {
        $query = "SELECT * FROM subcategorias WHERE categoria_id = :categoriaPaiId";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":categoriaPaiId", $categoriaPaiId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Registra o erro em um log, se necessário
            error_log('Erro ao buscar subcategorias: ' . $e->getMessage());
            throw new Exception('Erro ao buscar subcategorias: ' . $e->getMessage());
        }
    }


    public function cadastrarSubcategoria($nomeSubcategoria, $categoriaPai, $nomeImagemSubcategoria)
    {
        // Inserindo a subcategoria no banco de dados
        $query = "INSERT INTO subcategorias (nome_subcategoria, categoria_id, imagem_subcategoria) 
                  VALUES (:nomeSubcategoria, :categoriaPai, :imagemSubcategoria)";
        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':nomeSubcategoria', $nomeSubcategoria);
            $stmt->bindParam(':categoriaPai', $categoriaPai);
            $stmt->bindParam(':imagemSubcategoria', $nomeImagemSubcategoria);
            $stmt->execute();

            return json_encode(['message' => 'Subcategoria cadastrada com sucesso!']);
        } catch (PDOException $e) {
            error_log('Erro ao cadastrar subcategoria: ' . $e->getMessage());
            return json_encode(['error' => 'Erro ao cadastrar a subcategoria: ' . $e->getMessage()]);
        }
    }
}
