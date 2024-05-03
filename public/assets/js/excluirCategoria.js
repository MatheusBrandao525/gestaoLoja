document.addEventListener("DOMContentLoaded", function () {
  const botoesExcluir = document.querySelectorAll(".btn-excluir");

  botoesExcluir.forEach(function (botao) {
    botao.addEventListener("click", function () {
      const categoriaId = this.getAttribute("data-categoria-id");
      const imagemCategoria = this.getAttribute("data-imagem-categoria");
      if (confirm("Tem certeza que deseja excluir esta categoria?")) {
        fetch("excluirCategoria", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            categoriaId: categoriaId,
            imagemCategoria: imagemCategoria,
          }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              alert("Categoria excluída com sucesso!");
              window.location.reload(); // Recarrega a página para atualizar a lista
            } else {
              alert("Erro ao excluir a categoria: " + data.error);
            }
          })
          .catch((error) => {
            console.error("Erro:", error);
            alert("Erro ao excluir categoria.");
          });
      }
    });
  });
});
