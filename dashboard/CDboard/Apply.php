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
        
        // Display job details if available
        if (!empty($jobs)) {
            echo "<h4>Applying for Job: {$jobs['title']} | Location: {$jobs['location']}</h4>";
        } else {
            echo "<p class='text-muted'>No job details found.</p>";
        }

        // Fetch candidate details
        $CdData = $candidate->showCandidateDetails($candidate->id);
        ?>
        
        <div class="card mb-4">
            <div class="card-body">
                <h3>Your Details</h3>
                <?php if ($CdData) { ?>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong> <?php echo $CdData['name']; ?></li>
                        <li class="list-group-item"><strong>CNIC:</strong> <?php echo $CdData['cnic']; ?></li>
                        <li class="list-group-item"><strong>Address:</strong> <?php echo $CdData['address']; ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?php echo $CdData['email']; ?></li>
                        <li class="list-group-item"><strong>Phone:</strong> <?php echo $CdData['phone']; ?></li>
                        <li class="list-group-item"><strong>Town:</strong> <?php echo $CdData['town']; ?></li>
                        <li class="list-group-item"><strong>Region:</strong> <?php echo $CdData['region']; ?></li>
                        <li class="list-group-item"><strong>Postcode:</strong> <?php echo $CdData['postcode']; ?></li>
                        <li class="list-group-item"><strong>Country:</strong> <?php echo $CdData['country']; ?></li>
                    </ul>
                <?php } else { ?>
                    <p class="text-muted">Candidate details not found.</p>
                <?php } ?>
            </div>
        </div>

        <div class="card mb-4">
    <div class="card-body">
        <h3>Your Qualifications</h3>
        <?php
        // Fetch qualifications from the database
        $qualifications = $candidate->viewQualifications();

        // Print qualifications for debugging (optional)
        // print_r($qualifications);

        // Check if there are qualifications
        if (!empty($qualifications)) {
            echo "<table class='table table-striped'>";
            echo "<thead class='table-dark'>
                    <tr>
                        <th>Degree Level</th>
                        <th>Major Subject</th>
                        <th>Institution</th>
                        <th>Percentage</th>
                        <th>Resume</th> <!-- New column for viewing the resume -->
                    </tr>
                  </thead>";
            echo "<tbody>";

            // Loop through qualifications and display them in table rows
            foreach ($qualifications as $q) {
                echo "<tr>
                        <td>{$q['degree_level']}</td>
                        <td>{$q['major_subject']}</td>
                        <td>{$q['institution']}</td>
                        <td>{$q['obtained_percentage']}</td>";
                
                // Check if a resume file is available
                if (!empty($q['resume_file_path'])) {
                    // Create a link to the resume file
                    echo "<td><a href='http://localhost/e-recruitment-system6/uploads/{$q['resume_file_path']}' target='_blank' class='btn btn-primary btn-sm'>View Resume</a></td>";
                } else {
                    // If no resume is uploaded
                    echo "<td><span class='text-muted'>No resume uploaded</span></td>";
                }

                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-muted'>No qualifications found.</p>";
        }
        ?>
    </div>
</div>


        <!-- Form to submit resume -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Submit Application</h3>
                <?php if (!empty($jobs)) {
                    echo "<h4>Applying for Job: {$jobs['title']} | Description: {$jobs['description']} | Location: {$jobs['location']}</h4>";
                } else {
                    echo "<p class='text-muted'>No job details found.</p>";
                } ?>

                <form method="post" action="/e-recruitment-system6/actions/submit_application.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="job_id" class="form-label">Job ID:</label>
                        <input type="number" name="job_id" class="form-control" value="<?php echo $job_id; ?>" readonly required>
                    </div>

                    <div class="mb-3">
                        <label for="job_title" class="form-label">Job Title:</label>
                        <input type="Text" name="job_title" class="form-control" value="<?php echo $job_title; ?>" readonly required>
                    </div>

                    <div class="row mb-3">
                        <label for="rdobtained_percentage" class="col-sm-3 col-form-label">Required Degree Percentage:</label>
                        <div class="col-sm-9">
                            <input type="text" name="rdobtained_percentage" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="cv_file_path" class="col-sm-3 col-form-label">Upload CV:</label>
                        <div class="col-sm-9">
                            <input type="file" name="cv_file_path" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select name="status" class="form-select">
                            <option value="applied">Applied</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <!-- Section to view previous applications -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Your Applications</h3>
                <?php
               /* $applications = $candidate->viewApplications();
        
               if (!empty($applications)) {
                    echo "<ul class='list-group'>";
                    foreach ($applications as $a) {
                        echo "<li class='list-group-item'>Job ID: {$a['job_id']},Job Name: {$a['job_name']}, Status: {$a['status']}, Applied Date: {$a['applied_date']}</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p class='text-muted'>No applications found.</p>";
                }*/
                
                $applications = $candidate->viewApplications();
                
                if (!empty($applications)) {
                    echo "<table class='table table-bordered table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Job ID</th>";
                    echo "<th>Job Name</th>";
                    echo "<th>Status</th>";
                    echo "<th>Applied Date</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    
                    foreach ($applications as $a) {
                        echo "<tr>";
                        echo "<td>{$a['job_id']}</td>";
                        echo "<td>{$a['job_name']}</td>";
                        echo "<td>{$a['status']}</td>";
                        echo "<td>{$a['applied_date']}</td>";
                        echo "</tr>";
                    }
                    
                    echo "</tbody>";
                    echo "</table>";
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
 