
//#1 funcion de login para mover tipo flp de login a resetear login
$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
});


// documento de recarga a todos las funciones

document.addEventListener('DOMContentLoaded', function(){


    //#1 Valicion de Login
    // condicional
    //si existe ese elemento en el documento
    if(document.querySelector("#formLogin")){

        let formLogin = document.querySelector("#formLogin");

        formLogin.onsubmit = function(e){

            e.preventDefault();
            // relaciona a los dos unicos campos
            let strEmail = document.querySelector('#txtEmail').value;
            let strPassword = document.querySelector('#txtPassword').value;

            if(strEmail == "" || strPassword == ""){

                swal("Por favor","Escribe Usuario y Contraseña","error");
                return false;

            }else{

                // Enviar los datos al controlador
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/loginUser';
                var formData = new FormData(formLogin);

                // ajax

                request.open("POST",ajaxUrl,true);
                request.send(formData);

                request.onreadystatechange = function(){
                    
                if(request.readyState != 4) return;
        
                if(request.status == 200){

                    // Si el envio es exito convertir el json en objeto
                    var objData = JSON.parse(request.responseText);

                    // si es verdadero hizo login de forma correcta
                    if(objData.status){
                        // redirecionar
                        window.location = base_url+'/dashboard';

                    }else{

                        swal("Atencion", objData.msg, "error");

                        document.querySelector('#txtPassword').value="";
                    }
                }else{
                    swal("Atencion", "Error en el Proceso", "error");
                }

                return false;
            }

            }
        }
    }


    //#2 Validacion de resetar Usuario para recuprar cuenta

    if(document.querySelector("#formRecetPass")){

        let formRecetPass = document.querySelector("#formRecetPass");

        formRecetPass.onsubmit = function(e){
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmailReset').value;

            if(strEmail == ""){

                swal("Porfavor", "Escriba Tu Correo Electrónico", "error");
                return false;
            }else{

                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

                var ajaxUrl = base_url+'/Login/resetPass';

                var formData = new FormData(formRecetPass);

                request.open("POST",ajaxUrl,true);
                request.send(formData);
                
                request.onreadystatechange = function(){

                    console.log(request);
                }
            }
        }
    }
}, false);