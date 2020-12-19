<?php
session_start();
?>
<!---NAVEGADOR--->
<?php include('../incluide/heard.php');?>
<!--FORMULARIO-->
    <div class="container p-4">
            
        <div class="card">
            <div class="card-header text-center"><h3>Datos del Paciente</h3></div>
            <div class="card-body">
                <form id="Paciente"> 
                    <div class="form-group">
                    <input class="form-control" id="buscarPaciente" type="search" placeholder="Ingresar Factura" aria-label="Search">
                    </div>
                </form>
                <div class="container" id="DatosPaciente"></div>
            </div>
        </div>

    </div>
    <div id="mensaje-validacion"></div>
<?php include('../incluide/modal-editdatos.php');?>
<?php include('../incluide/footer.php');?>