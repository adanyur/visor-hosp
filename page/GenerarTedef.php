<?php
session_start();
?>
<!---NAVEGADOR--->
<?php include('../incluide/heard.php');?>
<!--FORMULARIO-->
    <div class="container p-4">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <form id="generarTrama">
                            <div class="form-group">
                                    <select class="form-control" id="Aseguradora"></select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="TipoLote"></select>
                            </div>    
                            <div class="form-group">
                                <input type="text" id="lote" class="form-control" placeholder="INGRESAR LOTE" autofocus>
                            </div>
                            <button type="submit" class="TEDEF btn btn-primary btn-block text-center">
                                    Generar TEDEF HOSP
                            </button>
                            <button type="button" class="nuevo btn btn-primary btn-block text-center">
                                    Nuevo
                            </button>
                        </form>
                    </div>
                </div>
            </div>  
            <!--LISTADO FUERA DE TRAMA-->
            <div class="col-md-7">
                    <table class="table table-hover text-center">
                       <thead>
                           <tr>
                               <th>IAFAS </th>
                               <th>LOTE</th>
                               <th>LOTE TEDEF</th>
                               <th>TIPO LOTE</th>
                           </tr>
                       </thead>
                       <tbody id="LotesHO"></tbody>
                   </table> 
            </div>    
        </div>
    </div>
    <div id="mensaje-validacion"></div>    
<?php include('../incluide/modal-mensaje.php');?> 
<?php include('../incluide/modal-carga.php');?> 
<?php include('../incluide/footer.php');?>