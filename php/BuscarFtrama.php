<?php

include('database.php');

$dato=$_POST['buscar'];

if($dato == null){
    echo "no hay dato";
}

$sql="
    SELECT 
    id,
    iafas,
    lote,
    lote_tedef,
    factura,
    observacion,
    usuario,
    to_char(fecha,'dd/mm/yyyy') AS fecha 
    FROM facturas_ftrama WHERE lote_tedef LIKE '$dato%' OR factura LIKE '$dato%'
";

$result = pg_exec($sql);
$count = pg_num_rows($result);
$json = array(); //creamos un array

if($count > 0){

while($row = pg_fetch_array($result)) 
{ 
    $id=$row['id'];
    $iafas=$row['iafas'];
    $lote=$row['lote'];
    $lote_tedef=$row['lote_tedef'];
    $factura=$row['factura'];
    $observacion=$row['observacion'];
    $usuario=$row['usuario'];
    $fecha=$row['fecha'];
    $json[] = array('reg' => 1,'id'=>$id,'iafas'=> $iafas, 'lote'=> $lote,'lote_tedef'=>$lote_tedef,'factura' =>$factura, 'observacion'=> $observacion,'usuario' =>$usuario ,'fecha'=>$fecha);
    
}
}else{
    $json[] = array('reg'=>0);
}


$json_string = json_encode($json);
echo $json_string;


?>