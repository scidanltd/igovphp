<?php
//$docURL = "/opt/igov/download/BrowseResult34590478.pdf";
$docURL = isset($_GET['filename']) ? $_GET['filename'] : 'default.pdf';

if (file_exists($docURL)) {
    $name = "pdf.pdf";

    // Set headers to serve the PDF file for download
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $name . '"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    header('Content-Length: ' . filesize($docURL));

    // Read the file and output it to the browser
    @readfile($docURL);
    exit;
} else {
    echo "File not found.";
}
?>