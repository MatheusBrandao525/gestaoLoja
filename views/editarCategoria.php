<?php
require_once 'components/menuLateral.php';
require_once 'controllers/CategoriaController.php';
require_once 'controllers/subCategoriaController.php';

// Inicializando o controlador
$subCategoriaController = new SubCategoriaController();

// Obtendo os dados da categoria e suas subcategorias
$categoriaId = $_POST['categoria_id'] ?? null; // Pegue o id da categoria via POST
$categoriaInfo = $subCategoriaController->exibirSubCategoriasDaCategoriaAtual($categoriaId);

// Dados da categoria
$categoriaData = $categoriaInfo['categoria'] ?? null;

// Subcategorias associadas
$subcategorias = $categoriaInfo['subcategorias'] ?? [];

if (!$categoriaData) {
    echo "Categoria não encontrada.";
    exit;
}
?>

<div class="main">
    <div class="centralizar" style="display: flex; flex-direction:column;">
        <!-- Formulário de edição de categoria -->
        <form id="formularioEditarCategoria" action="editarCategoria.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="categoriaId" value="<?php echo htmlspecialchars($categoriaData['categoria_id']); ?>">
            <div class="row">
                <div class="column">
                    <label for="nomeCategoria">Nome da Categoria:</label>
                    <input type="text" id="nomeCategoria" name="nomeCategoria" value="<?php echo htmlspecialchars($categoriaData['nome_categoria']); ?>" required>
                </div>
                <?php if (!empty($categoriaData['imagem_categoria'])) { ?>
                    <div class="column">
                        <div class="preview-imagem-atual-categoria">
                            <label for="imagemCategoria">Imagem Atual:</label>
                            <img src="public/assets/img/categorias/<?php echo htmlspecialchars($categoriaData['imagem_categoria']); ?>" alt="Imagem da categoria">

                        </div>
                    </div>
                <?php } else { ?>
                <?php } ?>
                <div class="column">
                    <label for="imagemCategoria">Atualizar Imagem da Categoria:</label>
                    <input type="file" id="imagemCategoria" name="imagemCategoria">
                </div>
                <div class="column container-botao-cadastro">
                    <button type="submit" class="btn-cadastro">Salvar</button>
                </div>
            </div>
        </form>

        <div class="container-subcategorias" style="padding: 10px; width: 100% !important;">
            <!-- Exibição das Subcategorias Relacionadas -->
            <h3>Subcategorias Associadas</h3>
            <div class="subcategorias-list" style="width:100% !important; display: flex; flex-direction:column;">
                <?php if (!empty($subcategorias)) : ?>
                    <ul style="width:100% !important; border: 1px solid #f4f4f4;">
                        <?php foreach ($subcategorias as $subcategoria) : ?>
                            <li style="padding: 10px 0; list-style: none; width:100% !important; display: flex; justify-content: space-between; align-items: center;">
                                <div class="column" style="flex: 1;">
                                    <strong><?php echo htmlspecialchars($subcategoria['nome_subcategoria']); ?></strong>
                                </div>
                                <div class="column" style="flex: 1; text-align: center;">
                                    <form action="editarSubcategoria.php" method="post" style="display: inline;padding: 0 !important;">
                                        <input type="hidden" name="subcategoria_id" value="<?php echo htmlspecialchars($subcategoria['subcategoria_id']); ?>">
                                        <button type="submit" class="btn-cadastro" style="padding: 2px !important;">Editar</button>
                                    </form>
                                </div>
                                <div class="column" style="flex: 1; text-align: center;">
                                    <form action="deletarSubcategoria.php" method="post" style="display: inline;padding: 0 !important;">
                                        <input type="hidden" name="subcategoria_id" value="<?php echo htmlspecialchars($subcategoria['subcategoria_id']); ?>">
                                        <button type="submit" class="btn-cadastro" onclick="return confirm('Tem certeza que deseja deletar esta subcategoria?')">Deletar</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>Não há subcategorias associadas a esta categoria.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>