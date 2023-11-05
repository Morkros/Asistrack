<?php
require_once('../db/autoload.php');
$datosAlumno = new alumno();
$baseDatos = new db();
$baseDatos->conectar();
date_default_timezone_set('America/Argentina/Buenos_Aires');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Formulario de Alta de Alumno</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/sweetalert2.css">
</head>
<body>
  <div class="container">
    <h1>Formulario de Alta de Alumno</h1>
    <form method="POST" action="">
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" class="form-control" name="nombre" required>
      </div>

      <div class="form-group">
        <label for="apellido">Apellido:</label>
        <input type="text" class="form-control" name="apellido" required>
      </div>

      <div class="form-group">
        <label for="dni">DNI:</label>
        <input type="text" class="form-control" name="dni" required>
      </div>

      <div class="form-group">
        <label for="nacimiento">Fecha de Nacimiento:</label>
        <input type="date" class="form-control" name="nacimiento" required>
      </div>

      <button type="submit" class="btn btn-primary">Agregar Alumno</button>
      <td><a href='../index.php' class='btn btn-danger btn-eliminar'>Volver</a></td>
    </form>
  </div>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/sweetalert2.js"></script>
</body>
</html>

<?php
// Verificar si se ha enviado el formulario de alta de alumno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];
  $dni = $_POST["dni"];
  $nacimiento = $_POST["nacimiento"];

  //comprueba que los campos no estén vacíos
  if (empty($nombre) && empty($apellido) && empty($dni) && empty($nacimiento)) {
    echo '<script language="javascript">Swal.fire({title: "Error", 
      text: "Por favor, complete todos los campos obligatorios.", 
      icon: "error", 
      confirmButtonColor: "#007bff"});</script>';
  } else {
    
    //comprueba que la edad sea igual o mayor a 17 años
    $fechaNacimiento = strtotime($nacimiento); //convierte la fecha ingresada a UNIX
    $fechaActual = time(); //fecha actual en UNIX
    if ($fechaActual - $fechaNacimiento < 17 * 31536000) {
      echo '<script language="javascript">Swal.fire({title: "Error", 
        text: "La fecha ingresada es menor a 17 años de edad.", 
        icon: "error", 
        confirmButtonColor: "#007bff"});</script>';
    } else {

      //comprueba que nombre y apellido sean alfabeticos
      if (ctype_alpha($nombre) & ctype_alpha($apellido)) {

        //comprueba que el DNI sea numerico
        $longitudDNI=strlen($dni);
        if (is_numeric($dni) && $longitudDNI=8) {
          $datosAlumno->insertAlumno($baseDatos, $nombre, $apellido, $dni, $nacimiento);
        } else {
          echo '<script language="javascript">Swal.fire({title: "Error", 
            text: "El DNI ingresado es inválido", 
            icon: "error", 
            confirmButtonColor: "#007bff"});</script>';
        }
      } else {
        echo '<script language="javascript">Swal.fire({title: "Error", 
          text: "Por favor, ingrese un nombre y/o apellido válido.", 
          icon: "error", 
          confirmButtonColor: "#007bff"});</script>';
      }
    }
  }
}
?>




