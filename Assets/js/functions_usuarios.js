let tableUsuarios;  

let rowTable = "";

// Loading
let divLoading = document.querySelector("#divLoading");

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

    // VALIDACION si existe ese elemento
    //#1
    if(document.querySelector('#formUsuario')){



    let formUsuario = document.querySelector("#formUsuario");
    formUsuario.onsubmit = function(e){
        e.preventDefault();

        let strIdentificacion = document.querySelector('#txtIdentificacion').value;
        let strNombre = document.querySelector('#txtNombre').value;
        let strApellido = document.querySelector('#txtApellido').value;
        let strEmail = document.querySelector('#txtEmail').value;
        let intTelefono = document.querySelector('#txtTelefono').value;
        let intTipousuario = document.querySelector('#listRolid').value;
        let strPassword = document.querySelector('#txtPassword').value;
        let intStatus = document.querySelector('#listStatus').value;

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
        
         // Loading
         divLoading.style.display = "flex";

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Usuarios/setUsuario';
        let formData = new FormData(formUsuario);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200){

                let objData = JSON.parse(request.responseText);

                if(objData.status){

                    if(rowTable == ""){
                        tableUsuarios.api().ajax.reload();
                    }else{
                        htmlStatus = intStatus == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';

                        rowTable.cells[1].textContent = strNombre;
                        rowTable.cells[2].textContent = strApellido;
                        rowTable.cells[3].textContent = strEmail;
                        rowTable.cells[4].textContent = intTelefono;
                        rowTable.cells[5].textContent = document.querySelector("#listRolid").selectedOptions[0].text;
                        rowTable.cells[6].innerHTML = htmlStatus;
                    }
                    $('#modalFormUsuario').modal("hide");
                    formUsuario.reset();
                    swal("Usuarios", objData.msg , "success");
                  
                
                }else{
                    swal("Error", objData.msg , "error");
                }
            }
             // Loading
             divLoading.style.display = "none";
             return false;
            }

        }

    }


    // #2 ACtualizar perfil
    // VALIDACION si existe ese elemento
    if(document.querySelector('#formPerfil')){



        let formPerfil = document.querySelector("#formPerfil");
        formPerfil.onsubmit = function(e){
            e.preventDefault();
    
            let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let intTelefono = document.querySelector('#txtTelefono').value;

            // Contraseñas
            let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
            
    
    
            if(strIdentificacion == '' || strApellido == '' || strNombre == ''  || intTelefono == '' ){
    
                swal("Atencion","Todos Los Campos son Obligatorios", "error");
                return false;
    
            }

            // VALIDACION DE CONSTRASEÑA SI SE ACTUALIZA Y VALIDA QUE LOS DOS SEAN IGUALES
            if(strPassword != "" || strPasswordConfirm != ""){

                if(strPassword != strPasswordConfirm){
                    
                    swal("Atención","Las Contraseñas no Son Iguales.", "info");
                    return false;

                }

                if(strPassword.length < 5){

                    swal("Atención", "La contraseña debe tener un mínimo de 5 caracteres", "info");
                    return false;

                }
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

            // Loading
            divLoading.style.display = "flex";
    
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            // Controllers/Usuarios.php
            let ajaxUrl = base_url+'/Usuarios/putPerfil';
            let formData = new FormData(formPerfil);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
    
            request.onreadystatechange = function(){

                if(request.readyState != 4) return;

                if(request.status == 200){
    
                    let objData = JSON.parse(request.responseText);
    
                    if(objData.status){

                        $('#modalFormPerfil').modal("hide");

                        swal({
                            title:"",
                            text: objData.msg,
                            type: "success",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: false,

                        }, function(isConfirm){

                            if(isConfirm){
                                
                                location.reload(); 
                            }
                        });
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }

                divLoading.style.display = "none";
                return false;

            }
    
        }
    
    }


     // #2 ACtualizar Datos Fiscales
    // VALIDACION si existe ese elemento
    if(document.querySelector('#formDataFiscal')){



        let formDataFiscal = document.querySelector("#formDataFiscal");
        formDataFiscal.onsubmit = function(e){
            e.preventDefault();
    
            let strDni = document.querySelector('#txtDni').value;
            let strNombreFiscal = document.querySelector('#txtNombreFiscal').value;
            let strDirFiscal = document.querySelector('#txtDirFiscal').value;
            
    
    
            if(strDni == '' || strNombreFiscal == '' || strDirFiscal == ''){
    
                swal("Atencion","Todos Los Campos son Obligatorios", "error");
                return false;
    
            }

            // Loading
            divLoading.style.display = "flex";

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            // Controllers/Usuarios.php
            let ajaxUrl = base_url+'/Usuarios/putDFiscal';
            let formData = new FormData(formDataFiscal);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
    
            request.onreadystatechange = function(){

                if(request.readyState != 4) return;

                if(request.status == 200){
    
                    let objData = JSON.parse(request.responseText);
    
                    if(objData.status){

                        $('#modalFormPerfil').modal("hide");

                        swal({
                            title:"",
                            text: objData.msg,
                            type: "success",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: false,

                        }, function(isConfirm){

                            if(isConfirm){
                                
                                location.reload(); 
                            }
                        });
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }

                divLoading.style.display = "none";
                return false;
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

    let ajaxUrl = base_url+'/Roles/getSelectRoles';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    // Obtener resultado de AJAX

    request.onreadystatechange = function(){

        // VALIDACION si existe tal elemento
        if(document.querySelector('#listRolid')){

        // Condicional si los datos fueron recibidos correctamtene
        if(request.readyState == 4 && request.status == 200){

            // seleciona el campos de lista de roles = pone los options
            document.querySelector('#listRolid').innerHTML = request.responseText;
            // Elige la lista per al primer options
            // document.querySelector('#listRolid').value = 1;

            // Actulizar el slect para que se muestr elos registros
            $('#listRolid').selectpicker('render');
        }
    }
    }
}

// Funcion para abrir el detalle de los usuarios
function fntViewUsuario(idpersona){

    
     
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;

            request.open("GET",ajaxUrl,true);
            request.send();

            request.onreadystatechange = function(){

                if(request.readyState == 4 && request.status == 200){

                    let objData = JSON.parse(request.responseText);

                    if(objData.status){

                        let estadoUsuario = objData.data.status == 1 ? '<span class="badge badge-success">Activo</span>':'<span class="badge badge-danger">Inactivo</span>';
                        
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
function fntEditUsuario(element,idpersona){

        //varaible principal que evita recarga pagina inicia del tabla para quedarmos alli mismo 
        //parentNode: dirige a su elemento padre del contenedor pero 3 veces hasta llegar al contenedor original
        rowTable = element.parentNode.parentNode.parentNode;

        // rowTable.cells[1].textContext = "Stive";
        // console.log(rowTable);
        // Configuracion de apariencia
        document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";
        document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
        document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
        document.querySelector('#btnText').innerHTML = "Actualizar";

        

 
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;

            request.open("GET",ajaxUrl,true);
            request.send();

            request.onreadystatechange = function(){

                if( request.readyState == 4 && request.status == 200){

                    let objData = JSON.parse(request.responseText);

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

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+'/Usuarios/delUsuario/';
                    let strData = "idUsuario="+idpersona;
                    request.open("POST",ajaxUrl,true);
                    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    request.send(strData);

                    request.onreadystatechange = function(){
                        if(request.readyState == 4 && request.status == 200){
                            let objData = JSON.parse(request.responseText);

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
    // Valida el tablerow para que vaciar

    rowTable = "";
    document.querySelector('#idUsuario').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    // Limpiar Campos
    document.querySelector('#formUsuario').reset();

    $('#modalFormUsuario').modal('show');


}


//Funcion para abrir modal de perfil

function openModalPerfil(){

    $('#modalFormPerfil').modal('show');
}