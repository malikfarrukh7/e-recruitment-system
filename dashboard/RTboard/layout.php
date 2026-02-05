<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Recruiter Dashboard'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            margin: 0;
            height: 100vh;
            
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #a3a7ff;
            color: #fff;
            height: 80px;
            padding: 20px;
            z-index: 1000;
        }
        .main-content {
            display: flex;
            flex-grow: 1;
            margin-top: 80px; /* Adjust to the height of the navbar */
        }
        .sidebar {
            position: fixed;
            top: 80px; /* Below the navbar */
            left: 0;
            width: 250px;
            background-color: #a3a7ff;
            height: calc(100vh - 80px); /* Full height minus navbar height */
            overflow-y: auto;
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
            margin-left: 250px; /* Adjust to the width of the sidebar */
            padding: 20px;
            flex-grow: 1;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<?php session_start(); ?>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="recruiter_dashboard.php" id="e-recruitment-system">E-Recruitment System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> 
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/e-recruitment-system6/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column p-3">
            <h4 class="text-white">Recruiter Menu</h4>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="recruiter_dashboard.php" class="nav-link <?php echo ($page === 'dashboard') ? 'active' : ''; ?>" id="dashboard-link" aria-current="page">Dashboard</a>
                </li>
                <li>
                    <a href="post-job.php" class="nav-link <?php echo ($page === 'post-job') ? 'active' : ''; ?>" id="post-job-link">Post Job Vacancy</a>
                </li>
                <li>
                    <a href="manage-jobs.php" class="nav-link <?php echo ($page === 'manage-jobs') ? 'active' : ''; ?>" id="manage-job-link">Manage Job Postings</a>
                </li>
                <li>
                    <a href="track-applicants.php" class="nav-link <?php echo ($page === 'track-applicants') ? 'active' : ''; ?>" id="track-applicants-link">Track Applicants</a>
                </li>
                <li> 
                    <a href="shortlist-applicants.php" class="nav-link <?php echo ($page === 'shortlist-applicants') ? 'active' : ''; ?>" id="sortlist-applicants">Shortlist Candidates</a>
                </li>
                <li> 
                    <a href="schedule-interview.php" class="nav-link <?php echo ($page === 'schedule-interview') ? 'active' : ''; ?>" id="schedule-interview">Schedule Interview</a>
                </li>
                <li> 
                    <a href="send-notification.php" class="nav-link <?php echo ($page === 'send-notification') ? 'active' : ''; ?>" id="send-notification">Send Notifications</a>
                </li>
                <li>
                    <a href="post-feedback.php" class="nav-link <?= ($page === 'post-feedback') ? 'active' : ''; ?>">Post Feedback</a>
                </li>
            </ul>
        </div>

        <!-- Dynamic Content Area -->
        <div class="content" id="content-area">
            <?php include($content); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
