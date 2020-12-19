<?php
session_start();
include('database.php');

$usuario=$_POST['usuario'];
$contrasena=$_POST['clave'];

$sql="SELECT us_codigo,fr_c_decodifica_password(us_clave)as us_clave FROM sg_usuarios WHERE us_codigo='$usuario'";
$result = pg_exec($sql);
while($row = pg_fetch_array($result)) 
{ 
    $us_codigo=$row['us_codigo'];
    $us_clave=$row['us_clave'];
}

$count = pg_num_rows($result);


   if ($usuario==$us_codigo && $contrasena==$us_clave){
        $_SESSION['usuario']=$usuario;
        $_SESSION['tedef']='Trama Generado';
        $_SESSION['mensaje-update']='Se actualizo los datos....';

        echo 1;
    }else{
        echo 0; 
    }
        



?>