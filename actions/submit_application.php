<?php
require_once '../classes/Candidate.php';
require_once '../config/db.php';
session_start();
$database = new Database();
$db = $database->getConnection();
$candidate = new Candidate($db);
$candidate->id = $_SESSION['set_id'];  // Assuming the candidate is logged in

/* if ($_POST) {
    $jobId = $_POST['job_id'];
    $status = $_POST['status'];

    if ($candidate->submitApplication($jobId, $status)) {
        echo "Application submitted successfully!";
        header("location: http://localhost/e-recruitment-system6/dashboard/CDboard/Apply.php");
    } else {
        echo "Failed to submit application.";
    }
}*/
if ($_POST) {
    $jobId = $_POST['job_id'];
    $jobName =$_POST['job_title'];
    $rdPercentage= $_POST['rdobtained_percentage'];
    $status = $_POST['status'];

    if (isset($_FILES['cv_file_path'])) {
        $file_tmp = $_FILES['cv_file_path']['tmp_name'];
        $file_name = $_FILES['cv_file_path']['name'];
        $unique_id = uniqid(); // Generates a unique ID based on the current timestamp
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); // Get the file extension
        
        $target_dir = "../uploads/";
        //$target_file = $target_dir . basename($file_name);
        $target_file =$target_dir. $unique_id . '_' . basename($file_name, "." . $file_extension) . '.' . $file_extension;

        // Check for upload errors
        if ($_FILES['cv_file_path']['error'] !== UPLOAD_ERR_OK) {
            return "Error uploading file: " . $_FILES['cv_file_path']['error'];
        }

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($file_tmp, $target_file)) {
            // Set the file path in the qualification object
            $cv_file_path = $target_file; // Store the path for database
        } else {
            // Handle error if the file upload fails
            return "Error moving uploaded file.";
        }
    }
    
    
    //submitApplication($jobId, $jobName, $status = 'applied')

    //if ($candidate->submitApplication($jobId, $status))
    if ($candidate->submitApplication($jobId, $jobName,$rdPercentage, $cv_file_path , $status = 'applied')) {
        echo "Application submitted successfully!";
       // header("Location: http://localhost/e-recruitment-system6/dashboard/CDboard/Apply.php");
        //header("location: http://localhost/e-recruitment-system6/dashboard/CDboard/Apply.php?job_id=" . $jobId . "&job_title=" . urlencode($jobName));
        header("Location: http://localhost/e-recruitment-system6/dashboard/CDboard/job-applications.php");
    } else {
        echo "You have already applied for this job.";
    }
}
?>
