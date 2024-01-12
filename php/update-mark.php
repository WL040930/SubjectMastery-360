<?php

    // include database connection file
    include "dbconn.php";

    // if POST request is received
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // if markInput and exam_user_answer_id is set
        if (isset($_POST['markInput']) && isset($_POST['exam_user_answer_id'])) {
            // Get the mark and exam_user_answer_id
            $mark = $_POST['markInput'];
            $exam_user_answer_id = $_POST['exam_user_answer_id'];

            // Update the database with the new mark
            $updateMarkQuery = "UPDATE `exam_user_answer` SET `exam_user_marks` = ? WHERE `exam_user_answer_id` = ?";
            $stmt = mysqli_prepare($connection, $updateMarkQuery);
            mysqli_stmt_bind_param($stmt, 'ii', $mark, $exam_user_answer_id);
            $updateResult = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // If the update is successful, echo success message
            if ($updateResult) {
                echo 'Mark Updated Successfully';
            } else {
                echo 'Failed to Update Mark';
            }
        } else {
            echo 'Invalid data received';
        }
    } else {
        echo 'Invalid request method';
    }
?>
