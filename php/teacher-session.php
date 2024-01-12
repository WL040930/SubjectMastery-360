<?php

    // if the session is not started, start the session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    
    // if session id and role is not set, redirect to logout page to clear all the session
    if(!isset($_SESSION['id']) && !isset($_SESSION['role'])) {
        echo "<script> alert('Please Login First.');</script>";
        echo "<script> window.location.href='feature-logout.php' </script>";
    } else {
        // if role is not teacher, redirect to logout page, to clear all the session
        $role = $_SESSION['role'];
        if($role != 'teacher') {
            echo "<script> alert('You are not authorized to view this page.');</script>";
            echo "<script> window.location.href='feature-logout.php' </script>";
        }
    }

?>
