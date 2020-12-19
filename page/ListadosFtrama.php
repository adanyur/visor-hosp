<?php
session_start();
?>
<!---NAVEGADOR--->
<?php include('../incluide/heard.php');?>
<!--FORMULARIO-->
    <div class="container p-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <div class="card-header text-center">
                            <h3>Fuera de trama</h3>
                        </div>
                    <div class="card-body">                            
                            <form id="FueraTrama">
                                    <input class="form-control mr-sm-2" id="buscar" type="search" placeholder="Buscar" aria-label="Search">
                            </form>
                             <p>
                            <table class="table table-hover text-center">
                            <thead>
                                <tr >
                                    <th width="200">IAFAS </th>
                                    <th>LOTE</th>
                                    <th>LOTE TEDEF</th>
                                    <th width="200">FACTURA</th>
                                    <th width="300">OBSERVACION</th>
                                    <th>USUARIO</th>
                                    <th>FECHA</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="ResultFtrama"></tbody>
                            <tbody id="ListadoFueratramaHO"></tbody>
                        </table> 
                     </div>
                </div>  
            </div>    
        </div>
    </div>
    <!---MODAL-->
<?php include('../incluide/modal-edit.php');?>
<?php include('../incluide/modal-mensaje.php');?>
<?php include('../incluide/footer.php');?>