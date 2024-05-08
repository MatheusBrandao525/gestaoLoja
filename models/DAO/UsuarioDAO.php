<?php

class UsuarioDAO
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function buscarTodosOsUsuariosCadastrados()
    {
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


    public function cadastrarUsuarioDatabase(Usuario $usuario)
    {
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

    public function excluirUsuarioDatabase($usuarioId, $fotoUsuario)
    {
        $this->conexao->beginTransaction();
        try {
            $stmt = $this->conexao->prepare("DELETE FROM usuarios WHERE id = :usuarioId");
            $stmt->bindParam(':usuarioId', $usuarioId);
            $stmt->execute();

            if ($stmt->rowCount()) {
                $diretorio_imagem = 'public/assets/img/usuarios/';
                $excluirImagemUsuario = $fotoUsuario;

                if ($excluirImagemUsuario != "") {
                    unlink($diretorio_imagem . $excluirImagemUsuario);
                }

                $this->conexao->commit();
                return ['success' => true, 'message' => "Usuário e imagem excluídos com sucesso!"];
            } else {
                $this->conexao->rollBack();
                return ['success' => false, 'error' => "Erro ao tentar excluir o usuário do banco de dados."];
            }
        } catch (Exception $e) {
            $this->conexao->rollBack();
            return ['success' => false, 'error' => "Erro ao tentar excluir usuário: " . $e->getMessage()];
        }
    }

    public function buscarDadosUsuarioPorId($usuarioId)
    {
        $query = "SELECT * FROM usuarios WHERE id = :usuarioId";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":usuarioId", $usuarioId);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => "Erro ao buscar dados do usuário: " . $e->getMessage()];
        }
    }
}
