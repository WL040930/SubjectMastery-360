<?php

    include "dbconn.php"; 
    include "admin-menu.php"; 
    include "admin-session.php"; 

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
            <a href="admin-manageprofile.php?id=<?php echo $row['user_id'];?>">
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
                    echo "No result Found";   
                }
            } else {
                echo "Please Enter Email Address";
            }
        }
    
    mysqli_close($connection);

?>

</body>

</html>