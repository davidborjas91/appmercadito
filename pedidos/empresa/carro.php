<?php
session_start();
require('../core/conexion.php');
$db->conectar();
// require 'requirelanguage.php';

// $id_cliente2 = clear($_SESSION['id_cliente']);
// check_user('carrito');

// if(isset($eliminar)){
// 	$eliminar = clear($eliminar);
// 	$mysqli->query("DELETE FROM carro WHERE id = '$eliminar'");
// 	redir("?p=carrito");
// }

// if(isset($id) && isset($modificar)){

// 	$id = clear($id);
// 	$modificar = clear($modificar);

// 	$mysqli->query("UPDATE carro SET cant = '$modificar' WHERE id = '$id'");
// 	alert("Cantidad modificada",1,'carrito');
// 	//redir("?p=carrito");
// }

// if(isset($finalizar)){

// 	$monto = clear($monto_total);

// 	$id_cliente = clear($_SESSION['id_cliente']);
// 	$q = $mysqli->query("INSERT INTO compra (id_cliente,fecha,monto,estado) VALUES ('$id_cliente',(convert_tz(now(),@@session.time_zone,'-06:00')),'$monto',0)");

// 	$sc = $mysqli->query("SELECT * FROM compra WHERE id_cliente = '$id_cliente' ORDER BY id DESC LIMIT 1");
// 	$rc = mysqli_fetch_array($sc);

// 	$ultima_compra = $rc['id'];


// 	$q2 = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente'");
// 	while($r2=mysqli_fetch_array($q2)){

// 		$sp = $mysqli->query("SELECT * FROM productos WHERE id = '".$r2['id_producto']."'");
// 		$rp = mysqli_fetch_array($sp);

// 		if($rp['oferta']>0){
// 			if(strlen($rp['oferta'])==1){
// 				$desc = "0.0".$rp['oferta'];
// 			}else{
// 				$desc = "0.".$rp['oferta'];
// 			}

// 			$preciototal = $rp['price'] -($rp['price'] * $desc);
// 		}else{
// 			$preciototal = $rp['price'];
// 		}
// 		$monto = $preciototal;
// 		//$monto = $rp['price'];

// 		$mysqli->query("INSERT INTO productos_compra (id_compra,id_producto,cantidad,monto) VALUES ('$ultima_compra','".$r2['id_producto']."','".$r2['cant']."','$monto')");

// 	}

// 	$mysqli->query("DELETE FROM carro WHERE id_cliente = '$id_cliente'");

// 	$sc = $mysqli->query("SELECT * FROM compra WHERE id_cliente = '$id_cliente' ORDER BY id DESC LIMIT 1");
// 	$rc = mysqli_fetch_array($sc);

// 	$id_compra = $rc['id'];

// 	alert("Se ha finalizado la compra",1,'ver_compra&id='.$id_compra);
// 	//redir("?p=ver_compra&id=".$id_compra);

// }
?>	
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


  
  <!-- Custom styles for this template -->
  <link href="form-validation.css" rel="stylesheet">
</head>

<body class="bg-white">
<div class="container">
    <main>

	<div class="text-center">
		<h3><i class="fa fa-shopping-cart"></i>Carrito de Compras</h3>

		<h4 class="text-center">
			<input type="hidden" id="idDireccion"/>
			<input type="hidden" id="montoEnvio"/>
			<span class="fa fa-truck"></span> <span id="ubicacion" data-bs-toggle="modal" data-bs-target="#ModalMap" data-bs-whatever="@mdo"> Seleccione la Dirección de Entrega <span class="fa fa-plus"></span></span>
		</h4>

		<style>
			.pac-container{
				z-index: 99999;
			}
		</style>		
		<div class="modal" id="ModalMap" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-center">
						<h4 class="modal-title w-100 text-center" id="exampleModalLabel">Direccion de entrega</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

	                </div>
					<div class="col-lg-12">
						<!--<div class="row">
							<div class="col-sm-12 text-center">	-->
								<div class="">
									<div id="" >
										<table id="table" class="table">
											<thead class="cf">
												<tr>													
													<th style="display: none;"><?php echo $c_tablaDescp; ?></th>
													<th style="display: none;"><?php echo $c_tablaDirec; ?></th>
													<th style="display: none;">id</th>
													<th>Direccion</th>
													<th>Accion</th>
												</tr>
											</thead>
											<tbody>
										<?php
                                        
                                        $c_cliente = $_SESSION["c_cliente"];
										//$id_cliente = clear($_SESSION['id_cliente']);
										$q = $db->conexion->query("SELECT * FROM cli_usuarios_direccion WHERE c_cliente = '$c_cliente' and b_registro_activo=1");
										while($r = mysqli_fetch_array($q)){
											$id = $r['id_direccion'];
											$direccion = $r['direccion'];
											$descripcion = $r['descripcion'];
											?>
												<tr>													
													<td data-title="<?php echo $c_tablaDescp; ?>" style="display: none;"><?=$descripcion?></td>
													<td data-title="<?php echo $c_tablaDirec; ?>" style="display: none;"><?=$direccion?></td>
													<td data-title="id" style="display: none;"><?=$id?></td>
													<td data-title="<?php echo $c_tablaDirec; ?>">
														<a class="boton" data-bs-dismiss="modal"><?=$descripcion?><?=$direccion?></a>
													</td>
													<?php if ($r['principal'] == 1){ ?>
													<td data-title="*">
														<a class="boton" data-bs-dismiss="modal"><i class="fa fa-check"></i></a>
													</td>
													<?php } ?>
														
												</tr>
											<?php
										}
										?>
										</tbody>
										</table>
									</div>
								</div>
							<!--</div>
						</div>-->
					</div>
					<div class="modal-footer justify-content-center">
						<a class="btn btn-primary" href="usuario.php" role="button"><i class="fa fa-share"></i> Agregar Direccion</a>
					</div>
				</div>
			</div>
		</div>
		</div>
	<br>
	<div id="no-more-tables" class="table-responsive-sm">
		<table class="table table-striped cf">
			<thead class="cf">
				<tr>
					<th><i class="fa fa-image"></i></th>
					<th>DETALLE</th>
					<th>CANT.</th>
					<!-- <th>PRECIO</th> -->
					<!-- <th><?php echo $c_tablaOfer; ?></th> -->
					<th>PRECIO</th>
					<th>*</th>
				</tr>
			</thead>
			<tbody>
		<?php
		// $id_cliente = clear($_SESSION['id_cliente']);
        $c_cliente = $_SESSION["c_cliente"];
		$q = $db->conexion->query("SELECT * FROM cli_carro WHERE c_cliente = '$c_cliente'");
		$monto_total = 0;
		// if(mysqli_num_rows($q)<1){alert("$c_confMsj",2,"tiendas");}
		while($r = mysqli_fetch_array($q)){
			$q2 = $db->conexion->query("SELECT * FROM pro_producto WHERE c_producto = '".$r['c_producto']."'");
			$r2 = mysqli_fetch_array($q2);

			$preciototal = 0;
					// if($r2['oferta']>0){
					// 	if(strlen($r2['oferta'])==1){
					// 		$desc = "0.0".$r2['oferta'];
					// 	}else{
					// 		$desc = "0.".$r2['oferta'];
					// 	}

					// 	$preciototal = $r2['price'] -($r2['price'] * $desc);
					// }else{
					// 	$preciototal = $r2['price'];
					// }
                    $preciototal = $r2['v_precio_inicial'];

			$nombre_producto = $r2['d_producto'];

			$cantidad = $r['cant'];

			$precio_unidad = $r2['v_precio_inicial'];
			$precio_total = $cantidad * $preciototal;
			$imagen_producto = $r2['d_imagen_producto'];

			$monto_total = $monto_total + $precio_total;

			?>
				<tr>
					<td data-title="IMG"><img src="https://bfdtechnologies.info/imagenes/productos/<?=$imagen_producto?>" class="rounded-circle" style="height: 80px;width: 80px;"/></td>
					<td data-title="DESCRIPCION"><?=$nombre_producto?></td>
					<td data-title="CANT."><?=$cantidad?></td>
					<!-- <td data-title="PRECIO"><?=number_format($precio_unidad,2)?> <?=$divisa?></td> -->
					<!-- <td data-title="<?php echo $c_tablaOfer; ?>">
						<?php
							// if($r2['oferta']>0){
							// 	echo $r2['oferta']."% ".$c_desc;
							// }else{
							// 	echo $c_sinDesc;
							// }
						?>
					</td> -->
					<td data-title="<?php echo $c_tablaPrecio; ?>"><?=number_format($preciototal,2)?> <?=$divisa?></td>
					<td data-title="<?php echo $c_tablaAct; ?>">
						<!-- <button onclick="modificar('<?=$nombre_producto?>','<?=$r['id']?>')" class="btn btn-success" type="button"><i class="fa fa-edit" title="Modificar cantidad en carrito"></i></button> -->
						<!--<a href="?p=carrito&eliminar=<?=$r['id']?>"><i class="fa fa-times" title="Eliminar"></i></a>-->
						
						<button class="btn btn-danger" type="button" onclick="eliminar('<?=$nombre_producto?>','<?=$r['id']?>')" value='<?=$r['id']?>' id="a"><i class="fa fa-times" title="Eliminar"></i></button>
					</td>
				</tr>
			<?php
		}
		?>
		</tbody>
		</table>
	</div>
	
	<br>
	<div class="col-lg-12">
		
	
	<!--<h5><?php echo $c_totalCompra; ?> <b class="text-green"><?=number_format($monto_total,2)?> <?=$divisa?></b></h5>-->
	<div class="row">
		<input type="hidden" id="subTotal" value="<?=$monto_total?>" />
    	<div class="col-6 col-sm-4"><h5>Sub-Total</h5></div>
    	<div class="col-6 col-sm-4 offset-md-4 text-right"><h5><b class="text-green"><?=number_format($monto_total,2)?> <?=$divisa?></b></h5></div>
  	</div>
  	<div class="row">
    	<div class="col-6 col-sm-4"><h5>Costo de Envío</h5></div>
    	<div class="col-6 col-sm-4 offset-md-4 text-right"><h5><b class="text-green"><div id="idMonto"><?=$divisa?></div></b></h5></div>
  	</div>

  	<div class="row">
    	<div class="col-6 col-sm-4"><h5>Monto Total</h5></div>
    	<div class="col-6 col-sm-4 offset-md-4 text-right"><h5><b class="text-green"><div id="total"><?=$divisa?></div></b></h5></div>
  	</div>
	<br>
	<form method="post" action="" style="display: none;">
		<input type="hidden" name="monto_total" value="<?=$monto_total?>"/>
		<button class="btn btn-primary" type="submit" name="finalizar"><i class="fa fa-check"></i> Finalizar Compra</button>
	</form>
	<input type="hidden" id="monto_total" name="monto_total2" value="<?=$monto_total?>"/>

	<div class="col-lg-12 text-center">
		<button class="btn btn-primary" type="button" id="btnAceptar"><i class="fa fa-check"></i> Finalizar</button>

		</div>
	</div>


	<div id="modal_confirma" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xs modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Confirmar</h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-sm-12">
						<div class="row">
					    	<div class="col-2 col-sm-4 text-left"><h6><strong>Tienda </strong></h6></div>
					    	<div class="col-10 col-sm-4 text-left"><p id="nombre_tienda"></p></div>
					  	</div>

						<div class="row">
					    	<div class="col-2 col-sm-4 text-left"><h6><strong>Lugar de Entrega </strong></h6></div>
					    	<div class="col-10 col-sm-4 text-left"><p id="ubicacion2"></p></div>
					  	</div>

					  	<div class="row">
					    	<div class="col-6 col-sm-6 text-left"><h6><strong>SubTotal </strong></h6></div>
					    	<div class="col-6 col-sm-6 text-right"><p><?=number_format($monto_total,2)?> <?=$divisa?></p></div>
					  	</div>

					  	<div class="row">
					    	<div class="col-6 col-sm-6 text-left"><h6><strong>Tarifa </strong></h6></div>
					    	<div class="col-6 col-sm-6 text-right"><p id="montoEnvio1"></div></p>
					  	</div>

						<div class="row">
					    	<div class="col-6 col-sm-6 text-left"><h6><strong>Total </strong></h6></div>
					    	<div class="col-6 col-sm-6 text-right"><div id="total1"></div></div>
					  	</div>

					  	
					</div>
					<!--col-sm-5-->
				</div>
				<div class="modal-footer">
					<button id="bt1_tab" type="button" class="btn btn-success">Aceptar</button>
					<button id="bt2_tab" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<div id="modal_error" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xs modal-dialog-centered">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Confirmar</h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</div>
					<div class="modal-body">
						<div class="form-group">
							<h5><?php echo $c_confMsj; ?></h5>
						</div>
					</div>
				<div class="modal-footer">
					<!--<button id="bt1_tab_p" type="button" class="btn btn-primary" data-dismiss="modal">Volver</button>-->
					<a class="btn btn-primary" href="?p=tiendas" role="button"><?php echo $c_conf; ?></a>
				</div>
			</div>
		</div>
	</div>

	<div id="modal_direc" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xs modal-dialog-centered">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?php echo $c_direcAddUser; ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</div>
					<div class="modal-body">
						<div class="form-group">
							<h5><?php echo $c_direccion; ?></h5>
						</div>
					</div>
				<!--<div class="modal-footer">
					<a class="btn btn-primary" href="?p=tiendas" role="button">Agregar</a>
				</div>-->
			</div>
		</div>
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

<script type="text/javascript">
	$(document).ready(function() {
		var url_reporte = "modulos/guardar/guardar_orden.php";

		function setCuentas() {
	        $("#dvLoading").css({ visibility: "visible", opacity: "0.5" });
	        var monto_total = $('#monto_total').val(); //agregado
	        var idDireccion = $('#idDireccion').val(); //agregado
	        var montoEnvio = $('#montoEnvio').val(); //agregado
	        
	        try {
	            $.ajax({
	                url: url_reporte,
	                type: 'POST',
	                dataType: 'JSON',
	                //data: null,
	                data: {
	                    monto_total: monto_total,
	                    idDireccion: idDireccion,
	                    montoEnvio: montoEnvio
	                }, //agregado
	                //timeout: 5000,
	            }).done(function(json) {
	            	 if (json.completo != null) {
	            	 	window.location="?p=ver_compra&id="+json.completo;
	            	 }
	            }).fail(function(jqXHR, estado, error) {
	                console.log(jqXHR);
	                alert("2");
	            }).always(function() {
	                $("#dvLoading").css({ visibility: "hidden", opacity: "0" });
	            })
	        } catch (err) {
	            alert('Ha ocurrido un problema!');
	            console.log(err.message);
	        }
	    }

	    $("#btnAceptar").click(function() {
	    	var monto_total = $('#monto_total').val();
	    	var idDireccion = $('#idDireccion').val();

    		if (monto_total <= 0) {
	            $('#modal_error').modal('show');
	        } else {
	        	if (idDireccion == "") {
		    		$('#ModalMap').modal('show');
		    	}else {
	            	$('#modal_confirma').modal('show');
	            }
	        }
	    	
	    	
	        //setCuentas() ;
	    });

	    $("#bt1_tab").click(function() {
	        setCuentas() ;
	    });

		$('#btnClick').click(function(){
			alert($(this));
		});

		$('.boton').click(function(){
		   var valores="";
		   var var1="";
	        $(this).parents("tr").find("td:first,td:eq(1)").each(function(){
	            valores+=$(this).html()+" ";
	        });

	        $(this).parents("tr").find("td:eq(2)").each(function(){
	            var1+=$(this).html()+" ";
	        });

	        //alert(valores);  
	        $('#ubicacion').html(valores);
	        $('#ubicacion2').html(valores);

	        $('#idDireccion').val(var1);

	        getTarifa();
		});

		function modif(var1,var2){
			alert(var1+" "+var2);
		}

		function getTarifa() {
			$("#dvLoading").css({ visibility: "visible", opacity: "0.5" });
			var idDireccion = $('#idDireccion').val();
			var tipo = 'p';
	        try {
	            $.ajax({
	                url: "modulos/guardar/fn_carrito_tarifa.php",
	                type: 'POST',
	                dataType: 'JSON',
	                data: {
	                	idDireccion: idDireccion,
						tipo: tipo
	                },
	                timeout: 1000,
	            }).done(function(json) {
	                console.log("getinfo" + json);
	                if (json.draw != null) {
	                	if (parseFloat(json.draw[0].distancia) >= parseFloat(json.draw[0].distMax)) {
	                		//alert("Supera la dist. MAX");
	                		swal({ title: "", text: "<?php echo $c_Dista?> "+json.draw[0].distMax+" KM", type: "warning",confirmButtonClass: "btn-primary",confirmButtonText: "<?php echo $btn_aceptar?>",closeOnConfirm: true});

	                		$('#ubicacion').val("");
	                		//$("#btnAceptar").css({ display: "none" });
	                		//$("#btnAceptar").attr("disabled");
	                		document.getElementById('btnAceptar').disabled=true;
	                	}else {
	                		//$('#id').text(json.draw[0].distancia);
		                	//$('#id').text(json.draw[0].monto);
		                	//alert(json.draw[0].distancia+"/"+json.draw[0].monto);
		                	$('#idMonto').html(json.draw[0].montoT);
		                	$('#montoEnvio').val(json.draw[0].monto);
		                	$('#montoEnvio1').html(json.draw[0].monto+" Lps");
		                	
		                	$('#nombre_tienda').html(json.draw[0].nombre_tienda);

		                	var n1 = parseFloat(json.draw[0].monto) + parseFloat($('#subTotal').val());
		                	var n = humanizeNumber(financial(n1));
		                	//alert(financial(n1) + "/" + n1 + "/" + n);

		                	$('#total').html(n+" Lps");
		                	$('#total1').html(n+" Lps");
		                	//$("#btnAceptar").css({ display: "block" });
		                	document.getElementById('btnAceptar').disabled=false;
	                	}
	                } 
	            }).fail(function(jqXHR, estado, error) {
	                console.log(jqXHR);
	            }).always(function() {
	                console.log("completo");
	                $("#dvLoading").css({ visibility: "hidden", opacity: "0" });
	            })
	        } catch (err) {
	            alert('Ha ocurrido un problema!');
	            console.log(err.message);
	        }
	    }

	    function format(n, sep, decimals) {
	       	sep = sep || "."; // Default to period as decimal separator
	       	decimals = decimals || 2; // Default to 2 decimals

	       	return n.toLocaleString().split(sep)[0]
	        + sep
	        + n.toFixed(decimals).split(sep)[1];
		}

		function financial(x) {
		  	return Number.parseFloat(x).toFixed(2);
		}

		function humanizeNumber(n) {
		    n = n.toString()
		    while (true) {
		    	var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3')
		       	if (n == n2) break
		       	n = n2
		    }
		    return n
		}
		
	});
	function modificar(produc,idc){
		/*swal({ title: "Cambiar cantidad de producto "+produc, text: "¿Cual es la nueva cantidad?",content: "input",button: "Cambiar"});
		$(".swal-button").click(function(){ alert($(".swal-input").val()); });*/
		//window.location="?p=carrito&id="+idc+"&modificar="+new_cant; 
			//alert("Modificar..."+idc);
			/*var new_cant = prompt("¿Cual es la nueva cantidad?");

			if(new_cant>0){
				window.location="?p=carrito&id="+idc+"&modificar="+new_cant;
			}*/

			swal({
			  title: "<?php echo $c_cantidadM?> "+produc,
			  text: "<?php echo $c_Cpregunta?>",
			  type: "input",
			  showCancelButton: true,
			  closeOnConfirm: false,
			  inputPlaceholder: "<?php echo $c_Cconfir?>"
			}, function (inputValue) {
			  if (inputValue === false) return false;
			  if (inputValue === "") {
			    swal.showInputError("<?php echo $c_Cerror?>");
			    return false
			  }
			  if(inputValue>0){
					window.location="?p=carrito&id="+idc+"&modificar="+inputValue;
				}else{
					swal("Error!", "<?php echo $c_plash?> " + inputValue, "error");		
				}
			  
			});
		}

		function eliminar(produc,idc){
			swal({
				title: "<?php echo $c_delProd?> "+produc,
				text: "<?php echo $c_confDelProd?>",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-primary",
				confirmButtonText: "<?php echo $btn_aceptar?>",
				cancelButtonText: "<?php echo $btn_cancel?>",
				closeOnConfirm: true,
				closeOnCancel: true
				},
				function(){
					window.location="?p=carrito&eliminar="+idc;
				});	
		//swal({ title: "Elimiar producto "+produc, text: "¿Esta seguro que desea eliminar este producto?",button: "Aceptar"});
		//$(".swal-button").click(function(){window.location="?p=carrito&eliminar="+idc;});
		//window.location="?p=carrito&id="+idc+"&modificar="+new_cant; 
			//alert("Modificar..."+idc);
			/*var new_cant = prompt("¿Cual es la nueva cantidad?");

			if(new_cant>0){
				window.location="?p=carrito&id="+idc+"&modificar="+new_cant;
			}*/
		}
</script>

</body>

</html>


