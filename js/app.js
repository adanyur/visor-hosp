$(document).ready(function () {
  //@INICIO
  //FUNCIONES QUE SE EJECUTAN DE FORMA INMEDIATA
  ListadoLotes();
  ListadoAseguradora();
  ListadoLotesA();
  ListadoFtrama();
  ListadoTipoLotes();
  //
  /**************************************LOGIN***************************************************/
  $("#login").submit(function (e) {
    const data = {
      usuario: $("#usuario").val(),
      clave: $("#clave").val(),
    };
    $.post("php/LoginHO.php", data, function (result) {
      if (result == "1") {
        window.location.href = "page/GenerarTedef.php";
      } else {
        $("#modal-mensaje").modal("show");
        $("#mensaje-error").text(
          "Usuario o contraseña Incorrecto, Favor de Revisar"
        );
      }
    });
    e.preventDefault();
  });

  //CERRAR SESISION
  $("#cerrar-sesion").submit(function (e) {
    $.ajax({
      url: "../php/CerrarSession.php",
      type: "POST",
      success: function (result) {
        if (result == 1) {
          window.location.href = "../index.html";
        }
      },
    });
    e.preventDefault();
  });

  /**************************************GENERAR TRAMA***************************************************/
  //FUNCION PARA GENERAR LA TRAMA AMB
  $("#generarTrama").submit(function (e) {
    if ($("#Aseguradora").val() == "0") {
      validacionTedef(1);
    } else if ($("#TipoLote").val() == "0") {
      validacionTedef(2);
    } else if ($("#lote").val() == "") {
      validacionTedef(3);
    } else {
      let lote = $("#lote").val();
      let aseguradoras = $("#Aseguradora").val();
      let tipolotes = $("#TipoLote").val();

      $("#modal-carga").modal("show");
      $.ajax({
        data: { lote, aseguradoras, tipolotes },
        url: "../php/GeneradorTramaHospitalario.php",
        type: "POST",
        success: function (result) {
          if (result == 0) {
            $("#modal-carga").modal("hide");
            $("#modal-mensaje").modal("show");
            $("#mensaje").text("Trama Generado");
            $("#generarTrama").trigger("reset");
            ListadoLotes();
            ListadoAseguradora();
            ListadoTipoLotes();
            window.location.href = "../php/DescargarArchivo.php";
          } else {
            $("#modal-mensaje").modal("show");
            $("#modal-carga").modal("hide");
            $("#mensaje").text("El lote ingresado no contiene factura");
          }
        },
      });
    }
    e.preventDefault();
  });

  //FUNCION DE VALIDACION DATOS PARA GENERAR DATOS EN MODAL
  function validacionTedef(codigo) {
    let mensaje = "";
    let template = "";

    if (codigo == 1) {
      mensaje = "SELECIONAR ASEGURADORA";
    } else if (codigo == 2) {
      mensaje = "SELECCIONAR TIPO DE LOTE";
    } else {
      mensaje = "INGRESAR EL LOTE";
    }
    template += `
        <div class="modal fade" id="modal-validacion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        ${mensaje}
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    $("#mensaje-validacion").html(template);
    $("#modal-validacion").modal("show");
  }

  //BOTON NUEVO
  $(document).on("click", ".nuevo", function () {
    $("#generarTrama").trigger("reset");
    $("#FueraTramaHO").trigger("reset");
    ListadoAseguradora();
    ListadoTipoLotes();
  });

  /**************************************LISTADO DE LOTES***************************************************/
  //LISTADO DE IAFAS
  function ListadoAseguradora() {
    $.ajax({
      url: "../php/ListadoAseguradora.php",
      type: "GET",
      success: function (result) {
        let aseguradora = JSON.parse(result);
        let template = "";
        template += '<option value="0">SELECCIONAR IAFAS</option>';
        aseguradora.forEach((aseguradora) => {
          template += `<option id="codigo" value="${aseguradora.ae_codi}|${aseguradora.ae_codigosunasa}|${aseguradora.ae_dcorta}">${aseguradora.ae_dcorta}</option>`;
        });
        $("#Aseguradora").html(template);
      },
    });
  }

  //LISTADO DE TIPO DE LOTES
  function ListadoTipoLotes() {
    $.ajax({
      url: "../php/ListadoTLote.php",
      type: "GET",
      success: function (result) {
        let Tlote = JSON.parse(result);
        let template = "";
        template += '<option value="0">SELECIONAR TIPO LOTE</option>';
        Tlote.forEach((Tlote) => {
          template += `<option value="${Tlote.descripcion}|${Tlote.codigo}">${Tlote.descripcion}</option>`;
        });
        $("#TipoLote").html(template);
      },
    });
  }

  //LISTADO LOTES CON ESTADO ABIERTO EN LA TABLA
  function ListadoLotes() {
    $.ajax({
      url: "../php/ListadoLotesHO.php",
      type: "POST",
      data: { tipo: "B" },
      success: function (result) {
        let Llotes = JSON.parse(result);
        let template = "";
        let templateLotes = "";

        Llotes.forEach((Llotes) => {
          const estado = Llotes.estado;

          if (estado == "ABIERTO") {
            color = "background-color:#fffff;";
            icono = '<i class="fas fa-lock-open"></i>';
          } else {
            color = "background-color:#f443366e;";
            icono = '<i class="fas fa-lock"></i>';
          }

          if (estado == "ABIERTO") {
            template += `
                        <tr ida=${Llotes.id} class="table-default">
                            <td>${Llotes.iafa}</a></td>
                            <td>${Llotes.lote}</td>
                            <td>${Llotes.lote_tedef}</td>
                            <td>${Llotes.tlote}</td>
                            <td>
                                <button class="item btn btn-dark">
                                    <i class="fas fa-check"></i>
                                </button>
                            <td>
                        </tr> 
                    `;
          }

          templateLotes += `
                    <tr idL=${Llotes.id}|${estado} style=${color}>
                    <td>${Llotes.iafa}</td>
                    <td>${Llotes.lote}</td>
                    <td>${Llotes.lote_tedef}</td>
                    <td>${Llotes.tlote}</td>
                    <td>
                        <button class="editarL btn btn-dark">
                            ${icono}
                        </button>        
                    </td>
                </tr>                
                `;
        });
        $("#LotesHO").html(template);
        $("#ListadoLotesHO").html(templateLotes);
      },
    });
  }

  ///LISTADO DE LOTES ACTIVOS
  function ListadoLotesA() {
    $.ajax({
      url: "../php/ListadoLotesHO.php",
      type: "POST",
      data: { tipo: "A" },
      success: function (result) {
        let lote = JSON.parse(result);
        let template = "";
        template += '<option value="0">SELECCIONAR LOTE</option>';
        lote.forEach((lote) => {
          if (lote.estado == "ABIERTO") {
            template += `<option id="codigo" value="${lote.lote}|${lote.iafa}|${lote.lote_tedef}">${lote.descripcion}</option>`;
          }
        });
        $("#ListadoLotesAC").html(template);
      },
    });
  }

  /**************************************FUERA DE TRAMA***************************************************/
  //INSERTAR FACTURA FUERA DE TRAMA
  $("#FueraTramaHO").submit(function (e) {
    if ($("#ListadoLotesAC").val() == "0") {
      validacionFtrama(1);
    } else if ($("#factura").val() == "") {
      validacionFtrama(2);
    } else {
      const data = {
        id: $("#ListadoLotesAC").val(),
        factura: $("#factura").val(),
        observacion: $("#observacion").val(),
      };

      $.post("../php/InsertFtramaHO.php", data, function (result) {
        $("#FueraTramaHO").trigger("reset");
        ListadoFtrama();
      });
    }
    e.preventDefault();
  });

  function validacionFtrama(codigo) {
    let mensaje = "";
    let template = "";
    if (codigo == 1) {
      mensaje = "SELECCIONAR LOTE";
    } else if (codigo == 2) {
      mensaje = "INGRESAR FACTURA";
    } else {
      mensaje = "SELECCIONAR TIPO DE RETIRO";
    }

    template += `
<div class="modal fade" id="modal-validacion">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        ${mensaje}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
`;
    $("#mensaje-validacion").html(template);
    $("#modal-validacion").modal("show");
  }

  //LISTADO FUERA DE TRAMA HOSP
  function ListadoFtrama() {
    $.ajax({
      url: "../php/ListadoFueraTramaHO.php",
      type: "GET",
      success: function (result) {
        let ftrama = JSON.parse(result);
        let template = "";
        let templatel = "";
        ftrama.forEach((ftrama) => {
          template += `
                <tr id="${ftrama.id}">
                        <td>${ftrama.iafas}</td>
                        <td>${ftrama.lote}</td>
                        <td>${ftrama.lote_tedef}</td>
                        <td>${ftrama.factura}</td>
                        <td>
                            <button class="eliminar btn btn-danger">
                                <i class="fas fa-trash-alt "></i>
                            </button>
                        </td>
                    </tr>
                    `;

          templatel += `
                    <tr id="${ftrama.id}">
                        <td>${ftrama.iafas}</td>
                        <td>${ftrama.lote}</td>
                        <td>${ftrama.lote_tedef}</td>
                        <td>F201-${ftrama.factura}</td>
                        <td>${ftrama.observacion}</td>
                        <td>${ftrama.usuario}</td>
                        <td>${ftrama.fecha}</td>
                        <td>
                            <button type="button" class="edit-modal btn btn-primary" data-toggle="modal" data-target="#modal-edit" data-whatever="@mdo">
                                <i class="fas fa-pencil-alt "></i>
                            </button>
                        </td>
                        <td>        
                            <button class="eliminar btn btn-danger">
                               <i class="fas fa-trash-alt "></i>
                           </button>
                        </td>
                    </tr>
                    `;
        });
        $("#ListadoFueratramaHOS").html(template);
        $("#ListadoFueratramaHO").html(templatel);
      },
    });
  }
  /**************************************OPCION DE BUSQUEDA***************************************************/
  //BUSQUEDA DE FACTURA O LOTE PARA FUERA DE TRAMA
  $("#buscar").keyup(function () {
    if ($("#buscar").val()) {
      let buscar = $("#buscar").val();
      $.ajax({
        url: "../php/BuscarFtrama.php",
        data: { buscar },
        type: "POST",
        success: function (result) {
          if (!result.error) {
            let buscar = JSON.parse(result);
            let template = "";
            buscar.forEach((buscar) => {
              if (buscar.reg > 0) {
                template += `
                <tr id="${buscar.id}">
                     <td>${buscar.iafas}</td>
                     <td>${buscar.lote}</td>
                     <td>${buscar.lote_tedef}</td>
                     <td>F201-${buscar.factura}</td>
                     <td>${buscar.observacion}</td>
                     <td>${buscar.usuario}</td>
                     <td>${buscar.fecha}</td>
                     <td>
                        <button type="button" class="edit-modal btn btn-primary" data-toggle="modal" data-target="#modal-edit" data-whatever="@mdo">
                            <i class="fas fa-pencil-alt "></i>
                        </button>
                      </td>
                      <td>     
                        <button class="eliminar btn btn-danger">
                            <i class="fas fa-trash-alt x1 "></i>
                        </button>
                    </td>
                 </tr>
              `;
              } else {
                template += `
              <tr>
                  <td colspan='10'>
                      <div class="card">
                          <div class="card-body">No hay registros</div>
                      </div>
                  </td>
              </tr `;
              }
            });
            $("#ListadoFueratramaHO").hide();
            $("#ResultFtrama").show();
            $("#ResultFtrama").html(template);
          }
        },
      });
    } else {
      $("#ResultFtrama").hide();
      $("#ListadoFueratramaHO").show();
    }
  });
  //BUSQUEDA POR LOTE,IAFAS,USUARIO Y FECHA
  $("#buscarLotes").keyup(function () {
    var a = $("#buscarLotes").val();
    if ($("#buscarLotes").val()) {
      let buscarLotes = $("#buscarLotes").val();
      $.ajax({
        url: "../php/BuscarLotes.php",
        data: { buscarLotes },
        type: "POST",
        success: function (result) {
          if (!result.error) {
            let buscarLotes = JSON.parse(result);
            let template = "";
            buscarLotes.forEach((buscarLotes) => {
              let estado = buscarLotes.estado;

              if (estado == "ABIERTO") {
                color = "background-color:#ffffff;";
                icono = '<i class="fas fa-lock-open"></i>';
              } else {
                color = "background-color:#f443366e;";
                icono = '<i class="fas fa-lock "></i>';
              }

              if (buscarLotes.reg > 0) {
                template += `
            <tr idL=${buscarLotes.id}|${estado} style=${color}>
                        <td>${buscarLotes.iafas}</td>
                        <td>${buscarLotes.lote}</td>
                        <td>${buscarLotes.lote_tedef}</td>
                        <td>${buscarLotes.tlote}</td>
                        <td>
                            <button class="editarL btn btn-dark">
                                ${icono}
                            </button>
                        </td>
                    </tr>
                         `;
              } else {
                template += `
                    <tr>
                        <td colspan='5'>
                            <div class="card">
                                <div class="card-body">No hay registros</div>
                            </div>
                        </td>
                    </tr>
                    `;
              }
            });
            $("#ListadoLotesHO").hide();
            $("#ResultLotes").show();
            $("#ResultLotes").html(template);
          }
        },
      });
    } else {
      $("#ResultLotes").hide();
      $("#ListadoLotesHO").show();
    }
  });

  //BUSQUEDA DE DATOS DE PACIENTE
  $("#buscarPaciente").keyup((e) => {
    let documento = $("#buscarPaciente").val();
    if (documento.length == "5") {
      const data = { factura: documento };
      PacienteDatos(data);
    }
    e.preventDefault();
  });

  const PacienteDatos = (data) => {
    $.post("../php/ListadoDatosPaciente.php", data, (result) => {
      let dataPaciente = JSON.parse(result);
      let template = "";
      dataPaciente.forEach((data) => {
        template = `
                  <div class="row">
                    <div class="col">
                      <div class="card text-white bg-primary">
                        <div class="card-body text-center">
                              <h6 class="card-title">
                                  <div class="row">
                                    <div class="col-2">PRODUCTO</div>
                                    <div class="col-2">CODIGO AFILIADO</div>
                                    <div class="col-2">COBERTURA</div>
                                    <div class="col-2">COPAGO FIJO</div>
                                    <div class="col-2">COPAGO VARIABLE</div>
                                  </div>
                              </h6>
                        </div>
                      </div>  
                    </div>
                    <div class="w-100 p-1"></div>
                    <div class="col">
                      <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title">
                              <div class="row">
                                  <div class="col-2">${data.Desproducto}</div>
                                  <div class="col-2">${data.codigoAfiliado}</div>
                                  <div class="col-2">${data.cobertura}</div>
                                  <div class="col-2">${data.copagoFijo}</div>
                                  <div class="col-2">${data.copagoVariable}</div>
                                  <div class="col-2" codigo="${data.numero}">
                                    <button type="button" class="obtenerData btn btn-primary" data-toggle="modal" data-target="#modal-editdatos" data-whatever="@mdo">
                                      <i class="fas fa-pencil-alt "></i>
                                    </button>
                                  </div>
                              </div>
                            </h6>
                        </div>
                      </div>  
                    </div>
                  </div>
                `;

        $("#DatosPaciente").html(template);
      });
    });
  };
  /**************************************OPCION DE ACTUALIZAR ESTADO***************************************************/

  $(document).on("click", ".obtenerData", (e) => {
    const element = $(this)[0].activeElement.parentElement;
    const factura = $(element).attr("codigo");
    $.post("../php/ListadoDatosPaciente.php", { factura }, (result) => {
      let template = "";
      let dataP = JSON.parse(result);
      dataP.forEach((d) => {
        template = `
            <div class="form-group row">
                <label class="col-3 col-form-label">PRODUCTO:</label>
                <div class="col-5">
                  <input type="text" class="form-control" id="producto" value="${d.producto}">
                </div>  
                <div class="col-3" id="${d.cuenta}|${d.hc}|PRE|${d.numero}">
                  <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
                </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-form-label">CODIGO AFILIADO:</label>
              <div class="col-5">
                <input type="text" class="form-control" id="codigoAfiliado" value="${d.codigoAfiliado}">
              </div>
              <div class="col-3" id="${d.cuenta}|${d.hc}|PLANES|${d.numero}">
                <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3 col-form-label">COBERTURA:</label>
              <div class="col-5">
                <input type="text" class="form-control" id="cobertura" value="${d.cobertura}">
              </div>
              <div class="col-3" id="${d.cuenta}|${d.hc}|PRE|${d.numero}">
                <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
              </div>
            </div>`;

        $("#DatoSiteds").html(template);
      });
    });
    e.preventDefault();
  });

  $("#editSiteds").submit((e) => {
    let element = $(this)[0].activeElement.parentElement;
    const datos = $(element).attr("id");

    const data = {
      producto: $("#producto").val(),
      codigoAfiliado: $("#codigoAfiliado").val(),
      cobertura: $("#cobertura").val(),
      boton: datos,
    };

    $.post("../php/ActualizacionDatos.php", data, (result) => {
      const data = { factura: result };
      PacienteDatos(data);
      $("#Paciente").trigger("reset");
      $("#modal-editdatos").modal("hide");
    });
    e.preventDefault();
  });

  /**************************************OPCION DE ACTUALIZAR ESTADO***************************************************/
  $(document).on("click", ".editarL", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const id = $(element).attr("idl");
    $.post("../php/CambioEstadoHO.php", { id }, (result) => {
      ListadoLotes();
      $("#ResultLotes").hide();
      $("#ListadoLotesHO").show();
      $("#BuscarLotes").trigger("reset");
    });
    e.preventDefault();
  });
  /**************************************OPCION DE ELIMINAR***************************************************/
  $(document).on("click", ".eliminar", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const id = $(element).attr("id");
    $.post("../php/EliminarHO.php", { id }, (result) => {
      ListadoFtrama();
      $("#ResultFtrama").hide();
      $("#ListadoFueratramaHO").show();
      $("#FueraTrama").trigger("reset");
    });
    e.preventDefault();
  });
  /**************************************OPCION PARA USAR DATOS***************************************************/
  $(document).on("click", ".item", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const id = $(element).attr("ida");
    $.post("../php/DatosItem.php", { id }, (result) => {
      const item = JSON.parse(result);
      item.forEach((item) => {
        let DatosAseguradora = "";
        let TipoLote = "";

        DatosAseguradora = `
                        <option value="${item.lote}|${item.codiafas}|${item.iafa}">${item.iafa}</option>'
                                    `;
        TipoLote = `
                            <option value="${item.tlote}|${item.idtlote}">${item.tlote}</option>'
                            `;
        $("#Aseguradora").html(DatosAseguradora);
        $("#TipoLote").html(TipoLote);
        $("#lote").val(item.lote);
      });
    });

    e.preventDefault();
  });

  /*****************************************MODAL DATOS***********************************************/

  $(document).on("click", ".edit-modal", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const id = $(element).attr("id");

    $.post("../php/DatosFtrama.php", { id }, (result) => {
      const itemftrama = JSON.parse(result);
      let template = "";
      let templateCabecera = "";
      itemftrama.forEach((itemftrama) => {
        templateCabecera += `<b>FACTURA : F201-${itemftrama.factura}</b>`;
        template += `
                <div class="form-group">
                    <label for="message-text" class="col-form-label">OBSERVACION</label>
                    <input type="hidden" id="factura" value="${itemftrama.factura}">
                    <textarea class="form-control" id="message-text">${itemftrama.observacion}</textarea>
                </div>    
                `;
      });
      $("#EditFtrama").html(template);
      $("#cabecera-modal").html(templateCabecera);
    });
    e.preventDefault();
  });

  /************************************UPDATE MODAL******************************************/

  $("#edit-ftrama").submit(function (e) {
    if ($("#Aseguradora").val() == "0") {
      validacionModal(1);
    } else if ($("#ListadoLotesAC").val() == "0") {
      validacionModal(2);
    } else {
      let aseguradora = $("#Aseguradora").val();
      let lotes = $("#ListadoLotesAC").val();
      let factura = $("#factura").val();
      let observaciones = $("#message-text").val();

      $.ajax({
        url: "../php/ActualizarFtrama.php",
        data: { aseguradora, lotes, observaciones, factura },
        type: "POST",
        success: function (result) {
          $("#ResultFtrama").hide();
          $("#ListadoFueratramaHO").show();
          $("#FueraTrama").trigger("reset");
          $("#modal-edit").modal("hide");
          $("#edit-ftrama").trigger("reset");
          ListadoFtrama();
          if (result == 1) {
            $("#modal-mensaje").modal("show");
          }
        },
      });
    }
    e.preventDefault();
  });
  ///validacion

  function validacionModal(codigo) {
    let mensaje = "";
    let template = "";
    if (codigo == 1) {
      mensaje = "SELECIONAR ASEGURADORA";
    } else if (codigo == 2) {
      mensaje = "SELECIONAR LOTE";
    }

    template += `
<div class="modal fade bd-example-modal-sm" id="modal-validacion">
 <div class="modal-dialog modal-sm modal-dialog-centered">
   <div class="modal-content" >
     <div class="modal-body">
       ${mensaje}
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
     </div>
   </div>
 </div>
</div>
`;
    $("#mensaje-validacion").html(template);
    $("#modal-validacion").modal("show");
  }
}); //@FIN
