// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'
  $('#tel').mask('0000-0000', {
    clearIfNotMatch: true
  });

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }

        if (firstName != "" && lastName != "" && form.checkValidity() != false) {

          var firstName = $('#firstName').val();
          var lastName = $('#lastName').val();
          var tel = $('#tel').val();
          var valor = '1';

          /*var formData = new FormData();
          var files = $('#image1')[0].files[0];
          formData.append('file',files);*/

          try {
            $.ajax({
              url: "guardar/fn_usuario.php",
              type: 'POST',
              dataType: 'JSON',
              data: {
                firstName: firstName,
                lastName: lastName,
                tel: tel,
                valor: valor
              }, //agregado
              //timeout: 5000,
            }).done(function (json) {
              if (json.draw != null) {
                alert(json.draw);
                /*if (json.draw == '0') {
                  alert("Completo");
                }*/

              }
            }).fail(function (jqXHR, estado, error) {
              console.log(jqXHR);

            }).always(function () {

            })
          } catch (err) {
            console.log(err.message);
          }

          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add('was-validated')
      }, false)
    })

  getDatos();

  function getDatos() {
    try {
      $.ajax({
        url: "guardar/fn_usuario_info.php",
        type: 'POST',
        dataType: 'JSON',
        data: {},
        //timeout: 10000,
      }).done(function (json) {
        console.log("getinfo" + json);
        //alert(json.data[0].nombre);
        $('#firstName').val(json.data[0].nombre);
        $('#lastName').val(json.data[0].apellido);
        $('#tel').val(json.data[0].telefono);
        $('#correo').val(json.data[0].c_usuario);
        $("#imgUser").attr("src",json.data[0].img);

        /*if (json.draw[0].nombre == 0) {
          document.getElementById("repartidor").style.display = "none";
        } else {
          document.getElementById("repartidor").style.display = "block";
        }
        $('#Tc').text(json.draw[0].total);*/
        //setTimeout('getInfoCarro()',2000);
      }).fail(function (jqXHR, estado, error) {
        console.log(jqXHR);
      }).always(function () {
        console.log("completo");
      })
    } catch (err) {
      //alert('');
      console.log(err.message);
    }
  }

  $("#fupForm").on('submit', function(e){
    
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: "guardar/fn_usuario.php",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            $('.submitBtn').attr("disabled","disabled");
            $('#fupForm').css("opacity",".5");
        },
        success: function(msg){
            $('.statusMsg').html('');
            if(msg == 'ok'){
                $('#fupForm')[0].reset();
                $('.statusMsg').html('<span style="font-size:18px;color:#34A853">Form data submitted successfully.</span>');
            }else{
                $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Some problem occurred, please try again.</span>');
            }
            $('#fupForm').css("opacity","");
            $(".submitBtn").removeAttr("disabled");
        }
    });
});
})()
$(document).ready(function () {
//file type validation
$("#file").change(function() {
    var file = this.files[0];
    var imagefile = file.type;
    var match= ["image/jpeg","image/png","image/jpg"];
    if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
        alert('Please select a valid image file (JPEG/JPG/PNG).');
        $("#file").val('');
        return false;
    }
});
  
  function setCuentas() {
    /*$("#dvLoading").css({
      visibility: "visible",
      opacity: "0.5"
    });*/
    var latitud = $('#ModalMap-lat').val(); //agregado 
    var longitud = $('#ModalMap-lon').val(); //agregado 
    var address = $('#direc').val(); //agregado
    var descrip = $('#ModalMapDescrip').val(); //agregado
    var valor = '2';

    try {
      $.ajax({
        url: "guardar/fn_usuario.php",
        type: 'POST',
        dataType: 'JSON',
        data: {
          latitud: latitud,
          longitud: longitud,
          address: address,
          descrip: descrip,
          valor: valor
        }, //agregado
        //timeout: 5000,
      }).done(function (json) {
        if (json.draw != null) {
          //window.location = "?p=usuario";
          //alert("Proceso completo");
          getTable();
        }
      }).fail(function (jqXHR, estado, error) {
        console.log(jqXHR);
      }).always(function () {
        /*$("#dvLoading").css({
          visibility: "hidden",
          opacity: "0"
        });*/
      })
    } catch (err) {
      //alert('Ha ocurrido un problema!');
      console.log(err.message);
    }
  }

  $("#btnAceptar").click(function () {
    if ($('#ModalMapDescrip').val() != "") {
      setCuentas();
      $("#ModalMap").modal('hide');
      //window.location="?p=usuario";
    } else {
      /*swal({
      	title: "<?php echo $u_msjDescrip; ?>",
      	text: "<?php echo $u_msjDescrip2; ?>",
      	type: "warning",
      	confirmButtonClass: "btn-primary",
      	confirmButtonText: "<?php echo $btn_aceptar; ?>",
      	closeOnConfirm: true
      	},
      	function(){
      		
      	});*/
      alert("Falta Datos");
      $('#ModalMapDescrip').focus();
      //swal({ title: "Falta Descripcion",text: "Debe agregar una descripcion de la ubicacion",button: "Aceptar"});
      //$(".swal-button").click(function(){$('#ModalMapDescrip').focus();});
    }
  });

  function modificar(idc) {
    var new_cant = prompt("<?php echo $u_msjCantidad; ?>");

    if (new_cant > 0) {
      window.location = "?p=carrito&id=" + idc + "&modificar=" + new_cant;
    }
  }

  function updateControls(addressComponents) {
    /*$('#us9-street1').val(addressComponents.addressLine1);
    $('#us9-city').val(addressComponents.city);
    $('#us9-state').val(addressComponents.stateOrProvince);
    $('#us9-zip').val(addressComponents.postalCode);
    $('#us9-country').val(addressComponents.country);*/
    $('#direc').val(addressComponents.addressLine1 + ", " + addressComponents.city + ", " + addressComponents.stateOrProvince + ", " + addressComponents.country);
  }
  $('#ModalMapPreview').locationpicker({
    location: {
      latitude: 15.605030083784195,
      longitude: -87.95489379882814
    },
    radius: 300,
    inputBinding: {
      latitudeInput: $('#ModalMap-lat'),
      longitudeInput: $('#ModalMap-lon'),
      locationNameInput: $('#ModalMapaddress')
    },
    enableAutocomplete: true,
    onchanged: function (currentLocation, radius, isMarkerDropped) {
      var addressComponents = $(this).locationpicker('map').location.addressComponents;
      updateControls(addressComponents);
    },
    oninitialized: function (component) {
      var addressComponents = $(component).locationpicker('map').location.addressComponents;
      updateControls(addressComponents);
    }
  });

  $('#ModalMap').on('show.bs.modal', function () {
    $('#ModalMapPreview').locationpicker('autosize');
  });

  $("#btn1").click(function () {
    //alert("Hola Mundo...");
    $("#ModalMap").modal('show');
    $("#pedirvan").trigger("click");
  });

  $("#pedirvan").click(function () {
    var lat = "";
    var lon = "";
    //Si el navegador soporta geolocalizacion
    if (!!navigator.geolocation) {
      //Pedimos los datos de geolocalizacion al navegador
      navigator.geolocation.getCurrentPosition(
        //Si el navegador entrega los datos de geolocalizacion los imprimimos
        function (position) {
          //window.alert("nav permitido");
          lat = position.coords.latitude;
          lon = position.coords.longitude;

          $("#ModalMap-lat").val(lat);
          $("#ModalMap-lon").val(lon);
          //alert(lat+"/"+lon);
          $('#ModalMapPreview').locationpicker({
            location: {
              latitude: lat,
              longitude: lon
            },
            radius: 300
          });

          if (lat == '0.00' || lon == '0.0' || lat == '') {
            //window.alert("nav no permitido");
            swal({
              title: "",
              text: "<?php echo $u_msjGPS; ?>",
              type: "warning",
              confirmButtonClass: "btn-primary",
              confirmButtonText: "<?php echo $btn_aceptar; ?>",
              closeOnConfirm: true
            });
            lat = "15.605030083784195";
            lon = "-87.95489379882814";
          }
        },
        //Si no los entrega manda un alerta de error
        function error() {
          //window.alert("nav no permitido");
          swal({
            title: "",
            text: "<?php echo $u_msjGPS; ?>",
            type: "warning",
            confirmButtonClass: "btn-primary",
            confirmButtonText: "<?php echo $btn_aceptar; ?>",
            closeOnConfirm: true
          });
        }
      );


    }
    $('#ModalMapPreview').locationpicker({
      location: {
        latitude: lat,
        longitude: lon
      },
      radius: 300
    });
  });

  $('#file-input').change(function (e) {
    addImage(e);
  });

  function addImage(e) {
    var file = e.target.files[0],
      imageType = /image.*/;

    if (!file.type.match(imageType))
      return;

    var reader = new FileReader();
    reader.onload = fileOnload;
    reader.readAsDataURL(file);
  }

  function fileOnload(e) {
    var result = e.target.result;
    $('#imgSalida').attr("src", result);
  }

  //Llenar tabla 
  getTable();

  function getTable() {
    //$("#dvLoading").css({ visibility: "visible", opacity: "0.5" });
    try {
      $.ajax({
        url: "guardar/fn_usuario_info.php",
        type: 'POST',
        dataType: 'JSON',
        data: {},
        //timeout: 1000,
      }).done(function (json) {
        console.log("getinfo" + json);
        if (json.direccion != null) {
          $('#tabla1').bootstrapTable('load', json.direccion);
        }
      }).fail(function (jqXHR, estado, error) {
        console.log(jqXHR);
      }).always(function () {
        console.log("completo");
        //$("#dvLoading").css({ visibility: "hidden", opacity: "0" });
      })
    } catch (err) {
      alert('Ha ocurrido un problema!');
      console.log(err.message);
    }
  }

  /*function priceFormatter(value) {
      return '<img src="tiendas/'+value+'" class="imagen_carro"/>';
  }*/

  $('input[type="file"]').each(function(){

    var $file = $(this),
        $label = $file.next('label'),
        $labelText = $label.find('span'),
        labelDefault = $labelText.text();
  
    $file.on('change', function(event){
      var fileName = $file.val().split( '\\' ).pop(),
          tmppath = URL.createObjectURL(event.target.files[0]);
      if( fileName ){
        $label
          .addClass('file-ok')
          .css('background-image', 'url(' + tmppath + ')');
        $labelText.text(fileName);
      }else{
        $label.removeClass('file-ok');
        $labelText.text(labelDefault);
        $labelText.removeClass('file-ok');
      }
    });
  
  });

});

function verFactura(value) {
  return '<a class="btn btn-link" href="javascript:;" onClick="prueba(' + value + ');"><i class="fas fa-trash-alt"></i></a>';
}

function prueba(value) {
  $(document).ready(function () {
    setDelete(value);
    function setDelete(values) {
      /*$("#dvLoading").css({
        visibility: "visible",
        opacity: "0.5"
      });*/
      var valor = '3';
      //alert('HOLA MUNDOSSS');
      try {
        $.ajax({
          url: "guardar/fn_usuario.php",
          type: 'POST',
          dataType: 'JSON',
          data: {
            values: values,
            valor: valor
          }, //agregado
          //timeout: 5000,
        }).done(function (json) {
          if (json.direccion != null) {
            //window.location = "?p=usuario";
            //alert("Proceso completo");
            $('#tabla1').bootstrapTable('load', json.direccion);
          }
        }).fail(function (jqXHR, estado, error) {
          console.log(jqXHR);
        }).always(function () {
          /*$("#dvLoading").css({
            visibility: "hidden",
            opacity: "0"
          });*/
        })
      } catch (err) {
        //alert('Ha ocurrido un problema!');
        console.log(err.message);
      }
    }
});
}