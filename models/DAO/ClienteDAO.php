<?php

class ClienteDAO
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function contarQuantidadeDeClientesCadastrados()
    {
        $query = "SELECT COUNT(*) AS total FROM clientes";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado['total'];
        } catch (Exception $e) {
            return ['error' => "Erro ao contar clientes cadastrados: " . $e->getMessage()];
        }
    }

    public function buscarUltimosClientesCadastrados()
    {
        $query = "SELECT * FROM clientes ORDER BY cliente_id DESC LIMIT 8";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => "Erro ao buscar os últimos clientes cadastrados: " . $e->getMessage()];
        }
    }

    public function buscarTodosOsClientesCadastrados()
    {
        $query = "SELECT * FROM clientes";
    
        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => "Erro ao buscar clientes: " . $e->getMessage()];
        }
    }
    

}