<?php

class UsuarioDAO
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function buscarTodosOsUsuariosCadastrados() {
        $query = "SELECT * FROM usuarios";
        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            echo "Erro ao buscar usuários: " . $e->getMessage();
            return null;
        }
    }
    

    public function cadastrarUsuarioDatabase(Usuario $usuario) {
        header('Content-Type: application/json');
        $query = "INSERT INTO usuarios (nome, email, senha, classe, foto) VALUES (:nome, :email, :senha, :classe, :foto)";
    
        try {

            $nome = $usuario->getNome();
            $email = $usuario->getEmail();
            $senha = $usuario->getSenha();
            $classe = $usuario->getStatus();
            $foto = $usuario->getFoto();

            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':classe', $classe);
            $stmt->bindParam(':foto', $foto);
    
            $stmt->execute();

            return ["success" => true, "message" => "Usuário cadastrado com sucesso!"];

        } catch (PDOException $e) {
            echo json_encode(["error" => "Erro ao cadastrar o usuário: " . $e->getMessage()]);
        }
    }
    
}