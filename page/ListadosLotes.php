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
                                <h3>Lotes</h3>
                            </div>
                    <div class="card-body">
                            <form id="BuscarLotes">
                                    <input class="form-control mr-sm-2" id="buscarLotes" type="search" placeholder="Buscar" aria-label="Search">
                            </form>
                            <p>
                            <table class="table table-hover text-center">
                            <thead>
                                <tr >
                                    <th>IAFAS </th>
                                    <th>LOTE</th>
                                    <th>LOTE TEDEF</th>
                                    <th>TIPO LOTE</th>
                                    <th>ESTADO</th>
                                </tr>
                            </thead>
                            <tbody id="ResultLotes"></tbody>
                            <tbody id="ListadoLotesHO"></tbody>
                        </table> 
                     </div>
                </div>  
            </div>    
        </div>
    </div>
<?php include('../incluide/footer.php');?>