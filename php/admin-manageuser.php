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
    <title>Admin - Manage User</title>
    <link rel="stylesheet" href="../css/adminmenu.css">
    <link rel="stylesheet" href="../css/admin-manageuser.css">
</head>
<body id="all">
    <div id="search-box">
        <form action="" method="get">
            <input type="text" name="email" placeholder="Enter Email to Search" id="search"> <br>
            <input type="submit" value="Search" name="btnSearch" id="search_button"><br><br>
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
                    echo '<div id="error_msg">ERROR: No Result  Found :(</div>';   
                }
            } else {
                echo '<div id="error_msg">ERROR: Please Enter Your Email Address !</div>';
            }
        }
    
    mysqli_close($connection);

?>
</body>

</html>