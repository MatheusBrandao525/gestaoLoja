<?php
require_once 'controllers/ProdutoController.php';
require_once 'controllers/UsuarioController.php';
require_once 'controllers/CategoriaController.php';
require_once 'controllers/ClienteController.php';
require 'components/menuLateral.php';
$usuarioController = new UsuarioController();
$produtoController = new ProdutoController();
$categoriaController = new CategoriaController();
$clienteController = new ClienteController();
$ultimosProdutosCadastrados = $produtoController->exibirUltimosProdutosCadastrados();
$ultimosClientesCadastrados = $clienteController->exibirUltimosClientesCadastrados();
$quantidadeDeprodutosCadastrados = $produtoController->exibirQuantidadeDeProdutosCadastrados();
$quantidadeDeUsuariosCadastrados = $usuarioController->exibirQuantidadeDeUsuariosCadastrados();
$quantidadeDeCategoriasCadastradas = $categoriaController->exibirQuantidadeDeCategoriasCadastradas();
$quantidadeDeClientesCadastrados = $clienteController->exibirQuantidadeDeClientesCadastrados();
?>
<div class="main">


    <!-- ======================= Cards ================== -->
    <div class="cardBox">
        <div class="card">
            <div>
                <div class="numbers"><?php echo $quantidadeDeprodutosCadastrados; ?></div>
                <div class="cardName">Pedidos Realizados</div>
            </div>

            <div class="iconBx">
                <i class="fas fa-box-open"></i>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers"><?php echo $quantidadeDeClientesCadastrados;?></div>
                <div class="cardName">Valor Total de Pedidos</div>
            </div>

            <div class="iconBx">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers"><?php echo $quantidadeDeCategoriasCadastradas; ?></div>
                <div class="cardName">Valor Total de Custo</div>
            </div>

            <div class="iconBx">
                <i class="fas fa-tags"></i>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers"><?php echo $quantidadeDeUsuariosCadastrados; ?></div>
                <div class="cardName">Valor Total de Lucro</div>
            </div>

            <div class="iconBx">
                <i class="fas fa-id-card"></i>
            </div>
        </div>
    </div>

    <!-- ================ Order Details List ================= -->
    <div class="details">
        <div class="recentOrders">
            <div class="cardHeader">
                <h2>Últimos Pedidos Realizados</h2>
                <a href="#" class="btn">Ver Todos</a>
            </div>

            <table class="fixed-header">
                <thead>
                    <tr>
                        <td>Cliente</td>
                        <td>Forma de Pagamento</td>
                        <td>Valor Pedido</td>
                        <td>Detalhes</td>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($ultimosProdutosCadastrados)) : ?>
                    <?php foreach ($ultimosProdutosCadastrados as $produto) : ?>
                    <tr>
                        <td><?php echo $produto['nome']; ?></td>
                        <td><?php echo $produto['preco_unitario']; ?></td>
                        <td><?php echo $produto['categoria_id']; ?></td>
                        <td><button class="details-btn">Detalhes</button></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <tr>
                        <td colspan="4">Nenhum produto cadastrado recentemente.</td>
                    </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <!-- ================= New Customers ================ -->
        <div class="recentCustomers">
            <div class="cardHeader">
                <h2>Mais Vendidos</h2>
            </div>

            <table>
                <?php if (!empty($ultimosClientesCadastrados)) : ?>
                <?php foreach ($ultimosClientesCadastrados as $cliente) : ?>
                <tr>
                    <td width="60px">
                        <h4><?php echo $cliente['cliente_id']?><br></h4>
                    </td>
                    <td class="dados-cliente-home">
                        <h4><?php echo $cliente['nome']?><br> <span>CPF: <?php echo $cliente['cpf'];?></span></h4>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                <tr>
                    <td colspan="4">Nenhum produto cadastrado recentemente.</td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
</div>