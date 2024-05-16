<?php
$clientes = new ClienteController();
$clientesData = $clientes->exibeTodosOsClientesCadastrados();
require_once 'components/menuLateral.php';
?>
<div class="main">
    <div class="busca-clientes">
        <input type="text" id="buscaClientes" placeholder="Digite o nome ou código do cliente..." onkeyup="pesquisaClientes()">
    </div>
    <div class="centralizar">
        <div class="clientes-container">
            <?php foreach ($clientesData as $cliente) { ?>
            <div class="cliente-item">
                <div class="cliente-info">
                    <span class="cliente-nome">Nome: <?php echo htmlspecialchars($cliente['nome']); ?></span>
                    <span class="cliente-email">E-mail: <?php echo htmlspecialchars($cliente['email']); ?></span>
                    <span class="cliente-email">Telefone: <?php echo htmlspecialchars($cliente['telefone']); ?></span>
                    <span class="cliente-email">CPF: <?php echo htmlspecialchars($cliente['cpf']); ?></span>
                    <div class="cliente-opcoes">
                        <form action="dadosCliente" method="post">
                            <input type="hidden" name="clienteId" value="<?php echo $cliente['cliente_id']; ?>">
                            <button type="submit" class="btn-editar-cliente"
                                data-cliente-id="<?php echo $cliente['cliente_id']; ?>">Ver Mais</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>