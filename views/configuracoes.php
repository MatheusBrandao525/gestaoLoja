<?php
require_once 'components/menuLateral.php';
require_once 'controllers/ConfiguracoesController.php';
$configuracaoController = new ConfiguracoesController();
$nomeRedeSocial = 'Whatsapp';


?>
<div class="main">
    <div class="centralizar">
        <div class="config-container">
            <div class="secao-redes-sociais">
                <div class="col-rede-social">
                    <h5>Whatsapp</h5>
                    <form action="salvarRedeSocial" method="post" class="form-container-config">
                        <input type="hidden" name="nomeRede" value="Whatsapp">
                        <?php
                            $redeSocial = $configuracaoController->verificaSeWhatsappEstaSalvo("Whatsapp");
                            if ($redeSocial) {
                            
                            $valorDoCampoLinkDaTabela = $redeSocial['link'];
                            ?>
                            <input type="text" name="linkRede" value="<?php echo $valorDoCampoLinkDaTabela; ?>">
                        <?php
                            } else {
                        ?>
                            <input type="text" name="linkRede">
                        <?php
                            }
                        ?>
                        <button type="submit">Alterar</button>
                    </form>

                </div>
                <div class="col-rede-social">
                    <h5>Facebook</h5>
                    <form action="salvarRedeSocial" method="post" class="form-container-config">
                        <input type="hidden" name="nomeRede" value="Facebook">
                        <?php
                            $redeSocial = $configuracaoController->verificaSeFacebookEstaSalvo("Facebook");
                            if ($redeSocial) {
                            
                            $valorDoCampoLinkDaTabela = $redeSocial['link'];
                            ?>
                            <input type="text" name="linkRede" value="<?php echo $valorDoCampoLinkDaTabela; ?>">
                        <?php
                            } else {
                        ?>
                            <input type="text" name="linkRede">
                        <?php
                            }
                        ?>
                        <button type="submit">Alterar</button>
                    </form>
                </div>
                <div class="col-rede-social">
                    <h5>Instagram</h5>
                    <form action="salvarRedeSocial" method="post" class="form-container-config">
                        <input type="hidden" name="nomeRede" value="Instagram">
                        <?php
                            $redeSocial = $configuracaoController->verificaSeInstagramEstaSalvo("Instagram");
                            if ($redeSocial) {
                            
                            $valorDoCampoLinkDaTabela = $redeSocial['link'];
                            ?>
                            <input type="text" name="linkRede" value="<?php echo $valorDoCampoLinkDaTabela; ?>">
                        <?php
                            } else {
                        ?>
                            <input type="text" name="linkRede">
                        <?php
                            }
                        ?>
                        <button type="submit">Alterar</button>
                    </form>
                </div>
                <div class="col-rede-social">
                    <h5>TikTok</h5>
                    <form action="salvarRedeSocial" method="post" class="form-container-config">
                        <input type="hidden" name="nomeRede" value="TikTok">
                        <?php
                            $redeSocial = $configuracaoController->verificaSeTikTokEstaSalvo("TikTok");
                            if ($redeSocial) {
                            
                            $valorDoCampoLinkDaTabela = $redeSocial['link'];
                            ?>
                            <input type="text" name="linkRede" value="<?php echo $valorDoCampoLinkDaTabela; ?>">
                        <?php
                            } else {
                        ?>
                            <input type="text" name="linkRede">
                        <?php
                            }
                        ?>
                        <button type="submit">Alterar</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>