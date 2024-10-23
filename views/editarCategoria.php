<?php
require_once 'components/menuLateral.php';
require_once 'controllers/CategoriaController.php';
$categoriaController = new CategoriaController();
$categoriaData = $categoriaController->mostraDadosCategoria();

// Obtendo os dados da categoria e suas subcategorias
$categoriaInfo = $categoriaController->exibirSubCategoriasDaCategoriaAtual();

// Dados da categoria
$categoriaData = $categoriaInfo['categoria'] ?? null;

// Subcategorias associadas
$subcategorias = $categoriaInfo['subcategorias'] ?? [];

if (isset($categoriaInfo['error'])) {
    echo $categoriaInfo['error'];
    exit;
}

if (!$categoriaData) {
    echo "Categoria não encontrada.";
    exit;
}
?>
<style>
    .btn-cadastro {
        background-color: #4CAF50;
        /* Verde moderno */
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    form.form-opcoes-subcategorias {
        border: none !important;
    }

    .btn-cadastro:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    .btn-cadastro:active {
        transform: scale(0.98);
    }

    .btn-cadastro.deletar {
        height: 40px;
        width: 150px;
        background-color: #f44336;
        /* Vermelho para deletar */
    }

    .btn-cadastro.deletar:hover {
        background-color: #e53935;
    }

    /* Estilos para ícones */
    .btn-cadastro i {
        font-size: 18px;
    }

    /* Flex para centralizar e espaçar os botões */
    .form-btn-container {
        width: 100%;
        align-items: center;
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }

    .form-btn-container form button {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100% !important;
    }

    .subcategoria-item {
        list-style: none;
        width: 98% !important;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
        margin-bottom: 10px;
        background-color: #f9f9f9;
        /* Leve cor de fundo para destacar */
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Sombra leve */
        transition: all 0.3s ease;
        /* Transição suave para hover */
    }

    .subcategoria-item:hover {
        background-color: #e0e0e0;
        /* Cor de fundo no hover */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        /* Sombra mais intensa no hover */
        transform: translateY(-3px);
        /* Leve movimentação no hover */
    }

    .form-btn-container button {
        background-color: #d9534f;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .form-btn-container button:hover {
        background-color: #c9302c;
        /* Efeito de hover para o botão */
    }
</style>
<div class="main">
    <div class="centralizar">
        <form id="formularioEditarCategoria" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="categoriaId" value="<?php echo $categoriaData['categoria_id']; ?>">
            <div class="row">
                <div class="column">
                    <label for="nomeCategoria">Nome da Categoria:</label>
                    <input type="text" id="nomeCategoria" name="nomeCategoria" value="<?php echo htmlspecialchars($categoriaData['nome_categoria']); ?>" required>
                </div>
                <?php
                if (!empty($categoriaData['imagem_categria'])): ?>
                    <div class="column">
                        <div class="preview-imagem-atual-categoria">
                            <label for="imagemCategoria">Imagem da Categoria:</label>
                            <img src="public/assets/img/categorias/<?php echo $categoriaData['imagem_categria']; ?>" alt="Imagem da Categoria">
                        </div>
                    </div>
                <?php endif; ?>

                <div class="column">
                    <label for="imagemCategoria">Imagem da Categoria:</label>
                    <input type="file" id="imagemCategoria" name="imagemCategoria" required>
                </div>
                <div class="column container-botao-cadastro">
                    <button type="submit" clas="btn-cadastro">Salvar</button>
                </div>
            </div>
        </form>

    </div>
    <div class="container-subcategorias" style="width: 100% !important;">
        <!-- Exibição das Subcategorias Relacionadas -->
        <h3 style="padding-left:15px;">Subcategorias Associadas</h3>
        <div class="subcategorias-list" style="width:100% !important; display: flex; flex-direction:column;">
            <?php if (!empty($subcategorias)) : ?>
                <ul style="width:100% !important; display:flex; justify-content:center;">
                    <?php foreach ($subcategorias as $subcategoria) : ?>
                        <li class="subcategoria-item">
                            <div class="column" style="flex: 1; padding-left:15px;">
                                <strong><?php echo htmlspecialchars($subcategoria['nome_subcategoria']); ?></strong>
                            </div>
                            <div class="column form-btn-container" style="display:flex; justify-content:right !important;">
                                <button
                                    class="btn-cadastro deletar"
                                    data-subcategoria-id="<?php echo htmlspecialchars($subcategoria['subcategoria_id']); ?>"
                                    data-nome-subcategoria="<?php echo htmlspecialchars($subcategoria['nome_subcategoria']); ?>"
                                    data-imagem-subcategoria="<?php echo htmlspecialchars($subcategoria['imagem_subcategoria']); ?>">
                                    <i class="fa fa-trash"></i> Deletar
                                </button>

                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p style="padding-left:15px;">Não há subcategorias associadas a esta categoria.</p>
            <?php endif; ?>
        </div>
    </div>

</div>
</div>
<script>
// Função de exclusão de subcategoria com AJAX
function confirmarExclusao(button) {
    const subcategoriaId = button.getAttribute('data-subcategoria-id');
    const nomeSubcategoria = button.getAttribute('data-nome-subcategoria');
    const imagemSubcategoria = button.getAttribute('data-imagem-subcategoria');

    console.log("ID da subcategoria:", subcategoriaId);
    console.log("Nome da subcategoria:", nomeSubcategoria);
    console.log("Imagem da subcategoria:", imagemSubcategoria);

    if (confirm(`Tem certeza que deseja deletar a subcategoria "${nomeSubcategoria}"?`)) {
        // Dados do formulário
        const formData = new FormData();
        formData.append('subcategoria_id', subcategoriaId);
        formData.append('imagemsubcategoria', imagemSubcategoria);

        // Desabilita o botão para evitar cliques múltiplos
        button.disabled = true;

        // Fazendo a requisição AJAX para excluir a subcategoria
        fetch('excluirSubcategoria', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Converte a resposta JSON
        .then(data => {
            // Exibe a resposta no alert
            alert(data.message || data.error);

            // Após o alert, a página é atualizada
            if (data.success) {
                window.location.reload();
            } else {
                // Reativa o botão em caso de falha
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Erro na exclusão:', error);
            alert('Ocorreu um erro ao tentar excluir a subcategoria.');
            // Reativa o botão em caso de erro
            button.disabled = false;
        });
    }
}

// Associa o evento de exclusão aos botões de deletar
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-cadastro.deletar');
    deleteButtons.forEach(button => {
        // Define a função que será chamada ao clicar
        button.addEventListener('click', function(event) {
            event.preventDefault();
            confirmarExclusao(button);
        });
    });
});

</script>