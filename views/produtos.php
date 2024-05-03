<?php
$produtos = new ProdutoController();
$produtosData = $produtos->exibirTodosOsProdutos();
require_once 'components/menuLateral.php';
?>
<div class="main">
    <div class="centralizar">
        <div class="categorias-container">
            <?php foreach ($produtosData as $produto) { ?>
                <div class="categoria-item">
                    <div class="categoria-imagem">
                        <img src="public/assets/img/produtos/<?php echo $produto['imagem1']; ?>" alt="Imagem da Categoria">
                    </div>
                    <div class="categoria-info">
                        <span class="categoria-nome"><?php echo htmlspecialchars($produto['nome']); ?></span>
                        <div class="categoria-opcoes">
                            <button class="btn-editar">Editar</button>
                            <button class="btn-excluir" data-produto-id="<?php echo $produto['produto_id'] ?>" data-imagem-produto="<?php echo $produto['imagem1']; ?>">Excluir</button>
                            <button class="btn-ver-produtos">Ver Produtos</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>