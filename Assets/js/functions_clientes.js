document.addEventListener('DOMContentLoaded', function(){

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
                        // tableUsuario.api().ajax.reload();
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