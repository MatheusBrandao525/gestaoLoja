<?php
require_once 'components/menuLateral.php';
?>
<div class="main">
    <div class="centralizar">
        <div class="config-container">
            <div class="secao-redes-sociais">
                <div class="col-rede-social">
                    <h5>Whatsapp</h5>
                    <form action="salvarRedeSocial" method="post" class="form-container-config">
                        <input type="hidden" name="nomeRede" value="Whatsapp">
                        <input type="text" name="linkRede">
                        <button type="submit">Alterar</button>
                    </form>
                </div>
                <div class="col-rede-social">
                    <h5>Facebook</h5>
                    <form action="salvarRedeSocial" method="post" class="form-container-config">
                        <input type="hidden" name="nomeRede" value="Facebook">
                        <input type="text" name="linkRede">
                        <button type="submit">Alterar</button>
                    </form>
                </div>
                <div class="col-rede-social">
                    <h5>Instagram</h5>
                    <form action="salvarRedeSocial" method="post" class="form-container-config">
                        <input type="hidden" name="nomeRede" value="Instagram">
                        <input type="text" name="linkRede">
                        <button type="submit">Alterar</button>
                    </form>
                </div>
                <div class="col-rede-social">
                    <h5>TikTok</h5>
                    <form action="salvarRedeSocial" method="post" class="form-container-config">
                        <input type="hidden" name="nomeRede" value="TikTok">                        
                        <input type="text" name="linkRede">
                        <button type="submit">Alterar</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>