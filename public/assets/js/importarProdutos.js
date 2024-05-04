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
});


