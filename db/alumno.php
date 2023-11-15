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
require_once("autoload.php");
require_once("traits.php");

class alumno {
  use alertas;
    private $id;
    private $nombre;
    private $apellido;
    private $dni;
    private $nacimiento;
    private $dni_alumno;
    private $fecha;
    private $conexion;

    public function insertAlumno($conexionDB, $nombreIngresado, $apellidoIngresado, $dniIngresado, $nacimientoIngresado) {
        $conexionDB->conectar();
        $this->nombre = $nombreIngresado;
        $this->apellido = $apellidoIngresado;
        $this->dni = $dniIngresado;
        $this->nacimiento = $nacimientoIngresado;
    
        $sql = "INSERT INTO alumnos (nombre, apellido, dni, nacimiento) VALUES (?, ?, ?, ?)";
        $stmt = $conexionDB->connect()->prepare($sql);

        if ($stmt) {
            //return true;
            $stmt->bind_param("ssss", $this->nombre, $this->apellido, $this->dni, $this->nacimiento);
            $stmt->execute();
            $stmt->close();
            $this->mostrarMensajeExito("Alumno añadido correctamente.");
            //echo '<script language="javascript">setTimeout(function () {window.location.href = "../index.php";}, 0050);</script>';
            $conexionDB->desconectar();
        } else {
            //return false;
            $this-> mostrarMensajeError("Error al agregar el alumno");
            $conexionDB->desconectar();
        }
    }
    
    function updateAlumno($conexionDB, $alumnoId, $nombre, $apellido, $dni, $nacimiento) {
      // Verificar si el DNI está duplicado y pertenece a otro usuario
      $sql = "SELECT id FROM alumnos WHERE dni = '$dni' AND id != $alumnoId";
      $result = $conexionDB->connect()->query($sql);

      if ($result->num_rows > 0) {
        $this->mostrarMensajeError("DNI existente, volver a intentar.");
      } else {
          // Actualizar los datos del alumno
          $sql = "UPDATE alumnos SET nombre = '$nombre', apellido = '$apellido', dni = '$dni', nacimiento = '$nacimiento' WHERE id = $alumnoId";
  
          if ($conexionDB->connect()->query($sql) === TRUE) {
              echo '<script language="javascript">setTimeout(function () {window.location.href = "../index.php";}, 0050);</script>';
          } else {
              $this-> mostrarMensajeError("Error al agregar el alumno");
              echo "Error al modificar los datos del alumno: " . $conexionDB->connect()->error;
          }
      }
  }

    // Función para eliminar los datos de un alumno
    function deleteAlumno($conexionDB, $alumnoId) {
        $conexionDB->conectar();
        $sql = "DELETE FROM alumnos WHERE id = $alumnoId";
        
        if ($conexionDB->connect()->query($sql) === TRUE) {
          $response = array('success' => true, 'message' => 'Alumno dado de baja exitosamente.');
        } else {
          $response = array('success' => false, 'message' => 'Error al dar de baja al alumno: ' . $conexionDB->connect()->error);
        }
        $conexionDB->desconectar();

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }

    //Permite realizar la busqueda de alumnos en el index
    public function consultar($conexionDB, $sql) {
        $conexionDB->conectar();
        $result = $conexionDB->connect()->query($sql);
        return $result;
        $conexionDB->desconectar();
    }

    //permite obtener los datos del alumno basado en la id vinculada
    public function getAlumno($conexionDB, $id) {
      $conexionDB->conectar();
      $sql = "SELECT * FROM alumnos WHERE id = ?";
      $stmt = $conexionDB->connect()->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $alumno = $result->fetch_assoc();
      $conexionDB->desconectar();
      return $alumno;
  }

  //permite insertar una asistencia al alumno basado en su dni
  public function insertAsistencia($conexionDB, $dni_alumno, $fecha) {
    $conexionDB->conectar();

      // Verificar si la asistencia ya existe
    $sql = "SELECT id FROM asistencias WHERE DATE(fecha) = ? AND dni_alumno = ?";
    $stmt = $conexionDB->connect()->prepare($sql);
    $stmt->bind_param("ss", $fecha, $dni_alumno);
    $stmt->execute();
    $result = $stmt->get_result();
      if ($result->num_rows > 0) {

      // La asistencia ya existe, mostrar mensaje de error
      $this->mostrarMensajeError("La fecha de la asistencia ya fue agregada anteriormente para el alumno.");
    } else {

      // La asistencia no existe, insertar en la base de datos
      $sql = "INSERT INTO asistencias (dni_alumno, fecha) VALUES (?, ?)";
      $stmt = $conexionDB->connect()->prepare($sql);
      $stmt->bind_param("ss", $dni_alumno, $fecha);
      $stmt->execute();
      $this->mostrarMensajeExito("Asistencia agregada exitosamente.");
    }
      $conexionDB->desconectar();
  }
  public function insertInstantanea($conexionDB, $alumnoId, $fecha) {
    $conexionDB->conectar();

    // Obtener el DNI del alumno utilizando el ID
    $sql = "SELECT dni FROM alumnos WHERE id = ?";
    $stmt = $conexionDB->connect()->prepare($sql);
    $stmt->bind_param("i", $alumnoId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dni_alumno = $row["dni"];
        
        // Verificar si la asistencia ya existe
        $sql = "SELECT id FROM asistencias WHERE dni_alumno = ? AND DATE(fecha) = ?";
        $stmt = $conexionDB->connect()->prepare($sql);
        $stmt->bind_param("ss", $dni_alumno, $fecha);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          $this->mostrarMensajeErrorReturn("La asistencia ya fue agregada anteriormente para el alumno.");
        } else {
            // La asistencia no existe, insertar en la base de datos
            $sql = "INSERT INTO asistencias (dni_alumno, fecha) VALUES (?, ?)";
            $stmt = $conexionDB->connect()->prepare($sql);
            $stmt->bind_param("ss", $dni_alumno, $fecha);
            $stmt->execute();
            $this->mostrarMensajeExito("Asistencia agregada exitosamente.");
        }
    } else {
      $this->mostrarMensajeErrorReturn("No se encontró el alumno con el ID proporcionado.");
    }

    $conexionDB->desconectar(); 
  }
}   
?>
