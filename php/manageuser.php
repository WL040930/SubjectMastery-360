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

<style>
    #result-box {
        width: 80%; 
        height: 100%;
        margin: auto;
        margin-top: 20px;
        border: 1px solid black;
        border-radius: 10px;
        padding: 10px;
        background-color: #f2f2f2;
    }
</style>

<body>
    <div id="header">
        <div><img src="../image/logo.png" height="100px"> </div>
        <div> <h1>Welcome, <?php echo $_SESSION['admin']; } ?></h1></div>
    </div>
    <br>
    <ul> 
        <li><a href="manageuser.php" disable>Manage User</a></li>
        <li><a href="database.php">Database</a></li>
        <li><a href="adminfeedback.php">Feedback</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>   

    <div id="search-box">
        <form action="" method="get">
            <input type="text" name="email" placeholder="Enter Email to Search"> <br>
            <input type="submit" value="Search" name="btnSearch">
        </form>
    </div>

    <?php 
        if(isset($_GET['btnSearch'])) {
            $email = $_GET['email'];
            if(!empty($email)) {
                $query = "SELECT * FROM user WHERE email_address LIKE '%$email' OR email_address LIKE '%$email%' OR email_address LIKE '$email%'";
                $result = mysqli_query($connection, $query);
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) { ?>

    <div id="search-result">
        <div id="result-box">
            <a href="manageprofile.php?id=<?php echo $row['user_id'];?>">
                <div>
                    <?php echo $row['username'] ; ?>
                </div>
                <div>
                    <?php echo $row['email_address'] ; ?>
                </div>
            </a>
        </div>                
    </div>

<?php
                    }
                } else {
                    echo "<script>alert('Please enter email');</script>";   
                }
            }
        }
    
    mysqli_close($connection);

?>

</body>

</html>