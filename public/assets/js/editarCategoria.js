document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formularioEditarCategoria");
    form.addEventListener("submit", function (event) {
      event.preventDefault();
  
      const formData = new FormData(form);
      const url = "editarDadosCategoria";
      if (confirm("Tem certeza que deseja Alterar esta Categoria?")) {
        fetch(url, {
          method: "POST",
          body: formData,
          headers: {},
        })
          .then((response) => response.json())
          .then((data) => {
            console.log("Sucesso:", data);
            alert("Categoria alterada com sucesso!");
            window.location.reload();
          })
          .catch((error) => {
            console.error("Erro:", error);
            alert("Erro ao alterar categoria. Tente novamente.");
          });
      }
    });
  });