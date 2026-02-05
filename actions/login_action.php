<?php
// login_action.php
require_once '../config/db.php';
require_once '../classes/User.php';
require_once '../classes/Candidate.php';
require_once '../classes/Recruiter.php';
require_once '../classes/Admin.php';
session_start();

$database = new Database();
$db = $database->getConnection();

$id = $_POST['id'];  // Using 'id' to determine user type
$password = $_POST['password'];

// Determine the user type based on the first two characters of the ID
$user_type = null;

if (strpos($id, 'CD') === 0) {
    $user_type = 'candidate';
} elseif (strpos($id, 'RT') === 0) {
    $user_type = 'recruiter';
} elseif (strpos($id, 'AD') === 0) {
    $user_type = 'admin';
} else {
    echo "<script>
            alert('Invalid ID format.');
            window.location.href = '../pages/login.php';
          </script>";
    exit();
}

$user = null;

if ($user_type == 'candidate') {
    $user = new Candidate($db);
} elseif ($user_type == 'recruiter') {
    $user = new Recruiter($db,$application);
} elseif ($user_type == 'admin') {
    $user = new Admin($db);
}

if ($user) {
    $user->id = $id;  // Using ID for login
    $user->password = $password;

    if ($user->login()) {
        // Redirect to the appropriate dashboard based on user type
        if ($user_type == 'candidate') {
            header("Location: ../dashboard/CDboard/candidate_dashboard.php");
        } elseif ($user_type == 'recruiter') {
            header("Location: ../dashboard/RTboard/recruiter_dashboard.php");
        } elseif ($user_type == 'admin') {
            header("Location: ../dashboard/ADboard/admin_dashboard.php");
        }
    } else {
        echo "<script>
                alert('Login failed. Please try again.');
                window.location.href = '../pages/login.php';
              </script>";
    }
} else {
    echo "Invalid user type.";
}
?>
