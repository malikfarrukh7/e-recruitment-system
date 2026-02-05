<?php
session_start();
if (!isset($_SESSION['set_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$adminDetails = [
    'id' => $_SESSION['set_id'],
    'name' => $_SESSION['set_name'],
    'email' => $_SESSION['set_email']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Candidate Dashboard'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        .navbar {
            background-color: #a3a7ff;
            color: #fff;
            height: 80px;
            padding: 20px;
        }
        .main-content {
            display: flex;
            flex-grow: 1;
            height: 100%;
        }
        .sidebar {
            width: 250px;
            background-color: #a3a7ff;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link.active {
            background-color: #8f92e6;
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #8f92e6;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">E-Recruitment System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column p-3">
            <h4 class="text-white">Candidate Menu</h4>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="candidate_dashboard.php" class="nav-link <?= ($page === 'dashboard') ? 'active' : ''; ?>">Dashboard</a>
                </li>
                <li>
                    <a href="search-jobs.php" class="nav-link <?= ($page === 'search-jobs') ? 'active' : ''; ?>">Search /Apply Jobs</a>
                </li>
                <li>
                    <a href="job-applications.php" class="nav-link <?= ($page === 'job-applications') ? 'active' : ''; ?>">My Applications</a>
                </li>
                <li>
                    <a href="job-alerts.php" class="nav-link <?= ($page === 'job-alerts') ? 'active' : ''; ?>">Job Alerts</a>
                </li>

                <li>
                    <a href="social-media.php" class="nav-link <?= ($page === 'social-media') ? 'active' : ''; ?>">Share Job on Social Media</a>
                </li>
                <li>
                    <a href="post-feedback.php" class="nav-link <?= ($page === 'post-feedback') ? 'active' : ''; ?>">Post Feedback</a>
                </li>
        </div>

        <!-- Dynamic Content Area -->
        <div class="content">
            <?php include($content); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
