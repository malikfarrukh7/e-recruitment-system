<h2>Post Job Vacancy</h2>

<?php
// Display success or error message based on the query parameters
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<div class='alert alert-success' id='alert-message' role='alert'>Job created successfully!</div>";
} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
    echo "<div class='alert alert-danger' id='alert-message' role='alert'>Failed to create the job. Please try again.</div>";
}
?>

<form id="post-job-form" action="http://localhost/e-recruitment-system6/actions/recruiter_action.php" method="POST">
    <input type="hidden" name="action" value="post_job">
    <div class="mb-3">
        <label for="title" class="form-label">Job Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="job_category" class="form-label">Job Category</label>
        <input type="text" class="form-control" id="job_category" name="job_category" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Job Description</label>
        <textarea class="form-control" id="description" name="description" required></textarea>
    </div>
    <div class="mb-3">
        <label for="requirements" class="form-label">Requirements</label>
        <textarea class="form-control" id="requirements" name="requirements" required></textarea>
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Location</label>
        <input type="text" class="form-control" id="location" name="location" required>
    </div>
    <div class="mb-3">
        <label for="industry" class="form-label">Industry</label>
        <input type="text" class="form-control" id="industry" name="industry" required>
    </div>
    <div class="mb-3">
        <label for="salary" class="form-label">Salary</label>
        <input type="number" class="form-control" id="salary" name="salary">
    </div>
    <button type="submit" class="btn btn-primary">Post Job</button>
</form>

<!-- JavaScript to hide the alert after 5 seconds -->
<script>
    window.onload = function() {
        var alertMessage = document.getElementById('alert-message');
        if (alertMessage) {
            // Set timeout to remove the alert after 5 seconds (5000 milliseconds)
            setTimeout(function() {
                alertMessage.style.display = 'none';
            }, 1500);
        }
    };
</script>
