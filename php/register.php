<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Account</title>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="icon" href="###"> <!--put icon here-->
</head>

<body>
    <div id="container">
        <h1>Register Your Acount</h1>
        <div><p>Register your account here by filling in your information</p></div>
        <br>
        <form action="login.php" method="post" onsubmit="return register_validation()">

            <div class="inp-box">
                <label for="Username">Username: <font color="red">*</font></label>
                <input type="text" name="username" id="username" placeholder="Enter Username" required>
            </div>

            <div class="inp-box">
                <label for="first_name">First Name: <font color="red">*</font></label>
                <input type="text" name="first_name" id="first_name" placeholder="Enter First Name" required>
            </div>

            <div class="inp-box">
                <label for="last_name">Last Name: <font color="red">*</font></label>
                <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name" required>
            </div>

            <div class="inp-box">
                <label for="email">Email: <font color="red">*</font></label>
                <input type="email" name="email" id="email" placeholder="Enter Email" required>
            </div>

            <div class="inp-box">
                <label for="institute_name">Institute name: </label>
                <input type="text" name="institute_name" id="institute_name" placeholder="Enter Institute Name">
            </div>

            <div class="inp-box">
                <label for="password">Password: <font color="red">*</font></label>
                <input type="password" name="password" id="password" placeholder="Enter Password" required>
            </div>

            <div class="inp-box">
                <label for="confirm_password">Confirm Password: <font color="red">*</font></label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password" required>
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
    <script src="../script/password_validation.js"></script>
</body>
</html>