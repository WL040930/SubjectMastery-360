<?php

    // helps in logging out the user
    session_start();
    session_unset();
    session_destroy();
    header("Location: feature-login.php");

?>