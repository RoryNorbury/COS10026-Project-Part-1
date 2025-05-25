<?php
session_start();
require_once("settings.php");

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
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        //Plaintext password check (because your DB has plain passwords)
        if ($pass === $db_pass) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: database.php');
            exit;
        } else {
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
