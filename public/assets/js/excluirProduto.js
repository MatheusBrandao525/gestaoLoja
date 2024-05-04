document.addEventListener("DOMContentLoaded", function () {
  const botoesExcluir = document.querySelectorAll(".btn-excluir-produto");

  botoesExcluir.forEach(function (botao) {
    botao.addEventListener("click", function () {
      const produtoId = this.getAttribute("data-produto-id");
      if (confirm("Tem certeza que deseja excluir este produto?")) {
        fetch("excluirProduto", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            produtoId: produtoId,
          }),
        })
          .then((response) => response.json()) // Agora estamos pegando a resposta como JSON diretamente
          .then((data) => {
            if (data.success) {
              alert("Produto excluído com sucesso!");
              window.location.reload(); // Recarrega a página para atualizar a lista
            } else {
              alert("Erro ao excluir o produto: " + data.error);
            }
          })
          .catch((error) => {
            console.error("Erro:", error);
            alert("Erro ao excluir produto.");
          });
      }
    });
  });
});
