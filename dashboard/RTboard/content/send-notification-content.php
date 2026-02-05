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
/*print_r($app);*/
?>

<div class="container mt-4">
    <h1>Search Applications</h1>
    <p>Search for applications based on candidate name, job title, or status.</p>

    <!-- Search Form -->
    <form action="send-notification.php" method="GET" class="application-search-form mb-4">
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
            <a href="send-notification.php" class="btn btn-secondary">Refresh</a>

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
                        <th>Send Notification</th> 
                        
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
    <button class="btn btn-warning btn-sm" onclick="toggleNotificationForm('<?php echo $app['application_id']; ?>')">Send Notification</button>
    <button class="btn btn-info btn-sm">Send Email</button>
    
    <!-- Notification Form (Hidden by default) -->
    <div id="notificationForm_<?php echo $app['application_id']; ?>" class="notification-form" style="display:none; margin-top: 10px;">
    <form action="../../actions/send_notification_action.php" method="POST">
        <input type="hidden" name="sender_id" value="<?php echo $recruiter_id; ?>">
        <input type="hidden" name="receiver_id" value="<?php echo $app['candidate_id']; ?>">
        <input type="hidden" name="application_id" value="<?php echo $app['application_id']; ?>">

        <div class="form-group">
            <label for="receiver_name">Receiver Name</label>
            <input type="text" class="form-control" name="receiver_name" value="<?php echo htmlspecialchars($app['candidate_name']); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" class="form-control" name="subject" placeholder="Enter notification subject" required>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" name="message" rows="3" placeholder="Enter your notification message" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Notification</button>
    </form>
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

<!-- jQuery for View CV and View Qualifications functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function toggleNotificationForm(appId) {
        const form = document.getElementById('notificationForm_' + appId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>