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

.btn-detail, .btn-edit, .btn-delete,.btn-despachar {
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

table th, table td {
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

.status.concluido{
    background-color: #02d937;
}

.pagination {
    text-align: center;
}

.pagination .btn {
    margin: 0 2px;
}
</style>
<div class="main">
    <div class="centralizar">
    <div class="container-pedidos-realizados">
        <div class="header-pedidos">
            <h1>Pedidos Entregues</h1>
        </div>
        <div class="order-summary">
            <span>Total de Pedidos Entregues: 15</span>
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
                    <th>Status Entrega</th>
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
                    <td><span class="status concluido">Entregue</span></td>
                    <td>
                        <button class="btn btn-detail">Detalhes</button>
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
                    <td><span class="status concluido">Entregue</span></td>
                    <td>
                        <button class="btn btn-detail">Detalhes</button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Felipe Silva</td>
                    <td>Cartão</td>
                    <td>R$ 70,00</td>
                    <td>2</td>
                    <td>R$ 140,00</td>
                    <td>22-05-2024</td>
                    <td><span class="status concluido">Entregue</span></td>
                    <td>
                        <button class="btn btn-detail">Detalhes</button>
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
    </div>

</div>
</div>
<?php
require_once 'components/footer.php';
?>