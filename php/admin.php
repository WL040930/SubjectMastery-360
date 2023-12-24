<?php

    include "dbconn.php"; 
    session_start();
    if(isset($_SESSION['admin']) == null) {
        echo "<script>alert('Authorized Access only!')</script>";
        echo "<script>window.location.href='../login.php';</script>";
    } else {

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    /* Make the ul into menu bar and make it looks nice */
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
    }

    li {
        float: left;
    }

    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li a:hover:not(.active) {
        background-color: #111;
    }

    .active {
        background-color: #4CAF50;
    }

    /* split the space between menu section equally */
    ul {
        display: flex;
        justify-content: space-around;
    }
    ul li {
        flex: 1;
    }
    ul li a {
        flex: 1;
    }
</style>


<body>
    <div id="header">
        <div><img src="../image/logo.png" height="100px"> </div>
        <div> <h1>Welcome, <?php echo $_SESSION['admin']; }?></h1></div>
    </div>
    <br>
    <ul> 
        <li><a href="manageuser.php">Manage User</a></li>
        <li><a href="database.php">Database</a></li>
        <li><a href="adminfeedback.php">Feedback</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>   
</body>
</html>