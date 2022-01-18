<?php
session_start();
require "conecta7.php";
$con=conecta();

$user=$_REQUEST['user'];//correo
$pass=$_REQUEST['pass'];
$pass=md5($pass);

$sql="SELECT * FROM administradores
      WHERE correo='$user' AND pass='$pass'
      AND status = 1 AND eliminado = 0";
$res=$con->query($sql);
$num=$res->num_rows;

if($num){
    $row=$res->fetch_array();
    $idU=$row["id"];
    $nombre=$row["nombre"].' '.$row["apellidos"];
    $correo=$row["correo"];
    $_SESSION['idU']=$idU;
    $_SESSION['nombre']=$nombre;
    $_SESSION['correo']=$correo;
    echo true;
    //header("Location:../bienvenido.php");
}else{
    echo false;
    //header("Location:../index.php");
}

/*
window.location.href="bienvenido.php"
*/
?>