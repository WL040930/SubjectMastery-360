<?php

    include "dbconn.php"; 
    session_start();
    $id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <link rel="stylesheet" href="../css/adminmenu.css">
</head>
<body>
    <div id="header">
        <div><img src="../image/logo.png" height="100px"> </div>
        <div> <h1>Welcome</h1></div>
    </div>
    <br>
    <ul> 
        <li><a href="manageuser.php" disable>Manage User</a></li>
        <li><a href="database.php">Database</a></li>
        <li><a href="adminfeedback.php">Feedback</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    
    <form action="" method="post">

    <?php
        $query = "SELECT * FROM user WHERE user_id = '$id'";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
    ?>

        <table border = "1">
            <tr>
                <td colspan="2">
                    profile picture
                </td>
            </tr>
            <tr>
                <td>ID</td>
                <td> <?php echo $row['user_id']; ?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td> <input type="text" name="username" value="<?php echo $row['username'];?>"></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td> <input type="text" name="firstname" value="<?php echo $row['user_first_name']; ?>"></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td> <input type="text" name="lastname" value="<?php echo $row['user_last_name']; ?>"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td> <input type="text" name="password" value="<?php echo $row['password']; ?>"></td>
            </tr>
            <tr>
                <td>Institute Name</td>
                <td> <input type="text" name="institute" value="<?php echo $row['institute_name'];?>"></td>
            </tr>
        </table>

        <input type="submit" name="submit" value="submit">
    </form>
    
    <?php } ?>

</body>
</html>

<?php

    if(isset($_POST['submit'])){
        
    }

?>