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
$totalClases = $rowParametros['dias_clases'];

 
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
        <!-- </li>
         <li class="nav-item ms-2 mr-2">
          <a class="nav-link" href="./profesor/index.php">Profesor</a>
       </li> -->
       <li class="nav-item  ms-2 mr-2">
          <a class="nav-link active">Calendario</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item ms-2 mr-2">
          <a class="nav-link" href="./asistencia/configuracion.php"><i class="bi bi-gear"></i></a>
        </li>
        <li class="nav-item ms-2 mr-2 mt-auto">
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

    // Calcular el porcentaje de asistencia
    $sqlAsistencias = "SELECT COUNT(*) AS asistencias FROM Asistencias WHERE dni_alumno = '" . $row["dni"] . "'";
    $resultAsistencias = $datosAlumno->consultar($baseDatos, $sqlAsistencias);
    $rowAsistencias = mysqli_fetch_assoc($resultAsistencias);
    $asistencias = $rowAsistencias['asistencias'];
    $porcentajeAsistencia = ($asistencias / $totalClases) * 100;
    $porcentajeAsistencia = number_format($porcentajeAsistencia, 2);
    
    echo "<td>" . $porcentajeAsistencia . "%</td>";
    echo "<td><div class='btn-group'>";
    echo "<a href='./alumno/insertInstantanea.php?id=" . $row["id"] . "&fecha=" . date("Y-m-d H:i:s") . "' class='btn btn-success'>Presente</a>";
    echo "<a href='./alumno/insertAsistencia.php?id=" . $row["id"] . "' class='btn btn-primary'>As.Tardía</a>";
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