<!-- admin_dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Admin Dashboard'; ?></title>
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
            <a class="navbar-brand" href="admin_dashboard.php">E-Recruitment System - Admin</a>
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
            <h4 class="text-white">Admin Menu</h4>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="admin_dashboard.php" class="nav-link <?php echo ($page === 'dashboard') ? 'active' : ''; ?>" aria-current="page">Dashboard</a>
                </li>
                <li>
                    <a href="manage-users.php" class="nav-link <?php echo ($page === 'manage-users') ? 'active' : ''; ?>">Manage Users</a>
                </li>
                <li>
                    <a href="manage-jobs.php" class="nav-link <?php echo ($page === 'manage-jobs') ? 'active' : ''; ?>">Manage Jobs</a>
                </li>
                <li>
                    <a href="calendar.php" class="nav-link <?php echo ($page === 'calendar') ? 'active' : ''; ?>">Interview Calendar</a>
                </li>
                <li>
                    <a href="hire-managers.php" class="nav-link <?php echo ($page === 'hire-managers') ? 'active' : ''; ?>">Hire Managers</a>
                </li>
                <li>
                    <a href="hire-interviewers.php" class="nav-link <?php echo ($page === 'hire-interviewers') ? 'active' : ''; ?>">Hire interviewers</a>
                </li>
                <li>
                    <a href="user-reports.php" class="nav-link <?php echo ($page === 'user-reports') ? 'active' : ''; ?>">User Reports</a>
                </li>
                <li>
                    <a href="social-sharing.php" class="nav-link <?php echo ($page === 'social-sharing') ? 'active' : ''; ?>">Social Sharing</a>
                </li>
                <li>
                    <a href="manage-feedback.php" class="nav-link <?php echo ($page === 'manage-feedback') ? 'active' : ''; ?>">Manage Feedback</a>
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
