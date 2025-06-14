<?php
// Include the database connection file
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $postData = file_get_contents('php://input');
    
    // Decode the JSON data
    $postDataArray = json_decode($postData, true); // true for associative array


    $sql = "INSERT INTO attempts(user_email, quiz_id, score) VALUES (?, ?, ?)";
    $query = $conn->prepare($sql);
    $query->bind_param("sii", $postDataArray["user_email"], $postDataArray["quiz_id"], $postDataArray["score"]);
    $query->execute();

    $score = $postDataArray["score"];
    echo json_encode(array('msg' => "Your Score = $score" ));
}
?>