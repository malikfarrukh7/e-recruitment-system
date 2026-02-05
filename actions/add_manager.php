<?php
require_once '../config/db.php';
require '../classes/Admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    $calendar_id = $_POST['calendar_id'] ?? null;

    if ($name && $email && $calendar_id) {
        $database = new Database();
        $db = $database->getConnection();
        $admin = new Admin($db);

        if ($admin->addManager($name, $email, $phone_number, $calendar_id)) {
            header('Location: http://localhost/e-recruitment-system6/dashboard/ADboard/hire-managers.php');
            exit;
        } else {
            header('Location: index.php?error=1');
            exit;
        }
    } else {
        header('Location: index.php?error=1');
        exit;
    }
}
?>
