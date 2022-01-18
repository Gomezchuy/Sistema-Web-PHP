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

$sql="SELECT * FROM administradores WHERE id=$id";

$res=$con->query($sql);

while($row=$res->fetch_array())
{
    $nombre=$row["nombre"];
    $apellidos=$row["apellidos"];
    $correo=$row["correo"];
    $rol=$row["rol"];
    $status=$row["status"];

    $rol_txt=($rol==1)?'Gerente':'Ejecutivo';
    $status_txt=($status==1)?'Activo':'Inactivo';

    //Imagen
    $archivo=$row["archivo"];
    $archivo_n=$row["archivo_n"];

    $cadena = explode(".",$archivo);        //Separa el nombre para obtener la extensión
    $ext    = $cadena[count($cadena)-1];    //Extensión
    $dir    = "../archivos/";                  //carpeta donde se guardan los archivos

    $ImagenSRC="$dir$archivo_n.$ext";
}
?>
<html>
    <head>
        <?php
        echo "<title>Detalle de $nombre $apellidos</title>";
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
        <div align="center"><a href="ListaAdministradores.php">Regresar al listado</a></div><br>
        
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
            echo "<td>$nombre $apellidos</td></tr>";
            echo "<tr><td>Correo: </td>";
            echo "<td>$correo</td></tr>";
            echo "<tr><td>Rol: </td>";
            echo "<td>$rol_txt</td></tr>";
            echo "<tr><td>Status: </td>";
            echo "<td>$status_txt</td></tr>";
            ?>

        </table>
    </body>
</html>