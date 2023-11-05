document.addEventListener("DOMContentLoaded", function() {
  // Obtener todos los botones de eliminar
  var btnEliminar = document.querySelectorAll(".btn-eliminar");

  // Agregar un evento de clic a cada botón de eliminar
  btnEliminar.forEach(function(btn) {
    btn.addEventListener("click", function() {
      var profesorId = this.getAttribute("data-profesor-id");
      var fila = this.closest("tr");

      // Eliminar la fila del alumno de la tabla
      fila.remove();

      // Crear una nueva solicitud HTTP utilizando fetch
      fetch("./deleteProfesor.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "profesorId=" + encodeURIComponent(profesorId)
      })
        .then(response => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error("Error al eliminar el alumno");
          }
        })
        .then(data => {
          console.log(data);
        })
        .catch(error => {
          console.error(error);
        });
    });
  });
});
