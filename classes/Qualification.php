<?php
class Qualification {
    private $conn;
    private $table_name = "qualifications";

    public $id;
    public $candidate_id;
    public $degree_level;
    public $major_subject;
    public $institution;
    public $obtained_percentage;
    public $resume_file_path;
    public $start_date;
    public $end_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to add a qualification
    public function addQualification() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (candidate_id, degree_level, major_subject, institution, obtained_percentage, resume_file_path, start_date, end_date)
                  VALUES (:candidate_id, :degree_level, :major_subject, :institution, :obtained_percentage, :resume_file_path, :start_date, :end_date)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':candidate_id', $this->candidate_id);
        $stmt->bindParam(':degree_level', $this->degree_level);
        $stmt->bindParam(':major_subject', $this->major_subject);
        $stmt->bindParam(':institution', $this->institution);
        $stmt->bindParam(':obtained_percentage', $this->obtained_percentage);
        $stmt->bindParam(':resume_file_path', $this->resume_file_path);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);

        return $stmt->execute();
    }

    // Method to fetch qualifications for a candidate
    public function getQualifications($candidateId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE candidate_id = :candidate_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':candidate_id', $candidateId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
