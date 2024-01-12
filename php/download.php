<?php

    // helps in downloading the file

    // Check if the 'filename' parameter is set in the GET request.
    if (isset($_GET['filename'])) {
        $filename = $_GET['filename'];

        // Define the file path relative to the '../data/file' directory.
        $filePath = '../data/file' . $filename;

        // if the file exists, then download it.
        if (file_exists($filePath)) {

             // Set HTTP headers for the file download.
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            // Read and output the file content
            readfile($filePath);
            exit;
        } else {
            // Display an error message if the file is not found.
            echo 'File not found.';
        }
    } else {
        // Display an error message if the 'filename' parameter is missing.
        echo 'Filename parameter is missing.';
    }
    
?>
