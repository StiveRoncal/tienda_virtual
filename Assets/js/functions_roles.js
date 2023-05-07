

// activar el data table y los valores de la tablas de roles
var tableRoles;

// LOADING
var divLoading = document.querySelector("#divLoading");

// evento par cargar y ejecutar
document.addEventListener('DOMContentLoaded', function(){

    tableRoles = $('#tableRoles').dataTable({

        "aProcessing":true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        
        "ajax":{
            "url": " "+base_url+"/Roles/getRoles",
            
            "dataSrc": ""
        },

        "columns":[
            {"data":"idrol"},
            {"data":"nombrerol"},
            {"data":"descripcion"},
            {"data":"status"},
            // otro para acciones para sus columnas
            {"data":"options"}
            
        ],

        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]
    });

    // Nuevo Rol en accion Guardar Rol

    // Nuevo Rol
    var formRol = document.querySelector("#formRol");
    formRol.onsubmit = function(e){
        // prevenir recarga
        e.preventDefault();

        // nuevo Id para ver estos si se actualizan
        var intIdRol =document.querySelector('#idRol').value;

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
        var ajaxUrl = base_url+'/Roles/setRol';
        // instanciar
        var formData = new FormData(formRol);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        
        request.onreadystatechange = function(){

            // condiconal si llega a las respuesta de envios
            if(request.readyState == 4 && request.status == 200){

                // console.log(request.responseText);
                
                var objData = JSON.parse(request.responseText);

                if(objData.status){
                    
                    $('#modalFormRol').modal("hide");
                    formRol.reset();
                    swal("Roles de usuario", objData.msg ,"success");

                    // Sirve para evitar Perder el evento en cada Interaccion de un boton
                    tableRoles.api().ajax.reload();

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


// funcion de datatables
$('#tableRoles').DataTable();


// Funcion abrir el modal

function openModal(){

    // validacion para evitar conficto en modales de agregar y actulizar de roles 
    document.querySelector('#idRol').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
    document.querySelector("#formRol").reset();

    $('#modalFormRol').modal('show');


}

// agregar elemento cuando se carge el documenta y carge la funcion
window.addEventListener('load', function(){
    // fntEditRol();
    // fntDelRol();
    // fntPermisos();
}, false);

// configuracion para mostar el editar de los roles
function fntEditRol(idrol){
 

            // Cambiar las propiedad de su html
            document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
            document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
            document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");
            document.querySelector('#btnText').innerHTML = "Actualizar";   
            
            // Obtener los datos de scrip ejeuctar ajax para obtener datos de table de roles atraves del id gaudaro en rl
            var idrol = idrol;
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Roles/getRol/'+idrol;
            request.open("GET",ajaxUrl,true);
            request.send();

            // condicional si se enviaron correctamente
            request.onreadystatechange = function(){
                
                if(request.readyState == 4 && request.status == 200){

                    // console.log(request.responseText);
                    // convertir los json en objetos
                    var objData =JSON.parse(request.responseText);
                
                    // Si est es status: true
                if(objData.status){
                    
                    // Asignar variales  a los campos de los campos
                    document.querySelector("#idRol").value = objData.data.idrol;
                    document.querySelector("#txtNombre").value = objData.data.nombrerol;
                    document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                 
                    // Validacion  de estados es 1 armar variables
                    if(objData.data.status == 1){

                        var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                    }else{

                        var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                    }

                    var htmlSelect = `${optionSelect}
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                    `;
                    // colocar el html los elementos de esataos
                    document.querySelector("#listStatus").innerHTML = htmlSelect;
                    // mostrar formilaropo
                    $('#modalFormRol').modal('show');
                }else{

                    swal("Error", objData.msg, "error");
                }

            }
        }
           

           
     
}

// Funcion para eliminar rol con los atributos rl que son auto incrementables
// Se llamara cuando se cargue todo el html
function fntDelRol(idrol){

    
            var idrol = idrol;
            
            // Nos scrip para preguntar si quiere eliminar
            swal({
                title: "Eliminar Rol",
                text: "¿Realmente quieres Eliminar el Rol?",
                icon: "warning",
                buttons: ["No, Cancelar","Si,Eliminar"],
                dangerMode: true,
              })
              .then((willDelete) => {
                if(willDelete){

                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxUrl = base_url+'/Roles/delRol/';
                    var strData = "idrol="+idrol;
                    request.open("POST",ajaxUrl,true);
                    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    request.send(strData);

                    request.onreadystatechange = function(){
                        if(request.readyState == 4 && request.status == 200){
                            var objData = JSON.parse(request.responseText);

                            if(objData.status){

                                swal("Eliminar!", objData.msg, "success");

                                tableRoles.api().ajax.reload(function(){
                                   
                                });
                            }else{
                                swal("Atención!", objData.msg, "error");
                            }
                        }
                    }
                }
              });
           

}

// Funcion para permisos de usuario
function fntPermisos(idrol){
    
   
            
            // peticion get para obtener los modulos
            var idrol = idrol;
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Permisos/getPermisosRol/'+idrol;
            request.open("GET",ajaxUrl,true);
            request.send();

            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){

                    // console.log(request.responseText);
                    // referencia 
                    document.querySelector('#contentAjax').innerHTML = request.responseText;
                    // Abre un modal
                    $('.modalPermisos').modal('show');

                    //Funcion oara guardar permisos asignados a mos modulos 
                    document.querySelector('#formPermisos').addEventListener('submit', fntSavePermisos,false);
                }

            }
  
}

 // Funcion para guardar los cambios en permisos de cada rol
 function fntSavePermisos(evnet){
    // Evitar que se recarge la pagina
    evnet.preventDefault();
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    // Ruta de la funcion que vamos a utilizar
    var ajaxUrl = base_url+'/Permisos/setPermisos';

    var formElement = document.querySelector("#formPermisos");
    var formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    // Validacion si se envio correctamente el guardao de peromisos
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){

            // convertir en objeto un foramto json
            var objData = JSON.parse(request.responseText);
            // Si el estatis es 0 o 1
            if(objData.status){

                swal("Permisos de usuario", objData.msg, "success");
            }else{

                swal("Error",objData.msg, "error");
            }
        }
    }
}