<?php
require_once 'components/menuLateral.php';
require_once 'controllers/ProdutoController.php';
$produtoController = new ProdutoController();
$produtoData = $produtoController->mostraDadosProduto();
?>
<div class="main">
    <div class="centralizar">
        <form id="formularioEditarProduto" action="alteraProduto" method="post">
            <div class="row">
                <div class="column">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produtoData['nome']); ?>" required>
                </div>
                <div class="column">
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" value="<?php echo htmlspecialchars($produtoData['codigo']); ?>" required>
                </div>
                <div class="column">
                    <label for="exibirPreco">Deseja exibir o preço?</label>
                    <select id="exibirPreco" name="exibirPreco" required>
                        <option value="<?php echo htmlspecialchars($produtoData['exibe_preco']); ?>"><?php echo htmlspecialchars($produtoData['status_exibe_preco']); ?></option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="column">
                    <label for="precoCusto">Preço de Custo:</label>
                    <input type="number" id="precoCusto" name="precoCusto" value="<?php echo htmlspecialchars($produtoData['preco_custo']); ?>" required>
                </div>
                <div class="column">
                    <label for="precoUnitario">Preço Unitário:</label>
                    <input type="number" id="precoUnitario" name="precoUnitario" value="<?php echo htmlspecialchars($produtoData['preco_unitario']); ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <label for="modelos">Modelos:</label>
                    <input type="text" id="modelos" name="modelos" value="<?php echo htmlspecialchars($produtoData['modelos']); ?>" required>
                </div>
                <div class="column">
                    <label for="cor">Cor:</label>
                    <input type="text" id="cor" name="cor" value="<?php echo htmlspecialchars($produtoData['cor']); ?>" required>
                </div>
                <div class="column">
                    <label for="destaque">É Destaque?</label>
                    <select id="destaque" name="destaque" value="<?php echo htmlspecialchars($produtoData['destaque']); ?>" required>
                        <option value="<?php echo htmlspecialchars($produtoData['destaque']); ?>"><?php echo htmlspecialchars($produtoData['status_destaque']); ?></option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="column">
                    <label for="tamanhos">Tamanhos:</label>
                    <input type="text" id="tamanhos" name="tamanhos" value="<?php echo htmlspecialchars($produtoData['tamanhos']); ?>" required>
                </div>
                <div class="column">
                    <label for="categoriaid">Categoria</label>
                    <select id="categoriaid" name="categoriaid" required>
                        <option value="<?php echo htmlspecialchars($produtoData['categoria_id']); ?>"><?php echo htmlspecialchars($produtoData['nome_categoria']); ?></option>
                        <option value="1">teste1</option>
                        <option value="2">teste2</option>
                    </select>
                </div>
            </div>
            <div class="full-width">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($produtoData['descricao']); ?></textarea>
            </div>
            <div class="row">
                <div class="column">
                    <div class="preview-imagem-atual-produto">
                        <span>Imagem 01 Atual</span>
                        <img src="public/assets/img/produtos/<?php echo $produtoData['imagem1']; ?>" alt="">
                    </div>
                </div>
                <?php if ($produtoData['imagem3'] != null && $produtoData['imagem3'] != '') { ?>
                    <div class="column">
                        <div class="preview-imagem-atual-produto">
                            <span>Imagem 02 Atual</span>
                            <img src="public/assets/img/produtos/<?php echo $produtoData['imagem2']; ?>" alt="">
                        </div>
                    </div>
                <?php } ?>
                <?php if ($produtoData['imagem3'] != null && $produtoData['imagem3'] != '') { ?>
                    <div class="column">
                        <div class="preview-imagem-atual-produto">
                            <span>Imagem 03 Atual</span>
                            <img src="public/assets/img/produtos/<?php echo $produtoData['imagem3']; ?>" alt="">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="column">
                    <div class="">
                        <label for="imagem1">Imagem:</label>
                        <input type="file" id="imagem1" name="imagem1" required>
                    </div>
                </div>
                <div class="column">
                    <div class="">
                        <label for="imagem2">Imagem:</label>
                        <input type="file" id="imagem2" name="imagem2">
                    </div>
                </div>
                <div class="column">
                    <div class="">
                        <label for="imagem3">Imagem:</label>
                        <input type="file" id="imagem3" name="imagem3">
                    </div>
                </div>
            </div>
            <div class="full-width container-botao-cadastro">
                <a href="produtos" class="btn-voltar">Voltar</a>
                <button type="submit">Cadastrar</button>
            </div>

        </form>
    </div>
</div>