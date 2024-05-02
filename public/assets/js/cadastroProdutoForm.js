document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formularioCadastroProduto");
  form.addEventListener("submit", function (event) {
    alert("Evento de submit capturado!");
    event.preventDefault(); // Impede a submissão padrão do formulário

    const formData = new FormData(form); // Coleta os dados do formulário
    const url = "cadastrarProdutoDatabase"; // URL para onde os dados do formulário serão enviados

    fetch(url, {
      method: "POST", // ou 'GET' se necessário
      body: formData, // Os dados coletados do formulário
      headers: {
        // Especifique cabeçalhos se necessário
      },
    })
      .then((response) => response.json()) // Converte a resposta do servidor em JSON
      .then((data) => {
        console.log("Sucesso:", data);
        alert("Produto cadastrado com sucesso!");
        form.reset(); // Limpa o formulário após o envio
      })
      .catch((error) => {
        console.error("Erro:", error);
        alert("Erro ao cadastrar produto. Tente novamente.");
      });
  });
});
