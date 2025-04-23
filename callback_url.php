<?php
header("Content-Type: application/json");

$response = [
    "ResultCode" => 0,
    "ResultDesc" => "Confirmation Received Successfully"
];

// Capture M-PESA response
$mpesaResponse = file_get_contents('php://input');

// Log the response
$logFile = "M_PESAConfirmationResponse.txt";
$log = fopen($logFile, "a");
fwrite($log, $mpesaResponse);
fclose($log);

// Send response
echo json_encode($response);
?>
