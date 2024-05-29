document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formularioCadastroProduto");
  const botaoCadastro = document.getElementById("botaoCadastro");

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    
    botaoCadastro.disabled = true;

    const formData = new FormData(form);
    const url = "cadastrarProdutoDatabase";

    fetch(url, {
      method: "POST",
      body: formData,
      headers: {
      },
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Sucesso:", data);
        alert("Produto cadastrado com sucesso!");
        form.reset();
      })
      .catch((error) => {
        console.error("Erro:", error);
        alert("Erro ao cadastrar produto. Tente novamente.");
      })
      .finally(() => {
        botaoCadastro.disabled = false;
      });
  });
});
