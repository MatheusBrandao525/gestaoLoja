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
        })
        .catch((error) => {
          console.error("Erro:", error);
          alert("Erro ao alterar produto. Tente novamente.");
        });
    }
  });
});
