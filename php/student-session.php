<?php

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION['id']) && !isset($_SESSION['role'])) {
        echo "<script> alert('Please Login First.');</script>";
        echo "<script> window.location.href='feature-logout.php' </script>";
    } else {
        $role = $_SESSION['role'];
        if($role != 'student') {
            echo "<script> alert('You are not authorized to view this page.');</script>";
            echo "<script> window.location.href='feature-logout.php' </script>";
        }
    }

?>