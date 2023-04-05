

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
            {"data":"status"}
            
        ],

        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]
    });

});


// funcion de datatables
$('#tableRoles').DataTable();


// Funcion abrir el modal

function openModal(){

    $('#modalFormRol').modal('show');


}