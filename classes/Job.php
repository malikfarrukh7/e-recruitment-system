<?php
class Job {
    private $conn;
    private $table_name = "jobs";

    public $id;
    public $recruiter_id;
    public $job_category;
    public $title;
    public $description;
    public $requirements;
    public $location;
    public $industry;
    public $status;
    public $posted_date;
    public $last_modified;
    public $salary;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to create a new job
    public function createJob() {
        $query = "INSERT INTO " . $this->table_name . " 
            (recruiter_id, job_category, title, description, requirements, location, industry, status, posted_date, salary)
            VALUES (:recruiter_id, :job_category, :title, :description, :requirements, :location, :industry, :status, :posted_date, :salary)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recruiter_id', $this->recruiter_id);
        $stmt->bindParam(':job_category', $this->job_category); 
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':requirements', $this->requirements);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':industry', $this->industry);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':posted_date', $this->posted_date);
        $stmt->bindParam(':salary', $this->salary);

        return $stmt->execute();
    }

    // Method to update an existing job
    public function updateJob() {
        $query = "UPDATE " . $this->table_name . " 
            SET title = :title, description = :description, requirements = :requirements, location = :location, industry = :industry, salary = :salary, last_modified = :last_modified
            WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':requirements', $this->requirements);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':industry', $this->industry);
        $stmt->bindParam(':salary', $this->salary);
        $stmt->bindParam(':last_modified', $this->last_modified);

        return $stmt->execute();
    }

    // Method to delete a job
    public function deleteJob() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }

    // Method to fetch jobs by recruiter
    public function getJobsByRecruiter($recruiterId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE recruiter_id = :recruiter_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recruiter_id', $recruiterId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // To get job by job ID
    /*public function getJobsById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }*/

    public function getJobsById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single job
    }
    

public function updateStatus() {
    $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':id', $this->id);
    
    return $stmt->execute();

}
/*public function searchJobs($searchOption, $searchInput) {
    $query = "SELECT * FROM " . $this->table_name . " WHERE $searchOption LIKE :searchInput";
    
    $stmt = $this->conn->prepare($query);
    $searchTerm = "%" . $searchInput . "%";
    $stmt->bindParam(':searchInput', $searchTerm);
    
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/
/*public function searchJobs($searchOption = null, $searchInput = null) {
    // Base query to fetch all jobs
    $query = "SELECT * FROM " . $this->table_name;
    
    // If search input is provided, modify the query to filter results
    if ($searchOption && $searchInput) {
        $query .= " WHERE $searchOption LIKE :searchInput";
    }
    
    $stmt = $this->conn->prepare($query);

    // If search input is provided, bind the search term
    if ($searchOption && $searchInput) {
        $searchTerm = "%" . $searchInput . "%";
        $stmt->bindParam(':searchInput', $searchTerm);
    }
    
    // Execute the query
    $stmt->execute();

    // Fetch and return the results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/

/*public function searchJobs($searchOption = null, $searchInput = null) {
    // Base query to fetch all jobs
    $query = "SELECT * FROM " . $this->table_name;
    
    // Modify the query if search input is provided
    if ($searchInput) {
        // If searchOption is provided, search within the specified column
        if ($searchOption) {
            $query .= " WHERE $searchOption LIKE :searchInput";
        } else {
            // Default to searching across multiple columns (e.g., title, location, industry)
            $query .= " WHERE title LIKE :searchInput 
                        OR location LIKE :searchInput 
                        OR industry LIKE :searchInput";
        }
    }

    $stmt = $this->conn->prepare($query);

    // If search input is provided, bind the search term
    if ($searchInput) {
        $searchTerm = "%" . $searchInput . "%";
        $stmt->bindParam(':searchInput', $searchTerm);
    }
    
    // Execute the query
    $stmt->execute();

    // Fetch and return the results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/

/*public function searchJobs($searchOption = null, $searchInput = null) {
    // Base query to fetch all jobs
    $query = "SELECT * FROM " . $this->table_name;

    // Modify the query based on the search option
    if ($searchInput) {
        if ($searchOption === null) {
            // Search in all fields if no specific option is chosen
            $query .= " WHERE title LIKE :searchInput OR location LIKE :searchInput OR industry LIKE :searchInput";
        } else {
            // Search by a specific field (title, location, industry)
            $query .= " WHERE $searchOption LIKE :searchInput";
        }
    }

    $stmt = $this->conn->prepare($query);

    // Bind the search term if provided
    if ($searchInput) {
        $searchTerm = "%" . $searchInput . "%";
        $stmt->bindParam(':searchInput', $searchTerm);
    }

    // Execute the query
    $stmt->execute();

    // Fetch and return the results
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    
}*/
/*public function searchJobs($searchOption = null, $searchInput = null) {
    // Base query to fetch all jobs
    $query = "SELECT * FROM " . $this->table_name;

    // If there's a search input, modify the query accordingly
    if ($searchInput) {
        if ($searchOption === 'all' || $searchOption === null) {
            // Search across title, location, and industry if 'all' is selected or no option is selected
            $query .= " WHERE title LIKE :searchInput OR location LIKE :searchInput OR industry LIKE :searchInput";
        } else {
            // Search in the specific field (title, location, or industry)
            $query .= " WHERE $searchOption LIKE :searchInput";
        }
    }

    $stmt = $this->conn->prepare($query);

    // Bind the search term if there's a search input
    if ($searchInput) {
        $searchTerm = "%" . $searchInput . "%";
        $stmt->bindParam(':searchInput', $searchTerm);
    }

    // Execute the query
    $stmt->execute();

    // Fetch and return the results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/

/*public function searchJobs($searchOption = null, $searchInput = null) {
    // Base query to fetch all jobs
    $query = "SELECT * FROM " . $this->table_name;

    // If there's a search input, modify the query accordingly
    if ($searchInput) {
        if ($searchOption === 'all' || $searchOption === null) {
            // Search across title, location, industry, description, and salary (for salary, treat it as an exact number)
            $query .= " WHERE title LIKE :searchInput 
                        OR location LIKE :searchInput 
                        OR industry LIKE :searchInput 
                        OR description LIKE :searchInput
                        OR salary = :exactSalary"; // For salary, we check for exact match
        } else {
            // Search in the specific field (title, location, industry, description, or salary)
            if ($searchOption === 'salary') {
                // Handle salary as an exact match
                $query .= " WHERE salary = :exactSalary";
            } else {
                // For other fields, use LIKE
                $query .= " WHERE $searchOption LIKE :searchInput";
            }
        }
    }

    $stmt = $this->conn->prepare($query);

    // Bind the search term if there's a search input
    if ($searchInput) {
        $searchTerm = "%" . $searchInput . "%";

        if ($searchOption === 'salary') {
            // Bind exact salary for numeric field
            $stmt->bindParam(':exactSalary', $searchInput);
        } else {
            // Bind search term for string fields
            $stmt->bindParam(':searchInput', $searchTerm);
            $stmt->bindParam(':exactSalary', $searchInput); // For 'all' option, also bind salary for number search
        }
    }

    // Execute the query
    $stmt->execute();

    // Fetch and return the results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
*/

public function searchJobs($searchOption = null, $searchInput = null) {
    // Base query to fetch all jobs
    $query = "SELECT * FROM " . $this->table_name;

    // If there's a search input, modify the query accordingly
    if ($searchInput) {
        if ($searchOption === 'all' || $searchOption === null) {
            // Search across title, location, industry, description, and salary (for salary, treat it as an exact number)
            $query .= " WHERE title LIKE :searchInput 
                        OR location LIKE :searchInput 
                        OR industry LIKE :searchInput 
                        OR description LIKE :searchInput
                        OR salary = :exactSalary";
        } else {
            // Search in the specific field (title, location, industry, or salary)
            if ($searchOption === 'salary') {
                $query .= " WHERE salary = :exactSalary";
            } else {
                // For other fields, use LIKE
                $query .= " WHERE $searchOption LIKE :searchInput";
            }
        }
    }

    // Prepare the query
    $stmt = $this->conn->prepare($query);

    // Bind the search term if there's a search input
    if ($searchInput) {
        $searchTerm = "%" . $searchInput . "%";

        if ($searchOption === 'salary') {
            // Bind exact salary for numeric field
            $stmt->bindParam(':exactSalary', $searchInput);
        } else {
            // Bind search term for string fields
            $stmt->bindParam(':searchInput', $searchTerm);

            // Bind salary only if the 'all' option is selected
            if ($searchOption === 'all' || $searchOption === null) {
                $stmt->bindParam(':exactSalary', $searchInput);
            }
        }
    }

    // Execute the query
    $stmt->execute();

    // Fetch and return the results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getAllJobsWithRecruiterDetails() {
    $query = "SELECT j.*, r.name AS recruiter_name
              FROM " . $this->table_name . " j
              JOIN recruiters r ON j.recruiter_id = r.id
              ORDER BY r.name, j.posted_date DESC";
    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}
?>
