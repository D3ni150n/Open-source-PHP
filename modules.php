<?php
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// check if logged in
if (isset($_SESSION['id'])) {

    echo template("templates/partials/header.php");
    ?>

    <!-- Navigation -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="modules.php">My Modules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="students.php">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="assignmodule.php">Assign Module</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="details.php">My Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="addstudent.php">Add New Student</a>
                </li>
            </ul>
            <a class="nav-link" href="logout.php">Logout</a>
        </div>
    </nav>

    <?php
    echo template("templates/partials/nav.php");

    // Build SQL statement that selects a student's modules
    $sql = "SELECT * FROM studentmodules sm, module m WHERE m.modulecode = sm.modulecode AND sm.studentid = '" . $_SESSION['id'] . "';";

    $result = mysqli_query($conn, $sql);

    // prepare page content
    ?>

    <div class="container mt-4">
        <h2>Modules</h2>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Type</th>
                    <th scope="col">Level</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($result)) : ?>
                    <tr>
                        <td><?php echo $row['modulecode']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['level']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<?php
    // Render the footer
    echo template("templates/partials/footer.php");

} else {
    // Redirect to the index page if not logged in
    header("Location: index.php");
}
?>


