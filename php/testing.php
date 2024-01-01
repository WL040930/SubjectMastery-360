<?php
include "dbconn.php"; // Assuming you have a global variable named $connection for the database connection

function quiz_total_mark($quiz_attempt_id, $user_id) {
    global $connection;

    // SQL query to calculate the total marks for a specific quiz attempt and user
    $totalMarkQuery = "
        SELECT SUM(qq.quiz_mark) AS total_mark
        FROM quiz_user_answer qua
        INNER JOIN quiz_question qq ON qua.quiz_question_id = qq.quiz_question_id
        WHERE qua.quiz_attempt_id = ?
        AND qua.quiz_attempt_id IN (
            SELECT quiz_attempt_id
            FROM quiz_attempt
            WHERE user_id = ?
        )";

    // Prepare and execute the query
    $stmt = $connection->prepare($totalMarkQuery);
    $stmt->bind_param('ii', $quiz_attempt_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($total_mark);
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Return the total mark
    return $total_mark;
}

// Example usage
$quiz_attempt_id = 2;
$user_id = 9; // Replace with the actual user ID
$totalMark = quiz_total_mark($quiz_attempt_id, $user_id);

// Output the result
echo "Total Marks for Attempt $quiz_attempt_id: $totalMark";
?>


<?php

function calculate_user_score($quiz_attempt_id, $user_id) {
    global $connection;

    // SQL query to calculate the user's score based on correctness of answers
    $userScoreQuery = "
        SELECT SUM(qq.quiz_mark * qo.iscorrect) AS user_score
        FROM quiz_user_answer qua
        INNER JOIN quiz_question qq ON qua.quiz_question_id = qq.quiz_question_id
        INNER JOIN quiz_option qo ON qua.answer = qo.quiz_option_id
        WHERE qua.quiz_attempt_id = ?
        AND qua.quiz_attempt_id IN (
            SELECT quiz_attempt_id
            FROM quiz_attempt
            WHERE user_id = ?
        )";

    // Prepare and execute the query
    $stmt = $connection->prepare($userScoreQuery);
    $stmt->bind_param('ii', $quiz_attempt_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($user_score);
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Return the user's score
    return $user_score;
}

// Example usage
$quiz_attempt_id = 2;
$user_id = 9; // Replace with the actual user ID
$userScore = calculate_user_score($quiz_attempt_id, $user_id);

// Output the result
echo "User's Score for Attempt $quiz_attempt_id: $userScore";
?>
