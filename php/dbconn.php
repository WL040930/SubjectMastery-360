<?php

    //database connection parameter
    $hostname = 'localhost';
    $username = 'root'; 
    $password = '';
    $database = 'subjectmastery360';

    //connect to database using mysqli
    $connection = mysqli_connect($hostname, $username, $password, $database);

    //check the connection of database
    if(!$connection){
        die("Connection failed: " . mysqli_connect_error());
    }

?>