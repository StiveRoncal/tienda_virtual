<?php

    headerAdmin($data);


?>
<main class="app-content">
      <div class="row user">
        <div class="col-md-12">
          <div class="profile">
            <div class="info"><img class="user-img" src="<?= media();?>/images/avatar3.png">
              <h4><?= $_SESSION['userData']['nombres'].' '.$_SESSION['userData']['apellidos'];?></h4>
              <p><?= $_SESSION['userData']['nombrerol'];?></p>
            </div>
            <div class="cover-image"></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
              <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-toggle="tab">Datos Personales</a></li>
              <li class="nav-item"><a class="nav-link" href="#user-settings" data-toggle="tab">Datos Fiscales</a></li>
              <!-- <li class="nav-item"><a class="nav-link" href="#datos" data-toggle="tab">Pagos</a></li> -->
            </ul>
          </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane active" id="user-timeline">
              <div class="timeline-post">
                <div class="post-media">
                  <div class="content">
                    <h5>DATOS PERSONALES <button class="btn btn-sm btn-info" type="button" onclick="OpenModalPerfil();"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button> </h5>
                    
                  </div>
                </div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="width:150px;">Identificación:</td>
                            <td id="celIdentificacion"><?= $_SESSION['userData']['identificacion']; ?></td>
                        </tr>
                        <tr>
                            <td style="width:150px;">Nombres:</td>
                            <td id="celNombre"><?= $_SESSION['userData']['nombres']; ?></td>
                        </tr>
                        <tr>
                            <td style="width:150px;">Apellidos:</td>
                            <td id="celApellido"><?= $_SESSION['userData']['apellidos']; ?></td>
                        </tr>
                        <tr>
                            <td style="width:150px;">Teléfono:</td>
                            <td id="celTelefono"><?= $_SESSION['userData']['telefono']; ?></td>
                        </tr>
                        <tr>
                            <td style="width:150px;">Email (Usuario):</td>
                            <td id="celEmail"><?= $_SESSION['userData']['email_user']; ?></td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="user-settings">
              <div class="tile user-settings">
                <h4 class="line-head">Datos Fiscales</h4>
                
                <form id="formDataFiscal" name="formDataFiscal">
                  <div class="row mb-4">
                    <div class="col-md-6">
                      <label>Identificación DNI/RUC</label>
                      <input class="form-control" type="text" id="txtDni" name="txtDni" value="<?= $_SESSION['userData']['dni']?>">
                    </div>
                    <div class="col-md-6">
                      <label>Nombre Fiscal Razon Social / Dni</label>
                      <input class="form-control" type="text" id="txtNombreFiscal" name="txtNombreFiscal" value="<?= $_SESSION['userData']['nombrefiscal']?>">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 mb-4">
                      <label>Dirección Fiscal</label>
                      <input class="form-control" type="text" id="txtDirFiscal" name="txtDirFiscal" value="<?= $_SESSION['userData']['direccionfiscal']?>">
                    </div>
                  </div>
                  <div class="row mb-10">
                    <div class="col-md-12">
                      <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Guardar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- <div class="tab-pane fade" id="datos">
                <div class="tile user-settings">
                    <p>Pagos</p>
                </div>
            </div> -->
          </div>
        </div>
      </div>
    </main>
<?php footerAdmin($data); ?>