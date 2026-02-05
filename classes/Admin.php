<?php
// Admin.php
require_once 'User.php';

class Admin extends User {
    protected $table_name = "admins";


    public function getCalendarData() {
        $query = "SELECT id, recruiter_id, job_name, interview_date, interview_time, interview_count 
                  FROM calendar
                  ORDER BY interview_date, interview_time";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt->execute()) {
            error_log("Database error: " . implode(" | ", $stmt->errorInfo()));
            return [];
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getCalendarSData() {
        $query = "SELECT * FROM calendar ORDER BY interview_date, interview_time";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array
    }
    
    public function addInterviewer($name, $email, $phone_number, $calendar_id) {
    $query = "INSERT INTO interviewers (name, email, phone_number, calendar_id) 
              VALUES (:name, :email, :phone_number, :calendar_id)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':calendar_id', $calendar_id);

    return $stmt->execute();
}


public function addManager($name, $email, $phone_number, $calendar_id) {
    $query = "INSERT INTO managers (name, email, phone_number, calendar_id) 
              VALUES (:name, :email, :phone_number, :calendar_id)";
    $stmt = $this->conn->prepare($query);

    // Bind the parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':calendar_id', $calendar_id);

    // Execute the query and return the result
    return $stmt->execute();
}


public function getManagerWithCalendar($calendarId) {
    $query = "
        SELECT 
            m.id AS manager_id,
            m.name AS manager_name,
            m.email AS manager_email,
            m.phone_number AS manager_phone,
            c.interview_date AS interview_date,
            c.interview_time AS interview_time,
            c.job_name AS job_name
        FROM managers m
        LEFT JOIN calendar c ON m.calendar_id = c.id
        WHERE c.id = :calendar_id
        ORDER BY c.interview_date, c.interview_time";
        
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':calendar_id', $calendarId, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        error_log("Database error: " . implode(" | ", $stmt->errorInfo()));
        return [];
    }
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getInterviewerWithCalendar($calendarId) {
    $query = "
        SELECT 
            i.id AS interviewer_id,
            i.name AS interviewer_name,
            i.email AS interviewer_email,
            i.phone_number AS interviewer_phone,
            c.interview_date AS interview_date,
            c.interview_time AS interview_time,
            c.job_name AS job_name
        FROM interviewers i
        LEFT JOIN calendar c ON i.calendar_id = c.id
        WHERE c.id = :calendar_id
        ORDER BY c.interview_date, c.interview_time";
        
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':calendar_id', $calendarId, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        error_log("Database error: " . implode(" | ", $stmt->errorInfo()));
        return [];
    }
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




}
?>
