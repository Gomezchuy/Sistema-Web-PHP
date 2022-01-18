<?php
session_start();
if($_SESSION)
{
    header("Location: menuIndex.php");
}
?>
<html>
    <head>
        <title>Login</title>
        
        <meta charset="utf-8">
        <script src="js/jquery-3.3.1.min.js"></script>
        <script>
            function validaCampos(){
                    var correo=document.Forma01.correo.value;
                    var pass=document.Forma01.password.value;

                    if(correo&&pass)
                    {
                        validaUsuario();
                    }else{
                        $('#mensaje').html('Faltan campos por llenar');
                        setTimeout("$('#mensaje').html('');",5000);
                    }
            }

            function validaUsuario()
            {
                var correo=$('#correo').val();
                var pass=$('#password').val();
                $.ajax({
                    url : 'funciones/validaUsuario.php?user='+correo+'&pass='+pass,
                    type : 'post',
                    dataType : 'text',
                    //data : 'id='+fila,
                    success : function(res){
                        if(res==true){
                            window.location.href="menuIndex.php";
                        }else{
                            $('#mensaje').html('Usuario y/o contraseña son incorrectos');
                            setTimeout("$('#mensaje').html('');",5000);
                        }
                    },error:function(){
                        alert('Error archivo no encontrado...');
                    }
                });
            }
        </script>
    </head>
    
    <body>
        <h1>Login</h1>
        <form name="Forma01" id="Forma01">
            <input type="text" name="correo" id="correo" placeholder="Correo"/><br>
            <input type="text" name="password" id="password" placeholder="Contraseña"/><br>
            <input type="submit" onclick="validaCampos(); return false;" value="Iniciar sesión"/>
        </form>
        <div id="mensaje" style="color: #F00;font-size: 16px;"></div>
    </body>
</html>