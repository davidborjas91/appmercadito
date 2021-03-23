<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.80.0">
  <title>Checkout example · Bootstrap v5.0</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/checkout/">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
  <!-- Bootstrap core CSS 
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    img{
      width: 180px;
      height: 180px;
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="form-validation.css" rel="stylesheet">
</head>

<body class="bg-white">

  <div class="modal fade modal-fullscreen" id="ModalMap" tabindex="-1" aria-labelledby="ModalMap">
    <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="ModalMap">Ubicacion</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="col-lg-12" style="z-index: 99999;">

          <div class="input-group mb-3">

            <input type="text" id="ModalMapaddress" class="form-control" placeholder="Ubicacion" aria-label="Ubicacion" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button id="pedirvan" class="btn btn-primary" type="button"><span class="fas fa-map-marker-alt"></span></button>
            </div>
          </div>
        </div>
        <div id="ModalMapPreview" style="width: 100%; height: 100%;position: relative;margin-top: -65px">
        </div>

        <div class="modal-body" style="display: none;">

          <div class="clearfix">&nbsp;</div>

          <div class="m-t-small">
            <label class="p-r-small col-lg-2 control-label">Lat.:</label>
            <div class="col-lg-4">
              <input type="text" class="form-control" id="ModalMap-lat" />
            </div>
            <label class="p-r-small col-lg-2 control-label">Long.:</label>

            <div class="col-lg-4">
              <input type="text" class="form-control" id="ModalMap-lon" />
            </div>
            <div class="col-lg-12">
              <input type="text" class="form-control" id="direc" />
            </div>
          </div>

          <div class="clearfix"></div>

        </div>
        <div class="col-lg-12" style="margin-top: -35px;">
          <div class="input-group mb-3">
            <input type="text" id="ModalMapDescrip" class="form-control" aria-label="Descripcion" aria-describedby="basic-addon2" placeholder="Descripcion">
            <div class="input-group-append">
              <button type="button" class="btn btn-primary btn-block" id="btnAceptar">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <main>
    <p class="statusMsg"></p>
    
      <div class="py-5 text-center">
      <!--<div class="text-center">
        <img src="../img/test.png" class="rounded-circle border border-danger" id="imgUser">
      </div>-->
      <form enctype="multipart/form-data" id="fupForm" >
      <div class="wrap-custom-file">
        <input type="file" name="file" id="file" accept=".gif, .jpg, .png" required/>
        <label  for="file">
          <span><img src="../img/test.png" class="rounded-circle border border-danger" id="imgUser"></span>
        </label>
      </div>
      <div class="text-center">
        <button class="btn btn-danger submitBtn" type="submit"><i class="fas fa-save"></i></button>
      </div>
      </form>
        <!--<img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
        <h2>Checkout form</h2>
        <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>-->
      </div>
      

      <div class="row g-3 justify-content-center">

        <div class="col-md-12 col-lg-10">
          <h4 class="mb-3">Información de usuario</h4>
          <form class="needs-validation" novalidate>
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>

              <div class="col-sm-6">
                <label for="lastName" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>

              <div class="col-sm-12">
                <label for="tel" class="form-label">Telefono <span class="text-muted">*</span></label>
                <input type="text" class="form-control" id="tel" placeholder="8888-8888" required>
                <div class="invalid-feedback">
                  Valid last phone is required.
                </div>
              </div>

              <div class="col-sm-12">
                <label for="correo" class="form-label">Correo <span class="text-muted">*</span></label>
                <input type="text" class="form-control" id="correo" placeholder="test@test.com" disabled>
                <div class="invalid-feedback">
                  Valid last email is required.
                </div>
              </div>
            </div>

            <hr class="my-4">
        </div>

        <div class="text-center">
          <button class="btn btn-primary btn-lg" type="submit">Guardar</button>
        </div>
        </form>
      </div>
  </div>

  <div class="text-center">
    <table id="tabla1" 
      data-click-to-select="false" 
      data-toolbar="#tool1" 
      data-flat="false" 
      data-toggle="table" 
      data-show-columns="false" 
      data-show-multi-sort="false" 
      data-show-export="false" 
      data-search="false" 
      data-mobile-responsive="true" 
      data-check-on-init="true" 
      data-pagination="false" 
      data-advanced-search="false" 
      data-id-table="advancedTable" 
      class="table">
      <thead>
        <tr>
          <!--<th data-field="imagen" data-formatter="priceFormatter">IMG</th>-->
          <th data-field="descripcion">Descripción</th>
          <th data-field="direccion">Dirección</th>
          <th data-field="id_direccion" data-formatter="verFactura">Acción</th>

        </tr>
      </thead>
      <tbody></tbody>
    </table>


    <button type="button" data-toggle="modal" data-target="#ModalMap" class="btn btn-default" id="btn1">
      <span class="fas fa-plus"></span><span id="ubicacion">Ubicacion</span>
    </button>
  </div>

  </main>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2020–2021 appmercadito</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
  </div>

  <!--<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
  <script type="text/javascript" src='https://maps.google.com/maps/api/js?libraries=places&key=AIzaSyBTKX4c5T_Y44qvJFk2Ur9igGABRzHFJnE'></script>

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/export/bootstrap-table-export.min.js"></script>
  <!-- Latest compiled and minified Locales -->
  <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/locale/bootstrap-table-es-MX.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>


  <script type="text/javascript" src="../js/locationpicker.jquery.js"></script>
  <script type="text/javascript" src="../js/locationpicker.jquery.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="form-validation.js"></script>
</body>

</html>