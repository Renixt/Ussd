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
  // Primer request
  $response  = "CON ¿Qué deseas consultar?\n";
  $response .= "1- Número de Cuenta\n";
  $response .= "2- Número de Teléfono\n";

} elseif ($text === '1') {
  $response  = "CON Selecciona una opción:\n";
  $response .= "1- Número de Cuenta\n";
  $response .= "2- Balance de Cuenta\n";

} elseif ($text === '2') {
  $response = "END Tu número de teléfono es: " . $phoneNumber;

} elseif ($text === '1*1') {
  $accountNumber = "AC001";
  $response = "END Tu número de CUENTA es: " . $accountNumber;

} elseif ($text === '1*2') {
  $balance = "10,000";
  $response = "END Tu balance es: " . $balance;

} else {
  // Opción no reconocida
  $response  = "CON Opción no válida.\n";
  $response .= "1- Número de Cuenta\n";
  $response .= "2- Número de Teléfono\n";
}

echo $response;
