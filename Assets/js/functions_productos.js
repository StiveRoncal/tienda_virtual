// Incluir libreria de Codigo de Barra
document.write(`<script src="${base_url}/Assets/js/plugins/jsBarcode.all.min.js"></script>`);

// habilitar la URL de enlazes
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});


// JS puro para ejecutar una funcion cuando se carge la pagina para que automaticamente se ejecuta la funcion

window.addEventListener('load',function(){
    
    fntCategorias();

}, false);
 


// SCRIP PARA ASIGNAR EVENTO DEL CODIGO EN BARRA CUANDO PONGA NUMERO

// Validar si existe
if(document.querySelector("#txtCodigo")){
    // almacenar dicho campo
    let inputCodigo = document.querySelector("#txtCodigo");
    // Realizara un evento cuando pulsamos click
    inputCodigo.onkeyup = function(){
        // inicia despues de 5 caracteres
        if(inputCodigo.value.length >= 5){

            document.querySelector('#divBarCode').classList.remove("notBlock");
            // Llamade de img codigo de barra
            fntBarcode();
        }else{

            document.querySelector('#divBarCode').classList.add("notBlock");
        }
    };
}



// Plugin para El TextArea para algo garnde
tinymce.init({
	selector: '#txtDescripcion',
	width: "100%",
    height: 400,    
    statubar: true,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});


// Funcion para que se ejecuta para cargar la vista 

function fntCategorias(){

    // Agaramos el id de combox
    // Si Existe el Elemento
    if(document.querySelector('#listCategoria')){

        // Almacena funcion de Controlador
        let ajaxUrl = base_url+'/Categorias/getSelectCategorias';

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

        request.open("GET",ajaxUrl,true);
        request.send();

        // Validacion de retorno de informacion
        
        request.onreadystatechange = function(){

            // Si se envio correctamente  de informacion
            if(request.readyState == 4 && request.status == 200){

                // devuelve los options de combox
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                // Jquery para usa funcion selectpicker para que rendere todoas las opcion aplicando el buscado
                $('#listCategoria').selectpicker('render');

            }
        }

    }

}


// Funcion para Ver img de Codigo en barra
function fntBarcode(){

    let codigo = document.querySelector("#txtCodigo").value;
    JsBarcode("#barcode", codigo);
}

// Imprimir el codigo en Barra
function fntPrintBarcode(area){

    let elemntArea = document.querySelector(area);
    let vprint = window.open('', 'popimpr', 'height=400,width=600');
    vprint.document.write(elemntArea.innerHTML );
    vprint.document.close();
    // Funcion para imprimir
    vprint.print();
    vprint.close();
}


// Mostrar Modal

function openModal(){
    
    // rowTable = "";
    document.querySelector('#idProducto').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Producto";
   
    document.querySelector('#formProductos').reset();

    $('#modalFormProductos').modal('show');
    // removePhoto();

}