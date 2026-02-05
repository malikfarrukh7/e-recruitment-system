<?php
require_once '../../config/db.php';
require_once '../../classes/Application.php';

session_start();
$db = new Database(); 
$conn = $db->getConnection();

// Check if recruiter is logged in
if (!isset($_SESSION['set_id'])) {
    echo "<div class='alert alert-danger'>Please log in to access this functionality.</div>";
    exit;
}

$recruiter_id = $_SESSION['set_id'];  // Recruiter ID from session
$application = new Application($conn); // Application class instance

// Get search parameters from URL
$search_option = isset($_GET['search_option']) ? $_GET['search_option'] : null;
$search_input = isset($_GET['search_input']) ? $_GET['search_input'] : null;

// Fetch applications
$applications = $application->searchApplications($search_option, $search_input, $recruiter_id);

// Check if there are any applications to report
if (empty($applications)) {
    echo "<div class='alert alert-danger'>No applications found to generate a report.</div>";
    exit;
}

// Set the headers to download the report as a CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="candidate_report.csv"');

// Open output stream for writing CSV content
$output = fopen('php://output', 'w');

// Write the header row
fputcsv($output, ['Application ID', 'Job Title', 'Candidate Name', 'Required Percentage', 'Application Status']);

// Write data rows
foreach ($applications as $app) {
    fputcsv($output, [
        $app['application_id'],
        $app['job_name'],
        $app['candidate_name'],
        $app['r_percentage'] . '%',
        $app['application_status']
    ]);
}

// Close the output stream
fclose($output);
exit;
?>
