<?php
session_start();
$nombre=$_SESSION['nombre'];
if($nombre=="")
{
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>bienvenido</title>
    </head>
    
    <frameset rows="10%,*" frameborder="no" bordercolor="#333" scrolling="no">
        <frame src="menuPrincipal.php" name="menuPrincipal"></frame>
        <frameset>
            <frame src="bienvenido.php" name="contenido"></frame>
        </frameset>
    </frameset>
</html>