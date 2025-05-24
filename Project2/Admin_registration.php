<?php
require_once("settings.php");
$conn = mysqli_connect($host, $user, $pswd, $dbnm);

$admin_id = 'admin123';
$password = password_hash('potatpass', PASSWORD_DEFAULT); 

$sql = "INSERT INTO admins (admin_id, password) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ss', $admin_id, $password);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);
echo "Admin registered.";
?>
