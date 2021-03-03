<?php

session_start();

function getRealIP() {

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
}
require_once ('conexion.php');
if(!$db->conectar()){
}else 
{
	$username=$_SESSION['c_usuario'];
	$db->conexion->query("INSERT INTO sist_log_login (c_usuario,f_ingreso,d_accion,d_dispositivo_navegador,d_direccion) VALUES ('".strtoupper($username)."',NOW(),'SALIDA','".$_SERVER['HTTP_USER_AGENT']."','".getRealIP()."')");  
	$db->desconectar();
}
unset ($SESSION['username']);
session_destroy();
header('Location: ../../index.php');

?>