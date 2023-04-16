<!-- Modal de Permisos -->

<div class="modal fade modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      
      <!-- Encabezado -->
      <div class="modal-header">
        <h5 class="modal-title h4">Permisos Roles de Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>

      <!-- Cuerpo -->
      <div class="modal-body">
      <?php

        //dep($data);
      
      ?>

      <div class="col-md-12">
          <div class="tile">
           <form action="" id="formPermisos" name="formPermisos">
            <!-- imput escodndido  con el id de rol para guardlo con eso-->
            <input type="hidden" name="idrol" id="idrol" value="<?= $data['idrol'];?>" required="">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Módulo</th>
                    <th>Ver</th>
                    <th>Crear</th>
                    <th>Actualizar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                
                // Codigo para
                $no = 1;
                // ingresae modulo
                $modulos = $data['modulos'];
                
                for($i = 0; $i < count($modulos); $i++){

                  // inicia de 0 y la coutn cuenta desde 1
                  $permisos = $modulos[$i]['permisos'];
                  // verificar si en el arreglo lo puedo igualar o dejar 0 como estaba, para que camnie el atributo de off a on
                  $rCheck = $permisos['r'] == 1 ? " checked " : "";
                  $wCheck = $permisos['w'] == 1 ? " checked " : "";
                  $uCheck = $permisos['u'] == 1 ? " checked " : "";
                  $dCheck = $permisos['d'] == 1 ? " checked " : "";

                  $idmod = $modulos[$i]['idmodulo'];
                
                ?>

                  <tr>
                    <td>
                      <?= $no;?>
                      <input type="hidden" name="modulos[<?= $i; ?>][idmodulo]" value="<?= $idmod;?>">
                    </td>
                    
                    <!-- Modulo -->
                    <td>
                        <?= $modulos[$i]['titulo']; ?>
                    </td>

                 

                    <!-- Leer -->
                    <td>
                      <div class="toggle-flip">
                            <label>
                             <input type="checkbox" name="modulos[<?= $i; ?>][r]" <?= $rCheck ?> >
                             <span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                            </label>
                      </div>
                    </td>

                    <!-- Escribir -->
                    <td>
                      <div class="toggle-flip">
                            <label>
                             <input type="checkbox" name="modulos[<?= $i; ?>][w]" <?= $wCheck ?>>
                             <span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                            </label>
                      </div>
                    </td>

                    <!-- actualizar -->
                    <td>
                      <div class="toggle-flip">
                            <label>
                             <input type="checkbox" name="modulos[<?= $i; ?>][u]" <?= $uCheck ?>>
                             <span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                            </label>
                      </div>
                    </td>

                    <!-- Eliminar -->
                    <td>
                      <div class="toggle-flip">
                            <label>
                             <input type="checkbox" name="modulos[<?= $i; ?>][d]" <?= $dCheck?>>
                             <span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                            </label>
                      </div>
                    </td>
                  </tr> 
                <?php
                  $no++;
                }
                ?>
                </tbody>
              </table>
            </div>

            <!-- Botones de Permisos -->
            <div class="text-center">
                <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i> Guardar</button>
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="app-menu__icon fas fa-sign-out-alt" aria-hidden="true"></i> Salir</button>
            </div>
            <!-- Form Final -->
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>