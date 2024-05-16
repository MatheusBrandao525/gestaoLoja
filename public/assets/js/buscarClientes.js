function pesquisaClientes() {
    var valor = $('#buscaClientes').val();

    console.log(valor);
    $.ajax({
        url: 'processarPesquisaClientes',
        type: 'POST',
        data: { pesquisa: valor },
        success: function(data) {
            $('.clientes-container').html(data);
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
});
