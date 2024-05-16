document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.custom-categoria-upload').addEventListener('click', function () {
        document.getElementById('real-file').click();
    });

    document.getElementById('real-file').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            document.querySelector('.categoria-upload-preview').textContent = file.name;
        } else {
            document.querySelector('.categoria-upload-preview').textContent = '';
        }
    });
});

$(document).ready(function () {
    $('.form-importar-categorias').submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var fileInput = $('#real-file'); // Seleciona o input de arquivo

        // Verifica se o campo de arquivo está vazio
        if (!fileInput.val()) {
            alert('Por favor, selecione um arquivo para importar.');
            return; // Interrompe o envio da requisição
        }

        var formData = new FormData(form[0]);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('.mensagem-importacao-categorias p').text(response);
                setTimeout(function() {
                    $('.mensagem-importacao-categorias p').fadeOut();
                }, 5000);
                form[0].reset();
                $('.categoria-upload-preview').text(''); // Limpa o conteúdo do campo de upload de arquivo
            },
            error: function (xhr, status, error) {
                $('.mensagem-importacao-categorias p').text('Erro ao importar categorias: ' + error);
            }
        });
    });
});
