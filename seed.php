<?php

// Include configuration, database connection, and functions
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if the user is logged in
if (isset($_SESSION['id'])) {

    // Array of student data
    $array_students = array(
        array(
            "studentid" => "000001",
            "password" => "s1",
            "dob" => "2002-05-10",
            "firstname" => "Allu",
            "lastname" => "Dsouza",
            "house" => "123 Main Street",
            "town" => "Springfield",
            "county" => "Newport",
            "country" => "UK",
            "postcode" => "12345",
            // Add other fields here
        ),
        array(
            "studentid" => "000002",
            "password" => "s2",
            "dob" => "2003-08-20",
            "firstname" => "Jolu",
            "lastname" => "Smith",
            "house" => "456 Elm Street",
            "town" => "Rivertown",
            "county" => "Berkshire",
            "country" => "UK",
            "postcode" => "67890",
            // Add other fields here
        ),
        array(
            "studentid" => "000003",
            "password" => "s3",
            "dob" => "2001-12-15",
            "firstname" => "Jestu",
            "lastname" => "Johnson",
            "house" => "789 Oak Street",
            "town" => "Mapleton",
            "county" => "Derby",
            "country" => "UK",
            "postcode" => "09876",
            // Add other fields here
        ),
        array(
            "studentid" => "000004",
            "password" => "s4",
            "dob" => "2004-02-28",
            "firstname" => "Don",
            "lastname" => "Brown",
            "house" => "1011 Pine Street",
            "town" => "Greenville",
            "county" => "Countyshire",
            "country" => "UK",
            "postcode" => "92574",
            // Add other fields here
        ),
        array(
            "studentid" => "000005",
            "password" => "s5",
            "dob" => "2000-07-03",
            "firstname" => "Lolo",
            "lastname" => "Garcia",
            "house" => "1213 Cedar Street",
            "town" => "Hill Valley",
            "county" => "Valleyshire",
            "country" => "UK",
            "postcode" => "98566",
            // Add other fields here
        ),
    );

    // Loop through the student data and insert into the database
    foreach ($array_students as $student) {
        $studentid = $student['studentid'];
        $password = password_hash($student['password'], PASSWORD_DEFAULT); // Hash the password
        $dob = $student['dob'];
        $firstname = $student['firstname'];
        $lastname = $student['lastname'];
        $house = $student['house'];
        $town = $student['town'];
        $county = $student['county'];
        $country = $student['country'];
        $postcode = $student['postcode'];
        // Add other fields here

        // Build the INSERT query
        $sql = "INSERT INTO student (studentid, password, dob, firstname, lastname, house, town, county, country, postcode) 
                VALUES ('$studentid', '$password', '$dob', '$firstname', '$lastname', '$house', '$town', '$county', '$country', '$postcode')";
        
        // Execute the query
        $result = mysqli_query($conn, $sql);

        // Check if the query was successful
        if (!$result) {
            echo "Error: " . mysqli_error($conn);
        } else {
            echo "Records inserted successfully.<br>";
        }
    }
} else {
    // Handle case where user is not logged in
    echo "User is not logged in.";
}
?>
