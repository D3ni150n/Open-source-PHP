<?php
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

if (isset($_SESSION['id'])) {
    echo template("templates/partials/header.php");
    ?>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
    if (isset($_POST['submit'])) {
        // Process form submission
        $studentid = mysqli_real_escape_string($conn, $_POST['txtstudentid']);
        $password = mysqli_real_escape_string($conn, $_POST['txtpassword']); // Not hashed yet
        $firstname = mysqli_real_escape_string($conn, $_POST['txtfirstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['txtlastname']);
        $dob = $_POST['dob']; // No need for escape since it's a date
        $house = mysqli_real_escape_string($conn, $_POST['txthouse']);
        $town = mysqli_real_escape_string($conn, $_POST['txttown']);
        $county = mysqli_real_escape_string($conn, $_POST['txtcounty']);
        $country = mysqli_real_escape_string($conn, $_POST['txtcountry']);
        $postcode = mysqli_real_escape_string($conn, $_POST['txtpostcode']);

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // File upload handling
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // if everything is ok, try to upload file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                // Insert new student record into database with image path
                $sql = "INSERT INTO student (studentid, password, firstname, lastname, dob, house, town, county, country, postcode, image_path) 
                        VALUES ('$studentid', '$hashed_password', '$firstname', '$lastname', '$dob', '$house', '$town', '$county', '$country', '$postcode', '$targetFile')";
                
                if (mysqli_query($conn, $sql)) {
                    echo "New student record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

    } else {
        // Display the form for entering student details
        echo <<<EOD
            <div class="container mt-4">
                <h2>Add New Student</h2>
                <form name="frmdetails" action="" method="post" enctype="multipart/form-data">
                    Student ID:
                    <input name="txtstudentid" type="text" class="form-control" value="" /><br/>
                    Password:
                    <input name="txtpassword" type="password" class="form-control" value="" /><br/>
                    First Name:
                    <input name="txtfirstname" type="text" class="form-control" value="" /><br/>
                    Surname:
                    <input name="txtlastname" type="text" class="form-control" value="" /><br/>
                    Date of Birth:
                    <input name="dob" type="date" class="form-control" value="" /><br/>
                    Number and Street:
                    <input name="txthouse" type="text" class="form-control" value="" /><br/>
                    Town:
                    <input name="txttown" type="text" class="form-control" value="" /><br/>
                    County:
                    <input name="txtcounty" type="text" class="form-control" value="" /><br/>
                    Country:
                    <input name="txtcountry" type="text" class="form-control" value="" /><br/>
                    Postcode:
                    <input name="txtpostcode" type="text" class="form-control" value="" /><br/>
                    Upload Image:
                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control-file"><br>
                    <input type="submit" value="Save" name="submit" class="btn btn-primary"/>
                </form>
            </div>
EOD;
    }

    echo template("templates/partials/footer.php");
} else {
    header("Location: index.php");
}
?>







