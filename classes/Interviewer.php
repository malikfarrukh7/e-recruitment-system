<?php

class Interviewer {
    private $conn;
    private $table = 'interviewers'; // Assuming a database table named 'interviewers'

    // Interviewer properties
    public $id;
    public $name;
    public $email;
    public $qualification;
    public $assign_for_job;
    public $interview_date;
    public $interview_time;
    public $interview_id;

    // Constructor to initialize database connection
    public function __construct($db) {
        $this->conn = $db;
    }


    public function addInterviewer($interview_id, $name, $email, $qualification, $assign_for_job, $interview_date, $interview_time) {
        $query = "INSERT INTO {$this->table} (interview_id, name, email, qualification, assign_for_job, interview_date, interview_time) 
                  VALUES (:interview_id, :name, :email, :qualification, :assign_for_job, :interview_date, :interview_time)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':interview_id', $interview_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':qualification', $qualification);
        $stmt->bindParam(':assign_for_job', $assign_for_job);
        $stmt->bindParam(':interview_date', $interview_date);
        $stmt->bindParam(':interview_time', $interview_time);

        return $stmt->execute();
    }

    // Method to add a new interviewer to the database
    public function getInterviewersByInterview($interview_id) {
        $query = "SELECT * FROM {$this->table} WHERE interview_id = :interview_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':interview_id', $interview_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
