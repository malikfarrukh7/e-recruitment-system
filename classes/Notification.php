<?php
class Notification {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to send a notification
    public function sendNotification($sender_id, $receiver_id, $application_id, $subject, $message) {
        $query = "INSERT INTO notifications (sender_id, receiver_id, application_id, subject, message) 
                  VALUES (:sender_id, :receiver_id, :application_id, :subject, :message)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':sender_id', $sender_id);
        $stmt->bindParam(':receiver_id', $receiver_id);
        $stmt->bindParam(':application_id', $application_id);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);

        return $stmt->execute();
    }

    // Method to get notifications for a candidate by their ID
    public function getNotificationsByCandidateId($candidate_id) {
        $query = "SELECT id, subject, message, created_at FROM notifications WHERE receiver_id = :candidate_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':candidate_id', $candidate_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
