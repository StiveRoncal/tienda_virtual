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