<?php
require_once("autoload.php");

class profesor {
    private $nombre;
    private $apellido;
    private $dni;
    private $nacimiento;
    private $conexion;
    private $dias;

    public function insertProfesor($conexionDB, $nombreIngresado, $apellidoIngresado, $dniIngresado, $nacimientoIngresado) {
        $conexionDB->conectar();
        $this->nombre = $nombreIngresado;
        $this->apellido = $apellidoIngresado;
        $this->dni = $dniIngresado;
        $this->nacimiento = $nacimientoIngresado;
    
        $sql = "INSERT INTO profesores (nombre, apellido, dni, nacimiento) VALUES (?, ?, ?, ?)";
        $stmt = $conexionDB->connect()->prepare($sql);

        if ($stmt) {
            //return true;
            $stmt->bind_param("ssss", $this->nombre, $this->apellido, $this->dni, $this->nacimiento);
            $stmt->execute();
            $stmt->close();
            echo '<script language="javascript">setTimeout(function () {window.location.href = "./index.php";}, 0050);</script>';
            $conexionDB->desconectar();
        } else {
            //return false;
            echo '<script language="javascript">alert("Error al agregar el profesor");</script>';
            $conexionDB->desconectar();
        }
    }
    // Función para modificar los datos de un alumno
    function updateProfesor($conexionDB, $profesorId, $nombre, $apellido, $dni, $nacimiento) {
        $sql = "UPDATE profesores SET nombre = '$nombre', apellido = '$apellido', dni = '$dni', nacimiento = '$nacimiento' WHERE id = $profesorId";
  
        if ($conexionDB->connect()->query($sql) === TRUE) {
        echo '<script language="javascript">setTimeout(function () {window.location.href = "./index.php";}, 0050);</script>';
        } else {
        echo "Error al modificar los datos del profesor: " . $conexionDB->connect()->error;
        }
    }
    // Función para eliminar los datos de un alumno
     function deleteProfesor($conexionDB, $profesorId) {
        $conexionDB->conectar();
        $sql = "DELETE FROM profesores WHERE id = $profesorId";
        if ($conexionDB->connect()->query($sql) === TRUE) {
          $response = array('success' => true, 'message' => 'Alumno dado de baja exitosamente.');
        } else {
          $response = array('success' => false, 'message' => 'Error al dar de baja al profesor: ' . $conexionDB->connect()->error);
        }
        $conexionDB->desconectar();
        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }
    
    //permite realizar la busqueda de alumnos en el index
    public function consultar($conexionDB, $sql) {
        $conexionDB->conectar();
        $result = $conexionDB->connect()->query($sql);
        return $result;
        $conexionDB->desconectar();
    }

    public function updateDiasClases($conexionDB, $diasIngresados) {
        $conexionDB->conectar();
        $this->dias = $diasIngresados;
        
        $sqlSelect = "SELECT * FROM parametros";
        $result = $conexionDB->connect()->query($sqlSelect);
    
        if ($result->num_rows > 0) {
            // Actualización normal
            $sql = "UPDATE parametros SET dias_clases = ?";
            $stmt = $conexionDB->connect()->prepare($sql);
    
            if ($stmt) {
                $stmt->bind_param("s", $this->dias);
                $stmt->execute();
                $stmt->close();
                echo '<script language="javascript">setTimeout(function () {window.location.href = ... ... ... "./configuracion.php";}, 0050);</script>';
            } else {
                echo '<script language="javascript">alert("Error al confirmar");</script>';
            }
        } else {
            // Insertar nuevo valor
            $sqlInsert = "INSERT INTO parametros (dias_clases) VALUES (?)";
            $stmt = $conexionDB->connect()->prepare($sqlInsert);
    
            if ($stmt) {
                $stmt->bind_param("s", $this->dias);
                $stmt->execute();
                $stmt->close();
                echo '<script language="javascript">setTimeout(function () {window.location.href = ... ... ... "./configuracion.php";}, 0050);</script>';
            } else {
                echo '<script language="javascript">alert("Error al confirmar");</script>';
            }
        }
    
        $conexionDB->desconectar();
    }


    public function updatePorcentajePromocion($conexionDB, $porcentajePromocion) {
        $conexionDB->conectar();
    
        $sqlSelect = "SELECT * FROM parametros";
        $result = $conexionDB->connect()->query($sqlSelect);
    
        if ($result->num_rows > 0) {
            // Actualización normal
            $sql = "UPDATE parametros SET promocion = ?";
            $stmt = $conexionDB->connect()->prepare($sql);
    
            if ($stmt) {
                $stmt->bind_param("s", $porcentajePromocion);
                $stmt->execute();
                $stmt->close();
                echo '<script language="javascript">alert("Porcentaje de promoción actualizado correctamente.");</script>';
            } else {
                echo '<script language="javascript">alert("Error al insertar el porcentaje de promoción.");</script>';
            }
        } else {
            // Insertar nuevo valor
            $sqlInsert = "INSERT INTO parametros (promocion) VALUES (?)";
            $stmt = $conexionDB->connect()->prepare($sqlInsert);
    
            if ($stmt) {
                $stmt->bind_param("s", $porcentajePromocion);
                $stmt->execute();
                $stmt->close();
                echo '<script language="javascript">alert("Porcentaje de promoción insertado correctamente.");</script>';
            } else {
                echo '<script language="javascript">alert("Error al insertar el porcentaje de promoción.");</script>';
            }
        }
    
        $conexionDB->desconectar();
    }
    

    public function updatePorcentajeRegular($conexionDB, $porcentajeRegular) {
        $conexionDB->conectar();
    
        $sqlSelect = "SELECT * FROM parametros";
        $result = $conexionDB->connect()->query($sqlSelect);
    
        if ($result->num_rows > 0) {
            // Actualización normal
            $sql = "UPDATE parametros SET regular = ?";
            $stmt = $conexionDB->connect()->prepare($sql);
    
            if ($stmt) {
                $stmt->bind_param("s", $porcentajeRegular);
                $stmt->execute();
                $stmt->close();
                echo '<script language="javascript">alert("Porcentaje regular actualizado correctamente.");</script>';
            } else {
                echo '<script language="javascript">alert("Error al insertar el porcentaje regular.");</script>';
            }
        } else {
            // Insertar nuevo valor
            $sqlInsert = "INSERT INTO parametros (regular) VALUES (?)";
            $stmt = $conexionDB->connect()->prepare($sqlInsert);
    
            if ($stmt) {
                $stmt->bind_param("s", $porcentajeRegular);
                $stmt->execute();
                $stmt->close();
                echo '<script language="javascript">alert("Porcentaje regular insertado correctamente.");</script>';
            } else {
                echo '<script language="javascript">alert("Error al insertar el porcentaje regular.");</script>';
            }
        }
    
        $conexionDB->desconectar();
    }
    
}
?>