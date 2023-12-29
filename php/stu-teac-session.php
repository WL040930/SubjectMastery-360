<?php

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION['id']) && !isset($_SESSION['role'])) {
        echo "<script> alert('Please Login First.');</script>";
        echo "<script> window.location.href='logout.php' </script>";
    }

?>