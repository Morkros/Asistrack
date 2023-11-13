<?php
require_once('../db/autoload.php');
$datosAlumno = new alumno();
$baseDatos = new db();
$baseDatos->conectar();

// Verificar si se ha enviado el formulario de alta de alumno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $dni_alumno = $_POST["dni_alumno"];
  $fecha = $_POST["fecha"];

  if (!empty($dni_alumno) && !empty($fecha)) {
    $datosAlumno->insertAsistencia($baseDatos, $dni_alumno, $fecha);
  }
}

if (isset($_GET["id"])) {
  $alumnoId = $_GET["id"];

  // Obtener el dni del alumno utilizando el id
  $alumno = $datosAlumno->getAlumno($baseDatos, $alumnoId);
  $dni_alumno = $alumno["dni"];
} else {
  // Si no se obtiene,redirigir a la página de consulta de alumnos
  header("Location: ../index.php");
  exit();
}

?>



<!DOCTYPE html>
<html>
<head>
  <title>Asistencia</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>


  <div class="container">
    <h1>Asistencia</h1>
    
    <div class="mt-3">
    <form method="POST" action="">
    <div class="form-group">
        <label for="dni_alumno">DNI:</label>
        <input type="text" class="form-control" name="dni_alumno" value="<?php echo $dni_alumno; ?>" readonly>
    </div>

      <div class="form-group">
        <label for="fecha">Fecha de Nacimiento:</label>
        <input type="date" class="form-control" name="fecha" required>
      </div>

      <button type="submit" class="btn btn-primary mt-3">Agregar Asistencia</button>
      <td><a href='../index.php' class='btn btn-danger btn-eliminar mt-3'>Volver</a></td>
    </form>
    </div>
    <script src="../js/bootstrap.min.js"></script>
  </div>
</body>
</html>
