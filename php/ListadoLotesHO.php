<?php

include('database.php');

$id=$_POST['tipo'];

if($id=='A'){

	$sql="
	SELECT 
		id,
		ae_dcorta as iafa,
		ae_codigosunasa as codigoiafas,
		lote,
		lote_tedef,
		CASE
		WHEN estado = 0 THEN
		'ABIERTO'
		ELSE
		'CERRADO'
		END as estado,
		ae_dcorta||'-'||'('||lote_Tedef||')' as descripcion,
		tlote
	FROM tedef a
	INNER JOIN aseguradora b ON(a.iafas=b.ae_codigosunasa ) where estado=0
	";
}else{
$sql="
SELECT 
	id,
	ae_dcorta as iafa,
	ae_codigosunasa as codigoiafas,
	lote,
	lote_tedef,
	CASE
	WHEN estado = 0 THEN
	'ABIERTO'
	ELSE
	'CERRADO'
	END as estado,
	ae_dcorta||'-'||'('||lote_Tedef||')' as descripcion,
	tlote
FROM tedef a
INNER JOIN aseguradora b ON(a.iafas=b.ae_codigosunasa ) ORDER BY 1 DESC 
";

}
if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array
while($row = pg_fetch_array($result)) 
{   
    $id=$row['id'];
	$iafa=$row['iafa'];
	$codigoIafas=$row['codigoiafas'];
    $lote=$row['lote'];
    $lote_tedef=$row['lote_tedef'];
	$estado=$row['estado'];
	$descripcion=$row['descripcion'];
	$tlote=$row['tlote'];
	$json[] = array('id'=>$id,'iafa'=> $iafa,'codigoIafas'=>$codigoIafas,'lote'=> $lote,'lote_tedef'=> $lote_tedef,'estado'=>$estado,'descripcion'=> $descripcion, 'tlote'=>$tlote);
}

$json_string = json_encode($json);
echo $json_string;


?>