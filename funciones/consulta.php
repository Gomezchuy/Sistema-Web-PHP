<?php
require "funciones/conecta7.php";
$con = conecta();

$sql="SELECT * FROM administradores
    WHERE status = 1 AND eliminado=0";
$res=$con->query($sql);
$cont=1;
?>