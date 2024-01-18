<?php

    // include database connection file
    include 'dbconn.php';

    // start session if the session is not started
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //  Check if the login form is submitted
    if (isset($_POST['btnLogin'])) {

        // retrieve email and password from the login form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // SQL query to retrieve user information from the database based on the email and password
        $query = "SELECT user.*, role.role
                  FROM user
                  LEFT JOIN role ON user.role_id = role.role_id
                  WHERE email_address = '$email' AND password = '$password'";
        
        // execute the query
        $result = mysqli_query($connection, $query);
    
        // check if the query is successful
        if ($result) {

            // fetch the query result as an associative array
            $row = mysqli_fetch_assoc($result);
    
            // check if the user exists in the database
            if ($row) {

                // store user information in the session
                $_SESSION['id'] = $row['user_id'];
                $_SESSION['first_name'] = $row['user_first_name'];
                $_SESSION['last_name'] = $row['user_last_name'];
                $_SESSION['email'] = $row['email_address'];
                $_SESSION['role'] = $row['role'];
                $role = $_SESSION['role'];
                
                // redirect user to the appropriate page based on the role
                if ($role == null) {
                    header("Location: feature-role.php");
                    exit();
                } elseif ($role == 'admin') {
                    header("Location: admin-index.php");
                    exit();
                } else {
                    header("Location: stu-teac-index.php");
                    exit();
                }
            } else {
                // Display error message if the user does not exist
                echo "<script>alert('Invalid email or password');</script>";
            }
        } else {
            // Handle query execution error
            echo "<script>alert('Error executing the query');</script>";
        }
    }
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SubjectMastery360</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/animation.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <div id="container">
        <div id="header">
            LOGIN TO <br>
            SUBJECTMASTERY360
        </div>
        <div id="input">
            <!--login form-->
            <form action="" method="post">
                <table>
                    <tr>
                        <td><img src="../image/user.png" height="50px"></td>
                        <td>EMAIL:</td>
                        <td><input type="email" name="email"></td>
                    </tr>
                    <tr>
                        <td><img src="../image/pass.png" height="50px"></td>
                        <td>PASSWORD:</td>
                        <td><input type="password" name="password"></td>
                    </tr>
                    <tr>
                        <td rolspan="3" id="login_button">
                            <input type="submit" value="Login" name="btnLogin" id="login_button">
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <!-- other than login form -->
        <div id="footer">
            <div id="sign-up">
                Don't have a account? <b><a href="feature-registration.php">Sign up</a></b>
            </div>
            <div id="forgot-password">
                <b><a href="">Forgot Password</a></b>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>   

</body>
</html>

<?php

    // close the database connection
    mysqli_close($connection);

?>