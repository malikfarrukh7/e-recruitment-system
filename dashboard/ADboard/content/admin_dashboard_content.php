
<h1>
    
<?php
    session_start();
    echo isset($_SESSION['set_name']) ? 'Welcome, ' . htmlspecialchars($_SESSION['set_name']) : ''; ?>
</h1>