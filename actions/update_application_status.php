<?php
require_once '../config/db.php';
require_once '../classes/Application.php';

session_start();

// Check if the recruiter is logged in
if (!isset($_SESSION['set_id'])) {
    echo "<div class='alert alert-danger'>Please log in to update the status.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_id = $_POST['application_id'];
    $new_status = $_POST['status'];

    $db = new Database();
    $conn = $db->getConnection();
    $application = new Application($conn);

    if ($application->updateStatus($application_id, $new_status)) {
        echo "<div class='alert alert-success'>Application status updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to update application status.</div>";
    }

    // Redirect back to the previous page
    header('Location: http://localhost/e-recruitment-system6/dashboard/RTboard/shortlist-applicants.php');
    exit;
}
