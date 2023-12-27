<?php

    include "dbconn.php"; 
    include "admin-menu.php"; 
    include "admin-session.php"; 
    $id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
</head>
<body>
    
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
                    <img src="../data/image<?php echo $row['profile_picture']?>" style="max-width: 200px; max-height: 200px;"> <br>
                    <input type="file" name="profile_picture">
                </td>
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
    <a href="admin-manageuser.php"><button type="button">Back</button></a>
    <?php } ?>

</body>
</html>

<?php

    if(isset($_POST['submit'])){
        $username = $_POST['username']; 
        $firstname = $_POST['firstname']; 
        $lastname = $_POST['lastname']; 
        $password = $_POST['password']; 
        $institute = $_POST['institute']; 
        if(!empty($username) && !empty($firstname) && !empty($lastname) && !empty($password)) {
            $query = "UPDATE `user` SET `username`='$username',`user_first_name`='$firstname',`user_last_name`='$lastname',`password`='$password',`institute_name`='$institute' WHERE user_id = '$id'"; 
            if(mysqli_query($connection, $query)) {
                echo "<script>alert('Record updated Successfully')</script>";
                echo "<script>window.location.href='admin-manageuser.php';</script>";
            } else {
                echo "Record update unsuccessful, please try again.";
            }
        } else {
            echo "Username, First Name, Last Name and Password cannot be null.";
        }
    }
//CHECK ADMIN PROBLEM 
?>

