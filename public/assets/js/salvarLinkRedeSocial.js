$(document).ready(function () {
    $('.form-container-config').submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            success: function (response) {
                alert(response);
            },
            error: function (xhr, status, error) {
                alert('Erro ao salvar a rede social: ' + error);
            }
        });
    });
});
