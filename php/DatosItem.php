<?php

include('database.php');

$id=$_POST['id'];

$sql="
SELECT 
	id,
	ae_dcorta as iafa,
	CAST(SUBSTRING(lote FROM 2) AS NUMERIC) AS lote,
	lote_tedef,
	CASE
	WHEN estado = 0 THEN
	'ABIERTO'
	ELSE
	'CERRADO'
	END as estado,
	lote||'-'||ae_dcorta||'-'||'('||lote_Tedef||')' as descripcion,
    tlote,
    iafas AS codiafas,
    substring(tlote from 1 for 1) as idtlote
FROM tedef a
INNER JOIN aseguradora b ON(a.iafas=b.ae_codigosunasa ) 
WHERE id=$id
";

if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array
while($row = pg_fetch_array($result)) 
{   
    $id=$row['id'];
    $iafa=$row['iafa'];
    $lote=$row['lote'];
    $lote_tedef=$row['lote_tedef'];
	$estado=$row['estado'];
	$descripcion=$row['descripcion'];
    $tlote=$row['tlote'];
    $codiafas=$row['codiafas'];
    $idtlote=$row['idtlote'];
    $json[] = array(
                'id'=>$id,'iafa'=> $iafa,'lote'=> $lote,'lote_tedef'=> 
                $lote_tedef,'estado'=>$estado,'descripcion'=> $descripcion, 'tlote'=>$tlote,'codiafas'=>$codiafas,'idtlote' => $idtlote
                );
}

$json_string = json_encode($json);
echo $json_string;



?>