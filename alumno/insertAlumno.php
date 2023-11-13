<?php
require_once('../db/autoload.php');
$datosAlumno = new alumno();
$baseDatos = new db();
$baseDatos->conectar();
date_default_timezone_set('America/Argentina/Buenos_Aires');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Formulario de Alta de Alumno</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/sweetalert2.css">
</head>
<body>
  <div class="container">
    <h1>Formulario de Alta de Alumno</h1>
    <form method="POST" action="">
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" class="form-control" name="nombre" required>
      </div>

      <div class="form-group">
        <label for="apellido">Apellido:</label>
        <input type="text" class="form-control" name="apellido" required>
      </div>

      <div class="form-group">
        <label for="dni">DNI:</label>
        <input type="text" class="form-control" name="dni" required>
      </div>

      <div class="form-group">
        <label for="nacimiento">Fecha de Nacimiento:</label>
        <input type="date" class="form-control" name="nacimiento" required>
      </div>

      <button type="submit" class="btn btn-primary mt-2">Agregar Alumno</button>
      <td><a href='../index.php' class='btn btn-danger btn-eliminar mt-2'>Volver</a></td>
    </form>
  </div>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/sweetalert2.js"></script>
</body>
</html>

<?php
// Verificar si se ha enviado el formulario de alta de alumno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = trim($_POST["nombre"]);
  $apellido = trim($_POST["apellido"]);
  $dni = trim($_POST["dni"]);
  $nacimiento = trim($_POST["nacimiento"]);

  // Comprobar campos vacíos
  if (empty($nombre) || empty($apellido) || empty($dni) || empty($nacimiento)) {
      mostrarError("Por favor, complete todos los campos obligatorios.");
  } else {
      // Comprobar edad mayor o igual a 17 años
      $fechaNacimiento = strtotime($nacimiento);
      $fechaActual = time();
      if ($fechaActual - $fechaNacimiento < 17 * 31536000) {
          mostrarError("La fecha ingresada es menor a 17 años de edad.");
      } else {
          // Comprobar nombre y apellido alfabéticos
          if (!ctype_alpha(str_replace(' ', '', $nombre))) {
              mostrarError("Por favor, ingrese un nombre válido.");
          } else if (!ctype_alpha(str_replace(' ', '', $apellido))) {
              mostrarError("Por favor, ingrese un apellido válido.");
          } else {
              // Comprobar DNI numérico y de longitud 8
              if (!is_numeric($dni) || strlen($dni) != 8) {
                  mostrarError("El DNI ingresado es inválido");
              } else {
                  $datosAlumno->insertAlumno($baseDatos, $nombre, $apellido, $dni, $nacimiento);
              }
          }
      }
  }
}

function mostrarError($mensaje) {
  echo '<script language="javascript">Swal.fire({
      title: "Error",
      text: "' . $mensaje . '",
      icon: "error",
      confirmButtonColor: "#007bff"
  });</script>';
}
?>




