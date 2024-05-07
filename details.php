<?php
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if the user is logged in
if (isset($_SESSION['id'])) {

    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // if the form has been submitted
    if (isset($_POST['submit'])) {
        // build an SQL statement to update the student details
        $sql = "UPDATE student SET firstname ='" . mysqli_real_escape_string($conn, $_POST['txtfirstname']) . "', ";
        $sql .= "lastname ='" . mysqli_real_escape_string($conn, $_POST['txtlastname'])  . "', ";
        $sql .= "house ='" . mysqli_real_escape_string($conn, $_POST['txthouse'])  . "', ";
        $sql .= "town ='" . mysqli_real_escape_string($conn, $_POST['txttown'])  . "', ";
        $sql .= "county ='" . mysqli_real_escape_string($conn, $_POST['txtcounty'])  . "', ";
        $sql .= "country ='" . mysqli_real_escape_string($conn, $_POST['txtcountry'])  . "', ";
        $sql .= "postcode ='" . mysqli_real_escape_string($conn, $_POST['txtpostcode'])  . "' ";
        $sql .= "WHERE studentid = '" . $_SESSION['id'] . "';";
        $result = mysqli_query($conn, $sql);

        $data['content'] = "<p>Your details have been updated</p>";
    } else {
        // Build an SQL statement to return the student record with the id that
        // matches that of the session variable.
        $sql = "SELECT * FROM student WHERE studentid='" . $_SESSION['id'] . "';";
        $result = mysqli_query($conn, $sql);

        // Check if the query returned any results
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            // Using HEREDOC notation to allow building of a multi-line string
            $data['content'] = <<<EOD
            <div class="container mt-4">
                <h2>My Details</h2>
                <form name="frmdetails" action="" method="post">
                    <div class="form-group">
                        <label for="txtfirstname">First Name:</label>
                        <input name="txtfirstname" type="text" class="form-control" value="{$row['firstname']}">
                    </div>
                    <div class="form-group">
                        <label for="txtlastname">Surname:</label>
                        <input name="txtlastname" type="text" class="form-control" value="{$row['lastname']}">
                    </div>
                    <div class="form-group">
                        <label for="txthouse">Number and Street:</label>
                        <input name="txthouse" type="text" class="form-control" value="{$row['house']}">
                    </div>
                    <div class="form-group">
                        <label for="txttown">Town:</label>
                        <input name="txttown" type="text" class="form-control" value="{$row['town']}">
                    </div>
                    <div class="form-group">
                        <label for="txtcounty">County:</label>
                        <input name="txtcounty" type="text" class="form-control" value="{$row['county']}">
                    </div>
                    <div class="form-group">
                        <label for="txtcountry">Country:</label>
                        <input name="txtcountry" type="text" class="form-control" value="{$row['country']}">
                    </div>
                    <div class="form-group">
                        <label for="txtpostcode">Postcode:</label>
                        <input name="txtpostcode" type="text" class="form-control" value="{$row['postcode']}">
                    </div>
                    <input type="submit" value="Save" name="submit" class="btn btn-primary">
                </form>
            </div>
            EOD;
        } else {
            // No record found for the session ID
            $data['content'] = "<p>No record found for your student ID.</p>";
        }
    }

    // Render the template
    echo template("templates/default.php", $data);
    echo template("templates/partials/footer.php");

} else {
    header("Location: index.php");
}
?>


