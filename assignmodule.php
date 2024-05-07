<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if logged in
if (isset($_SESSION['id'])) {

    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // If a module has been selected
    if (isset($_POST['selmodule'])) {
        $sql = "INSERT INTO studentmodules VALUES ('" .  $_SESSION['id'] . "','" . $_POST['selmodule'] . "');";
        $result = mysqli_query($conn, $sql);
        $data['content'] .= "<div class='container mt-4'><p>The module " . $_POST['selmodule'] . " has been assigned to you</p></div>";
    } else { // If a module has not been selected

        // Build SQL statement that selects all the modules
        $sql = "SELECT * FROM module";
        $result = mysqli_query($conn, $sql);

        $data['content'] .= "<div class='container mt-4'>";
        $data['content'] .= "<form name='frmassignmodule' action='' method='post'>";
        $data['content'] .= "<div class='form-group'>";
        $data['content'] .= "<label for='selmodule'>Select a module to assign</label>";
        $data['content'] .= "<select class='form-control' name='selmodule'>";
        // Display the module names in a dropdown selection box
        while ($row = mysqli_fetch_array($result)) {
            $data['content'] .= "<option value='$row[modulecode]'>$row[name]</option>";
        }
        $data['content'] .= "</select>";
        $data['content'] .= "</div>";
        $data['content'] .= "<button type='submit' name='confirm' class='btn btn-primary'>Save</button>";
        $data['content'] .= "</form>";
        $data['content'] .= "</div>";
    }

    // Render the template
    echo template("templates/default.php", $data);
    echo template("templates/partials/footer.php");

} else {
    header("Location: index.php");
}
?>
