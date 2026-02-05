<?php

require_once '../config/db.php';
require_once '../classes/Candidate.php';
require_once '../classes/Recruiter.php';
require_once '../classes/Admin.php';
session_start();
$database = new Database();
$db = $database->getConnection();

$user_type = $_POST['user_type']; // 'candidate', 'recruiter', or 'admin'
$name = $_POST['name'];
$cnic = $_POST['cnic'];
$address = $_POST['address'];
$password = $_POST['password'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$town = $_POST['town'];
$region = $_POST['region'];
$postcode = $_POST['postcode'];
$country = $_POST['country'];

$user = null;
$assigned_id = ''; // To hold the generated ID

if ($user_type == 'candidate') {
    $user = new Candidate($db);
} elseif ($user_type == 'recruiter') {
    $user = new Recruiter($db,$application);
} elseif ($user_type == 'admin') {
    $user = new Admin($db);
}

if ($user) {
    $user->name = $name;
    $user->cnic = $cnic;
    $user->address = $address;
    $user->password = $password;
    $user->email = $email;
    $user->phone = $phone;
    $user->town = $town;
    $user->region = $region;
    $user->postcode = $postcode;
    $user->country = $country;

    // Generate unique ID based on user type
    $assigned_id = $user->generateUniqueId();
    $user->id = $assigned_id;

    if ($user->register()) {
        // Use JavaScript to show alert and then redirect
        echo "<script type='text/javascript'>
                alert('Registration successful. Your assigned ID is: " . $assigned_id . "');
                window.location.href = '../pages/login.php';
              </script>";
    } else {
        echo "Unable to register.";
    }
} else {
    echo "Invalid user type.";
}
?>
