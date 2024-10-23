<?php
require_once 'components/menuLateral.php';
require_once 'controllers/CategoriaController.php';

$categoriaController = new CategoriaController();
$todasAsCategorias = $categoriaController->exibirTodasAsCategorias();
?>
<div class="main">
    <div class="centralizar">
        <form id="formularioCadastroSubcategoria" action="cadastrarSubcategoriaDatabase" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="column">
                    <label for="nomeSubcategoria">Nome da Subcategoria:</label>
                    <input type="text" id="nomeSubcategoria" name="nomeSubcategoria" required>
                </div>
                <div class="column">
                    <label for="categoriaPai">Categoria Pai:</label>
                    <select id="categoriaPai" name="categoriaPai" required>
                        <?php foreach ($todasAsCategorias as $categoria): ?>
                            <option value="<?php echo $categoria['categoria_id']; ?>"><?php echo $categoria['nome_categoria']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="column">
                    <label for="imagemSubcategoria">Imagem da Subcategoria:</label>
                    <input type="file" id="imagemSubcategoria" name="imagemSubcategoria">
                </div>
                <div class="column container-botao-cadastro">
                    <button type="submit" class="btn-cadastro">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        const form = $("#formularioCadastroSubcategoria");
        $("#formularioCadastroSubcategoria").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: this.action,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log("Sucesso:", response);
                    alert("Subcategoria cadastrada com sucesso!");
                    form[0].reset();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Erro:", textStatus, errorThrown);
                    alert("Erro ao cadastrar subcategoria! Tente novamente.");
                }
            });
        });
    });
</script>