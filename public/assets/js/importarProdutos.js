document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.custom-file-upload').addEventListener('click', function() {
        document.getElementById('real-file').click();
    });

    document.getElementById('real-file').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            document.querySelector('.file-upload-preview').textContent = file.name;
        } else {
            document.querySelector('.file-upload-preview').textContent = '';
        }
    });


const customFileUpload = document.querySelector('.image-custom-file-upload');
const realFileInput = document.getElementById('image-upload-file');
const fileUploadPreview = document.querySelector('.image-file-upload-preview');

customFileUpload.addEventListener('click', function() {
    realFileInput.click();
});

realFileInput.addEventListener('change', function() {
    const files = this.files;
    let filenames = Array.from(files).map(file => file.name).join(', ');
    fileUploadPreview.textContent = filenames ? filenames : "Nenhuma imagem selecionada";
});

});


$(document).ready(function () {
    $('.form-importar-produtos').submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var formData = new FormData(form[0]);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('.mensagem-importacao-produtos p').text(response);
                setTimeout(function() {
                    $('.mensagem-importacao-produtos p').fadeOut();
                }, 5000);
                form[0].reset();
                $('.file-upload-preview').text(''); // Limpa o conteúdo do campo de upload de arquivo
            },
            error: function (xhr, status, error) {
                $('.mensagem-importacao-produtos p').text('Erro ao importar produtos: ' + error);
            }
        });
    });
});

$(document).ready(function () {
    $('.image-upload-form').submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var formData = new FormData(form[0]);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('.mensagem-importacao-imagens p').text(response);
                setTimeout(function() {
                    $('.mensagem-importacao-imagens p').fadeOut();
                }, 5000);
                form[0].reset();
                $('.image-file-upload-preview').text(''); // Limpa o conteúdo do campo de upload de imagem
            },
            error: function (xhr, status, error) {
                $('.mensagem-importacao-imagens p').text('Erro ao importar imagens: ' + error);
            }
        });
    });
});
