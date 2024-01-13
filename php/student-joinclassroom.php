<?php

    // include all necessary files
    include "dbconn.php";
    include "feature-usermenu.php";
    include "student-session.php"; 

    // fetch user id
    $user_id = $_SESSION['id'];

    // fetch the classroom code entered by the user
    if (isset($_POST['submit'])) {
        $digit1 = $_POST["digit1"];
        $digit2 = $_POST["digit2"];
        $digit3 = $_POST["digit3"];
        $digit4 = $_POST["digit4"];
        $digit5 = $_POST["digit5"];
        $digit6 = $_POST["digit6"];
        $digit7 = $_POST["digit7"];
    
        // combine the code into one string, and assign it with $code variable
        $code = $digit1 . $digit2 . $digit3 . $digit4 . $digit5 . $digit6 . $digit7;
    
        // check if the classroom code is valid
        $checkQuery = "SELECT * FROM `classroom` WHERE `classroom_code` = '$code'";
        $checkResult = mysqli_query($connection, $checkQuery);
        $rowCheck = mysqli_fetch_assoc($checkResult);
    
        if ($rowCheck) {
            $rowCount = mysqli_num_rows($checkResult);
            
            // if the classroom code is valid, fetch the classroom id
            if ($rowCount == 1) {
                $classroom_id = $rowCheck['classroom_id'];
    
                // Check if the user is already a member of the classroom
                $membershipCheckQuery = "SELECT * FROM `classroom_member` WHERE `user_id` = '$user_id' AND `classroom_id` = '$classroom_id'";
                $membershipCheckResult = mysqli_query($connection, $membershipCheckQuery);
                $existingMembership = mysqli_fetch_assoc($membershipCheckResult);
                
                if ($existingMembership) {
                    echo "<script> alert ('You are already a member of this classroom.'); </script>";
                    echo "<script> window.location.href = 'stu-teac-classroompage.php?id=$classroom_id'; </script>";
                    exit();
                }
    
                // If not a member, insert into the classroom_member table
                $insertQuery = "INSERT INTO `classroom_member`(`user_id`, `classroom_id`) 
                                VALUES ('$user_id','$classroom_id')";
                $insertResult = mysqli_query($connection, $insertQuery);
    
                if ($insertResult) {
                    // insert successfully
                    echo "<script> alert ('You have successfully joined the classroom.'); </script>";
                    echo "<script> window.location.href = 'stu-teac-classroompage.php?id=$classroom_id'; </script>";
                    exit();
                } else {
                    // insert failed
                    echo "<script> alert ('Error Occurred. Please try again.'); </script>";
                    echo "<script> window.location.href = 'student-joinclassroom.php'; </script>";
                    exit();
                }

            // classroom code doesnt exists
            } else if ($rowCount == 0) {
                echo "<script> alert ('Invalid Classroom Code. Please Try Again.'); </script>";
                echo "<script> window.location.href = 'student-joinclassroom.php'; </script>";
                exit();

            // unexpected error
            } else if ($rowCount > 1) {
                echo "<script> alert ('There is an error on the website. Please Contact Admin.'); </script>";
                echo "<script> window.location.href = 'stu-teac-index.php'; </script>";
                exit();
            }
        
        // classroom code doesnt exists
        } else {
            echo "<script> alert ('Invalid Classroom Code. Please Try Again.'); </script>";
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Classroom</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/animation.css">
    <link rel="stylesheet" href="../css/student-joinclassroom.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
<body>

    <div class="container">

        <div class="header">
            <h1>Join Classroom</h1>
        </div>

        <div class="codedes">
            <p>Enter the 7-digit code to join the classroom:</p>
        </div>

        <!-- form that will accept 7 digit numbers -->
        <form action="" method="post" onsubmit="return validateForm()">
            <div class="code-input" id="codeInput">
                <input type="text" maxlength="1" name="digit1" id="digit1" oninput="moveToNext(this)" />
                <input type="text" maxlength="1" name="digit2" id="digit2" oninput="moveToNext(this)" />
                <input type="text" maxlength="1" name="digit3" id="digit3" oninput="moveToNext(this)" />
                <input type="text" maxlength="1" name="digit4" id="digit4" oninput="moveToNext(this)" />
                <input type="text" maxlength="1" name="digit5" id="digit5" oninput="moveToNext(this)" />
                <input type="text" maxlength="1" name="digit6" id="digit6" oninput="moveToNext(this)" />
                <input type="text" maxlength="1" name="digit7" id="digit7" />
            </div>

            <!-- validation message box -->
            <div id="validation-message"></div>

            <!-- submit button -->
            <br><button type="submit" id="submit-btn" name="submit">Submit</button>
        </form>
    </div>

    <!-- script that will validate the input -->
    <script src="../script/join-classroom.js"></script>

</body>
</html>
