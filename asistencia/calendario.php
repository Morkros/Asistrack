<?php
require_once('../db/autoload.php');
$datosAlumno = new alumno();
$baseDatos = new db();
$baseDatos->conectar();

?>
<!DOCTYPE html>
<html>
<head>

<title>Consulta de Alumnos</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/sweetalert2.css">
</head>
<body>
<div class="container">
    <h1>Asistencias por Fecha</h1>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item  ms-2 mr-2">
          <a class="nav-link ">Alumno</a>
        </li>
        <li class="nav-item  ms-2 mr-2">
          <a class="nav-link active">Calendario</a>
        </li>
        <!-- </li>
         <li class="nav-item ms-2 mr-2">
          <a class="nav-link" href="./profesor/index.php">Profesor</a>
       </li> -->
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item ms-2 mr-2">
          <!-- Icono "gear" de bootstrap -->
        <a class="nav-link" href="./asistencia/configuracion.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
          </svg>
        </a>
        </li>
        <li class="nav-item ms-2 mr-2 mt-1">
          <a class="navbar-brand">AsisTrack</a>
        </li>
      </ul>
    </nav>

    <div class="text-center mt-5">
      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="form-group">
        <p><label for="fecha_buscar">Seleccionar Fecha:</label></p>
        <input type="date" id="fecha_buscar" name="fecha_buscar">
      </div>
      <button type="submit" class="btn btn-primary mt-3 mb-5">Buscar</button>
    </form>
    </div>

  
    <?php
    // Verificar si se ha enviado el formulario de búsqueda
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fecha_buscar"])) {
      $fechaBusqueda = $_POST["fecha_buscar"];
      // Consulta SQL para obtener las asistencias de todos los alumnos en la fecha seleccionada
      $sql = "SELECT a.nombre, a.apellido, asis.fecha 
              FROM Alumnos a 
              LEFT JOIN Asistencias asis ON a.dni = asis.dni_alumno 
              WHERE DATE(asis.fecha) = '$fechaBusqueda'";
      // Ejecutar la consulta y procesar los resultados
      $resultado = $datosAlumno->consultar($baseDatos, $sql);
      // Mostrar los resultados en una tabla
      if (mysqli_num_rows($resultado) > 0) {
        echo "<table class='table'>";
        echo "<thead><tr><th>Nombre</th><th>Apellido</th><th>Fecha de Asistencia</th></tr></thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($resultado)) {
          $fechaFormato = date_create($row["fecha"]);
          echo "<tr>";
          echo "<td>" . $row["nombre"] . "</td>";
          echo "<td>" . $row["apellido"] . "</td>";
          echo "<td>" . date_format($fechaFormato, "d/m/Y H:i:s" ) . "</td>";
          echo "</tr>";
        }
        echo "</tbody></table>";
      } else { 
        echo "<div class='text-center mt-2'>No se encontraron asistencias para la fecha seleccionada.</div>";
      }
    } elseif (empty($fechaBusqueda)) {
        echo "<div class='text-center mt-2'>Porfavor, ingresar fecha.</div>";
    }
    ?>
  </div>
  <script src="../js/sweetalert2.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>


