<?php
    $nombre=$_POST['nombre'];
    $correo=$_POST['correo'];
    $sexo=$_POST['sexo'];
    $boletin=isset($_POST['boletin']);
    $comentario=$_POST['comentario'];
    $carrera=$_POST['carrera'];
    $pasw=$_POST['pasw'];
    $promedio=$_POST['promedio'];
    $fecha=$_POST['fecha'];
    
    $boletin_txt=($boletin==1)?'Si':'No';
    $sexo_txt=($sexo=='F')?'Femenino':'Masculino';
    $carrera_txt=($carrera==1)?'Ing. Informática':'Ing. Computación';

    echo "Bienvenido $nombre <br>";
    echo "Correo: $correo <br>";
    echo "Genero: $sexo_txt <br>";
    echo "Boletin: $boletin_txt <br>";
    echo "Comentario: $comentario <br>";
    echo "Carrera: $carrera_txt <br>";
    echo "Contraseña: $pasw <br>";
    echo "fecha: $fecha";
?>