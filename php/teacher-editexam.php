<?php

    ob_start();

    include "dbconn.php";
    include "feature-usermenu.php";
    include "teacher-session.php";

    if(isset($_GET['id'])) {
        $exam_question_id = $_GET['id'];
    } else {
        header("Location: teacher-manageexam.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link rel="stylesheet" href="../css/teacher-editquiz.css">
    <link rel="stylesheet" href="../css/animation.css">
    <link rel="stylesheet" href="../css/teacher-editexam.css">
</head>
<body>
    <div class="headerquiz">
        Edit Question
    </div>
    <form method="post" enctype="multipart/form-data">
        <?php
        
            $sql = "SELECT * FROM exam_question WHERE exam_question_id = '$exam_question_id'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
        
        ?>
        <table>
            <tr>
                <th>Question</th>
                <td><textarea name="question" id="question"><?php echo $row['exam_question']; ?></textarea></td>
            </tr>
            <tr>
                <th>Marks</th>
                <td><input type="text" value="<?php echo $row['exam_marks']; ?>" disabled></td>
            </tr>
            <tr>
                <th>Image</th>
                <td style="text-align: center;">
                    <?php if (!empty($row['exam_attachment'])): ?>
                        <img src="../data/image<?php echo $row['exam_attachment']; ?>" style="height:150px;" id="previewImage"> <br>
                    <?php else: ?>
                        <div style="width: 150px; height: 150px; border: 1px solid #ddd;"></div><br>
                    <?php endif; ?>

                    <label for="image" class="custom-file-input">
                        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" onchange="handleFileInput()">
                    </label>
                </td>
            </tr>
        </table>
        <div class="divsubmit">
            <input type="submit" name="submit" value="Update" class="submitbtn">
        </div>

    </form>

    <div class="exit-btn">
        <button type="button" id="exit" onclick="exit()" class="exit-btn2">Exit</button>
    </div>
</body>
</html>

<script>

    function exit() {
        window.location.href = "teacher-manageexam.php?id=<?php echo $row['exam_id']; ?>";
    }

    function handleFileInput() {
        var fileInput = document.getElementById('image');
        var previewImage = document.getElementById('previewImage');
        var selectedFile = fileInput.files[0];

        if (selectedFile) {
            var reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(selectedFile);
        }
    }
</script>

<?php
    if (isset($_POST['submit'])) {
        // Retrieve and sanitize form data
        $question = mysqli_real_escape_string($connection, $_POST['question']);
        // Additional sanitization if needed for other fields

        // Handle file upload
        if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            move_uploaded_file($image_tmp_name, "../data/image" . $image_name);

            // Update the image name in the database
            $updateImageQuery = "UPDATE exam_question SET exam_attachment = '$image_name' WHERE exam_question_id = '$exam_question_id'";
            mysqli_query($connection, $updateImageQuery);
        }

        // Update the question text in the database
        $updateQuestionQuery = "UPDATE exam_question SET exam_question = '$question' WHERE exam_question_id = '$exam_question_id'";
        mysqli_query($connection, $updateQuestionQuery);

        // Redirect to a success page or back to the question page
        header("Location: teacher-manageexam.php?id=" . $row['exam_id']);
        exit();
    }

    ob_end_flush();
?>