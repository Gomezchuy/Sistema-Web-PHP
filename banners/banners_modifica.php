<?php
require "../funciones/conecta7.php";
$con = conecta();

//Recibe variables
//Variables recibidos por parametro
$id=$_REQUEST['id'];

//Variables recibidos por el formulario
$nombre=$_REQUEST['nombre'];

//Variables de imagen
$archivo     = $_FILES['archivo']['name'];

$sql="UPDATE banners SET nombre='$nombre'";

//Imagen
if($archivo!="")
{
    $archivo_tmp = $_FILES['archivo']['tmp_name'];
    $archivo_n   = md5_file($archivo_tmp);

    $cadena = explode(".",$archivo);        //Separa el nombre para obtener la extensión
    $ext    = $cadena[count($cadena)-1];    //Extensión
    $dir    = "../archivos/";                  //carpeta donde se guardan los archivos

    //Guardar imagen en la carpeta
    $archivoName1="$archivo_n.$ext";    //Nuevo nombre de mi archivo (archivo)
    //copy(origen,destino);
    copy($archivo_tmp,$dir.$archivoName1);

    $sql.=", archivo='$archivoName1' WHERE id=$id";
}else{
    $sql.=" WHERE id=$id";
}

$res=$con->query($sql);

header("Location: ListaBanners.php");
?>