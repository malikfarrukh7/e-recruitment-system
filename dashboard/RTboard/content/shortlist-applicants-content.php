<?php
require_once '../../config/db.php';
require_once '../../classes/Application.php';

//session_start();
$db = new Database(); 
$conn = $db->getConnection();

// Check if the recruiter is logged in
if (!isset($_SESSION['set_id'])) {
    echo "<div class='alert alert-danger'>Please log in to access your dashboard.</div>";
    exit;
}

$recruiter_id = $_SESSION['set_id'];  // Recruiter ID from session
$application = new Application($conn); // Application class instance

// Check if search parameters are set
if (isset($_GET['search_input']) && !empty($_GET['search_input'])) {
    $search_option = isset($_GET['search_option']) && $_GET['search_option'] !== 'all' ? $_GET['search_option'] : null;
    $search_input = $_GET['search_input'];
    $applications = $application->searchApplications($search_option, $search_input, $recruiter_id);
} else {
    // If no search is applied, fetch all applications for the recruiter
    $applications = $application->searchApplications(null, null, $recruiter_id);
}

// Group applications by job title
$groupedApplications = [];
if ($applications) {
    foreach ($applications as $app) {
        $groupedApplications[$app['job_name']][] = $app;
    }
}

?>

<div class="container mt-4">
    <h1>Search Applications</h1>




     <!-- Search Form -->
     <form action="shortlist-applicants.php" method="GET" class="application-search-form mb-4">
        <div class="form-group">
            <label>Search By:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="search_option" id="search_all" value="all" <?php echo (!isset($_GET['search_option']) || $_GET['search_option'] === 'all') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="search_all">Search in All Fields</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="search_option" id="search_job" value="j.title" <?php echo (isset($_GET['search_option']) && $_GET['search_option'] === 'j.title') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="search_job">Job Title</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="search_option" id="search_candidate" value="c.name" <?php echo (isset($_GET['search_option']) && $_GET['search_option'] === 'c.name') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="search_candidate">Candidate Name</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="search_option" id="search_status" value="a.status" <?php echo (isset($_GET['search_option']) && $_GET['search_option'] === 'a.status') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="search_status">Application Status</label>
            </div>
        </div>

        <div class="form-group">
            <label for="search_input">Search:</label>
            <input type="text" name="search_input" id="search_input" class="form-control" placeholder="Search by keyword" value="<?php echo isset($_GET['search_input']) ? htmlspecialchars($_GET['search_input']) : ''; ?>">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Search Applications</button>
            <a href="shortlist-applicants.php" class="btn btn-secondary">Refresh</a>

            <a href="generate-report.php?search_input=<?php echo isset($_GET['search_input']) ? htmlspecialchars($_GET['search_input']) : ''; ?>&search_option=<?php echo isset($_GET['search_option']) ? htmlspecialchars($_GET['search_option']) : ''; ?>" class="btn btn-success">Generate Report</a>
        </div>
    </form>

    <!-- Grouped Application Listings -->
    <?php if (!empty($groupedApplications)): ?>
        <?php foreach ($groupedApplications as $jobTitle => $jobApplications): ?>
            <h3><?php echo htmlspecialchars($jobTitle); ?> Applications</h3>
            <table class="table table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Application ID</th>
            <th>Candidate Name</th>
            <th>Required Percentage</th>
            <th>Application Status</th>
            <th>Change Status</th>
            <th>View CV</th>
            <th>View Qualifications</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($jobApplications as $app): ?>
            <tr>
                <td><?php echo htmlspecialchars($app['application_id']); ?></td>
                <td><?php echo htmlspecialchars($app['candidate_name']); ?></td>
                <td><?php echo htmlspecialchars($app['r_percentage']); ?>%</td>
                <td><?php echo htmlspecialchars($app['application_status']); ?></td>
                <td>
                    <form method="POST" action="../../actions/update_application_status.php">
                        <input type="hidden" name="application_id" value="<?php echo $app['application_id']; ?>">
                        <select name="status" class="form-control">
                            <option value="applied" <?php echo $app['application_status'] === 'applied' ? 'selected' : ''; ?>>Applied</option>
                            <option value="under review" <?php echo $app['application_status'] === 'under review' ? 'selected' : ''; ?>>Under Review</option>
                            <option value="shortlisted" <?php echo $app['application_status'] === 'shortlisted' ? 'selected' : ''; ?>>Shortlisted</option>
                            <option value="rejected" <?php echo $app['application_status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                        <button type="submit" class="btn btn-success btn-sm mt-2">Update</button>
                    </form>
                </td>
                <td>
                    <?php if (!empty($app['cv_file'])): ?>
                        <button class="btn btn-primary btn-sm view-cv" data-resume-url="../../uploads/<?php echo $app['cv_file']; ?>">View CV</button>
                    <?php else: ?>
                        <span class="text-muted">No CV uploaded</span>
                    <?php endif; ?>
                </td>
              <!--  <td><button class="btn btn-primary view-qualifications" data-application-id="<?php echo $app['application_id']; ?>">View Qualifications</button></td> --> 
              <td><button class="btn btn-primary view-qualifications" data-application-id="<?php echo $app['application_id']; ?>">View Qualifications</button></td>
            </tr>

            <tr class="qualification-details-row" data-application-id="<?php echo $app['application_id']; ?>" style="display:none;">
    <td colspan="6">
        <div class="qualification-details-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Degree Level</th>
                        <th>Major Subject</th>
                        <th>Institution</th>
                        <th>Percentage</th>
                        <th>Resume</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($app['degree_level']); ?></td>
                        <td><?php echo htmlspecialchars($app['major_subject']); ?></td>
                        <td><?php echo htmlspecialchars($app['institution']); ?></td>
                        <td><?php echo htmlspecialchars($app['obtained_percentage']); ?>%</td>
                        <td>
                            <?php if (!empty($app['resume_file_path'])): ?>
                                <a href="uploads/<?php echo $app['resume_file_path']; ?>" target="_blank" class="btn btn-primary btn-sm">View Resume</a>
                            <?php else: ?>
                                <span class="text-muted">No resume uploaded</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </td>
</tr>

        <?php endforeach; ?>
    </tbody>
</table>

        <?php endforeach; ?>
    <?php else: ?>
        <p>No applications found for the search criteria.</p>
    <?php endif; ?>
</div>

<!-- jQuery for View CV -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
/*$(document).ready(function() {


    $(document).ready(function() {
    // Toggle qualifications on "View Qualifications" button click
    $('.view-qualifications').on('click', function() {
        var applicationId = $(this).data('application-id');
        $('.qualification-details-row[data-application-id="' + applicationId + '"]').toggle();
    });

    // Open CV in a new window on "View CV" button click
    $('.view-cv').on('click', function() {
        var resumeUrl = $(this).data('resume-url');
        window.open(resumeUrl, '_blank');
    });
});*/

$(document).ready(function() {
    // Toggle qualifications on "View Qualifications" button click
    $('.view-qualifications').on('click', function() {
        var applicationId = $(this).data('application-id');
        $('.qualification-details-row[data-application-id="' + applicationId + '"]').toggle();
    });

    // Open CV in a new window on "View CV" button click
    $('.view-cv').on('click', function() {
        var resumeUrl = $(this).data('resume-url');
        window.open(resumeUrl, '_blank');
    });
});

</script>

