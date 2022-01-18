<?php
session_start();
$nombre=$_SESSION['nombre'];
if($nombre=="")
{
    header("Location: ../index.php");
}

require "../funciones/conecta7.php";
$con = conecta();

$sql="SELECT * FROM administradores
    WHERE status = 1 AND eliminado=0";
$res=$con->query($sql);
$cont=1;
?>
<html>
    <head>
        <title>Lista de Administradores</title>

        <link href="../css/Listado.css" rel="stylesheet" type="text/css">

        <meta charset="UTF-8">

        <script src="../js/jquery-3.3.1.min.js"></script>
        <script>
            function confirmarEliminar(id) {
                if(confirm("¿Te gustaría eliminar a este usuario?"))
                {
                    eliminaFilas(id);
                }
            }

            function eliminaFilas(fila){
                $.ajax({
                    url : 'elimina_administradores7.php?id='+fila,
                    type : 'post',
                    dataType : 'text',
                    //data : 'id='+fila,
                    success : function(res){
                        if(res==true){
                            $('#mensaje').html('Fila eliminada.');
                            $('#row'+fila).hide();
                            setTimeout("$('#mensaje').html('Mensaje');",2000);
                        }else{
                            $('#mensaje').html('Error en la eliminación.');
                            setTimeout("$('#mensaje').html('Mensaje');",3000);
                        }
                    },error:function(){
                        alert('Error archivo no encontrado...');
                    }
                });
            }
        </script>
    </head>

    <body>
        <table border="1" width="95%" align="center">
            <tr>
                <th colspan="7">Listado de Administradores</th>
            </tr>
            <tr>
                <th colspan="7"><a href="AltaAdmins.php">Dar de alta</a></th>
            </tr>
            <tr>
                <th colspan="7"><div id="mensaje" style="color: #F00;font-size: 16px;">Mensaje</div></th>
            </tr>
            <tr>
                <td class="titulo">ID</td>
                <td class="titulo">Nombre completo</td>
                <td class="titulo">Correo</td>
                <td class="titulo">Rol</td>
                <th colspan="3" class="titulo">Opciones</th>
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

                echo "<tr id=\"row$id\">";
                echo "<td width='20px'>$id</td> <td>$nombre $apellidos</td> <td>$correo</td> <td>$rol_txt</td>";
                echo "<td><a href=\"detalleAdmin.php?id=$id\">Ver detalle</a></td>";
                echo "<td><a href=\"modificaAdmin.php?id=$id\">Editar</a></td>";
                echo "<td><a href=\"javascript:void(0);\" onClick=\"confirmarEliminar($id);\">Eliminar</a></td>";
                echo "</tr>";
                $cont++;
            }
            ?>
        </table>
    </body>
</html>