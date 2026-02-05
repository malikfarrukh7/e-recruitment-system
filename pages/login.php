<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }
        .btn-outline-custom:hover {
            background-color: white;
            color: #a3a7ff;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navid">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="../index.php" class="navbar-brand">E Recruitment System</a>
        <div class="collapse navbar-collapse" id="navid">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a href="../index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="../index.php#about" class="nav-link">About Us</a></li>
                <li class="nav-item"><a href="../index.php#services" class="nav-link">Our Services</a></li>
                <li class="nav-item"><a href="../index.php#team" class="nav-link">Team</a></li>
                <li class="nav-item"><a href="../index.php#contact" class="nav-link">Contact Us</a></li>
            </ul>
            <a href="register.php" class="btn btn-light">Register</a>
        </div>
    </div>
</nav>

<!-- Login Form -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <?php
                    // Display error messages from session
                    session_start();
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <form action="../actions/login_action.php" method="POST">
                        <div class="mb-3">
                            <label for="id" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="Enter your ID (e.g., CD01, RT01, AD01)" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="#" class="text-decoration-none">Lost your password?</a><br>
                    <span>Don't have an account? <a href="register.php" class="text-decoration-none">Sign up here</a></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
