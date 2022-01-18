<?php
require "funciones/conecta7.php";
$con = conecta();

$sql="SELECT * FROM administradores
    WHERE status = 1 AND eliminado = 0";
$res=$con->query($sql);
$cont=1;

while($row=$res->fetch_array())
{
    $id=$row['id'];
    $nombre=$row["nombre"];
    $apellidos=$row["apellidos"];
    echo "$id $nombre $apellidos";
    echo " ----- ";
    echo "<a href=\"elimina_administradores7.php?id=$id\">";
    echo " Click para eliminar";
    echo "</a><br";
    $cont++;
}
?>