<?php
class db {
    // Configuración de acceso a la base de datos
private $servername = "localhost";
private $username = "root";
private $password = "hola"; 
private $dbname = "sistema";
private $conexion;

// Crear la conexión
public function conectar() {
    $this->conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    // Verificar la conexión
    if ($this->conexion->connect_error) {
        die("Error al conectar a la base de datos: " . $this->conexion->connect_error);
    }
}
//cerrar la conexión
public function desconectar() {
    mysqli_close($this->conexion);
}
//retorna el valor almacenado en la variable (es un getter creo?)
public function connect() {
    return $this->conexion;
}
}
?>
