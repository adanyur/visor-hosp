<?php
include('database.php');

$data= explode('|', $_POST['boton']);

$cuenta=$data[0];
$hc=$data[1];
$boton=$data[2];
$numero=$data[3];

$producto=$_POST['producto'];
$codigoAfiliado=$_POST['codigoAfiliado'];
$cobertura=$_POST['cobertura'];

if($boton=='PLANES'){
    $sql="UPDATE planes_historia SET pl_codafilseg='$codigoAfiliado' WHERE pl_numhist='$hc'"; 
}else{
    $sql="UPDATE pre_facturacion SET pfac_producto='$producto',pfac_subtipocob='$cobertura' WHERE pfac_cuenta='$cuenta'"; 
}


if(pg_exec($sql)){
    echo $numero;
}else{
    echo 0;
}

?>