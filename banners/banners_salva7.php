<?php
//administradores_salva.php;
require "../funciones/conecta7.php";
$con = conecta();

//Recibe variables (datos del banner)
$nombre   = $_REQUEST['nombre'];

//Recibe variables (imagen)
$archivo     = $_FILES['archivo']['name'];
$archivo_tmp = $_FILES['archivo']['tmp_name'];
$archivo_n   = md5_file($archivo_tmp);

$cadena = explode(".",$archivo);        //Separa el nombre para obtener la extensión
$ext    = $cadena[count($cadena)-1];    //Extensión
$dir    = "../archivos/";                  //carpeta donde se guardan los archivos

//Guardar imagen en la carpeta
$archivoName1="$archivo_n.$ext";    //Nuevo nombre de mi archivo (archivo)
//copy(origen,destino);
copy($archivo_tmp,$dir.$archivoName1);

//Subirla a la base de datos
$sql="INSERT INTO banners
    (nombre,archivo)
    VALUES ('$nombre','$archivoName1')";

$res=$con->query($sql);

header("Location: ListaBanners.php");
?>