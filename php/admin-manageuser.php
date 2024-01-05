<?php

    // Include the database connection file
    include "dbconn.php"; 

    // Include the admin menu file
    include "admin-menu.php"; 

    // Include the admin session file
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
        // Check if the Search button is clicked
        if(isset($_GET['btnSearch'])) {
            $email = $_GET['email'];
            if(!empty($email)) {

                // Query to search for users based on the entered email
                $query = "SELECT * FROM user WHERE email_address LIKE '%$email' OR email_address LIKE '%$email%' OR email_address LIKE '$email%'";
                $result = mysqli_query($connection, $query);

                // Check if there are any results
                if(mysqli_num_rows($result) > 0) {

                     // Display search results
                    while($row = mysqli_fetch_assoc($result)) { 
    ?>

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
                    // Display an error message if no results are found
                    echo '<div id="error_msg">ERROR: No Result  Found :(</div>';   
                }
            } else {
                // Display an error message if no email is entered
                echo '<div id="error_msg">ERROR: Please Enter Your Email Address !</div>';
            }
        }
    
    mysqli_close($connection);

    ?>
</body>

</html>