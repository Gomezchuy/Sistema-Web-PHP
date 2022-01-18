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
        <title>B2</title>
        <script src="js/jquery-3.3.1.min.js"></script>
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
                <th colspan="6">Listado de Administradores</th>
            </tr>
            <tr>
                <th colspan="6"><a href="AltaAdmins.php">Crear un nuevo usuario</a></th>
            </tr>
            <tr>
                <th colspan="6"><div id="mensaje" style="color: #F00;font-size: 16px;">Mensaje</div></th>
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
                echo "<td><a href=\"javascript:void(0);\" onClick=\"confirmarEliminar($id);\">Eliminar Administrador</a></td>";
                echo "</tr>";
                $cont++;
            }
            ?>
        </table>
    </body>
</html>