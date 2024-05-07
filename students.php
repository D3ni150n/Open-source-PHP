<?php
// Include configuration, database connection, and functions
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if the user is logged in
if (isset($_SESSION['id'])) {

    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // Build SQL statement to select all student records
    $sql = "SELECT * FROM student";

    // Execute the query
    $result = mysqli_query($conn, $sql);
    ?>

    <style>
        /* CSS styles to add borders between table cells */
        table.table-striped td {
            border: 1px solid #dee2e6;
        }
    </style>

    <div class="container mt-4">
        <form action='deletestudents.php' method='POST'>
            <h2>Student Records</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Student ID</th>
                        <!-- Removed the password column -->
                        <th scope="col">DOB</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">House</th>
                        <th scope="col">Town</th>
                        <th scope="col">County</th>
                        <th scope="col">Country</th>
                        <th scope="col">Postcode</th>
                        <th scope="col">Image</th>
                        <th scope="col">Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $row['studentid'] ?></td>
                            <!-- Removed the password column -->
                            <td><?= $row['dob'] ?></td>
                            <td><?= $row['firstname'] ?></td>
                            <td><?= $row['lastname'] ?></td>
                            <td><?= $row['house'] ?></td>
                            <td><?= $row['town'] ?></td>
                            <td><?= $row['county'] ?></td>
                            <td><?= $row['country'] ?></td>
                            <td><?= $row['postcode'] ?></td>
                            <td><img src="<?= $row['image_path'] ?>" alt="Student Image" style="width: 100px; height: auto;"></td>
                            <td><input type='checkbox' name='students[]' value='<?= $row['studentid'] ?>' /></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <input type='submit' name='deletebutton' value='Delete' class='btn btn-primary'>
        </form>
    </div>

    <?php
    echo template("templates/partials/footer.php");

} else {
    header("Location: index.php");
}
?>






