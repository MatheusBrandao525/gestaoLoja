<?php
require_once 'components/menuLateral.php';
?>
<div class="main">
    <div class="centralizar">
        <form id="formularioCadastroCategoria" action="cadastarCategoriaDatabase" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="column">
                    <label for="nomeCategoria">Nome da Categoria:</label>
                    <input type="text" id="nomeCategoria" name="nomeCategoria" required>
                </div>
                <div class="column">
                    <label for="imagemCategoria">Imagem da Categoria:</label>
                    <input type="file" id="imagemCategoria" name="imagemCategoria" required>
                </div>
                <div class="column container-botao-cadastro">
                    <button type="submit" clas="btn-cadastro">Cadastrar Categoria</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
    <script>
        $(document).ready(function() {
            const form = $("#formularioCadastroCategoria");
            $("#formularioCadastroCategoria").submit(function(e) {
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
                        alert("Categoria cadastrada com sucesso!");
                        form[0].reset();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Erro:", textStatus, errorThrown);
                        alert("Erro ao cadastrar categoria! Tente novamente.");
                    }
                });
            });
        });
    </script>