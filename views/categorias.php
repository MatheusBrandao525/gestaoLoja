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
                        <img src="public/assets/img/categorias/<?php echo $categoria['imagem_categria']; ?>" alt="Imagem da Categoria">
                    </div>
                    <div class="categoria-info">
                        <span class="categoria-nome"><?php echo htmlspecialchars($categoria['nome_categoria']); ?></span>
                        <div class="categoria-opcoes">
                            <form action="editarCategoria" method="post">
                                <input type="hidden" name="categoria_id" value="<?php echo $categoria['categoria_id']; ?>">
                                <button type="submit" class="btn-editar">Editar</button>
                            </form>
                            <button class="btn-excluir" data-categoria-id="<?php echo $categoria['categoria_id']; ?>" data-imagem-categoria="<?php echo $categoria['imagem_categria']; ?>">Excluir</button>
                            <button class="btn-ver-produtos">Ver Produtos</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>