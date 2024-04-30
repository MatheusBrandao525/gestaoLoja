<div class="centralizar">
    <form action="/submit-your-form-handler" method="post">
        <div class="row">
            <div class="column">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="column">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" required>
            </div>
            <div class="column">
                <label for="precoCusto">Preço de Custo:</label>
                <input type="number" id="precoCusto" name="precoCusto" required>
            </div>
            <div class="column">
                <label for="precoUnitario">Preço Unitário:</label>
                <input type="number" id="precoUnitario" name="precoUnitario" required>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <label for="modelos">Modelos:</label>
                <input type="text" id="modelos" name="modelos" required>
            </div>
            <div class="column">
                <label for="cor">Cor:</label>
                <input type="text" id="cor" name="cor" required>
            </div>
            <div class="column">
                <label for="destaque">É Destaque?</label>
                <select id="destaque" name="destaque" required>
                    <option value="">Selecionar...</option>
                    <option value="sim">Sim</option>
                    <option value="nao">Não</option>
                </select>
            </div>
            <div class="column">
                <label for="tamanhos">Tamanhos:</label>
                <input type="text" id="tamanhos" name="tamanhos" required>
            </div>
        </div>
        <div class="full-width">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required></textarea>
        </div>
        <div class="full-width">
            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem" name="imagem" required>
        </div>
        <div class="full-width container-botao-cadastro">
            <button type="submit">Cadastrar</button>
        </div>
    </form>
</div>