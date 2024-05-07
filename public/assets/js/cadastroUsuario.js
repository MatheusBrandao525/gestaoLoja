document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('foto').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var uploadText = document.querySelector('.upload-box p');
                uploadText.textContent = 'Arquivo selecionado: ' + file.name;
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });


const form = document.getElementById("formularioCadastroUsuario");
form.addEventListener("submit", function (event) {
  event.preventDefault();

  const formData = new FormData(form);
  const url = "cadastrarUsuario";
    fetch(url, {
      method: "POST",
      body: formData,
      headers: {},
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Sucesso:", data);
        alert("Usuário cadastrado com sucesso!");
        window.location.reload();
      })
      .catch((error) => {
        console.error("Erro:", error);
        alert("Erro ao cadastrar usuário. Tente novamente.");
      });
});

});