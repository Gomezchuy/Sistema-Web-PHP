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
    </head>

    <body>
        <table border="1" align="center">
            <tr>
                <td><a href="bienvenido.php" target="contenido">Inicio</a></td>
                <td><a href="administradores/ListaAdministradores.php" target="contenido">Administradores</a></td>
                <td><a href="productos/ListaProductos.php" target="contenido">Productos</a></td>
                <td><a href="banners/ListaBanners.php" target="contenido">Banners</a></td>
                <td><a href="#" target="contenido">Pedidos</a></td>
                <td>Bienvenido <?php echo $nombre;?></td>
                <td><a href="funciones/cerrarSesion.php" target="contenido">Cerrar sesión</a></td>
            </tr>
        </table>
    </body>
</html>