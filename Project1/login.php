<?php

// Testing.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/settings.php';


$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = trim($_POST['admin_id'] ?? '');
    $pass = $_POST['password'] ?? '';

    $conn = mysqli_connect($host, $user, $pswd, $dbnm);
    if ($conn) {
        $stmt = mysqli_prepare($conn,
            "SELECT `password` FROM `admins` WHERE `admin_id` = ?");
        mysqli_stmt_bind_param($stmt,'s',$id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$db_pass);
        if (mysqli_stmt_fetch($stmt) && $pass === $db_pass) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $error = 'Invalid ID or password';
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
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
<body>
  <?php include 'nav.inc'; ?>
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
  <?php include 'footer.inc'; ?>
</body>
</html>
