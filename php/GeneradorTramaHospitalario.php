<?php
session_start();
include('database.php');
include('Generador_trama_HO.php');
require_once 'zip.class.php';

//VARIABLES
$lote=$_POST['lote'];
$tipolote=$_POST['tipolotes'];
$aseguradora=$_POST['aseguradoras'];
$result_aseguradora = explode('|', $aseguradora);
$result_tipolote = explode('|', $tipolote);
$loten=str_pad($lote,10,"0",STR_PAD_LEFT);
$usuario=$_SESSION['usuario'];
//NUMERO DE LOTE
$loteparagenerar=$result_tipolote[1].$loten;


//$result_aseguradora[0] CODIGO
//$result_aseguradora[1] CODIGO IAFAS
//$result_aseguradora[2] DESCRIPCION IAFAS

$count=validacionSiExiteLote($loteparagenerar);

if($count > 0){
	$resultado=validacion_lotes($loteparagenerar,$result_aseguradora[1]);
	$LoteTedef=generar_numero_lote($loteparagenerar,$result_aseguradora[1],$resultado);
	
	
	if($resultado == 0 ){
		$insert="INSERT INTO TEDEF(USUARIO_INICIO,FECHA_INICIO,LOTE_TEDEF,IAFAS,ESTADO,LOTE,TLOTE)
				  VALUES('$usuario',NOW(),$LoteTedef,'$result_aseguradora[1]',0,'$loteparagenerar','$result_tipolote[0]')";	
			pg_exec($insert);
	}
	
	///var/www/html/VisorTedef/TEDEF_HOSP/
	///VALIDACION SI EXISTE ARCHIVO
	$ArchivoZip=$lote." - (".$LoteTedef.")";
	$RutaDestinoTrama="/var/www/html/VisorTedef/TEDEF_HOSP/ArchivoPlano/".$ArchivoZip;
	$RutaDestino="/var/www/html/VisorTedef/TEDEF_HOSP/ArchivoPlano/";
	
	$count =count(glob($RutaDestino.'{*}',GLOB_BRACE)); //obtenemos todos los nombres de los ficheros
	$files = glob($RutaDestino.'{*}',GLOB_BRACE); //obtenemos todos los nombres de los ficheros
	
	if($count > 0){
		foreach($files as $file){
			$NumeroArchivo = opendir($file);
			while( ($archivo = readdir($NumeroArchivo)) !== false ) { 
				if($archivo <> ".." AND $archivo <> "."){
					$eliminar=$file."/".$archivo;
					unlink($eliminar); //ELIMINAR EL CONTENIDO DENTRO DE UN ARCHIVO 
				}
			}
			rmdir($file); 
			mkdir($RutaDestinoTrama, 0777, TRUE);
			
		}
	}else{
		mkdir($RutaDestinoTrama, 0777, TRUE);
	}
	
	//NOMBRE DE ArCHIVOS PARA CADA TABLA DEL TEDEF
	$dfac=$RutaDestinoTrama."/dfac_20100375061_00013383_".$result_aseguradora[1]."_".$LoteTedef."_".date('Ym')."_".date('Ymd');
	$date=$RutaDestinoTrama."/date_20100375061_00013383_".$result_aseguradora[1]."_".$LoteTedef."_".date('Ym')."_".date('Ymd');
	$dser=$RutaDestinoTrama."/dser_20100375061_00013383_".$result_aseguradora[1]."_".$LoteTedef."_".date('Ym')."_".date('Ymd');
	$dden=$RutaDestinoTrama."/dden_20100375061_00013383_".$result_aseguradora[1]."_".$LoteTedef."_".date('Ym')."_".date('Ymd');
	$dfar=$RutaDestinoTrama."/dfar_20100375061_00013383_".$result_aseguradora[1]."_".$LoteTedef."_".date('Ym')."_".date('Ymd');
	
	
	//FUNCIONES QUE GENERAN LA TRAMA
	$dfac_n=tedef_dfac($dfac,$loteparagenerar,$LoteTedef);
	IF($dfac_n > 0){
		$date_n=tedef_date($date,$loteparagenerar);
		IF($date_n > 0){
			$dser_n=tedef_dser($dser,$loteparagenerar);
				IF ($dser_n > 0){
					tedef_dden($dden);
					tedef_dfar($dfar);
							$r=0;					
				}ELSE{$r=3;}
		}ELSE{$r=2;}
	}ELSE{$r=1;}
	
	
	if($r==0){
	
		$RutaDescZip="/var/www/html/VisorTedef/TEDEF_HOSP/Descarga";
		$TotalZip = count(glob($RutaDescZip.'/{*.zip}',GLOB_BRACE));
		$zipTotal=glob($RutaDescZip.'/{*.zip}',GLOB_BRACE);
	
		if($TotalZip > 0 ){
			foreach($zipTotal as $total ){
				unlink($total);
			}
		}
	
		$zipper = new ZipArchiver;
		$RutaDescarga = "/var/www/html/VisorTedef/TEDEF_HOSP/Descarga/".$result_aseguradora[2]."-".$result_tipolote[0].".zip";
		$zip = $zipper->zipDir($RutaDestinoTrama, $RutaDescarga);
		$result=0;
	
	}
	

}else{
	$result=1;
}

echo $result;
?>


