<?php
require_once '../../config/db.php';
require_once '../../classes/Application.php';
require_once '../../classes/Interview.php';

//session_start();
$db = new Database(); 
$conn = $db->getConnection();

if (!isset($_SESSION['set_id'])) {
    echo "<div class='alert alert-danger'>Please log in to access your dashboard.</div>";
    exit;
}

$recruiter_id = $_SESSION['set_id']; 
$application = new Application($conn); 
$interview = new Interview($conn);

$search_option = $_GET['search_option'] ?? null;
$search_input = $_GET['search_input'] ?? null;
$applications = $application->searchShortlistedApplications($search_option, $search_input, $recruiter_id);
$interviewCounts = $interview->getInterviewCounts();
$interviewCalendar = $interview->getCalendarRData($recruiter_id);

$groupedApplications = [];
if ($applications) {
    foreach ($applications as $app) {
        $groupedApplications[$app['job_name']][] = $app;
    }
}
?>

<div class="container mt-4">
    <h1>Shortlisted Applications</h1>

    <?php if (!empty($groupedApplications)): ?>
        <?php foreach ($groupedApplications as $jobTitle => $jobApplications): ?>
            <h3><?php echo htmlspecialchars($jobTitle); ?> Applications</h3>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Application ID</th>
                        <th>Candidate Name</th>
                        <th>Interview Date</th>
                        <th>Interview Time</th>
                        <th>Interview Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jobApplications as $app): 
                        $interviewDetails = $interview->getInterviewDetails($app['application_id']);
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($app['application_id']); ?></td>
                            <td><?php echo htmlspecialchars($app['candidate_name']); ?></td>
                            <td>
                                <form id="scheduleForm-<?php echo $app['application_id']; ?>" action="http://localhost/e-recruitment-system6/actions/schedule-interview.php" method="POST">
                                    <input type="hidden" name="application_id" value="<?php echo $app['application_id']; ?>">
                                    <input type="hidden" name="recruiter_id"  value="<?php echo htmlspecialchars($recruiter_id); ?>">
                                    <input type="hidden" name="candidate_id" value="<?php echo $app['candidate_id']; ?>">
                                    <input type="hidden" name="job_name" value="<?php echo htmlspecialchars($app['job_name']); ?>">

                                    <input type="date" class="form-control" name="interview_date" 
                                           value="<?php echo $interviewDetails ? htmlspecialchars($interviewDetails['interview_date']) : ''; ?>">
                            </td>
                            <td>
                                    <input type="time" class="form-control" name="interview_time" 
                                           value="<?php echo $interviewDetails ? htmlspecialchars($interviewDetails['interview_time']) : ''; ?>">
                            </td>
                            <td>
                                <?php echo $interviewDetails ? '<span class="text-success">Scheduled</span>' : '<span class="text-danger">Not Scheduled</span>'; ?>
                            </td>
                            <td>
                                <?php if ($interviewDetails): ?>
                                    <button type="submit" name="action" value="update" class="btn btn-primary">Update</button>
                                    <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                                <?php else: ?>
                                    <button type="submit" name="action" value="save" class="btn btn-success">Save</button>
                                <?php endif; ?>
                                </form>
                                <button class="btn btn-warning btn-sm" onclick="toggleNotificationForm('<?php echo $app['application_id']; ?>')">Send Notification</button>
    
                             <!-- Notification Form (Hidden by default) -->
                                <div id="notificationForm_<?php echo $app['application_id']; ?>" class="notification-form" style="display:none; margin-top: 10px;">
                                <form action="../../actions/send_notification2.php" method="POST">
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
                        
                        <?php if ($interviewDetails): ?>
                            <tr>
                                <td colspan="6" class="text-muted">
                                    <strong>Previously Scheduled Interview:</strong> 
                                    <?php echo htmlspecialchars($interviewDetails['interview_date']); ?> at <?php echo htmlspecialchars($interviewDetails['interview_time']); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>

        <h3>Interview Count Summary</h3>
<div class="row">
    <?php foreach ($interviewCounts as $count): ?>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($count['job_name']); ?></h5>
                    <p class="card-text">
                        <strong>Interview Date:</strong> <?php echo htmlspecialchars($count['interview_date']); ?><br>
                        <strong>Interview Time:</strong> <?php echo htmlspecialchars($count['interview_time']); ?><br>
                        <strong>Total Interviews:</strong> <?php echo htmlspecialchars($count['interview_count']); ?>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Form to add new Interview Count -->
<h3>Add Interview Summary To Calendar</h3>
<form action="http://localhost/e-recruitment-system6/actions/schedule-interview.php" method="POST">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Job Name</th>
                <th>Interview Date</th>
                <th>Interview Time</th>
                <th>Total Interviews</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" class="form-control" id="job_name" name="jobC_name" required>
                <input type="hidden" name="recruiter_id" value="<?php echo htmlspecialchars($recruiter_id); ?>">
                </td>
                <td><input type="date" class="form-control" id="interviewC_date" name="interviewC_date" required></td>
                <td><input type="time" class="form-control" id="interviewC_time" name="interviewC_time" required></td>
                <td><input type="number" class="form-control" id="interviewC_count" name="interview_count" required></td>
                <td>
                    <button type="submit" name="action" value="save_to_calendar" class="btn btn-success">Add</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<h3>Interview Calendar</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Recruiter ID</th>
            <th>Job Name</th>
            <th>Interview Date</th>
            <th>Interview Time</th>
            <th>Interview Count</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($interviewCalendar)): ?>
            <?php foreach ($interviewCalendar as $record): ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['id']); ?></td>
                    <td><?php echo htmlspecialchars($record['recruiter_id']); ?></td>
                    <td><?php echo htmlspecialchars($record['job_name']); ?></td>
                    <td><?php echo htmlspecialchars($record['interview_date']); ?></td>
                    <td><?php echo htmlspecialchars($record['interview_time']); ?></td>
                    <td><?php echo htmlspecialchars($record['interview_count']); ?></td>
                    <td>
                        <button 
                            class="btn btn-primary" 
                            onclick="toggleUpdateForm(<?php echo $record['id']; ?>)">
                            Update
                        </button>
                    </td>
                </tr>
                <!-- Hidden update form -->
                <tr id="update-form-<?php echo $record['id']; ?>" style="display: none;">
                    <td colspan="7">
                        <form action="http://localhost/e-recruitment-system6/actions/schedule-interview.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($record['id']); ?>">
                            <div class="row">
                                <div class="col-md-3">
                                <input type="hidden" name="recruiter_id" value="<?php echo htmlspecialchars($recruiter_id); ?>">
                                    <label for="job_name">Job Name</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="jobC_name" 
                                        value="<?php echo htmlspecialchars($record['job_name']); ?>" 
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label for="interview_date">Interview Date</label>
                                    <input 
                                        type="date" 
                                        class="form-control" 
                                        name="interviewC_date" 
                                        value="<?php echo htmlspecialchars($record['interview_date']); ?>" 
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label for="interview_time">Interview Time</label>
                                    <input 
                                        type="time" 
                                        class="form-control" 
                                        name="interviewC_time" 
                                        value="<?php echo htmlspecialchars($record['interview_time']); ?>" 
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label for="interview_count">Interview Count</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        name="interview_count" 
                                        value="<?php echo htmlspecialchars($record['interview_count']); ?>" 
                                        min="1" 
                                        required>
                                </div>
                            </div>
                            <button type="submit" name="action" value="Update_to_calendar" class="btn btn-success mt-3">Submit</button>
                            <button 
                                type="button" 
                                class="btn btn-secondary mt-3" 
                                onclick="toggleUpdateForm(<?php echo $record['id']; ?>)">
                                Cancel
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">No interview records found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

        
        <!-- Form to submit all interview counts to calendar 
        <form action="http://localhost/e-recruitment-system6/actions/schedule-interview.php" method="POST">
            <input type="hidden" name="recruiter_id" value="<?php echo htmlspecialchars($recruiter_id); ?>">
            <button type="submit" name="action" value="save_to_calendar" class="btn btn-info mt-3">Submit All Interview Counts to Calendar</button>
        </form> -->

    <?php else: ?>
        <p>No shortlisted applications found.</p>
    <?php endif; ?>
</div>

<!-- jQuery for View CV and View Qualifications functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function toggleNotificationForm(appId) {
        const form = document.getElementById('notificationForm_' + appId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function toggleUpdateForm(id) {
        const formRow = document.getElementById('update-form-' + id);
        formRow.style.display = formRow.style.display === 'none' ? 'table-row' : 'none';
    }
</script>