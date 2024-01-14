<?php

    // start output buffering
    ob_start(); 

    // include database connection file
    include "dbconn.php";

    // start session if the session is not started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // check if the user is logged in
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
    <link rel="stylesheet" href="../css/role.css">
    <link rel="stylesheet" href="../css/animation.css">
</head>

<body>
    <div id="container">
        <div id="header">
            <h1>Select Your Role</h1>
        </div>

        <!-- Form allows user to choose their role (student or teacher) -->
        <form action="" method="post">
            <div class="box">
                <img src="../image/student.png" alt="Student">
                <h3>Student</h3>
                <div class="specification">
                    <p>
                        <ul>
                            <li>Join Classroom</li>
                            <li>Download Study Materials</li>
                            <li>Attempt Quiz and Exam</li>
                            <li>Read Own Results</li>
                            <li>Read Feedback from Teacher</li>
                        </ul>
                    </p>
                </div>
                <input type="radio" name="role" value="student" checked>
            </div>

            <div class="box">
                <img src="../image/teacher.png" alt="Teacher">
                <h3>Teacher</h3>
                <div class="specification">
                    <p>
                        <ul>
                            <li>Create Classroom</li>
                            <li>Share Class Materials</li>
                            <li>Create Quiz and Exam</li>
                            <li>Read students' Results</li>
                            <li>Provide Feedback</li>
                        </ul>
                    </p>
                </div>
                <input type="radio" name="role" value="teacher">
            </div>

            <!-- Submit button -->
            <div id="btnSubmit">
                <input type="submit" value="Next" name="btnNext">
            </div>
        </form>
    </div>

    <script>

        // Function to enlarge the box when clicked
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

    // Check if the next button is clicked
    if(isset($_POST['btnNext'])) {

        // Get the selected role
        $selectedRole = $_POST['role']; 
        
        // Set the role id based on the selected role
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

        // Update the role id in the database
        $insertQuery = "UPDATE `user` SET `role_id`='$roleId' WHERE user_id = '$user_id'";
        $insertResult = mysqli_query($connection, $insertQuery);
        
        // Check if the query is executed successfully
        if($insertResult) {
            $_SESSION['role'] = $selectedRole;
            header("Location: stu-teac-index.php"); 
            exit();
        } else {
            echo "<script> alert('Please try again later. '); </script>";
            echo "<script> window.location.href='feature-logout.php'; </script>";
        }
    }

    // end output buffering
    ob_end_flush(); 

?>