<?php
require_once('../db/autoload.php');
$baseDatos = new db();
$baseDatos->conectar();
$datosAlumno = new alumno();

// Verificar si se ha enviado el ID del alumno a eliminar

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["alumnoId"])) {
 $alumnoId = $_POST["alumnoId"];
  // Llamar a la función para dar de baja al alumno
  $datosAlumno->deleteAlumno($baseDatos, $alumnoId);
} else {
  // Si no se ha enviado el ID del alumno, devolver un mensaje de error
  $response = array('success' => false, 'message' => 'No se ha proporcionado el ID del alumno.');
 echo json_encode($response);
}

?>
