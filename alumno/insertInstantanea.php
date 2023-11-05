<?php
require_once('../db/autoload.php');
$datosAlumno = new alumno();
$baseDatos = new db();
$baseDatos->conectar();
?>

<!DOCTYPE html>
<head>
  <title>Document</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/sweetalert2.css">
</head>
<body>
  <script src="../js/sweetalert2.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>

<?php
if (isset($_GET["id"]) && isset($_GET["fecha"])) {
  $alumnoId = $_GET["id"];
  $fecha = $_GET["fecha"];
  
  $datosAlumno->insertInstantanea($baseDatos, $alumnoId, $fecha);
} else {
  echo '<script language="javascript">Swal.fire({title: "Error", 
    text: "Error al obtener los datos del alumno.", 
    icon: "error", 
    confirmButtonColor: "#007bff"});</script>';
}
?>