<?php
require_once 'components/menuLateral.php';
require_once 'controllers/CategoriaController.php';
$categoriaController = new CategoriaController();
$categoriaData = $categoriaController->mostraDadosCategoria();
?>
<div class="main">
    <div class="centralizar">
            <form id="formularioEditarCategoria" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="categoriaId" value="<?php echo $categoriaData['categoria_id'];?>">
                <div class="row">
                    <div class="column">
                        <label for="nomeCategoria">Nome da Categoria:</label>
                        <input type="text" id="nomeCategoria" name="nomeCategoria" value="<?php echo htmlspecialchars($categoriaData['nome_categoria']);?>" required>
                    </div>
                    <div class="column">
                    <div class="preview-imagem-atual-categoria">
                        <label for="imagemCategoria">Imagem da Categoria:</label>
                        <img src="public/assets/img/categorias/<?php echo $categoriaData['imagem_categria'];?>" alt="">
                    </div>
                    </div>
                    <div class="column">
                        <label for="imagemCategoria">Imagem da Categoria:</label>
                        <input type="file" id="imagemCategoria" name="imagemCategoria" required>
                    </div>
                    <div class="column container-botao-cadastro">
                        <button type="submit" clas="btn-cadastro">Salvar</button>
                    </div>
                </div>
            </form>
    </div>
</div>
</div>