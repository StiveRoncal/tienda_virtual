

// activar el data table y los valores de la tablas de roles
var tableRoles;

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

        // Validar campossi estan vacios
        var strNombre = document.querySelector('#txtNombre').value;
        var strDescripcion = document.querySelector('#txtDescripcion').value;
        var intStatus = document.querySelector('#listStatus').value;

        if(strNombre == '' || strDescripcion == '' || intStatus == ''){

            swal("Atención", "Todos los campos son Obligatorios.", "error");
            return false;
        }

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

                    tableRoles.api().ajax.reload(function(){
                        
                    });

                }else{
                    swal("Error", objData.msg, "error");
                }


            }

           
        }
        
    }
});


// funcion de datatables
$('#tableRoles').DataTable();


// Funcion abrir el modal

function openModal(){

    $('#modalFormRol').modal('show');


}