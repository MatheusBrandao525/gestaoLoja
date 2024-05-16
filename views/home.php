<?php
require_once 'controllers/ProdutoController.php';
require_once 'controllers/UsuarioController.php';
require_once 'controllers/CategoriaController.php';
require 'components/menuLateral.php';
$usuarioController = new UsuarioController();
$produtoController = new ProdutoController();
$categoriaController = new CategoriaController();
$ultimosProdutosCadastrados = $produtoController->exibirUltimosProdutosCadastrados();
$quantidadeDeprodutosCadastrados = $produtoController->exibirQuantidadeDeProdutosCadastrados();
$quantidadeDeUsuariosCadastrados = $usuarioController->exibirQuantidadeDeUsuariosCadastrados();
$quantidadeDeCategoriasCadastradas = $categoriaController->exibirQuantidadeDeCategoriasCadastradas();
?>
<div class="main">


    <!-- ======================= Cards ================== -->
    <div class="cardBox">
        <div class="card">
            <div>
                <div class="numbers"><?php echo $quantidadeDeprodutosCadastrados; ?></div>
                <div class="cardName">Produtos Cadastrados</div>
            </div>

            <div class="iconBx">
                <i class="fas fa-box-open"></i>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers">0</div>
                <div class="cardName">Clientes Cadastrados</div>
            </div>

            <div class="iconBx">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers"><?php echo $quantidadeDeCategoriasCadastradas; ?></div>
                <div class="cardName">Categorias Cadastradas</div>
            </div>

            <div class="iconBx">
                <i class="fas fa-tags"></i>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers"><?php echo $quantidadeDeUsuariosCadastrados; ?></div>
                <div class="cardName">Usuarios Cadastrados</div>
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
                <h2>Produtos Cadastrados Recentemente</h2>
                <a href="#" class="btn">Ver Todos</a>
            </div>

            <table class="fixed-header">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>Preço</td>
                        <td>Categoria</td>
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
                <h2>Clientes Cadastrados Recentemente</h2>
            </div>

            <table>
                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="public/assets/img/placeholder.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>David <br> <span>Italy</span></h4>
                    </td>
                </tr>

                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="public/assets/img/placeholder.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>Amit <br> <span>India</span></h4>
                    </td>
                </tr>

                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="public/assets/img/placeholder.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>David <br> <span>Italy</span></h4>
                    </td>
                </tr>

                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="public/assets/img/placeholder.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>Amit <br> <span>India</span></h4>
                    </td>
                </tr>

                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="public/assets/img/placeholder.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>David <br> <span>Italy</span></h4>
                    </td>
                </tr>

                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="public/assets/img/placeholder.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>Amit <br> <span>India</span></h4>
                    </td>
                </tr>

                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="public/assets/img/placeholder.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>David <br> <span>Italy</span></h4>
                    </td>
                </tr>

                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="public/assets/img/placeholder.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>Amit <br> <span>India</span></h4>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>