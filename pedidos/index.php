<?php
date_default_timezone_set('America/Tegucigalpa');
$time = time();

//echo date("Ymd_H_i_s", $time);

 ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>.::MI MERCADITO::. </title>
    <style>
    .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('https://bfdtechnologies.info/img/cargando.gif') 50% 50% no-repeat rgb(249,249,249);
      opacity: .8;
      }

      .eye{
  position:absolute;
  top: 5px;
  left : 11px;
  z-index: 1;
}

.heaven
{
  position:absolute;
  z-index: -1;
}
    </style>
  <link rel="icon" type="image/png" href="https://bfdtechnologies.info/img/icono/favicon.ico" />
      <style>
      .producto {
        padding: inherit;
      }
      .form {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        border-radius: 5px;
      }
      img {
        border-radius: 10px 10px 10px 10px;
      }
      </style>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <!--<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">-->
        <link href="css/fonts.googleapis.css" rel="stylesheet">


        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <script src="vendor/jquery/jquery.min.js">
        </script>

         <!--<script src="https://bfdtechnologies.info/js/FancyZoom.js" type="text/javascript"></script>
         <script src="https://bfdtechnologies.info/js/FancyZoomHTML.js" type="text/javascript"></script>-->

      <script type="text/javascript">

      $( document ).ready(function() {
        geo();
        $('.carousel').carousel({
            interval:2500
          });


      });
      var lstPro;
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

          console.log('Tu posición actual es:');
          console.log('Latitud : ' + coordenadas.latitude);
          console.log('Longitud: ' + coordenadas.longitude);
          console.log('Más o menos ' + coordenadas.accuracy + ' metros.');
          //alert('Latitud : ' + coordenadas.latitude);
          //alert('Longitud : ' + coordenadas.longitude);

          $('#ubicacion').val(coordenadas.latitude+","+coordenadas.longitude);

          //alert($('#ubicacion').val());

                 		document.getElementById('filtro').hidden='';
          listarProductos();

                    //$('#nuevaEmpresaModal').modal('show');
        };

        function error(error) {
          console.warn('ERROR(' + error.code + '): ' + error.message);

                                $(".loader").fadeOut("fast");
          //listarProductos();
          //alert('NO SE LOGRO CAPTURAR SU UBICACION');
          //document.getElementById('filtro').hidden='';


          $('#msj').html('NO SE LOGRO CAPTURAR SU UBICACION, ASEGURESE QUE ESTE ACTIVO EL SERVICIO DE GPS.');

          $('#empresas').html('<h1>NO SE LOGRO CAPTURAR SU UBICACION, ASEGURESE QUE ESTE ACTIVO EL SERVICIO DE GPS.</h1>');
          $('#empresas').append('<p><strong>Es Necesario capturar tu ubicacion para poder asegurarnos de brindarte las mejores opciones mostrandote los comercios mas cercanos.<strong></p>');

          $('#mensajeModal').modal('show');


          //alert('ERROR(' + error.code + '): ' + error.message);
        };
      }

    function isMobile(){
      return (
          (navigator.userAgent.match(/Android/i)) ||
          (navigator.userAgent.match(/webOS/i)) ||
          (navigator.userAgent.match(/iPhone/i)) ||
          (navigator.userAgent.match(/iPod/i)) ||
          (navigator.userAgent.match(/iPad/i)) ||
          (navigator.userAgent.match(/BlackBerry/i))
      );
    }
      function listarProductos()
      {

          $(".loader").fadeIn("fast");
        var movil="25";
        if ( isMobile() ) {
        //alert("Es Telefono");
        movil="50";
       // código en el caso de que sea un dispositivo móvil
      }
        var $c_empresa=$("#c_empresa").val();
        //alert($('#filtro').val());
        $.post("core/funciones.sql.php",
        {
          funcion : 'fcnLstEmp',
            coordenadas : $('#ubicacion').val(),
              filtro : $('#filtro').val(),
          tel: movil},
          function(mensaje) {
            $('#empresas').html(mensaje);

                      $(".loader").fadeOut("fast");
            //console.log(mensaje);
            //alert(mensaje);

            //setupZoom();

          });


        //alert(c_empresa);
      }
      function stEmpPro($c_empresa,$d_empresa,$d_logo)
      {
        $('#c_empresa').val($c_empresa);
          $('#d_empresa').val($d_empresa);
            $('#d_logo').val($d_logo);
          $( "#frmProductos" ).submit();
      }
      </script>
  </head>
  <body>

    <div class="loader" id="loader"></div>
    <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mensajeModal">Open Modal</button>-->
      <?php
  //  echo "HOLA";
     ?>
     <br/>

       <center> <!--<h1>MI MERCADITO</h1>-->
        <!--  <h1>LISTADO DE EMPRESAS</h1>-->
       <form class="col-md-8" action="empresa/index.php" method="post" id="frmProductos">

          <!-- <img src="img/mercadito.png"
               alt="Sin Imagen"
               width="100"
              height="100"/>-->
              <div class="col-md-4" >

                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img class="d-block w-100" src="img/promocion.jpeg" width="400"
                     height="200" alt="First slide">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="img/ceibon.jpeg" alt="Second slide" width="400"
                     height="200">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="img/img2.png" alt="Third slide" width="100"
                     height="200">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="img/img3.png" alt="fourt slide" width="100"
                     height="200">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="img/img4.png" alt="fourt slide" width="100"
                     height="200">
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                  </a>
                 </div>

              </div>

         <input type="hidden" name="c_empresa"  id="c_empresa" value="3037">
         <input type="hidden" name="d_empresa" id="d_empresa" value="DISTRIBUIDORA EL CEIBON">
         <input type="hidden" name="d_logo" id="d_logo" value="">
           <hr/>

        <input type="hidden" name="ubicacion" id="ubicacion" value="0,0">
       <input type="text" name="filtro" onkeyup="listarProductos();" placeholder="Buscar" id="filtro" hidden='true'>
       <br/>
       <br/>


     <div id="empresas" class="col-12 col-sm-12 row text-center">

     </div>
   </form>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

   <!-- Button trigger modal
   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevaEmpresaModal">
     Launch demo modal
   </button>
-->


<!-- Modal -->
<div class="modal fade" id="nuevaEmpresaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="exampleModalLabel">PROMOCION</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
       <!--<img src="img/promocion.jpeg" alt="Sin Imagen" style="width:100%;position: relative;" width="400" height="400">
-->
       <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
         <ol class="carousel-indicators">
           <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
           <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
           <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
           <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
         </ol>
         <div class="carousel-inner">
           <div class="carousel-item active">
             <img class="d-block w-100" src="img/promocion.jpeg" alt="First slide">
           </div>
           <div class="carousel-item">
             <img class="d-block w-100" src="img/ceibon.jpeg" alt="Second slide">
           </div>
           <div class="carousel-item">
             <img class="d-block w-100" src="img/promocion.jpeg" alt="Third slide">
           </div>
           <div class="carousel-item">
             <img class="d-block w-100" src="img/ceibon.jpeg" alt="fourt slide">
           </div>
         </div>
         <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
           <span class="carousel-control-prev-icon" aria-hidden="true"></span>
           <span class="sr-only">Previous</span>
         </a>
         <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
           <span class="carousel-control-next-icon" aria-hidden="true"></span>
           <span class="sr-only">Next</span>
         </a>
        </div>
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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




   <script type="text/javascript">
   $("#frmProductos").submit(function(e){
   //console.log($('#c_empresa').val());
     //alert("Envio info");
           //  e.preventDefault();
    });

    function cerrado($comercio,$mensaje)
    {
        $('#msj').html('EL COMERCIO '+$comercio+' '+$mensaje+'.');

        $('#mensajeModal').modal('show');
    }
   </script>

  </body>
</html>
