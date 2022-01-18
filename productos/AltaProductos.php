<?php
session_start();
$nombre=$_SESSION['nombre'];
if($nombre=="")
{
    header("Location: ../index.php");
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Alta de Productos</title>

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
                document.Forma01.action='productos_salva7.php';
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
                        alert('Error archivo de verificar imagen no encontrado...');
                    }
                });
                return respuesta;
            }
            
            function comprobarCodigo(codigo){
                $.ajax({
                    url : 'verificarCodigo.php?codigo='+codigo+'&codigoSistema=null&opcion=1',
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
                                $('#mensaje').html('No se ha adjuntado imagen alguna');
                                setTimeout("$('#mensaje').html('');",5000);
                            }
                        }
                    },error:function(){
                        alert('Error archivo de "comprobar codigo" no encontrado...');
                    }
                });
            }
        </script>
    </head>
    <body>
        <a href="ListaProductos.php">Regresar al listado</a><br><br>
        Alta de Productos<br><br>
        <form enctype="multipart/form-data" name="Forma01" id="Forma01">
        
		    <label>Nombre:</label>
            <input type="text" name="nombre" id="nombre"/><br>
		    <label>Código:</label>
            <input type="text" name="codigo" id="codigo"/><br>
            <div id="mensajeCodigo" style="color: #F00;font-size: 16px;"></div>
		    <label>Descripción:</label><br>
		    <textarea name="descripcion" id="descripcion" cols="30" rows="5"></textarea><br>
            <label>Costo:</label>
		    <input type="number" name="costo" id="costo" min="0"><br>
            <label>Stock:</label>
		    <input type="number" name="stock" id="stock" min="0"><br><br>
            <div>Foto: <input type="file" onchange="comprobarImagen(0); return false;" id="archivo" name="archivo"></div>
            <div class="preview">
                <img id="image">
            </div>
            <br>
            <input type="submit" onclick="validaCampos(); return false;" value="Salvar"/>
        </form>
        <div id="mensaje" style="color: #F00;font-size: 16px;"></div>
    </body>
</html>