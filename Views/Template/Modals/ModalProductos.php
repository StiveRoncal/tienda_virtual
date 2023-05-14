<!-- Modal Formulario Nuevo productos -->
<div class="modal fade" id="modalFormProductos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <form id="formProductos" name="formProductos" class="form-horizontal">

              
                <input type="hidden" id="idProducto" name="idProducto" value="">
              
                <p class="text-primary">Los Campos con Asterisco(<span class="required">*</span>) son Obligatorios</p>

                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                          <label class="control-label">Nombre Producto <span class="required">*</span></label>
                          <input class="form-control" name="txtNombre" id="txtNombre" type="text" required="">
                        </div>
                        <div class="form-group">
                          <label class="control-label">Descripción Producto<span class="required">*</span></label>
                          <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4"></textarea>
                        </div>
                        
        
                    </div>

                    <div class="col-md-4">

                            <div class="form-group">
                                <label for="" class="control-label">Código <span class="required">*</span></label>
                                <input class="form-control" id="txtCodigo" name="txtCodigo" type="text" placeholder="Código en Barra"  required="">
                                <br>
                                <!-- Codigo en Barras -->
                                <div id="divBarCode" class="notBlock textcenter">
                                    <!-- Img en Barra -->
                                    <div id="printCode">
                                      <svg id="barcode"></svg>
                                    </div>

                                    <button class="btn btn-success btn-sm" type="button" onClick="fntPrintBarcode('#printCode')"><i class="fas fa-print"></i> Imprimir</button>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Precio <span class="required">*</span></label>
                                    <input class="form-control " id="txtPrecio" name="txtPrecio" type="text" required="">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="control-label">Stock <span class="required">*</span></label>
                                    <input class="form-control" id="txtStock" name="txtStock" type="text"  required="">
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="listCategoria">Categoría <span class="required">*</span></label>
                                    <select class="form-control" data-live-search="true" name="listCategoria" id="listCategoria" required=""></select>
                                </div>

                                <div class="form-group col-md-6">
                                        <label for="listStatus">Estados <span class="required">*</span></label>
                                        <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                </div>
                            </div>

                      
                            <div class="row">
                                <div class="form-group col-md-6">
                                    
                                    <button  id="btnActionForm" class="btn btn-primary btn-lg btn-block" type="submit">
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>

                                </div>
                                <div class="form-group col-md-6">
                                    
                                    <button class="btn btn-danger btn-lg btn-block" type="button" data-dismiss="modal">
                                    <i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>

                                </div>
                            </div>    


                    </div>
                </div> 

              

                <!-- Botones -->
                <!-- <div class="tile-footer">
                </div> -->

                
              </form>
          
      </div>
  
    </div>
  </div>
</div>




<!-- Modal Ver Detalle de CLIENTE  Registrado -->
<div class="modal fade" id="modalViewCategoria" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos La Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <table class="table table-bordered">
                <tbody>
                  <!-- Datos de la categoria -->
                   <tr>
                    <td>ID:</td>
                    <td id="celId"></td>
                   </tr>

                   <tr>
                    <td>Nombres:</td>
                    <td id="celNombre">XXXXXXTTTT</td>
                   </tr>

                   <tr>
                    <td>Descripción:</td>
                    <td id="celDescripcion">zzzzz Stive roncal</td>
                   </tr>

                   <tr>
                    <td>Estado:</td>
                    <td id="celEstado">zzzzzz</td>
                   </tr>

                   <tr>
                    <td>Foto:</td>
                    <td id="imgCategoria">zzzzzz</td>
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


