function togglePasswordVisibility() {
  var senha = document.getElementById("senha");
  var toggleIcon = document.getElementById("toggle-icon");
  if (senha.type === "password") {
    senha.type = "text";
    toggleIcon.classList.remove("fa-eye-slash");
    toggleIcon.classList.add("fa-eye");
  } else {
    senha.type = "password";
    toggleIcon.classList.remove("fa-eye");
    toggleIcon.classList.add("fa-eye-slash");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  var toggleButton = document.querySelector(".toggle-password");
  if (toggleButton) {
    toggleButton.addEventListener("click", togglePasswordVisibility);
  } else {
    console.error("Button not found");
  }

  var inputFoto = document.getElementById("foto");
  var imagePreview = document.getElementById("imagePreview");

  inputFoto.addEventListener("change", function (event) {
    var file = event.target.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function (e) {
        imagePreview.src = e.target.result;
        imagePreview.style.display = "block"; // Garante que a imagem seja exibida se antes não estava visível
      };
      reader.readAsDataURL(file);
    }
  });
});
