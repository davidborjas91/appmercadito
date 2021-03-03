<?php

session_start();
/*if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
{
 echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php'>";
 exit;
 //echo "Usuario ".$_SESSION['username'];

} */
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <meta name="theme-color" content="#2196F3">
    <link rel="icon" type="image/png" href="https://bfdtechnologies.info/img/icono/favicon.ico">
    <title>.::Mercadito Delivery::.</title>

    <!-- CSS  -->
    <link href="min/plugin-min.css" type="text/css" rel="stylesheet">
    <link href="min/custom-min.css" type="text/css" rel="stylesheet" >

        <script src="https://bfdtechnologies.info/vendor/jquery/jquery.min.js">
        </script>



        <script src="https://bfdtechnologies.info/vendor/jquery/jquery.min.js">
        </script>

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
  top: 0px;
  left : 0px;
  z-index: 1;
}

.heaven
{
  position:absolute;
  z-index: -1;
}
    </style>

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
        border-radius: 5px 5px 10px 10px;
      }
      </style>
</head>
<body id="top" class="scrollspy">

    <div class="loader" id="loader"></div>


    <script type="text/javascript">

      $( document ).ready(function() {
        var URLactual = window.location.href;
        console.log(URLactual);
        if(URLactual=='https://appmercadito.com/'){
            console.log(URLactual+"#work");
            window.location.href=URLactual+"#work";/*
            window.location.replace('http://www.example.com')
window.location.assign('http://www.example.com')
window.location.href = 'http://www.example.com'*/
          }

        $(".loader").fadeIn("fast");
          setTimeout(geo(), 5000);

          //alert(URLactual);

      });

      function geo()
      { //user click on button

          //$(".loader").fadeIn("fast");
          var options = {
            enableHighAccuracy: true,
            timeout: 12000,
            maximumAge: 0
          };

        navigator.geolocation.getCurrentPosition( success, error, options );

        function success(position) {
          var coordenadas = position.coords;

          $(".loader").fadeIn("fast");

          console.log('Tu posición actual es:');
          console.log('Latitud : ' + coordenadas.latitude);
          console.log('Longitud: ' + coordenadas.longitude);
          console.log('Más o menos ' + coordenadas.accuracy + ' metros.');
          //alert('Latitud : ' + coordenadas.latitude);
          //alert('Longitud : ' + coordenadas.longitude);

          $('#ubicacion').val(coordenadas.latitude+","+coordenadas.longitude);

          //alert($('#ubicacion').val());

                 		//document.getElementById('filtro').hidden='';
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

        $('#empresas').append('<a class="btn btn-waning" onclick="location.reload();"> Reintentar </a>');


          
          //setTimeout($('#mensajeModal').modal('show'), 1000);
          setTimeout(geo(), 2000);


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
        $.post("pedidos/core/funciones.sql.php",
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
            //console.log($c_empresa);
            //console.log($d_empresa);
            //console.log($d_logo);
        $( "#frmProductos" ).submit();
      }

        function cerrado($comercio,$mensaje)
        {
            $('#msj').html('EL COMERCIO '+$comercio+' '+$mensaje+'.');

            $('#mensajeModal').modal('show');
        }
      </script>

<!-- Pre Loader -->
<div id="loader-wrapper">
    <div id="loader"></div>

    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>

</div>

<!--Navigation-->
 <div class="navbar-fixed">
    <nav id="nav_f" class="default_color" role="navigation">
        <div class="container">
            <div class="nav-wrapper">
            <a href="https://bfdtechnologies.info/login.php" id="logo-container" class="brand-logo">Mercadito</a>
                <ul class="right hide-on-med-and-down">
                    <!--<li><a href="https://pedidos.bfdtechnologies.info/" target="_blank">Hacer Pedido</a></li>-->
                    
                    <?php
                        if(!isset($_SESSION['loggedin']) )
                        {
                          //if($_SESSION['loggedin'])
                         echo '  <li><a href="pedidos/login.php">Entrar</a></li>';

                        } 
                    ?>
                    <li><a href="#work">Comercios</a></li>
                    <!--<li><a href="#team">Colaboradores</a></li>-->
                    <li><a href="#contact">Contacto</a></li>
                    <li><a href="https://play.google.com/store/apps/details?id=bfd.dev.mercadmin&hl=es_HN" target="_blank">Descargar</a></li>
                     <?php
                        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
                        {
                         echo '  <li><a href="pedidos/core/core.logout.php">Salir</a></li>';

                        } 
                    ?>
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <!--<li><a href="https://pedidos.bfdtechnologies.info/" target="_blank">Hacer Pedido</a></li>
                    <li><a href="#intro">Servicio</a></li>-->
                    <?php
                        if(!isset($_SESSION['loggedin']) )
                        {
                          //if($_SESSION['loggedin'])
                         echo '  <li><a href="pedidos/login.php">Entrar</a></li>';

                        } 
                    ?>
                    <li><a href="#work">Comercios</a></li>
                    <!--<li><a href="#team">Colaboradores</a></li>-->
                    <li><a href="#contact">Contacto</a></li>
                    <li><a href="https://play.google.com/store/apps/details?id=bfd.dev.mercadmin&hl=es_HN" target="_blank">Descargar</a></li>
                     <?php
                        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
                        {
                          if($_SESSION['loggedin'])
                         echo '  <li><a href="pedidos/core/core.logout.php">Salir</a></li>';

                        } 
                    ?>
                </ul>
            <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
            </div>
        </div>
    </nav>
</div>


<!--
<div hidden class="section scrollspy" id="work">
    <div class="container">
        <h2 class="header text_b">Afiliados </h2>
        <div class="row">
          <div id="empresas" class="section row col-12 col-sm-12  text-center"></div>
        </div>
    </div>
</div>
<div class="section no-pad-bot" id="index-banner">
    <div class="container">


  </div>
</div>-->

<!--Hero-->
<div class="section no-pad-bot" id="index-banner">
    <div class="container">
      
                 
                  <?php

                  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
                  {
                   echo '  <center>
                   <a class="blue-text btn btn-large waves-effect waves-light white darken-1" href="#work">
                          <i class="mdi-action-shopping-cart right blue-text">
                          </i> Hacer Pedido
                        </a>

                </center>';
                   //exit;
                   //echo "Usuario ".$_SESSION['username'];

                  } 
                   ?>

                        <input hidden type="text" name="filtro" onkeyup="listarProductos();" placeholder="Buscar" id="filtro" hidden="true"/>
               


                   

        <h1 class="text_h center header cd-headline letters type">
          <span>Nosotros te lo llevamos, </span>
          <span class="cd-words-wrapper waiting">
              <b class="is-visible">Tu lo quieres.</b>
              <b>Tu lo pides.</b>
              <b>Tu lo Regalas.</b>
          </span>

        </h1>


    </div>
</div>

<!--Intro and service-->
<div id="intro" class="section scrollspy">
    <div class="container">
        <div class="row">
            <div  class="col s12">
                <h2 class="center header text_h2"> Somos la plataforma donde puedes realizar  <span class="span_h2">compras</span>
                   de tus comercios favoritos o  <span class="span_h2">afiliarte</span> para ofrecer tus productos.

  </h2>
            </div>

            <div  class="col s12 m4 l4">
                <div class="center promo promo-example">
                    <i class="mdi-image-flash-on"></i>
                    <h5 class="promo-caption">Agilidad en las entregas</h5>
                    <p class="light center">Hacerte llegar el producto que necesitas en el tiempo optimo es nuestra prioridad.</p>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="center promo promo-example">
                    <i class="mdi-social-group"></i>
                    <h5 class="promo-caption">Buena Atencion</h5>
                    <p class="light center">Nuestos colaboradores te entregaran un trato agradable y personalizado en cada orden que realices.</p>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="center promo promo-example">
                    <i class="mdi-hardware-desktop-windows"></i>
                    <h5 class="promo-caption">Enfoque Multiplataforma</h5>
                    <p class="light center">Realiza tus pedidos desde cualquier lugar que desees desde Laptops, Tablets, Telefonos Moviles, etc.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Work-->
<div class="section scrollspy" id="work">
    <div class="container">
        <h2 class="header text_b">Afiliados </h2>
        <div class="row">
            <!--<div class="col s12 m4 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="img/project1.jpg">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">DISTRIBUIDORA EL CEIBON <i class="mdi-navigation-more-vert right"></i></span>
                        <p><a href="#">Project link</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">DISTRIBUIDORA EL CEIBON <i class="mdi-navigation-close right"></i></span>
                        <p>Here is some more information about this project that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="img/project2.jpeg">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">HAMBUS<i class="mdi-navigation-more-vert right"></i></span>
                        <p><a href="#">Project link</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">HAMBUS <i class="mdi-navigation-close right"></i></span>
                        <p>Here is some more information about this project that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="img/project3.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">RESTAURANTE MALKA <i class="mdi-navigation-more-vert right"></i></span>
                        <p><a href="#">Project link</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">RESTAURANTE MALKA <i class="mdi-navigation-close right"></i></span>
                        <p>Here is some more information about this project that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="img/project4.jpg">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">RESTAURANTE TIPIKTRACHO <i class="mdi-navigation-more-vert right"></i></span>
                        <p><a href="#">Project link</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">RESTAURANTE TIPIKTRACHO <i class="mdi-navigation-close right"></i></span>
                        <p>Here is some more information about this project that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="img/project5.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">GARDENS FRIEND <i class="mdi-navigation-more-vert right"></i></span>
                        <p><a href="#">Project link</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">GARDENS FRIEND <i class="mdi-navigation-close right"></i></span>
                        <p>Here is some more information about this project that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="img/project6.jpeg">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">RESTAURANTE CASA MIA <i class="mdi-navigation-more-vert right"></i></span>
                        <p><a href="#">Project link</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">RESTAURANTE CASA MIA <i class="mdi-navigation-close right"></i></span>
                        <p>Here is some more information about this project that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>-->
            <form class="col-md-8" action="pedidos/empresa/index.php" method="post" id="frmProductos">
      <div class="row col s12" id="empresas">
      </div>
      <input type="hidden" name="c_empresa"  id="c_empresa" value="3037">
         <input type="hidden" name="d_empresa" id="d_empresa" value="DISTRIBUIDORA EL CEIBON">
         <input type="hidden" name="d_logo" id="d_logo" value="">


        <input type="hidden" name="ubicacion" id="ubicacion" value="0,0">
      </form>
        </div>
    </div>
</div>

<!--Parallax-->
<div class="parallax-container">
    <div class="parallax"><img src="img/delivery.png"></div>
</div>

<!--Team
<div class="section scrollspy" id="team">
    <div class="container">
        <h2 class="header text_b"> Colaboradores </h2>
        <div class="row">
            <div class="col s12 m3">
                <div class="card card-avatar">
                    <div class="waves-effect waves-block waves-light">
                        <img class="activator" src="img/avatar1.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Favio Erazo <br/>
                            <small><em><a class="red-text text-darken-1" href="#">Colaborador</a></em></small></span>
                        <p>

                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card card-avatar">
                    <div class="waves-effect waves-block waves-light">
                        <img class="activator" src="img/avatar2.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Selbin Velasquez<br/>
                            <small><em><a class="red-text text-darken-1" href="#">Colaborador</a></em></small>
                        </span>
                        <p>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card card-avatar">
                    <div class="waves-effect waves-block waves-light">
                        <img class="activator" src="img/avatar3.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">
                            Francisco Erazo <br/>
                            <small><em><a class="red-text text-darken-1" href="#">Colaborador</a></em></small></span>
                        <p>

                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card card-avatar">
                    <div class="waves-effect waves-block waves-light">
                        <img class="activator" src="img/avatar4.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Gloria Moncada<br/>
                            <small><em><a class="red-text text-darken-1" href="#">Colaboradora</a></em></small></span>
                        <p>
                            <a class="blue-text text-lighten-2" href="https://www.facebook.com/joash.c.pereira">
                                <i class="fa fa-facebook-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://twitter.com/im_joash">
                                <i class="fa fa-twitter-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://plus.google.com/u/0/+JoashPereira">
                                <i class="fa fa-google-plus-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://www.linkedin.com/in/joashp">
                                <i class="fa fa-linkedin-square"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card card-avatar">
                    <div class="waves-effect waves-block waves-light">
                        <img class="activator" src="img/avatar4.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Riccy Andino<br/>
                            <small><em><a class="red-text text-darken-1" href="#">Colaboradora</a></em></small></span>
                        <p>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<!--Footer-->
<footer id="contact" class="page-footer default_color scrollspy">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <form class="col s12" action="#" method="post" id="contacto">
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="mdi-action-account-circle prefix white-text"></i>
                            <input id="name" name="name" type="text" class="validate white-text">
                            <label for="name" class="white-text">Nombre</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="mdi-communication-email prefix white-text"></i>
                            <input id="email" name="email" type="email" class="validate white-text">
                            <label for="email" class="white-text">Correo</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="mdi-editor-mode-edit prefix white-text"></i>
                            <textarea id="message" name="message" class="materialize-textarea white-text"></textarea>
                            <label for="message" class="white-text">Mensaje</label>
                        </div>
                        <div class="col offset-s7 s5">
                            <button class="btn waves-effect waves-light red darken-1" type="submit">Enviar
                                <i class="mdi-content-send right white-text"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Mercadito</h5>
                <ul>
                    <li><a class="white-text" href="https://bfdtechnologies.info/login.php">Afiliados</a></li>
                    <li><a class="white-text" href="pedidos/login.php">Clientes</a></li>
                    <li><a class="white-text" href="https://admin.appmercadito.com/">Administracion</a></li>
                </ul>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Redes Sociales</h5>
                <ul>
                    <li>
                        <a class="white-text" href="https://instagram.com/mimercaditohn?r=nametag">
                            <i class="small fa fa-instagram white-text"></i> Instagram
                        </a>
                    </li>
                    <li>
                        <a class="white-text" href="https://fb.com/Mi-Mercadito-105114794412054/">
                            <i class="small fa fa-facebook-square white-text"></i> Facebook
                        </a>
                    </li>
                    <li>
                        <a class="white-text" href="tel:+50433011054">
                            <i class="small fa fa-phone white-text"></i> Telefono

                        </a>
                    </li>
                    <li>
                        <a class="white-text" href="https://wa.me/message/VSHT627DEKDKL1">
                            <i class="small fa fa-comments white-text"></i> Whastapp
                        </a>
                    </li>
                    <li>
                        <a class="white-text" href="mailto:info@appmercadito.com">
                            <i class="small fa fa-envelope white-text"></i> Correo
                        </a>
                    </li>

                </ul>
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


    <div class="footer-copyright default_color">
        <div class="container">
            Dev By <a class="white-text" href="https://bfdtechnologies.info/">BFD TECHNOLOGIES © 2020</a>.
        </div>
    </div>
</footer>


    <!--  Scripts-->
    <script type="text/javascript">
    $( "#contacto" ).submit(function( event ) {


        var datosForm=new FormData(document.getElementById("contacto"));//$("#frmHor").serializeArray() ;
      //alert( "datos: "+datos);
      //console.log(datosForm);
      datosForm.append("funcion","fcnSTCont");
      //datosForm.append("empresa",$("#formModificar").serializeArray());
      datosForm.append("nombre",$("#name").val() );
      datosForm.append("correo", $("#email").val());
      datosForm.append("mensaje", $("#message").val());

    $.ajax({
      url: "pedidos/core/funciones.sql.php",
      type: "POST",
      data: datosForm,
      contentType: false,
      processData: false,
      success: function(mensaje)
      {
        //console.log(mensaje);
        if(mensaje==''){

        document.getElementById("contacto").reset();
        alert("MENSAJE ENVIADO CON EXITO");

      }else {
        console.log("Respuesta > ( "+mensaje+" )");

       alert('ERROR: '+mensaje);
        }
      }
  });

        event.preventDefault();
      });
    </script>
    <script src="min/plugin-min.js"></script>
    <script src="min/custom-min.js"></script>

    </body>
</html>
