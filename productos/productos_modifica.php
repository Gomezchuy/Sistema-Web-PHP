<?php
require "../funciones/conecta7.php";
$con = conecta();

//Recibe variables
//Variables recibidos por parametro
$id=$_REQUEST['id'];

//Variables recibidos por el formulario
$nombre      = $_REQUEST['nombre'];
$codigo      = $_REQUEST['codigo'];
$descripcion = $_REQUEST['descripcion'];
$costo       = $_REQUEST['costo'];
$stock       = $_REQUEST['stock'];

//Variables de imagen
$archivo     = $_FILES['archivo']['name'];
$archivo_tmp = $_FILES['archivo']['tmp_name'];

$sql="UPDATE productos SET nombre='$nombre', codigo='$codigo',
descripcion='$descripcion', costo='$costo', stock='$stock'";

//Imagen
if($archivo!="")
{
    $archivo_n   = md5_file($archivo_tmp);

    $cadena = explode(".",$archivo);        //Separa el nombre para obtener la extensión
    $ext    = $cadena[count($cadena)-1];    //Extensión
    $dir    = "../archivos/";                  //carpeta donde se guardan los archivos

    //Guardar imagen en la carpeta
    $archivoName1="$archivo_n.$ext";    //Nuevo nombre de mi archivo (archivo)
    //copy(origen,destino);
    copy($archivo_tmp,$dir.$archivoName1);

    $sql.=", archivo='$archivo', archivo_n='$archivo_n' WHERE id=$id";
}else{
    $sql.=" WHERE id=$id";
}

$res=$con->query($sql);

header("Location: ListaProductos.php");
?>