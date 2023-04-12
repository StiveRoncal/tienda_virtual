<!-- Modal -->
<div class="modal fade" id="modalFormRol" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Formularo de Vali Admin -->
        <div class="tile">
       
            <div class="tile-body">
              <form id="formRol" name="formRol">
                <input type="hidden" id="idRol" name="idRol" value="">
                <div class="form-group">
                  <label class="control-label">Nombre</label>
                  <input class="form-control" name="txtNombre" id="txtNombre" type="text" placeholder="Nombre del Rol" required="">
                </div>
                <div class="form-group">
                  <label class="control-label">Descripcion</label>
                  <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripción del Rol" required=""></textarea>
                </div>
                
                <!-- ComboBox -->
                <div class="form-group">
                    <label for="exampleSelect1">Estados</label>
                    <select class="form-control" id="listStatus" name="listStatus" required="">
                      <option value="1">Activo</option>
                      <option value="2">Inactivo</option>
                     
                    </select>
                  </div>

                  <!-- Botones -->
                <div class="tile-footer">
                    <button  id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
              </form>
            </div>
           
          </div>
      </div>
  
    </div>
  </div>
</div>


