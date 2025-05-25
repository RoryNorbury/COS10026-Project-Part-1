<?php
// Track login attempts
session_start();

// Include database configuration (host, username, password, DB name)
require_once("settings.php");

$error = '';

// Set lockout time to 5 minutes (in seconds)
$lockout_time = 5 * 60;

// Initialize session variables if not already set
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0;              // Count failed login attempts
    $_SESSION['last_attempt_time'] = 0;            // Track time of last failed attempt
}

// Check if the user is currently locked out
if ($_SESSION['failed_attempts'] >= 3) {
    $time_since_last = time() - $_SESSION['last_attempt_time']; // Time since last failed attempt
    if ($time_since_last < $lockout_time) {
        // If within lockout period, show error message
        $error = "Too many failed attempts. Please wait " . ceil(($lockout_time - $time_since_last) / 60) . " more minute(s).";
    }
}

// Handle form submission only if not locked out
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error)) {
    // Get admin ID and password 
    $id   = trim($_POST['admin_id'] ?? '');
    $pass = $_POST['password'] ?? '';

    // Connect to the database from phpmyadmin 
    $conn = mysqli_connect($host, $user, $pswd, $dbnm);
    if ($conn) {
        $stmt = mysqli_prepare($conn,
            "SELECT `password` FROM `admins` WHERE `admin_id` = ?");
        mysqli_stmt_bind_param($stmt,'s',$id);       
        mysqli_stmt_execute($stmt);                      // Run the SQL query
        mysqli_stmt_bind_result($stmt,$db_pass);         // Bind result to variable
        mysqli_stmt_fetch($stmt);                        // Fetch the result
        mysqli_stmt_close($stmt);                        // Close the statement
        mysqli_close($conn);                             // Close DB connection

        // Compare form password to DB password
        if ($pass === $db_pass) {
            $_SESSION['admin_logged_in'] = true;         // Set login session
            $_SESSION['failed_attempts'] = 0;            // Reset attempt counter
            header('Location: eoi_data.php');            // Redirect to eoi_data.php
            exit;                                       
        } else {
            $_SESSION['failed_attempts']++;              // Add failed attempts
            $_SESSION['last_attempt_time'] = time();     // Update last failed attempt time
            $error = 'Invalid ID or password';           // Set error message
        }
    } else {
        $error = 'Cannot connect to database.';           // Connection failure error
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="global_style manage_style">
  <?php include 'nav.inc'; ?>
  <div id="main-container">
    <div class="login-box">
      <h1>Admin Login</h1>
      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
          <label for="admin_id">Admin ID</label>
          <input type="text" id="admin_id" name="admin_id" required>
          
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
          
          <button type="submit" class="btn">Log In</button>
        </form>
      </div>
  </div>
  <?php include 'footer.inc'; ?>
</body>
</html>
