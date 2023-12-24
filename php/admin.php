<?php

    include "dbconn.php"; 
    session_start();
    if(isset($_SESSION['admin']) == null) {
        echo "<script>alert('Authorized Access only!')</script>";
        echo "<script>window.location.href='login.php';</script>";
    } else {

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page - Admin</title>
    <link rel="stylesheet" href="../css/adminmenu.css">
</head>


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