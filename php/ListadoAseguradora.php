<?php

include('database.php');


$sql="
SELECT trim(ae_codi) AS ae_codi,
       trim(ae_dcorta) AS ae_dcorta,
       trim(ae_codigosunasa) AS ae_codigosunasa
FROM aseguradora
WHERE length(ae_codigosunasa) <> '0'
";

if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array
while($row = pg_fetch_array($result)) 
{ 
    $ae_codi=$row['ae_codi'];
    $ae_dcorta=$row['ae_dcorta'];
    $ae_codigosunasa=$row['ae_codigosunasa'];
	$json[] = array('ae_codi'=> $ae_codi,'ae_dcorta'=> $ae_dcorta,'ae_codigosunasa'=> $ae_codigosunasa);
}

$json_string = json_encode($json);
echo $json_string;


?>