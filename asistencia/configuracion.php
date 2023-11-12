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
        <li class="nav-item  ms-2 mr-2">
          <a class="nav-link active">Calendario</a>
        </li>
        <!-- <li class="nav-item ms-2 mr-2">
          <a class="nav-link" href="../profesor/index.php">Profesor</a>
        </li> -->
      </ul>
      <ul class="navbar-nav ms-auto">
      <a class="nav-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
          </svg>
        </a>
        <li class="nav-item ms-2 mr-2 mt-1">
          <a class="navbar-brand">AsisTrack</a>
        </li>
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
