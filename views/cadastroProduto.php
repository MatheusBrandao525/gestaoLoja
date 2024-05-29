<?php
require 'components/menuLateral.php';
require_once 'controllers/CategoriaController.php';
$categoriaController = new CategoriaController();
$categoriasData = $categoriaController->exibirTodasAsCategorias();
?>
<div class="main">
    <div class="centralizar">
        <form id="formularioCadastroProduto" action="cadastroProduto" method="post">
            <div class="row">
                <div class="column">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="column">
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" required>
                </div>
                <div class="column">
                    <label for="exibirPreco">Deseja exibir o preço?</label>
                    <select id="exibirPreco" name="exibirPreco" required>
                        <option value="">Selecionar...</option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="column">
                    <label for="precoCusto">Preço de Custo:</label>
                    <input type="number" id="precoCusto" name="precoCusto" required>
                </div>
                <div class="column">
                    <label for="precoUnitario">Preço Unitário:</label>
                    <input type="number" id="precoUnitario" name="precoUnitario" required>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <label for="modelos">Modelos:</label>
                    <input type="text" id="modelos" name="modelos" required>
                </div>
                <div class="column">
                    <label for="cor">Cor:</label>
                    <input type="text" id="cor" name="cor" required>
                </div>
                <div class="column">
                    <label for="destaque">É Destaque?</label>
                    <select id="destaque" name="destaque" required>
                        <option value="">Selecionar...</option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="column">
                    <label for="tamanhos">Tamanhos:</label>
                    <input type="text" id="tamanhos" name="tamanhos" required>
                </div>
                <div class="column">
                    <label for="categoriaid">Categoria</label>
                    <select id="categoriaid" name="categoriaid" required>
                        <option value="">Selecionar...</option>
                        <?php foreach ($categoriasData as $categoria): ?>
                        <option value="<?php echo $categoria['categoria_id'];?>"><?php echo $categoria['nome_categoria'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="full-width">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>
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
                <button type="submit">Cadastrar</button>
            </div>

        </form>

    </div>
</div>
</div>