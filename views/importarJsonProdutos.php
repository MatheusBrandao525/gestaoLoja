<?php
require_once 'components/menuLateral.php';
?>
<div class="main">
    <div class="centralizar alinhamento-coluna">

        <div class="coluna-inteira">
            <div class="coluna-metade">
                <h4>Importar produtos</h4>
                <form action="processarProdutosImportados" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="column">
                            <div class="file-upload-wrapper">
                                <input type="file" id="real-file" hidden="hidden" name="fileUpload" required>
                                <div class="custom-file-upload">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span class="file-upload-text">Clique para adicionar arquivos</span>
                                </div>
                                <div class="file-upload-preview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="column container-botao-upload">
                        <button type="submit" name="uploadBtn">Upload</button>
                    </div>
                </form>
            </div>
            <div class="coluna-metade">
                <div class="mensagem-importacao-produtos">
                    <p>Aqui vai ficar a mensagem de importação dos produtos.</p>
                </div>
            </div>
        </div>
        <div class="coluna-inteira">
            <div class="coluna-metade">
                <h4>Importar Imagens dos produtos</h4>
                <form action="importarImagensProduto" method="POST" enctype="multipart/form-data" class="image-upload-form">
                    <div class="row">
                        <div class="column">
                            <div class="image-upload-wrapper">
                                <input type="file" id="image-upload-file" hidden="hidden" name="imageUpload[]" multiple required>
                                <div class="image-custom-file-upload">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span class="image-file-upload-text">Clique para adicionar imagens</span>
                                </div>
                                <div class="image-file-upload-preview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="column image-upload-btn-container">
                        <button type="submit" class="image-upload-btn">Upload</button>
                    </div>
                </form>
            </div>
            <div class="coluna-metade">
                <div class="mensagem-importacao-imagens">
                    <p>Aqui vai ficar a mensagem de importação das iamgens dos produtos.</p>
                </div>
            </div>
        </div>


    </div>
</div>
</div>