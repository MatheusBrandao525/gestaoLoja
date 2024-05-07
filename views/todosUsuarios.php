<?php
$usuariosController = new UsuarioController();
$usuariosData = $usuariosController->exibirTodosOsUsuarios();
require_once 'components/menuLateral.php';
?>
<div class="main">
    <div class="centralizar">
        <div class="usuarios-container">
            <?php foreach ($usuariosData as $usuario) { ?>
                <div class="usuario-item">
                    <div class="usuario-imagem">
                        <img src="public/assets/img/usuarios/<?php echo $usuario['foto']; ?>" alt="Foto do Usuário">
                    </div>
                    <div class="usuario-info">
                        <span class="usuario-nome"><?php echo htmlspecialchars($usuario['nome']); ?></span>
                        <div class="usuario-opcoes">
                            <form action="editarUsuario" method="post">
                                <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">
                                <button type="submit" class="btn-editar">Editar</button>
                            </form>
                            <button class="btn-excluir-usuario" data-usuario-id="<?php echo $usuario['id']; ?>">Excluir</button>
                            <form action="verDetalhesUsuario" method="post">
                                <input type="hidden" name="usuarioId" value="<?php echo $usuario['id'];?>">
                                <button type="submit" class="btn-ver-detalhes">Ver Detalhes</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>
