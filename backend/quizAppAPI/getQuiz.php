<?php
// Include the database connection file
require_once 'db_connection.php';


if(isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];
    $user_email = $_GET['user_email'];

    $sql = "SELECT * FROM attempts WHERE user_email = ? AND quiz_id = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("si", $user_email, $quiz_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(array('msg' => 'You have already attempted this quiz before!'));
    } else{
        // Prepare and execute the SQL query to retrieve questions for the given quiz_id
        $sql = "SELECT * FROM quiz_questions WHERE quiz_id = ?";
        $query = $conn->prepare($sql);
        $query->bind_param("i", $quiz_id); // 'i' indicates integer type
        $query->execute();
        $result = $query->get_result();
    
        // Initialize an empty array to store questions data
        $questions = array();
    
        // Fetch questions and add them to the array
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $questions[] = array(
                    'question_text' => $row["question_text"],
                    'option1' => $row["option1"],
                    'option2' => $row["option2"],
                    'option3' => $row["option3"],
                    'option4' => $row["option4"],
                    'correct_option' => $row["correct_option"]
                );
            }
            // Close statement and database connection
            $query->close();
            $conn->close();
        
            // Encode the questions array to JSON format and output it
            header('Content-Type: application/json');
            echo json_encode($questions);
        }else{
            // Close statement and database connection
            $query->close();
            $conn->close();
    
            echo json_encode(array('msg' => 'Invalid Quiz ID'));
        }
    }
}
?>
