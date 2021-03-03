<?php
session_start();

//$password = $_POST['pass'];
require_once ('conexion.php');
$tbl_name = "cli_usuarios_clientes";
/*
$host_db = "localhost";
$user_db = "root";
$pass_db = "";
$db_name = "controlac";
$tbl_name = "tbl_usuarios";

$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}*/

function getRealIP() {

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
}

$username = $_POST['usuario'];
$password = $_POST['pass'];
//print_r($_POST);
//$username = $_POST['datos'][0]["value"];
//$password = $_POST['datos'][1]["value"];

$sql = "SELECT * FROM $tbl_name WHERE c_usuario = '$username' and b_registro_activo in(1,-1)";
//echo "$sql";
if(!$db->conectar()){
       //echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../index.php?msg=Error al Conectarse a la base de datos!'>";
              echo "Error al Conectarse a la base de datos!";
  }else
  {
    //echo "No Se conecto";
    $result = $db->conexion->query($sql);
    if ($result->num_rows <1) {
      $db->conexion->query("INSERT INTO sist_log_login (c_usuario,f_ingreso,d_accion,d_dispositivo_navegador,d_direccion) VALUES ('".strtoupper($username)."',NOW(),'FALLO INGRESO','".$_SERVER['HTTP_USER_AGENT']."','".getRealIP()."')");
      $db->desconectar();
      //echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../index.php?msg=No se Encontro el Usuario o la cuenta esta inactiva!'>";
      echo "No se Encontro el Usuario o la cuenta esta inactiva!"; exit;
     }
     $row = $result->fetch_array(MYSQLI_ASSOC);
     //echo "$password";
     //echo("Verificacion >>".password_verify($password, "abc")." >>");
     if (password_verify($password,$row['d_pass'])) {

        $_SESSION['loggedin'] = true;
        //$_SESSION['username'] = strtoupper($username).",".$row['d_usuario'];
        $_SESSION['c_usuario'] = strtoupper($username);
        $_SESSION["nombre"] = $row['d_usuario'];
        $_SESSION["d_usuario"] = $row['d_usuario'];
        $_SESSION["c_cliente"] = $row['c_cliente'];
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (3600)*3;
        $_SESSION['menu']=0;
        $_SESSION['plataforma']='mercadito';
        $db->conexion->query("INSERT INTO sist_log_login (c_usuario,f_ingreso,d_accion,d_dispositivo_navegador,d_direccion) VALUES ('".strtoupper($username)."',NOW(),'INGRESO','".$_SERVER['HTTP_USER_AGENT']."','".getRealIP()."')");

        if(mysqli_error($db->conexion)!=""){
          echo "ERROR INSERTANDO BITACORA";
          echo mysqli_error($db->conexion)." Error";
          $db->conexion->rollback();
          //exit;
        }else {
          mysqli_commit($db->conexion);
        }
        //echo "INSERT INTO sist_log_login (c_usuario,f_ingreso,d_accion) VALUES ('".strtoupper($username)."',NOW(),'INGRESO')";
        //echo "Bienvenido! " . $_SESSION['username'];
        //echo "Bienvenido! ";
       // echo "<br><br><a href=panel-control.php>Panel de Control</a>";
       echo "OK";
        //echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../gui/index.php'>";

     } else {
       //echo "Username o Password estan incorrectos.";

       //echo "<br><a href='index.php'>Volver a Intentarlo</a>";
      //echo ("INSERT INTO sist_log_login (c_usuario,f_ingreso,d_accion,d_dispositivo_navegador,d_direccion) VALUES ('".strtoupper($username)."',NOW(),'FALLO INGRESO','".$_SERVER['HTTP_USER_AGENT']."','".getRealIP()."')");

        $db->conexion->query("INSERT INTO sist_log_login (c_usuario,f_ingreso,d_accion,d_dispositivo_navegador,d_direccion) VALUES ('".strtoupper($username)."',NOW(),'FALLO INGRESO','".$_SERVER['HTTP_USER_AGENT']."','".getRealIP()."')");
        if(mysqli_error($db->conexion)!=""){
          echo "ERROR INSERTANDO BITACORA";
          echo mysqli_error($db->conexion)." Error";
          $db->conexion->rollback();
          //exit;
        }else {
          mysqli_commit($db->conexion);
        }
        $db->desconectar();
       //echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../index.php?msg=Contraseña Incorrecta!'>";
      echo "Contraseña Incorrecta!";
     }
  }
 ?>
