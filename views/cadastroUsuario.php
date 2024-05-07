<?php
require_once 'components/menuLateral.php';
?>
<div class="main">
    <div class="centralizar">
        <form id="formularioCadastroUsuario" action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="column">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="column">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="">Selecionar...</option>
                        <option value="user">Usuário</option>
                        <option value="admin">Admin</option>
                        <option value="sup">Suporte</option>
                    </select>
                </div>
                <div class="column">
                    <label for="foto">Foto:</label>
                    <div class="alinhamento-horizontal">
                        <div class="upload-container" onclick="document.getElementById('foto').click();">
                            <input type="file" id="foto" name="foto" style="display: none;" required>
                            <div class="upload-box">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                <p>Fazer upload da foto de perfil</p>
                            </div>
                        </div>
                        <div id="imagePreviewContainer" class="image-preview-container">
                            <img id="imagePreview" src="#" alt="Image Preview" style="display: none;" />
                        </div>
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