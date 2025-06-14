<?php

require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $postData = file_get_contents('php://input');
    
    // Decode the JSON data
    $postDataArray = json_decode($postData, true); // true for associative array
    
    //Add new quiz in quizzes table
    $sql = "INSERT INTO quizzes(user_email) VALUES (?)";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $postDataArray["owner"]);
    $query->execute();

    $quiz_id = $conn->insert_id;  //Get quiz_id of new quiz

   // Determine the number of items in the array
    $count = count($postDataArray);
    
    // Loop through all questions and insert them into quiz_questions table
    for ($i = 0; $i < $count - 1; $i++) {
        $key = array_keys($postDataArray)[$i];
        $value = $postDataArray[$key];
        
        $sql = "INSERT INTO quiz_questions (quiz_id, question_text, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $query = $conn->prepare($sql);
        $query->bind_param("isssssi", $quiz_id, $value[0], $value[1], $value[2], $value[3], $value[4], $value[5]);
        $query->execute();
    }

    echo json_encode(array('msg' => "Quiz created successfully!\nQuiz ID = $quiz_id"));
}
?>
