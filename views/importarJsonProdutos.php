<?php
require_once 'components/menuLateral.php';
require_once 'controllers/CategoriaController.php';

$categoriaController = new CategoriaController();
$todasAsCategorias = $categoriaController->exibirTodasAsCategorias();
?>
<div class="main">
    <div class="centralizar alinhamento-coluna">

        <div class="coluna-inteira">
            <div class="coluna-metade">
                <h4>Importar produtos</h4>
                <form class="form-importar-produtos" action="processarProdutosImportados" method="POST" enctype="multipart/form-data">

                    <!-- Select para escolha do grupo -->
                    <div class="row">
                        <div class="column">
                            <label for="grupo-produto">Selecione o grupo de produtos:</label>
                            <select id="grupo-produto" name="grupoProduto" required>
                                <option value="" disabled selected>Escolha um grupo</option>
                                <?php foreach ($todasAsCategorias as $categoria): ?>
                                    <option value="<?php echo $categoria['categoria_id']; ?>"><?php echo $categoria['nome_categoria']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Select para escolha do subgrupo -->
                    <div class="row">
                        <div class="column">
                            <label for="subgrupo-produto">Selecione o subgrupo de produtos:</label>
                            <select id="subgrupo-produto" name="subgrupoProduto" required>
                                <option value="" disabled selected>Escolha um subgrupo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Campo de upload de arquivo -->
                    <div class="row">
                        <div class="column">
                            <div class="file-upload-wrapper">
                                <input type="file" id="real-file" hidden="hidden" name="fileUpload" required>
                                <div class="custom-file-upload">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span class="file-upload-text">Clique para adicionar arquivos</span>
                                </div>
                                <div class="file-upload-preview"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Botão de upload -->
                    <div class="column container-botao-upload">
                        <button type="submit" name="uploadBtn">Upload</button>
                    </div>
                </form>
            </div>


            <div class="coluna-metade">
                <div class="mensagem-importacao-produtos">
                    <p></p>
                </div>
            </div>
        </div>
        <div class="coluna-inteira">
            <div class="coluna-metade">
                <h4>Importar Imagens dos produtos</h4>
                <form action="importarImagensProduto" method="POST" enctype="multipart/form-data" class="image-upload-form">
                    <div class="row">
                        <div class="column">
                            <div class="image-upload-wrapper">
                                <input type="file" id="image-upload-file" hidden="hidden" name="imageUpload[]" multiple required>
                                <div class="image-custom-file-upload">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span class="image-file-upload-text">Clique para adicionar imagens</span>
                                </div>
                                <div class="image-file-upload-preview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="column image-upload-btn-container">
                        <button type="submit" class="image-upload-btn">Upload</button>
                    </div>
                </form>
            </div>
            <div class="coluna-metade">
                <div class="mensagem-importacao-imagens">
                    <p></p>
                </div>
            </div>
        </div>


    </div>
</div>
</div>

<script>
// Função para atualizar as opções de subgrupos com base no grupo selecionado
function atualizarSubgrupos(grupoId) {
    const subgrupoSelect = document.getElementById('subgrupo-produto');

    // Limpa as opções atuais
    subgrupoSelect.innerHTML = '<option value="" disabled selected>Escolha um subgrupo</option>';

    // Dados que serão enviados via POST
    const formData = new FormData();
    formData.append('categoria_id', grupoId); // Aqui usamos 'categoria_id' conforme a função PHP espera esse campo

    // Faz a requisição AJAX via POST para buscar os subgrupos
    fetch('exibirsubacategorias', { // Endereço onde a função PHP está disponível
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Tente converter a resposta para JSON
    .then(jsonData => {
        console.log('Resposta do servidor:', jsonData); // Log da resposta no console

        // Continue o processamento normal com os subgrupos
        // Corrigido para verificar 'subgrupos' em vez de 'subcategorias'
        if (jsonData.subgrupos && jsonData.subgrupos.length > 0) {
            jsonData.subgrupos.forEach(subgrupo => { // Alterado para 'subgrupo'
                const option = document.createElement('option');
                option.value = subgrupo.subcategoria_id; // Assumindo que esta chave está correta
                option.textContent = subgrupo.nome_subcategoria; // Assumindo que esta chave está correta
                subgrupoSelect.appendChild(option);
            });
        } else {
            subgrupoSelect.innerHTML = '<option value="" disabled selected>Nenhum subgrupo disponível</option>';
        }
    })
    .catch(error => {
        console.error('Erro ao carregar subgrupos:', error);
    });

    console.log(grupoId); // Mover o console.log aqui, dentro da função
}

// Adiciona um evento no select de grupos para disparar a função ao selecionar um grupo
document.getElementById('grupo-produto').addEventListener('change', function() {
    const grupoId = this.value;
    if (grupoId) {
        atualizarSubgrupos(grupoId);
    }
});
</script>

