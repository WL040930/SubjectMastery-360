<?php

    // include necessary files
    include "dbconn.php"; 
    include "feature-usermenu.php";
    include "teacher-session.php";

    // check if the user is logged in
    if(isset($_SESSION['id'])){
        // get the user id
        $user_id = $_SESSION['id'];
    } else {
        header("Location: feature-logout.php");
        exit(); 
    }

    // get the quiz id from the url
    if(isset($_GET['id'])) {
        $quiz_id = $_GET['id'];
        $query = "SELECT * FROM quiz WHERE quiz_id = '$quiz_id'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <link rel="stylesheet" href="../css/teacher-quizquestion.css">
    <link rel="stylesheet" href="../css/animation.css">
</head>
<body>
    
    <h1 align="center">Add Question - <?php echo $row['quiz_title'];?></h1>
    <!-- Form to add new question -->
    <div class="container-all">
        <form action="" method="post" onsubmit="return validate_mark()" enctype="multipart/form-data">
            <textarea name="question" id="question" placeholder="Enter the Question" required style="resize: none; width: 95%; border: 1px solid #ccc; border-radius: 5px; padding: 7px;"></textarea> <br>
            <input type="text" name="mark" id="mark" placeholder="Enter the Mark" required> <br>
            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png"> <br>
            <input type="text" name="option1" id="option1" placeholder="Enter Option 1 (Correct Answer)" required> <br>
            <input type="text" name="option2" id="option2" placeholder="Enter Option 2" required> <br>
            <input type="text" name="option3" id="option3" placeholder="Enter Option 3" required> <br>
            <input type="text" name="option4" id="option4" placeholder="Enter Option 4" required> <br>
            <div id="validation-message"></div>
            <input type="submit" value="Add Question" name="submit">
            <input type="button" value="Clear" onclick="clearForm()">
        </form>
        <button type="button" id="exit" onclick="exit()" class="exit-btn">Exit</button>
    </div>
        
    <script>
        // Function to exit the page
        function exit() {
            window.location.href = "teacher-managequiz.php?id=<?php echo $quiz_id; ?>";
        }
    </script>
    <script src="../script/clear-form-quiz.js"></script>
    <script src="../script/validation-mark.js"></script>

    <?php 

        // if the user has submitted the form
        if(isset($_POST['submit'])) {

            // get the data from the form
            $question = $_POST['question'];
            $mark = $_POST['mark'];
            $option1 = $_POST['option1'];
            $option2 = $_POST['option2'];
            $option3 = $_POST['option3'];
            $option4 = $_POST['option4'];
            
            // insert the question into the quiz_question table
            $insertQuery = "INSERT INTO `quiz_question`(`quiz_id`, `quiz_question_text`, `quiz_mark`) 
                            VALUES ('$quiz_id','$question','$mark')";
            $insertResult = mysqli_query($connection, $insertQuery);
            if ($insertResult) {
                // get the question id
                $question_id = mysqli_insert_id($connection);

                // insert the options into the quiz_option table
                $optionQuery1 = "INSERT INTO `quiz_option`(`quiz_question_id`, `option_text`, `iscorrect`) 
                            VALUES ('$question_id','$option1',TRUE)";
                $optionQuery2 = "INSERT INTO `quiz_option`(`quiz_question_id`, `option_text`, `iscorrect`) 
                            VALUES ('$question_id','$option2',FALSE)";
                $optionQuery3 = "INSERT INTO `quiz_option`(`quiz_question_id`, `option_text`, `iscorrect`) 
                            VALUES ('$question_id','$option3',FALSE)";
                $optionQuery4 = "INSERT INTO `quiz_option`(`quiz_question_id`, `option_text`, `iscorrect`) 
                            VALUES ('$question_id','$option4',FALSE)";
                $resultOption1 = mysqli_query($connection, $optionQuery1);
                $resultOption2 = mysqli_query($connection, $optionQuery2);
                $resultOption3 = mysqli_query($connection, $optionQuery3);
                $resultOption4 = mysqli_query($connection, $optionQuery4);

                // if the user upload an image, upload the image to the server
                if ($resultOption1 && $resultOption2 && $resultOption3 && $resultOption4) {
                    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                        $fileName = $_FILES["image"]["name"];
                        $fileSize = $_FILES["image"]["size"];
                        $tmpName = $_FILES["image"]["tmp_name"];
        
                        // check the image extension
                        $validImageExtension = ['jpg', 'jpeg', 'png'];
                        $imageExtension = explode('.', $fileName);
                        $imageExtension = strtolower(end($imageExtension));
        
                        if (!in_array($imageExtension, $validImageExtension)) {
                            echo "<script> alert('Invalid Image Extension');</script>";
                        } else if ($fileSize > 5000000) {
                            echo " <script> alert('Image Size Is Too Large'); </script>";
                        } else {
                            $newImageName = uniqid();
                            $newImageName .= '.' . $imageExtension;
        
                            move_uploaded_file($tmpName, '../data/image' . $newImageName);
                            echo $question_id;
                            $updateQuery = "UPDATE `quiz_question` SET `quiz_attachment`='$newImageName' WHERE `quiz_question_id` = '$question_id'";
                            mysqli_query($connection, $updateQuery);
        
                            echo "<script> alert('Question Added Success.');</script>";
                        }
                    } else {
                        echo "<script> alert('Question Added Success.');</script>";
                    }
                } else {
                    echo "<script>alert('Error adding question');</script>"; 
                }
            }
        }

    ?>

</body>
</html>


<?php

    } else {
        // if the user has not choose the quiz, show the list of quiz
        $fetch = "SELECT 
                    cm.*,
                    c.*,
                    cq.*,
                    q.*
                FROM 
                    classroom_member cm
                JOIN 
                    classroom c ON cm.classroom_id = c.classroom_id
                JOIN 
                    classroom_quiz cq ON c.classroom_id = cq.classroom_id
                JOIN 
                    quiz q ON cq.quiz_id = q.quiz_id
                WHERE 
                    cm.user_id = '$user_id';
                ";

        $fetch_result = mysqli_query($connection, $fetch);

        if ($fetch_result) {
            // if the user has created any quiz before, show the list of quiz
            if(mysqli_num_rows($fetch_result) > 0) {
        
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Quiz</title>
    <link rel="stylesheet" href="../css/teacher-quizquestion.css">
    <link rel="stylesheet" href="../css/animation.css">
</head>
<body>
    <h1 align="center">Choose the Quiz you would like to add a question</h1>
    <ul>
    <?php
        while ($fetch_row = mysqli_fetch_assoc($fetch_result)) {
            echo "<a class='linktoclassroom' href='teacher-quizquestion.php?id=".$fetch_row['quiz_id']."'><li class='choose-classroom'>".$fetch_row['quiz_title']."</li></a>";
        }
    ?>
    </ul>
</body>
</html>

<?php
            } else {
                // if the user has not created any quiz before, show the message
                echo "<div style='text-align: center; font-size: 24px; margin-top: 100px;'>You did not create any quiz before.</div>";
            }
        } else {
        echo "Error in fetching data: " . mysqli_error($connection);
        }
    }
?>