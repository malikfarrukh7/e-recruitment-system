<?php
/*require_once '../classes/Candidate.php';
require_once '../config/db.php';
session_start();

$database = new Database();
$db = $database->getConnection();
$candidate = new Candidate($db);
$candidate->id = $_SESSION['set_id'];  // Assuming the candidate is logged in

// Check if job_id is set in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];  // Get job ID from the URL
} else {
    echo "<p>No job selected for application.</p>";
    exit; // Prevent further execution if no job_id is present
}

if ($_POST) {
    $degree_level = $_POST['degree_level'];
    $major_subject = $_POST['major_subject'];
    $institution = $_POST['institution'];
    $obtained_percentage = $_POST['obtained_percentage'];
    $resume_file_path = $_POST['resume_file_path'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Add the qualification using the Candidate class method
    if ($candidate->addQualification($degree_level, $major_subject, $institution, $obtained_percentage, $resume_file_path, $start_date, $end_date)) {
        // Qualification added successfully, now redirect with the job_id in the URL
        header("location: http://localhost/e-recruitment-system6/dashboard/CDboard/Qualification.php?job_id=" . $job_id);
        exit();  // Make sure to exit after the redirect to prevent further script execution
    } else {
        echo "Failed to add qualification.";
    }
}*/

require_once '../classes/Candidate.php';
require_once '../config/db.php';
session_start();

$database = new Database();
$db = $database->getConnection();
$candidate = new Candidate($db);
$candidate->id = $_SESSION['set_id'];  // Assuming the candidate is logged in

// Check if job_id is set in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];  // Get job ID from the URL
} else {
    echo "<p>No job selected for application.</p>";
    exit; // Prevent further execution if no job_id is present
}

// Get job title if it exists
$job_title = isset($_GET['job_title']) ? $_GET['job_title'] : '';

// Handle form submission
if ($_POST) {
    $degree_level = $_POST['degree_level'];
    $major_subject = $_POST['major_subject'];
    $institution = $_POST['institution'];
    $obtained_percentage = $_POST['obtained_percentage'];
//    $resume_file_path = $_POST['resume_file_path'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (isset($_FILES['resume_file_path'])) {
        $file_tmp = $_FILES['resume_file_path']['tmp_name'];
        $file_name = $_FILES['resume_file_path']['name'];
        $unique_id = uniqid(); // Generates a unique ID based on the current timestamp
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); // Get the file extension
        
        $target_dir = "../uploads/";
        //$target_file = $target_dir . basename($file_name);
        $target_file =$target_dir. $unique_id . '_' . basename($file_name, "." . $file_extension) . '.' . $file_extension;

        // Check for upload errors
        if ($_FILES['resume_file_path']['error'] !== UPLOAD_ERR_OK) {
            return "Error uploading file: " . $_FILES['resume_file_path']['error'];
        }

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($file_tmp, $target_file)) {
            // Set the file path in the qualification object
            $resume_file_path = $target_file; // Store the path for database
        } else {
            // Handle error if the file upload fails
            return "Error moving uploaded file.";
        }
    }


    // Add the qualification using the Candidate class method
    if ($candidate->addQualification($degree_level, $major_subject, $institution, $obtained_percentage, $resume_file_path, $start_date, $end_date)) {
        // Qualification added successfully, now redirect with the job_id in the URL
        header("location: http://localhost/e-recruitment-system6/dashboard/CDboard/Qualification.php?job_id=" . $job_id . "&job_title=" . urlencode($job_title));
        exit();  // Make sure to exit after the redirect to prevent further script execution
    } else {
        echo "<div class='alert alert-danger'>Failed to add qualification.</div>";
    }
}
?>
