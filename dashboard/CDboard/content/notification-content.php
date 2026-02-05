<?php
require_once '../../config/db.php';
require_once '../../classes/Notification.php';

$db = new Database(); 
$conn = $db->getConnection();
$notification = new Notification($conn);

// Check if candidate is logged in
$candidate_id = $_SESSION['set_id'];
$notifications = $notification->getNotificationsByCandidateId($candidate_id);
?>
<div class="container mt-4">
    <h1>Job Alert / Notifications</h1>
    <?php if (!empty($notifications)): ?>
        <ul class="list-group">
            <?php foreach ($notifications as $index => $notif): ?>
                <li class="list-group-item">
                    <h5>
                        <a href="#" onclick="toggleMessage(<?php echo $index; ?>); return false;">
                            <?php echo htmlspecialchars($notif['subject']); ?>
                        </a>
                    </h5>
                    <div id="message_<?php echo $index; ?>" style="display: none;">
                        <p><?php echo nl2br(htmlspecialchars($notif['message'])); ?></p>
                        <small class="text-muted">Received on: <?php echo htmlspecialchars($notif['created_at']); ?></small>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No notifications available.</p>
    <?php endif; ?>
</div>

<script>
    function toggleMessage(index) {
        const messageDiv = document.getElementById(`message_${index}`);
        messageDiv.style.display = messageDiv.style.display === 'none' ? 'block' : 'none';
    }
</script>
</body>
</html>
