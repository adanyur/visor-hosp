<?php
//PRODUCCION
// $servidorbd = "kronos.clinicasantaisabel.com";
// $usuario = "admpgsql";
// $clave = "9+8+7ab*";
// $bd = "bd_isis";
// $enlace = pg_connect("host=".$servidorbd." port= 5432"." dbname=".$bd." user=".$usuario." password=".$clave) or die("existio un error al intentar conectarse al servidor de base de datos");


//DESARROLLO
$servidorbd = "localhost";
$usuario = "postgres";
$clave = "2009";
$bd = "bd_isis2";
$enlace = pg_connect("host=" . $servidorbd . " port= 5432" . " dbname=" . $bd . " user=" . $usuario . " password=" . $clave) or die("existio un error al intentar conectarse al servidor de base de datos");
