<html>
    <head>
        <title>Formulario01</title>

        <script>
            //alert("Hola...");

            //var nombre="Pancho";
            //var nombre='Pancho';
            var nombre='12345';

            //miAlerta2(nombre)

            function miAlerta2(nombre) {
                alert("Hola.... "+nombre);
            }

            function miAlerta() {
                alert("Hola....");
            }

            function validaCampos(){
                var nombre=document.Forma01.nombre.value;
                alert(nombre);
            }
            function enviaDatos(){
                document.Forma01.method='post';
                document.Forma01.action='recibe.php';
                document.Forma01.submit();
            }
        </script>
    </head>
    <body>
        <form name="Forma01">
            <input type="text" name="nombre" id="nombre" placeholder="Escribir tu usuario"/><br>
            <input type="text" name="correo" id="correo" value="@"/><br>
            <select name="rol" id="rol">
                <option value="0">Selecciona rol</option>
                <option value="1">Administrador</option>
                <option value="2">Usuario</option>
            </select><br>
            <input type="submit" onclick="enviaDatos(); return false;" value="Enviar"/>
        </form>
    </body>
</html>