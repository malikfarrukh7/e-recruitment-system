<?php
class Interview {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

  /*  public function scheduleInterview($applicationId, $recruiter_id, $candidateId, $jobName, $interviewDate, $interviewTime) {
        $query = "INSERT INTO interviews (application_id, recruiter_id candidate_id, job_name, interview_date, interview_time) 
                  VALUES (:applicationId, :recruiter_id, :candidateId, :jobName, :interviewDate, :interviewTime)
                  ON DUPLICATE KEY UPDATE interview_date = :interviewDate, interview_time = :interviewTime";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':applicationId', $applicationId);
        $stmt->bindParam(':recruiter_id', $recruiter_id);
        $stmt->bindParam(':candidateId', $candidateId);
        $stmt->bindParam(':jobName', $jobName);
        $stmt->bindParam(':interviewDate', $interviewDate);
        $stmt->bindParam(':interviewTime', $interviewTime);

        return $stmt->execute();
    }  */

    public function scheduleInterview($applicationId, $recruiter_id, $candidateId, $jobName, $interviewDate, $interviewTime) {
        $query = "INSERT INTO interviews (application_id, recruiter_id, candidate_id, job_name, interview_date, interview_time) 
                  VALUES (:applicationId, :recruiter_id, :candidateId, :jobName, :interviewDate, :interviewTime)
                  ON DUPLICATE KEY UPDATE interview_date = :interviewDate, interview_time = :interviewTime";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':applicationId', $applicationId);
        $stmt->bindParam(':recruiter_id', $recruiter_id);
        $stmt->bindParam(':candidateId', $candidateId);
        $stmt->bindParam(':jobName', $jobName);
        $stmt->bindParam(':interviewDate', $interviewDate);
        $stmt->bindParam(':interviewTime', $interviewTime);
    
        return $stmt->execute();
    }
    

    public function getInterviewDetails($applicationId) {
        $query = "SELECT interview_date, interview_time FROM interviews WHERE application_id = :applicationId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':applicationId', $applicationId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




    public function getInterviewCounts() {
        $sql = "
            SELECT 
                interview_date, 
                interview_time, 
                job_name, 
                COUNT(*) AS interview_count 
            FROM 
                interviews 
            GROUP BY 
                interview_date, 
                interview_time, 
                job_name
            ORDER BY 
                interview_date ASC, interview_time ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateInterview($applicationId, $interviewDate, $interviewTime) {
        $query = "UPDATE interviews 
                  SET interview_date = :interviewDate, interview_time = :interviewTime 
                  WHERE application_id = :applicationId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':applicationId', $applicationId);
        $stmt->bindParam(':interviewDate', $interviewDate);
        $stmt->bindParam(':interviewTime', $interviewTime);

        return $stmt->execute();
    }



    public function deleteInterview($applicationId) {
        $query = "DELETE FROM interviews WHERE application_id = :applicationId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':applicationId', $applicationId);

        return $stmt->execute();
    }


    public function saveToCalendar($recruiterId, $jobName, $interviewDate, $interviewTime, $interviewCount) {
        // SQL statement with recruiter_id included
        $sql = "INSERT INTO calendar (recruiter_id, job_name, interview_date, interview_time, interview_count)
                VALUES (:recruiter_id, :job_name, :interview_date, :interview_time, :interview_count)
                ON DUPLICATE KEY UPDATE interview_count = :interview_count";
        
        $stmt = $this->conn->prepare($sql);
        
        // Debugging line to check if recruiter_id is set correctly
        if (!$recruiterId) {
            die("Error: recruiter_id is not set");
        }
    
        return $stmt->execute([
            ':recruiter_id' => $recruiterId,
            ':job_name' => $jobName,
            ':interview_date' => $interviewDate,
            ':interview_time' => $interviewTime,
            ':interview_count' => $interviewCount
        ]);
    }
    
    

    public function getInterviewCountForSlot($recruiterId, $jobName, $interviewDate, $interviewTime) {
        $sql = "
            SELECT COUNT(*) AS interview_count
            FROM interviews 
            WHERE recruiter_id = :recruiter_id 
            AND job_name = :job_name 
            AND interview_date = :interview_date 
            AND interview_time = :interview_time
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':recruiter_id' => $recruiterId,
            ':job_name' => $jobName,
            ':interview_date' => $interviewDate,
            ':interview_time' => $interviewTime
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['interview_count'] ?? 0;
    }
    

    public function getCalendarRData($recruiter_id) {
        // Updated query to filter by recruiter_id
        $query = "SELECT * FROM calendar WHERE recruiter_id = :recruiter_id ORDER BY interview_date, interview_time";
        $stmt = $this->conn->prepare($query);
    
        // Bind the recruiter_id parameter to the query
        $stmt->bindParam(':recruiter_id', $recruiter_id, PDO::PARAM_INT);
        $stmt->execute();
    
        // Fetch all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCalendarRecord($id, $recruiter_id, $job_name, $interview_date, $interview_time, $interview_count) {
        try {
            $query = "
                UPDATE calendar
                SET 
                    job_name = :job_name,
                    interview_date = :interview_date,
                    interview_time = :interview_time,
                    interview_count = :interview_count
                WHERE id = :id AND recruiter_id = :recruiter_id
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':job_name', $job_name, PDO::PARAM_STR);
            $stmt->bindParam(':interview_date', $interview_date, PDO::PARAM_STR);
            $stmt->bindParam(':interview_time', $interview_time, PDO::PARAM_STR);
            $stmt->bindParam(':interview_count', $interview_count, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':recruiter_id', $recruiter_id, PDO::PARAM_STR);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error updating record: " . $e->getMessage();
            return false;
        }
    }
    
    

}
?>
