<?php
require 'components/menuLateral.php';
?>
<div class="main">
    <div class="centralizar">
    <div class="coluna-inteira-importa-categorias">
            <div class="coluna-inteira-importar-categorias">
                <h4>Importar Categorias</h4>
                <form action="processarCategoriasImportadas" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="column">
                            <div class="categoria-upload-wrapper">
                                <input type="file" id="real-file" hidden="hidden" name="categoriasFileUpload" required>
                                <div class="custom-categoria-upload">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span class="categoria-upload-text">Clique para adicionar arquivos</span>
                                </div>
                                <div class="categoria-upload-preview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="column container-botao-upload">
                        <button type="submit" name="uploadBtn">Upload</button>
                    </div>
                </form>
            </div>
            <div class="coluna-inteira-importar-categorias">
                <div class="mensagem-importacao-categorias">
                    <p>Aqui vai ficar a mensagem de importação dos produtos.</p>
                </div>
            </div>
        </div>
    </div>
</div>