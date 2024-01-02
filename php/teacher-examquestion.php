<?php

    include "dbconn.php"; 
    include "teacher-session.php";

    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
    } else {
        header("Location: feature-logout.php");
        exit(); 
    }

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
</head>
<body>
    
    <h1>Add Question - <?php echo $row['exam_title'];?></h1>
    <form action="" method="post" enctype="multipart/form-data" onsubmit ="return validate_mark()">
        <input type="text" name="question" id="question" placeholder="Enter Question" required> <br>
        <input type="text" name="mark" placeholder="mark" id="mark" required> <br>
        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png"> <br>
        <div id="validation-message"></div> <br>
        <input type="submit" value="Confirm Add" name="submit">
        <input type="button" value="Clear" onclick="clearForm()">
    </form>
    
    <script src="../script/clear-form.js"></script>
    <script src="../script/validation-mark.js"></script>

    <?php 

if (isset($_POST['submit'])) {
    $question = $_POST['question'];
    $mark = $_POST['mark'];

    $insertQuery = "INSERT INTO `exam_question`(`exam_id`, `exam_question`, `exam_marks`) 
                    VALUES ('$exam_id','$question','$mark')";

    if (mysqli_query($connection, $insertQuery)) {
        $new_id = mysqli_insert_id($connection);

        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];

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
        if(mysqli_num_rows($fetch_result) > 0) {
        
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Exam</title>
</head>
<body>
    <h1>Choose the Exam you would like to add a question</h1>

    <?php
        while ($fetch_row = mysqli_fetch_assoc($fetch_result)) {
            echo "<a href='teacher-examquestion.php?id=".$fetch_row['exam_id']."'>".$fetch_row['exam_title']."</a><br>";
        }
    ?>
</body>
</html>

<?php
            } else {
                echo "You are not involved in any classroom.";
            }
        } else {
        echo "Error in fetching data: " . mysqli_error($connection);
        }
    }
?>