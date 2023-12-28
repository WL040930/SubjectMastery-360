<?php

    session_start();

    if (!isset($_SESSION['role']) || $_SESSION['role'] != "teacher") {
        echo "<script> alert('You are not a teacher, please proceed to login.') </script>";
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }

?>
