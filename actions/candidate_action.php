<?php
// Include necessary files and initialize database connection
include_once 'config/db.php';
include_once 'classes/Job.php';

// Create database connection
$database = new Database();
$db = $database->getConnection();

// Initialize the Job object
$job = new Job($db);

// Check if search form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_option']) && isset($_GET['search_input'])) {
   // $searchOption = $_GET['search_option'];
   // $searchInput = $_GET['search_input'];
   $job->searchJobs($searchOption, $searchInput)

    // Call the searchJobs method
    $results = $job->searchJobs($searchOption, $searchInput);

    // Display the results in a table
    if ($results) {
        echo "<h2>Search Results:</h2>";
        echo "<table class='table table-bordered'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Category</th>";
        echo "<th>Job Title</th>";
        echo "<th>Location</th>";
        echo "<th>Industry</th>";
        echo "<th>Salary</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($results as $result) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($searchOption) . "</td>";
            echo "<td>" . htmlspecialchars($result['title']) . "</td>";
            echo "<td>" . htmlspecialchars($result['location']) . "</td>";
            echo "<td>" . htmlspecialchars($result['industry']) . "</td>";
            echo "<td>" . htmlspecialchars($result['salary']) . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No job found for your search criteria.</p>";
    }
} else {
    echo "<p>Invalid search criteria.</p>";
}
?>
