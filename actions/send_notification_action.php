<?php
require_once '../config/db.php';
require_once '../classes/Notification.php';
session_start();

$db = new Database(); 
$conn = $db->getConnection();
$notification = new Notification($conn);

// Ensure all required data is provided
if (isset($_POST['sender_id'], $_POST['receiver_id'], $_POST['application_id'], $_POST['subject'], $_POST['message'])) {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $application_id = $_POST['application_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Send notification
    if ($notification->sendNotification($sender_id, $receiver_id, $application_id, $subject, $message)) {
        echo "<div class='alert alert-success'>Notification sent successfully.</div>";
        header("Location: http://localhost/e-recruitment-system6/dashboard/RTboard/send-notification.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Failed to send notification.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>All fields are required.</div>";
}
?>
