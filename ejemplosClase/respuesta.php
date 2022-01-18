<?php
$id=$_REQUEST['id'];
$ban=0;

if($id>10){
    $ban=1;
}

echo $ban;
?>