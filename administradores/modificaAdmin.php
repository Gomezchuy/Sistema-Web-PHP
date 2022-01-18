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
        <?php echo "<title>Modificar $nombre $apellidos</title>"; ?>

        <meta charset="UTF-8">

        <style>
            .preview {
            position: relative;
            }

            .preview img {
            max-width: 20%;
            }
        </style>

        <script src="../js/jquery-3.3.1.min.js"></script>
        <script>
            function validaCampos(){
                    var nombre=document.Forma01.nombre.value;
                    var apellidos=document.Forma01.apellidos.value;
                    var correo=document.Forma01.correo.value;
                    var pass=document.Forma01.password.value;
                    var rol=document.Forma01.rol.value;

                    if(nombre&&apellidos&&correo&&rol>0)
                    {
                        comprobarCorreo(correo);
                    }else{
                        $('#mensaje').html('Faltan campos por llenar');
                        setTimeout("$('#mensaje').html('');",5000);
                    }
            }

            function altaAdmin()
            {
                document.Forma01.method='post';
                document.Forma01.action='administradores_modifica.php?id=<?php echo $id; ?>';
                document.Forma01.submit();
            }

            /*op:
            1: Retorna un valor
            2: No retorna nada
            */
            function comprobarImagen(op,retornarVariable)
            {
                var formData=new FormData();
                var files=$('#archivo')[0].files[0];
                formData.append('archivo',files);

                var respuesta=false;

                $.ajax({
                    url : '../funciones/verificarImagen.php',
                    type : 'post',
                    dataType : 'json',
                    data : formData,
                    contentType:false,
                    processData:false,
                    success : function(res){
                        if(res.res==true){
                            const $image=document.querySelector('#image')

                            const imagen=formData.get('archivo')
                            const image=URL.createObjectURL(imagen)
                            $image.setAttribute('src',image)

                            respuesta=true;
                        }else{
                            const $image=document.querySelector('#image')

                            const imagen=formData.get('archivo')
                            const image=URL.createObjectURL(imagen)
                            $image.removeAttribute('src')

                            $('#mensaje').html(''+res.message);
                            setTimeout("$('#mensaje').html('');",5000);

                            respuesta=false;
                        }
                        if(op==1)
                        {
                            retornarVariable(respuesta);
                        }
                    },error:function(){
                        alert('Error archivo no encontrado...');
                    }
                });
                return respuesta;
            }
            
            function comprobarCorreo(correo){
                $.ajax({
                    url : 'verificarCorreo.php?correo='+correo+'&correoSistema=<?php echo $correo; ?>&opcion=2',
                    type : 'post',
                    dataType : 'text',
                    //data : 'id='+fila,
                    success : function(res){
                        if(res==true){
                            $('#mensajeCorreo').html('El correo '+correo+' ya existe');
                            setTimeout("$('#mensajeCorreo').html('');",5000);
                        }else{
                            if($('#archivo').val())
                            {
                                comprobarImagen(1,function(res){
                                    if(res)
                                    {
                                        altaAdmin();
                                    }else{
                                        $('#mensaje').html('El archivo que ha adjuntado no es una imagen');
                                        setTimeout("$('#mensaje').html('');",5000);
                                    }
                                });
                            }else{
                                altaAdmin();
                            }
                        }
                    },error:function(){
                        alert('Error archivo no encontrado...');
                    }
                });
            }

            $(document).ready(function(){ //Selecciona el SELECT al seleccionar el administrador
                $('#rol > option[value="<?php echo $rol; ?>"]').attr('selected','selected');

                <?php
                if($archivo!="")
                {
                ?>
                    document.getElementById("image").src="<?php echo $ImagenSRC;?>";
                <?php
                }
                ?>
            });
        </script>
    </head>
    <body>
        <a href="ListaAdministradores.php">Regresar al listado</a><br><br>
        Edición de administradores<br><br>
        <form enctype="multipart/form-data" name="Forma01" id="Forma01">
            <?php
            echo "<input type=\"text\" name=\"nombre\" id=\"nombre\" placeholder=\"Nombre\" value=\"$nombre\"/><br>";
            echo "<input type=\"text\" name=\"apellidos\" id=\"apellidos\" placeholder=\"Apellidos\" value=\"$apellidos\"/><br>";
            echo "<input type=\"text\" name=\"correo\" id=\"correo\" placeholder=\"Correo\" value=\"$correo\"/>";
            ?>
            <div id="mensajeCorreo" style="color: #F00;font-size: 16px;"></div>
            <input type="text" name="password" id="password" placeholder="Contraseña"/><br>
            <select name="rol" id="rol" default="1">
                <option value="0">Selecciona</option>
                <option value="1">Gerente</option>
                <option value="2">Ejecutivo</option>
            </select><br><br>
            <div>Foto: <input type="file" onchange="comprobarImagen(0); return false;" id="archivo" name="archivo"></div>
            <div class="preview">
                <img id="image">
            </div>
            <br>
            <input type="submit" onclick="validaCampos(); return false;" value="Modificar"/>
        </form>
        <div id="mensaje" style="color: #F00;font-size: 16px;"></div>
    </body>
</html>