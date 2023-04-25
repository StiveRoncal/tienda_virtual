<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <form id="formUsuario" name="formUsuario" class="form-horizontal">
                <input type="hidden" id="idUsuario" name="idUsuario" value="">
                <p class="text-primary">Todos Los Campos Son Obligatorios.</p>

                <!-- Identificacion -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txtIdentificacion">Identificación</label>
                        <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" required="">
                    </div>
                </div>


                <!-- Nombres y Apellido -->

                <div class="form-row">
                    <!-- Nombre -->
                    <div class="form-group col-md-6">
                        <label for="txtNombre">Nombres</label>
                        <input type="text" class="form-control" id="txtNombre" name="txtNombre" required="">
                    </div>
                    <!-- Apellido -->
                    <div class="form-group col-md-6">
                        <label for="txtApellido">Apellidos</label>
                        <input type="text" class="form-control" id="txtApellido" name="txtApellido" required="">
                    </div>
                </div>



                 <!-- Telefono y Email -->

                 <div class="form-row">
                    <!-- Telefono -->
                    <div class="form-group col-md-6">
                        <label for="txtTelefono">Teléfono</label>
                        <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" required="">
                    </div>
                    <!-- Email -->
                    <div class="form-group col-md-6">
                        <label for="txtEmail">Email</label>
                        <input type="text" class="form-control" id="txtEmail" name="txtEmail" required="">
                    </div>
                </div>


                <!-- Rol usuario y Status -->
                <div class="form-row">
                    <!-- Rol Usuario -->
                    <div class="form-group col-md-6">
                        <label for="listRolid">Rol Usuario</label>
                        <select  class="form-control" data-live-search="true" name="listRolid" id="listRolid" required></select>
                    </div>
                    <!-- Status -->
                    <div class="form-group col-md-6">
                        <label for="listStatus">Status</label>
                        <select  class="form-control selectpicker" name="listStatus" id="listStatus" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>


                <!-- Contraseña -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txtPassword">Password</label>
                        <input type="password" class="form-control" id="txtPassword" name="txtPassword">
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


