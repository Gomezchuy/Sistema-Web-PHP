<?php
session_start();
$nombre=$_SESSION['nombre'];
if($nombre=="")
{
    header("Location: ../index.php");
}
?>
<html>
    <head>
        <title>Alta Administradores</title>

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

                    if(nombre&&apellidos&&correo&&pass&&rol>0)
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
                document.Forma01.action='administradores_salva7.php';
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
                    url : 'verificarCorreo.php?correo='+correo+'&correoSistema=null&opcion=1',
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
                                $('#mensaje').html('No se ha adjuntado imagen alguna');
                                setTimeout("$('#mensaje').html('');",5000);
                            }
                        }
                    },error:function(){
                        alert('Error archivo no encontrado...');
                    }
                });
            }
        </script>
    </head>
    <body>
        <a href="ListaAdministradores.php">Regresar al listado</a><br><br>
        Alta de Administradores<br><br>
        <form enctype="multipart/form-data" name="Forma01" id="Forma01">
            <input type="text" name="nombre" id="nombre" placeholder="Nombre"/><br>
            <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos"/><br>
            <input type="text" name="correo" id="correo" placeholder="Correo"/>
            <div id="mensajeCorreo" style="color: #F00;font-size: 16px;"></div>
            <input type="text" name="password" id="password" placeholder="Contraseña"/><br>
            <select name="rol" id="rol">
                <option value="0">Selecciona</option>
                <option value="1">Gerente</option>
                <option value="2">Ejecutivo</option>
            </select><br><br>
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