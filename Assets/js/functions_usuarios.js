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

        // script para validar los elemeto de campos para ingresar usuario si estan no cumple con los requerimiento

        // selecciona todos los elemtos con valid
        let elementsValid = document.getElementsByClassName("valid");
        //cuenta todo slos elemento string
        for(let i=0; i < elementsValid.length; i++ ){

            // verifica poscion 1, verifica si elemento contiene la clase is valid ose el campo esta rojo
            if(elementsValid[i].classList.contains('is-invalid')){

                swal("Atención","Porfavor Verifique los campos en Rojo", "error");
                return false;
            }
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

                    tableUsuarios.api().ajax.reload();
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
    // fntViewUsuario();
    // fntEditUsuario();
    // fntDelUsuario();
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
function fntViewUsuario(idpersona){

    
            var idpersona = idpersona;
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

          
       
}

// Funcion para editar similiar al fntviewusuario
function fntEditUsuario(idpersona){

    
        // Configuracion de apariencia
        document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";
        document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
        document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
        document.querySelector('#btnText').innerHTML = "Actualizar";

        

            var idpersona = idpersona;
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

          
        
}


// Eliminar Usuario
function fntDelUsuario(idpersona){

 
            // obtner atributo rl
            var idUsuario = idpersona;
            
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

                                tableUsuarios.api().ajax.reload();
                            }else{
                                swal("Atención!", objData.msg, "error");
                            }
                        }
                    }
                }
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