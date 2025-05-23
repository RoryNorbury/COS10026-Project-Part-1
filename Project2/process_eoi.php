<?php
session_start(); // start the session to potentially store messages if redirecting
error_reporting(E_ALL);
ini_set('display_errors', 1);


// sanitise input
function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data); // important if magic_quotes_gpc is on, though deprecated
    $data = htmlspecialchars($data); // convert special characters to HTML entities
    return $data;
}

// prevent direct URL access, only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: apply.php"); // redirect to the application form
    exit();
}

require_once("settings.php"); // include database settings

// database connection
$conn = @mysqli_connect($host, $user, $pswd, $dbnm);

// check connection
if (!$conn) {
    // display error message
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>Error</title><link rel='stylesheet' href='styles/styles.css'></head><body>";
    echo "<div id='main-container' style='padding: 20px; text-align: center;'><h1>Database Connection Error</h1>";
    echo "<p>We are experiencing technical difficulties. Please try again later.</p>";
    echo "<p><em>Error details (for debugging): " . mysqli_connect_error() . " (Code: " . mysqli_connect_errno() . ")</em></p>";
    echo "<p><a href='apply.php'>Go back to the Application Form</a></p>";
    echo "</div></body></html>";
    exit();
}

// create EOI table if it doesn't exist
$create_table_sql = "CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    JobReferenceNumber VARCHAR(5) NOT NULL,
    FirstName VARCHAR(20) NOT NULL,
    LastName VARCHAR(20) NOT NULL,
    DateOfBirth VARCHAR(10) NOT NULL, 
    Gender VARCHAR(20) NOT NULL,
    StreetAddress VARCHAR(40) NOT NULL,
    SuburbTown VARCHAR(40) NOT NULL,
    State VARCHAR(3) NOT NULL,
    Postcode VARCHAR(4) NOT NULL,
    EmailAddress VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(12) NOT NULL,
    Skill1 BOOLEAN DEFAULT FALSE,
    Skill2 BOOLEAN DEFAULT FALSE,
    Skill3 BOOLEAN DEFAULT FALSE,
    OtherSkills TEXT,
    Status ENUM('New', 'Current', 'Final') DEFAULT 'New',
    ApplicationTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

if (!mysqli_query($conn, $create_table_sql)) {
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>Error</title><link rel='stylesheet' href='styles/styles.css'></head><body>";
    echo "<div id='main-container' style='padding: 20px; text-align: center;'><h1>Table Creation Error</h1>";
    echo "<p>Could not create EOI table: " . mysqli_error($conn) . "</p>";
    echo "<p><a href='apply.php'>Back to Application Form</a></p>";
    echo "</div></body></html>";
    mysqli_close($conn);
    exit();
}


// server side validation
$errors = [];

// job Reference Number
$job_ref_num = isset($_POST['job_selection']) ? sanitise_input($_POST['job_selection']) : '';
if (empty($job_ref_num)) {
    $errors[] = "Job Reference Number is required.";
} elseif (!in_array($job_ref_num, ['MM26C', 'MM00C'])) {
    $errors[] = "Invalid Job Reference Number selected.";
}

// first Name
$first_name = isset($_POST['first_name']) ? sanitise_input($_POST['first_name']) : '';
if (empty($first_name)) {
    $errors[] = "First Name is required.";
} elseif (!preg_match("/^[a-zA-Z]{1,20}$/", $_POST['first_name'])) { // original $_POST for preg_match before sanitise for DB
    $errors[] = "First Name must be 1-20 alpha characters.";
}

// last Name
$last_name = isset($_POST['last_name']) ? sanitise_input($_POST['last_name']) : '';
if (empty($last_name)) {
    $errors[] = "Last Name is required.";
} elseif (!preg_match("/^[a-zA-Z]{1,20}$/", $_POST['last_name'])) {
    $errors[] = "Last Name must be 1-20 alpha characters.";
}

// date of birth
$dob = isset($_POST['dob']) ? sanitise_input($_POST['dob']) : '';
if (empty($dob)) {
    $errors[] = "Date of Birth is required.";
} elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob)) {
    $errors[] = "Date of Birth must be in yyyy-mm-dd format.";
} else {
    list($y, $m, $d) = explode('-', $dob);
    if (!checkdate((int)$m, (int)$d, (int)$y)) {
        $errors[] = "Invalid Date of Birth (e.g., 2025-02-30 is not a valid date).";
    }
}



// gender
$gender = isset($_POST['gender']) ? sanitise_input($_POST['gender']) : '';
if (empty($gender)) {
    $errors[] = "Gender is required.";
} elseif (!in_array($gender, ['Male', 'Female', 'Other', 'Prefer not to say'])) {
     $errors[] = "Invalid Gender selected.";
}


// street address
$street_address = isset($_POST['address']) ? sanitise_input($_POST['address']) : '';
if (empty($street_address)) {
    $errors[] = "Street Address is required.";
} elseif (strlen($street_address) > 40) {
    $errors[] = "Street Address must be no more than 40 characters.";
}

// suburb or town
$suburb_town = isset($_POST['suburb']) ? sanitise_input($_POST['suburb']) : '';
if (empty($suburb_town)) {
    $errors[] = "Suburb/Town is required.";
} elseif (strlen($suburb_town) > 40) {
    $errors[] = "Suburb/Town must be no more than 40 characters.";
}

// state
$state = isset($_POST['state']) ? sanitise_input($_POST['state']) : '';
$valid_states = ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];
if (empty($state)) {
    $errors[] = "State is required.";
} elseif (!in_array($state, $valid_states)) {
    $errors[] = "Invalid State selected.";
}

// postcode
$postcode = isset($_POST['postcode']) ? sanitise_input($_POST['postcode']) : '';
if (empty($postcode)) {
    $errors[] = "Postcode is required.";
} elseif (!preg_match("/^\d{4}$/", $postcode)) {
    $errors[] = "Postcode must be exactly 4 digits.";
}

// email address
$email = isset($_POST['email']) ? sanitise_input($_POST['email']) : '';
if (empty($email)) {
    $errors[] = "Email Address is required.";
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { // Use original $_POST for filter_var
    $errors[] = "Invalid Email Address format.";
}

// phone number
$phone = isset($_POST['phone']) ? sanitise_input($_POST['phone']) : '';
if (empty($phone)) {
    $errors[] = "Phone Number is required.";
} elseif (!preg_match("/^[\d\s]{8,12}$/", $_POST['phone'])) {
    $errors[] = "Phone Number must be 8-12 digits (spaces allowed).";
}

// skills
$skills = $_POST['skills'] ?? [];
$skill1 = in_array("Basic Networking Understanding", $skills) ? 1 : 0;
$skill2 = in_array("Awareness of Privacy Protocols", $skills) ? 1 : 0;
$skill3 = in_array("Cloud Platforms Familiarity", $skills) ? 1 : 0;

// other skills (optional)
$other_skills = isset($_POST['other_skills']) ? sanitise_input($_POST['other_skills']) : '';


// if there are validation errors, display them
if (!empty($errors)) {
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>Application Error</title><link rel='stylesheet' href='styles/styles.css'></head><body>";
    echo "<div id='main-container' style='padding: 20px;'><h1>Application Submission Failed</h1>";
    echo "<p>Please correct the following errors:</p><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "<p><a href='apply.php'>Go back to the Application Form</a></p>";
    echo "</div></body></html>";
} else {
    // no errors, proceed to insert data into the database
    // use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($conn, "INSERT INTO eoi (JobReferenceNumber, FirstName, LastName, DateOfBirth, Gender, StreetAddress, SuburbTown, State, Postcode, EmailAddress, PhoneNumber, Skill1, Skill2, Skill3, OtherSkills, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')");
    
    mysqli_stmt_bind_param($stmt, "sssssssssssiiis", 
        $job_ref_num, 
        $first_name, 
        $last_name, 
        $dob, 
        $gender, 
        $street_address, 
        $suburb_town, 
        $state, 
        $postcode, 
        $email, 
        $phone, 
        $skill1, 
        $skill2, 
        $skill3, 
        $other_skills
    );

    if (mysqli_stmt_execute($stmt)) {
        $eoi_number = mysqli_insert_id($conn); // get the auto-generated EOInumber
        echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>Application Successful</title><link rel='stylesheet' href='styles/styles.css'></head><body>";
        echo "<div id='main-container' style='padding: 20px; text-align: center;'><h1>Application Submitted Successfully!</h1>";
        echo "<p>Thank you for your application, " . htmlspecialchars($first_name) . ".</p>";
        echo "<p>Your Expression of Interest (EOI) number is: <strong>" . $eoi_number . "</strong></p>";
        echo "<p><a href='index.php'>Return to Home Page</a></p>";
        echo "</div></body></html>";
    } else {
        // database insertion error
        echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>Error</title><link rel='stylesheet' href='styles/styles.css'></head><body>";
        echo "<div id='main-container' style='padding: 20px; text-align: center;'><h1>Database Submission Error</h1>";
        echo "<p>We encountered an error while processing your application. Please try again later.</p>";
        echo "<p><em>Error details (for debugging): " . mysqli_error($conn) . "</em></p>";
        echo "<p><a href='index.php'>Return to Home Page</a></p>";
        echo "</div></body></html>";
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn); // close database connection
?>