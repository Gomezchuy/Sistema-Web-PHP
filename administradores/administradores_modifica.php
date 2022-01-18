<?php
require "../funciones/conecta7.php";
$con = conecta();

//Recibe variables
//Variables recibidos por parametro
$id=$_REQUEST['id'];

//Variables recibidos por el formulario
$nombre=$_REQUEST['nombre'];
$apellidos=$_REQUEST['apellidos'];
$correo=$_REQUEST['correo'];
$pass=$_REQUEST['password'];
$rol=$_REQUEST['rol'];
$passEnc=md5($pass);
$bandera=0;

//Variables de imagen
$archivo     = $_FILES['archivo']['name'];
$archivo_tmp = $_FILES['archivo']['tmp_name'];

$sql="UPDATE administradores SET nombre='$nombre', apellidos='$apellidos',
correo='$correo', rol='$rol'";

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

    $sql.=", archivo='$archivo', archivo_n='$archivo_n'";
}

if($pass=="")
{
    $sql.=" WHERE id=$id";
}else{
    $sql.=", pass='$passEnc' WHERE id=$id";
}

$res=$con->query($sql);

header("Location: ListaAdministradores.php");
?>