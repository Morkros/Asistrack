<?php
require_once('../db/autoload.php');
$baseDatos = new db();
$baseDatos->conectar();
$datosProfesor = new profesor();

// Verificar si se ha enviado el formulario de modificación de profesor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $profesorId = $_POST["profesorId"];
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];
  $dni = $_POST["dni"];
  $nacimiento = $_POST["nacimiento"];

  $datosProfesor->updateProfesor($baseDatos, $profesorId, $nombre, $apellido, $dni, $nacimiento);

} else {
  // Obtener el ID del profesor a modificar
  $profesorId = $_GET["id"];

  // Obtener los datos del profesor de la base de datos
  $sql = "SELECT * FROM profesores WHERE id = $profesorId";
  //$result = $baseDatos->connect()->query($sql);
  $result = $datosProfesor->consultar($baseDatos, $sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row["nombre"];
    $apellido = $row["apellido"];
    $dni = $row["dni"];
    $nacimiento = $row["nacimiento"];
  } else {
    echo "No se encontró el profesor.";
    exit;
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Modificar Datos de profesor</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
  <div class="container">
    <h1>Modificar Datos de profesor</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <div class="form-group">
        <label for="profesorId">ID del profesor:</label>
        <input type="text" class="form-control" id="profesorId" name="profesorId" value="<?php echo $profesorId; ?>" required>
      </div>
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
      </div>
      <div class="form-group">
        <label for="apellido">Apellido:</label>
        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
      </div>
      <div class="form-group">
        <label for="dni">DNI:</label>
        <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $dni; ?>" required>
      </div>
      <div class="form-group">
        <label for="nacimiento">Fecha de Nacimiento:</label>
        <input type="date" class="form-control" id="nacimiento" name="nacimiento" value="<?php echo $nacimiento; ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Modificar</button>
      <td><a href='../index.php' class='btn btn-danger btn-eliminar'>Volver</a></td>
    </form>
  </div>
  <script src="../js/bootstrap.js"></script>
</body>
</html>