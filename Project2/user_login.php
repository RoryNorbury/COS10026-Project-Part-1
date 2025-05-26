<?php
session_start();
require_once("settings.php");

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $conn = mysqli_connect($host, $user, $pswd, $dbnm);
        if ($conn) {
            $stmt = mysqli_prepare($conn, "SELECT UploadID, FirstName, LastName, Password, Status FROM consciousness_uploads WHERE Email = ?");
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $upload_id, $first_name, $last_name, $hashed_password, $status);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if ($upload_id && password_verify($password, $hashed_password)) {
                // update last login
                $update_stmt = mysqli_prepare($conn, "UPDATE consciousness_uploads SET LastLogin = CURRENT_TIMESTAMP WHERE UploadID = ?");
                mysqli_stmt_bind_param($update_stmt, 'i', $upload_id);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);

                // set session variables
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $upload_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $first_name . ' ' . $last_name;

                mysqli_close($conn);
                header('Location: user_dashboard.php');
                exit;
            } else {
                $error = 'Invalid email or password. Your consciousness may not be recognized.';
            }
            mysqli_close($conn);
        } else {
            $error = 'Cannot connect to consciousness database.';
        }
    }
}

// handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    $success = 'You have been successfully disconnected from the digital realm.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User Portal - Access Your Digital Consciousness</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="global_style manage_style">
    <?php include 'nav.inc'; ?>
    <div id="main-container">
        <div class="login-container">
            <div class="login-header">
                <h1>🧠 User Portal</h1>
                <p>Access Your Digital Consciousness Dashboard</p>
            </div>

            <?php if ($error): ?>
                <div class="error-box">
                    <p>⚠️ <?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success-box">
                    <p>✅ <?= htmlspecialchars($success) ?></p>
                </div>
            <?php endif; ?>

            <div class="login-options">
                <div class="login-box">
                    <h2>🔐 Sign In to Your Consciousness</h2>
                    <form method="post">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required placeholder="your.consciousness@meowmeows.com">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required placeholder="Your digital key">
                        </div>
                        
                        <button type="submit" class="btn login-btn">🚀 Access Digital Realm</button>
                    </form>
                </div>

                <div class="signup-prompt">
                    <h3>New to Digital Immortality?</h3>
                    <p>Upload your consciousness and join the digital afterlife!</p>
                    <a href="upload.php" class="btn signup-btn">⬆️ Upload Consciousness</a>
                </div>
            </div>

            <div class="portal-features">
                <h3>🌟 Portal Features</h3>
                <div class="features-grid">
                    <div class="feature-card">
                        <h4>📊 Upload Status</h4>
                        <p>Monitor your consciousness transfer progress in real-time</p>
                    </div>
                    <div class="feature-card">
                        <h4>💳 Subscription Management</h4>
                        <p>View and upgrade your digital existence plan</p>
                    </div>
                    <div class="feature-card">
                        <h4>🖥️ System Health</h4>
                        <p>Check consciousness integrity and server status</p>
                    </div>
                    <div class="feature-card">
                        <h4>📡 Activity Logs</h4>
                        <p>Review your digital consciousness activity</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.inc'; ?>
</body>
</html>