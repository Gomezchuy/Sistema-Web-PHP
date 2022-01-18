<?php
session_start();
$nombre=$_SESSION['nombre'];
if($nombre=="")
{
    header("Location: index.php");
}
require "funciones/conecta7.php";
$con = conecta();

$sql="SELECT * FROM banners
    WHERE status = 1 AND eliminado=0";
    
$res=mysqli_query($con,$sql);
$numBanners=mysqli_num_rows($res);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>bienvenido</title>
        <link rel="stylesheet" href="css/slider.css">
    </head>
    <body>
        <?php
        if($numBanners<4)
        {
            $sqlimg="SELECT * FROM banners WHERE status = 1 AND eliminado=0 ORDER BY rand() LIMIT 1";
            $res=$con->query($sqlimg);

            echo "<div class=\"imagenSola\">";
            echo "<ul>";
            while($row=$res->fetch_array())
            {
                $nombreImagen=$row['archivo'];
                echo "<li><img src=\"archivos/$nombreImagen\"></li>";
            }
            echo "</ul>";
            echo "</div>";
        }else
        {
            $sqlimg="SELECT * FROM banners WHERE status = 1 AND eliminado=0 ORDER BY rand() LIMIT 4";
            $res=$con->query($sqlimg);
            echo "<div class=\"slider\">";
            echo "<ul>";
            while($row=$res->fetch_array())
            {
                $nombreImagen=$row['archivo'];
                echo "<li><img src=\"archivos/$nombreImagen\"></li>";
            }
            echo "</ul>";
            echo "</div>";
        }
        ?>
        <h1 align="center">¡Bienvenido <?php echo $nombre; ?>!</h1>
    </body>
</html>