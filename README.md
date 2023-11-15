# Como utilizar Asistrack
## Descarga del sistema
- Copia y pega el siguiente link en un navegador web: https://github.com/Morkros/Asistrack
- Haz click en el botón verde que dice "<> code", click en "download zip" y con esto se descargará un archivo .zip que contiene los archivos del sistema dentro de una carpeta llamada "asistrack-main" 8 es recomendable cambiarle el nombre a la carpeta para que sea solo "asistrack").
## Iniciando el sistema
Para cargar el sistema es necesario tener instalados XAMPP, Laragon o algún otro software que incluya Apache, junto a un software de base de datos (en este caso utilizamos XAMPP y MariaDB).
- ### Iniciando XAMPP
  - Copia la carpeta "asistrack", luego ve al panel de control de XAMPP y haz click en "explorer", esto abrirá la carpeta donde se encuentra instalado XAMPP.
  - Haz click en la carpeta "htdocs" y una vez dentro pega la carpeta "asistrack", luego ve al panel de control de XAMPP y haz click en "start" para iniciar Apache.
- ### Cargando la base de datos en HeidiSQL
  - Para iniciar la base de datos y que Asistrack pueda conectarse a la misma, es necesario cambiar la contraseña en el archivo "db.php" que se encuentra en "asistrack/db".
  - La contraseña se encuentra en la linea " private $password = "12345"; ", donde 12345 debe ser cambiado por la contraseña que utiliza para ingresar a HeidiSQL.
  - Al ingresar a HeidiSQL se debe crear un proyecto (el nombre que le asigne no importa)
  - Al conectarse al proyecto deberá hacer click en "Archivo" -> "Cargar archivo SQL" y deberá navegar hasta encontrar la carpeta "asistrack", hacer click en el archivo "scriptSistema.sql" y finalmente hacer click en aceptar (si le pide reconocer automaticamente la codificación del archivo, hacer click en "si").
  - Una vez cargado el script, debe clickear en "Ejecutar script" (o presionar F9) y luego en "Recargar" (o presiosar F5); si siguió los pasos correctamente, debería ver una tabla llamada "sistema" en el panel izquierdo.
- ### Entrando al sistema
  - Una vez realizados los pasos anteriores, solo debe escribir "localhost/asistrack/index.php".
## Utilizando Asistrack
- ### Ventana Alumno
  - #### Añadir alumno
    - Clickee en el botón azul "agregar alumno", esto lo llevará al formulario de alta de alumno, donde deberá ingresar nombre, apellido, DNI y edad del alumno.
    - Puede hacer click en el botón volver para ser llevado a la ventana principal nuevamente.
    - Criterios a tener en cuenta: DNI debe ser igual a 8 digitos de longitud, nombre y apellido no puede contener números, la fecha de nacimiento debe ser mayor o igual a 17 años de edad.
  - #### Modificar alumno
    - Clickee en el botón amarillo "modificar alumno", esto lo llevará al formulario de modificación de alumno, donde podrá cambiar cualquier dato del alumno.
    - Puede hacer click en el botón volver para ser llevado a la ventana principal nuevamente.
    - Los criterios son los mismos que al añadir un alumno, pero además se le suma el siguiente criterio: si quiere reemplazar el DNI, no podrá utilizar uno que ya exista en otro alumno.
  - #### Eliminar alumno
    - Clickee en el botón rojo "eliminar alumno", esto abrirá un cartel en el que deberá confirmar o cancelar la eliminación de los datos del alumno.
    - Debe tener en cuenta que la eliminación es PERMANENTE.
  - #### Asistencia inmediata
    - clickee en el botón verde "presente" para declarar que el alumno estuvo presente en el dia de la fecha, almacenando la fecha y la hora del momento en que se clickeó.
  - #### Asistencia atrasada
    - Clickee en el botón azul "As. Tardía", esto lo llevará al formulario de asistencia, lo que le permitirá ingresar una asistencia que no haya sido ingresada anteriormente debido a alguna clase de error.
- ### Ventana Calendario
  - #### Búsqueda por fecha
    - Ingrese una fecha válida de clases, para obtener la información de todos los alumnos presentes en ese día específico.
- ### Parametros
  - #### Porcentaje promoción
    - Permite ingresar el porcentaje con el cuál se calculará si un alumno aprueba promocinando o no.
    - Criterios a tener en cuenta: el porcentaje debe ser igual a 2 dígitos y númerico.
  - #### Porcentaje Regular
    - Permite ingresar el porcentaje con el cuál se calculará si un alumno aprueba regular o no.
    - Los criterios son los mismos que los de Porcentaje Promoción.
  - #### Días de Clases
    - Permite ingresar el total de días de clases que habrá o hubo durante el año; este valor se utilizará en conjunto con los porcentajes regular y promoción para obtener el porcentaje de asistencias de un alumno.
    - Criterios a tener en cuenta: el valor ingresado debe ser númerico, mayor a 1 dígito y menor a 4 dígitos (esto se debe a que dependiendo de si es un curso de duración corta, puede tener menos de 100 días de clases)



