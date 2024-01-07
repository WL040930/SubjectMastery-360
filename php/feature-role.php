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
    <title>Role Selection</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #edf1f7;
            margin: 0;
            padding: 0;
        }

        #container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #header {
            text-align: center;
            margin-bottom: 30px;
            color: #7E6E57;
        }

        .box {
            display: inline-block;
            width: 200px;
            height: 200px;
            border: 2px solid #BCA37F;
            margin: 10px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s, transform 0.3s;
            border-radius: 8px;
            overflow: hidden;
        }

        .box:hover {
            border-color: #7E6E57;
        }

        .box.enlarged {
            border-color: #7E6E57;
            transform: scale(1.1);
        }

        .box img {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
            border-radius: 50%;
        }

        .box h3 {
            margin: 0;
            color: #7E6E57;
            font-size: 18px;
        }

        .box .specification {
            display: none;
            color: #BCA37F;
            font-size: 14px;
        }

        .box.enlarged .specification {
            display: block;
        }

        #btnSubmit {
            text-align: center;
            margin-top: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #7E6E57;
            color: #edf1f7;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #BCA37F;
        }
    </style>
</head>

<body>
    <div id="container">
        <div id="header">
            <h1>Select Your Role</h1>
        </div>

        <form action="" method="post">
            <div class="box">
                <img src="../image/student.png" alt="Student">
                <h3>Student</h3>
                <div class="specification">
                    <p>Student specification goes here...</p>
                </div>
                <input type="radio" name="role" value="student" checked>
            </div>

            <div class="box">
                <img src="../image/teacher.png" alt="Teacher">
                <h3>Teacher</h3>
                <div class="specification">
                    <p>Teacher specification goes here...</p>
                </div>
                <input type="radio" name="role" value="teacher">
            </div>

            <div id="btnSubmit">
                <input type="submit" value="Next" name="btnNext">
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var boxes = document.getElementsByClassName("box");
            for (var i = 0; i < boxes.length; i++) {
                boxes[i].addEventListener("click", function () {
                    for (var j = 0; j < boxes.length; j++) {
                        boxes[j].classList.remove("enlarged");
                    }
                    this.classList.add("enlarged");
                    var radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                });
            }
        });
    </script>
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