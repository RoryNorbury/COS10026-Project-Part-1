<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// sanitise input function
function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// prevent direct URL access
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: upload.php");
    exit();
}

require_once("settings.php");

// database connection
$conn = @mysqli_connect($host, $user, $pswd, $dbnm);

if (!$conn) {
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>Error</title><link rel='stylesheet' href='styles/styles.css'></head><body>";
    echo "<div id='main-container' style='padding: 20px; text-align: center;'><h1>Database Connection Error</h1>";
    echo "<p>We are experiencing technical difficulties. Please try again later.</p>";
    echo "<a href='upload.php'>Back to Upload Portal</a>";
    echo "</div></body></html>";
    exit();
}

// create consciousness_uploads table with password field
$create_table_sql = "CREATE TABLE IF NOT EXISTS consciousness_uploads (
    UploadID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    DateOfBirth DATE NOT NULL,
    Gender ENUM('Male', 'Female', 'Other', 'Prefer not to say') NOT NULL,
    StreetAddress VARCHAR(100) NOT NULL,
    City VARCHAR(50) NOT NULL,
    State VARCHAR(3) NOT NULL,
    Postcode VARCHAR(4) NOT NULL,
    Phone VARCHAR(15) NOT NULL,
    EmergencyContact VARCHAR(100),
    EmergencyPhone VARCHAR(15),
    SubscriptionPlan ENUM('Basic', 'Premium', 'Executive') DEFAULT 'Basic',
    MedicalConditions TEXT,
    SpecialRequests TEXT,
    ConsciousnessConsent BOOLEAN DEFAULT FALSE,
    PhysicalConsent BOOLEAN DEFAULT FALSE,
    DataUseConsent BOOLEAN DEFAULT FALSE,
    TermsAccepted BOOLEAN DEFAULT FALSE,
    Status ENUM('Pending', 'Processing', 'Uploaded', 'Failed') DEFAULT 'Pending',
    UploadTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    LastLogin TIMESTAMP NULL
);";

if (!mysqli_query($conn, $create_table_sql)) {
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>Error</title><link rel='stylesheet' href='styles/styles.css'></head><body>";
    echo "<div id='main-container' style='padding: 20px; text-align: center;'><h1>System Error</h1>";
    echo "<p>Could not initialize consciousness storage system.</p>";
    echo "<a href='upload.php'>Back to Upload Portal</a>";
    echo "</div></body></html>";
    mysqli_close($conn);
    exit();
}

// server-side validation
$errors = [];

// password validation
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

if (empty($password)) {
    $errors[] = "Password is required for account security.";
} elseif (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long.";
} elseif ($password !== $confirm_password) {
    $errors[] = "Password confirmation does not match.";
}

// personal information
$first_name = isset($_POST['first_name']) ? sanitise_input($_POST['first_name']) : '';
if (empty($first_name)) {
    $errors[] = "First Name is required for consciousness identification.";
} elseif (!preg_match("/^[a-zA-Z\s]{1,50}$/", $_POST['first_name'])) {
    $errors[] = "First Name must be 1-50 alphabetic characters.";
}

$last_name = isset($_POST['last_name']) ? sanitise_input($_POST['last_name']) : '';
if (empty($last_name)) {
    $errors[] = "Last Name is required for consciousness identification.";
} elseif (!preg_match("/^[a-zA-Z\s]{1,50}$/", $_POST['last_name'])) {
    $errors[] = "Last Name must be 1-50 alphabetic characters.";
}

$email = isset($_POST['email']) ? sanitise_input($_POST['email']) : '';
if (empty($email)) {
    $errors[] = "Email is required for digital communications.";
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format detected.";
}

$dob = isset($_POST['dob']) ? sanitise_input($_POST['dob']) : '';
if (empty($dob)) {
    $errors[] = "Date of Birth is required for age verification.";
} elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob)) {
    $errors[] = "Date of Birth must be in yyyy-mm-dd format.";
}

$gender = isset($_POST['gender']) ? sanitise_input($_POST['gender']) : '';
if (empty($gender)) {
    $errors[] = "Gender selection is required.";
} elseif (!in_array($gender, ['Male', 'Female', 'Other', 'Prefer not to say'])) {
    $errors[] = "Invalid gender selection.";
}

// address info
$street_address = isset($_POST['street_address']) ? sanitise_input($_POST['street_address']) : '';
if (empty($street_address)) {
    $errors[] = "Street Address is required for physical form retrieval.";
} elseif (strlen($street_address) > 100) {
    $errors[] = "Street Address must be no more than 100 characters.";
}

$city = isset($_POST['city']) ? sanitise_input($_POST['city']) : '';
if (empty($city)) {
    $errors[] = "City is required.";
} elseif (strlen($city) > 50) {
    $errors[] = "City must be no more than 50 characters.";
}

$state = isset($_POST['state']) ? sanitise_input($_POST['state']) : '';
$valid_states = ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];
if (empty($state)) {
    $errors[] = "State is required.";
} elseif (!in_array($state, $valid_states)) {
    $errors[] = "Invalid State selected.";
}

$postcode = isset($_POST['postcode']) ? sanitise_input($_POST['postcode']) : '';
if (empty($postcode)) {
    $errors[] = "Postcode is required.";
} elseif (!preg_match("/^\d{4}$/", $postcode)) {
    $errors[] = "Postcode must be exactly 4 digits.";
}

$phone = isset($_POST['phone']) ? sanitise_input($_POST['phone']) : '';
if (empty($phone)) {
    $errors[] = "Phone number is required for emergency protocols.";
} elseif (!preg_match("/^[\d\s\-\+]{8,15}$/", $_POST['phone'])) {
    $errors[] = "Phone number must be 8-15 digits.";
}

// optional fields
$emergency_contact = isset($_POST['emergency_contact']) ? sanitise_input($_POST['emergency_contact']) : '';
$emergency_phone = isset($_POST['emergency_phone']) ? sanitise_input($_POST['emergency_phone']) : '';
$subscription_plan = isset($_POST['subscription_plan']) ? sanitise_input($_POST['subscription_plan']) : 'Basic';
$medical_conditions = isset($_POST['medical_conditions']) ? sanitise_input($_POST['medical_conditions']) : '';
$special_requests = isset($_POST['special_requests']) ? sanitise_input($_POST['special_requests']) : '';

// consent checkboxes
$consciousness_consent = isset($_POST['consciousness_consent']) ? 1 : 0;
$physical_consent = isset($_POST['physical_consent']) ? 1 : 0;
$data_use_consent = isset($_POST['data_use_consent']) ? 1 : 0;
$terms_accepted = isset($_POST['terms_accepted']) ? 1 : 0;

// validate all consents are given
if (!$consciousness_consent) $errors[] = "Consciousness consent must be given to proceed.";
if (!$physical_consent) $errors[] = "Physical form consent must be given to proceed.";
if (!$data_use_consent) $errors[] = "Data usage consent must be given to proceed.";
if (!$terms_accepted) $errors[] = "Terms and conditions must be accepted.";

// check for existing email
$email_check = mysqli_prepare($conn, "SELECT UploadID FROM consciousness_uploads WHERE Email = ?");
mysqli_stmt_bind_param($email_check, "s", $email);
mysqli_stmt_execute($email_check);
mysqli_stmt_store_result($email_check);
if (mysqli_stmt_num_rows($email_check) > 0) {
    $errors[] = "This consciousness has already been registered for upload.";
}
mysqli_stmt_close($email_check);

// display errors or process upload
if (!empty($errors)) {
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>Upload Failed</title><link rel='stylesheet' href='styles/styles.css'></head><body class='global_style upload_style manage_style'>";
    include 'nav.inc';
    echo "<div id='main-container'><h1>Consciousness Upload Failed</h1>";
    echo "<div class='warning-box'><p>The following errors prevented your upload:</p><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul></div>";
    echo "<p><a href='upload.php' class='upload-button' style='display: inline-block; width: auto; padding: 10px 20px;'>Return to Upload Portal</a></p>";
    echo "</div></body></html>";
} else {
    // hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // generate initial user-specific data
    $neural_pathways_total = rand(850000, 950000);
    $memory_fragments_total = rand(15000, 35000);
    $server_locations = ["Sydney Data Center", "Melbourne Quantum Hub", "Brisbane Neural Facility", "Perth Consciousness Vault"];
    $server_location = $server_locations[rand(0, 3)];
    $consciousness_integrity = rand(87, 99);
    $digital_stability = rand(92, 98);
    $initial_progress = rand(5, 25);
    $neural_mapped = ($initial_progress / 100) * $neural_pathways_total;
    $memory_mapped = ($initial_progress / 100) * $memory_fragments_total;
    $digital_personality = json_encode([
    'creativity' => rand(60, 95),
    'logic' => rand(70, 98),
    'empathy' => rand(65, 92),
    'curiosity' => rand(80, 99),
    'humor' => rand(40, 85)
    ]);

    
    // insert into database with password
    $stmt = mysqli_prepare($conn, "INSERT INTO consciousness_uploads (
    FirstName, LastName, Email, Password, DateOfBirth, Gender, 
    StreetAddress, City, State, Postcode, Phone, EmergencyContact, 
    EmergencyPhone, SubscriptionPlan, MedicalConditions, SpecialRequests, 
    ConsciousnessConsent, PhysicalConsent, DataUseConsent, TermsAccepted, 
    Status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Processing')");
    
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssiiii", 
    $first_name, $last_name, $email, $hashed_password, $dob, $gender, 
    $street_address, $city, $state, $postcode, $phone,
    $emergency_contact, $emergency_phone, $subscription_plan,
    $medical_conditions, $special_requests,
    $consciousness_consent, $physical_consent, $data_use_consent, $terms_accepted
    );

    if (mysqli_stmt_execute($stmt)) {
    $upload_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    
    $update_stmt = mysqli_prepare($conn, "UPDATE consciousness_uploads SET 
        UploadProgress = ?,
        NeuralPathwaysTotal = ?,
        NeuralPathwaysMapped = ?,
        MemoryFragmentsTotal = ?,
        MemoryFragmentsMapped = ?,
        ServerLocation = ?,
        ConsciousnessIntegrity = ?,
        DigitalStability = ?,
        DigitalPersonality = ?,
        VirtualCredits = 100.00,
        AchievementPoints = 50
        WHERE UploadID = ?");
    
    mysqli_stmt_bind_param($update_stmt, "iiiiisiisi", 
        $initial_progress, $neural_pathways_total, $neural_mapped,
        $memory_fragments_total, $memory_mapped, $server_location,
        $consciousness_integrity, $digital_stability, $digital_personality, $upload_id
    );
    
    mysqli_stmt_execute($update_stmt);
    mysqli_stmt_close($update_stmt);
    
    // initial activities
    $initial_activities = [
        ['System', 'Consciousness upload initiated successfully', 'High'],
        ['Neural', 'Neural pattern scanning commenced', 'Medium'],
        ['Memory', 'Memory indexing protocols activated', 'Medium'],
        ['Server', 'Assigned to ' . $server_location, 'Medium'],
        ['Security', 'Digital security protocols established', 'High']
    ];
    
    foreach ($initial_activities as $activity) {
        $activity_stmt = mysqli_prepare($conn, "INSERT INTO user_activity_log (UserID, ActivityType, ActivityDescription, ImportanceLevel) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($activity_stmt, "isss", $upload_id, $activity[0], $activity[1], $activity[2]);
        mysqli_stmt_execute($activity_stmt);
        mysqli_stmt_close($activity_stmt);
    }
    
    //welcome achievement
    $achievement_stmt = mysqli_prepare($conn, "INSERT INTO user_achievements (UserID, AchievementName, AchievementDescription, AchievementIcon, PointsAwarded) VALUES (?, 'Digital Pioneer', 'Successfully initiated consciousness upload', '🚀', 50)");
    mysqli_stmt_bind_param($achievement_stmt, "i", $upload_id);
    mysqli_stmt_execute($achievement_stmt);
    mysqli_stmt_close($achievement_stmt);
    
    // add starter digital pet
    $pet_stmt = mysqli_prepare($conn, "INSERT INTO user_digital_assets (UserID, AssetType, AssetName, AssetDescription, AssetIcon) VALUES (?, 'Pet', 'MemPaws™ Kitten', 'Your first digital companion to keep you company in the server space', '🐱')");
    mysqli_stmt_bind_param($pet_stmt, "i", $upload_id);
    mysqli_stmt_execute($pet_stmt);
    mysqli_stmt_close($pet_stmt);
    
    // set user session
    $_SESSION['user_logged_in'] = true;
    $_SESSION['user_id'] = $upload_id;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $first_name . ' ' . $last_name;
    
    // redirect to dashboard
    header("Location: user_dashboard.php?welcome=1");
    exit();
} else {
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>System Error</title><link rel='stylesheet' href='styles/styles.css'></head><body class='global_style upload_style manage_style'>";
    include 'nav.inc';
    echo "<div id='main-container'><h1>System Error</h1>";
    echo "<div class='warning-box'><p>A critical error occurred during consciousness upload processing.</p><p>Error: " . mysqli_error($conn) . "</p></div>";
    echo "<p><a href='upload.php' class='upload-button' style='display: inline-block; width: auto; padding: 10px 20px;'>Retry Upload</a></p>";
    echo "</div></body></html>";
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>