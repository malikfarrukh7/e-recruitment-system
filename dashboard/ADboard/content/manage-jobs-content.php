<?php
session_start();
require_once '../../classes/job.php';
require_once '../../config/db.php';

// Database connection
$database = new Database();
$db = $database->getConnection();
$job = new Job($db);

try {
    // Fetch all jobs with recruiter details
    $jobs = $job->getAllJobsWithRecruiterDetails();

    if ($jobs) {
        // Group jobs by recruiter
        $recruiterJobs = [];
        foreach ($jobs as $job) {
            $recruiterJobs[$job['recruiter_name']][] = $job;
        }

        // Display each recruiter's jobs
        foreach ($recruiterJobs as $recruiterName => $recruiterJobsList) {
            echo "<h2>Jobs Posted by " . htmlspecialchars($recruiterName) . "</h2>";
            echo "<table class='table table-striped'>";
            echo "<thead><tr><th>Title</th><th>Location</th><th>Industry</th><th>Status</th><th>Posted Date</th><th>Actions</th></tr></thead>";
            echo "<tbody>";
            
            foreach ($recruiterJobsList as $job) {
                echo "<tr id='job-row-{$job['id']}'>";
                echo "<td>" . htmlspecialchars($job['title']) . "</td>";
                echo "<td>" . htmlspecialchars($job['location']) . "</td>";
                echo "<td>" . htmlspecialchars($job['industry']) . "</td>";
                echo "<td>" . htmlspecialchars($job['status']) . "</td>";
                echo "<td>" . htmlspecialchars($job['posted_date']) . "</td>";
                echo "<td>";
                echo "<a href='#' class='btn btn-primary' onclick='showEditForm({$job['id']})'>Edit</a> ";
                if ($job['status'] == 'active') {
                    echo "<a href='http://localhost/e-recruitment-system6/actions/admin_action.php?action=deactivate&id=" . $job['id'] . "' class='btn btn-warning'>Deactivate</a> ";
                } else {
                    echo "<a href='http://localhost/e-recruitment-system6/actions/admin_action.php?action=activate&id=" . $job['id'] . "' class='btn btn-success'>Activate</a> ";
                }
                echo "<form action='http://localhost/e-recruitment-system6/actions/admin_action.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this job?\")'>";
                echo "<input type='hidden' name='action' value='delete_job'>";
                echo "<input type='hidden' name='job_id' value='" . $job['id'] . "'>";
                echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";

                // Hidden form below each row for editing the job
                echo "<tr id='edit-form-row-{$job['id']}' style='display:none;'>";
                echo "<td colspan='6'>";
                echo "<form id='edit-job-form-{$job['id']}' action='http://localhost/e-recruitment-system6/actions/admin_action.php' method='POST'>";
                echo "<input type='hidden' name='action' value='update_job'>";
                echo "<input type='hidden' name='job_id' value='{$job['id']}'>";
                echo "<div class='form-group'>";
                echo "<label for='title-{$job['id']}'>Job Title</label>";
                echo "<input type='text' name='title' id='title-{$job['id']}' class='form-control' value='" . htmlspecialchars($job['title']) . "' required>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label for='location-{$job['id']}'>Location</label>";
                echo "<input type='text' name='location' id='location-{$job['id']}' class='form-control' value='" . htmlspecialchars($job['location']) . "' required>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label for='industry-{$job['id']}'>Industry</label>";
                echo "<input type='text' name='industry' id='industry-{$job['id']}' class='form-control' value='" . htmlspecialchars($job['industry']) . "' required>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label for='description-{$job['id']}'>Job Description</label>";
                echo "<textarea name='description' id='description-{$job['id']}' class='form-control' required>" . htmlspecialchars($job['description']) . "</textarea>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label for='salary-{$job['id']}'>Salary</label>";
                echo "<input type='number' name='salary' id='salary-{$job['id']}' class='form-control' value='" . htmlspecialchars($job['salary']) . "'>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-success mt-3'>Update Job</button>";
                echo "<button type='button' class='btn btn-secondary mt-3' onclick='hideEditForm({$job['id']})'>Cancel</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        }
    } else {
        echo "<p>No jobs found.</p>";
    }
} catch (PDOException $e) {
    echo "Error fetching jobs: " . $e->getMessage();
}
?>

<!-- JavaScript to toggle the visibility of the edit form -->
<script>
function showEditForm(jobId) {
    var formRow = document.getElementById('edit-form-row-' + jobId);
    formRow.style.display = formRow.style.display === 'none' ? 'table-row' : 'none';
}

function hideEditForm(jobId) {
    var formRow = document.getElementById('edit-form-row-' + jobId);
    formRow.style.display = 'none';
}
</script>
