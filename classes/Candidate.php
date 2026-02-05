<?php
require_once 'Qualification.php';
require_once 'Application.php';
require_once 'User.php';

class Candidate extends User {
    protected $table_name = "candidates";

    private $qualifications = [];
    private $applications = [];

    public function __construct($db) {
        parent::__construct($db);
    }


    public function addQualification($degree_level, $major_subject, $institution, $obtained_percentage, $resume_file_path, $start_date, $end_date) {

        // Create a Qualification object and assign values
        $qualificationObj = new Qualification($this->conn);
        $qualificationObj->candidate_id = $this->id;
        $qualificationObj->degree_level = $degree_level;
        $qualificationObj->major_subject = $major_subject;
        $qualificationObj->institution = $institution;
        $qualificationObj->obtained_percentage = $obtained_percentage;
        $qualificationObj->resume_file_path = $resume_file_path; // Save the new file name in the database
        $qualificationObj->start_date = $start_date;
        $qualificationObj->end_date = $end_date;
    
        // Add the new qualification to the database
        return $qualificationObj->addQualification();
    }

    // Add a qualification (using Qualification class)
   /* public function addQualification($degree_level, $major_subject, $institution, $obtained_percentage, $resume_file_path, $start_date, $end_date) {

        if (isset($_FILES['resume_file_path'])) {
            $file_tmp = $_FILES['resume_file_path']['tmp_name'];
            $file_name = $_FILES['resume_file_path']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($file_name);
    
            // Check for upload errors
            if ($_FILES['resume_file_path']['error'] !== UPLOAD_ERR_OK) {
                return "Error uploading file: " . $_FILES['resume_file_path']['error'];
            }
    
            // Move the uploaded file to the desired directory
            if (move_uploaded_file($file_tmp, $target_file)) {
                // Set the file path in the qualification object
                $resume_file = $target_file; // Store the path for database
            } else {
                // Handle error if the file upload fails
                return "Error moving uploaded file.";
            }
        }


        $qualificationObj = new Qualification($this->conn);
        $qualificationObj->candidate_id = $this->id;
        $qualificationObj->degree_level = $degree_level;
        $qualificationObj->major_subject = $major_subject;
        $qualificationObj->institution = $institution;
        $qualificationObj->obtained_percentage = $obtained_percentage;
        $qualificationObj->resume_file_path = $resume_file_path;
        $qualificationObj->start_date = $start_date;
        $qualificationObj->end_date = $end_date;

        return $qualificationObj->addQualification();
    }*/

    // View qualifications
    public function viewQualifications() {
        $qualificationObj = new Qualification($this->conn);
        return $qualificationObj->getQualifications($this->id);
    }

    // Submit an application (using Application class)
   /* public function submitApplication($jobId, $status = 'applied') {
        $applicationObj = new Application($this->conn);
        $applicationObj->candidate_id = $this->id;
        $applicationObj->job_id = $jobId;
        $applicationObj->status = $status;
        $applicationObj->applied_date = date('Y-m-d');  // Set the applied date to the current date

        return $applicationObj->submitApplication();
    }*/

    
  /*  public function submitApplication($jobId, $status = 'applied') {
        $applicationObj = new Application($this->conn);
        $applicationObj->candidate_id = $this->id;
        $applicationObj->job_id = $jobId;
        $applicationObj->status = $status;
        $applicationObj->applied_date = date('Y-m-d');  // Set the applied date to the current date
    
        // Check if the candidate has already applied for this job
        if ($applicationObj->hasAlreadyApplied()) {
            return false;  // Return false if the candidate has already applied for the job
        }
    
        return $applicationObj->submitApplication();
    }*/



    public function submitApplication($jobId, $jobName,$rdPercentage, $cv_file_path, $status = 'applied') {
        $applicationObj = new Application($this->conn);
        $applicationObj->candidate_id = $this->id;
        $applicationObj->job_id = $jobId;
        $applicationObj->job_name = $jobName;
        $applicationObj->r_percentage = $rdPercentage;  // Add job name to the application
        $applicationObj->cv_file = $cv_file_path;
        $applicationObj->status = $status;
        $applicationObj->applied_date = date('Y-m-d');  // Set the applied date to the current date
    
        // Check if the candidate has already applied for this job
        if ($applicationObj->hasAlreadyApplied()) {
            return false;  // Return false if the candidate has already applied for the job
        }
    
        return $applicationObj->submitApplication();
    }
    

    // View previous applications
    public function viewApplications() {
        $applicationObj = new Application($this->conn);
        return $applicationObj->getApplications($this->id);
    }

   /* public function showCandidateDetails() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            return [
                'id' => $row['id'],
                'name' => $row['name'],
                'cnic' => $row['cnic'],
                'address' => $row['address'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'town' => $row['town'],
                'region' => $row['region'],
                'postcode' => $row['postcode'],
                'country' => $row['country']
            ];
        }
        return false;
    }
}*/

    public function showCandidateDetails($candidateId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $candidateId);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row; // Return the candidate's details as an associative array
        }
        return null; // Return null if no candidate found
    }

    public function getAllCandidates() {
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


}
?>
