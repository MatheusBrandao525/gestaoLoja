<?php

$routes = [
    '/gestaoLoja/' => 'HomeController@apresentarTelaDeHome',
    '/gestaoLoja/login' => 'LoginController@redirecionaParaTelaDeLogin',
    '/gestaoLoja/validarLogin' => 'LoginController@autenticarUsuario',
    '/gestaoLoja/sair' => 'LoginController@deslogarUsuario',
    '/gestaoLoja/home' => 'HomeController@apresentarTelaDeHome',
    '/gestaoLoja/cadastroProduto' => 'ProdutoController@mostrarTelaCadastroProduto',
    '/gestaoLoja/cadastrarProdutoDatabase' => 'ProdutoController@cadastrarProduto',
    '/gestaoLoja/categoria' => 'CategoriaController@redirecionarParaTelaCategoria',
    '/gestaoLoja/detalhes' => 'ProdutoController@redirecionaParaTelaDetalhes',
    '/gestaoLoja/conta' => 'PerfilController@apresentarTelaPerfil',
    '/gestaoLoja/carrinho' => 'CarrinhoController@apresentarTelaDeCarrinho',
    '/gestaoLoja/checkout' => 'CheckoutController@apresentarTelaCheckout',
    '/gestaoLoja/subCategoria' => 'CategoriaController@redirecionarParaSubCategorias',
    '/gestaoLoja/detalhesPedido' => 'PerfilController@redirecionaParaDetalhesPedido',
    '/gestaoLoja/pesquisa' => 'PesquisaController@redirecionaParaTelaDePesquisa',
    '/gestaoLoja/sucesso' => 'CheckoutController@redirecionaParaTelaDeSucesso',
    '/gestaoLoja/erro_404' => 'ErroController@redirecionarParaTelaDeErro404',
    '/gestaoLoja/produtos' => 'ProdutoController@apresentarTodosOsProdutos',
    '/gestaoLoja/usuario_nao_encontrado' => 'ErroController@redirecionartelaUsuarioNaoEncontrado'
];

if (isset($_GET['url'])) {
    $urlSolicitada = '/gestaoLoja/' . $_GET['url'];
    if (array_key_exists($urlSolicitada, $routes)) {
        list($controller, $method) = explode('@', $routes[$urlSolicitada]);
    } else {
        header("Location: /gestaoLoja/erro_404");
        exit;
    }
}
