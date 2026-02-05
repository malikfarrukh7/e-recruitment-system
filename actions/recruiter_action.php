<?php
require_once '../config/db.php';
require_once '../classes/Job.php';
session_start();

// Check if the recruiter is logged in
if (!isset($_SESSION['set_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

// Establish database connection
$database = new Database();
$db = $database->getConnection();

// Handle different recruiter actions (POST and GET)
$method = $_SERVER['REQUEST_METHOD'];
$action = $method === 'POST' ? $_POST['action'] ?? '' : ($_GET['action'] ?? '');

switch ($action) {
    case 'post_job':
        if ($method === 'POST') {
            postJob($db);
        }
        break;
    case 'update_job':
        if ($method === 'POST') {
            updateJob($db);
        }
        break;
    case 'delete_job':
        if ($method === 'POST') {
            deleteJob($db);
        }
        break;
    case 'fetch_jobs':
        if ($method === 'GET') {
            fetchJobs($db);
        }
        break;
    case 'activate':
            if ($method === 'GET') {
                changeJobStatus($db, 'active');
            }
            break;
    case 'deactivate':
            if ($method === 'GET') {
                changeJobStatus($db, 'inactive');
            }
            break;
   // default:
       // header("Location: ../pages/recruiter_dashboard.php?error=invalid_action");
        exit();
}
fetchJobs($db);

// Function to handle posting a new job
// Function to handle posting a new job
function postJob($db) {
    $job = new Job($db);
    $job->recruiter_id = $_SESSION['set_id'];
    $job->job_category = $_POST['job_category'];
    $job->title = $_POST['title'];
    $job->description = $_POST['description'];
    $job->requirements = $_POST['requirements'];
    $job->location = $_POST['location'];
    $job->industry = $_POST['industry'];
    $job->salary = $_POST['salary'];
    $job->posted_date = date('Y-m-d H:i:s');
    $job->status = 'Active';

    if ($job->createJob()) {
        echo "Job created successfully"; 
        // Redirect to the form with a success message
        header("Location: ../dashboard/RTboard//post-job.php?success=1");
    } else {
        // Redirect to the form with an error message
        header("Location: ../pages/post-job.php?error=1");
    }
}


// Function to update a job
function updateJob($db) {
    $job = new Job($db);
    $job->id = $_POST['job_id'];
    $job->title = $_POST['title'];
    $job->description = $_POST['description'];
    $job->requirements = $_POST['requirements'];
    $job->location = $_POST['location'];
    $job->industry = $_POST['industry'];
    $job->salary = $_POST['salary'];
    $job->last_modified = date('Y-m-d H:i:s');

    if ($job->updateJob()) {
        header("Location: ../dashboard/RTboard//manage-jobs.php?success=job_updated");
    } else {
        header("Location: ../pages/recruiter_dashboard.php?error=job_update_failed");
    }
}

// Function to delete a job
function deleteJob($db) {
    $job = new Job($db);
    $job->id = $_POST['job_id'];

    if ($job->deleteJob()) {
        header("Location: ../dashboard/RTboard//manage-jobs.php?success=job_deleted");
    } else {
        header("Location: ../pages/recruiter_dashboard.php?error=job_delete_failed");
    }
}

// Function to fetch all jobs for the recruiter
function fetchJobs($db) {
    $job = new Job($db);
    $recruiterId = $_SESSION['set_id'];
    $jobs = $job->getJobsByRecruiter($recruiterId);
    //header("Location: ../R//manage-jobs.php");
    return $jobs;
    echo json_encode($jobs); // Return jobs as JSON for potential AJAX requests
}

function changeJobStatus($db, $new_status) {
    $job = new Job($db);
    $job->id = $_GET['id']; // Get job ID from URL
    $job->status = $new_status;
    
    if ($job->updateStatus()) {
        header("Location: ../dashboard/RTboard/manage-jobs.php?success=job_status_changed");
    } else {
        header("Location: ../pages/recruiter_dashboard.php?error=job_status_change_failed");
    }
}
?>
