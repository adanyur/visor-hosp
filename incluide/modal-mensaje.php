<div class="modal fade" id="modal-mensaje">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal body -->
      <div class="modal-body">
        <?php 
          $url=basename($_SERVER['PHP_SELF']);
        switch ($url) {
              case "ListadosFtrama.php":
                  echo $_SESSION['mensaje-update'];
                  break;       
          }
        ?>
        <div id="mensaje"></div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>