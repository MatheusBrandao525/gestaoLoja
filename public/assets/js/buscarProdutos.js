function pesquisaProdutos() {
    var valor = $('#busca').val();

    console.log(valor);
    $.ajax({
        url: 'processarPesquisaProdutos',
        type: 'POST',
        data: { pesquisa: valor },
        success: function(data) {
            $('.produtos-container').html(data);
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
});
