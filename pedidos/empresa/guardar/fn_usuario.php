<?php
require('../../core/conexion.php');
session_start();

$valor = $_POST['valor'];

if(!empty($_FILES['file']['name'])){
    $conex = new db();
    $c_cliente = $_SESSION["c_cliente"];
    $uploadedFile = '';
    if(!empty($_FILES["file"]["type"])){
        $fileName = time().'_'.$_FILES['file']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['file']['tmp_name'];
            $targetPath = "../../img/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $uploadedFile = $fileName;

                $queryInst = "UPDATE cli_usuarios_clientes_info SET 
                        d_imagen_usuario='$uploadedFile'
                    WHERE c_cliente='$c_cliente';";
                $conex->insertar($queryInst, array());
            }
        }
    }
    echo json_encode($uploadedFile);
}

if($valor == '1'){
    try {
        $conex = new db();
    
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $tel = $_POST['tel'];
        $c_cliente = $_SESSION["c_cliente"];
        $respuesta = '';

        $queryInst = "UPDATE cli_usuarios_clientes_info SET 
                        nombre='$firstName',
                        apellido='$lastName',
                        telefono='$tel',
                        f_modifico=NOW(),
                        c_usuario_modifico='$c_cliente'
                    WHERE c_cliente='$c_cliente';";
    
        $conex->insertar($queryInst, array());	
    
        $json_data = array("draw" => "TRUE");
    
        echo json_encode($json_data);
        
        $conex->desconectar();
    }catch(PDOException $e){
        echo json_encode($e->getMessage());
    }
}elseif($valor == '2'){
    try{
        $c_cliente = $_SESSION["c_cliente"];
        $latitud = $_POST['latitud'];	
        $longitud = $_POST['longitud'];
        $address = $_POST['address'];
        $descrip = $_POST['descrip']; 
    
        $conex = new db();
       
        $query1 = "UPDATE cli_usuarios_direccion SET principal=0 WHERE c_cliente='$c_cliente'";
        $conex->insertar($query1, array());
    
        $sql = "INSERT INTO cli_usuarios_direccion(c_cliente,descripcion,direccion,latitud,longitud,b_registro_activo,principal) VALUES ($c_cliente,'$descrip','$address','$latitud','$longitud',1,1)";
    
        $conex->insertar($sql, array());	
    
        $json_data = array("draw" => "1");
    
        echo json_encode($json_data);
        
        $conex->desconectar();
    }catch(PDOException $e){
        echo json_encode($e->getMessage());
    }
}elseif($valor == '3'){
    try{
        $c_cliente = $_SESSION["c_cliente"];
        $values = $_POST['values']; 
    
        $conex = new db();
       
        $query1 = "UPDATE cli_usuarios_direccion SET b_registro_activo=0 WHERE c_cliente='$c_cliente' AND id_direccion='$values'";
        $conex->insertar($query1, array());	

        $direccion = "SELECT * 
            FROM cli_usuarios_direccion 
            WHERE c_cliente='$c_cliente' AND b_registro_activo=1;";
        $SQLdireccion = $conex->getFilas($direccion, array());
    
        $json_data = array("direccion" => $SQLdireccion);
    
        echo json_encode($json_data);
        
        $conex->desconectar();
    }catch(PDOException $e){
        echo json_encode($e->getMessage());
    }
}

?>