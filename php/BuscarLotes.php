<?php

include('database.php');

$dato=$_POST['buscarLotes'];


$sql="
SELECT 
	id,
	ae_dcorta as iafa,
	lote,
	lote_tedef,
	TO_CHAR(fecha_inicio,'DD/MM/YYYY') as fecha,
	tlote,
	CASE estado
	WHEN 1 THEN 'CERRADO'
	WHEN 0 THEN 'ABIERTO'
	END estado
FROM tedef a
INNER JOIN aseguradora b ON(a.iafas=b.ae_codigosunasa ) 
WHERE CAST(lote_tedef AS VARCHAR) LIKE '$dato%'  OR ae_dcorta LIKE '$dato%'
";

$result = pg_exec($sql);
$count = pg_num_rows($result);
$json = array(); //creamos un array

if($count > 0){

while($row = pg_fetch_array($result)) 
{ 
	$id=$row['id'];	
	$iafas=$row['iafa'];
    $lote=$row['lote'];
    $lote_tedef=$row['lote_tedef'];
	$fecha=$row['fecha'];
	$tlotes=$row['tlote'];
	$estado=$row['estado'];
	
    $json[] = array('reg' => 1,'id'=>$id,'iafas'=> $iafas, 'lote'=> $lote,'lote_tedef'=> $lote_tedef,'fecha'=>$fecha,'tlote'=>$tlotes,'estado'=>$estado);
    
}

}else{
	$json[] = array('reg'=>0);
}



$json_string = json_encode($json);
echo $json_string;


?>