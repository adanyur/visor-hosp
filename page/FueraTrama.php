<?php
session_start();
?>
<!---NAVEGADOR--->
<?php include('../incluide/heard.php'); ?>
<!--FORMULARIO-->
<div class="container p-4">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form id="FueraTramaHO">
                        <div class="form-group">
                            <select class="form-control" id="TipoRetiro">
                                <option value="0">SELECCIONAR TIPO RETIRO</option>
                                <option value="FT">FUERA DE TRAMA</option>
                                <option value="RL">RETIRAR DEL LOTE</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="ListadoLotesAC"></select>
                        </div>
                        <div class="form-group">
                            <input type="text" id="factura" class="form-control" placeholder="INGRESAR FACTURA" value=''>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="observacion" placeholder="OBSERVACION" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block text-center">
                            Enviar
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
                        <th>IAFAS</th>
                        <th>LOTE</th>
                        <th>LOTE TEDEF</th>
                        <th>FACTURA</th>
                    </tr>
                </thead>
                <!--<tbody id="ListadoFueratramaHO"></tbody>-->
                <tbody id="ListadoFueratramaHOS"></tbody>
            </table>
        </div>
    </div>
</div>
<div id="mensaje-validacion"></div>
<?php include('../incluide/footer.php'); ?>