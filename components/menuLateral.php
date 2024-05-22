<?php
require_once 'utils/Utilidades.php';
$utilidades = new Utilidades();
$sessaoExiste = $utilidades->verificaSeSessaoExiste();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="public/assets/css/style_menuLateral.css">
    <link rel="stylesheet" href="public/assets/css/style_cadastroProdutosForm.css">
    <link rel="stylesheet" href="public/assets/css/style_telaTodasCategorias.css">
    <link rel="stylesheet" href="public/assets/css/style_telaTodosProdutos.css">
    <link rel="stylesheet" href="public/assets/css/style_importarProdutos.css">
    <link rel="stylesheet" href="public/assets/css/style_telaEditarProduto.css">
    <link rel="stylesheet" href="public/assets/css/style_telaEditarCategoria.css">
    <link rel="stylesheet" href="public/assets/css/style_cadastroUsuario.css">
    <link rel="stylesheet" href="public/assets/css/style_telaTodosUsuarios.css">
    <link rel="stylesheet" href="public/assets/css/style_telaEditarUsuario.css">
    <link rel="stylesheet" href="public/assets/css/style_importarCategorias.css">
    <link rel="stylesheet" href="public/assets/css/style_telaConfiguracoes.css">
    <link rel="stylesheet" href="public/assets/css/style_telaTodosClientes.css">

    <style>
        .dropbtn {
            cursor: pointer;
            display: block;
        }

        .nome-icone {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding-right: 10px;
            /* Espaçamento entre o título e a seta */
        }

        .nome-icone .title {
            margin-right: 10px;
            /* Espaço entre o texto e a seta */
        }

        .nome-icone i {
            transition: transform 0.3s ease;
            /* Suaviza a rotação */
        }


        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Dropdown container */
        .dropdown {
            position: relative;
        }

        /* Estilização do conteúdo do dropdown com transição */
        .dropdown-content {
            max-height: 0;
            overflow: hidden;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out;
            opacity: 0;
            transition-delay: 0.25s;
        }

        .dropdown-content.show {
            max-height: 500px;
            /* ajuste conforme necessário */
            opacity: 1;
            transition-delay: 0s;
        }

        .dropdown {
            position: relative;
        }

        /* CSS para manter os outros itens no lugar enquanto o dropdown se expande */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        .details-btn {
            background-color: #2790b0;
            border: none;
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <img src="public/assets/img/top_motos.png" alt="Brand Logo">
                        </span>
                    </a>

                </li>

                <li>
                    <a href="home">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropbtn">
                        <span class="icon">
                            <i class="fas fa-tags"></i>
                        </span>
                        <div class="nome-icone">
                            <span class="title">Categorias</span>
                            <i class="fas fa-chevron-down"></i> <!-- Ícone da seta -->
                        </div>
                    </a>
                    <div class="dropdown-content">
                        <a href="importarCategorias">Importar Categorias</a>
                        <a href="cadastroCategoria">Cadastrar Categoria</a>
                        <a href="categorias">Ver Categorias</a>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropbtn">
                        <span class="icon">
                            <i class="fas fa-box-open"></i>
                        </span>
                        <div class="nome-icone">
                            <span class="title">Pedidos</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="dropdown-content">
                        <a href="importarProdutos">Pedidos Realizados</a>
                        <a href="cadastroProduto">Atualizar Pedido</a>
                        <a href="produtos">Pedidos Entregues</a>
                    </div>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropbtn">
                        <span class="icon">
                            <i class="fas fa-box-open"></i>
                        </span>
                        <div class="nome-icone">
                            <span class="title">Produtos</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="dropdown-content">
                        <a href="importarProdutos">Importar Produtos</a>
                        <a href="cadastroProduto">Cadastrar Produto</a>
                        <a href="produtos">Ver Produtos</a>
                    </div>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropbtn">
                        <span class="icon">
                            <i class="fas fa-users"></i>
                        </span>
                        <div class="nome-icone">
                            <span class="title">Clientes</span>
                            <i class="fas fa-chevron-down"></i> <!-- Ícone da seta -->
                        </div>
                    </a>
                    <div class="dropdown-content">
                        <a href="verClientes">Ver Clientes</a>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropbtn">
                        <span class="icon">
                            <i class="fas fa-id-card"></i>
                        </span>
                        <div class="nome-icone">
                            <span class="title">Usuarios</span>
                            <i class="fas fa-chevron-down"></i> <!-- Ícone da seta -->
                        </div>
                    </a>
                    <div class="dropdown-content">
                        <a href="cadastroUsuarios">Cadastrar Usuario</a>
                        <a href="verUsuarios">Ver Usuarios</a>
                    </div>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">Ajuda</span>
                    </a>
                </li>

                <li>
                    <a href="configuracoes">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Configurações</span>
                    </a>
                </li>

                <li>
                    <a href="sair">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sair</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="topbar">
            <div class="toggle">

            </div>

            <div class="user">
                <img src="public/assets/img/placeholder.jpg" alt="">
            </div>
        </div>
        <!-- ========================= Main ==================== -->

    </div>

    <!-- =========== Scripts =========  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="public/assets/js/menuLateral.js"></script>
    <script src="public/assets/js/cadastroProdutoForm.js"></script>
    <script src="public/assets/js/excluirCategoria.js"></script>
    <script src="public/assets/js/excluirProduto.js"></script>
    <script src="public/assets/js/importarProdutos.js"></script>
    <script src="public/assets/js/editarProduto.js"></script>
    <script src="public/assets/js/editarCategoria.js"></script>
    <script src="public/assets/js/cadastroUsuario.js"></script>
    <script src="public/assets/js/excluirUsuario.js"></script>
    <script src="public/assets/js/editarUsuario.js"></script>
    <script src="public/assets/js/importarCategorias.js"></script>
    <script src="public/assets/js/buscarProdutos.js"></script>
    <script src="public/assets/js/salvarLinkRedeSocial.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(function(dropdown) {
                var btn = dropdown.querySelector('.dropbtn');
                btn.addEventListener('click', function(event) {
                    event.stopPropagation();
                    var dropdownContent = this.nextElementSibling;
                    var icon = this.querySelector('.nome-icone i'); // Seleciona o ícone de seta dentro de nome-icone
                    if (dropdownContent.classList.contains('show')) {
                        dropdownContent.classList.remove('show');
                        icon.style.transform = 'rotate(0deg)'; // Seta aponta para baixo
                    } else {
                        closeAllDropdowns();
                        dropdownContent.classList.add('show');
                        icon.style.transform = 'rotate(180deg)'; // Seta aponta para cima
                    }
                });
            });

            function closeAllDropdowns() {
                document.querySelectorAll('.dropdown-content').forEach(function(element) {
                    element.classList.remove('show');
                    var icon = element.previousElementSibling.querySelector('.nome-icone i');
                    if (icon) {
                        icon.style.transform = 'rotate(0deg)'; // Reseta a rotação da seta
                    }
                });
            }

            document.addEventListener('click', function(event) {
                if (!event.target.matches('.dropbtn, .dropbtn *')) { // Inclui todos os filhos de dropbtn no seletor
                    closeAllDropdowns();
                }
            });
        });
    </script>

    <script>
        function loadContent(option) {
            const mainDiv = document.querySelector('.main');

            fetch(`components/${option}.php`)
                .then(response => response.text())
                .then(html => {
                    mainDiv.innerHTML = html;
                })
                .catch(error => console.error('Error loading the page: ', error));
        }
    </script>

</body>

</html>