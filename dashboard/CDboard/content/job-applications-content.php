<div class="card mb-4">
<div class="card-body">
    <h3>Your Applications</h3>
    <p>Check the status of your job applications here.</p>
<?php
 require_once '../../config/db.php';
 require_once '../../classes/Candidate.php';
 $db = new Database(); 
 $conn = $db->getConnection();

 if (!isset($_SESSION['set_id'])) {
     echo "<div class='alert alert-danger'>Please log in to access your dashboard.</div>";
     exit;
 }
 $candidate = new Candidate($conn); 
$candidate->id = $_SESSION['set_id']; 
   /* $applications = $candidate->viewApplications();

   if (!empty($applications)) {
        echo "<ul class='list-group'>";
        foreach ($applications as $a) {
            echo "<li class='list-group-item'>Job ID: {$a['job_id']},Job Name: {$a['job_name']}, Status: {$a['status']}, Applied Date: {$a['applied_date']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p class='text-muted'>No applications found.</p>";
    }*/
    
    $applications = $candidate->viewApplications();
    
    if (!empty($applications)) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Job ID</th>";
        echo "<th>Job Name</th>";
        echo "<th>Status</th>";
        echo "<th>Applied Date</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        foreach ($applications as $a) {
            echo "<tr>";
            echo "<td>{$a['job_id']}</td>";
            echo "<td>{$a['job_name']}</td>";
            echo "<td>{$a['status']}</td>";
            echo "<td>{$a['applied_date']}</td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p class='text-muted'>No applications found.</p>";
    }

?>

</div>
</div>