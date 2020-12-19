<?php
session_start();
include('database.php');


$usuario=$_SESSION['usuario'];
$asegurada=$_POST['aseguradora'];
$result_asegurada = explode('|', $asegurada);
$lote =  $_POST['lotes'];
$result_lote = explode('|', $lote);
$observacion = $_POST['observaciones'];
$factura=$_POST['factura'];

$sql="
    UPDATE facturas_ftrama SET 
        iafas='$result_asegurada[2]',
        lote='$result_lote[0]',
        lote_tedef='$result_lote[2]', 
        observacion='$observacion',
        actualiza_usuario='$usuario',
        actualiza_fecha=now() 
    WHERE factura='$factura';
";


   if(pg_exec($sql)){
        echo 1;
    }else{
        echo 0;
    }




?>