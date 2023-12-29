<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SESSION['role'] == 'teacher' && isset($_SESSION['admin'])) {
        echo "<script> alert('There is an error in your session, please login again.') </script>"; 
        echo "<script> window.location.href='logout.php' </script>";
        exit();
    }

    if (!isset($_SESSION['role']) || $_SESSION['role'] != "teacher") {
        echo "<script> alert('You are not a teacher, please proceed to login.') </script>";
        echo "<script>window.location.href='logout.php';</script>";
        exit();
    }

?>
