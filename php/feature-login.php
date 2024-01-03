<?php

    include 'dbconn.php';
    session_start();

    if (isset($_POST['btnLogin'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $query = "SELECT user.*, role.role
                FROM user
                LEFT JOIN role ON user.role_id = role.role_id
                WHERE email_address = '$email' AND password = '$password'";
                
        $result = mysqli_query($connection, $query);
    
        if ($result) {
            $row = mysqli_fetch_assoc($result);
    
            if ($row) {
                $_SESSION['id'] = $row['user_id'];
                $_SESSION['first_name'] = $row['user_first_name'];
                $_SESSION['last_name'] = $row['user_last_name'];
                $_SESSION['email'] = $row['email_address'];
                $_SESSION['role'] = $row['role'];
                $role = $_SESSION['role'];
    
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
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="icon" href="../image/logo.png">
</head>

<body>
    <div id="container">
        <div id="header">
            LOGIN TO <br>
            SUBJECTMASTERY360
        </div>
        <div id="input">
            <form action="" method="post">
                <table>
                    <tr>
                        <td><img src="../image/feedback.png" height="50px"></td>
                        <td>EMAIL:</td>
                        <td><input type="email" name="email"></td>
                    </tr>
                    <tr>
                        <td><img src="../image/feedback.png" height="50px"></td>
                        <td>PASSWORD:</td>
                        <td><input type="password" name="password"></td>
                    </tr>
                    <tr>
                        <td rolspan="3" align="right">
                            <input type="submit" value="Login" name="btnLogin">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="footer">
            <div id="sign-up">
                Don't have a account? <a href="feature-registration.php">Sign up</a>
            </div>
            <div id="forgot-password">
                <a href="">Forgot Password</a>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>   

</body>
</html>

<?php

    mysqli_close($connection);

?>