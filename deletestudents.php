<?php
// Include configuration, database connection, and functions
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if the user is logged in
if (isset($_SESSION['id'])) {

    // Check if form is submitted and student ids are selected for deletion
    if (isset($_POST['deletebutton']) && isset($_POST['students']) && !empty($_POST['students'])) {
        // Array to store selected student ids
        $selected_students = $_POST['students'];
        
        // Sanitize and escape each selected student id to prevent SQL injection
        $escaped_student_ids = array_map(function($student_id) use ($conn) {
            return mysqli_real_escape_string($conn, $student_id);
        }, $selected_students);
        
        // Start SQL transaction
        mysqli_begin_transaction($conn);
        
        // Initialize error flag
        $error = false;
        
        // Loop through each selected student id and build SQL query to delete the record
        foreach ($escaped_student_ids as $student_id) {
            // Build SQL statement to delete the student record
            $sql = "DELETE FROM student WHERE studentid = '$student_id'";
            
            // Execute the delete query
            $result = mysqli_query($conn, $sql);
            
            // Check if the query was successful
            if (!$result) {
                // Set error flag and rollback transaction
                $error = true;
                mysqli_rollback($conn);
                break; // Exit loop if an error occurs
            }
        }
        
        // Commit or rollback transaction based on query success
        if (!$error) {
            mysqli_commit($conn);
            echo "Selected student records have been deleted successfully.";
        } else {
            echo "Error deleting student records: " . mysqli_error($conn);
        }
    } else {
        // If no student records are selected for deletion
        echo "No student records selected for deletion.";
    }

} else {
    header("Location: index.php");
}
?>

