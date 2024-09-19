<?php
$token = '9ddb217208706f45b00621273d94d54373e913dbe4c1192d04885ead295d0f76143a4b23b92a7f7415d33bcb093a2e197a66e174e7498ee56db7ff88793cd0ba1cb9441c5c2e76eabe8fedf7c3863df10fbe2ffcc69c3a1532f663fb59bf733bcc736c359275f6274b56b5045857bf6034a61e0dd32fd357fff02b210bcdf4ae';

$idNumber = $_POST['idNumber'];
$today = date('l, d M Y');
$CreateOrder = "https://lawyer.iqdesk.xyz/api/orders";
$data = [
    "data" => [
        "Order_name" => "$today"
    ]
];

// Initialize cURL session
$ch = curl_init($CreateOrder);

// Set the request method to POST
curl_setopt($ch, CURLOPT_POST, true);

// Set the request headers
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $token"
]);

// Set the request body
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Decode the JSON response
    $jsonResponse = json_decode($response, true);
    // Print the response
   // print_r($jsonResponse);
}

// Close the cURL session
curl_close($ch);

$OrderId = $jsonResponse['data']['id'];

$CreatePdfURL = "http://igov.iqdesk.xyz:8080/igov/request";

$createData = [
    "requestId" => $OrderId,
    "idNumber" => $idNumber,
    "requestEmail" => "lawgicalre@gmail.com"
];
    $ch = curl_init($CreatePdfURL);

    // Set the request method to POST
    curl_setopt($ch, CURLOPT_POST, true);
    
    // Set the request headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    
    // Set the request body
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($createData));
    
    // Return the response as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute the cURL request
    $response = curl_exec($ch);
    
    // Check for errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Decode the JSON response
        $jsonResponse = json_decode($response, true);
        // Print the response
        print_r($jsonResponse);
    }
    
    // Close the cURL session
    curl_close($ch);