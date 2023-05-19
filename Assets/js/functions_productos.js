
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
            <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload"></i></label>
            <button class="btnDeleteImage" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
            
            // Colocar Todo el elemento de DIV images #containerImages con la funcion de appendChild
            document.querySelector("#containerImages").appendChild(newElement);
            // referencia a la clase para subir imagen en carpeta local, para que se muestre en el explorador y crear una ventanita de img 
            // concadenar elemto para eviar que la img se agrega en el [0] => img i similar por eso acemos eso
            document.querySelector("#div"+key+" .btnUploadfile").click();
            
            // eejcuta funcion
            fntInputFile();
        }
    }
   

        

    
    // Invocar funcion
    fntInputFile();

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


// Funcion para Cambiar de ver y poner la ruta de imagen en el input inputUploadfile
function fntInputFile(){

    // almacena clase de input y lo referencia
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");

    // recore todo los elemto de las clases
    inputUploadfile.forEach(function(inputUploadfile){

        // aplicamps la funcion de cambio de clase
        inputUploadfile.addEventListener('change', function(){

            // elemeto de tipo hiden del formulario
            let idProducto = document.querySelector("#idProducto").value;   
            // obetner id de class="div24(aleotorio)"
            // referncia al boton de fecha arriba para subir img
            let parentId = this.parentNode.getAttribute("id");
            // referencia de id al elemento que damos click que obtiene su id <input id="img1"/>
            let idFile = this.getAttribute("id");
            // almacena el id file para concadenar con un selector # que obtiene el valor de ese elemento
            let uploadFoto = document.querySelector("#"+idFile).value;  
            // los mismo pero aqui obtiene el archivo que carga
            let fileimg = document.querySelector("#"+idFile).files;
            // seleciiona elemeto <div id="div"> y se dirige a previmage
            let prevImg = document.querySelector("#"+parentId+" .prevImage");

            // alamcena  el navengadpr del vwtan de url 
            let nav = window.URL || window.webkitURL;


            // Validar si Existe Alguna Imagen, si existe algun archibo img
            if(uploadFoto != ''){

                // almacena input en poscion 0 para obtener el tipo de archivo
                let type = fileimg[0].type;
                // aqui obtiene el nombre del archivo
                let name = fileimg[0].name;

                // Validamos el tipo de Archivo enviado

                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){

                    // da Respsues de archivo no correspondiente
                    prevImg.innerHTML = "Archivo no Valido,Esto Senati no corresponde al formato de img aceptado";
                    // deja el valor vacio
                    uploadFoto.value = "";
                    // detiene el proveso
                    return false;

                }else{
                    // Si es correcto el archivo

                    // alamce el input file del tipo de artchi
                    let objeto_url = nav.createObjectURL(this.files[0]);

                    // muestra la img y direccion de img de carga
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg">`;
                    

                    // Proceso de Ajax

                    // Validacion de navegacio
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

                    // ruta de funcion que usa 
                    let ajaxUrl = base_url+'/Productos/setImage';
                    // instancia
                    let formData = new FormData();
                    // con sea instanci agremos  el campo id producto con valor definido en liena 256 de una varaible
                    formData.append('idproducto', idProducto);
                    // otro eleemto de guarda foto, con contendio del tipo files
                    formData .append("foto", this.files[0]);

                    // peticion de post con varianle anterirores
                    request.open("POST",ajaxUrl, true);
                    // envip
                    request.send(formData);

                    // Validcaion si fueron enviados correctamente

                    request.onreadystatechange = function(){
                        
                        if(request.readyState !=4) return;

                        if(request.status == 200){

                            // convertirmos json en objto
                            let objData = JSON.parse(request.responseText);

                          


                            // Validacion de objeto
                            if(objData.status){
                            
                                  // alamcenr la url de url de imagen temporal
                                prevImg.innerHTML = `<img  src="${objeto_url}">`;
                                //diregir al id del parnet especial mente a los botone que se van a configurar 
                                document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);

                                document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notBlock");

                                document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notBlock");
                                
                            }else{
                                swal("Error", objData.msg, "error");
                            }
                        }

                    }

                }


            }
        });

    });
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


// Boton VER 

function fntViewInfo(idProducto){

    // Validacion AJAX
    let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;

    request.open("GET",ajaxUrl,true);

    request.send();

    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){


           let objData = JSON.parse(request.responseText);

            if(objData.status){

                let htmlImage = "";
                // almacena Data
                let objProducto = objData.data;
                
                // status en html
                var estadoProducto = objProducto.status == 1 ? '<span class="badge badge-success">Activo</span>':'<span class="badge badge-danger">Inactivo</span>';

                // muestra el producto con su respectivas celdas
                document.querySelector("#celCodigo").innerHTML = objProducto.codigo;
                document.querySelector("#celNombre").innerHTML = objProducto.nombre;
                document.querySelector("#celPrecio").innerHTML = objProducto.precio;
                document.querySelector("#celStock").innerHTML = objProducto.stock;
                document.querySelector("#celCategoria").innerHTML = objProducto.categoria;
                document.querySelector("#celStatus").innerHTML = estadoProducto;
                document.querySelector("#celDescripcion").innerHTML = objProducto.descripcion;

                // Validacion hay img existente

                if(objProducto.images.length > 0){

                    let objProductos = objProducto.images;

                    for(let p=0; p < objProductos.length; p++){
                        
                        htmlImage +=`<img src="${objProductos[p].url_image}"></img>`;

                    }
                }

                document.querySelector("#celFotos").innerHTML = htmlImage;
                
                $('#modalViewProducto').modal('show');
            }else{

                swal("Error", objData.msg, "error");
            }
        }

    }


}


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