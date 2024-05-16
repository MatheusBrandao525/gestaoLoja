<?php

class ProdutoDao
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function buscarTodosOsProdutosDatabase()
    {
        $query = "SELECT * FROM produtos";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => "Erro ao buscar produtos: " . $e->getMessage()];
        }
    }

    public function buscarDadosProdutoPorId($produtoId)
    {
        $query = "SELECT * FROM produtos WHERE produto_id = :produtoId";
        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam("produtoId", $produtoId);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => "Erro ao buscar dados do produto: " . $e->getMessage()];
        }
    }

    public function cadastro(Produto $produto)
    {
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

    public function excluirProdutoDatabase($produtoId)
    {
        $this->conexao->beginTransaction();
        try {
            $stmt = $this->conexao->prepare("DELETE FROM produtos WHERE produto_id = :produtoId");
            $stmt->bindParam(':produtoId', $produtoId);
            $stmt->execute();

            if ($stmt->rowCount()) {
                $this->conexao->commit();
                return ['success' => true, 'message' => "Produto excluido com sucesso!"];
            } else {
                $this->conexao->rollBack();
                return ['success' => false, 'error' => "Erro ao tentar excluir produto do banco de dados."];
            }
        } catch (Exception $e) {
            $this->conexao->rollBack();
            return ['success' => false, 'error' => "Erro ao tentar excluir produto: " . $e->getMessage()];
        }
    }


    public function atualizarProdutoDatabase($produtoId, Produto $produto)
    {
        try {
            $sql = "UPDATE produtos SET 
                    nome = :nome, 
                    codigo = :codigo, 
                    exibe_preco = :exibePreco, 
                    preco_custo = :precoCusto, 
                    preco_unitario = :precoUnitario, 
                    modelos = :modelos, 
                    cor = :cor, 
                    destaque = :destaque, 
                    tamanhos = :tamanhos, 
                    descricao = :descricao, 
                    imagem1 = :imagem1, 
                    imagem2 = :imagem2, 
                    imagem3 = :imagem3, 
                    categoria_id = :categoriaId 
                    WHERE produto_id = :produtoId";

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
            $imagem1 = $produto->getImagem();
            $imagem2 = $produto->getImagem2();
            $imagem3 = $produto->getImagem3();
            $categoriaId = $produto->getCategoriaId();

            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':codigo', $codigo);
            $stmt->bindValue(':exibePreco', $exibePreco);
            $stmt->bindValue(':precoCusto', $precoCusto);
            $stmt->bindValue(':precoUnitario', $precoUnitario);
            $stmt->bindValue(':modelos', $modelos);
            $stmt->bindValue(':cor', $cor);
            $stmt->bindValue(':destaque', $destaque);
            $stmt->bindValue(':tamanhos', $tamanhos);
            $stmt->bindValue(':descricao', $descricao);
            $stmt->bindValue(':imagem1', $imagem1);
            $stmt->bindValue(':imagem2', $imagem2);
            $stmt->bindValue(':imagem3', $imagem3);
            $stmt->bindValue(':categoriaId', $categoriaId);
            $stmt->bindValue(':produtoId', $produtoId);
            $stmt->execute();

            return ['success' => true, 'message' => 'Produto alterado com sucesso!'];
        } catch (PDOException $e) {
            return ['error' => 'Erro ao atualizar o produto: ' . $e->getMessage()];
        }
    }

    public function excluirImagemProdutoDatabase($produtoId, $imagem)
    {
        try {
            $this->conexao->beginTransaction();

            $sqlSelect = "SELECT {$imagem} FROM produtos WHERE produto_id = :produtoId";
            $stmtSelect = $this->conexao->prepare($sqlSelect);
            $stmtSelect->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
            $stmtSelect->execute();
            $nomeArquivoImagem = $stmtSelect->fetchColumn();

            $sqlUpdate = "UPDATE produtos SET {$imagem} = NULL WHERE produto_id = :produtoId";
            $stmtUpdate = $this->conexao->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
            $stmtUpdate->execute();

            if ($nomeArquivoImagem) {
                $caminhoImagem = "public/assets/img/produtos/{$nomeArquivoImagem}";
                if (file_exists($caminhoImagem)) {
                    unlink($caminhoImagem);
                }
            }

            $this->conexao->commit();

            return true;
        } catch (Exception $e) {
            $this->conexao->rollBack();
            error_log("Erro ao excluir imagem do produto: " . $e->getMessage());
            return false;
        }
    }

    public function buscarProdutosPorCategoriaDatabase($categoriaId)
    {
        $query = "SELECT * FROM produtos WHERE categoria_id = :categoriaId";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":categoriaId", $categoriaId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => "Erro ao buscar produtos por categoria: " . $e->getMessage()];
        }
    }

    public function buscarUltimosProdutosCadastrados()
    {
        $query = "SELECT * FROM produtos ORDER BY produto_id DESC LIMIT 8";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => "Erro ao buscar os últimos produtos cadastrados: " . $e->getMessage()];
        }
    }

    public function contarProdutosCadastrados()
    {
        $query = "SELECT COUNT(*) AS total FROM produtos";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado['total'];
        } catch (Exception $e) {
            return ['error' => "Erro ao contar produtos cadastrados: " . $e->getMessage()];
        }
    }
}
