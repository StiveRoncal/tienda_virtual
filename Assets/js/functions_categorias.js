

// cargar evento caudno se carge todo el html
document.addEventListener('DOMContentLoaded', function(){

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

                            // Sirve para evitar Perder el evento en cada Interaccion de un boton
                            // tableRoles.api().ajax.reload();

                        }else{
                            swal("Error", objData.msg, "error");
                        }
                    }
                // Loading
                divLoading.style.display = "none";
                return false;
                
                }
                
            }
});


// funcion para eliminar foto con (X)
function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
    document.querySelector('#img').remove();
}

function openModal(){
    

    rowTable = "";
    document.querySelector('#idCategoria').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoría";
   
    document.querySelector('#formCategoria').reset();

    $('#modalFormCategorias').modal('show');


}