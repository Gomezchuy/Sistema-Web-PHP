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

$sql="SELECT * FROM productos WHERE id=$id";

$res=$con->query($sql);

while($row=$res->fetch_array())
{
    $nombre=$row["nombre"];
    $codigo=$row["codigo"];
    $descripcion=$row["descripcion"];
    $costo=$row["costo"];
    $stock=$row["stock"];
    
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
                    var codigo=document.Forma01.codigo.value;
                    var descripcion=document.Forma01.descripcion.value;
                    var costo=document.Forma01.costo.value;
                    var stock=document.Forma01.stock.value;

                    if(nombre&&codigo&&descripcion&&costo&&stock)
                    {
                        if(costo<0 || stock<0)
                        {
                            $('#mensaje').html('Lo siento, pero el campo "Costo" o "Stock" no deben ser menores a 0');
                            setTimeout("$('#mensaje').html('');",5000);
                        }else{
                            if(stock%1!=0)
                            {
                                $('#mensaje').html('Lo siento, pero el campo "Stock" no admite números con decimales');
                                setTimeout("$('#mensaje').html('');",5000);
                            }else{
                                comprobarCodigo(codigo);
                            }
                        }
                    }else{
                        $('#mensaje').html('Faltan campos por llenar');
                        setTimeout("$('#mensaje').html('');",5000);
                    }
            }

            function altaProducto()
            {
                document.Forma01.method='post';
                document.Forma01.action='productos_modifica.php?id=<?php echo $id; ?>';
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
            
            function comprobarCodigo(codigo){
                $.ajax({
                    url : 'verificarCodigo.php?codigo='+codigo+'&codigoSistema=<?php echo $codigo; ?>&opcion=2',
                    type : 'post',
                    dataType : 'text',
                    //data : 'id='+fila,
                    success : function(res){
                        if(res==true){
                            $('#mensajeCodigo').html('El codigo '+codigo+' ya existe');
                            setTimeout("$('#mensajeCodigo').html('');",5000);
                        }else{
                            if($('#archivo').val())
                            {
                                comprobarImagen(1,function(res){
                                    if(res)
                                    {
                                        altaProducto();
                                    }else{
                                        $('#mensaje').html('El archivo que ha adjuntado no es una imagen');
                                        setTimeout("$('#mensaje').html('');",5000);
                                    }
                                });
                            }else{
                                altaProducto();
                            }
                        }
                    },error:function(){
                        alert('Error archivo de "comprobar codigo" no encontrado...');
                    }
                });
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
        <a href="ListaProductos.php">Regresar al listado</a><br><br>
        Edición de productos<br><br>
        <form enctype="multipart/form-data" name="Forma01" id="Forma01">
            <?php
		    echo "<label>Nombre: </label>";
            echo "<input type=\"text\" name=\"nombre\" id=\"nombre\" value=\"$nombre\"/><br>";
            echo "<label>Código: </label>";
            echo "<input type=\"text\" name=\"codigo\" id=\"codigo\" value=\"$codigo\"/><br>";
            echo "<div id=\"mensajeCodigo\" style=\"color: #F00;font-size: 16px;\"></div>";
            echo "<label>Descripción:</label><br>";
            echo "<textarea name=\"descripcion\" id=\"descripcion\" cols=\"30\" rows=\"5\">$descripcion</textarea><br>";
            echo "<label>Costo: </label>";
            echo "<input type=\"number\" name=\"costo\" id=\"costo\" min=\"0\" value=\"$costo\"><br>";
            echo "<label>Stock: </label>";
            echo "<input type=\"number\" name=\"stock\" id=\"stock\" min=\"0\" value=\"$stock\"><br><br>";
            ?>
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