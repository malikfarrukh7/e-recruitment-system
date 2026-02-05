<?php
require_once '../config/db.php';
require_once '../classes/candidate.php';
require_once '../classes/recruiter.php';
require_once '../classes/application.php';

$database = new Database();
$db = $database->getConnection();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$type = $_GET['type'] ?? $_POST['type'] ?? '';
$id = $_GET['id'] ?? $_POST['id'] ?? '';
if ($type == 'candidate') {
    $user = new Candidate($db);
} elseif ($type == 'recruiter') {
    $user = new Recruiter($db,$application);
} else {
    exit("Invalid user type.");
}

switch ($action) {
    case 'activate':
        $user->updateStatus($id, 'active');
        break;
    case 'deactivate':
        $user->updateStatus($id, 'inactive');
        break;
    case 'delete':
        $user->delete($id);
        break;
}

header("Location: http://localhost/e-recruitment-system6/dashboard/ADboard/manage-users.php");
exit;
?>
