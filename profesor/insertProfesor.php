<?php
require_once('../db/autoload.php');
$datosProfesor = new profesor();
$baseDatos = new db();
$baseDatos->conectar();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Formulario de Alta de profesor</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/sweetalert2.css">
</head>
<body>
  <div class="container">
    <h1>Formulario de Alta de profesor</h1>
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

      <button type="submit" class="btn btn-primary">Agregar profesor</button>
      <td><a href='../index.php' class='btn btn-danger btn-eliminar'>Volver</a></td>
    </form>
  </div>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/sweetalert2.js"></script>
</body>
</html>

<?php
// Verificar si se ha enviado el formulario de alta de profesor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];
  $dni = $_POST["dni"];
  $nacimiento = $_POST["nacimiento"];

  if (!empty($nombre) && !empty($apellido) && !empty($dni) && !empty($nacimiento)) {
    $datosProfesor->insertProfesor($baseDatos, $nombre, $apellido, $dni, $nacimiento);
  } else {
    echo '<script language="javascript">Swal.fire({title: "Error", 
      text: "Por favor, complete todos los campos obligatorios.", 
      icon: "error", 
      confirmButtonColor: "#007bff"});</script>';
  }
}
?>