<?php
require_once('../db/autoload.php');
$baseDatos = new db();
$baseDatos->conectar();
$datosAlumno = new alumno();

// Verificar si se ha enviado el formulario de modificación de alumno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $alumnoId = $_POST["alumnoId"];
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];
  $dni = $_POST["dni"];
  $nacimiento = $_POST["nacimiento"];

  $datosAlumno->updateAlumno($baseDatos, $alumnoId, $nombre, $apellido, $dni, $nacimiento);

} else {
  // Obtener el ID del alumno a modificar
  $alumnoId = $_GET["id"];

  // Obtener los datos del alumno de la base de datos
  $sql = "SELECT * FROM alumnos WHERE id = $alumnoId";
  //$result = $baseDatos->connect()->query($sql);
  $result = $datosAlumno->consultar($baseDatos, $sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row["nombre"];
    $apellido = $row["apellido"];
    $dni = $row["dni"];
    $nacimiento = $row["nacimiento"];
  } else {
    echo "No se encontró el alumno.";
    exit;
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Modificar Datos de Alumno</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Modificar Datos de Alumno</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <div class="form-group" style="display: none;">
        <label for="alumnoId">ID del Alumno:</label>
        <input type="text" class="form-control" id="alumnoId" name="alumnoId" value="<?php echo $alumnoId; ?>" required>
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
</body>
</html>