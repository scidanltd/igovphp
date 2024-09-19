<!DOCTYPE html>

<html>

<head>
    <title>iGOV</title>
     <script>
        function openPopup(filename) {
            var url = "openFile.php?filename=" + encodeURIComponent(filename); // URL with the filename parameter
            var windowName = "popupWindow"; // Name of the popup window
            var windowFeatures = "width=600,height=400,resizable=yes,scrollbars=yes"; // Features of the popup

            window.open(url, windowName, windowFeatures);
        }
    </script>
</head>

<body>
    <form action="create_pdf.php" method="post">
            <input type="text" name="idNumber" placeholder="הכנס תעודת זהות" />
            <input type="submit" />

    </form>
<?php

$token = '9ddb217208706f45b00621273d94d54373e913dbe4c1192d04885ead295d0f76143a4b23b92a7f7415d33bcb093a2e197a66e174e7498ee56db7ff88793cd0ba1cb9441c5c2e76eabe8fedf7c3863df10fbe2ffcc69c3a1532f663fb59bf733bcc736c359275f6274b56b5045857bf6034a61e0dd32fd357fff02b210bcdf4ae';
$getOrders = "https://lawyer.iqdesk.xyz/api/orders";
$ch = curl_init();

// Set the URL
curl_setopt($ch, CURLOPT_URL, $getOrders);

// Set the request headers
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $token"
]);

// Set cURL to return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Decode the JSON response
    $dataArray = json_decode($response, true);

// Check if the response is correctly decoded
if (json_last_error() === JSON_ERROR_NONE) {
    // Output the JSON response
    echo '<pre>';
    //print_r($jsonResponse);
    echo '</pre>';
} else {
    echo 'JSON decode error: ' . json_last_error_msg();
}
}

// Close the cURL session
curl_close($ch);

// Start generating the HTML table
echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>Order Name</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Published At</th>
        <th>Request Status</th>
        <th>Document URL</th>
        <th>Receipt URL</th>
      </tr>";

// Loop through the data and populate the table rows
foreach ($dataArray['data'] as $item) {
    $id = $item['id'];
    $attributes = $item['attributes'];
    $orderName = $attributes['Order_name'] ?? 'N/A';
    $createdAt = $attributes['createdAt'];
    $updatedAt = $attributes['updatedAt'];
    $publishedAt = $attributes['publishedAt'];
    $requestStatus = $attributes['requestStatus'] ?? 'N/A';
    $docURL = $attributes['docURL'] ?? 'N/A';
    $receiptURL = $attributes['receiptURL'] ?? 'N/A';

    echo "<tr>
            <td>$id</td>
            <td>$orderName</td>
            <td>$createdAt</td>
            <td>$updatedAt</td>
            <td>$publishedAt</td>
            <td>$requestStatus</td>
            <td><button onclick=\"openPopup('".$docURL."')\">Download PDF</button></td>
            <td>$receiptURL</td>
          </tr>";
}

// Close the HTML table
echo "</table>";
?>
</body>
</html>