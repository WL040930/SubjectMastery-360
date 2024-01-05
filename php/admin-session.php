<?php

    //check whether the session is started or not
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //check whether the user has login or not
    if(!isset($_SESSION['id']) && !isset($_SESSION['role'])) {
        echo "<script> alert('Please Login First.');</script>";
        echo "<script> window.location.href='feature-logout.php' </script>";
    } else {
        //Get the role from session
        $role = $_SESSION['role'];

        //if the user not admin, then redirect user to logout page
        if($role != 'admin') {
            echo "<script> alert('You are not authorized to view this page.');</script>";
            echo "<script> window.location.href='feature-logout.php' </script>";
        }
    }

?>

