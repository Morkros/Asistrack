<?php
require_once('../db/autoload.php');
$datosProfesor = new profesor();
$baseDatos = new db();
$baseDatos->conectar();

$sql = "SELECT promocion, regular FROM parametros";
$resultado = $baseDatos->connect()->query($sql);

if ($resultado->num_rows > 0) {
  $row = $resultado->fetch_assoc();
  $porcentajePromocion = $row["promocion"];
  $porcentajeRegular = $row["regular"];
} else {
  // Manejar el caso en que no se encuentren los porcentajes en la base de datos
  $porcentajePromocion = "";
  $porcentajeRegular = "";
}

// Obtener los días de clases de la base de datos
$sql = "SELECT dias_clases FROM parametros";
$resultado = $baseDatos->connect()->query($sql);

if ($resultado->num_rows > 0) {
  $row = $resultado->fetch_assoc();
  $diasClases = $row["dias_clases"];
} else {
  // Manejar el caso en que no se encuentren los días de clases en la base de datos
  $diasClases = "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["confirmar"])) {
    // Acción para actualizar el porcentaje de promoción
    if (isset($_POST["promocion"])) {
      $porcentajePromocion = $_POST["promocion"];
      $datosProfesor->updatePorcentajePromocion($baseDatos, $porcentajePromocion);
    }

    // Acción para actualizar el porcentaje regular
    if (isset($_POST["regular"])) {
      $porcentajeRegular = $_POST["regular"];
      $datosProfesor->updatePorcentajeRegular($baseDatos, $porcentajeRegular);
    }

    // Acción para actualizar los días de clases
    if (isset($_POST["dias"])) {
      $diasClases = $_POST["dias"];
      $datosProfesor->updateDiasClases($baseDatos, $diasClases);
    }
  }

}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Configuración</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
  <div class="container">
    <h1>Configuración</h1>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item ms-2 mr-2">
          <a class="nav-link" href="../index.php">Alumno</a>
        </li>
        <li class="nav-item ms-2 mr-2">
          <a class="nav-link" href="../profesor/index.php">Profesor</a>
        </li>
        <li class="nav-item ms-2 mr-2">
          <a class="nav-link active">Configuración</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="navbar-brand">AsisTrack</a>
      </ul>
    </nav>

    <div class="mt-3">
      <form method="POST" action="">

      <div class="mt-3">
        <div class="form-group">
          <label for="promocion">Porcentaje Promoción:</label>
          <input type="text" class="form-control" name="promocion" value="<?php echo $porcentajePromocion; ?>">

      <div class="mt-3">
        <div class="form-group">
          <label for="regular">Porcentaje Regular:</label>
          <input type="text" class="form-control" name="regular" value="<?php echo $porcentajeRegular; ?>">
     
      <div class="mt-3">
        <div class="form-group">
          <label for="dias">Días de Clase:</label>
          <input type="text" class="form-control" name="dias" value="<?php echo $diasClases; ?>">
         </div>

      <div class="mt-3">
        <button type="submit" class="btn btn-primary" name="confirmar">Confirmar</button>
      </form>
    </div>



  <script src="../js/bootstrap.js"></script>
</body>
</html>
