<?php
trait calculo {
    function calculoRegularidad($porcentaje,$nota1,$nota2){
        $promedio= $nota1 + $nota2 / 2;
        if (($porcentaje<80 && $porcentaje>=50) && $promedio>6) {
            print "regular";
        } elseif ($porcentaje<=50 || $promedio<6) {
            print "libre";
        } elseif ($porcentaje>=80 && $promedio>=8) {
            print "promociona";
        }
    }
}
?>