<?php
//elimina_administradores.php
require "../funciones/conecta7.php";
$con=conecta();

//Recibe variables
$id=$_REQUEST['id'];

$sql="UPDATE banners SET eliminado=1 WHERE id=$id";

$res=$con->query($sql);

echo true;
//header("Location: B2.php");
?>