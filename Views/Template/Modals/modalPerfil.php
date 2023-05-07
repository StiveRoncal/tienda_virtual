<!-- Modal Formulario Nuevo Usuario -->
<div class="modal fade" id="modalFormPerfil" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <form id="formPerfil" name="formPerfil" class="form-horizontal">
              
                <p class="text-primary">Los Campos con Asterisco(<span class="required">*</span>) Son Obligatorios</p>

                <!-- Identificacion -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txtIdentificacion">Identificación <span class="required">*</span></label>
                        <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" value="<?= $_SESSION['userData']['identificacion']?>" required="">
                    </div>
                </div>


                <!-- Nombres y Apellido -->

                <div class="form-row">
                    <!-- Nombre -->
                    <div class="form-group col-md-6">
                        <label for="txtNombre">Nombres <span class="required">*</span></label>
                        <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" value="<?= $_SESSION['userData']['nombres']?>" required="">
                    </div>
                    <!-- Apellido -->
                    <div class="form-group col-md-6">
                        <label for="txtApellido">Apellidos <span class="required">*</span></label>
                        <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido"  value="<?= $_SESSION['userData']['apellidos']?>" required="">
                    </div>
                </div>



                 <!-- Telefono y Email -->

                 <div class="form-row">
                    <!-- Telefono -->
                    <div class="form-group col-md-6">
                        <label for="txtTelefono">Teléfono <span class="required">*</span></label>
                        <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" value="<?= $_SESSION['userData']['telefono']?>" required="" onkeypress="return controlTag(event);">
                    </div>
                    <!-- Email Bloqueo de input con readonly y bloquear desabled-->
                    <div class="form-group col-md-6">
                        <label for="txtEmail">Email</label>
                        <input type="text" class="form-control valid validEmail" id="txtEmail" name="txtEmail" value="<?= $_SESSION['userData']['email_user']?>" required="" readonly disabled >
                    </div>
                </div>


           


                <!-- Contraseña -->
                <div class="form-row">
                    <!-- Nuevo Contraseña-->
                    <div class="form-group col-md-6">
                        <label for="txtPassword">Password</label>
                        <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                    </div>

                    <!-- Repetir contraseña -->
                    <div class="form-group col-md-6">
                        <label for="txtPasswordConfirm">Confirmar Password</label>
                        <input type="password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm">
                    </div>
                </div>

                  <!-- Botones -->
                <div class="tile-footer">
                    <button  id="btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                </div>

                
              </form>
          
      </div>
  
    </div>
  </div>
</div>


