<?php

$routes = [
    '/gestaoLoja/' => 'HomeController@apresentarTelaDeHome',
    '/gestaoLoja/login' => 'LoginController@redirecionaParaTelaDeLogin',
    '/gestaoLoja/home' => 'HomeController@apresentarTelaDeHome',
    '/gestaoLoja/validarLogin' => 'LoginController@autenticarUsuario',
    '/gestaoLoja/sair' => 'LoginController@deslogarUsuario',
    '/gestaoLoja/importarProdutos' => 'ProdutoController@telaImportarJsonProdutos',
    '/gestaoLoja/cadastroProduto' => 'ProdutoController@mostrarTelaCadastroProduto',
    '/gestaoLoja/cadastrarProdutoDatabase' => 'ProdutoController@cadastrarProduto',
    '/gestaoLoja/cadastroCategoria' => 'CategoriaController@telaCadastrarCategoria',
    '/gestaoLoja/excluirCategoria' => 'CategoriaController@excluirCategoria',
    '/gestaoLoja/excluirUsuario' => 'UsuarioController@excluirUsuario',
    '/gestaoLoja/editarUsuario' => 'UsuarioController@telaEditarUsuario',
    '/gestaoLoja/alterarDadosUsuario' => 'UsuarioController@alterarDadosUsuario',
    '/gestaoLoja/editarProduto' => 'ProdutoController@telaEditarProduto',
    '/gestaoLoja/alterarDadosProduto' => 'ProdutoController@alterarDadosProduto',
    '/gestaoLoja/excluirProduto' => 'ProdutoController@excluirProduto',
    '/gestaoLoja/excluirImagemProduto' => 'ProdutoController@excluirImagemProduto',
    '/gestaoLoja/cadastarCategoriaDatabase' => 'CategoriaController@cadastrarCategoria',
    '/gestaoLoja/detalhes' => 'ProdutoController@redirecionaParaTelaDetalhes',
    '/gestaoLoja/categorias' => 'CategoriaController@telaCategorias',
    '/gestaoLoja/verProdutosCategoria' => 'ProdutoController@telaProdutosPorCategoria',
    '/gestaoLoja/editarCategoria' => 'CategoriaController@telaEditarCategoria',
    '/gestaoLoja/editarDadosCategoria' => 'CategoriaController@editarCategoria',
    '/gestaoLoja/detalhesPedido' => 'PerfilController@redirecionaParaDetalhesPedido',
    '/gestaoLoja/erro_404' => 'ErroController@redirecionarParaTelaDeErro404',
    '/gestaoLoja/produtos' => 'ProdutoController@telaTodosOsProdutos',
    '/gestaoLoja/cadastroUsuarios' => 'UsuarioController@telaCadastrarUsuarios',
    '/gestaoLoja/cadastrarUsuario' => 'UsuarioController@cadastrarUsuario',
    '/gestaoLoja/verUsuarios' => 'UsuarioController@telaTodosOsUsuarios',
    '/gestaoLoja/cadastroCliente' => 'ClienteController@telaCadastroCliente',
    '/gestaoLoja/verClientes' => 'ClienteController@telaTodosOsClientes',
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
