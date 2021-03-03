<?php
if(isset($_POST['funcion']))
$funcion=$_POST['funcion'];
else
exit;


//establecemos la zona horaria predeterminada a la hora local de honduras
	date_default_timezone_set('America/Tegucigalpa');

// Le decimos a PHP que usaremos cadenas UTF-8 hasta el final del script
mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
mb_http_output('UTF-8');

switch ($funcion) {
	case 'fcnLstProEmp':
	fcnLstProEmp($_POST['c_sucursal']);
	break;
	case 'fcnLstProEmpArray':
	fcnLstProEmpArray($_POST['c_empresa']);
	break;
	case 'fcnSTOrd':
	fcnSTOrd();
	break;
	case 'fcnLstEmp':
	fcnLstEmp();
	break;
	case 'fcnLstCompPro':
	fcnLstCompPro();
	break;
	case 'fcnSTCont':
	fcnSTCont();
	break;
	case 'fcnSTCta':
	fcnSTCta();
	break;
	case '':
	break;
	case '':
	break;
}

function fcnLstProEmp($c_empresa)
{
  //echo $c_empresa;
  require('conexion.php');
  $filtro="";

  if(isset($_POST['filtro']))
  $filtro=" and (b.d_producto_alter like '%".$_POST['filtro']."%' ) ";


	//echo $_POST['d_empresa'];
	$respuesta='';
	$sql='SELECT
          b.c_correlativo,
          a.c_producto,
          a.c_producto as c_empresa,
          a.c_marca,
          a.c_tipo,
          b.d_producto_alter as d_producto,
          b.d_producto_alter as d_nombre_empresa,
          a.d_desc_producto,
          a.d_imagen_producto,
          b.c_barras,
          b.v_precio_actual as v_precio_inicial,
          a.f_ingreso,
          a.c_usuario_ingreso,
          a.f_modifico,
          a.c_usuario_modifico,
          a.b_registro_activo,
          b.b_disponible,
					a.c_tipo,
					(SELECT count(*) as complementos from pro_complementos_enc_suc x
					inner join pro_complementos_det_suc y on x.c_complemento=y.c_complemento
					where c_producto=x.c_producto and x.b_registro_activo=1
					and c_correlativo_producto=(SELECT c_correlativo
					from pro_producto_x_sucursal where c_producto=a.c_producto
					and c_sucursal=b.c_sucursal)) as complementos
      FROM
          pro_producto a
          inner join pro_producto_x_sucursal b on a.c_producto=b.c_producto
          and b.c_sucursal=\''.$c_empresa.'\' and b.b_registro_activo=1 and a.b_registro_activo=1
					and a.c_tipo='.$_POST['c_tipo'].' '.$filtro;
	        // echo $sql;


			try {

				if(!$db->conectar()){
						$respuesta= "No Se conecto";
				}else
				{
					$consulta = $db->conexion->query($sql);
					//$db->conexion->query($sql);
					if(mysqli_error($db->conexion)!=""){
						$respuesta= mysqli_error($db->conexion)." Error";
						$db->conexion->rollback();
						echo $respuesta;
						exit;
					}else {
						mysqli_commit($db->conexion);
					}
						 $respuesta='';

						 $porcentaje='25';
						$fuente='14';
							if(isset($_POST['tel'])){
							$porcentaje=$_POST['tel'];
							$fuente='14';
						}
						//echo $fuente;
					while($resultados = mysqli_fetch_array($consulta)) {
						
						 $complementos=$resultados['complementos'];
						 $disponible='
						 <a class="btn btn-danger btn-sm" onclick="down(\''.$resultados['c_producto'].'\')">
							 <i class="fas fa-minus" style="color: white"></i>
						 </a>
						 <input class="text-center" align="center" readonly onchange="valida(\''.$resultados['c_producto'].'\')" type="number" min="0" name="pro_'.$resultados['c_producto'].'"
							id="pro_'.$resultados['c_producto'].'" value="0" style="width:50px" />
						 <a class="btn btn-success btn-sm" onclick="up(\''.$resultados['c_producto'].'\','.$complementos.')">
								<i class="fas fa-plus" style="color: white"></i>
						 </a>';
						 $img_disponible='';
						 if($resultados['b_disponible']=='0')
						 {
							 $disponible=' <a class="btn btn-danger " >
								 <i class="fas fa-minus" style="color: white"></i>
							 </a>
							 <input readonly onchange="valida(\''.$resultados['c_producto'].'\')" type="number" min="0" name="pro_'.$resultados['c_producto'].'"
								id="pro_'.$resultados['c_producto'].'" value="0" style="width:50px" />
							 <a class="btn btn-success" disabled="true" >
									<i class="fas fa-plus" style="color: white"></i>
							 </a>';
$disponible='';
							 $img_disponible='<img  onClick="detalleProducto(\''.$resultados['c_producto'].'\')"
							 style="width:90%;" class="eye"  width="180"	height="200" src="https://bfdtechnologies.info/img/nodisponible.png"/>';
							 							 /*$img_disponible='<img  onClick="detalleProducto(\''.$resultados['c_correlativo'].'\',\''.$resultados['c_producto'].'\',\''.$resultados['d_producto'].'\',\'https://bfdtechnologies.info/imagenes/productos/'.$resultados['d_imagen_producto'].'\',\''.$resultados['d_desc_producto'].'\',\''.$resultados['v_precio_inicial'].'\')"
							 							 style="width:90%;" class="eye"  width="180"	height="200" src="https://bfdtechnologies.info/img/nodisponible.png"/>';*/

						 }


						 $respuesta.='<div  style="border-style:none; max-height: '.$porcentaje.'%;width:'.$porcentaje.'%;height:90%;" class="producto card form-control">
														<div class="form">
															<!--<img src="https://bfdtechnologies.info/imagenes/productos/'.$resultados['d_imagen_producto'].'" alt="Sin Imagen" style="width:100%"
															width="200"
			 	                     height="200">-->

														 <!--<a href="https://bfdtechnologies.info/imagenes/productos/'.$resultados['d_imagen_producto'].'">-->
														 <img  onClick="detalleProducto(\''.$resultados['c_producto'].'\')"
														 src="https://bfdtechnologies.info/imagenes/productos/'.$resultados['d_imagen_producto'].'"
														 alt="Sin Imagen" style="width:100%"
														 width="200"
														height="200"/>
														'.$img_disponible.' <!--</a>-->
															<div class="responsive" style="height: 80px;">
																<h1  onClick="detalleProducto(\''.$resultados['c_producto'].'\')"
																style="font-size: '.$fuente.'px;"> <center> <strong>'.$resultados['d_producto'].' </strong></center> </h1>
																<strong style="font-size:14px">Lps '.$resultados['v_precio_inicial'].'</strong>
															</div>
																<div class="text-center" style="text-align:center">

																'.$disponible.'

															</div>
														</div>
														</div>';
					}
					if($respuesta=='')
					$respuesta='<br/><center><font color="blue">NO HAY RESULTADOS</font></center>';
					/*
          $respuesta.='</tbody>
        </table>';*/
				}
			} catch (Exception $e) {
				$respuesta=$e;
				echo $respuesta;
			}finally
			{
				$db->desconectar();
			}
      echo $respuesta;
}


		function fcnLstProEmpArray($c_empresa)
		{
		  //echo $c_empresa;
		  require('conexion.php');
			$respuesta='';
			$filtro="";
		if(isset($_POST['filtro']))
  			$filtro=" and b.d_producto_alter like '%".$_POST['filtro']."%' ";


			$sql='SELECT
		          a.c_producto,
		          a.c_marca,
		          a.c_tipo,
		          b.d_producto_alter as d_producto,
		          /*a.d_desc_producto,*/
		          a.d_imagen_producto,
		          b.v_precio_actual as v_precio_inicial,
		          b.b_disponible,
							\'0\' as cantidad,
							\'0.00\' as subtotal,
							IFNULL( (SELECT
					        SUM(n_comp_min)
					    FROM
					        pro_complementos_enc_suc X
					    WHERE
					        b.c_correlativo = c_correlativo_producto
					        and (select count(*) from pro_complementos_det_suc y
					             where c_complemento = X.c_complemento AND X.b_registro_activo = 1 )>0) ,0) as n_complementos_min_pro
		      FROM
		          pro_producto a
		          inner join pro_producto_x_sucursal b on a.c_producto=b.c_producto
		          and b.c_sucursal=\''.$c_empresa.'\' and b.b_registro_activo=1 
		          and a.b_registro_activo=1 '.' '.$filtro;
			         //echo $sql;
							 //exit;
					try {

						if(!$db->conectar()){
								$respuesta= "No Se conecto";
						}else
						{
							$consulta = $db->conexion->query($sql);
							//$db->conexion->query($sql);
							if(mysqli_error($db->conexion)!=""){
								$respuesta= mysqli_error($db->conexion)." Error";
								$db->conexion->rollback();
								echo $respuesta;
								exit;
							}else {
								mysqli_commit($db->conexion);
							}
								$myArray = array();
								while($resultados = mysqli_fetch_array($consulta)) {
									$myArray[] = $resultados;
								}
								//$res['productos']=($myArray);
    						//echo json_encode($res);
						    $respuesta= json_encode($myArray);
						}
					} catch (Exception $e) {
						$respuesta=$e;
						echo $respuesta;
					}finally
					{
						$db->desconectar();
					}
		      echo $respuesta;
		}
		function fcnSTOrd()
		{
			//print_r($_POST);
			//exit;
			//echo json_decode ($_POST['lstPro']) ;
			//print_r( ($_POST['lstPro']) );
			$someArray = json_decode($_POST['lstPro'], true);
			$sql="INSERT INTO venta_pedidos_enc(
						    c_pedido,
						    c_empresa,
						    d_cliente_nombre,
						    d_cliente_apellido,
						    d_telefono,
						    d_direccion_referencia,
						    d_direccion,
						    f_ingreso,
						    d_geolocalizacion,
						    d_correo,
						    c_estado_pedido,
						    c_tipo_pedido,
						    c_sucursal,
						    v_monto_envio,
								d_comentario_cliente)
						VALUES(
						    NULL,
						    (select c_empresa from neg_empresa_sucursal
									where c_sucursal='".$_POST["c_empresa"]."'),
						    '".$_POST["nombre"]."',
						    '".$_POST["apellido"]."',
						    '".$_POST["telefono"]."',
						    '".$_POST["referencia"]."',
						    '".$_POST["direccion"]."',
						    DATE_SUB(NOW(),INTERVAL 2 HOUR),
						    '".$_POST["ubicacion"]."',
						    '".$_POST["correo"]."',
						    '0',
						    '".$_POST["tipo_pro"]."',
						    '".$_POST["c_empresa"]."',
						    '".$_POST["envio"]."',
								'".$_POST["comentario"]."')";
								//print_r($_POST);

													//echo $sql;
													//exit;
			  //print_r($someArray);        // Dump all data of the Array
				$n=0;
				$time = time();

				$sql_detalle="INSERT INTO venta_pedidos_det(
											    c_pedido_detalle,
											    c_pedido,
											    c_producto,
											    cant_producto,
											    v_precio,
											    v_subtotal,
											    f_ingreso,
											    b_registro_activo)
											VALUES ";
				//echo date("Ymd_H_i_s", $time);
				for ($i=0; $i <sizeof($someArray) ; $i++) {
					if($someArray[$i]["cantidad"]>0)
					{
						if($n>0)
						$sql_detalle.=" , ";


						$sql_detalle.="(
								NULL,
								(SELECT c_pedido from venta_pedidos_enc
						where d_cliente_nombre='".$_POST["nombre"]."'
						and d_cliente_apellido='".$_POST["apellido"]."'
						and d_telefono='".$_POST["telefono"]."'
						and c_sucursal='".$_POST["c_empresa"]."'
						order by c_pedido desc limit 1),
								'".$someArray[$i]["c_producto"]."',
								'".$someArray[$i]["cantidad"]."',
								'".$someArray[$i]["v_precio_inicial"]."',
								'".$someArray[$i]["subtotal"]."',
								DATE_SUB(NOW(),INTERVAL 2 HOUR),
								'1')";
								/*
						$sql.="(
						    NULL,
						    '".$_POST["telefono"]."_".date("Ymd_H_i_s", $time)."',
						    '".$_POST["c_empresa"]."',
						    '".$someArray[$i]["c_producto"]."',
						    '".$someArray[$i]["cantidad"]."',
						    '".$someArray[$i]["v_precio_inicial"]."',
						    '".$someArray[$i]["subtotal"]."',
						    '".$_POST["nombre"]."',
						    '".$_POST["apellido"]."',
						    '".$_POST["telefono"]."',
						    '".$_POST["direccion"]."',
						    '".$_POST["referencia"]."',
						    '".$_POST["correo"]."',
						    '".$_POST["ubicacion"]."', NOW() )";*/
								$n++;
						//echo $someArray[$i]["c_producto"]."<br/>";

					}
				}

									//echo $sql_detalle;
									//exit;

				require('conexion.php');
				$respuesta='';
						try {

							if(!$db->conectar()){
									$respuesta= "No Se conecto";
							}else
							{
								$consulta = $db->conexion->query($sql);
								//$db->conexion->query($sql);
								if(mysqli_error($db->conexion)!=""){
									$respuesta= mysqli_error($db->conexion)." Error";
									$db->conexion->rollback();
									echo $respuesta;
									exit;
								}else {
									mysqli_commit($db->conexion);
									$consulta = $db->conexion->query($sql_detalle);
									//$db->conexion->query($sql);
									if(mysqli_error($db->conexion)!=""){
										$respuesta= mysqli_error($db->conexion)." Error";
										$db->conexion->rollback();
										echo $respuesta;
										exit;
									}else {
										mysqli_commit($db->conexion);
										$respuesta='OK';
										$cuerpo=fcnLstProPed("(SELECT c_pedido from venta_pedidos_enc
								where d_cliente_nombre='".$_POST["nombre"]."'
								and d_cliente_apellido='".$_POST["apellido"]."'
								and d_telefono='".$_POST["telefono"]."'
								and c_sucursal='".$_POST["c_empresa"]."'
								order by c_pedido desc limit 1)", $time);
										$cuerpo='<html>
									  <head>
									    <title>Han Realizado un Nuevo Pedido</title>
											<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
											integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
											<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
											integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
									  </head>
									  <body>
										<p>Empresa ( '.$_POST['d_empresa'].' ) </p>
										<!--<p>Codigo Pedido ( '.$_POST["telefono"]."_".date("Ymd_H_i_s", $time).' )</p>-->
										<p>Fecha: ( '.date("Y-m-d H:i:s", $time).' )</p>
										<p>Cliente: ( '.strtoupper($_POST["nombre"].' '.$_POST["apellido"]).' )</p>
									    <p>Detalle del Pedido</p>

									    <table BORDER class="table table-bordered table-responsive">
											<tr>
												<th>CODIGO</th>
												<th scope="col">PRODUCTO</th>
												<th >DESCRIPCION</th>
												<th >CANTIDAD</th>
												<th >PRECIO</th>
												<th >SUBTOTAL</th>
											 </tr>
									      '.$cuerpo.'
									    </table>
											<br>
											<br>
											<br><h2><a href=\'https://bfdtechnologies.info/login.php\'>Iniciar Sesion</a></h2>
									  </body>
									  </html>';
										//echo $cuerpo;

										$correo_empresa= fcngetDato("select d_correo from neg_empresa_sucursal
											where c_sucursal='".$_POST["c_empresa"]."'");
											//echo $correo_empresa." dhjhd ";
											//echo $_POST["d_empresa"];
										enviaCorreoPedido($correo_empresa,$_POST["d_empresa"],$cuerpo);
										//enviaCorreoPedido('gmoncada@bfdtechnologies.info','Gloria Moncada',$cuerpo);
									}
								}

							}
						} catch (Exception $e) {
							$respuesta=$e;
							echo $respuesta;
						}finally
						{
							$db->desconectar();
						}
			      echo $respuesta;
				//echo $sql;
		  //echo $someArray[0]["c_producto"]; // Access Array data
		  //echo $someArray[1]["c_producto"]; // Access Array data
		}
		function fcnLstProPed($c_pedido)
			{
				$sql="SELECT
				a.c_producto,
				b.d_producto,
				a.cant_producto,
				a.v_precio,
				a.v_subtotal,
				concat(c.d_cliente_nombre,c.d_cliente_apellido) as cliente,
				b.d_desc_producto,
				c.v_monto_envio
				FROM venta_pedidos_det a
				inner join pro_producto b on a.c_producto=b.c_producto
				inner join venta_pedidos_enc c on a.c_pedido=c.c_pedido
				where a.c_pedido=".$c_pedido." ";

				//echo $sql;
				//require('conexion.php');
				$respuesta='';

				try {
					$db = new BaseDatos();

					if(!$db->conectar()){
							$respuesta= "No Se conecto";
					}else
					{
						$consulta = $db->conexion->query($sql);
						//$db->conexion->query($sql);
						if(mysqli_error($db->conexion)!=""){
							echo mysqli_error($db->conexion)." Error";
							$db->conexion->rollback();
							echo $respuesta;
							exit;
						}else {
							mysqli_commit($db->conexion);


						}
						$total=0;
						$envio="";
						while($resultados = mysqli_fetch_array($consulta)) {
							//$respuesta.= '<label>'.$resultados['d_producto'].'</label>								<br/>';

							$respuesta.= '
							<tr>
							<td>'.$resultados['c_producto'].'</td>
							<td>'.$resultados['d_producto'].'</td>
							<td>'.$resultados['d_desc_producto'].'</td>
							<td>'.$resultados['cant_producto'].'</td>
							<td>L '.$resultados['v_precio'].'</td>
							<td>L '.$resultados['v_subtotal'].'</td>
							</tr>';
							$total+=$resultados['v_subtotal'];
							$envio=$resultados['v_monto_envio'];
						}
						$respuesta.= '
						<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>TOTAL</td>
						<td>'.$total.'</td>
						</tr>';
						/*echo $envio;
						$respuesta.= '
						<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>MONTO ENVIO INICIAL</td>
						<td> '.$envio.' </td>
						</tr>';

						$respuesta.= '
						<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>TOTAL</td>
						<td>'.($total+$envio).'</td>
						</tr>';*/

						//echo $db->conexion->mysql_error;
					}
				} catch (Exception $e) {
					$respuesta=$e;

					echo $respuesta;
				}finally
				{
					$db->desconectar();
				}

				return $respuesta;
			}
		function enviaCorreoPedido($correo_destino,$nombre_destino,$cuerpo)
		{
		  // Varios destinatarios
		  //$para  = 'erazo.favio@gmail.com' . ', '; // atención a la coma
		  $para = ''.$nombre_destino.' <'.$correo_destino.'>';
		  //$para .= ' ,ferazo@bfdtechnologies.info';
		  $para .= ' ,ADMIN<info@bfdtechnologies.info>';


		  // título
		  $título = '.::|MERCADITO|::. - Nuevo Pedido';

		  // mensaje
		  //mensaje=$cuerpo;
		  $mensaje = ''.$cuerpo;


		  // Para enviar un correo HTML, debe establecerse la cabecera Content-type
		  $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		  $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		  // Cabeceras adicionales
		  $cabeceras .= 'To: '.$nombre_destino.' <'.$correo_destino.'>' . "\r\n";
		  $cabeceras .= 'From: .::|MERCADITO|::.<info@bfdtechnologies.info>' . "\r\n";
		  //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
		  $cabeceras.='Reply-To: .::|MERCADITO|::.<info@bfdtechnologies.info>' . "\r\n";
		  //$cabeceras .= 'Bcc: Admin<ferazo@bfdtechnologies.info>' . "\r\n";

		  // Enviarlo

		  $success = mail($para, $título, $mensaje, $cabeceras);
		  if (!$success) {
		      $errorMessage = error_get_last()['message'];
					echo $errorMessage;
		  }
		}

		function fcnLstEmp()
		{
			//print_r($_POST);
			require('conexion.php');
			$respuesta='';
			$gps=explode(",", $_POST['coordenadas']);
			//echo $_POST['coordenadas'];
	    //echo $gps[0]."</br>";
	    //echo $gps[1]."</br>";
				$filtro=" ";
			if($_POST['filtro']!="")
			$filtro=" and 	d_nombre_empresa like '%".$_POST['filtro']."%'";


	    $filtro.=" and ( (SELECT (acos(sin(radians(".$gps[0].")) * sin(radians(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 1))) +
				cos(radians(".$gps[0].")) * cos(radians(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 1))) *
				cos(radians(".$gps[1].") - radians(SUBSTRING_INDEX(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 2), ',', -1)))) * 6378)) + ( (SELECT (acos(sin(radians(".$gps[0].")) * sin(radians(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 1))) +
				cos(radians(".$gps[0].")) * cos(radians(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 1))) *
				cos(radians(".$gps[1].") - radians(SUBSTRING_INDEX(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 2), ',', -1)))) * 6378))*0.521 )) <=50000 ";

			$sql='select * from (SELECT
					    a.c_empresa,
					    b.c_sucursal,
					    a.d_nombre_empresa,
					    b.d_nombre_sucursal,
					    b.d_direccion,
					    b.d_geolocalizacion,
					    b.b_abierto,
					    d_logo,'."
							(SELECT (acos(sin(radians(".$gps[0].")) * sin(radians(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 1))) +
							cos(radians(".$gps[0].")) * cos(radians(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 1))) *
							cos(radians(".$gps[1].") - radians(SUBSTRING_INDEX(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 2), ',', -1)))) * 6378) + ( (SELECT (acos(sin(radians(".$gps[0].")) * sin(radians(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 1))) +
							cos(radians(".$gps[0].")) * cos(radians(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 1))) *
							cos(radians(".$gps[1].") - radians(SUBSTRING_INDEX(SUBSTRING_INDEX(b.d_geolocalizacion, ',', 2), ',', -1)))) * 6378))*0.514 ) ) as distancia
					FROM
					    neg_empresa a
							inner join neg_empresa_sucursal b on a.c_empresa=b.c_empresa
					WHERE
					a.b_registro_activo=1
					and b.b_registro_activo=1 ".$filtro." ) as datos
					order by b_abierto desc,distancia";
							 //echo $sql;
					try {

						if(!$db->conectar()){
								$respuesta= "No Se conecto";
						}else
						{
							$consulta = $db->conexion->query($sql);
							//$db->conexion->query($sql);
							if(mysqli_error($db->conexion)!=""){
								$respuesta= mysqli_error($db->conexion)." Error";
								$db->conexion->rollback();
								echo $respuesta;
								exit;
							}else {
								mysqli_commit($db->conexion);
							}
								 $respuesta='';

								 $porcentaje='25';
								$fuente='14';
									if(isset($_POST['tel'])){
									$porcentaje=$_POST['tel'];
									$fuente='14';
								}
							while($resultados = mysqli_fetch_array($consulta)) {
								$cerrado="";
									$accion='onclick="stEmpPro(\''.$resultados['c_sucursal'].'\',\''.$resultados['d_nombre_sucursal'].'\',\''.$resultados['d_logo'].'\')" ';
									$img_cerrado='';
								if($resultados['b_abierto']=='0')
								{
									$accion='onclick="cerrado(\''.$resultados['d_nombre_empresa'].'\',\'NO ESTA DISPONIBLE EN ESTE MOMENTO\');"';
											$img_cerrado=' <img style="width:100%;" class="eye"  width="180"	height="200" src="https://bfdtechnologies.info/img/cerrado2.png"/> ';
								}
								//print_r($resultados);
								$respuesta.='
								 <div  style="border-style:none; max-height: '.$porcentaje.'%;width:'.$porcentaje.'%;height:auto;" class="producto col s3 m3 l3">
									<div class="card">
									<a '.$accion.' >
										<!--<img src="https://bfdtechnologies.info/imagenes/'.$resultados['c_empresa'].'/'.$resultados['d_logo'].'" alt="Sin Imagen" style="width:100%"
										width="200"
									 height="200">-->
									 '.$cerrado.'<img '.$accion.'
									 src="https://bfdtechnologies.info/imagenes/'.$resultados['c_empresa'].'/'.$resultados['d_logo'].'"
									 alt="Sin Imagen" style="width:100%;position: relative;"

									 width="200"
									height="200" />
									'.$img_cerrado.'</a>
										<div class="reponsive" style="height: 70px;">
											<h2 style="font-size: '.$fuente.'px;" class="reponsive"> <center> <strong>'.strtoupper($resultados['d_nombre_sucursal']).' | '.round($resultados['distancia'], 2).' KM </strong></center> </h2>
											<!--<strong>'.$resultados['d_direccion'].'</strong>-->
										</div>
											<!--<div class="card-footer row" style="text:center">
											<button type="button" class="btn btn-success " style="color: white"  '.$accion.' >
												<i class="fas fa-check" style="color: white"></i>
											</button>
										</div>-->
									</div>
									</div>';
									/*
									$respuesta.='
									<div class="col s3 m3 l3" style="border-style:none; max-height: '.$porcentaje.'%;width:'.$porcentaje.'%;height:auto;" >
								      <div class="card">
								          <div class="card-image waves-effect waves-block waves-light">
								              <a '.$accion.' ><img class="activator" src="https://bfdtechnologies.info/imagenes/'.$resultados['c_empresa'].'/'.$resultados['d_logo'].'"
								              style="width:100%;position: relative;"
												 width="200"
												height="200"/>
									'.$img_cerrado.'</a>
								          </div>
								          <div class="reponsive" style="height: 70px;">
								          <p style="font-size: '.$fuente.'px;" class="reponsive"> <center> <strong>'.strtoupper($resultados['d_nombre_sucursal']).' | '.round($resultados['distancia'], 2).' KM </strong></center> </p>


								          </div>

								      </div>
								  </div>';*/
							}/*
							$respuesta.='</tbody>
						</table>';*/
						if($respuesta=="")
						$respuesta="NO SE ENCONTRARON COMERCIOS";
						}
					} catch (Exception $e) {
						$respuesta=$e;
						echo $respuesta;
					}finally
					{
						$db->desconectar();
					}
					echo $respuesta;
		}

		function fcngetDato($query)
		{
			//print_r($_POST);
			//require('conexion.php');
			$respuesta='';

				$db = new BaseDatos();
			$sql=$query;
							 //echo $sql;
					try {

						if(!$db->conectar()){
								$respuesta= "No Se conecto";
						}else
						{
							$consulta = $db->conexion->query($sql);
							//$db->conexion->query($sql);
							if(mysqli_error($db->conexion)!=""){
								$respuesta= mysqli_error($db->conexion)." Error";
								$db->conexion->rollback();
								echo $respuesta;
								exit;
							}else {
								mysqli_commit($db->conexion);
							}

							while($resultados = mysqli_fetch_array($consulta)) {
								return $resultados[0];
							}
						}
					} catch (Exception $e) {
						$respuesta=$e;
						echo $respuesta;
					}finally
					{
						$db->desconectar();
					}
					 //$respuesta;
		}


		function fcnGTComp()
		{
			//print_r($_POST);
			require('conexion.php');
			$respuesta='';

				//$db = new BaseDatos();
			$sql="";
							 //echo $sql;
					try {

						if(!$db->conectar()){
								$respuesta= "No Se conecto";
						}else
						{
							$consulta = $db->conexion->query($sql);
							//$db->conexion->query($sql);
							if(mysqli_error($db->conexion)!=""){
								$respuesta= mysqli_error($db->conexion)." Error";
								$db->conexion->rollback();
								echo $respuesta;
								exit;
							}else {
								mysqli_commit($db->conexion);
							}

							while($resultados = mysqli_fetch_array($consulta)) {
								return $resultados[0];
							}
						}
					} catch (Exception $e) {
						$respuesta=$e;
						echo $respuesta;
					}finally
					{
						$db->desconectar();
					}
					 //$respuesta;
		}
		function fcnLstCompPro()
		{
			//print_r($_POST);
			require('conexion.php');
			$respuesta='';

			$sql='SELECT a.c_complemento,
							a.c_correlativo_producto,
							a.d_complemento,
							a.n_comp_min,
							a.n_comp_max,
							b.c_registro,
							b.d_complemento_det,
							b.v_complemento,
		          c.d_producto_alter as d_producto,
		          d.d_desc_producto,
		          d.d_imagen_producto,
		          c.v_precio_actual as v_precio_inicial,
							c.b_disponible

						FROM pro_complementos_enc_suc a
						inner join pro_complementos_det_suc b on a.c_complemento=b.c_complemento
						inner join pro_producto_x_sucursal c on a.c_correlativo_producto=c.c_correlativo
						inner join pro_producto d on c.c_producto=d.c_producto
						and a.b_registro_activo=1 and b.b_registro_activo=1
						and c.c_producto='.$_POST['c_producto'].'
						and c.c_sucursal=\''.$_POST['c_empresa'].'\'
						order by a.c_complemento,b.c_registro';
						//echo $sql;



						$complementos=fcngetDato("SELECT count(*) as complementos from pro_complementos_enc_suc a
						inner join pro_complementos_det_suc b on a.c_complemento=b.c_complemento
													where c_producto='".$_POST['c_producto']."' and a.b_registro_activo=1
													and c_correlativo_producto=(SELECT c_correlativo
														from pro_producto_x_sucursal where c_producto='".$_POST['c_producto']."'
														and c_sucursal='".$_POST['c_empresa']."')");
														//echo $complementos;
							if($complementos==0)
							{
									$sql='SELECT
											    a.d_producto_alter AS d_producto,
											    b.d_desc_producto,
											    b.d_imagen_producto,
											    a.v_precio_actual AS v_precio_inicial,
													a.b_disponible,
													b.c_marca,
													(select d_marca from pro_marca
													where c_marca=b.c_marca) as d_marca
											FROM
											    pro_producto_x_sucursal a
											INNER JOIN pro_producto b ON
											    a.c_producto = b.c_producto AND a.b_registro_activo = 1
													AND a.c_producto = '.$_POST['c_producto'].' AND a.c_sucursal = \''.$_POST['c_empresa'].'\'';
							}
							$disponible="";
					try {

						if(!$db->conectar()){
								$respuesta= "No Se conecto";
						}else
						{
							$consulta = $db->conexion->query($sql);
							//$db->conexion->query($sql);
							if(mysqli_error($db->conexion)!=""){
								$respuesta= mysqli_error($db->conexion)." Error";
								$db->conexion->rollback();
								echo $respuesta;
								exit;
							}else {
								mysqli_commit($db->conexion);
								$n=0;
								if($complementos==0)
								{
									while($resultados = mysqli_fetch_array($consulta))
									{

										$disponible=$resultados['b_disponible'];
										echo '<div id="nombre" class="carousel slide" data-ride="carousel">
										<center><h2><STRONG>'.$resultados['d_producto'].' - '.$resultados['v_precio_inicial'].'</STRONG></h2></center>
										</div>
										<div  class="carousel slide" data-ride="carousel">
											<center><img id="img"
											data-dismiss="modal"
											src="https://bfdtechnologies.info/imagenes/productos/'.$resultados['d_imagen_producto'].'"
											alt="Sin Imagen" style="width:50%"
											width="200"
										 height="200"/>
									 </center>
										</div>
										<div id="desc" class="carousel slide" data-ride="carousel"> <center>
										'.$resultados['d_desc_producto'].' - '.$resultados['d_marca'].' </center>
										</div>
										<div id="c_prod" class="carousel slide" data-ride="carousel">
										</div>
										<div id="disponible" class="carousel slide" data-ride="carousel">
										</div>';
									}
								}else {

									while($resultados = mysqli_fetch_array($consulta))
									{

										$disponible=$resultados['b_disponible'];
										if($n==0)
										{
											echo '<div id="nombre" class="carousel slide" data-ride="carousel">
											<center><h2><STRONG>'.$resultados['d_producto'].' - '.$resultados['v_precio_inicial'].'</STRONG></h2></center>
						          </div>
						          <div  class="carousel slide" data-ride="carousel">
						            <center><img id="img"
						            data-dismiss="modal"
						            src="https://bfdtechnologies.info/imagenes/productos/'.$resultados['d_imagen_producto'].'"
						            alt="Sin Imagen" style="width:50%"
						            width="200"
						           height="200"/>
						         </center>
						          </div>
						          <div id="desc" class="carousel slide" data-ride="carousel">
											'.$resultados['d_desc_producto'].'
						          </div>
						          <div id="c_prod" class="carousel slide" data-ride="carousel">
						          </div>
						          <div id="disponible" class="carousel slide" data-ride="carousel">
						          </div>';
											if($disponible==0)
											break;
										}
										if($n!=$resultados['c_complemento'])
										{
											//echo $resultados['c_complemento'].'</br>';
											if($n!=0 )
											{
													$respuesta.='	</div>
												</div>';
											}
												$respuesta.='	<div class="card mb-4 py-3 border-bottom-primary">';

												$respuesta.= "<center><Strong> <input type='hidden' value='0.00' id='".$resultados['c_complemento']."'/>
												<input type='hidden' value='".$resultados['n_comp_max']."' id='max_".$resultados['c_complemento']."'/>
												<font style='color:blue'>".$resultados['d_complemento']." </font> </Strong>
												<a style='font-size:12px' > ( min ".$resultados['n_comp_min']." - max ".$resultados['n_comp_max']." articulo (s) ) </a></center><br/>";
			                $respuesta.='<div class="card-body">';
											$n=$resultados['c_complemento'];
										}

											$precio=$resultados['v_complemento'];

											if($precio!=0)
											{
												$precio=" +".$precio." Lps";
											}else {
												$precio="";
											}
											//$respuesta.= $resultados['d_complemento_det']." <br/>";

											$respuesta.='<input onchange="stComPro('.$resultados['c_complemento'].','.$resultados['c_registro'].');" type="checkbox" id="'.$resultados['c_registro'].'"
											name="'.$resultados['c_registro'].'" value="0">
																	<label for="'.$resultados['c_registro'].'"> <Strong>'.$resultados['d_complemento_det'].'</Strong>
																	<font style="color:blue">'.$precio.'</font>
																	</label><br>';






									//	$n++;

									}
								}
								if($complementos!=0)
								{
	 									$respuesta.='	</div>
	 								</div>';
								}

								if($disponible==1)
								{
										$respuesta.='<div class="text-center" style="text-align: center;">
										<a class="btn btn-danger btn-sm" onclick="down(\''.$_POST['c_producto'].'\')">
					 							 <i class="fas fa-minus" style="color: white"></i>
					 						 </a>
					 						 <input class="text-center" align="center" readonly onchange="valida(\''.$_POST['c_producto'].'\')" type="number" min="0" name="modal_pro_'.$_POST['c_producto'].'"
					 							id="modal_pro_'.$_POST['c_producto'].'" value="0" style="width:50px" />
					 						 <a class="btn btn-success btn-sm" onclick="up(\''.$_POST['c_producto'].'\','.$complementos.')">
					 								<i class="fas fa-plus" style="color: white"></i>
					 						 </a>
								 		 </div>';
								 }
							}
						}
					} catch (Exception $e) {
						$respuesta=$e;
						echo $respuesta;
					}finally
					{
						$db->desconectar();
					}
					echo $respuesta;
		}



	function fcnSTCont()
	{
		$correo=$_POST["correo"];
		$nombre_destino=$_POST["nombre"];
		$cuerpo=$_POST["mensaje"];
		// Varios destinatarios
		//$para  = 'erazo.favio@gmail.com' . ', '; // atención a la coma
		$para = ''.$nombre_destino.' <'.$correo.'>';
		$para .= ' .::|MERCADITO|::.<info@appmercadito.com>';
		//$para .= ' ,ADMIN<info@appmercadito.com>';


		// título
		$título = '.::|MERCADITO|::. - Formulario de Contacto';

		// mensaje
		//mensaje=$cuerpo;
		$mensaje = ''.$cuerpo;


		// Para enviar un correo HTML, debe establecerse la cabecera Content-type
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Cabeceras adicionales
		//$cabeceras .= 'To: '.$nombre_destino.' <'.$correo.'>' . "\r\n";
		$cabeceras .= 'From: '.$nombre_destino.' <'.$correo.'>' . "\r\n";
		$cabeceras .= 'To: .::|MERCADITO|::.<info@appmercadito.com>' . "\r\n";
		//$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
		$cabeceras.='Reply-To: '.$nombre_destino.' <'.$correo.'>' . "\r\n";
		//$cabeceras .= 'Bcc: Admin<ferazo@bfdtechnologies.info>' . "\r\n";

		// Enviarlo

		$success = mail($para, $título, $mensaje, $cabeceras);
		if (!$success) {
				$errorMessage = error_get_last()['message'];
				echo $errorMessage;
		}else
		echo "Envio correctamente";
	}

	function insert()
	{

	}
	function fcnSTCta()
	{
		$_POST["pass"]=password_hash($_POST["pass"], PASSWORD_DEFAULT,["cost"=>12]);
		$coord=explode(",",$_POST["ubicacion"]);
		//CODIGO ALEATORIO ACTIVACION
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890&%#*";
		  $codigo = "";
		  //Reconstruimos la contraseña segun la longitud que se quiera
		  for($i=0;$i<4;$i++) {
		     //obtenemos un caracter aleatorio escogido de la cadena de caracteres
		     $codigo .= substr($str,rand(0,39),1);
		  }
		  $_POST["usuario"]=strtoupper($_POST["usuario"]);
		  $_POST["nombre"]=strtoupper($_POST["nombre"]);
		 // echo " codigo ".$codigo." ";
		  $sql_count="SELECT count(*) as existe
		  from cli_usuarios_clientes 
		  where c_usuario='".$_POST["usuario"]."'";

		$sql="INSERT INTO cli_usuarios_clientes(
			    c_cliente,
			    c_usuario,
			    d_usuario,
			    d_pass,
			    c_codigo_confirmacion,
			    b_registro_activo,
			    f_ingreso,
			    d_ubicacion_creo
			)
			VALUES(NULL,'".$_POST["usuario"]."',
			'".$_POST["nombre"]."',
			'".$_POST["pass"]."',
			'".$codigo."',
			-1,DATE_SUB(NOW(),INTERVAL 2 HOUR),
			'".$_POST["ubicacion"]."' );";
			
		require('conexion.php');
		//echo $sql;
		//exit;
		$respuesta='';
		try {

			if(!$db->conectar()){
					$respuesta= "No Se conecto";
			}else
			{
				$consulta = $db->conexion->query($sql_count);
				if(mysqli_error($db->conexion)!=""){
					$respuesta= mysqli_error($db->conexion)." Error";
					$db->conexion->rollback();
					//echo $respuesta;
					//exit;
				}else {
					mysqli_commit($db->conexion);
					$existe="";
					while($resultados = mysqli_fetch_array($consulta))
					{
						$existe=$resultados["existe"];
					}
					if($existe=="0")
					{

						$consulta = $db->conexion->query($sql);
						if(mysqli_error($db->conexion)!=""){
							$respuesta= mysqli_error($db->conexion)." Error";
							$db->conexion->rollback();
							//echo $respuesta;
							//exit;
						}else {
							mysqli_commit($db->conexion);
							$respuesta='OK';

							$cuerpo='<html>
									  
									  <body>
										<p>Hola '.$_POST['nombre'].', se ha creado una nueva cuenta vinculada a este correo electronico para poder utilizar la plataforma Mercadito Delivery, solo tienes que ingresar el codigo que se muestra a continuacion para terminar el proceso: </p>
										
									    <h1>Codigo: <strong>'.$codigo.'</strong></h1> 

									    
											<br>
											<br>
											<br><h2><a href=\'https://appmercadito.com/pedidos/login.php\'>Iniciar Sesion</a></h2>

											<p>Saludos,</p>
											<p>.::MiMercaditoTeam::.</p>
									  </body>
									  </html>';
							enviaCorreoNuevaCuenta($_POST["usuario"],$_POST["nombre"],$cuerpo);
						}
					}else
					$respuesta='Ya existe una cuenta con registrada con ese correo electronico';
					
					//
				}

			}
		} catch (Exception $e) {
			$respuesta=$e;
			//echo $respuesta;
		}finally
		{
			$db->desconectar();
		}
		echo $respuesta;
	}

	function enviaCorreoNuevaCuenta($correo_destino,$nombre_destino,$cuerpo)
	{
	  // Varios destinatarios
	  //$para  = 'erazo.favio@gmail.com' . ', '; // atención a la coma
	  $para = ''.$nombre_destino.' <'.$correo_destino.'>';
	  //$para .= ' ,ferazo@bfdtechnologies.info';
	  $para .= ' ,ADMIN<info@appmercadito.com>';


	  // título
	  $título = '.::|MERCADITO|::. - Nueva Cuenta';

	  // mensaje
	  //mensaje=$cuerpo;
	  $mensaje = ''.$cuerpo;


	  // Para enviar un correo HTML, debe establecerse la cabecera Content-type
	  $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	  $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	  // Cabeceras adicionales
	  $cabeceras .= 'To: '.$nombre_destino.' <'.$correo_destino.'>' . "\r\n";
	  $cabeceras .= 'From: .::|MERCADITO|::.<info@appmercadito.com>' . "\r\n";
	  //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
	  $cabeceras.='Reply-To: .::|MERCADITO|::.<info@appmercadito.com>' . "\r\n";
	  //$cabeceras .= 'Bcc: Admin<ferazo@bfdtechnologies.info>' . "\r\n";

	  // Enviarlo

	  $success = mail($para, $título, $mensaje, $cabeceras);
	  if (!$success) {
	      $errorMessage = error_get_last()['message'];
				echo $errorMessage;
	  }
	}

	
 ?>
