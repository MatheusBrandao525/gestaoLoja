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