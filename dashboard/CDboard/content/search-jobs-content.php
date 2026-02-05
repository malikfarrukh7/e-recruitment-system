<?php
include_once '../../config/db.php';
include_once '../../classes/Job.php';
include_once '../../classes/Application.php'; // Include the Application class

// Instantiate database and job object
$database = new Database();
$db = $database->getConnection();
$job = new Job($db);
$application = new Application($db); // Instantiate the Application class

// Get candidate_id from session
$candidate_id = isset($_SESSION['set_id']) ? $_SESSION['set_id'] : null;

// Check if search parameters are set
if (isset($_GET['search_input']) && !empty($_GET['search_input'])) {
    $search_option = isset($_GET['search_option']) && $_GET['search_option'] !== 'all' ? $_GET['search_option'] : null;
    $search_input = $_GET['search_input'];
    $jobs = $job->searchJobs($search_option, $search_input);
} else {
    // If no search is applied, fetch all jobs
    $jobs = $job->searchJobs();
}

 // Handle job application submission
//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id'])) {
  //  $job_id = $_POST['job_id'];
    //if ($candidate_id) {
      //  // Apply to the job using the Application class
        //$application->applyToJob($candidate_id, $job_id);
       // echo "<div class='alert alert-success'>Application submitted successfully!</div>";
    //} else {
      //  echo "<div class='alert alert-danger'>You need to be logged in to apply for a job.</div>";
    //}
//}
?>

<div class="container mt-4">
    <h1>Search Jobs</h1>
    <p>Search for job vacancies using a keyword (e.g., job title, location, or industry).</p>

    <!-- Search Form -->
    <form action="search-jobs.php" method="GET" class="job-search-form mb-4">
        <div class="form-group">
            <label>Search By:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="search_option" id="search_all" value="all" <?php echo (!isset($_GET['search_option']) || $_GET['search_option'] === 'all') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="search_all">Search in All Fields</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="search_option" id="search_title" value="title" <?php echo (isset($_GET['search_option']) && $_GET['search_option'] === 'title') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="search_title">Job Title</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="search_option" id="search_location" value="location" <?php echo (isset($_GET['search_option']) && $_GET['search_option'] === 'location') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="search_location">Location</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="search_option" id="search_industry" value="industry" <?php echo (isset($_GET['search_option']) && $_GET['search_option'] === 'industry') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="search_industry">Industry</label>
            </div>
        </div>

        <div class="form-group">
            <label for="search_input">Search:</label>
            <input type="text" name="search_input" id="search_input" class="form-control" placeholder="Search by keyword" value="<?php echo isset($_GET['search_input']) ? htmlspecialchars($_GET['search_input']) : ''; ?>">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Search Jobs</button>
            <a href="search-jobs.php" class="btn btn-secondary">Refresh</a>
        </div>
    </form>

    <!-- Job Listings -->
    <?php if (isset($jobs) && count($jobs) > 0): ?>
        <h3><?php echo isset($_GET['search_input']) ? 'Search Results' : 'All Job Listings'; ?></h3>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Job Title</th>
                    <th>Location</th>
                    <th>Industry</th>
                    <th>Requirements</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $index => $job): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($job['title']); ?></td>
                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                        <td><?php echo htmlspecialchars($job['industry']); ?></td>
                        <td><?php echo htmlspecialchars($job['requirements']); ?></td>
                        <td><?php echo htmlspecialchars($job['salary']); ?></td>
                        <td>
                            <!-- Job Apply Form -->
                            <!--<form action="Apply.php" method="POST" style="display:inline;">
                                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                <button type="submit" class="btn btn-success">Apply</button>
                            </form>  -->
                            <form action="Qualification.php?job_id=<?php echo $job['id']; ?>&job_title=<?php echo $job['title'];?> " method="POST" style="display:inline;">
                            <button type="submit" class="btn btn-success">Apply</button>
                             </form>

                            <!-- View Details Button -->
                            <button type="button" class="btn btn-info view-details-btn" data-index="<?php echo $index; ?>">View Details</button>
                        </td>
                    </tr>

                    <!-- Collapsible Job Details Row -->
                    <tr id="job-details-<?php echo $index; ?>" class="job-details-row" style="display:none;">
                        <td colspan="6">
                            <div class="job-details-content">
                                <strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?><br>
                                <strong>Status:</strong> <?php echo htmlspecialchars($job['status']); ?><br>
                                <strong>Posted Date:</strong> <?php echo htmlspecialchars($job['posted_date']); ?><br>
                                <strong>Last Modified:</strong> <?php echo htmlspecialchars($job['last_modified']); ?><br>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($jobs)): ?>
        <p>No jobs found for the search criteria.</p>
    <?php endif; ?>
</div>

<!-- jQuery for View Details functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Toggle job details on "View Details" button click
        $('.view-details-btn').on('click', function() {
            var index = $(this).data('index');
            $('#job-details-' + index).toggle(); // Toggle the corresponding details row
        });
    });
</script>
