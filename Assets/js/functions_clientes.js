document.addEventListener('DOMContentLoaded', function(){

    //#1
    if(document.querySelector('#formCliente')){



        let formCliente = document.querySelector("#formCliente");
        formCliente.onsubmit = function(e){
            e.preventDefault();
    
            let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;

            let strDni = document.querySelector('#txtDni').value;
            let strNomFiscal = document.querySelector('#txtNombreFiscal').value;
            let strDirFiscal = document.querySelector('#txtDirFiscal').value; 

            let strPassword = document.querySelector('#txtPassword').value;
            
    
            if(strIdentificacion == '' || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' || strDni == '' || strDirFiscal == '' || strNomFiscal == ''){
    
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
            let ajaxUrl = base_url+'/Clientes/setCliente';
            let formData = new FormData(formCliente);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
    
            request.onreadystatechange = function(){
    
                if(request.readyState == 4 && request.status == 200){
    
                    let objData = JSON.parse(request.responseText);
    
                    if(objData.status){
    
                        
                        $('#modalFormCliente').modal("hide");
                        formCliente.reset();
                        swal("Usuarios", objData.msg , "success");
                        tableUsuarios.api().ajax.reload();
                      
                    
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