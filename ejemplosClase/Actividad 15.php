<html>
    
    <head>
        <title>Actividad 15</title>

        <script>
            function recibe(){
                    var comb=document.getElementById("numero");
                    var seleccionado=comb.options[comb.selectedIndex].text;
                    if(document.forma01.numero.value!=0)
                    {
                        document.forma01.action='recibe15.php';
                        document.forma01.submit();
                    }else
                    {
                        alert("Faltan campos por llenar");
                        
                    }
                }
        </script>
    </head>

 <body>
	<form name="forma01" method="POST">
		<label for="numero">Número:</label>
		<select name="numero" id="numero">
            <option value="0">Selecciona</option>
            <?php
            for($i=1;$i<=5000;$i++){
                echo"<option value='$i'>$i</option>";
            }
            ?>
		</select>
		<input type="submit" onclick="recibe(); return false;" value="Enviar con input"/>
	</form>
	
 </body>
</html>