// FUNCIONES GENERALES DEL PROYECTO RECUERDA STIVE x( | x(
//Funcion(funcion(funcion()))->Recuerda esta parte
//

// #1 Funcion bloque de todas la teclas que solo permite numeros

function controlTag(e){
    // Captura todo lo que se escribe
    tecla = (document.all) ? e.keyCode : e.which;
    // tecla de retroceso o para borar si lo prende
    if(tecla == 8) return true;
    // Si estamos presionar la tecla tabular, esto permite hacer pasar al otro campo con TAbulador 
    else if(tecla==0||tecla==9) return true;

    // Expresion regular evita caracteres raros
    patron=/[0-9\s]/;
    // 
    n = String.fromCharCode(tecla);
    // Verifica el patron con Expresiones regulares y testea la variable n
    return patron.test(n);
}

// #2 Funcion con parametro para validar cadena de texto con expresione sergulares y volares con tilde

function testText(txtString){

    // instacio un objeto con expreciones regular  que incluya letras con tilde las vocales para validar texto
    var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);

    // condiconal si cumple la cadena de expresion regular
    if(stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}


// #3 Funcion para validar campos solo numeros

function testEntero(intCant){

    var intCantidad = new RegExp(/^([0-9])*$/);

    if(intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}

// #4 Funcion para validar correo con todas las extensiones de estas

function fntEmailValidate(email){
    // expresion regular paraun correo con formatoa
    var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

    // si es un emial incorrectp
    if(stringEmail.test(email) == false){
        return false;
    }else{
        return true;
    }
}

// #5 funcion asigna elemento del la clase valid-Text

function fntValidText(){

    // almacena campos con esa clase
    let validText = document.querySelectorAll(".validText");
    // recore todo los elemtos de essa clase
    validText.forEach(function(validText){
        // agrega evento cuando termine de presiona la tecla ejeucta funcion si es correcta o incorrecta
        validText.addEventListener('keyup',function(){

            let inputValue = this.value;

            // llama a la funcion testText la 2 que asignamos
            // verifica si lo que devuelve es falso pone invalod de lo contraio lo quita
            if(!testText(inputValue)){

                this.classList.add('is-invalid');
            }else{
                this.classList.remove('is-invalid');
            }

        });

    });
}


// #6 Funcion validar campos de numero 

function fntValidNumber(){

    let validNumber = document.querySelectorAll(".validNumber");
    validNumber.forEach(function(validNumber){
        validNumber.addEventListener('keyup',function(){

            let inputValue = this.value;

            if(!testEntero(inputValue)){

                this.classList.add('is-invalid');
            }else{

                this.classList.remove('is-invalid');
            }

        });

    });
}


// #7 validar campo correo

function fntValidEmail(){

    let validEmail = document.querySelectorAll(".validEmail");
    
    validEmail.forEach(function(validEmail){

        validEmail.addEventListener('keyup', function(){

            let inputValue = this.value;
            
            if(!fntEmailValidate(inputValue)){

                this.classList.add('is-invalid');
            }else{
                this.classList.remove('is-invalid');
            }
        });
    });
}


// Documento  que sirve para cargar funcion ya las llama

window.addEventListener('load', function(){
    fntValidText();
    fntValidNumber();
    fntValidEmail();
    
},false);