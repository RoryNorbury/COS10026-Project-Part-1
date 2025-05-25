<?php
session_start();
require_once("settings.php");

$error = '';

// Lockout configuration
$lockout_time = 5 * 60; // 5 minutes
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0;
    $_SESSION['last_attempt_time'] = 0;
}

// Check if user is locked out
if ($_SESSION['failed_attempts'] >= 3) {
    $time_since_last = time() - $_SESSION['last_attempt_time'];
    if ($time_since_last < $lockout_time) {
        $error = "Too many failed attempts. Please wait " . ceil(($lockout_time - $time_since_last) / 60) . " more minute(s).";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error)) {
    $id   = trim($_POST['admin_id'] ?? '');
    $pass = $_POST['password'] ?? '';

    $conn = mysqli_connect($host, $user, $pswd, $dbnm);
    if ($conn) {
        $stmt = mysqli_prepare($conn,
            "SELECT `password` FROM `admins` WHERE `admin_id` = ?");
        mysqli_stmt_bind_param($stmt,'s',$id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$db_pass);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // Plaintext password check (since your DB stores plain text)
        if ($pass === $db_pass) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['failed_attempts'] = 0; // Reset counter
            header('Location: eoi_data.php');
            exit;
        } else {
            $_SESSION['failed_attempts']++;
            $_SESSION['last_attempt_time'] = time();
            $error = 'Invalid ID or password';
        }
    } else {
        $error = 'Cannot connect to database.';
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
