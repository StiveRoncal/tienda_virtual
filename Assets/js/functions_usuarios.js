// ejecutar la funcion en momento que carga los archviso

window.addEventListener('load',function(){ 
    fntRolesUsuario();
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