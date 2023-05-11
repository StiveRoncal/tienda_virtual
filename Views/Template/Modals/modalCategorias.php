<!-- Modal Formulario Nuevo CLIENTE -->
<div class="modal fade" id="modalFormCategorias" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <form id="formCategoria" name="formCategoria" class="form-horizontal">
                <input type="hidden" id="idCategoria" name="idCategoria" value="">
                <p class="text-primary">Los Campos con Asterisco(<span class="required">*</span>) son Obligatorios</p>

                
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" id="idCategoria" name="idCategoria" value="">
                        <div class="form-group">
                          <label class="control-label">Nombre <span class="required">*</span></label>
                          <input class="form-control" name="txtNombre" id="txtNombre" type="text" placeholder="Nombre Categoria" required="">
                        </div>
                        <div class="form-group">
                          <label class="control-label">Descripción <span class="required">*</span></label>
                          <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripción La Categoria" required=""></textarea>
                        </div>
                        
                        <!-- ComboBox -->
                        <div class="form-group">
                            <label for="exampleSelect1">Estados <span class="required">*</span></label>
                            <select class="form-control" id="listStatus" name="listStatus" required="">
                              <option value="1">Activo</option>
                              <option value="2">Inactivo</option>
                            </select>
                        </div>    



                    </div>
                    <div class="col-md-6">
                        
                    <div class="photo">
                      <label for="foto">Foto (570x380)</label>
                          <div class="prevPhoto">
                            <span class="delPhoto notBlock">X</span>
                            <label for="foto"></label>
                              <div>
                                <img id="img" src="<?= media(); ?>/images/portada_categoria.png">
                              </div>
                          </div>
                            <div class="upimg">
                              <input type="file" name="foto" id="foto">
                            </div>
                          <div id="form_alert"></div>
                    </div>








                    </div>
                </div> 

              

                <!-- Botones -->
                <div class="tile-footer">
                    <button  id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                </div>

                
              </form>
          
      </div>
  
    </div>
  </div>
</div>




<!-- Modal Ver Detalle de CLIENTE  Registrado -->
<div class="modal fade" id="modalViewCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <table class="table table-bordered">
                <tbody>
                  <!-- Datos No Personales tipo Cuenta Dibujito -->
                    <tr>
                        <td>Identificación:</td>
                        <td id="celIdentificacion">787887878</td>
                    </tr>
                    <tr>
                        <td>Nombres:</td>
                        <td id="celNombre"></td>
                    </tr>
                    <tr>
                        <td>Apellidos:</td>
                        <td id="celApellido"></td>
                    </tr>
                    <tr>
                        <td>Teléfono:</td>
                        <td id="celTelefono"></td>
                    </tr>
                    <tr>
                        <td>Email (Usuario):</td>
                        <td id="celEmail"></td>
                    </tr>

                    <!-- DATOS FISCALES -->
                    <tr>
                        <td>Identificacion Tributaria:</td>
                        <td id="celIde"></td>
                    </tr>
                    <tr>
                        <td>Nombre Fiscal:</td>
                        <td id="celNomFiscal"></td>
                    </tr>
                    <tr>
                        <td>Dirección Fiscal:</td>
                        <td id="celDirFiscal"></td>
                    </tr>
                    <tr>
                        <td>Fecha Registro:</td>
                        <td id="celFechaRegistro"></td>
                    </tr>
                </tbody>
            </table> 
      </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
    </div>
  </div>
</div>


