

var tableClientes;  

var divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){

    // DataTAbles
    // DataTables
    tableClientes = $('#tableClientes').dataTable({

        "aProcessing":true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        
        "ajax":{
            "url": " "+base_url+"/Clientes/getClientes",
            
            "dataSrc": ""
        },

        "columns":[
            // nombres del formato json
            {"data":"idpersona"},
            {"data":"identificacion"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"email_user"},
            {"data":"telefono"},
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



    if(document.querySelector('#formCliente')){
        
        var formCliente = document.querySelector("#formCliente");
        formCliente.onsubmit = function(e){
            e.preventDefault();

            var strIdentificacion = document.querySelector('#txtIdentificacion').value;
            var strNombre = document.querySelector('#txtNombre').value;
            var strApellido = document.querySelector('#txtApellido').value;
            var strEmail = document.querySelector('#txtEmail').value;
            var intTelefono = document.querySelector('#txtTelefono').value;

            var strDni = document.querySelector('#txtDni').value;
            var strNomFiscal = document.querySelector('#txtNombreFiscal').value;
            var strDirFiscal = document.querySelector('#txtDirFiscal').value;
            var strPassword = document.querySelector('#txtPassword').value;

            if(strIdentificacion == '' || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' 
                || strDni == '' || strDirFiscal == '' || strNomFiscal == ''){

                    swal("Atención", "Todos Los Campos Son Obligatorios.", "Error");
                    return false;
            }


            let elementsValid = document.getElementsByClassName("valid");
            for(let i = 0; i < elementsValid.length; i++){

                if(elementsValid[i].classList.contains('is-invalid')){

                    swal("Atención", "Por favor verifique los campos en Rojos.", "error");
                    return false;
                }
            }


            divLoading.style.display = "flex";

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Clientes/setCliente';
            var formData = new FormData(formCliente);
            request.open("POST",ajaxUrl,true);
            request.send(formData);

            request.onreadystatechange = function(){

                if(request.readyState == 4 && request.status == 200){

                    var objData = JSON.parse(request.responseText);

                    if(objData.status){

                        $('#modalFormCliente').modal("hide");
                        formCliente.reset();
                        swal("Usuario", objData.msg , "success");
                        tableClientes.api().ajax.reload();
                    }else{

                        swal("Error",objData.msg,"error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
            
        }
    }





}, false);

// FUNCIONE BOTONES (VER, EDITAR, ACTUALIZAR)


// BOTON VER
function fntViewInfo(idpersona){

  
    var idpersona = idpersona;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Clientes/getCliente/'+idpersona;

    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){

            var objData = JSON.parse(request.responseText);

            if(objData.status){

                
                document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                
                document.querySelector("#celIde").innerHTML = objData.data.dni;
                document.querySelector("#celNomFiscal").innerHTML = objData.data.nombrefiscal;
                document.querySelector("#celDirFiscal").innerHTML = objData.data.direccionfiscal;

                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;

                $('#modalViewCliente').modal('show');

            }else{

                swal("Error", objData.msg, "error");
            }
        }
    }

  

}

// Funcion para abrir modal 
function openModal(){
    // Valida el tablerow para que vaciar

    rowTable = "";
    document.querySelector('#idUsuario').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
    // Limpiar Campos
    document.querySelector('#formCliente').reset();

    $('#modalFormCliente').modal('show');


}