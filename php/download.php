<?php
if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];

    // Your logic to construct the file path goes here
    $filePath = '../data/file' . $filename;

    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        exit;
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Filename parameter is missing.';
}
?>
