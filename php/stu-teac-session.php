<?php

    // if session is not started, start session
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // check if user is logged in
    if(!isset($_SESSION['id']) && !isset($_SESSION['role'])) {
        echo "<script> alert('Please Login First.');</script>";
        echo "<script> window.location.href='feature-logout.php' </script>";
    }

?>