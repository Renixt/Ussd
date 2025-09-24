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

//} elseif ($text === '2') {
 // $response = "END Tu número de teléfono es: " . $phoneNumber;

} elseif ($text === '1*1') {
    //1- Número de Cuenta
 
  $response = "CON Introduzca el número de cuenta (digitos únicamente): " ;

} elseif (substr($text, 0, 4) === '1*1*') {
    // Aquí el usuario ya ingresó algo después de 1*1
    $accountNumber = explode('*', $text)[2]; // Toma lo que está después de 1*1
    $response = "CON Tu número de cuenta capturado es: " . $accountNumber;
    $text = substr($text, 0, 3); //regresa text a 1*1*
    $response = "CON Ingresa '1' para continuar" .$text + " + "  .$accountNumber;
} elseif ($text === '1*1*1') {
        $response = "END Codigo actual:" .$text ;



}

echo $response;
