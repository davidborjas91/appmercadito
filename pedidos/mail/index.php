
<?php

enviaCorreoPedido('ferazo@credisol.hn','DISTRIBUIDORA EL CEIBON',$asunto,'');

function enviaCorreoPedido($correo_destino,$nombre_destino,$cuerpo)
{
    // Varios destinatarios
    //$para  = 'erazo.favio@gmail.com' . ', '; // atención a la coma
    $para .= $correo_destino;
    $para .= ' ,ferazo@bfdtechnologies.info';
    $para .= ' ,info@bfdtechnologies.info';
    
    
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
      <p>¡Estos son los cumpleaños para Agosto!</p>
      <table>
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
    }
    echo $errorMessage;
}

?>
