<?php
    //connection database
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Account</title>
    <link rel="icon" href="../image/feedback.png">
    <link rel="stylesheet" href="../css/feedbackbutton.css">
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>

    <div id="container">

        <div id="header">
            <h1 align="center">SUBJECT MASTERY 360</h1>
            <h2 align="center">SIGN UP</h2>
        </div>

        <div id="data-entry">
            <form action="" method="post">
                <div class="box">
                    <label for="username">Username: <font color="red">*</font></label>
                    <input type="text" name="username" id="username" placeholder="Username" required>
                </div>
                <div class="box">
                    <label for="firstname">First Name: <font color="red">*</font></label>
                    <input type="text" name="firstname" id="firstname" placeholder="First Name" required>
                </div>
                <div class="box">
                    <label for="lastname">Last Name: <font color="red">*</font></label>
                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" required>
                </div>
                <div class="box">
                    <label for="email">Email Address: <font color="red">*</font></label>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="box">
                    <label for="password">Password: <font color="red">*</font></label>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>
                <div class="box">
                    <label for="confirm_password">Confirm Password: <font color="red">*</font></label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                </div>
                <div class="box">
                    <label for="institute_name">Institute Name: </label>
                    <input type="text" name="institute_name" id="institute_name" placeholder="Institute Name">
                </div>
        </div>

        <div id="submit-field">
                <input type="submit" value="Register" id="submit" name="submit">
                <div class="login-text">Already have an account? <a href="login.php">Login here.</a>
            </form>
        </div>

        <div id="reset"></div>

        <div id="feedback">
            <a href="feedback.php" id="feedback-link">
                <img src="../image/feedback.png" alt="Feedback" title="Click Here to Leave Feedback" id="feedback-image">
            </a>
        </div>

    </div>

</body>

</html>
