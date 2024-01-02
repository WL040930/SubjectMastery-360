<?php

include "dbconn.php"; 

function calculateFullMarks($exam_attempt_id, $connection) {
    // SQL query to calculate the total marks for a specific exam attempt
    $totalMarkQuery = "
        SELECT SUM(eq.exam_marks) AS total_marks
        FROM exam_question eq
        INNER JOIN exam_user_answer eua ON eq.exam_question_id = eua.exam_question_id
        WHERE eua.exam_attempt_id = ?";

    // Prepare and execute the query
    $stmt = $connection->prepare($totalMarkQuery);
    $stmt->bind_param('i', $exam_attempt_id);
    $stmt->execute();
    $stmt->bind_result($total_marks);
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Return the total marks
    return $total_marks;
}

function calculateUserMarks($exam_attempt_id, $connection) {
    // SQL query to calculate the user's score based on correctness of answers
    $userScoreQuery = "
        SELECT IFNULL(SUM(eua.exam_user_marks), 0) AS user_marks
        FROM exam_user_answer eua
        WHERE eua.exam_attempt_id = ?";

    // Prepare and execute the query
    $stmt = $connection->prepare($userScoreQuery);
    $stmt->bind_param('i', $exam_attempt_id);
    $stmt->execute();
    $stmt->bind_result($user_marks);
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Check if the sum is 0, meaning all values were NULL
    if ($user_marks == 0) {
        return "Not finish marking";
    } else {
        return $user_marks;
    }
}
// Example usage with a provided exam_attempt_id
$exam_attempt_id = 4; // Replace with the specific exam_attempt_id you want to calculate

$full_marks = calculateFullMarks($exam_attempt_id, $connection);
$user_marks = calculateUserMarks($exam_attempt_id, $connection);

echo "Full Marks: $full_marks\n";
echo "User Marks: $user_marks\n";

