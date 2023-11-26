<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Account</title>
</head>

<style>
    body{
        background-color: #B3D2F2;
    }

    /*Center container in the middle of the page and leave 100px from top and bottom of the page */
    #container {
        margin: 100px auto 100px;
        width: 500px;
        border: 1px solid black;
        padding: 7px;
        border-radius: 7px; 
        background-color: #B3EBF2;
    }

    .inp-box {
        margin-bottom: 20px;
        width: 100%;
    }

    input[type=text], input[type=password], input[type=email] {
        width: 95%;
        padding: 10px;
        margin: 5px 5px 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
        border-radius: 7px;
    }

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

    input[type=submit]:hover {
        background-color: #45a049;
    }


</style>

<body>
    <div id="container">
        <h1>Register Your Acount</h1>
        <div><p>Register your account here by filling in your information</p></div>
        <br>
        <form action="login.php" method="post" onsubmit="return validate_password()">

            <div class="inp-box">
                <label for="Username">Username: </label>
                <input type="text" name="username" id="Username" placeholder="Enter Username" required>
            </div>

            <div class="inp-box">
                <label for="first_name">First Name: </label>
                <input type="text" name="first_name" id="first_name" placeholder="Enter First Name" required>
            </div>

            <div class="inp-box">
                <label for="last_name">Last Name: </label>
                <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name" required>
            </div>

            <div class="inp-box">
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" placeholder="Enter Email" required>
            </div>

            <div class="inp-box">
                <label for="institute_name">Institute name: </label>
                <input type="text" name="institute_name" id="institute_name" placeholder="Enter Institute Name">
            </div>

            <div class="inp-box">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" placeholder="Enter Password" required>
            </div>

            <div class="inp-box">
                <label for="confirm_password">Confirm Password: </label>
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

    <script>
        function validate_password() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
            var validate_message = document.getElementsByClassName("validate-message")[0];

            var uppercase = /[A-Z]/;
            var lowercase = /[a-z]/;
            var specialcharacter = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
            var number = /[0-9]/;
            var length = /.{8,}/;

            if (
                password.match(uppercase) &&
                password.match(lowercase) &&
                password.match(specialcharacter) &&
                password.match(number) &&
                password.match(length)
            ) {
                if (password === confirm_password) {
                    validate_message.textContent = "";
                } else {
                    validate_message.textContent = "Password and Confirm Password must match.";
                    validate_message.style.color = "red";
                    return false;
                }
            } else {
                validate_message.textContent =
                    "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
                validate_message.style.color = "red";
                return false;
            }
        }
    </script>

</body>
</html>