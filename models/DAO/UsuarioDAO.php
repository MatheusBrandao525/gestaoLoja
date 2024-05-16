<?php

class UsuarioDAO
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function loginDoUsuario($email, $senha)
    {
        $query = "SELECT * FROM usuarios WHERE email = :usuarioEmail AND senha = :usuarioSenha";
        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":usuarioEmail", $email);
            $stmt->bindParam(":usuarioSenha", $senha);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario) {
                return $usuario;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
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

    public function atualizarDadosUsuarioDatabase($usuarioId, $dados)
    {
        try {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, classe = :status, foto = :foto WHERE id = :usuarioId";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':nome', $dados['nome']);
            $stmt->bindValue(':email', $dados['email']);
            $stmt->bindValue(':senha', $dados['senha']);
            $stmt->bindValue(':status', $dados['status']);
            $stmt->bindValue(':foto', $dados['foto']);
            $stmt->bindValue(':usuarioId', $usuarioId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Dados do usuário atualizados com sucesso!'];
            } else {
                return ['error' => 'Nenhuma alteração realizada.'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Erro ao atualizar os dados do usuário: ' . $e->getMessage()];
        }
    }

    public function contarUsuariosCadastrados()
    {
        $query = "SELECT COUNT(*) AS total FROM usuarios";

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado['total'];
        } catch (Exception $e) {
            return ['error' => "Erro ao contar usuários cadastrados: " . $e->getMessage()];
        }
    }
}
