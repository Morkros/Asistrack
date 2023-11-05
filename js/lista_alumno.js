document.addEventListener("DOMContentLoaded", function() {
  // Obtener todos los botones de eliminar
  var btnEliminar = document.querySelectorAll(".btn-eliminar");

  // Agregar un evento de clic a cada botón de eliminar
  btnEliminar.forEach(function(btn) {
    btn.addEventListener("click", function() {
      var alumnoId = this.getAttribute("data-alumno-id");
      var fila = this.closest("tr");

      // Eliminar la fila del alumno de la tabla
      fila.remove();

      // Crear una nueva solicitud HTTP utilizando fetch
      fetch("alumno/deleteAlumno.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "alumnoId=" + encodeURIComponent(alumnoId)
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
