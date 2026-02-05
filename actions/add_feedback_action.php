<?php
// Include the database connection
require_once '../config/db.php';
require_once '../classes/Feedback.php';

session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $userType = $_POST['user_type'];
    $userEmail = $_POST['user_email'];
    $message = $_POST['message'];

    // Validate the form data
    if (empty($userType) || empty($userEmail) || empty($message)) {
        die("All fields are required.");
    }

    try {
        // Initialize the database connection
        $database = new Database();
        $db = $database->getConnection();

        // Create an instance of the Feedback class
        $feedback = new Feedback($db, $userType, $userEmail, $message);

        // Add feedback
        if ($feedback->addFeedback()) {
            echo "Feedback submitted successfully.";
        } else {
            echo "Failed to submit feedback.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
