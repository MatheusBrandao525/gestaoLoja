<?php
require_once 'components/menuLateral.php';
$usuario = new UsuarioController();
$usuarioData = $usuario->dadosUsuarioPorId();
?>
<div class="main">
    <div class="centralizar">
        <form id="formularioAlterarUsuario" action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="column">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="altera-nome" value="<?php echo htmlspecialchars($usuarioData['nome']); ?>" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="altera-email" value="<?php echo htmlspecialchars($usuarioData['email']); ?>" required>
                </div>
                <div class="column">
                    <label for="senha">Senha:</label>
                    <div class="password-container">
                        <input type="password" id="senha" name="altera-senha" value="<?php echo $usuarioData['senha']; ?>" required>
                        <button type="button" class="toggle-password">
                            <i id="toggle-icon" class="fa fa-eye-slash"></i>
                        </button>

                    </div>

                    <label for="status">Status:</label>
                    <select id="status" name="altera-status" required>
                        <option value="<?php echo htmlspecialchars($usuarioData['classe']); ?>"><?php echo htmlspecialchars($usuarioData['classe']); ?></option>
                        <option value="user">Usuário</option>
                        <option value="admin">Admin</option>
                        <option value="sup">Suporte</option>
                    </select>
                </div>
                <div class="column">
                    <label for="foto">Foto:</label>
                    <div class="alinhamento-horizontal">
                        <div class="upload-container" onclick="document.getElementById('foto').click();">
                            <input type="file" id="foto" name="altera-foto" style="display: none;">
                            <div class="upload-box">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                <p>Fazer upload da foto de perfil</p>
                            </div>
                        </div>
                        <div id="imagePreviewContainer" class="image-preview-container">
                            <img id="imagePreview" src="public/assets/img/usuarios/<?php echo htmlspecialchars($usuarioData['foto']); ?>" alt="Image Preview" style="<?php echo !empty($usuarioData['foto']) ? '' : 'display: none;'; ?>" />
                        </div>
                    </div>

                </div>

            </div>
            <div class="full-width container-botao-cadastro">
                <button type="submit">Salvar Dados</button>
            </div>
        </form>
    </div>
</div>