<?php

include('database.php');


$sql="
select id_texto as codigo,
		descripcion
from tabla_maestra  WHERE id_tabla=17 AND nro not in(0)
";

if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array
while($row = pg_fetch_array($result)) 
{ 
    $codigo=$row['codigo'];
    $descripcion=$row['descripcion'];
	$json[] = array('codigo'=> $codigo,'descripcion'=> $descripcion);
}

$json_string = json_encode($json);
echo $json_string;



?>