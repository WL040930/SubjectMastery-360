<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Matching Example</title>
</head>

<body>
    <h1>Password Matching Example</h1>

    <form id="registrationForm" onsubmit="return validateForm()">
        <label for="password">Password:</label>
        <input type="password" id="password" required>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" required>

        <p id="passwordMatchMessage"></p>

        <input type="submit" value="Register">
    </form>

    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var messageElement = document.getElementById("passwordMatchMessage");

            if (password !== confirmPassword) {
                messageElement.textContent = "Password and Confirm Password do not match. Please re-enter.";
                messageElement.style.color = "red";
                return false;
            } else {
                messageElement.textContent = ""; // Clear the message if passwords match
                return true;
            }
        }
    </script>
</body>
</html>
