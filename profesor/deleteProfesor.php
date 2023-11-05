<?php
require_once('../db/autoload.php');
$baseDatos = new db();
$baseDatos->conectar();
$datosProfesor = new profesor();

// Verificar si se ha enviado el ID del alumno a eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["profesorId"])) {
  $profesorId = $_POST["profesorId"];
  // Llamar a la función para dar de baja al alumno
  $datosProfesor->deleteProfesor($baseDatos, $profesorId);
} else {
  // Si no se ha enviado el ID del alumno, devolver un mensaje de error
  $response = array('success' => false, 'message' => 'No se ha proporcionado el ID del alumno.');
  echo json_encode($response);
}

?>
