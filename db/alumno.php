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
  //use alertas;
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
            echo '<script language="javascript">setTimeout(function () {window.location.href = "../index.php";}, 0050);</script>';
            $conexionDB->desconectar();
        } else {
            //return false;
            echo '<script language="javascript">Swal.fire({title: "Error", 
              text: "Error al agregar el alumno", 
              icon: "error", 
              confirmButtonColor: "#007bff"});</script>';
            $conexionDB->desconectar();
        }
    }
    // Función para modificar los datos de un alumno
    function updateAlumno($conexionDB, $alumnoId, $nombre, $apellido, $dni, $nacimiento) {
        $sql = "UPDATE alumnos SET nombre = '$nombre', apellido = '$apellido', dni = '$dni', nacimiento = '$nacimiento' WHERE id = $alumnoId";
  
        if ($conexionDB->connect()->query($sql) === TRUE) {
        echo '<script language="javascript">setTimeout(function () {window.location.href = "../index.php";}, 0050);</script>';
        } else {
        echo "Error al modificar los datos del alumno: " . $conexionDB->connect()->error;
        }
    }
    // Función para eliminar los datos de un alumno
    function deleteAlumno($conexionDB, $alumnoId) {
        $conexionDB->conectar();
        $sql = "DELETE FROM alumnos WHERE id = $alumnoId";
        
        echo '<script language="javascript">Swal.fire({
          title: "Are you sure?",
          text: "You wont be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire(
              "Deleted!",
              "Your file has been deleted.",
              "success"
            )
          }
        });</script>';
        //if ($conexionDB->connect()->query($sql) === TRUE) {
        //  $response = array('success' => true, 'message' => 'Alumno dado de baja exitosamente.');
        //} else {
        //  $response = array('success' => false, 'message' => 'Error al dar de baja al alumno: ' . $conexionDB->connect()->error);
        //}
        //$conexionDB->desconectar();
        // Devolver la respuesta en formato JSON
       // echo json_encode($response);
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
      echo '<script language="javascript">Swal.fire({title: "Error", 
        text: "La fecha de la asistencia ya fue agregada anteriormente para el alumno.", 
        icon: "error", 
        confirmButtonColor: "#007bff"});</script>';
    } else {
      // La asistencia no existe, insertar en la base de datos
      $sql = "INSERT INTO asistencias (dni_alumno, fecha) VALUES (?, ?)";
      $stmt = $conexionDB->connect()->prepare($sql);
      $stmt->bind_param("ss", $dni_alumno, $fecha);
      $stmt->execute();
      echo '<script language="javascript">Swal.fire({title: "¡Genial!", 
        text: "Asistencia agregada exitosamente.", 
        icon: "success", 
        confirmButtonColor: "#007bff"}).then(function() {
          window.location.href = "../index.php";
      });</script>';
      //echo '<script language="javascript">setTimeout(function () {window.location.href = "../index.php";}, 0050);</script>';
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
          echo '<script language="javascript">Swal.fire({title: "Error", 
            text: "La asistencia ya fue agregada anteriormente para el alumno.", 
            icon: "error", 
            confirmButtonColor: "#007bff"}).then(function() {
              window.location.href = "../index.php";
          });</script>';
            //echo '<script language="javascript">setTimeout(function () {window.location.href = "../index.php";}, 0050);</script>';
        } else {
            // La asistencia no existe, insertar en la base de datos
            $sql = "INSERT INTO asistencias (dni_alumno, fecha) VALUES (?, ?)";
            $stmt = $conexionDB->connect()->prepare($sql);
            $stmt->bind_param("ss", $dni_alumno, $fecha);
            $stmt->execute();

              echo '<script language="javascript">Swal.fire({title: "¡Genial!", 
              text: "Asistencia agregada exitosamente.", 
              icon: "success", 
              confirmButtonColor: "#007bff"}).then(function() {
                window.location.href = "../index.php";
            });</script>';
             // echo '<script language="javascript">setTimeout(function () {window.location.href = "../index.php";}, 0050);</script>';
        }
    } else {
        echo '<script language="javascript">Swal.fire({title: "Error", 
        text: "No se encontró el alumno con el ID proporcionado.", 
        icon: "error", 
        confirmButtonColor: "#007bff"}).then(function() {
          window.location.href = "../index.php";
      });</script>';
        //echo '<script language="javascript">setTimeout(function () {window.location.href = "../index.php";}, 0050);</script>';
    }

    $conexionDB->desconectar(); 
  }
}   
?>
