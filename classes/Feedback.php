<?php
class Feedback {
    private $conn;
    
    // Class properties
    private $userType;
    private $userEmail;
    private $message;

    public function __construct($db, $userType = null, $userEmail = null, $message = null) {
        $this->conn = $db;
        $this->userType = $userType;
        $this->userEmail = $userEmail;
        $this->message = $message;
    }

    // Method to add feedback
    public function addFeedback() {
        $query = "INSERT INTO feedback (user_type, user_email, message) 
                  VALUES (:user_type, :user_email, :message)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_type', $this->userType);
        $stmt->bindParam(':user_email', $this->userEmail);
        $stmt->bindParam(':message', $this->message);

        return $stmt->execute();
    }

    // Method to retrieve all feedback
    public function getAllFeedback() {
        $query = "SELECT * FROM feedback ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteFeedback($id) {
        $query = "DELETE FROM feedback WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>
