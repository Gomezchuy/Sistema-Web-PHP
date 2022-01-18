<?php
$file_name = $_FILES['archivo']['name'];     //Nombre real del archivo
$file_tmp  = $_FILES['archivo']['tmp_name']; //Nombre temporal del archivo
$cadena    = explode(".",$file_name);        //Separa el nombre para obtener la extensión
$ext       = $cadena[1];                     //Extensión
$dir       = "archivos/";                    //carpeta donde se guardan los archivos
$file_enc  = md5_file($file_tmp);            //Nombre del archivo encriptado

echo "file name: $file_name <br>";
echo "file tmp:  $file_tmp  <br>";
echo "ext:       $ext       <br>";
echo "file_enc   $file_enc  <br>";

if($file_name!=''){
    $fileName1="$file_enc.$ext";    //Nuevo nombre de mi archivo (archivo)
    //copy(origen,destino);
    copy($file_tmp, $dir.$fileName1);
}
?>