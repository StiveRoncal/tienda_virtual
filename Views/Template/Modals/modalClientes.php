<!-- Modal Formulario Nuevo CLIENTE -->
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
                <p class="text-primary">Los Campos con Asterisco(<span class="required">*</span>) son Obligatorios</p>

                
               

                <!--Identificacion, Nombres y Apellido -->

                <div class="form-row">
                    <!-- Identificacion -->
                    <div class="form-group col-md-4">
                        <label for="txtIdentificacion">Identificación <span class="required">*</span></label>
                        <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" required="">
                    </div>
                    <!-- Nombre -->
                    <div class="form-group col-md-4">
                        <label for="txtNombre">Nombres <span class="required">*</span></label>
                        <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                    </div>
                    <!-- Apellido -->
                    <div class="form-group col-md-4">
                        <label for="txtApellido">Apellidos <span class="required">*</span></label>
                        <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
                    </div> 
                  

                </div>



                 <!-- Telefono y Email -->

                 <div class="form-row">
                    <!-- Telefono -->
                    <div class="form-group col-md-4">
                        <label for="txtTelefono">Teléfono <span class="required">*</span></label>
                        <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                    </div>
                    <!-- Email -->
                    <div class="form-group col-md-4">
                        <label for="txtEmail">Email <span class="required">*</span></label>
                        <input type="text" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
                    </div>

                      <!-- Password -->
                      <div class="form-group col-md-4">
                        <label for="txtPassword">Password</label>
                        <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                    </div>
                </div>
                
                <hr>
                
                <p class="text-primary">Datos Fiscales.</p>

                <!-- DATOS FISCALES: identificacion,nombre,direccopm -->
                <div class="form-row">
                    <!-- identificacion -->
                    <div class="form-group  col-md-6">
                        <label for="">Identificacion tributarioa <span class="required">*</span></label>
                        <input class="form-control" type="text" id="txtDni" name="txtDni" required="">
                    </div>
                    <!-- Nombres -->
                    <div class="form-group col-md-6">
                        <label for="">Nombre Fiscal <span class="required">*</span></label>
                        <input class="form-control" type="text" id="txtNombreFiscal" name="txtNomFiscal" required="">
                    </div>
                    <!-- Direccion -->
                    <div class="form-group col-md-12">
                        <label for="">Dirección Fiscal <span class="required">*</span></label>
                        <input class="form-control" type="text" id="txtDirFiscal" name="txtDirFiscal" required="">
                    </div>

                </div>


                <!-- Contraseña -->
                <div class="form-row">
                    
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


