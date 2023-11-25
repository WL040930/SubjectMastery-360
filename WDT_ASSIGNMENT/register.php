<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<style>
    /*center the container to the middle of the page,
    Make sure the container can cover all the "input"
    leave some space between the top of the page*/
    .container {
        margin: 100px auto 100px;
        width: 500px;
        height: 780px;
        border: 1px solid black;
        border-radius: 10px;
        padding: 20px;
        background-color: white;
    }

    /*divide all the "input" inside the container equally*/
    .input {
        width: 100%;
        margin-bottom: 20px;
    }
    
    /*make the input boxes look like text boxes*/
    input[type=text], input[type=password], input[type=email] {
        width: 95%;
        padding: 10px;
        margin: 5px 5px 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    /*Make the button center in the middle, and style it (green)*/
    input[type=submit] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /*Make the button look like a button*/
    input[type=submit]:hover {
        background-color: #45a049;
    }

</style>

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
