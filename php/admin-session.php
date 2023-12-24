<?php
    session_start();
    if(isset($_SESSION['admin']) == null) {
        echo "<script>alert('Authorized Access only!')</script>";
        echo "<script>window.location.href='login.php';</script>";
    }
?>