<!-- Modal Formulario Nuevo Usuario -->
<div class="modal fade" id="modalFormCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <form id="formCliente" name="formCliente" class="form-horizontal">
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
                        <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                    </div>
                    <!-- Apellido -->
                    <div class="form-group col-md-6">
                        <label for="txtApellido">Apellidos</label>
                        <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
                    </div>
                </div>



                 <!-- Telefono y Email -->

                 <div class="form-row">
                    <!-- Telefono -->
                    <div class="form-group col-md-6">
                        <label for="txtTelefono">Teléfono</label>
                        <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                    </div>
                    <!-- Email -->
                    <div class="form-group col-md-6">
                        <label for="txtEmail">Email</label>
                        <input type="text" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
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




<!-- Modal Ver Detalle de Usuario Registrado -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <table class="table table-bordered">
                <tbody>
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
                    <tr>
                        <td>Tipo Usuario:</td>
                        <td id="celTipoUsuario"></td>
                    </tr>
                    <tr>
                        <td>Estado:</td>
                        <td id="celEstado"></td>
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


