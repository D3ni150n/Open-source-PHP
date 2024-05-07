<?php
// Include configuration, database connection, and functions
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Initialize variables
$searchResults = [];
$message = '';

// Check if form is submitted
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];

    // Build SQL statement to search for student records
    $sql = "SELECT * FROM student 
            WHERE firstname LIKE '%$searchTerm%' 
            OR studentid LIKE '%$searchTerm%'
            OR lastname LIKE '%$searchTerm%' 
            OR town LIKE '%$searchTerm%' 
            OR county LIKE '%$searchTerm%'
            OR country LIKE '%$searchTerm%' 
            OR postcode LIKE '%$searchTerm%'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if any results were found
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $searchResults[] = $row;
        }
    } else {
        $message = "No records found matching '$searchTerm'.";
    }
}

// Include header and navigation
echo template("templates/partials/header.php");
echo template("templates/partials/nav.php");
?>

<?php
// Display search results and message
if (!empty($searchResults)) {
    echo "<div class='container mt-4'>";
    echo "<h3>Search Results</h3>";
    echo "<table class='table table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Student ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Town</th>";
    echo "<th>County</th>";
    echo "<th>Country</th>";
    echo "<th>Postcode</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($searchResults as $result) {
        echo "<tr>";
        echo "<td>" . $result['studentid'] . "</td>";
        echo "<td>" . $result['firstname'] . "</td>";
        echo "<td>" . $result['lastname'] . "</td>";
        echo "<td>" . $result['town'] . "</td>";
        echo "<td>" . $result['county'] . "</td>";
        echo "<td>" . $result['country'] . "</td>";
        echo "<td>" . $result['postcode'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}

if (!empty($message)) {
    echo "<div class='container mt-4'>";
    echo "<p>$message</p>";
    echo "</div>";
}

// Include footer
echo template("templates/partials/footer.php");
?>
