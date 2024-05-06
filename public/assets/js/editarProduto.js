document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formularioEditarProduto");
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(form);
    const url = "alterarDadosProduto";
    if (confirm("Tem certeza que deseja Alterar este Produto?")) {
      fetch(url, {
        method: "POST",
        body: formData,
        headers: {},
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Sucesso:", data);
          alert("Produto alterado com sucesso!");
          window.location.reload();
        })
        .catch((error) => {
          console.error("Erro:", error);
          alert("Erro ao alterar produto. Tente novamente.");
        });
    }
  });
});


document.addEventListener('DOMContentLoaded', function() {
  var deleteIcons = document.querySelectorAll('.icone-apagar-imagem-produto');
  deleteIcons.forEach(function(icon) {
      icon.addEventListener('click', function() {
          var imagemId = this.getAttribute('data-imagem-id');
          var produtoId = this.getAttribute('data-produto-id');
          if (confirm('Você realmente deseja excluir esta imagem?')) {
              var xhr = new XMLHttpRequest();
              xhr.open('POST', 'excluirImagemProduto', true);
              xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
              xhr.onload = function() {
                  if (xhr.status === 200) {
                      alert('Imagem excluída com sucesso!');
                      console.log(this.response);
                      window.location.reload();
                  } else {
                      alert('Erro ao excluir imagem.');
                  }
              };
              xhr.send('produtoId=' + produtoId + '&imagem=' + imagemId);
          }
      });
  });
});