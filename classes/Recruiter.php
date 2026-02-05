<?php
/*require_once 'User.php';
require_once 'Application.php';  // Add reference to Application class

class Recruiter extends User {
    protected $table_name = "recruiters";

    // Aggregating an instance of Application class
    private $application;

    public function __construct($db) {
        parent::__construct($db); // Call parent constructor
        $this->application = $application; // Injecting Application 
        $this->conn = $db;
    }

    // Function to view job applications for a recruiter's jobs
    public function viewJobApplications($recruiter_id) {
        return $this->application->getApplicationsByRecruiter($recruiter_id);
    }

    // Other functions related to the Recruiter can go here...
}*/

require_once 'User.php';
require_once 'Application.php';  // Add reference to Application class

class Recruiter extends User {
    protected $table_name = "recruiters";

    // Aggregating an instance of Application class
    private $application;

    // Constructor accepting a database connection and an Application instance
    public function __construct($db, $application) {
        parent::__construct($db);  // Call parent constructor
        $this->application = $application;  // Injecting Application instance for aggregation
    }

    // Function to view job applications for a recruiter's jobs
    /*public function viewJobApplications($recruiter_id, $job_title = null, $percentage = null, $candidate_name = null) {
        return $this->application->getApplicationsByRecruiter($recruiter_id, $job_title, $percentage, $candidate_name);
    }*/
    public function viewJobApplications($recruiter_id, $job_title = null, $percentage = null, $candidate_name = null) {
        return $this->application->getApplicationsByRecruiter($recruiter_id, $job_title, $percentage, $candidate_name);
    }
    

    public function getAllRecruiters() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }



    // recruiter.php
public function scheduleInterview($applicationId, $candidateId, $jobName, $interviewDate, $interviewTime) {
    $query = "INSERT INTO interviews (application_id, candidate_id, job_name, interview_date, interview_time) 
              VALUES (:applicationId, :candidateId, :jobName, :interviewDate, :interviewTime)";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':applicationId', $applicationId);
    $stmt->bindParam(':candidateId', $candidateId);
    $stmt->bindParam(':jobName', $jobName);
    $stmt->bindParam(':interviewDate', $interviewDate);
    $stmt->bindParam(':interviewTime', $interviewTime);

    return $stmt->execute();
}

    // Other functions related to the Recruiter can go here...
}


?>
