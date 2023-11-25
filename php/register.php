<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>
    <!--
        Make a register page which the form is in the middle of the page, and it is covered by a border
    -->
    <div class="container">
        <h1>Register Your Account</h1>
        <form action="#" method="post">
            <div class="input">
                <label for="username">Username: </label>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="input">
                <label for="first_name">First Name: </label>
                <input type="text" name="first_name" id="first_name" placeholder="First Name" required>
            </div>
            <div class="input">
                <label for="last_name">Last Name: </label>
                <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>
            </div>
            <div class="input">
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="input">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="input">
                <label for="confirm_password">Confirm Password: </label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
            </div>
            <div class="input">
                <input type="submit" name="submit" value="Register">
            </div>
            <div class="input">
                <a href="login.php">Already have an account? Login here.</a>
            </div>
        </form>

</body>
</html>