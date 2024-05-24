<?php
require_once 'components/menuLateral.php';
?>
<style>
    .conteiner-acesso-negado{
    width: 98% !important;
    height: 650px !important;
    display: flex;
    justify-content: center;
    flex-direction: column;
}

h1.headerAcessoNegado{
    display: flex;
    width: 100%;
    padding: 2rem 0 !important;
    text-align: center;
    justify-content: center;
    align-items: center;
}

.mensagemAcessoNegado{
    font-size: 1rem;
    text-align: center;
}

.container-botao-voltar-acesso{
    display:flex;
    height: 100px;
    align-items: center;
    width: 100% !important;
    justify-content: center;
}

.botaoVoltarAcessoNegado{
    padding: 10px;
    width: 350px !important;
    height: 40px;
    color: #fff;
    font-weight: bold;
    text-decoration: none;
    border-radius: 10px;
    text-align: center !important;
    background-color: #61a6ab;
}
</style>
<div class="main">
    <div class="centralizar">
        <div class="conteiner-acesso-negado">
        <h1 class="headerAcessoNegado">Acesso Negado</h1>
        <p class="mensagemAcessoNegado">Você não tem permissão para acessar esta página.</p>
        <div class="container-botao-voltar-acesso">
        <a href="/login" class="botaoVoltarAcessoNegado">Voltar para a página de login</a>
        </div>
    </div>
</div>
</div>
