<?php
require "../funciones/conecta7.php";
$con = conecta();

//Recibe variables (datos del producto)
$nombre      = $_REQUEST['nombre'];
$codigo      = $_REQUEST['codigo'];
$descripcion = $_REQUEST['descripcion'];
$costo       = $_REQUEST['costo'];
$stock       = $_REQUEST['stock'];

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
$sql="INSERT INTO productos
    (nombre,codigo,descripcion,costo,stock,archivo_n,archivo)
    VALUES ('$nombre','$codigo','$descripcion','$costo','$stock',
    '$archivo_n','$archivo')";

$res=$con->query($sql);

header("Location: ListaProductos.php");
?>