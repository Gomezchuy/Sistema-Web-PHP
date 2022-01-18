<?php
require "funciones/conecta7.php";
$con = conecta();

$sql="SELECT * FROM administradores
    WHERE status = 1 AND eliminado=0";
$res=$con->query($sql);
$cont=1;
?>
<html>
    <head>
        <title>B1. Lista de administradores</title>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script>
            function eliminaFila(id) {
                if(confirm("¿Te gustaría eliminar a este usuario?"))
                {
                    window.location.href="elimina_administradores7.php?id="+id;
                }
            }
        </script>
    </head>

    <body>
        <table border="1" width="95%" align="center">
            <tr>
                <th colspan="6">Listado de Administradores</th>
            </tr>
            <tr>
                <th colspan="6"><a href="#">Crear un nuevo usuario</a></th>
            </tr>
            <?php
            while($row=$res->fetch_array())
            {
                $id=$row['id'];
                $nombre=$row["nombre"];
                $apellidos=$row["apellidos"];
                $correo=$row["correo"];
                $rol=$row["rol"];

                $op=false;
                
                $rol_txt=($rol==1)?'Gerente':'Ejecutivo';

                echo "<tr id=\"$id\">";
                echo "<td width='20px'>$id</td> <td>$nombre $apellidos</td> <td>$correo</td> <td>$rol_txt</td>";
                echo "<td><a href='#' onclick=\"eliminaFila($id)\">Click para eliminar</a></td>";
                echo "</tr>";
                $cont++;
            }
            ?>
        </table>
    </body>
</html>