<?php
require_once 'db_connection.php';

if(isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];

    $sql = "SELECT * FROM attempts WHERE quiz_id = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $quiz_id);
    $query->execute();
    $result = $query->get_result();

    $quiz_attempts = array();
    
    // Fetch quiz_attempts and add them to the array
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $quiz_attempts[] = array(
                'user_email' => $row["user_email"],
                'score' => $row["score"]
            );
        }
        // Close statement and database connection
        $query->close();
        $conn->close();
    
        // Encode the quiz_attempts array to JSON format and output it
        echo json_encode($quiz_attempts);
    } else{
        echo json_encode(array('msg' => 'No attempts yet!'));
    }
}
?>