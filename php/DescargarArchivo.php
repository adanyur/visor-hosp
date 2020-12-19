<?php

$RutaDescarga = "/var/www/html/VisorTedef/TEDEF_HOSP/Descarga/";
$files = glob($RutaDescarga.'{*.zip}',GLOB_BRACE);

foreach($files as $file){
$len=strlen("$RutaDescarga");
$archivo = substr($file,$len);

header('Content-type: "application/zip"'); 
header('Content-Disposition: attachment; filename="'.$archivo.'"'); 
readfile($file);
}


?>


