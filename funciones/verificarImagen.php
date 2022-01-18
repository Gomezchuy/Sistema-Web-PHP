<?php
$message="";
$res=false;
if($_FILES)
{
    $file_name = $_FILES['archivo']['name'];     //Nombre real del archivo
    $cadena    = explode(".",$file_name);        //Separa el nombre para obtener la extensión
    $ext       = $cadena[count($cadena)-1];      //Extensión
    if(strcasecmp($ext,"jpg")==0 || strcasecmp($ext,"jpeg")==0 || strcasecmp($ext,"png")==0)
    {
        $res=true;
    }else{
        $message="El archivo no es un tipo de imagen";
        $res=false;
    }
}else{
    $message="No ha ingresado ninguna imagen";
    $res=false;
}
echo json_encode(array("res"=>$res,"message"=>$message));
?>