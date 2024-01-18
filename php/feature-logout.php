<?php

    // helps in logging out the user
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    session_unset();
    session_destroy();
    header("Location: feature-login.php");

?>