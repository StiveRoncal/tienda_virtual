
var tableCategorias;
// cargar evento caudno se carge todo el html
document.addEventListener('DOMContentLoaded', function(){
        // DATATABLES
        tableCategorias = $('#tableCategorias').dataTable({

            "aProcessing":true,
            "aServerSide": true,
            "language":{
                "url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            
            "ajax":{
                "url": " "+base_url+"/Categorias/getCategorias",
                
                "dataSrc": ""
            },
    
            "columns":[
                // nombres del formato json
                {"data":"idcategoria"},
                {"data":"nombre"},
                {"data":"descripcion"},
                {"data":"status"},
                // otro para acciones para sus columnas
                {"data":"options"}
                
            ],
            // Botones de exportaciones
            'dom': 'lBfrtip',
            'buttons': [
                {
                    "extend":"copyHtml5",
                    "text":"<i class='far fa-copy'></i> Copiar",
                    "titleAttr":"Copiar",
                    "className": "btn btn-secondary"
    
                },
                {
                    "extend":"excelHtml5",
                    "text":"<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr":"Exportar Excel",
                    "className": "btn btn-success"
                },{
                    "extend":"pdfHtml5",
                    "text":"<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr":"Exportar PDF",
                    "className": "btn btn-danger"
                },{
                    "extend":"csvHtml5",
                    "text":"<i class='fas fa-file-csv'></i> CSV",
                    "titleAttr":"Exportar CVS",
                    "className": "btn btn-info"
    
                }
            ],
            // Paginacion
            "resonsieve":"true",
            "bDestroy": true,
            "iDisplayLength": 10,
            "order":[[0,"desc"]]
        });




        // Scrip para IMG
            
        if(document.querySelector("#foto")){
            var foto = document.querySelector("#foto");
            foto.onchange = function(e) {
                var uploadFoto = document.querySelector("#foto").value;
                var fileimg = document.querySelector("#foto").files;
                var nav = window.URL || window.webkitURL;
                var contactAlert = document.querySelector('#form_alert');
                if(uploadFoto !=''){
                    var type = fileimg[0].type;
                    var name = fileimg[0].name;
                    if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                        contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
                        if(document.querySelector('#img')){
                            document.querySelector('#img').remove();
                        }
                        document.querySelector('.delPhoto').classList.add("notBlock");
                        foto.value="";
                        return false;
                    }else{  
                            contactAlert.innerHTML='';
                            if(document.querySelector('#img')){
                                document.querySelector('#img').remove();
                            }
                            document.querySelector('.delPhoto').classList.remove("notBlock");
                            var objeto_url = nav.createObjectURL(this.files[0]);
                            document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">";
                        }
                }else{
                    alert("No selecciono foto");
                    if(document.querySelector('#img')){
                        document.querySelector('#img').remove();
                    }
                }
            }
        }

        // Eliminar con la (X)
        if(document.querySelector(".delPhoto")){
            var delPhoto = document.querySelector(".delPhoto");
            delPhoto.onclick = function(e) {
                // Direccion elemento con valor 1
                document.querySelector("#foto_remove").value = 1;
                removePhoto();
            }
        }


            // Envios de Datos Por AJAZ nombre,descripcion y statys
            // NUEVO CATEGORIA
            var formCategoria = document.querySelector("#formCategoria");
            formCategoria.onsubmit = function(e){
                // prevenir recarga
                e.preventDefault();

                // nuevo Id para ver estos si se actualizan
                var intIdCategoria =document.querySelector('#idCategoria').value;

                // Validar campossi estan vacios
                var strNombre = document.querySelector('#txtNombre').value;
                var strDescripcion = document.querySelector('#txtDescripcion').value;
                var intStatus = document.querySelector('#listStatus').value;

                if(strNombre == '' || strDescripcion == '' || intStatus == ''){

                    swal("Atención", "Todos los campos son Obligatorios.", "error");
                    return false;
                }

                // LOADING
                // Loading
                divLoading.style.display = "flex";


                // Ajax para hacer un metodo de guardado de datos
                var request =(window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
                // dirigire a la funcion
                var ajaxUrl = base_url+'/Categorias/setCategoria';
                // instanciar
                var formData = new FormData(formCategoria);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                
                request.onreadystatechange = function(){

                    // condiconal si llega a las respuesta de envios
                    if(request.readyState == 4 && request.status == 200){

                        // console.log(request.responseText);
                        
                        var objData = JSON.parse(request.responseText);

                        if(objData.status){
                            
                            $('#modalFormCategorias').modal("hide");
                            formCategoria.reset();
                            swal("Categoria", objData.msg ,"success");
                            removePhoto();
                            // Sirve para evitar Perder el evento en cada Interaccion de un boton
                            tableCategorias.api().ajax.reload();

                        }else{
                            swal("Error", objData.msg, "error");
                        }
                    }
                // Loading
                divLoading.style.display = "none";
                return false;
                
                }
                
            }
}, false);

/************************************************************************************************************************************************* */
// FUNCIONE BOTONES (VER, EDITAR, ACTUALIZAR)


// #1 BOTON VER
function fntViewInfo(idcategoria){

  
    var idcategoria = idcategoria;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Categorias/getCategoria/'+idcategoria;

    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){

            let objData = JSON.parse(request.responseText);

            if(objData.status){

                // Validacion de Input Row Table

                // Estados en html
                var estado = objData.data.status == 1 ? '<span class="badge badge-success">Activo</span>':'<span class="badge badge-danger">Inactivo</span>';
                
                
                document.querySelector("#celId").innerHTML = objData.data.idcategoria;
                document.querySelector("#celNombre").innerHTML = objData.data.nombre;
                document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
                document.querySelector("#celEstado").innerHTML = estado;
            
                document.querySelector("#imgCategoria").innerHTML = '<img src="'+objData.data.url_portada+'"></img>';



                $('#modalViewCategoria').modal('show');

            }else{

                swal("Error", objData.msg, "error");
            }
        }
    }

  

}


// #2 BOTON Editar
function fntEditInfo(idcategoria){


    document.querySelector('#titleModal').innerHTML = "Actualizar Categoría";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
  
    var idcategoria = idcategoria;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Categorias/getCategoria/'+idcategoria;

    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){

            let objData = JSON.parse(request.responseText);

            if(objData.status){

                document.querySelector("#idCategoria").value = objData.data.idcategoria;
                document.querySelector("#txtNombre").value = objData.data.nombre;
                document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                document.querySelector("#foto_actual").value = objData.data.portada;
                
                // Validacion de ESTADO
                if(objData.data.status == 1){

                    document.querySelector("#listStatus").value = 1;

                }else{

                    document.querySelector("#listStatus").value = 2;

                }

                $('#listStatus').selectpicker('render');


                // VALIDACION para img Si existe o no en Editar o para editar o quitar si hay alguna modificaicon
                // Si existe una img por defecto 
                if(document.querySelector('#img')){
                    // Busca Ruta de IMG
                    document.querySelector('#img').src = objData.data.url_portada;

                }else{
                    // Crea un elemento de img 
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objData.data.url_portada+">";

                }



                // Validacio para cambiar IMG si esto es defecto o otra, para configurara las img
                
                if(objData.data.portada == 'portada_categoria.png'){
                    // quitar portada
                    document.querySelector('.delPhoto').classList.add("notBlock");

                }else{
                    // poner portada
                    document.querySelector('.delPhoto').classList.remove("notBlock")

                }

                $('#modalFormCategorias').modal('show');

            }else{

                swal("Error", objData.msg, "error");
            }
        }
    }

  

}








// funcion para eliminar foto con (X)
function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");

    // Validaicon cuando se habra varias veces, si existe de lo contraito no hace nada 
    if(document.querySelector('#img')){

        document.querySelector('#img').remove();
    }
    
}

function openModal(){
    

    document.querySelector('#idCategoria').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoría";
   
    document.querySelector('#formCategoria').reset();

    $('#modalFormCategorias').modal('show');
    removePhoto();

}