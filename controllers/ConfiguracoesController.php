<?php
require_once "core/Conexao.php";
require_once 'utils/Utilidades.php';
class ConfiguracoesController
{
    public function telaConfiguracoes()
    {
        include ROOT_PATH . '/views/configuracoes.php';
    }

    public function salvarLinkRedesSociais()
    {
        $conexao = Conexao::getInstance()->getConexao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nomeRede']) && isset($_POST['linkRede'])) {
            $nomeRedeSocial = filter_input(INPUT_POST, 'nomeRede', FILTER_SANITIZE_STRING);
            $linkRedeSocial = filter_input(INPUT_POST, 'linkRede', FILTER_SANITIZE_STRING);
    
            $query = "SELECT * FROM redes_sociais WHERE nome = :nomeRedeSocial";
            $stmt = $conexao->prepare($query);
            $stmt->bindParam(":nomeRedeSocial", $nomeRedeSocial);
            $stmt->execute();
    
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($resultado) {
                $query = "UPDATE redes_sociais SET link = :linkRedeSocial WHERE nome = :nomeRedeSocial";
                $stmt = $conexao->prepare($query);
                $stmt->bindParam(":linkRedeSocial", $linkRedeSocial);
                $stmt->bindParam(":nomeRedeSocial", $nomeRedeSocial);
                $stmt->execute();
    
                echo "Link da rede social atualizado com sucesso!";
            } else {
                $query = "INSERT INTO redes_sociais (nome, link) VALUES (:nomeRedeSocial, :linkRedeSocial)";
                $stmt = $conexao->prepare($query);
                $stmt->bindParam(":nomeRedeSocial", $nomeRedeSocial);
                $stmt->bindParam(":linkRedeSocial", $linkRedeSocial);
                $stmt->execute();
    
                echo "Nova rede social adicionada com sucesso!";
            }
        }
    }
    
}
