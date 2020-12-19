<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="edit-ftrama"> <!--FORMULARIO-->
        <!--CABECERA-->
          <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><div id="cabecera-modal"></div>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          </div>
        <!--BODY-->
          <div class="modal-body">
          <div class="form-group">
              <label for="recipient-name" class="col-form-label">IAFAS</label>
              <select class="form-control" id="Aseguradora"></select>
            </div>
            <div class="form-group">
            <label for="recipient-name" class="col-form-label">lOTES ACTIVOS</label>
            <select class="form-control" id="ListadoLotesAC"></select>
            </div>
            <div class="form-group" id="EditFtrama">
            </div>
          </div>
        <!--FOOTER-->
          <div class="modal-footer">
            <button type="button" class="cerrar btn btn-secondary" data-dismiss="modal">CERRAR</button>
            <button type="submit" class="ftrama-modal btn btn-primary">ACTUALIZAR</button>
          </div>
			</form>
		</div>
  </div>
</div>
<div id="mensaje-validacion"></div>