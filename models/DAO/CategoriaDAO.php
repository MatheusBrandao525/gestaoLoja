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

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':nomeCategoria', $nome);
            $stmt->bindParam(':imagemCategoria', $imagem);
            $stmt->execute();

            echo json_encode(['message' => 'Categoria cadastrada com sucesso!']);
        } catch (Exception $e) {
            echo json_encode(['message' => "Erro ao cadastrar categoria. '$e'"]);
        }
    }

    public function buscarTodasCategoriasDatabase()
    {
        $query = "SELECT * FROM categorias";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => "Erro ao buscar categorias: " . $e->getMessage()];
        }
    }

    public function excluirCategoriaDatabase($categoriaId, $imagemCategoria)
    {
        $this->conexao->beginTransaction();
        try {
            $stmt = $this->conexao->prepare("DELETE FROM categorias WHERE categoria_id = :categoriaId");
            $stmt->bindParam(':categoriaId', $categoriaId);
            $stmt->execute();

            if ($stmt->rowCount()) {
                $diretorio_imagem = 'public/assets/img/categorias/';

                $excluirImagemCat = $imagemCategoria;

                if ($excluirImagemCat != "") {
                    unlink($diretorio_imagem . $excluirImagemCat);
                }

                $this->conexao->commit();
                return ['success' => true, 'message' => "Categoria e imagem excluídas com sucesso!"];
            } else {
                $this->conexao->rollBack();
                return ['success' => false, 'error' => "Erro ao tentar excluir a categoria do banco de dados."];
            }
        } catch (Exception $e) {
            $this->conexao->rollBack();
            return ['success' => false, 'error' => "Erro ao tentar excluir categoria: " . $e->getMessage()];
        }
    }
}
