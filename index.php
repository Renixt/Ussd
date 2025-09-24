<?php 
//lee las variables enviadas via POST de AT gateway
$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$sessionId = $_POST["text"];

if($text == ""){
    //Primer request, la respuesta empieza con CON
    $response = "CON ¿Que deseas consultar? \n";
    $response = "1- Numero de Cuenta \n";
    $response = "2- Numero de Telefono \n";
}else if($text == "1"){
    $response = "CON Selecciona una opción. \n";
    $response = "1- Numero de Cuenta \n";
    $response = "2- Balance de Cuenta\n";
}else if($text == "2"){
    //terminal response, empieza con END
    $response = "END Tu numero de telefono es: " .$phoneNumber;
}else if($text == "1*1"){
    //respuesta de segundo nivel, porque el user selecciono 1 en la primera instancia
    $accountNumber = "AC001";
    $response = "END Tu numero de CUENTA es: " .$accountNumber;
}else if($text == "1*2"){
    //respuesta de segundo nivel, porque el user selecciono 1 en la primera instancia
    $balance = "10,000";
    $response = "END Tu balance es: " .$balance;
}

//echo la respuesta a la API. La respuesta depende en el numero seleccionado en cada instancia
header('Content-type; text/plain');
echo $response;






?>