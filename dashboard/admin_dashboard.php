<?php
//require_once '../config/db.php';
require_once '../classes/Admin.php';
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
    <title>Admin Dashboard</title>
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
            <h4 class="text-white">Admin Menu</h4>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" id="dashboard-link" aria-current="page">Dashboard</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="manage-users-link">Manage Users</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="job-management-link">Job Management</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="application-status-link">Application Status</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="system-settings-link">System Settings</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="post-feedback-link">Post Feedback</a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="content" id="content-area">
            <h1>Welcome <?= htmlspecialchars($adminDetails['name']); ?> to Your Admin Dashboard!</h1>
            <p>E-Recruitment System: Manage your users, jobs, and more with ease and efficiency.</p>
            <p>Select an option from the sidebar to manage your system tasks.</p>
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
                            <p>E-Recruitment System: Manage your users, jobs, and more with ease and efficiency.</p>
                        `;
                        break;
                    case 'dashboard-link':
                        contentArea.innerHTML = `
                            <h1>Welcome <?= htmlspecialchars($adminDetails['name']);?>!</h1>
                            <p>E-Recruitment System: Manage your users, jobs, and more with ease and efficiency.</p>
                        `;
                        break;
                    case 'manage-users-link':
                        contentArea.innerHTML = `
                            <h1>Manage Users</h1>
                            <p>View and manage registered users.</p>
                        `;
                        break;
                    case 'job-management-link':
                        contentArea.innerHTML = `
                            <h1>Job Management</h1>
                            <p>Post, edit, or remove job listings.</p>
                        `;
                        break;
                    case 'application-status-link':
                        contentArea.innerHTML = `
                            <h1>Application Status</h1>
                            <p>Check the status of job applications submitted by candidates.</p>
                        `;
                        break;
                    case 'system-settings-link':
                        contentArea.innerHTML = `
                            <h1>System Settings</h1>
                            <p>Configure system-wide settings and preferences.</p>
                        `;
                        break;
                    case 'post-feedback-link':
                        contentArea.innerHTML = `
                            <h1>Post Feedback</h1>
                            <p>Provide feedback about the system or report any issues.</p>
                        `;
                        break;
                    default:
                        contentArea.innerHTML = `
                            <h1>Welcome <?= htmlspecialchars($adminDetails['name']); ?>!</h1>
                            <p>E-Recruitment System: Manage your users, jobs, and more with ease and efficiency.</p>
                        `;
                        break;
                }
            });
        });
    </script>
</body>
</html>
