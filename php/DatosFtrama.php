<?php
include('database.php');

$id=$_POST['id'];


$sql="
select 
	Lote,
    lote_tedef,
    factura,
	observacion
	
from facturas_ftrama where id=$id
";



if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array

while($row = pg_fetch_array($result)) 
{
    $lote=$row['lote'];
    $lote_tedef=$row['lote_tedef'];
    $factura=$row['factura'];
    $observacion=$row['observacion'];

    $json[] = array('lote' => $lote,'lote_tedef'=>$lote_tedef,'factura'=>$factura,'observacion' =>$observacion);

}


$json_string = json_encode($json);
echo $json_string;


?>