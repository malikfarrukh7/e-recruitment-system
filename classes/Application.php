<?php
class Application {
    private $conn;
    private $table_name = "applications";

    public $id;
    public $candidate_id;
    public $job_id;
    public $r_percentage;  // Add job name to the application
    public $cv_file;
    public $status;
    public $applied_date;
    public $job_name;  // Add job_name as part of the application process

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to submit a job application
    public function submitApplication() {
        $query = "INSERT INTO applications (candidate_id, job_id, job_name, r_percentage, cv_file, status, applied_date) 
                  VALUES (:candidate_id, :job_id, :job_name, :r_percentage, :cv_file, :status, :applied_date)";
        
        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':candidate_id', $this->candidate_id);
        $stmt->bindParam(':job_id', $this->job_id);
        $stmt->bindParam(':job_name', $this->job_name);
        $stmt->bindParam(':r_percentage', $this->r_percentage);
        $stmt->bindParam(':cv_file', $this->cv_file);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':applied_date', $this->applied_date);

        // Execute the query and return the result
        return $stmt->execute();
    }

    // Method to check if the candidate has already applied for the job
    public function hasAlreadyApplied() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE candidate_id = :candidate_id AND job_id = :job_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':candidate_id', $this->candidate_id);
        $stmt->bindParam(':job_id', $this->job_id);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;  // Return true if a row exists
    }



    // Method to fetch applications for a specific candidate
    public function getApplications($candidateId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE candidate_id = :candidate_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':candidate_id', $candidateId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


   /* public function getApplicationsByRecruiter($recruiter_id) {
        $query = "SELECT 
                    a.id AS application_id,
                    j.title AS job_name,
                    c.name AS candidate_name,
                    q.degree_level,
                    q.major_subject,
                    q.institution,
                    q.resume_file_path,
                    a.status AS application_status
                  FROM applications a
                  INNER JOIN jobs j ON a.job_id = j.id
                  INNER JOIN candidates c ON a.candidate_id = c.id
                  LEFT JOIN qualifications q ON a.candidate_id = q.candidate_id
                  WHERE j.recruiter_id = :recruiter_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recruiter_id', $recruiter_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }*/

   /* public function getApplicationsByRecruiter($recruiter_id) {
        $query = "
            SELECT a.id AS application_id, j.title AS job_name, c.id AS candidate_id, 
                   c.name AS candidate_name, q.degree_level, q.major_subject, 
                   q.institution, a.status AS application_status, c.resume_file_path 
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            JOIN candidates c ON a.candidate_id = c.id
            LEFT JOIN qualifications q ON c.id = q.candidate_id
            WHERE j.recruiter_id = :recruiter_id
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recruiter_id', $recruiter_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return as associative array
    }*/

   /* public function getApplicationsByRecruiter($recruiter_id) {
        $query = "
            SELECT a.id AS application_id, j.title AS job_name, c.id AS candidate_id, 
                   c.name AS candidate_name, q.degree_level, q.major_subject, 
                   q.institution, q.obtained_percentage,q.resume_file_path, a.status AS application_status
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            JOIN canddates c ON a.candidate_id = c.id
            LEFT JOIN qualificatiions q ON c.id = q.candidate_id
            WHERE j.recruiter_id = :recruiter_id
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recruiter_id', $recruiter_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return as associative array
    } */
    
 /*   public function getApplicationsByRecruiter($recruiter_id) {
        $query = "
            SELECT a.id AS application_id, j.title AS job_name, c.id AS candidate_id, 
                   c.name AS candidate_name, q.degree_level, q.major_subject, 
                   q.institution, q.obtained_percentage,q.resume_file_path, a.r_percentage, a.cv_file, a.status AS application_status
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            JOIN candidates c ON a.candidate_id = c.id
            LEFT JOIN qualifications q ON c.id = q.candidate_id
            WHERE j.recruiter_id = :recruiter_id
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recruiter_id', $recruiter_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return as associative array
    }  */

    // Recruiter.php

/*public function viewJobApplications($recruiter_id, $job_title = null, $percentage = null, $candidate_name = null)*/

/*public function getApplicationsByRecruiter($recruiter_id, $job_title = null, $percentage = null, $candidate_name = null){
    $query = "SELECT a.id as application_id, j.title as job_name, c.name as candidate_name, c.id as candidate_id, a.status as application_status, q.degree_level, q.major_subject, q.institution, q.obtained_percentage, r.cv_file, q.resume_file_path
              FROM applications a
              JOIN jobs j ON a.job_id = j.id
              JOIN candidates c ON a.candidate_id = c.id
              LEFT JOIN qualifications q ON c.id = q.candidate_id
              LEFT JOIN resumes r ON c.id = r.candidate_id
              WHERE j.recruiter_id = :recruiter_id";

    // Add search conditions if the parameters are provided
    if (!empty($job_title)) {
        $query .= " AND j.title LIKE :job_title";
    }
    if (!empty($percentage)) {
        $query .= " AND q.obtained_percentage >= :percentage";
    }
    if (!empty($candidate_name)) {
        $query .= " AND c.name LIKE :candidate_name";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':recruiter_id', $recruiter_id);

    // Bind the search parameters
    if (!empty($job_title)) {
        $stmt->bindValue(':job_title', '%' . $job_title . '%');
    }
    if (!empty($percentage)) {
        $stmt->bindParam(':percentage', $percentage);
    }
    if (!empty($candidate_name)) {
        $stmt->bindValue(':candidate_name', '%' . $candidate_name . '%');
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/
    
public function getApplicationsByRecruiter($recruiter_id, $job_title = null, $percentage = null, $candidate_name = null) {
    $query = "
        SELECT a.id AS application_id, j.title AS job_name, c.id AS candidate_id, 
               c.name AS candidate_name, q.degree_level, q.major_subject, 
               q.institution, q.obtained_percentage, q.resume_file_path, a.r_percentage, a.cv_file, a.status AS application_status
        FROM applications a
        JOIN jobs j ON a.job_id = j.id
        JOIN candidates c ON a.candidate_id = c.id
        LEFT JOIN qualifications q ON c.id = q.candidate_id
        WHERE j.recruiter_id = :recruiter_id
    ";

    // Add conditions for search filters
    if (!empty($job_title)) {
        $query .= " AND j.title LIKE :job_title";
    }
    if (!empty($candidate_name)) {
        $query .= " AND c.name LIKE :candidate_name";
    }
    if (!empty($percentage)) {
        $query .= " AND a.r_percentage >= :percentage";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':recruiter_id', $recruiter_id);

    // Bind parameters for search filters
    if (!empty($job_title)) {
        $stmt->bindValue(':job_title', "%$job_title%");
    }
    if (!empty($candidate_name)) {
        $stmt->bindValue(':candidate_name', "%$candidate_name%");
    }
    if (!empty($percentage)) {
        $stmt->bindParam(':percentage', $percentage);
    }

    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return as associative array
}



public function searchApplications($searchOption = null, $searchInput = null, $recruiterId) {
    // Base query to fetch all applications for the recruiter
    $query = "SELECT a.id AS application_id, j.title AS job_name, c.id AS candidate_id, 
                   c.name AS candidate_name, q.degree_level, q.major_subject, 
                   q.institution, q.obtained_percentage, q.resume_file_path, a.r_percentage, a.cv_file, 
                   a.status AS application_status
              FROM applications a
              JOIN jobs j ON a.job_id = j.id
              JOIN candidates c ON a.candidate_id = c.id
              LEFT JOIN qualifications q ON c.id = q.candidate_id
              WHERE j.recruiter_id = :recruiterId";  // Closing the query string correctly

    // If there's a search input, modify the query accordingly
    if ($searchInput) {
        if ($searchOption === 'all' || $searchOption === null) {
            // Search across candidate name, job title, and application status
            $query .= " AND (j.title LIKE :searchInput 
                            OR c.name LIKE :searchInput 
                            OR a.status LIKE :searchInput)";
        } else {
            // Search in the specific field (job_name, candidate_name, or application_status)
            $query .= " AND $searchOption LIKE :searchInput";
        }
    }

    // Prepare the query
    $stmt = $this->conn->prepare($query);

    // Bind recruiter ID
    $stmt->bindParam(':recruiterId', $recruiterId);

    // Bind search term if search input is provided
    if ($searchInput) {
        $searchTerm = "%" . $searchInput . "%";
        $stmt->bindParam(':searchInput', $searchTerm);
    }

    // Execute the query
    $stmt->execute();

    // Return results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function updateStatus($application_id, $new_status) {
    $query = "UPDATE applications SET status = :status WHERE id = :application_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':status', $new_status);
    $stmt->bindParam(':application_id', $application_id);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}

/*public function updateShortlistStatus($application_id, $shortlist_status) {
    $query = "UPDATE applications SET shortlist = :shortlist WHERE id = :application_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':shortlist', $shortlist_status);
    $stmt->bindParam(':application_id', $application_id);
    return $stmt->execute();
}
*/

public function searchShortlistedApplications($searchOption = null, $searchInput = null, $recruiterId) {
    // Base query to fetch all shortlisted applications for the recruiter
    $query = "SELECT a.id AS application_id, j.title AS job_name, c.id AS candidate_id, 
                   c.name AS candidate_name, q.degree_level, q.major_subject, 
                   q.institution, q.obtained_percentage, q.resume_file_path, a.r_percentage, a.cv_file, 
                   a.status AS application_status
              FROM applications a
              JOIN jobs j ON a.job_id = j.id
              JOIN candidates c ON a.candidate_id = c.id
              LEFT JOIN qualifications q ON c.id = q.candidate_id
              WHERE j.recruiter_id = :recruiterId
              AND a.status = 'shortlisted'";  // Only show applications with status "shortlisted"

    // If there's a search input, modify the query accordingly
    if ($searchInput) {
        if ($searchOption === 'all' || $searchOption === null) {
            // Search across candidate name and job title
            $query .= " AND (j.title LIKE :searchInput 
                            OR c.name LIKE :searchInput)";
        } else {
            // Search in the specific field (job_name or candidate_name)
            $query .= " AND $searchOption LIKE :searchInput";
        }
    }

    // Prepare the query
    $stmt = $this->conn->prepare($query);

    // Bind recruiter ID
    $stmt->bindParam(':recruiterId', $recruiterId);

    // Bind search term if search input is provided
    if ($searchInput) {
        $searchTerm = "%" . $searchInput . "%";
        $stmt->bindParam(':searchInput', $searchTerm);
    }

    // Execute the query
    $stmt->execute();

    // Return results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}
    

?>
