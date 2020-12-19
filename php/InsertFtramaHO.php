<?php
session_start();
include('database.php');

$codigo=$_POST['id'];
$result_explode = explode('|', $codigo);
$factura=$_POST['factura'];
$observacion=$_POST['observacion'];
$usuario=$_SESSION['usuario'];

$sql="INSERT INTO facturas_Ftrama(lote,lote_tedef,factura,observacion,iafas,usuario,fecha) 
      VALUES ('$result_explode[0]',$result_explode[2],'$factura','$observacion','$result_explode[1]','$usuario',now())";


if(pg_exec($sql)){
    return 1;
}else{
    return 0;
}
