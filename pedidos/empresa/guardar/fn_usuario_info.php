<?php
require('../../core/conexion.php');
session_start();
try {
    $db = new db();

    /*if (!$db->conectar()) {
        $respuesta = "No Se conecto";
    }*/

    $c_cliente = $_SESSION["c_cliente"];
    //echo "/".$c_cliente;
    $sql = "SELECT 
                a.c_usuario,
                b.nombre,
                b.apellido,
                b.telefono,
                CONCAT('../img/', b.d_imagen_usuario)AS img
            FROM cli_usuarios_clientes a
            INNER JOIN cli_usuarios_clientes_info b ON a.c_cliente=b.c_cliente
            WHERE a.c_cliente='$c_cliente';";
    
    $direccion = "SELECT * 
            FROM cli_usuarios_direccion 
            WHERE c_cliente='$c_cliente' AND b_registro_activo=1;";

    /*$consulta = $db->conexion->query($sql);

    while ($resultados = mysqli_fetch_array($consulta)) {

        $json_data = array(
            "nombre" => $resultados['nombre'],
            "apellido" => $resultados['apellido'],
            "telefono" => $resultados['telefono'],
        );
    }*/

    $query = $db->getFilas($sql, array());
    $SQLdireccion = $db->getFilas($direccion, array());

	$json_data = array(
                        "data" => $query,
                        "direccion" => $SQLdireccion);

    echo json_encode($json_data);

    $db->desconectar();
	//$mysqli->close();


}catch(PDOException $e){
	echo json_encode($e->getMessage());
}
?>