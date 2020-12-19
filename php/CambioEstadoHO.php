<?php
session_start();
include('database.php');


$usuario=$_SESSION['usuario'];
$id=$_POST['id'];
$result_explode = explode('|', $id);

if($result_explode[1] =='ABIERTO'){
    $estado=1; //CERRADO
}else{
    $estado=0; //ABIERTO
}

$sql="
        UPDATE tedef SET usuario_fin='$usuario',fecha_fin=now(),estado=$estado WHERE id=$result_explode[0]
    ";

    if(pg_exec($sql)){
        echo 1;
    }else{
        echo 0;
    }

?>