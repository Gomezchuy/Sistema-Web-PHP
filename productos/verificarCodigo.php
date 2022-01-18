<?php
require "../funciones/conecta7.php";
$con=conecta();
$cont=0;

//Recibe variables
$codigo=$_REQUEST['codigo'];
$codigoSistema=$_REQUEST['codigoSistema'];
$opcion=$_REQUEST['opcion'];
/*Opción
1: Nuevos productos
2: Modificar productos*/
$sql="SELECT codigo FROM productos WHERE codigo='$codigo' AND status = 1 AND eliminado=0";

$res=mysqli_query($con,$sql);
$codigosRepetidos=mysqli_num_rows($res);

if($codigosRepetidos>0)
{
    switch($opcion)
    {
        case 1:
            echo true;
            break;
        case 2:
            if($codigoSistema==$codigo)
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