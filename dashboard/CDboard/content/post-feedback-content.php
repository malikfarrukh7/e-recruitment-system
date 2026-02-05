
<div class="container mt-5">
    <h1 class="mb-4">Feedback Form</h1>

    <form action="http://localhost/e-recruitment-system6/actions/add_feedback_action.php" method="post" class="row g-3">
        <!-- User Type Dropdown -->
        <div class="col-md-6">
            <label for="user_type" class="form-label">Select Feedback For</label>
            <select name="user_type" id="user_type" class="form-control" required>
                <option value="Recruiter">Recruiter</option>
                <option value="website">Website</option>
            </select>
        </div>

        <!-- Pre-filled Email -->
        <div class="col-md-6">
            <label for="user_email" class="form-label">Sender Email</label>
            <input type="email" name="user_email" id="user_email" class="form-control" 
                   value="<?= htmlspecialchars($_SESSION['set_email']) ?>" readonly>
        </div>

        <!-- Feedback Message -->
        <div class="col-12">
            <label for="message" class="form-label">Your Feedback</label>
            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
        </div>

        <!-- Submit Button -->
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Send Feedback</button>
        </div>
    </form>
</div>
