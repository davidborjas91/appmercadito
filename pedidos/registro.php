
<!------ Include the above in your HEAD tag ---------->
<?php

session_start();
if(isset($_SESSION['plataforma']))
{
 echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../index.php'>";
 exit;
 //echo "Usuario ".$_SESSION['username'];

}
 ?>
<!DOCTYPE html>
<html  lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="PLATAFORMA MI MERCADITO">
  <meta name="author" content="FAVIO ERAZO">
  <title>Mi Mercadito</title>

  <link rel="icon" type="image/png" href="img/icono/favicon.ico" />

  <style media="screen">
  /* Coded with love by Mutiullah Samim */
body,
html {
  margin: 0;
  padding: 0;
  height: 100%;
  background: #60a3bc !important;
}
.user_card {
  height: 400px;
  width: 350px;
  margin-top: auto;
  margin-bottom: auto;
  background: #FFFF;
  position: relative;
  display: flex;
  justify-content: center;
  flex-direction: column;
  padding: 10px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  border-radius: 5px;

}
.brand_logo_container {
  position: absolute;
  height: 170px;
  width: 170px;
  top: -75px;
  border-radius: 50%;
  background: #60a3bc;
  padding: 10px;
  text-align: center;
}
.brand_logo {
  height: 150px;
  width: 150px;
  border-radius: 50%;
  border: 2px solid white;
}
.form_container {
  margin-top: 100px;
}
.login_btn {
  width: 100%;
  background: #5e68ff !important;
  color: white !important;
}
.login_btn:focus {
  box-shadow: none !important;
  outline: 0px !important;
}
.login_container {
  padding: 0 2rem;
}
.input-group-text {
  background: #5e68ff !important;
  color: white !important;
  border: 0 !important;
  border-radius: 0.25rem 0 0 0.25rem !important;
}
.input_user,
.input_pass:focus {
  box-shadow: none !important;
  outline: 0px !important;
}
.custom-checkbox .custom-control-input:checked~.custom-control-label::before {
  background-color: #5e68ff !important;
}
  </style>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <script src="https://bfdtechnologies.info/js/bootstrap-notify.js">  </script>
    <!-- Bootstrap core JavaScript-->
    <script src="https://bfdtechnologies.info/vendor/jquery/jquery.min.js"></script>
    <script src="https://bfdtechnologies.info/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://bfdtechnologies.info/vendor/jquery-easing/jquery.easing.min.js"></script>

<!--  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
</head>
<!--Coded with love by Mutiullah Samim-->
<body>

        <strong name="latitud" id="latitud" ></strong>
        <strong name="longitud" id="longitud"></strong>

        <input type="hidden" name="ubicacion" id="ubicacion" value="0,0">

	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img  width="200"
            height="200" src="https://appmercadito.com/pedidos/img/merc.jpeg" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form class="user" action="" method="POST" id="frmRegistro">
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input required type="text" class="form-control input_user"
              placeholder="Ingrese su Nombre..."  id="nombre"
               name="nombre" required="true">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-at"></i></span>
              </div>
              <input required type="email" class="form-control input_user"
              placeholder="Ingrese su correo..."  id="usuario"
               name="usuario" required="true">
            </div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input required type="password" class="form-control input_pass " value=""
              id="pass" placeholder="Contraseña" required="true" name="pass">
						</div>
						<!--<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="customControlInline">
								<label class="custom-control-label" for="customControlInline">Remember me</label>
							</div>
						</div>-->
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<!--<button type="button" name="button" class="btn login_btn ">Entrar</button>-->
          <input type="submit" value="CREAR CUENTA" class="btn  btn-block btn-success"/>

				   </div>
					</form>
				</div>

				<div class="mt-4">
					<div class="d-flex justify-content-center links">
           <a href="login.php" class="ml-2">Iniciar Sesion</a>
					</div>
				</div>
			</div>
		</div>
	</div>


      <!-- Modal -->
      <div class="modal fade" id="mensajeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Mensaje</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
             <div id="msj" class="carousel slide" data-ride="carousel">

              </div>
           </div>
           <div class="modal-footer text-center">
            <center> <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </center>
           </div>
         </div>
       </div>
      </div>


      <script src="https://bfdtechnologies.info/js/bootstrap-notify.js">  </script>
  <script type="text/javascript">


    $("#frmRegistro" ).submit(function( event ) 
    {
      var validando=$.notify({
                title: '<strong>Validando Datos</strong>',
                message: 'Espere un momento.'
              },{
                type: 'success'
              });
      var datosForm=new FormData(document.getElementById("frmRegistro"));
      datosForm.append("funcion","fcnSTCta");
      datosForm.append("ubicacion" , $("#ubicacion").val());
          

          $.ajax({
        url: "core/funciones.sql.php",
        type: "POST",
        data: datosForm,
        contentType: false,
        processData: false,
        success: function(mensaje)
        {
          //console.log(mensaje);
          if(mensaje=='OK'){
            $.ajax({
                url: "core/core.login.php",
                type: "POST",
                data: datosForm,
                contentType: false,
                processData: false,
                success: function(mensaje)
                {
                  if(mensaje=='OK'){
                     location.reload();

                  }else {
                    console.log("Respuesta > ( "+mensaje+" )");

                    $('#msj').html('ERROR: '+mensaje);

                    $('#mensajeModal').modal('show');
                  }
                }
            });

        }else {
          console.log("Respuesta > ( "+mensaje+" )");

          $('#msj').html('ERROR: '+mensaje);

          $('#mensajeModal').modal('show');
            //$('#tmp').html(mensaje);
          }
        }
    });
      event.preventDefault();
    });


    $( document ).ready(function() {
          //setTimeout(geo(), 1000);
          geo();
      });
    function geo()
    { //user click on button

        var options = {
          enableHighAccuracy: true,
          timeout: 12000,
          maximumAge: 0
        };

      navigator.geolocation.getCurrentPosition( success, error, options );

      function success(position) {
        var coordenadas = position.coords;
        console.log("entro");
        //alert("Entro");
        $('#ubicacion').val(coordenadas.latitude+","+coordenadas.longitude);
        console.log('Coordenada(' + coordenadas.latitude+","+coordenadas.longitude);

      };

      function error(error) {
        console.warn('ERROR(' + error.code + '): ' + error.message);
        setTimeout(geo(), 1000);
      };
    }
  </script>
</body>
</html>
