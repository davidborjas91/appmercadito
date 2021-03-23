
<?php

session_start();
date_default_timezone_set('America/Tegucigalpa');
$time = time();

//echo date("Ymd_H_i_s", $time);
/*
echo $_POST['c_empresa'];
echo $_POST['ubicacion'];*/

//echo $_POST['ubicacion'];
if(!isset($_POST['d_empresa']))
/*echo $_POST['d_empresa'];
else */{
  header('Location: ../../');
}
 ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>.::MI MERCADITO::. - <?php if(isset($_POST['d_empresa']))echo $_POST['d_empresa']; ?></title>

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
  border-radius: 10px 10px 0 0;
}

#cabecera {  
  width: 100%;
  left: 0;
  top: 0;
  position: fixed; /* Hacemos que la cabecera tenga una posición fija */
  z-index:1;
  background-color:#FFFFFF;
}
#frmPedido {  
  padding-top: 200px; /* Hacemos que la cabecera tenga una posición fija */
}
</style>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!--<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">-->
  <link href="../css/fonts.googleapis.css" rel="stylesheet">


  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <script src="../vendor/jquery/jquery.min.js">
  </script>

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



 <script src="https://bfdtechnologies.info/js/FancyZoom.js" type="text/javascript"></script>
 <script src="https://bfdtechnologies.info/js/FancyZoomHTML.js" type="text/javascript"></script>

  <script type="text/javascript">

  function geo()
  { //user click on button
      var options = {
        enableHighAccuracy: true,
        timeout: 6000,
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
    };

    function error(error) {
      console.warn('ERROR(' + error.code + '): ' + error.message);

      //alert('ERROR(' + error.code + '): ' + error.message);
    };
  }

    $( document ).ready(function() {

            //console.log("hgjhgj");

      listarProductos();
      //geo();
    });
    var lstPro;

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
       var tmp=$("#tipo_pro").val();
       document.getElementById("frmPedido").reset();
       $("#tipo_pro").val(tmp);
      $("#c_empresa").val("<?php echo $_POST['c_empresa']; ?>");
      $("#d_empresa").val("<?php echo $_POST['d_empresa']; ?>");
      $("#d_logo").attr("src","<?php echo 'https://bfdtechnologies.info/imagenes/'.explode( '-', $_POST['c_empresa'])[0].'/'.$_POST['d_logo']; ?>");


      var $c_empresa=$("#c_empresa").val();
      $.post("../core/funciones.sql.php",
      {
        funcion : 'fcnLstProEmp',
        c_sucursal: $c_empresa,
        c_tipo: $("#tipo_pro").val(),
        tel: movil},
        function(mensaje) {
          $('#productos').html(mensaje);
          $(".loader").fadeOut("fast");
          //console.log(mensaje);
          //alert(mensaje);

          //setupZoom();

        });

        $.post("../core/funciones.sql.php",
        {
          funcion : 'fcnLstProEmpArray',
          c_empresa: $c_empresa},
          function(mensaje) {
            //$('#productos').html(mensaje);
            console.log(mensaje);
            //alert(mensaje);
            lstPro=mensaje;
            lstPro= JSON.parse(lstPro);
            $('#ubicacion').val('<?php echo $_POST['ubicacion']; ?>');
            /*for (var i = 0; i < lstPro.length; i++) {

              console.log(lstPro[i]);
            }*/
            console.log(lstPro);

          });

      //alert(c_empresa);
    }
    function up($c_producto,$complementos)
    {

      var objeto="#pro_"+$c_producto;
      //  $(objeto).val(parseFloat($(objeto).val())+1);
      //alert($c_producto);
      var total=0;
      for (var i = 0; i < lstPro.length; i++) {
        if(lstPro[i]["c_producto"]==$c_producto)
        {
          //if(parseFloat(lstPro[i]["cantidad"])>0)
          if($complementos==0 || $('#detalleProdModal').is(':visible'))
         lstPro[i]["cantidad"]=  parseFloat(lstPro[i]["cantidad"])+1;

           lstPro[i]["subtotal"]=  parseFloat(lstPro[i]["cantidad"])*parseFloat(lstPro[i]["v_precio_inicial"]);
        //  console.log("ENCONTRO: "+lstPro[i]["cantidad"]);

          $("#pro_st_"+$c_producto).val(lstPro[i]["subtotal"]);

          $(objeto).val(lstPro[i]["cantidad"]);

          console.log($('#detalleProdModal').is(':visible'));
          if(/*parseFloat(lstPro[i]["cantidad"])>0 &&*/ !$('#detalleProdModal').is(':visible')
        && $complementos>0)
          {
            detalleProducto($c_producto);
            $("#modal_pro_"+$c_producto).val(lstPro[i]["cantidad"]);
          }

          if($('#detalleProdModal').is(':visible'))
          $("#modal_pro_"+$c_producto).val(lstPro[i]["cantidad"]);

          var c_producto=lstPro[i]["c_producto"];
          var cantidad=lstPro[i]["cantidad"];
          var c_empresa=$("#c_empresa").val();
          //alert(lstPro[i]["cantidad"]+"="+lstPro[i]["c_producto"]+"-"+$("#c_empresa").val());
          carrito(c_producto, cantidad, c_empresa, 1);
        }

        total=parseFloat(total)+parseFloat(lstPro[i]["subtotal"]);
        
      }
      
      $("#subtotal").val(total);

      var tot=parseFloat($("#subtotal").val())+parseFloat($("#envio").val());
      $("#total").val(tot);

      //valida($c_producto,"up");
    }
    function down($c_producto)
    {
      var objeto="#pro_"+$c_producto;
      //if($(objeto).val()>0)
      //$(objeto).val(parseFloat($(objeto).val())-1);
      var total=0;
      for (var i = 0; i < lstPro.length; i++) {
        if(lstPro[i]["c_producto"]==$c_producto)
        {
          if(parseFloat(lstPro[i]["cantidad"])>0)
          {
            lstPro[i]["cantidad"]=  parseFloat(lstPro[i]["cantidad"])-1;
              lstPro[i]["subtotal"]=  parseFloat(lstPro[i]["cantidad"])*parseFloat(lstPro[i]["v_precio_inicial"]);
           //console.log("ENCONTRO: "+lstPro[i]["cantidad"]);
             $("#pro_st_"+$c_producto).val(lstPro[i]["subtotal"]);

            if($('#detalleProdModal').is(':visible'))
            $("#modal_pro_"+$c_producto).val(lstPro[i]["cantidad"]);


           $(objeto).val(lstPro[i]["cantidad"]);

          }

        }
                total=parseFloat(total)+parseFloat(lstPro[i]["subtotal"]);

      }

      //console.log(total);
            $("#subtotal").val(total);
      var tot=parseFloat($("#subtotal").val())+parseFloat($("#envio").val());
      if(tot>parseFloat($("#envio").val()))
          $("#total").val(tot);
      else
          $("#total").val(0);

      //valida($c_producto,"down");
    }

    function imprime()
    {
      for (var i = 0; i < lstPro.length; i++) {

        console.log(lstPro[i]);
      }
    }
    function valida($item,ope)
    {
      var objeto="#pro_"+$item;
      //alert("modifico "+objeto);
      //  alert("modifico "+$(objeto).val());
      if($(objeto).val()=='')
      $(objeto).val("0");
      else if($(objeto).val()<0)
      $(objeto).val("0");

      calculaTotal($item,ope);
    }
    function calculaTotal($item,ope)
    {
      console.log($item);
      var total=parseFloat($("#total").val());
      var precio=parseFloat($("#pro_v_"+$item).val());
      var cantidad=parseFloat($("#pro_"+$item).val());
      var cantidad1=cantidad-1;
      if(ope=="down" )
      cantidad1=cantidad+1;
      if(cantidad1<0)
      cantidad1=0;
      var subtotal=(cantidad1)*precio;

            if(cantidad==0)
            subtotal=0;
      total=total-subtotal;
      subtotal=(cantidad)*precio;
      console.log(total);
      console.log(cantidad);
      console.log(precio);
      /*
      if(ope=="down")
      total=total+subtotal;
      else */
      if(subtotal<0)
      subtotal=0;


      if(cantidad==0)
      subtotal=0;

      if(total<0)
      total=0;

      total=total+subtotal;
      if(total<0)
      total=0;

      $("#pro_st_"+$item).val(subtotal);
      $("#total").val(total);


    }
  </script>


  <link rel="icon" type="image/png" href="../img/icono/favicon.ico" />
  </head>
  <body>
    <div class="loader" id="loader"></div>
      <div id="tmp"></div>
  <br/>
  <br/>

    <center> <!--<h2>MI MERCADITO</h2>
       <h3>LISTADO DE PRODUCTOS</h3>-->
       <header id="cabecera">
      <h3 ><?php if(isset($_POST['d_empresa']))echo $_POST['d_empresa']; ?></h3>
 <img href="https://pedidos.bfdtechnologies.info/" src="../img/mercadito.png"
            alt="Sin Imagen"
            width="80"
           height="80"
           style="border-radius: 10px 10px 10px 10px;"
           id="d_logo"/>
<br/>
<input type="text" name="filtro" onkeyup="listarProductos();" placeholder="Buscar" id="filtro" >
         <hr/>
         <a class="btn btn-primary" href="usuario.php" role="button">Usuario</a>
         <a class="btn btn-primary" href="carro.php" role="button">Carro</a>
</header>

    <form class="col-md-11 col-sm-12" action="#" method="post" id="frmPedido">

       
        <!-- <img src="../img/ceibon.jpeg"
               alt="Sin Imagen"
               width="100"
              height="100"/>-->

      <!-- <label for="">Filtrar Por: </label>-->
      <select onchange="listarProductos();" id="tipo_pro" name="tipo_pro" class="form-control col-md-3" >
          <option value="201" selected>PRODUCTO</option>
          <option value="200">SERVICIO</option>
      </select>

      <input type="hidden" name="c_empresa"  id="c_empresa" value="3037">
        <input type="hidden" name="d_empresa" value="DISTRIBUIDORA EL CEIBON">
        <hr/>

        <!--<div class="col-md-12 responsive">
          EMBUTIDOS <a class="btn btn-primary col-md-1" >
            <i class="fas fa-minus" style="color: white"></i>
          </a>
           <input type="number" name="" value="0" class="col-md-2">
           <a class="btn btn-primary col-md-1" >
             <i class="fas fa-plus" style="color: white"></i>
           </a>
      <div id="productos" class="col s12 row">-->

      <div id="productos" class="row col-sm-12">

      </div>
      <br/>
      <hr/>
      <table id="tabla-empresas" class="table-responsive" style="width:100%;">
            <thead>
             <tr>
              </tr>
          </thead>
          	<tbody >
              <tr>
                <th scope="col">SubTotal</th>
                <th scope="col"><input readonly type="number" name="subtotal" id="subtotal" value="0" class="col-md-5"></th>
              </tr>
                <tr>
                  <th scope="col">Envio</th>
                  <th scope="col"><input readonly type="number" name="envio" id="envio" value="32.0" class="col-md-5"></th>
                </tr>
                <tr>
                  <th scope="col">Total</th>
                  <th scope="col"><input readonly type="number" name="total" id="total" value="0" class="col-md-5"></th>
                </tr>
            </tbody>
          </table>

      <hr/>
        <label for="">Ciudad</label>
      <select id="ciudad" class="form-control col-md-2" >
          <option value="0101" selected>La Ceiba</option>
          <!--<option value="0501">SPS</option>-->
      </select>
            <br/>

            <input type="text" name="direccion" value="" placeholder="Direccion" required/>
            <input type="text" name="referencia" value="" placeholder="Lugar Referencia" required/>
            <hr/>

            <input type="text" name="nombre" value="<?php

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
{
 echo $_SESSION['d_usuario'];

}
 ?>" placeholder="Nombre" required/>
            <input type="text" name="apellido" value="" placeholder="Apellido" required/>
            <input type="number" maxlength="8" min="00000000" minlength="8" name="telefono" value="" placeholder="Numero de Celular" required/>

            <!--<input type="text" name="direccion" value="BARRIO INGLES" placeholder="Direccion" required>
            <input type="text" name="referencia" value="CALLE DEL CEMENTERIO" placeholder="Lugar Referencia" required>
            <hr/>

            <input type="text" name="nombre" value="FAVIO JAVIER" placeholder="Nombre" required>
            <input type="text" name="apellido" value="ERAZO PINEDA" placeholder="Apellido" required>
            <input type="number" maxlength="8" name="telefono" value="95326210" placeholder="Numero de Celular" required>-->
      <input type="text" name="correo" value="" placeholder="Correo Electronico"/>
            <br/>
      <textarea name="comentario" value="" placeholder="Comentario" rows="3" cols="22"></textarea>
      <input type="hidden" name="ubicacion" id="ubicacion" value="0,0"/>
      <p>* Confirmaremos el pedido mediante Whatsapp o llamada Telefonica, asegurate de colocar un numero que posea una cuenta de Whatsapp Activa o red movil disponible.</p>

      <p>* El valor de envio puede variar dependiendo de tu ubicacion, horario y cantidad de productos, se te informara al momento de confirmar el pedido si existe algun cambio de tarifa.</p>
      <p>* Al Momento de Realizar tu pedido, capturamos tu ubicacion para tener una referencia mas precisa de tu ubicacion.</p>
      </div>

      <br/>
      <input class="btn btn-primary" type="submit" value="Procesar">

      </center>
    </form>

                <br/>
                            <br/>


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



      <!-- Modal -->
      <div class="modal fade" id="detalleProdModal" 
      tabindex="-1" role="dialog" 
      aria-labelledby="detalleProdModal" 
      aria-hidden="true" >
       <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <center>
              <h5 class="modal-title" id="exampleModalLabel">
                DETALLE DE PRODUCTO
              </h5>
             </center>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
             <div hidden id="nombre" class="carousel slide" data-ride="carousel">
             </div>
             <div hidden class="carousel slide" data-ride="carousel">
               <center><img id="img"
               data-dismiss="modal"
               src=""
               alt="Sin Imagen" style="width:100%"
               width="200"
              height="200"/>
            </center>
             </div>
             <div hidden id="desc" class="carousel slide" data-ride="carousel">
             </div>
             <div hidden id="c_prod" class="carousel slide" data-ride="carousel">
             </div>
             <div hidden id="disponible" class="carousel slide" data-ride="carousel">
             </div>
           </br>
             <div id="complementos" class="carousel slide" data-ride="carousel">
             </div>
           </div>
           <div class="modal-footer text-center">
            <center> <button type="button" class="btn btn-success" data-dismiss="modal" id="btnAceptar">OK</button>
            </center>
           </div>
         </div>
       </div>
      </div>

      <script src="../vendor/jquery/jquery.min.js">
      </script>

        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
        <script src="../vendor/jquery/jquery.min.js">
        </script>

       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


      <script type="text/javascript">
        $( "#frmPedido" ).submit(function( event ) {


          var datosForm=new FormData(document.getElementById("frmPedido"));//$("#frmHor").serializeArray() ;
    //alert( "datos: "+datos);
    //console.log(datosForm);
    datosForm.append("funcion","fcnSTOrd");
    //datosForm.append("empresa",$("#formModificar").serializeArray());
    datosForm.append("lstPro",JSON.stringify(lstPro) );
    datosForm.append("d_empresa","<?php echo $_POST['d_empresa']; ?>");
    //datosForm.append("ubicacion",JSON.stringify(lstPro) );

    console.log($('#total').val());
    if($('#total').val()>0)
    {
      $.ajax({
        url: "../core/funciones.sql.php",
        type: "POST",
        data: datosForm,
        contentType: false,
        processData: false,
        success: function(mensaje)
        {
          //console.log(mensaje);
          if(mensaje=='OK'){
            listarProductos();
            $('#msj').html('PEDIDO REALIZADO CORRECTAMENTE, PRONTO NOS COMUNICAREMOS CONTIGO.');

            $('#mensajeModal').modal('show');
          //alert('PEDIDO REALIZADO CORRECTAMENTE, PRONTO NOS COMUNICAREMOS CONTIGO');

          var tmp=$("#tipo_pro").val();
          document.getElementById("frmPedido").reset();
          $("#tipo_pro").val(tmp);

        }else {
          console.log("Respuesta > ( "+mensaje+" )");

          $('#msj').html('ERROR: '+mensaje);

          $('#mensajeModal').modal('show');
            $('#tmp').html(mensaje);
          }
        }
    });
  }else {
    $('#msj').html('ERROR: DEBE SELECCIONAR AL MENOS UN PRODUCTO');

    $('#mensajeModal').modal('show');
      //$('#tmp').html(mensaje);
    //alert("DEBE SELECCIONAR AL MENOS UN PRODUCTO");
  }
          event.preventDefault();
        });

        //function detalleProducto($c_correlativo,$c_prod,$d_prod,$img,$desc_prod,$v_precio)
        function detalleProducto($c_prod)
        {
          $('#complementos').html("");

          $(".loader").fadeIn("fast");
          /*  $('#nombre').html('<center><h2><STRONG>'+$d_prod+' - '+$v_precio+'</STRONG></h2></center>');
          //$('#img').html($img);
          $('#desc').html($desc_prod);
          $('#c_prod').html($c_prod);
          //$('#disponible').html($disp);

          $("#img").attr("src",$img);*/

          var datosForm=new FormData();//$("#frmHor").serializeArray() ;
          //alert( "datos: "+datos);
          //console.log(datosForm);
          datosForm.append("funcion","fcnLstCompPro");
          //datosForm.append("empresa",$("#formModificar").serializeArray());
          datosForm.append("c_producto",$c_prod );
          datosForm.append("c_empresa","<?php echo $_POST['c_empresa']; ?>");
          //datosForm.append("ubicacion",JSON.stringify(lstPro) );

            $.ajax({
              url: "../core/funciones.sql.php",
              type: "POST",
              data: datosForm,
              contentType: false,
              processData: false,
              success: function(mensaje)
              {
                //console.log(mensaje);
                $('#complementos').html(mensaje);
                $(".loader").fadeOut("fast");
                for (var i = 0; i < lstPro.length; i++) {
                  if(lstPro[i]["c_producto"]==$c_prod)
                  {
                    $('#detalleProdModal').modal('show');

                    //if($('#detalleProdModal').is(':visible'))
                    $("#modal_pro_"+$c_prod).val(lstPro[i]["cantidad"]);
                  }
                }

              }
          });



        }
        function stComPro($c_complemento,$c_registro)
        {

          var activo=0;
          if($('#'+$c_registro).prop('checked'))
          {
              activo=1;
          }else {
            activo=-1;
          }
          if(activo==-1)
          {
            activo=parseInt($("#"+$c_complemento).val())+parseInt(activo);

            $("#"+$c_complemento).val(activo);
          }else {
            if(parseInt($("#"+$c_complemento).val())<parseInt($("#max_"+$c_complemento).val()))
            {
              activo=parseInt($("#"+$c_complemento).val())+parseInt(activo);

              $("#"+$c_complemento).val(activo);
            }else
            $("#"+$c_registro).prop('checked', false);
            //$('#'+$c_registro).attr("checked",false);
          }

          console.log(activo);


          console.log(parseInt($("#"+$c_complemento).val()));

        }

        
          /*function carrito(c_producto, cant, c_empresa, accion) {
          alert(c_producto+"-"+cant+"-"+c_empresa+"-"+accion);
          try {
            $.ajax({
              url: "../core/funciones.sql.php",
              type: 'POST',
              dataType: 'JSON',
              data: {
                funcion: 'fcnCarrito',
                c_producto: c_producto,
                cant: cant,
                c_empresa: c_empresa,
                accion: accion
              }, //agregado
              //timeout: 5000,
            }).done(function (json) {
              if(json == 1){
                  alert(json);
                }else{
                  alert("Error");
                }
            }).fail(function (jqXHR, estado, error) {
              console.log(jqXHR);
            }).always(function () {
              $("#dvLoading").css({
                visibility: "hidden",
                opacity: "0"
              });
            })
          } catch (err) {
            //alert('Ha ocurrido un problema!');
            console.log(err.message);
          }
        }*/

        function carrito(c_producto, cant, c_empresa, accion) {
          //$('#complementos').html("");

          $(".loader").fadeIn("fast");
          
          var datosForm=new FormData();
          datosForm.append("funcion","fcnCarrito");
          datosForm.append("c_producto",c_producto);
          datosForm.append("cant",cant);
          datosForm.append("c_empresa",c_empresa);
          datosForm.append("accion",accion);

            $.ajax({
              url: "../core/funciones.sql.php",
              type: "POST",
              data: datosForm,
              contentType: false,
              processData: false,
              success: function(mensaje){
                //console.log(mensaje);
                //$('#complementos').html(mensaje);
                alert(mensaje);
                $(".loader").fadeOut("fast");
                
              }
          });
        }
        
      </script>
  </body>
</html>
