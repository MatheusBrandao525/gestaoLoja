<?php
require_once 'components/menuLateral.php';
?>
<div class="main">
    <div class="centralizar">
        <form method="POST" enctype="multipart/form-data">
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
</div>
</div>