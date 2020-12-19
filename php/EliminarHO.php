<?php

include('database.php');

$id=$_POST['id'];

$sql="DELETE FROM facturas_ftrama WHERE id=$id";

if(pg_exec($sql)){
    return 1;
}
else{
    return 2;
}


?>