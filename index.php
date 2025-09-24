<?php
// Asegura método y valores por defecto
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$sessionId   = $_POST['sessionId']   ?? '';
$serviceCode = $_POST['serviceCode'] ?? '';
$phoneNumber = $_POST['phoneNumber'] ?? '';
$text        = $_POST['text']        ?? '';

if ($method !== 'POST') {
  // Si abres la app en el navegador, verás esto (para verificar que el dyno está vivo)
  header('Content-Type: text/plain');
  echo "USSD endpoint OK. Use POST desde el gateway.\n";
  exit;
}

header('Content-Type: text/plain');

if ($text === '') {
  // MENU 1
  $response  = "CON Seleccione una Opción:\n";
  $response .= "1- Hacer Transferencia\n";
 // $response .= "2- Número de Teléfono\n";

} elseif ($text === '1') {
    //MENU 2
  $response  = "CON Seleccione el método de identificación del beneficiario:\n";
  $response .= "1- Número de Cuenta\n";
  $response .= "2- Número de teléfono asociado\n";

} elseif ($text === '1*2') {
  $response = "CON Introduzca el número de teléfono asociado (digitos únicamente): " ;

} elseif ($text === '1*1') {
    //1- Número de Cuenta
 
  $response = "CON Introduzca el número de cuenta (digitos únicamente): " ;

} elseif (preg_match('/^1\*[12]\*[^*]+$/', $text)) {
    // 1*1*<cuenta>  -> acaba de capturar la cuen]ta/telefono
    $parts = explode('*', $text);
    $tipo = ($parts[1] === '1') ? 'Numero de cuenta' : 'Teléfono';
    $idSelected = $parts[2];

    // Muestra el siguiente menú 
    $response  = "CON  {$tipo} capturado: {$idSelected}\n";
    $response .= "1. Continuar";
}
elseif (preg_match('/^1\*[12]\*[^*]+\*1$/', $text)) {
    // 1*1*<cuenta>*1 -> eligió continuar
     $response = "CON Introduzca el monto a transferir en pesos mexicanos (digitos únicamente): " ;
}elseif (preg_match('/^1\*[12]\*[^*]+\*1\*[^*]+$/', $text)) {
    // 1*1*<cuenta>*1*<monto> -> eligió continuar
     $parts = explode('*', $text);
     $monto = $parts[4];
     $accountNumber = $parts[2];

    // Muestra el siguiente menú 
    $response  = "CON El número de cuenta: {$accountNumber}. Cantidad: {$monto} \n";
     $response .= "1. Continuar";

}elseif (preg_match('/^1\*[12]\*[^*]+\*1\*[^*]+\*1$/', $text)) {
     // 1*1*<cuenta>*1*<monto>*1 -> eligió continuar
     $response  = "CON Ingresa tu PIN de seguridad. \n";
    
}elseif (preg_match('/^1\*[12]\*[^*]+\*1\*[^*]+\*1\*[^*]+$/', $text)) {
     // 1*1*<cuenta>*1*<monto>*1*<pin< -> eligió continuar
    $parts = explode('*', $text);
    $monto = $parts[4];
    $accountNumber = $parts[2];
    $pin = $parts[6];

    $response  = "CON Se realizará una transferencia a: {$accountNumber}, de valor: {$monto}. \n";
    $response .= "1. CONFIRMAR";
    
}elseif (preg_match('/^1\*[12]\*[^*]+\*1\*[^*]+\*1\*[^*]+\*1$/', $text)) {
     // 1*1*<cuenta>*1*<monto>*1*<pin<*1 -> eligió continuar
   

    $response  = "END Transacción Realizada Correctamente. \n";
    
}

echo $response;
