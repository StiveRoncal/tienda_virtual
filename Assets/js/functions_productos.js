
// Incluir libreria de Codigo de Barra
document.write(`<script src="${base_url}/Assets/js/plugins/jsBarcode.all.min.js"></script>`);


let tableProductos;

// habilitar la URL de enlazes
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});


// JS puro para ejecutar una funcion cuando se carge la pagina para que automaticamente se ejecuta la funcion

window.addEventListener('load',function(){
      // DATATABLES
      tableProductos = $('#tableProductos').dataTable({

        "aProcessing":true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        
        "ajax":{
            "url": " "+base_url+"/Productos/getProductos",
            
            "dataSrc": ""
        },

        "columns":[
            // nombres del formato json
            {"data":"idproducto"},
            {"data":"codigo"},
            {"data":"nombre"},
            {"data":"stock"},
            {"data":"precio"},
            {"data":"status"},
            // otro para acciones para sus columnas
            {"data":"options"}
            
        ],
        // referencia a columna que agrega algunas clases
        "columnDefs": [
                    // reemplazo de calses y columna designada
                    {'className': "textcenter", "targets": [3]},
                    {'className': "textright", "targets": [4]},
                    {'className': "textcenter", "targets": [5]}
        ],


        // Botones de exportaciones
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend":"copyHtml5",
                "text":"<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary",
                "exportOptions":{
                    "columns":[0,1,2,3,4,5]
                }

            },
            {
                "extend":"excelHtml5",
                "text":"<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar Excel",
                "className": "btn btn-success",
                // Opcional para columnas
                "exportOptions":{
                    "columns":[0,1,2,3,4,5]
                }
            },{
                "extend":"pdfHtml5",
                "text":"<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar PDF",
                "className": "btn btn-danger",
                "exportOptions":{
                    "columns":[0,1,2,3,4,5]
                }
            },{
                "extend":"csvHtml5",
                "text":"<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar CVS",
                "className": "btn btn-info",
                "exportOptions":{
                    "columns":[0,1,2,3,4,5]
                }

            }
        ],
        // Paginacion
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]
    });


    // Verificar Si Existe El Formulario Sirve para crear un producto
    if(document.querySelector("#formProductos")){


        let formProductos = document.querySelector("#formProductos");

        formProductos.onsubmit = function(e){

            e.preventDefault();


            let strNombre = document.querySelector('#txtNombre').value;
            let intCodigo = document.querySelector('#txtCodigo').value;
            let strPrecio = document.querySelector('#txtPrecio').value;
            let intStock = document.querySelector('#txtStock').value;

            if(strNombre == '' || intCodigo == ''  || strPrecio == '' || intStock == ''){

                swal("Atención", "Todos Los Campos son Obligatorios", "error");
                return false;
            }

            if(intCodigo.length < 5){
                
                swal("Atención", "El Codigo debe Ser mayor que 5 Dígitos","error");
                return false;

            }

            divLoading.style.display = "flex";
            tinyMCE.triggerSave();

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

            let ajaxUrl = base_url+'/Productos/setProducto';
            let formData = new FormData(formProductos);

            request.open("POST",ajaxUrl,true);
            request.send(formData);

            request.onreadystatechange = function(){

                if(request.readyState == 4 && request.status == 200){

                    // json a Objeto
                    let objData = JSON.parse(request.responseText);

                    if(objData.status){

                        swal("", objData.msg, "success");

                        // establcer ID
                        document.querySelector('#idProducto').value = objData.idproducto;
                        tableProductos.api().ajax.reload();

                    }else{

                        swal("Error", objData.msg, "error");

                    }

                
                }   

                divLoading.style.display = "none";
                return false;

            }
        }

    }
    

    // Boton de Agregar IMG en Galeria en modal de productos
    if(document.querySelector(".btnAddImage")){

        let btnAddImage = document.querySelector(".btnAddImage");

        btnAddImage.onclick = function(e){
            // Cambiar los elemento de div24 que es Id a uno diferente que no se repita
            let key = Date.now();
            let newElement = document.createElement("div");
            // cambio de valor el id="div24" por algo aleatorio
            newElement.id = "div"+key;

            newElement.innerHTML = `
            <div class="prevImage">
                
            </div>

            <input type="file" name="foto" id="img${key}" class="inputUploadfile">
            <label for="img${key}" class="btnUpdatefile"><i class="fas fa-upload"></i></label>
            <button class="btnDeleteImage" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
            
            // Colocar Todo el elemento de DIV images #containerImages con la funcion de appendChild
            document.querySelector("#containerImages").appendChild(newElement);
            // referencia a la clase para subir imagen en carpeta local, para que se muestre en el explorador y crear una ventanita de img 
            document.querySelector(".btnUpdatefile").click();
            
        }
    }
   

        

    


    // Funcion de Abajo
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