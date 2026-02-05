<?php
session_start();
require_once '../../config/db.php';
require_once '../../classes/candidate.php';
require_once '../../classes/recruiter.php';
require_once '../../classes/application.php';

// Database connection
$database = new Database();
$db = $database->getConnection();
$application = new Application($db);
$candidate = new Candidate($db);
$recruiter = new Recruiter($db,$application);

// Fetch all candidates and recruiters
$candidates = $candidate->getAllCandidates();
$recruiters = $recruiter->getAllRecruiters();

function displayUserTable($users, $userType) {
    echo "<h2>" . ucfirst($userType) . " Management</h2>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Actions</th></tr></thead>";
    echo "<tbody>";
    
    foreach ($users as $user) {
        $statusLabel = $user['status'] == 'active' ? 'Deactivate' : 'Activate';
        $statusAction = $user['status'] == 'active' ? 'deactivate' : 'activate';
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['name']) . "</td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td>" . htmlspecialchars($user['phone']) . "</td>";
        echo "<td>" . htmlspecialchars($user['status']) . "</td>";
        echo "<td>";
        echo "<a href='../../actions/admin_user_action.php?action=$statusAction&type=$userType&id=" . $user['id'] . "' class='btn btn-warning'>" . $statusLabel . "</a> ";
        echo "<form action='../../actions/admin_user_action.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this user?\")'>";
        echo "<input type='hidden' name='action' value='delete'>";
        echo "<input type='hidden' name='type' value='$userType'>";
        echo "<input type='hidden' name='id' value='" . $user['id'] . "'>";
        echo "<button type='submit' class='btn btn-danger'>Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</tbody></table>";
}

// Display tables for candidates and recruiters
displayUserTable($candidates, 'candidate');
displayUserTable($recruiters, 'recruiter');
?>
 