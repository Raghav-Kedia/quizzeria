<?php
// Include the database connection file
require_once 'db_connection.php';

if(isset($_GET['user_email'])) {
    $user_email = $_GET['user_email'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $user_email);
    $query->execute();
    $result = $query->get_result();

    // Fetch questions and add them to the array
    if($result->num_rows == 0) {
        $sql = "INSERT INTO users(email) VALUE (?)";
        $query = $conn->prepare($sql);
        $query->bind_param("s", $user_email);
        $query->execute();
    }

    echo json_encode(array('msg' => 'successful'));
}
?>
