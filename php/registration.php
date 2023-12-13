<?php

    include "dbconn.php"; 
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Account</title>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="../css/feedbackbutton.css">
    <link rel="icon" href="../image/logo.png"> <!--put icon here-->

</head>

<body>
    <div id="container">
        <h1>Register Your Acount</h1>
        <div><p>Register your account here by filling in your information</p></div>
        <br>
        <form action="#" method="post" onsubmit="return register_validation()">

            <div class="inp-box">
                <label for="Username">Username: <font color="red">*</font></label>
                <input type="text" name="username" id="username" placeholder="Enter Username">
            </div>

            <div class="inp-box">
                <label for="first_name">First Name: <font color="red">*</font></label>
                <input type="text" name="first_name" id="first_name" placeholder="Enter First Name">
            </div>

            <div class="inp-box">
                <label for="last_name">Last Name: <font color="red">*</font></label>
                <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name">
            </div>

            <div class="inp-box">
                <label for="email">Email: <font color="red">*</font></label>
                <input type="email" name="email" id="email" placeholder="Enter Email">
            </div>

            <div class="inp-box">
                <label for="institute_name">Institute name: </label>
                <input type="text" name="institute_name" id="institute_name" placeholder="Enter Institute Name">
            </div>

            <div class="inp-box">
                <label for="password">Password: <font color="red">*</font></label>
                <input type="password" name="password" id="password" placeholder="Enter Password">
            </div>

            <div class="inp-box">
                <label for="confirm_password">Confirm Password: <font color="red">*</font></label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password">
            </div>

            <div class="validate-message"></div>
            <div class="inp-box">
                <input type="submit" name="submit" value="Register">
            </div>

            <div class="inp-box">
                Already have an account? <a href="login.php">Login here.</a>
            </div>
        </form>
    </div>

    <div id="feedback">
        <a href="feedback.php" id="feedback-link">
            <img src="../image/feedback.png" alt="Feedback" title="Click Here to Leave Feedback" id="feedback-image">
        </a>
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
            echo "<script>alert('Registration Successful!')</script>";
            header(Location: "feedbackbutton.php");
        } else {
            echo "<script>alert('Registration Failed!')</script>";
        }
        }
    

?> 