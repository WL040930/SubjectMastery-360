<?php

include "dbconn.php";

if (isset($_POST['submit'])) {
    $quiz_id = mysqli_real_escape_string($connection, $_POST['quiz_id']);
    $quiz_question_id = mysqli_real_escape_string($connection, $_POST['quiz_question_id']);
    $question = mysqli_real_escape_string($connection, $_POST['question']);
    $correct_option = mysqli_real_escape_string($connection, $_POST['correct_option']);
    $incorrect_options = $_POST['incorrect_options'];
    $incorrect_option_ids = $_POST['incorrect_option_ids'];

    // Update the question in the quiz_question table
    $updateQuestionQuery = "UPDATE quiz_question SET quiz_question_text = '$question' WHERE quiz_question_id = '$quiz_question_id'";
    mysqli_query($connection, $updateQuestionQuery);

    // Update the correct option in the quiz_option table
    $updateCorrectOptionQuery = "UPDATE quiz_option SET option_text = '$correct_option' WHERE quiz_question_id = '$quiz_question_id' AND iscorrect = '1'";
    mysqli_query($connection, $updateCorrectOptionQuery);

    // Update existing incorrect options
    foreach ($incorrect_options as $key => $incorrect_option) {
        $incorrect_option_id = mysqli_real_escape_string($connection, $key);
        $updateIncorrectOptionQuery = "UPDATE quiz_option SET option_text = '$incorrect_option' WHERE quiz_option_id = '$incorrect_option_id'";
        mysqli_query($connection, $updateIncorrectOptionQuery);
    }

    // Redirect to a success page or back to the question page
    header("Location: teacher-managequiz.php?id=$quiz_id");
    exit();
}

?>
