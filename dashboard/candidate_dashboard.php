<?php
//require_once '../config/db.php';
require_once '../classes/Candidate.php';
session_start();
if (!isset($_SESSION['set_id'])) {
    header("Location:../pages/login.php"); // Redirect to login if not logged in
    exit();
}

// Create a database connection
//$database = new Database();
//$db = $database->getConnection();

// Create an instance of the Admin class
///$admin = new Admin($db);

// Get admin details from session
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
    <title>Candidate Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        .navbar {
            background-color: #a3a7ff; /* Custom color */
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
            background-color: #a3a7ff; /* Custom color */
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link.active {
            background-color: #8f92e6; /* Custom color for active link */
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #8f92e6; /* Slightly darker shade for hover */
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
            <a class="navbar-brand" href="#" id="e-recruitment-system">E-Recruitment System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
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
                    <a href="#" class="nav-link active" id="dashboard-link" aria-current="page">Dashboard</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="search-jobs-link">Search Jobs</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="job-applications-link">My Applications</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="job-alerts-link">Job Alerts</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="application-status-link">Application Status</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="social-media-sharing-link">Share Job on Social Media</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="post-feedback-link">Post Feedback</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="settings-link">Settings</a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="content" id="content-area">
            <h1>Welcome <?= htmlspecialchars($adminDetails['name']); ?> to Your Candidate Dashboard, !</h1>
            <p>E-Recruitment System: Helping you find the right job with ease and efficiency.</p>
            <p>Select an option from the sidebar to manage your job search, applications, and more.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle navigation clicks and switch active tab
        document.querySelectorAll('.sidebar .nav-link, .navbar-brand').forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                // Remove active class from all nav-links
                document.querySelectorAll('.sidebar .nav-link').forEach(function (link) {
                    link.classList.remove('active');
                });

                // Add active class to the clicked link
                if (event.target.classList.contains('nav-link')) {
                    event.target.classList.add('active');
                }

                // Update the content area based on the clicked link
                const contentArea = document.getElementById('content-area');
                switch (event.target.id) {
                    case 'e-recruitment-system':
                        contentArea.innerHTML = `
                            <h1>Welcome <?= htmlspecialchars($adminDetails['name']);?> To E-Recruitment System!</h1>
                            <p>E-Recruitment System: Helping you find the right job with ease and efficiency.</p>
                            <p>Select an option from the sidebar to manage your job search, applications, and more.</p>
                        `;
                        break;
                    case 'dashboard-link':
                        contentArea.innerHTML = `
                          <h1>Welcome <?= htmlspecialchars($adminDetails['name']);?>!</h1>
                            <p>E-Recruitment System: Helping you find the right job with ease and efficiency.</p>
                            <p>Select an option from the sidebar to manage your job search, applications, and more.</p>
                        `;
                        break;
                    case 'search-jobs-link':
                        contentArea.innerHTML = `
                            <h1>Search Jobs</h1>
                            <p>Search for job vacancies using keywords, location, industry, and other criteria.</p>
                        `;
                        break;
                    case 'job-applications-link':
                        contentArea.innerHTML = `
                            <h1>My Applications</h1>
                            <p>View and manage your job applications here.</p>
                        `;
                        break;
                    case 'job-alerts-link':
                        contentArea.innerHTML = `
                            <h1>Job Alerts</h1>
                            <p>View job alerts and notifications tailored to your preferences.</p>
                        `;
                        break;
                    case 'application-status-link':
                        contentArea.innerHTML = `
                            <h1>Application Status</h1>
                            <p>Check the status of your job applications here.</p>
                        `;
                        break;
                    case 'social-media-sharing-link':
                        contentArea.innerHTML = `
                            <h1>Share Job on Social Media</h1>
                            <p>Share job vacancies to different social media platforms like Facebook and Instagram.</p>
                        `;
                        break;
                    case 'post-feedback-link':
                        contentArea.innerHTML = `
                            <h1>Post Feedback</h1>
                            <p>Provide feedback relevant to the website or recruiters.</p>
                        `;
                        break;
                    case 'settings-link':
                        contentArea.innerHTML = `
                            <h1>Settings</h1>
                            <p>Adjust your account settings and preferences here.</p>
                        `;
                        break;
                    default:
                        contentArea.innerHTML = `
                            <h1>Welcome <?= htmlspecialchars($adminDetails['name']); ?>!</h1>
                            <p>E-Recruitment System: Helping you find the right job with ease and efficiency.</p>
                            <p>Select an option from the sidebar to manage your job search, applications, and more.</p>
                        `;
                        break;
                }
            });
        });
    </script>
</body>
</html>
