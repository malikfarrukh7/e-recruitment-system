<?php
// File: delete_feedback.php
require_once '../../config/db.php';
require '../../classes/Feedback.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the feedback ID from the POST request
    $feedbackId = $_POST['id'] ?? null;

    if ($feedbackId) {
        // Initialize database connection
        $database = new Database();
        $db = $database->getConnection();

        // Initialize Feedback class
        $feedback = new Feedback($db);

        // Delete the feedback
        if ($feedback->deleteFeedback($feedbackId)) {
            header('Location: view_feedback.php?message=Feedback deleted successfully.');
            exit;
        } else {
            header('Location: view_feedback.php?error=Failed to delete feedback.');
            exit;
        }
    } else {
        header('Location: view_feedback.php?error=Invalid feedback ID.');
        exit;
    }
}
?>
