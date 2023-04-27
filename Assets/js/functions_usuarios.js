var tableUsuarios;  
document.addEventListener('DOMContentLoaded', function(){

    // DataTables
    tableUsuarios = $('#tableUsuarios').dataTable({

        "aProcessing":true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        
        "ajax":{
            "url": " "+base_url+"/Usuarios/getUsuarios",
            
            "dataSrc": ""
        },

        "columns":[
            {"data":"idpersona"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"email_user"},
            {"data":"telefono"},
            {"data":"nombrerol"},
            {"data":"status"},
            // otro para acciones para sus columnas
            {"data":"options"}
            
        ],

        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]
    });

    var formUsuario = document.querySelector("#formUsuario");
    formUsuario.onsubmit = function(e){
        e.preventDefault();

        var strIdentificacion = document.querySelector('#txtIdentificacion').value;
        var strNombre = document.querySelector('#txtNombre').value;
        var strApellido = document.querySelector('#txtApellido').value;
        var strEmail = document.querySelector('#txtEmail').value;
        var intTelefono = document.querySelector('#txtTelefono').value;
        var intTipousuario = document.querySelector('#listRolid').value;
        var strPassword = document.querySelector('#txtPassword').value;


        if(strIdentificacion == '' || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' || intTipousuario == ''){

            swal("Atencion","Todos Los Campos son Obligatorios", "error");
            return false;

        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/Usuarios/setUsuario';
        var formData = new FormData(formUsuario);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200){

                var objData = JSON.parse(request.responseText);

                if(objData.status){

                    $('#modalFormUsuario').modal("hide");
                    formUsuario.reset();
                    swal("Usuarios", objData.msg , "success");

                    tableUsuarios.api().ajax.reload(function(){
                        fntRolesUsuario();
                        fntViewUsuario();
                        fntEditUsuario();
                        fntDelUsuario();
                    });
                }else{
                    swal("Error", objData.msg , "error");
                }
            }
        }

    }
}, false);

// ejecutar la funcion en momento que carga los archviso

window.addEventListener('load',function(){ 
    fntRolesUsuario();
    fntViewUsuario();
    fntEditUsuario();
    fntDelUsuario();
}, false);

// Funcion PEticion ajax
function fntRolesUsuario(){

    var ajaxUrl = base_url+'/Roles/getSelectRoles';
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    // Obtener resultado de AJAX

    request.onreadystatechange = function(){

        // Condicional si los datos fueron recibidos correctamtene
        if(request.readyState == 4 && request.status == 200){

            // seleciona el campos de lista de roles = pone los options
            document.querySelector('#listRolid').innerHTML = request.responseText;
            // Elige la lista per al primer options
            document.querySelector('#listRolid').value = 1;

            // Actulizar el slect para que se muestr elos registros
            $('#listRolid').selectpicker('render');
        }
    }
}

// Funcion para abrir el detalle de los usuarios
function fntViewUsuario(){

    var btnViewUsuario = document.querySelectorAll(".btnViewUsuario");

    btnViewUsuario.forEach(function(btnViewUsuario){

        btnViewUsuario.addEventListener('click', function(){

            var idpersona = this.getAttribute("us");
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;

            request.open("GET",ajaxUrl,true);
            request.send();

            request.onreadystatechange = function(){

                if(request.readyState == 4 && request.status == 200){

                    var objData = JSON.parse(request.responseText);

                    if(objData.status){

                        var estadoUsuario = objData.data.status == 1 ? '<span class="badge badge-success">Activo</span>':'<span class="badge badge-danger">Inactivo</span>';
                        
                        document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                        document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                        document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                        document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                        document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                        document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombrerol;
                        document.querySelector("#celEstado").innerHTML = estadoUsuario;
                        document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;

                        $('#modalViewUser').modal('show');
                    }else{

                        swal("Error", objData.msg, "error");
                    }
                }
            }

          
        });
    });
}

// Funcion para editar similiar al fntviewusuario
function fntEditUsuario(){

    var btnEditUsuario = document.querySelectorAll(".btnEditUsuario");

    btnEditUsuario.forEach(function(btnEditUsuario){

        // Configuracion de apariencia
        document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";
        document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
        document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
        document.querySelector('#btnText').innerHTML = "Actualizar";

        btnEditUsuario.addEventListener('click', function(){

            var idpersona = this.getAttribute("us");
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;

            request.open("GET",ajaxUrl,true);
            request.send();

            request.onreadystatechange = function(){

                if( request.readyState == 4 && request.status == 200){

                    var objData = JSON.parse(request.responseText);

                    if(objData.status){

                        document.querySelector("#idUsuario").value = objData.data.idpersona;
                        document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                        document.querySelector("#txtNombre").value = objData.data.nombres;
                        document.querySelector("#txtApellido").value = objData.data.apellidos;
                        document.querySelector("#txtTelefono").value = objData.data.telefono;
                        document.querySelector("#txtEmail").value = objData.data.email_user;
                        document.querySelector("#listRolid").value = objData.data.idrol;

                        $('#listRolid').selectpicker('render');

                        // cambiar el estado 
                        if(objData.data.status == 1){

                            document.querySelector("#listStatus").value = 1;
                        }else{

                            document.querySelector("#listStatus").value = 2;
                        }

                        $('#listStatus').selectpicker('render');
                    }
                }

               $('#modalFormUsuario').modal('show');
            }

          
        });
    });
}


// Eliminar Usuario
function fntDelUsuario(){

    // variable que almacena el atributo class de eliminar rol del boton todos elementos
    var btnDelUsuario = document.querySelectorAll(".btnDelUsuario");
    btnDelUsuario.forEach(function(btnDelUsuario){

        btnDelUsuario.addEventListener('click', function(){
            // obtner atributo rl
            var idUsuario = this.getAttribute("us");
            
            // Nos scrip para preguntar si quiere eliminar
            swal({
                title: "Eliminar Usuario",
                text: "¿Realmente quieres Eliminar el Usuario?",
                icon: "warning",
                buttons: ["No, Cancelar","Si,Eliminar"],
                dangerMode: true,
              })
              .then((willDelete) => {
                if(willDelete){

                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxUrl = base_url+'/Usuarios/delUsuario/';
                    var strData = "idUsuario="+idUsuario;
                    request.open("POST",ajaxUrl,true);
                    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    request.send(strData);

                    request.onreadystatechange = function(){
                        if(request.readyState == 4 && request.status == 200){
                            var objData = JSON.parse(request.responseText);

                            if(objData.status){

                                swal("Eliminar!", objData.msg, "success");

                                tableUsuarios.api().ajax.reload(function(){
                                    fntRolesUsuario();
                                    fntViewUsuario();
                                    fntEditUsuario();
                                    fntDelUsuario();
                                });
                            }else{
                                swal("Atención!", objData.msg, "error");
                            }
                        }
                    }
                }
              });
            });
});

}



// Funcion para abrir modal 
function openModal(){

    document.querySelector('#idUsuario').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    // Limpiar Campos
    document.querySelector('#formUsuario').reset();

    $('#modalFormUsuario').modal('show');





}