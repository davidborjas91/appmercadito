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
	fcnLstProEmp($_POST['c_empresa']);
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
	case '':
	break;
	case '':
	break;
	case '':
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
	$respuesta='';
	$sql='SELECT
          a.c_producto,
          a.c_producto as c_empresa,
          a.c_marca,
          a.c_tipo,
          a.d_producto,
          a.d_producto as d_nombre_empresa,
          a.d_desc_producto,
          a.d_imagen_producto,
          a.c_barras,
          a.v_precio_inicial,
          a.f_ingreso,
          a.c_usuario_ingreso,
          a.f_modifico,
          a.c_usuario_modifico,
          a.b_registro_activo
      FROM
          pro_producto a
          inner join pro_producto_x_empresa b on a.c_producto=b.c_producto
          and b.c_empresa='.$c_empresa.' and b.b_registro_activo=1 and a.b_registro_activo=1 ';
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
          $respuesta='<table id="tabla-productos" class="table-responsive">'.
                '<thead>'.
          		   ' <tr>'.
          		    '  <th scope="col">PRODUCTO</th>'.
          		     ' <th >PRECIO</th>'.
           		     ' <th >CANTIDAD</th>'.
           		     ' <th >SUBTOTAL</th>'.
          		    '</tr>'.
          	 	'</thead>'.
          	 ' 	<tbody>';
						 $respuesta='';

						 $porcentaje='25';
						$fuente='14';
							if(isset($_POST['tel'])){
							$porcentaje=$_POST['tel'];
							$fuente='10';
						}
					while($resultados = mysqli_fetch_array($consulta)) {

						/*$respuesta.= "<tr>
            <td style='text-align: left;'><strong>".$resultados['d_producto'].'</strong></td>
					  <td ><label readonly type="number" name="pro_v_'.$resultados['c_producto'].'" id="pro_v_'.$resultados['c_producto'].'"
						value="'.$resultados['v_precio_inicial'].'" class="col-md-12">L'.$resultados['v_precio_inicial'].'</label></td>
            <td >
						<div>
							<a class="btn btn-danger " onclick="down(\''.$resultados['c_producto'].'\')">
	              <i class="fas fa-minus" style="color: white"></i>
	            </a>
             	<input readonly onchange="valida(\''.$resultados['c_producto'].'\')" type="number" min="0" name="pro_'.$resultados['c_producto'].'"
							 id="pro_'.$resultados['c_producto'].'" value="0" style="width:60px" />
             	<a class="btn btn-success" onclick="up(\''.$resultados['c_producto'].'\')">
	               <i class="fas fa-plus" style="color: white"></i>
	            </a>
						 <div>
						 </td>
 					  <td ><center> <input readonly type="number" name="pro_st_'.$resultados['c_producto'].'" id="pro_st_'.$resultados['c_producto'].'"
 						value="0.00" style="width:80px"> </center></td>
             </tr>';*/
						 $respuesta.='<div  style=" max-height: '.$porcentaje.'%;width:'.$porcentaje.'%;height:auto;" class="producto card form-control">
														<div class="form">
															<!--<img src="https://bfdtechnologies.info/imagenes/productos/'.$resultados['d_imagen_producto'].'" alt="Sin Imagen" style="width:100%"
															width="200"
			 	                     height="200">-->

														 <a href="https://bfdtechnologies.info/imagenes/productos/'.$resultados['d_imagen_producto'].'"><img
														 src="https://bfdtechnologies.info/imagenes/productos/'.$resultados['d_imagen_producto'].'"
														 alt="Sin Imagen" style="width:100%"
														 width="200"
														height="200"/></a>
															<div class="container">
																<b style="font-size: '.$fuente.'px;"> <center> <strong>'.$resultados['d_producto'].' </strong></center> </b
																<strong>Lps '.$resultados['v_precio_inicial'].'</strong>
															</div>
																<div class="card-footer row" style="text:center">
																<a class="btn btn-danger " onclick="down(\''.$resultados['c_producto'].'\')">
										              <i class="fas fa-minus" style="color: white"></i>
										            </a>
									             	<input readonly onchange="valida(\''.$resultados['c_producto'].'\')" type="number" min="0" name="pro_'.$resultados['c_producto'].'"
																 id="pro_'.$resultados['c_producto'].'" value="0" style="width:60px" />
									             	<a class="btn btn-success" onclick="up(\''.$resultados['c_producto'].'\')">
										               <i class="fas fa-plus" style="color: white"></i>
										            </a>

															</div>
														</div>
														</div>';
					}/*
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
			$sql='SELECT
		          a.c_producto,
		          a.c_marca,
		          a.c_tipo,
		          a.d_producto,
		          a.d_desc_producto,
		          a.d_imagen_producto,
		          a.v_precio_inicial,
							\'0.00\' as cantidad,
							\'0.00\' as subtotal
		      FROM
		          pro_producto a
		          inner join pro_producto_x_empresa b on a.c_producto=b.c_producto
		          and b.c_empresa='.$c_empresa.' and b.b_registro_activo=1 and a.b_registro_activo=1 ';
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
			//echo json_decode ($_POST['lstPro']) ;
			//print_r( ($_POST['lstPro']) );
			$someArray = json_decode($_POST['lstPro'], true);
			$sql="INSERT INTO venta_carrito_tmp(
					    c_item_carrito,
					    c_pedido,
					    c_empresa,
					    c_producto,
					    cant_producto,
					    v_precio,
					    v_subtotal,
					    d_cliente_nombre,
					    d_cliente_apellido,
					    d_telefono,
					    d_direccion,
					    d_direccion_referencia,
					    d_correo,
					    d_geolocalizacion,
							f_ingreso
					)
					VALUES
					";
			  //print_r($someArray);        // Dump all data of the Array
				$n=0;
				$time = time();

				//echo date("Ymd_H_i_s", $time);
				for ($i=0; $i <sizeof($someArray) ; $i++) {
					if($someArray[$i]["cantidad"]>0)
					{
						if($n>0)
						$sql.=" , ";

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
						    '".$_POST["ubicacion"]."', NOW() )";
								$n++;
						//echo $someArray[$i]["c_producto"]."<br/>";

					}
				}

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
									$respuesta='OK';
									$cuerpo=fcnLstProPed($_POST["telefono"]."_".date("Ymd_H_i_s", $time));
									enviaCorreoPedido('info@bfdtechnologies.info','Soporte',$cuerpo);
									//enviaCorreoPedido('gmoncada@bfdtechnologies.info','Gloria Moncada',$cuerpo);
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
				d_producto,
				cant_producto,
				v_precio,
				v_subtotal,
				concat(d_cliente_nombre,d_cliente_apellido) as cliente,
				b.d_desc_producto,
				b_pedido_recibido,
				b_pedido_entregado
				FROM `venta_carrito_tmp` a
				inner join pro_producto b on a.c_producto=b.c_producto
				where c_pedido='".$c_pedido."' ";

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
						while($resultados = mysqli_fetch_array($consulta)) {
							//$respuesta.= '<label>'.$resultados['d_producto'].'</label>								<br/>';

							$respuesta.= '
							<tr>
							<td>'.$resultados['c_producto'].'</td>
							<td>'.$resultados['d_producto'].'</td>
							<td>'.$resultados['d_desc_producto'].'</td>
							<td>'.$resultados['cant_producto'].'</td>
							<td>'.$resultados['v_precio'].'</td>
							<td>'.$resultados['v_subtotal'].'</td>
							</tr>';
							$total+=$resultados['v_subtotal'];
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
		  $para = $correo_destino;
		  //$para .= ' ,ferazo@bfdtechnologies.info';
		  //$para .= ' ,info@bfdtechnologies.info';


		  // título
		  $título = '.::|MERCADITO|::. - Nuevo Pedido';

		  // mensaje
		  //mensaje=$cuerpo;
		  $mensaje = '
		  <html>
		  <head>
		    <title>Han Realizado un Nuevo Pedido</title>
		  </head>
		  <body>
		    <p>¡Listado de Productos!</p>
		    <table class="table-bordered">
		      '.$cuerpo.'
		    </table>
		  </body>
		  </html>
		  ';


		  // Para enviar un correo HTML, debe establecerse la cabecera Content-type
		  $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		  $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		  // Cabeceras adicionales
		  $cabeceras .= 'To: '.$nombre_destino.' <'.$correo_destino.'>' . "\r\n";
		  $cabeceras .= 'From: .::|MERCADITO|::.<info@bfdtechnologies.info>' . "\r\n";
		  //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
		  $cabeceras.='Reply-To: .::|MERCADITO|::.<info@bfdtechnologies.info>' . "\r\n";
		  $cabeceras .= 'Bcc: Admin<ferazo@bfdtechnologies.info>' . "\r\n";

		  // Enviarlo

		  $success = mail($para, $título, $mensaje, $cabeceras);
		  if (!$success) {
		      $errorMessage = error_get_last()['message'];
					echo $errorMessage;
		  }
		}

		function fcnLstEmp()
		{
			require('conexion.php');
			$respuesta='';
			$sql='SELECT
					    c_empresa,
					    d_nombre_empresa,
					    d_direccion,
					    c_tipo_empresa,
					    c_rtn,
					    c_cai,
					    c_factura_inicial,
					    c_factura_final,
					    f_limite_fact,
					    c_usuario_ingreso,
					    f_ingreso,
					    c_usuario_modifico,
					    f_modifico,
					    b_registro_activo,
					    d_geolocalizacion,
					    n_contacto,
					    d_logo
					FROM
					    neg_empresa
					WHERE
					b_registro_activo=1';
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

								 $respuesta.='<div  style=" max-height: '.$porcentaje.'%;width:'.$porcentaje.'%;height:auto;" class="producto card form-control">
																<div class="form">
																	<!--<img src="https://bfdtechnologies.info/imagenes/'.$resultados['c_empresa'].'/'.$resultados['d_logo'].'" alt="Sin Imagen" style="width:100%"
																	width="200"
																 height="200">-->

																 <a href="https://bfdtechnologies.info/imagenes/'.$resultados['c_empresa'].'/'.$resultados['d_logo'].'"><img
																 src="https://bfdtechnologies.info/imagenes/'.$resultados['c_empresa'].'/'.$resultados['d_logo'].'"
																 alt="Sin Imagen" style="width:100%"
																 width="200"
																height="200"/></a>
																	<div class="container">
																		<h2 style="font-size: '.$fuente.'px;"> <center> <strong>'.$resultados['d_nombre_empresa'].' </strong></center> </h2>
																		<!--<strong>'.$resultados['d_direccion'].'</strong>-->
																	</div>
																		<div class="card-footer row" style="text:center">
																		<button type="submit" class="btn btn-success " style="color: white" onclick="stEmpPro(\''.$resultados['c_empresa'].'\',\''.$resultados['d_nombre_empresa'].'\')">
																			<i class="fas fa-check" style="color: white"></i>
																		</button>


																	</div>
																</div>
																</div>';
							}/*
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
 ?>
