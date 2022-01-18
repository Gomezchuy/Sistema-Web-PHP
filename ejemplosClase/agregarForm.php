<html>
    <head>
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script>
            function agregar (idP){
                var cantidad=$('#producto_'+idP).val();
                if(cantidad>0){
                    $.ajax({
                        url: 'recibeProducto.php',
                        type: 'post',
                        dataType: 'text',
                        data: 'idP='+idP+'&cantidad='+cantidad,
                        success:function(res){
                            if(res){
                                $('#mensaje_'+idP).html('Agregado con exito');
                                setTimeout("$('#mensaje_"+idP+"').html('');",5000);
                            }
                        },error: function(){
                            alert('Error al conectar al servidor...');
                        }
                    });//Termina ajax()
                }else{
                    $('#mensaje_'+idP).html('Seleccione cantidad');
                    setTimeout("$('#mensaje_"+idP+"').html('');",3000);
                }
            }
        </script>
        <style>
            .producto{
                width: 120px;
                min-height: 210px;
                border: 1px dotted #CCC;
                padding: 5px;
                float: left;
                margin-right: 3px;
                margin-bottom: 3px;
                background: #567912;
            }
            .producto_imagen{
                width: 100px;
                height: 100px;
                background: #CCC;
                margin-bottom: 8px;
            }
        </style>
    </head>

    <body>
        <div style="float:left; width:960px; min-height:500px; background:#f5f5f5;">
        <div class="producto">
            <div class="producto_imagen"></div>
            Producto 1<br>
            $5,250.00<br>
            <select id="producto_1" name="producto_1">
                <option value="0">Selecciona</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <input onclick="agregar(1); return false;" type="submit" value="Agregar" /><br>
            <div id="mensaje_1" style="color: #FF0000; font-size: 11px;"></div>
        </div>
        </div>
    </body>
</html>