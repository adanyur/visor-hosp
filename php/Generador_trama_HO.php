<?php

set_time_limit(360);
include('database.php');


function validacionSiExiteLote($lote){
	$sql="SELECT COUNT(*) as total FROM facturas WHERE fc_nrodocenvio='$lote'";
	if(!$result = pg_exec($sql)) die("no se ejecuto query validacio si exite lote");

	while($row = pg_fetch_array($result)) 
		{ 
		return $row['total'];
		}
}



function validacion_lotes($lote,$iafas){

	$sql="SELECT COUNT(*) AS total FROM tedef WHERE lote='$lote' AND iafas='$iafas'";
	if(!$result = pg_exec($sql)) die("no se ejecuto query validacio lotes");
	while($row = pg_fetch_array($result)) 
	{ 
		$total=$row['total'];
	}
	
		if($total> 0){
			return 1;
		}else{
			return 0;
		}
	
	}

function generar_numero_lote($lote,$iafas,$count){
	if($count > 0){
		$sql = "SELECT 
					lote_tedef
				FROM TEDEF 
				WHERE lote='$lote' 
				AND   iafas='$iafas'
				";
	}else{
		$sql = "SELECT 
					lote_tedef + 1 AS lote_tedef
				FROM TEDEF 
				WHERE IAFAS='$iafas'
				ORDER BY lote_tedef  
				DESC LIMIT 1				
				";
	}

	if(!$result = pg_exec($sql)) die("no se ejecuto query generar numero lote");
	$clientes = array(); //creamos un array
	while($row = pg_fetch_array($result)) 
	{ 
		return $row['lote_tedef'];
		
	}
}


//FUNCIONES PARA GENERAR EL TEDEF HOSPITALARIO
//FUNCION PARA LA TABLA FACTURA DEL TEDEF
function tedef_dfac($archivo,$lote,$n_tedef){
$sql = "SELECT * FROM uf_tedef_dfac('$lote','$n_tedef')";
if(!$result = pg_exec($sql)) die("no se ejecuto query archivo fac");
$ar1= fopen($archivo.".txt","w+");
while($row = pg_fetch_array($result)) 
{ 
	$dato=$row['trama']."\r\n";
	fwrite($ar1,$dato);
}
	IF(fclose($ar1)){
		return 1;
	}else{
		return 0;
	}
}


//FUNCION PARA LA TABLA ATENCION DEL TEDEF
function tedef_date($archivo,$lote){
$sql = "SELECT * FROM uf_tedef_date('$lote')";
if(!$result = pg_exec($sql)) die("no se ejecuto query archivo date");
$ar1= fopen($archivo.".txt","w+");
while($row = pg_fetch_array($result)) 
{ 
	$dato=$row['trama']."\r\n";
	fwrite($ar1,$dato);
}
	IF(fclose($ar1)){
		return 1;
	}else{
		return 0;
	}
}

//FUNCION PARA LA TABLA SERVICIO DEL TEDEF
function tedef_dser($archivo,$lote){
$sql = "SELECT * FROM uf_tedef_dser('$lote')";
if(!$result = pg_exec($sql)) die("no se ejecuto query archivo dser");
$ar1= fopen($archivo.".txt","w+");
while($row = pg_fetch_array($result)) 
{ 
	$dato=$row['trama']."\r\n";
	fwrite($ar1,$dato);
}
	IF(fclose($ar1)){
		return 1;
	}else{
		return 0;
	}
}

function tedef_dden($archivo){
fopen($archivo.".txt","a+");
}

function tedef_dfar($archivo){
fopen($archivo.".txt","a+");
}


?>