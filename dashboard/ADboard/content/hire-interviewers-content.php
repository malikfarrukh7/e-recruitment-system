<?php
// File: index.php
require_once '../../config/db.php';
require '../../classes/Admin.php';

// Database configuration
$database = new Database();
$db = $database->getConnection();

// Initialize Admin class
$admin = new Admin($db);

// Fetch calendar data
$calendarData = $admin->getCalendarSData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar Data</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Calendar Data</h1>

    <!-- Loop through calendar data and display the table with dynamic form visibility -->
    <?php foreach ($calendarData as $row): ?>
        <h3>Hire Interviewers For Job: <?= htmlspecialchars($row['job_name']) ?></h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recruiter ID</th>
                    <th>Interview Date</th>
                    <th>Interview Time</th>
                    <th>Interview Count</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['recruiter_id']) ?></td>
                    <td><?= htmlspecialchars($row['interview_date']) ?></td>
                    <td><?= htmlspecialchars($row['interview_time']) ?></td>
                    <td><?= htmlspecialchars($row['interview_count']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td>
                        <!-- Button to trigger JavaScript function for showing the form -->
                        <button class="btn btn-primary btn-sm" onclick="toggleInterviewerForm(<?= $row['id'] ?>)">Add Interviewer</button>

                        <!-- Form to add an interviewer, initially hidden -->
                        <div id="form-<?= $row['id'] ?>" style="display: none; margin-top: 10px;">
                            <form action="http://localhost/e-recruitment-system6/actions/add_interviewer.php" method="post" class="row g-3">
                                <input type="hidden" name="calendar_id" value="<?= $row['id'] ?>">
                                <div class="col-md-4">
                                    <input type="text" name="name" class="form-control" placeholder="Interviewer Name" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="email" name="email" class="form-control" placeholder="Interviewer Email" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="phone_number" class="form-control" placeholder="Phone Number">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </td> 
                </tr>

                <!-- Fetch and display interviewer details for this calendar entry -->
                <?php 
                    $interviewerDetails = $admin->getinterviewerWithCalendar($row['id']);
                    if (!empty($interviewerDetails)): 
                ?>
                <tr>
                    <td colspan="7">
                        <strong>interviewer Details:</strong>
                        <table class="table table-sm table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>interviewer ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Send Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($interviewerDetails as $interviewer): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($interviewer['interviewer_id']) ?></td>
                                        <td><?= htmlspecialchars($interviewer['interviewer_name']) ?></td>
                                        <td><?= htmlspecialchars($interviewer['interviewer_email']) ?></td>
                                        <td><?= htmlspecialchars($interviewer['interviewer_phone']) ?></td>
                                        <td>
            <form action="http://localhost/e-recruitment-system6/actions/send_email.php" method="post">
                <input type="hidden" name="email" value="<?= htmlspecialchars($manager['interviewer_email']) ?>">
                <input type="hidden" name="name" value="<?= htmlspecialchars($manager['interviewer_name']) ?>">
                <button type="submit" class="btn btn-info btn-sm">Send Email</button>
            </form>
        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</div>

<!-- JavaScript to toggle the visibility of the interviewer form -->
<script>
function toggleInterviewerForm(calendarId) {
    var form = document.getElementById('form-' + calendarId);
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
