<?php

require "dbconn.php";

// Function to calculate the average mark for a specific quiz
// Function to calculate the average marks for all students/attempts in a specific quiz
// Function to calculate the total marks for a specific quiz attempt
// Function to check how many times a specific quiz has been attempted
function quiz_attempt_count($quiz_id) {
    global $connection;

    // Fetch the attempt count
    $attemptCountQuery = "
        SELECT COUNT(DISTINCT qa.quiz_attempt_id) AS attempt_count
        FROM quiz_attempt qa
        WHERE qa.quiz_id = ?";

    $stmt = $connection->prepare($attemptCountQuery);
    $stmt->bind_param('i', $quiz_id); // 'i' represents an integer type
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $attempt_count = $row['attempt_count'];
    } else {
        $attempt_count = 0;
    }

    // Close the statement
    $stmt->close();

    // Return the attempt count for the specific quiz
    return $attempt_count;
}

// ...

// Usage example
$quiz_id = 2; // Replace with the actual quiz_id
$attemptCount = quiz_attempt_count($quiz_id);

// Display the attempt count
echo "<p>Quiz {$quiz_id} has been attempted {$attemptCount} times</p>";


// Function to calculate the total marks of a specific quiz
function calculate_total_marks($quiz_id, $db) {
    $query = "
    SELECT SUM(qq.quiz_mark) as total_marks
    FROM quiz_user_answer qua
    JOIN quiz_attempt qa ON qua.quiz_attempt_id = qa.quiz_attempt_id
    JOIN quiz_question qq ON qua.quiz_question_id = qq.quiz_question_id
    JOIN quiz_option qot ON qua.answer = qot.quiz_option_id
    WHERE qa.quiz_id = ? AND qot.iscorrect = 1
    ";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_marks'];
}


// ...

// Usage example
$quiz_id = 2; // Replace with the actual quiz_id
$totalMarks = calculate_total_marks($quiz_id, $connection);

// Display the total marks for the quiz
echo "<p>Total Marks for Quiz {$quiz_id}: {$totalMarks}</p>";

function calculate_total_possible_marks($quiz_id, $db) {
    $query = "
    SELECT SUM(qq.quiz_mark) as total_marks
    FROM quiz_question qq
    WHERE qq.quiz_id = ?
    ";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_marks'];
}

$quiz_id = 2; 
echo calculate_total_possible_marks($quiz_id, $connection);