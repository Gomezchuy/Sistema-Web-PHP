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
        <?php echo "<title>Modificar $nombre</title>"; ?>

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

                    if(nombre)
                    {
                            if($('#archivo').val())
                            {
                                comprobarImagen(1,function(res){
                                    if(res)
                                    {
                                        altaBanner();
                                    }else{
                                        $('#mensaje').html('El archivo que ha adjuntado no es una imagen');
                                        setTimeout("$('#mensaje').html('');",5000);
                                    }
                                });
                            }else{
                                altaBanner();
                            }
                    }else{
                        $('#mensaje').html('Faltan campos por llenar');
                        setTimeout("$('#mensaje').html('');",5000);
                    }
            }

            function altaBanner()
            {
                document.Forma01.method='post';
                document.Forma01.action='banners_modifica.php?id=<?php echo $id; ?>';
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

            $(document).ready(function(){
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
        <a href="ListaBanners.php">Regresar al listado</a><br><br>
        Edición de administradores<br><br>
        <form enctype="multipart/form-data" name="Forma01" id="Forma01">
            <?php
            echo "<input type=\"text\" name=\"nombre\" id=\"nombre\" placeholder=\"Nombre\" value=\"$nombre\"/><br>";
            ?>
            <br>
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