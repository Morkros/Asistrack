<?php
trait alertas {
    public function mostrarMensajeError($mensaje) {
        echo '<script language="javascript">Swal.fire({
            title: "Error",
            text: "' . $mensaje . '",
            icon: "error",
            confirmButtonColor: "#007bff"
        });</script>';
      }
      //esta versión de la función anterior, permite volver al index al clickear el botón de confirmación
    public function mostrarMensajeErrorReturn($mensaje) {
        echo '<script language="javascript">Swal.fire({
            title: "Error",
            text: "' . $mensaje . '",
            icon: "error",
            confirmButtonColor: "#007bff"
        }).then(function() {
            window.location.href = "../index.php";
        });</script>';
      }
    
    public function mostrarMensajeSuccess($mensaje) {
        echo '<script language="javascript">Swal.fire({title: "¡Genial!", 
            text: "' . $mensaje . '", 
            icon: "success", 
            confirmButtonColor: "#007bff"}).then(function() {
              window.location.href = "../index.php";
            });</script>';
    }
}
?>