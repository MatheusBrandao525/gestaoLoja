<?php
$categorias = new CategoriaController();
$categoriasData = $categorias->exibirTodasAsCategorias();
require_once 'components/menuLateral.php';
?>
<div class="main">
    <div class="centralizar">
        <div class="categorias-container">
            <?php foreach ($categoriasData as $categoria) { ?>
            <div class="categoria-item">
                <div class="categoria-imagem">
                    <img src="public/assets/img/categorias/<?php echo $categoriasData['imagem_categria'];?>" alt="Imagem da Categoria">
                </div>
                <div class="categoria-info">
                    <span class="categoria-nome"><?php echo htmlspecialchars($categoria['nome_categoria']); ?></span>
                    <div class="categoria-opcoes">
                        <button class="btn-editar">Editar</button>
                        <button class="btn-excluir">Excluir</button>
                        <button class="btn-ver-produtos">Ver Produtos</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>