<?php
require_once 'components/menuLateral.php';
?>
<style>
.container-pedidos-realizados {
    width: 98%;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
}

.header-pedidos {
    text-align: center;
    margin-bottom: 20px;
}

.actions {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.btn {
    padding: 10px 15px;
    border: none;
    background-color: #ccc;
    cursor: pointer;
    margin: 0 5px;
    border-radius: 5px;
}

.btn-primary {
    background-color: #4CAF50;
    color: white;
}

.btn-detail,
.btn-edit,
.btn-delete,
.btn-despachar {
    padding: 5px 10px;
    margin: 0 2px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.btn-detail {
    background-color: #5bc0de;
    color: white;
}

.btn-edit {
    background-color: #f0ad4e;
    color: white;
}

.btn-delete {
    background-color: #d9534f;
    color: white;
}

.btn-despachar {
    background-color: #2dab58;
    color: white;
}

.order-summary {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.2em;
}

.search {
    text-align: right;
    margin-bottom: 10px;
}

.search input {
    padding: 5px;
    width: 200px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th,
table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

table th {
    background-color: #f2f2f2;
}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tbody tr:hover {
    background-color: #f1f1f1;
}

.status {
    padding: 5px 10px;
    border-radius: 3px;
    color: white;
}

.status.approved {
    background-color: #5cb85c;
}

.status.pending {
    background-color: #f0ad4e;
}

.status.cancelled {
    background-color: #d9534f;
}

.pagination {
    text-align: center;
}

.pagination .btn {
    margin: 0 2px;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.modal-body {
    padding: 10px 0;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
}

.modal-footer .btn {
    margin-left: 10px;
}

.signature-section {
    display: flex;
    justify-content: space-around;
    margin-top: 40px;
}

.signature-section p {
    text-align: center;
    margin: 20px 0;
}

.btn {
    padding: 10px 20px;
    margin: 5px;
    cursor: pointer;
}

.btn-primary {
    background-color: blue;
    color: white;
}


@media print {

    /* Esconder elementos que não devem aparecer na impressão */
    .modal-header .close,
    .modal-footer {
        display: none;
    }

    /* Ajustar margens e padding para impressão */
    body {
        margin: 0;
        padding: 10mm;
    }

    /* Estilizar o texto e conteúdo principal para impressão */
    .modal-content {
        border: none;
        box-shadow: none;
        width: 100%;
        /* Garantir que a largura seja 100% */
        margin: 0;
        /* Remover margens */
        padding: 0;
        /* Remover padding */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .signature-section {
        display: flex;
        justify-content: space-around;
        margin-top: 40px;
    }

    .signature-section p {
        text-align: center;
        margin: 20px 0;
    }
}
</style>
<div class="main">
    <div class="centralizar">
        <div class="container-pedidos-realizados">
            <div class="header-pedidos">
                <h1>Gerenciar Pedidos</h1>
            </div>
            <div class="order-summary">
                <span>Total de Pedidos: 15</span>
            </div>
            <div class="search">
                <input type="text" placeholder="Pesquisar...">
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Forma de Pagamento</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Preço Total</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>João Silva</td>
                        <td>Cartão</td>
                        <td>R$ 50,00</td>
                        <td>2</td>
                        <td>R$ 100,00</td>
                        <td>22-05-2024</td>
                        <td><span class="status approved">Aprovado</span></td>
                        <td>
                            <button class="btn btn-detail" onclick="openModal()">Detalhes</button>
                            <button class="btn btn-edit">Editar</button>
                            <button class="btn btn-delete">Excluir</button>
                            <button class="btn btn-despachar">Despachar Entrega</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Maria Oliveira</td>
                        <td>PIX</td>
                        <td>R$ 1,50</td>
                        <td>10</td>
                        <td>R$ 15,00</td>
                        <td>21-05-2024</td>
                        <td><span class="status pending">Pendente</span></td>
                        <td>
                            <button class="btn btn-detail" onclick="openModal()">Detalhes</button>
                            <button class="btn btn-edit">Editar</button>
                            <button class="btn btn-delete">Excluir</button>
                            <button class="btn btn-despachar">Despachar Entrega</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination">
                <button class="btn">Primeiro</button>
                <button class="btn">Anterior</button>
                <button class="btn">1</button>
                <button class="btn">2</button>
                <button class="btn">Próximo</button>
                <button class="btn">Último</button>
            </div>
        </div>
        <div id="orderModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Detalhes do Pedido</h2>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <th>Nome do Cliente:</th>
                            <td>Maria Oliveira</td>
                        </tr>
                        <tr>
                            <th>CPF:</th>
                            <td>123.456.789-00</td>
                        </tr>
                        <tr>
                            <th>Telefone:</th>
                            <td>(11) 98765-4321</td>
                        </tr>
                        <tr>
                            <th>Endereço:</th>
                            <td>Rua das Flores, 123, São Paulo - SP</td>
                        </tr>
                    </table>
                    <h3>Produtos do Pedido</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço Unitário</th>
                                <th>Preço Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Caneta Bic</td>
                                <td>10</td>
                                <td>R$ 1,50</td>
                                <td>R$ 15,00</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="signature-section">
                        <p> __________________________ </br>Assinatura do Entregador</p>
                        <p> ________/_________/_________ </br>Data e Hora</p>
                        <p> __________________________ </br>Assinatura do Cliente</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" onclick="closeModal()">Fechar</button>
                    <button class="btn btn-primary" onclick="printOrder()">Imprimir</button>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<script>
function openModal() {
    document.getElementById('orderModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('orderModal').style.display = 'none';
}

function printOrder() {
    window.print();
}

window.onclick = function(event) {
    if (event.target == document.getElementById('orderModal')) {
        closeModal();
    }
}
</script>

<?php
require_once 'components/footer.php';
?>