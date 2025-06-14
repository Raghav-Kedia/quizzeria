<?php
require_once 'db_connection.php';

if(isset($_GET['user_email'])) {
    $user_email = $_GET['user_email'];

    $sql = "SELECT * FROM quizzes WHERE user_email = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $user_email);
    $query->execute();
    $result = $query->get_result();

    $quiz_ids = array();
    
    // Fetch quiz_ids and add them to the array
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $quiz_ids[] = $row["quiz_id"];
        }
        // Close statement and database connection
        $query->close();
        $conn->close();
    
        // Encode the quiz_ids array to JSON format and output it
        echo json_encode($quiz_ids);
    }
}
?>