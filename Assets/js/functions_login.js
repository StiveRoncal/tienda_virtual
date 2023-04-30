
//#1 funcion de login para mover tipo flp de login a resetear login
$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
});


// documento de recarga a todos las funciones

document.addEventListener('DOMContentLoaded', function(){
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

                console.log(request);
            }

        }
    }
}, false);