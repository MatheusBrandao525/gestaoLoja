<?php
require_once 'components/menuLateral.php';
$produtos = new ProdutoController();
$produtosData = $produtos->buscarProdutosPorCategoria();
?>
<div class="main">
    <div class="centralizar">
    <div class="produtos-container">
            <?php foreach ($produtosData as $produto) { ?>
                <div class="produto-item">
                    <div class="produto-imagem">
                        <img src="public/assets/img/produtos/<?php echo $produto['imagem1']; ?>" alt="Imagem do produto">
                    </div>
                    <div class="produto-info">
                        <span class="produto-nome"><?php echo htmlspecialchars($produto['nome']); ?></span>
                        <div class="produto-opcoes">
                            <button class="btn-excluir-produto" data-produto-id="<?php echo $produto['produto_id']; ?>">Detalhes</button>
                            <button class="btn-excluir-produto" data-produto-id="<?php echo $produto['produto_id']; ?>">Excluir</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>