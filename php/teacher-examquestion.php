<?php

    // include all necessary files
    include "dbconn.php"; 
    include "feature-usermenu.php";
    include "teacher-session.php";

    // get the exam id from the url
    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
    } else {
        // if the user is not logged in, redirect to the logout page
        header("Location: feature-logout.php");
        exit(); 
    }

    // get the exam id from the url
    if(isset($_GET['id'])) {
        $exam_id = $_GET['id'];
        $query = "SELECT * FROM exam WHERE exam_id = '$exam_id'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <link rel="stylesheet" href="../css/teacher-examquestion.css">
</head>
<body>
    
    <div class="container-add">
        <!-- Display form allows user to add question for exam -->
        <h1 style="font-size: 36px; text-decoration: underline; padding: 10px">Add Question - <?php echo $row['exam_title'];?></h1>
        <form action="" method="post" enctype="multipart/form-data" onsubmit ="return validate_mark()">
            <div class="question">
                <label for="question">Question: </label> <br>
                <textarea name="question" id="question" placeholder="Enter Question" required style="resize: none"></textarea> <br>
            </div>
            <div class="mark">
                <label for="mark">Mark: </label> <br>
                <input type="text" name="mark" placeholder="mark" id="mark" required> <br>
            </div>
            <div class="image">
                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png"> <br>
            </div>

            <!-- Display the validation message -->
            <div id="validation-message"></div> <br>
            <div class="join">
                <input type="submit" value="Confirm Add" name="submit" class="submit-btn">
                <input type="button" value="Clear" onclick="clearForm()" class="clear-btn">
            </div>
        </form>

        <!-- Exit button -->
        <div class="exit-btn">
            <button type="button" id="exit" onclick="exit()" class="exit-btn2">Exit</button>
        </div>
        <div style="clear: both"></div>
    </div>

    <script>
        // function to exit the page
        function exit() {
            if (confirm('Do you want to leave the page?')) {
                window.location.href = 'stu-teac-index.php';
            }
        }
    </script>
    <script src="../script/clear-form.js"></script>
    <script src="../script/validation-mark.js"></script>

    <?php 

        // if the user click the submit button
        if (isset($_POST['submit'])) {
            $question = $_POST['question'];
            $mark = $_POST['mark'];
            
            // insert the question into the database
            $insertQuery = "INSERT INTO `exam_question`(`exam_id`, `exam_question`, `exam_marks`) 
                            VALUES ('$exam_id','$question','$mark')";

            if (mysqli_query($connection, $insertQuery)) {
                // get the question id
                $new_id = mysqli_insert_id($connection);

                // if the user upload an image, upload the image to the server
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

                        $updateQuery = "UPDATE `exam_question` SET `exam_attachment`='$newImageName' WHERE `exam_question_id` = '$new_id'";
                        mysqli_query($connection, $updateQuery);

                        echo "<script> alert('Successfully Added');</script>";
                    }
                } else {
                    echo "<script> alert('Successfully Added');</script>";
                }
            } else {
                echo "<script> alert('Error adding question, please try again later');</script>";
            }
        }

    ?>

</body>
</html>


<?php

    } else {
        // if the url does not contain the exam id, display the exam list
        $fetch = "SELECT 
                    cm.*,
                    c.*,
                    ce.*,
                    e.*
                FROM 
                    classroom_member cm
                JOIN 
                    classroom c ON cm.classroom_id = c.classroom_id
                JOIN 
                    classroom_exam ce ON c.classroom_id = ce.classroom_id
                JOIN 
                    exam e ON ce.exam_id = e.exam_id
                WHERE 
                    cm.user_id = '$user_id';
                ";

        $fetch_result = mysqli_query($connection, $fetch);

        if ($fetch_result) {
            // if the user is involved in any of the classroom, display the classroom list
            if(mysqli_num_rows($fetch_result) > 0) {
        
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Exam</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/teacher-examquestion.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <h1 id="eq_h1" align="center">Choose The Exam You Would Like To Add Questions</h1>
    <div id="eq_choices">
    <ul>
        <?php
            while ($fetch_row = mysqli_fetch_assoc($fetch_result)) {
                echo "<a href='teacher-examquestion.php?id=".$fetch_row['exam_id']."'><li class='choose-classroom'>".$fetch_row['exam_title']."</li></a>";
            }
        ?>
    </ul>
    </div>
</body>
</html>

<?php
            } else {
                echo "<div style='text-align: center; font-size: 24px; margin-top: 100px;'>You did not create any exam before.</div>";
            }
        } else {
            echo "Error in fetching data: " . mysqli_error($connection);
        }
    }
?>