<?php
session_start();
$nombre=$_SESSION['nombre'];
if($nombre=="")
{
    header("Location: ../index.php");
}

require "../funciones/conecta7.php";
$con=conecta();

$id=$_REQUEST['id'];

$sql="SELECT * FROM banners WHERE id=$id";

$res=$con->query($sql);

while($row=$res->fetch_array())
{
    $nombre=$row["nombre"];

    //Imagen
    $archivo=$row["archivo"];
    
    $dir    = "../archivos/";   //carpeta donde se guardan los archivos

    $ImagenSRC="$dir$archivo";
}
?>
<html>
    <head>
        <?php
        echo "<title>Detalle de $nombre</title>";
        ?>
        <meta charset="UTF-8">

        <style>
            .preview {
                position: relative;
            }

            .preview img {
                max-width: 20%;
            }
        </style>
    </head>
    <body>
        <div align="center"><a href="ListaBanners.php">Regresar al listado</a></div><br>
        
        <?php
        if($archivo!="")
        {
            echo "<div class=\"preview\" align=\"center\">";
            echo "<img id=\"image\" src=\" $ImagenSRC \">";
            echo "</div><br>";
        }
        ?>
        <table align="center" border="1">
            <?php
            echo "<tr><td>Nombre: </td>";
            echo "<td>$nombre</td></tr>";
            ?>

        </table>
    </body>
</html>