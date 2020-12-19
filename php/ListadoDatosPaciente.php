<?php
include('database.php');


$factura=str_pad($_POST['factura'],7,"0",STR_PAD_LEFT);

$sql="
select
	f2.fc_numero as numero,
	f2.fc_cuenta as cuenta, 
	pl.pl_numhist as hc,
	'F'||f2.fc_serie||'-'||f2.fc_numero as factura,
	trim(pl.pl_codafilseg) as codigoAfiliado,
	trim(p.pfac_producto) as producto,
	trim(t.ta_desc ) as productoDescripcion,
	p.pfac_subtipocob as cobertura,
	p.pfac_dap1 as p1,
	case
	when length(p.pfac_nroaut)=0 then 
		'SIN DOCUMENTO'
	else
	p.pfac_nroaut
	end 
	 as p1,
	p.pfac_dap2 as p2,
	case
	when length(p.pfac_nroaut2)=0 then
		'SIN DOCUMENTO'
	else 
		p.pfac_nroaut2
	end as p2,
	p.pfac_coservicio as copagoVariable,
	p.pfac_deducible as copagoFijo
from facturas f2 
inner join pre_facturacion p on(f2.fc_cuenta =p.pfac_cuenta)
inner join planes_historia pl on(pl.pl_numhist =p.pfac_hc and p.pfac_tipocl::int=pl.pl_codplan)
inner join tipo_asegurado  t on(pl.pl_codaseg=t.ta_tarifa::int and p.pfac_producto=t.ta_codi)
where f2.fc_numero='$factura'
and f2.fc_serie='201'  
and pl_estado=1 order by f2.fc_numero;
";

if(!$result = pg_exec($sql)) die("no se ejecuto query");
$json = array(); //creamos un array
while($row = pg_fetch_array($result)) 
{ 
    $numero=$row['numero'];
	$cuenta=$row['cuenta'];
	$hc=$row['hc'];
    $codigoAfiliado=$row['codigoafiliado'];
	$producto=$row['producto'];
	$productoDescripcion=$row['productodescripcion'];
	$cobertura=$row['cobertura'];
	$copagoVariable=$row['copagovariable'];
	$copagoFijo=$row['copagofijo'];
	
	$json[] = array(
		'numero'=>$numero,
		'cuenta'=>$cuenta,
		'hc'=>$hc,
		'codigoAfiliado'=>$codigoAfiliado,
		'producto'=>$producto,
		'Desproducto'=>$productoDescripcion,
		'cobertura'=>$cobertura,
		'copagoVariable'=>$copagoVariable,
		'copagoFijo'=>$copagoFijo
	);
}

$json_string = json_encode($json);
echo $json_string;



?>