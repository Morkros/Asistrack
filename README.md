# Como utilizar Asistrack
## Descarga del sistema
- Copia y pega el siguiente link en un navegador web: https://github.com/Morkros/Asistrack
- haz click en el botón verde que dice "<> code", click en "download zip" y con esto se descargará un archivo .zip que contiene los archivos del sistema dentro de una carpeta llamada "asistrack-main" 8 es recomendable cambiarle el nombre a la carpeta para que sea solo "asistrack").
## Iniciando el sistema
Para cargar el sistema es necesario tener instalados XAMPP, Laragon o algún otro software que incluya Apache, junto a un software de base de datos (en este caso utilizamos XAMPP y MariaDB).
- ### Iniciando XAMPP
  - Copia la carpeta "asistrack", luego ve al panel de control de XAMPP y haz click en "explorer", esto abrirá la carpeta donde se encuentra instalado XAMPP.
  - Haz click en la carpeta "htdocs" y una vez dentro pega la carpeta "asistrack", luego ve al panel de control de XAMPP y haz click en "start" para iniciar Apache.
- ### Cargando la base de datos en HeidiSQL
  - Para iniciar la base de datos y que Asistrack pueda conectarse a la misma, es necesario cambiar la contraseña en el archivo "db.php" que se encuentra en "asistrack/db".
  - la contraseña se encuentra en la linea " private $password = "12345"; ", donde 12345 debe ser cambiado por la contraseña que utiliza para ingresar a HeidiSQL.
  - Al ingresar a HeidiSQL se debe crear un proyecto (el nombre que le asigne no importa)
  - al conectarse al proyecto deberá hacer click en "Archivo" -> "Cargar archivo SQL" y deberá navegar hasta encontrar la carpeta "asistrack", hacer click en el archivo "scriptSistema.sql" y finalmente hacer click en aceptar (si le pide reconocer automaticamente la codificación del archivo, hacer click en "si").
  - Una vez cargado el script, debe clickear en "Ejecutar script" (o presionar F9) y luego en "Recargar" (o presiosar F5); si siguió los pasos correctamente, debería ver una tabla llamada "sistema" en el panel izquierdo.
- ### Entrando al sistema
  - Una vez realizados los pasos anteriores, solo debe escribir "localhost/asistrack/index.php".
## Utilizando Asistrack
- ### Añadir alumno
  - Clickee en el botón azul "agregar alumno", esto lo llevará al formulario de alta de alumno, donde deberá ingresar nombre, apellido, DNI y edad del alumno.
  - Puede hacer click en el botón volver para ser llevado a la ventana principal nuevamente.
- ### Modificar alumno
- ### Eliminar alumno
- ### Asistencia inmediata
- ### Asistencia atrasada
  



