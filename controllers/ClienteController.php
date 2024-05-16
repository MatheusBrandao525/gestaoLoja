<?php
require_once "core/Conexao.php";
require_once 'utils/Utilidades.php';
require_once 'models/DAO/ClienteDAO.php';
class ClienteController
{

    public function telaCadastroCliente()
    {
        include ROOT_PATH . '/views/cadastroCliente.php';
    }

    public function telaTodosOsClientes()
    {
        include ROOT_PATH . '/views/todosClientes.php';
    }

    public function exibirQuantidadeDeClientesCadastrados()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $clienteDAO = new ClienteDAO($conexao);

        return $quantidadeDeClientesCadastrados = $clienteDAO->contarQuantidadeDeClientesCadastrados();
    }

    public function exibirUltimosClientesCadastrados()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $clienteDAO = new ClienteDAO($conexao);

        // Chama a função para buscar os últimos clientes cadastrados
        return $ultimosClientesCadastrados = $clienteDAO->buscarUltimosClientesCadastrados();
    }

    public function exibeTodosOsClientesCadastrados()
    {
        $conexao = Conexao::getInstance()->getConexao();
        $clienteDAO = new ClienteDAO($conexao);
        return $clienteDAO->buscarTodosOsClientesCadastrados();
    }
    

}