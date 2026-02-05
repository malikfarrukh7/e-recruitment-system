<?php
session_start();
if (!isset($_SESSION['set_id'])) {
    header("Location:../pages/login.php"); // Redirect to login if not logged in
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
    <title>Recruiter Dashboard</title>
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
            <h4 class="text-white">Recruiter Menu</h4>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" id="dashboard-link" aria-current="page">Dashboard</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="post-job-link">Post Job Vacancy</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="manage-job-link">Manage Job Postings</a>
                </li>
                <li>
                    <a href="#" class="nav-link" id="track-applicants-link">Track Applicants</a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="content" id="content-area">
            <div id="result"></div>
            <h1>Welcome to Your Recruiter Dashboard</h1>
            <p>E-Recruitment System: Helping you manage job vacancies, track applicants, and more.</p>
            <p>Select an option from the sidebar to manage your recruitment process efficiently.</p>
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
                    case 'dashboard-link':
                        contentArea.innerHTML = `
                            <h1>Dashboard</h1>
                            <p>This is your dashboard. Here you can see an overview of all your recruiting activities.</p>`;
                        break;

                    case 'post-job-link':
                        contentArea.innerHTML = `
                            <h2>Post Job Vacancy</h2>
                            <form id="post-job-form" action="../actions/recruiter_action.php" method="POST">
                            <input type="hidden" name="action" value="post_job">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Job Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Job Description</label>
                                    <textarea class="form-control" id="description" name="description" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea class="form-control" id="requirements" name="requirements" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" required>
                                </div>
                                <div class="mb-3">
                                    <label for="industry" class="form-label">Industry</label>
                                    <input type="text" class="form-control" id="industry" name="industry" required>
                                </div>
                                <div class="mb-3">
                                    <label for="salary" class="form-label">Salary</label>
                                    <input type="number" class="form-control" id="salary" name="salary">
                                </div>
                                <button type="submit" class="btn btn-primary" onclick="handleFormSubmit(event, 'post-job-form', '../actions/recruiter_action.php')">Post Job</button>
                            </form>`;
                        break;

                        case 'manage-job-link':
                            
                            
    fetch('../actions/recruiter_action.php?action=fetch_jobs')
        .then(response => response.json())
        .then(data => {
            let content = `<h2>Manage Job Postings</h2>`;
            if (data.length > 0) {
                content += `
                    <table border="1" cellpadding="10">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Requirements</th>
                                <th>Location</th>
                                <th>Industry</th>
                                <th>Salary</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>`;

                data.forEach(job => {
                    content += `
                        <tr id="job-row-${job.id}">
                            <td>${job.title}</td>
                            <td>${job.description}</td>
                            <td>${job.requirements}</td>
                            <td>${job.location}</td>
                            <td>${job.industry}</td>
                            <td>${job.salary}</td>
                            <td>
                                <button onclick="showEditForm(${job.id})">Edit</button>
                                <button onclick="deleteJob(${job.id})">Delete</button>
                            </td>
                        </tr>
                        <!-- Hidden Edit Form Row -->
                        <tr id="edit-row-${job.id}" style="display: none;">
                            <td colspan="7">
                                <form id="edit-job-form-${job.id}">
                                    <label>Title:</label>
                                    <input type="text" id="edit-title-${job.id}" value="${job.title}" required><br>

                                    <label>Description:</label>
                                    <textarea id="edit-description-${job.id}" required>${job.description}</textarea><br>

                                    <label>Requirements:</label>
                                    <textarea id="edit-requirements-${job.id}" required>${job.requirements}</textarea><br>

                                    <label>Location:</label>
                                    <input type="text" id="edit-location-${job.id}" value="${job.location}" required><br>

                                    <label>Industry:</label>
                                    <input type="text" id="edit-industry-${job.id}" value="${job.industry}" required><br>

                                    <label>Salary:</label>
                                    <input type="number" id="edit-salary-${job.id}" value="${job.salary}" required><br>

                                    <button type="button" onclick="updateJob(${job.id})">Update</button>
                                    <button type="button" onclick="hideEditForm(${job.id})">Cancel</button>
                                </form>
                            </td>
                        </tr>`;
                });

                content += `</tbody></table>`;
            } else {
                content += `<p>No jobs found.</p>`;
            }
            contentArea.innerHTML = content;
        })
        .catch(error => {
            console.error('Error fetching jobs:', error);
        });
    break;

                    case 'track-applicants-link':
                        contentArea.innerHTML = `
                            <h2>Track Applicants</h2>
                            <p>Here you can view the applicants who have applied for your jobs and track their progress.</p>`;
                        break;
                }
            });
        });

        // Prevent form reload and handle submission with AJAX
        function handleFormSubmit(event, formId, actionUrl) {
            event.preventDefault(); // Prevent default form submission

            var form = document.getElementById(formId);
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', actionUrl, true);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Success! Update the user list and notify the user
                    document.getElementById('result').innerHTML = xhr.responseText;
                } else {
                    // Error handling
                    document.getElementById('result').innerHTML = 'An error occurred: ' + xhr.status;
                }
            };

            xhr.onerror = function () {
                // Network error
                document.getElementById('result').innerHTML = 'A network error occurred.';
            };

            xhr.send(formData);
        }
    </script>
</body>
</html>
