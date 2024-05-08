document.addEventListener("DOMContentLoaded", function () {
  const botoesExcluir = document.querySelectorAll(".btn-excluir-usuario");

  botoesExcluir.forEach(function (botao) {
    botao.addEventListener("click", function () {
      const usuarioId = this.getAttribute("data-usuario-id");
      const fotoUsuario = this.getAttribute("data-foto-usuario");
      if (confirm("Tem certeza que deseja excluir este usuário?")) {
        fetch("excluirUsuario", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            usuarioId: usuarioId,
            fotoUsuario: fotoUsuario,
          }),
        })
          .then((response) => response.json()) // Agora estamos pegando a resposta como JSON diretamente
          .then((data) => {
            if (data.success) {
              alert("Usuário excluído com sucesso!");
              window.location.reload(); // Recarrega a página para atualizar a lista
            } else {
              alert("Erro ao excluir o usuário: " + data.error);
            }
          })
          .catch((error) => {
            console.error("Erro:", error);
            alert("Erro ao excluir usuário.");
          });
      }
    });
  });
});
