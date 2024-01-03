<?php

    include "dbconn.php";

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION['id'])) {
        header("Location: feature-logout.php");
        exit(); 
    } else {
        $user_id = $_SESSION['id'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    body {
        background-color: antiquewhite;
    }

    #container {
        width: 70%;
        height: auto;
        margin: 0 auto;
        background-color: aqua;
    }

    #student {
        width: 50%; 
        height: auto;
        float: left;
        background-color: blueviolet;
    }

    #teacher {
        width: 50%;
        height: auto;
        float: right;
        background-color: chartreuse;
    }

    #close {
        clear: both;
    }
</style>

<body>
    <div id="container">
        <div id="header">
            <h1>Please Select Your Role</h1>
        </div>

        <form action="" method="post">
        <div id="student">
            <input type="radio" name="role" value="student">Student<br>
        </div>

        <div id="teacher">
            <input type="radio" name="role" value="teacher">Teacher<br>
        </div>

        <div id="close"></div>
    </div>        

        <div id="btnSubmit">
            <input type="submit" value="Next" name="btnNext">
        </div>
        </form>
</body>
</html>

<?php

    if(isset($_POST['btnNext'])) {
        $selectedRole = $_POST['role']; 
        
        switch ($selectedRole) {
            case 'student':
                $roleId = 1;
                break;
            case 'teacher':
                $roleId = 2;
                break;
            default:
                // Handle other cases if needed
                break;
        }

        $insertQuery = "UPDATE `user` SET `role_id`='$roleId' WHERE user_id = '$user_id'";
        $insertResult = mysqli_query($connection, $insertQuery); 
        if($insertResult) {
            $_SESSION['role'] = $selectedRole;
            header("Location: stu-teac-index.php"); 
            exit();
        } else {
            echo "<script> alert('Please try again later. '); </script>";
            echo "<script> window.location.href='feature-logout.php'; </script>";
        }
    }

?>