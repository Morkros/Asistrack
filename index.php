<?php
require_once('db\autoload.php');
$datosAlumno = new alumno();
$baseDatos = new db();
$baseDatos->conectar();
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Verificar si se ha enviado el formulario de búsqueda
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre_buscar"])) {
  $nombreBuscar = $_POST["nombre_buscar"];
  // Realizar la consulta de alumnos filtrando por nombre, apellido o nombre completo
  $sql = "SELECT * FROM alumnos WHERE nombre LIKE '%$nombreBuscar%' OR apellido LIKE '%$nombreBuscar%' OR CONCAT(nombre, ' ', apellido) LIKE '%$nombreBuscar%'";
} else {
  // Consulta para obtener todos los alumnos
  $sql = "SELECT * FROM alumnos ORDER BY apellido";;
}

// Ejecutar la consulta
$result = $datosAlumno->consultar($baseDatos, $sql);

// Obtener la cantidad total de clases según los parámetros establecidos
$sqlParametros = "SELECT dias_clases FROM Parametros";
$resultParametros = $datosAlumno->consultar($baseDatos, $sqlParametros);
$rowParametros = mysqli_fetch_assoc($resultParametros);

// Verificar si se obtuvo un resultado válido
if ($rowParametros && array_key_exists('dias_clases', $rowParametros)) {
    $totalClases = $rowParametros['dias_clases'];
} else {
    // Si $rowParametros es nulo o no tiene la clave 'dias_clases' se le asigna valor
    $totalClases = 0; 
}


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
    <h1>Consulta de Alumnos</h1>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item  ms-2 mr-2">
          <a class="nav-link active">Alumno</a>
        </li>
        <li class="nav-item  ms-2 mr-2">
          <a class="nav-link" href="../asistrack-main/asistencia/calendario.php">Calendario</a>
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
          <input type="text" class="form-control" id="nombre_buscar" name="nombre_buscar" placeholder="Buscar por Nombre">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Buscar</button>
      </form>
    </div>
    <br>
    <table class="table">
      <thead>
        <tr>
          <th>DNI</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Nacimiento</th>
          <th>Porcentaje</th>
          <th><a href='alumno/insertAlumno.php' class='btn btn-primary'>Agregar Alumno</a></th>
          
        </tr>
      </thead>
      <tbody>
      <?php
      
// Mostrar los resultados en la tabla
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $nacimientoFormato = date_create($row["nacimiento"]);
    echo "<tr>";
    echo "<td>" . $row["dni"] . "</td>";
    echo "<td>" . $row["nombre"] . "</td>";
    echo "<td>" . $row["apellido"] . "</td>";
    echo "<td>" . date_format($nacimientoFormato, "d/m/Y") . "</td>";


// Realizar la consulta para obtener los valores de "regular" y "promocion"
$sqlParametros = "SELECT regular, promocion FROM Parametros";
$resultParametros = $datosAlumno->consultar($baseDatos, $sqlParametros);
$rowParametros = mysqli_fetch_assoc($resultParametros);

// Verificar si se obtuvo un resultado válido y si las claves existen
if ($rowParametros && array_key_exists('regular', $rowParametros) && array_key_exists('promocion', $rowParametros)) {
    $valorRegular = $rowParametros['regular'];
    $valorPromocional = $rowParametros['promocion'];
} else {
    // Si $rowParametros es nulo o no contiene las claves 'regular' y 'promocion' se le aigna valor
    $valorRegular = 0; 
    $valorPromocional = 0; 
}


// Calcular el porcentaje de asistencia
$sqlAsistencias = "SELECT COUNT(*) AS asistencias FROM Asistencias WHERE dni_alumno = '" . $row["dni"] . "'";
$resultAsistencias = $datosAlumno->consultar($baseDatos, $sqlAsistencias);
$rowAsistencias = mysqli_fetch_assoc($resultAsistencias);
$asistencias = $rowAsistencias['asistencias'];
// Verificar si $totalClases es distinto de cero antes de realizar la división
if ($totalClases != 0) {
  $porcentajeAsistencia = ($asistencias / $totalClases) * 100;
  $porcentajeAsistencia = number_format($porcentajeAsistencia, 2);
} else {
  //si $totalClases es cero se asigna valor
  $porcentajeAsistencia = 0; 
}

// Color de porcentaje
if ($porcentajeAsistencia == 0 && $valorRegular == 0 && $valorPromocional == 0) {
  $colorPorcentaje = 'red'; // Si el porcentaje es 0 y no hay valores para promoción ni regular, el texto es rojo
} elseif ($porcentajeAsistencia < $valorRegular) {
  $colorPorcentaje = 'red';
} elseif ($porcentajeAsistencia >= $valorRegular && $porcentajeAsistencia < $valorPromocional) {
  $colorPorcentaje = 'yellow';
} else {
  $colorPorcentaje = 'green';
}


    echo "<td style='color: $colorPorcentaje;'>" . $porcentajeAsistencia . "%</td>";
    echo "<td><div class='btn-group'>";
    echo "<a href='./asistencia/insertInstantanea.php?id=" . $row["id"] . "&fecha=" . date("Y-m-d H:i:s") . "' class='btn btn-success'>Presente</a>";
    echo "<a href='./asistencia/insertAsistencia.php?id=" . $row["id"] . "' class='btn btn-primary'>As.Tardía</a>";
    echo "</div></td>";
    echo "<td><div class='btn-group'>";
    echo "<a href='./alumno/updateAlumno.php?id=" . $row["id"] . "' class='btn btn-warning'>Modificar</a>";
    echo "<a href='#' class='btn btn-danger btn-eliminar' data-alumno-id='" . $row["id"] . "'>Eliminar</a>";
    echo "</div></td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='5'>No se encontraron alumnos.</td></tr>";
}
?>
      </tbody>
    </table>
	 </div>
  <script src="js/lista_alumno.js"></script>
  <script src="js/sweetalert2.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>

