<?php

    include "dbconn.php"; 
    session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="icon" href="../image/icon.png">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">

</head>

<body>
    <div id="container">
        <h1>Register Your Account</h1>
        <div><p>Register your account here by filling in your information</p></div>
        <br>
        <form action="#" method="post" onsubmit="return register_validation()">

            <div class="inp-box">
                <label for="Username"><b>Username: </b><font color="red">*</font></label>
                <input type="text" name="username" id="username" placeholder="Enter Username">
            </div>

            <div class="inp-box">
                <label for="first_name"><b>First Name: </b><font color="red">*</font></label>
                <input type="text" name="first_name" id="first_name" placeholder="Enter First Name">
            </div>

            <div class="inp-box">
                <label for="last_name"><b>Last Name: </b><font color="red">*</font></label>
                <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name">
            </div>

            <div class="inp-box">
                <label for="email"><b>Email: </b><font color="red">*</font></label>
                <input type="email" name="email" id="email" placeholder="Enter Email">
            </div>

            <div class="inp-box">
                <label for="institute_name"><b>Institute name: </b></label>
                <input type="text" name="institute_name" id="institute_name" placeholder="Enter Institute Name">
            </div>

            <div class="inp-box">
                <label for="password"><b>Password: </b><font color="red">*</font></label>
                <input type="password" name="password" id="password" placeholder="Enter Password">
            </div>

            <div class="inp-box">
                <label for="confirm_password"><b>Confirm Password: </b><font color="red">*</font></label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password">
            </div>

            <div class="validate-message"></div>
            <div class="inp-box">
                <input type="submit" name="submit" value="Register" id="submit_button">
            </div>

            <div class="inp-box">
                Already have an account? <a href="feature-login.php"><b>Login here.</b></a>
            </div>
        </form>
    </div>

    <script src="../script/register_validation.js"></script>
</body>
</html>

<?php

    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $institute_name = $_POST['institute_name'];
        $query = "INSERT INTO `user`(`username`, `user_first_name`, `user_last_name`, `email_address`, `password`, `institute_name`) VALUES ('$username','$first_name','$last_name','$email','$password','$institute_name')";
        if(mysqli_query($connection, $query)){
            $fetch = " SELECT user.*, role.*
                        FROM user
                        INNER JOIN
                        role ON user.role_id = role.role_id
                        WHERE email_address = '$email' AND password='$password'"; 
            $result = mysqli_query($connection, $fetch); 
            $row = mysqli_fetch_assoc($result);  
            $_SESSION['id'] = $row['user_id'];
            $_SESSION['username'] = $row['username']; 
            $_SESSION['email'] = $row['email_address'];
            $_SESSION['role'] = $row['role']; 
            echo "<script>alert('Registration Successful!')</script>";
            echo "<script>
                    var wantToAddPicture = confirm('Do you want to add a profile picture after registration?');

                    if (wantToAddPicture) {
                        window.location.href='feature-profilepicture.php';
                    } else {
                        window.location.href='feature-login.php';
                    }
                    </script>";
            exit(); 
        } else {
            echo "<script>alert('Registration Failed!')</script>";
        }
    }
    

?> 