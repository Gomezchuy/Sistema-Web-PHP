<?php
require "../funciones/conecta7.php";
$con=conecta();
$cont=0;

//Recibe variables
$correo=$_REQUEST['correo'];
$correoSistema=$_REQUEST['correoSistema'];
$opcion=$_REQUEST['opcion'];
/*Opción
1: Nuevos usuarios
2: Modificar usuarios*/
$sql="SELECT correo FROM administradores WHERE correo='$correo'";

$res=mysqli_query($con,$sql);
$correosRepetidos=mysqli_num_rows($res);

if($correosRepetidos>0)
{
    switch($opcion)
    {
        case 1:
            echo true;
            break;
        case 2:
            if($correoSistema==$correo)
            {
                echo false;
            }else{
                echo true;
            }
            break;
    }
}else
{
    echo false;
}
?>