<?php
// Start the session
session_start();

// Include configuration and necessary classes
/*require_once 'config/db.php';
require_once 'classes/User.php';
require_once 'classes/Candidate.php';
require_once 'classes/Recruiter.php';
require_once 'classes/Admin.php';*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Recruitment System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar-custom {
            background-color: #a3a7ff; /* Deep Blue */
        }
        .navbar-custom .navbar-nav .nav-link,
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-toggler-icon {
            color: white; /* White text */
        }
        .btn-outline-custom {
            color: white;
            border-color: white;
            margin-left: 10px;
        }
        .btn-outline-custom:hover {
            background-color: white;
            color: #a3a7ff;
        }
        .bd{
            background-image: url('images/pexels-karolina-grabowska-5904062.jpg');
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            height: 100vh; /* Ensure the body takes up the full viewport height */
            /*background-image: url('images/background.jpg'); */
            background-size: cover; /* Make the background image cover the entire page */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            background-attachment: fixed; 
        }
        .background {
    position: relative; /* Ensure the container is positioned relatively */
    color: white; /* Text color */
    padding: 50px; /* Adds some padding around the text */
    text-align: center; /* Centers the text horizontally */
    z-index: 1; /* Places the content above the background */
}

.background::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('images/wave_background_5-scaled.jpg');
    background-size: cover; /* Makes the image cover the entire container */
    background-position: center; /* Centers the image */
    opacity: 0.4; /* 30% transparency */
    z-index: -1; /* Places the background behind the content */
}

        
    </style>
</head>
<body class=bd>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navid">
        <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="index.php">E-Recruitment System</a>
        <div class="collapse navbar-collapse" id="navid">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="pages/about.php" class="nav-link">About Us</a></li>
                <li class="nav-item"><a href="pages/services.php" class="nav-link">Our Services</a></li>
                <li class="nav-item"><a href="pages/team.php" class="nav-link">Team</a></li>
                <li class="nav-item"><a href="pages/contact.php" class="nav-link">Contact Us</a></li>
            </ul>
            <form class="d-flex me-3">
                <input type="search" name="search" placeholder="Search here..." class="form-control">
                <button class="btn btn-outline-custom" type="submit">Search</button>
            </form>
            <a href="pages/login.php" class="btn btn-light me-2">Login</a>
            <a href="pages/register.php" class="btn btn-light">Register</a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class=background>
  <div class="container mt-5">
    <h1 class="display-4">Welcome to E-Recruitment System</h1>
        <p class="lead">Find your dream job or the perfect candidate with our easy-to-use e-recruitment platform.</p>
       
        </div>
</div>
<div>
    <button class="btn btn-outline-custom" type="submit" id="">IT</button> 
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
