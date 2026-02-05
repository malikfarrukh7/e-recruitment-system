<?php
// File: view_feedback.php
require_once '../../config/db.php';
require '../../classes/Feedback.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize Feedback class
$feedback = new Feedback($db);

// Fetch all feedback
$feedbackList = $feedback->getAllFeedback();
?>

<div class="container mt-5">
    <h1 class="mb-4">Feedback List</h1>

    <?php if (!empty($feedbackList)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>For</th>
                    <th>Sender Email</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feedbackList as $feedback): ?>
                    <tr>
                        <td><?= htmlspecialchars($feedback['id']) ?></td>
                        <td><?= htmlspecialchars($feedback['user_type']) ?></td>
                        <td><?= htmlspecialchars($feedback['user_email']) ?></td>
                        <td><?= htmlspecialchars($feedback['message']) ?></td>
                        <td><?= htmlspecialchars($feedback['created_at']) ?></td>
                        <td>
                            <!-- Delete button -->
                            <form action="delete_feedback.php" method="post" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($feedback['id']) ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">No feedback available.</p>
    <?php endif; ?>
</div>

