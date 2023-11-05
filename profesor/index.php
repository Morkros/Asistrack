<?php
require_once('../db/autoload.php');
$datosProfesor = new profesor();
$baseDatos = new db();
$baseDatos->conectar();


//Verificar si se ha enviado el formulario de búsqueda
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre_buscar"])) {
  $nombreBuscar = $_POST["nombre_buscar"];
//Realizar la consulta de alumnos filtrando por nombre, apellido o nombre completo
$sql = "SELECT * FROM profesores WHERE CONCAT(nombre, ' ', apellido) LIKE '%$nombreBuscar%' OR nombre LIKE '%$nombreBuscar%' OR apellido LIKE '%$nombreBuscar%'";
$result = $datosProfesor->consultar($baseDatos, $sql);
} else {
//Consulta de todos los alumnos si no se ha enviado el formulario de búsqueda
  $sql = "SELECT * FROM profesores ORDER BY apellido ASC";
  $result = $datosProfesor->consultar($baseDatos, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Consulta de Profesores</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/sweetalert2.css">
</head>
<body>
<div class="container">
    <h1>Consulta de Profesores</h1>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <ul class="navbar-nav mr-auto">
      <li class="nav-item ms-2 mr-2">
          <a class="nav-link" href="../index.php">Alumno</a>
        </li>
        <li class="nav-item ms-2 mr-2">
          <a class="nav-link active">Profesor</a>
        </li>
        <li class="nav-item ms-2 mr-2">
          <a class="nav-link" href="../asistencia/configuracion.php">Configuración</a>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="navbar-brand">AsisTrack</a>
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
          <th><a href='./insertProfesor.php' class='btn btn-primary'>Agregar Profesor</a></th>
        </tr>
      </thead>
      <tbody>
        <?php

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["dni"] . "</td>";
            echo "<td>" . $row["nombre"] . "</td>";
            echo "<td>" . $row["apellido"] . "</td>";
            echo "<td>" . $row["nacimiento"] . "</td>";
            echo "<td><a href='./updateProfesor.php?id=" . $row["id"] . "' class='btn btn-warning'>Modificar</a></td>";
            echo "<td><a href='#' class='btn btn-danger btn-eliminar ' data-profesor-id='" . $row["id"] . "'>Eliminar</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='4'>No se encontraron alumnos.</td></tr>";
        }
        ?>
      </tbody>
    </table>
	 </div>
  <script src="../js/lista_profesor.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/sweetalert2.js"></script>
</body>