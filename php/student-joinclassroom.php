<?php

    include "dbconn.php";
    include "student-session.php"; 

    $user_id = $_SESSION['id'];

    if (isset($_POST['submit'])) {
        $digit1 = $_POST["digit1"];
        $digit2 = $_POST["digit2"];
        $digit3 = $_POST["digit3"];
        $digit4 = $_POST["digit4"];
        $digit5 = $_POST["digit5"];
        $digit6 = $_POST["digit6"];
        $digit7 = $_POST["digit7"];

        $code = $digit1 . $digit2 . $digit3 . $digit4 . $digit5 . $digit6 . $digit7;

        $checkQuery = "SELECT * FROM `classroom` WHERE `classroom_code` = '$code'";
        $checkResult = mysqli_query($connection, $checkQuery);
        $rowCheck = mysqli_fetch_assoc($checkResult);

        if ($rowCheck) {
            $rowCount = mysqli_num_rows($checkResult);

            if ($rowCount == 1) {
                $classroom_id = $rowCheck['classroom_id'];
                $insertQuery = "INSERT INTO `classroom_member`(`user_id`, `classroom_id`) 
                                VALUES ('$user_id','$classroom_id')";
                $insertResult = mysqli_query($connection, $insertQuery);    
                if ($insertResult) {
                    echo "<script> alert ('You have successfully joined the classroom. ');</script>"; 
                    echo "<script> window.location.href = 'stu-teac-classroompage.php?id=$classroom_id'; </script>";
                    exit();
                } else {
                    echo "<script> alert ('Error Occur. Please try again. ');</script>";
                    echo "<script> window.location.href = 'student-joinclassroom.php'; </script>";
                    exit();
                }
            } else if($rowCount == 0) {
                echo "<script> alert ('Invalid Classroom Code. Please Try Again. ');</script>";
                echo "<script> window.location.href = 'student-joinclassroom.php'; </script>";
                exit();
            } else if ($rowCount > 1) {
                echo "<script> alert ('There is an error in the website. Please Contact Admin. ');</script>";
                echo "<script> window.location.href = 'stu-teac-index.php'; </script>";
                exit(); 
            }
        } else {
            echo "Error: " . mysqli_error($connection);
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Classroom</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
        }

        .code-input {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .code-input input {
            width: 40px;
            height: 40px;
            font-size: 18px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #submit-btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
<body>

<div class="container">
    <h1>Join Classroom</h1>
    <p>Enter the 7-digit code to join the classroom:</p>

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

        <div id="validation-message"></div>

        <button type="submit" id="submit-btn" name="submit">Submit</button>
    </form>
</div>

<script>
    function moveToNext(currentInput) {
        if (currentInput.value.length === currentInput.maxLength) {
            const nextInput = currentInput.nextElementSibling;
            if (nextInput) {
                nextInput.focus();
            }
        }
    }

    function validateForm() {
        var validation_message = document.getElementById('validation-message');
        validation_message.textContent = ""; // Clear any previous validation messages

        for (let i = 1; i <= 7; i++) {
            const digit = document.getElementById('digit' + i).value;

            if (!(/^\d$/.test(digit))) {
                validation_message.textContent = "Only Digit Number is allowed";
                validation_message.style.color = "red";
                return false;
            }
        }

        return true;
    }
</script>

</body>
</html>
