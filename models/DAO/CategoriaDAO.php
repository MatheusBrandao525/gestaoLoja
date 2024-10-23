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

    public function buscarDadosCategoriaPorId($categoriaId)
    {
        $query = "SELECT * FROM categorias WHERE categoria_id = :categoriaId";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":categoriaId", $categoriaId);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => "Erro ao buscar dados da categoria: " . $e->getMessage()];
        }
    }

    public function buscarNomeCategoriaPorId($categoriaId)
    {
        $query = "SELECT nome_categoria FROM categorias WHERE categoria_id = :categoriaId";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":categoriaId", $categoriaId);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => "Erro ao buscar nome da categoria: " . $e->getMessage()];
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

    public function atualizarCategoriaDatabase($categoriaId, Categoria $categoria)
    {
        try {
            // Prepara a SQL para atualizar a categoria
            $sql = "UPDATE categorias SET 
                    nome_categoria = :nomeCategoria, 
                    imagem_categria = :imagemCategoria
                    WHERE categoria_id = :categoriaId";

            // Obtém os valores da entidade Categoria
            $nomeCategoria = $categoria->getNome();
            $imagemCategoria = $categoria->getImagem();

            // Prepara o statement
            $stmt = $this->conexao->prepare($sql);

            // Vincula os parâmetros ao statement
            $stmt->bindValue(':nomeCategoria', $nomeCategoria);
            $stmt->bindValue(':imagemCategoria', $imagemCategoria);
            $stmt->bindValue(':categoriaId', $categoriaId);

            // Executa o statement
            $stmt->execute();

            // Retorna sucesso se a atualização ocorrer corretamente
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Categoria atualizada com sucesso!'];
            } else {
                return ['error' => 'Nenhuma alteração realizada.'];
            }
        } catch (PDOException $e) {
            // Retorna erro se houver uma exceção durante a execução
            return ['error' => 'Erro ao atualizar a categoria: ' . $e->getMessage()];
        }
    }

    public function contarQuantidadeCategoriasCadastradas()
    {
        $query = "SELECT COUNT(*) AS total FROM categorias";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado['total'];
        } catch (Exception $e) {
            return ['error' => "Erro ao contar categorias cadastradas: " . $e->getMessage()];
        }
    }

    public function cadastrarSubcategoria($nomeSubcategoria, $categoriaPai, $nomeImagemSubcategoria)
    {
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

    public function buscarSubCategoriasPorGrupoId($grupoId)
{
    // Exemplo de consulta SQL
    $query = 'SELECT * FROM subcategorias WHERE categoria_id = :grupoId';
    $stmt = $this->conexao->prepare($query);
    $stmt->bindValue(':grupoId', $grupoId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function excluirSubcategoriaDatabase($subcategoriaId)
    {
        try {
            // Prepara a query SQL para excluir a subcategoria
            $sql = "DELETE FROM subcategorias WHERE subcategoria_id = :subcategoria_id";
    
            // Prepara a conexão para execução da query
            $stmt = $this->conexao->prepare($sql);
    
            // Vincula o parâmetro :subcategoria_id ao valor real
            $stmt->bindParam(':subcategoria_id', $subcategoriaId, PDO::PARAM_INT);
    
            // Executa a query
            if ($stmt->execute()) {
                // Se a exclusão for bem-sucedida, retorna true
                return true;
            } else {
                // Caso a exclusão falhe, retorna false
                return false;
            }
    
        } catch (PDOException $e) {
            // Em caso de erro, captura a exceção e retorna false
            error_log("Erro ao excluir subcategoria: " . $e->getMessage());
            return false;
        }
    }
    
}
