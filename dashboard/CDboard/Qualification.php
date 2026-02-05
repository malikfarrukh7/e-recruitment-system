<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Resume and Qualifications</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Application Form</h1>

        <?php
        session_start();  // Start session to access session variables

        // Database connection
        require_once '../../config/db.php';
        require_once '../../classes/Candidate.php';
        require_once '../../classes/Job.php';
        $db = new Database(); 
        $conn = $db->getConnection();

        if (!isset($_SESSION['set_id'])) {
            echo "<div class='alert alert-danger'>Please log in to access your dashboard.</div>";
            exit;
        }

        $candidate = new Candidate($conn); 
        $candidate->id = $_SESSION['set_id'];  
        $job = new Job($conn);

        if (isset($_GET['job_id'])) {
            $job_id = $_GET['job_id'];
        }

        if (isset($_GET['job_title'])) {
            $job_title = urldecode($_GET['job_title']); // Decode job title from the URL
        }

        $jobs = $job->getJobsById($job_id);
        
        if (!empty($jobs)) {
            echo "<h4>Applying for Job: {$jobs['title']} | Description: {$jobs['description']} | Location: {$jobs['location']}</h4>";
        } else {
            echo "<p class='text-muted'>No job details found.</p>";
        }
        ?>

        <div class="card mb-4">
            <div class="card-body">
                <h3>Your Qualifications</h3>
                <?php
                $qualifications = $candidate->viewQualifications();

                if (!empty($qualifications)) {
                    echo "<table class='table table-striped'>";
                    echo "<thead class='table-dark'>
                            <tr>
                                <th>Degree Level</th>
                                <th>Major Subject</th>
                                <th>Institution</th>
                                <th>Percentage</th>
                            </tr>
                          </thead>";
                    echo "<tbody>";
                    foreach ($qualifications as $q) {
                        echo "<tr>
                                <td>{$q['degree_level']}</td>
                                <td>{$q['major_subject']}</td>
                                <td>{$q['institution']}</td>
                                <td>{$q['obtained_percentage']}</td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p class='text-muted'>No qualifications found.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Form to add qualification -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Add Qualification</h3>
                <form method="post" action="/e-recruitment-system6/actions/submit_qualification.php?job_id=<?php echo $job_id; ?>&job_title=<?php echo urlencode($job_title); ?>" enctype="multipart/form-data">
          <!--      <form method="post" action="/e-recruitment-system6/actions/submit_qualification.php?job_id=<?php echo $job_id; ?>&job_title=<?php echo urlencode($job_title); ?>">  -->
                    <div class="row mb-3">
                        <label for="degree_level" class="col-sm-3 col-form-label">Degree Level:</label>
                        <div class="col-sm-9">
                            <select name="degree_level" class="form-select" required>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Bachelor">Bachelor</option>
                                <option value="Master">Master</option>
                                <option value="PhD">PhD</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="major_subject" class="col-sm-3 col-form-label">Major Subject:</label>
                        <div class="col-sm-9">
                            <input type="text" name="major_subject" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="institution" class="col-sm-3 col-form-label">Institution:</label>
                        <div class="col-sm-9">
                            <input type="text" name="institution" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="obtained_percentage" class="col-sm-3 col-form-label">Obtained Percentage:</label>
                        <div class="col-sm-9">
                            <input type="text" name="obtained_percentage" class="form-control" required>
                        </div>
                    </div>

                   <!-- <div class="row mb-3">
                        <label for="resume_file_path" class="col-sm-3 col-form-label">Resume File Path:</label>
                        <div class="col-sm-9">
                            <input type="text" name="resume_file_path" class="form-control">
                        </div>
                    </div>  -->

                    <div class="row mb-3">
                        <label for="resume_file_path" class="col-sm-3 col-form-label">Upload Resume:</label>
                        <div class="col-sm-9">
                            <input type="file" name="resume_file_path" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="start_date" class="col-sm-3 col-form-label">Start Date:</label>
                        <div class="col-sm-9">
                            <input type="date" name="start_date" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="end_date" class="col-sm-3 col-form-label">End Date:</label>
                        <div class="col-sm-9">
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">ADD</button>
                    </div>
                </form>

                <?php if (!empty($jobs)) { ?>
                    <div class="d-flex justify-content-end">
                        <form action="Apply.php?job_id=<?php echo $jobs['id']; ?>&job_title=<?php echo urlencode($jobs['title']); ?>" method="POST">
                            <button type="submit" class="btn btn-success">Proceed Next</button>
                        </form>
                    </div>
                <?php } else { ?>
                    <p class="text-muted">No job available to proceed.</p>
                <?php } ?>
            </div>
        </div>

        <!-- Section to view previous applications -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Your Applications</h3>
                <?php
                $applications = $candidate->viewApplications();

                if (!empty($applications)) {
                    echo "<ul class='list-group'>";
                    foreach ($applications as $a) {
                        echo "<li class='list-group-item'>Job ID: {$a['job_id']}, Status: {$a['status']}, Applied Date: {$a['applied_date']}</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p class='text-muted'>No applications found.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
