<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit();
}

require_once("settings.php");
$conn = mysqli_connect($host, $user, $pswd, $dbnm);

$result = mysqli_query($conn, "SELECT * FROM eoi");

echo "<h1>EOI Submissions</h1>";
echo "<table border='1'><tr>
<th>EOI Number</th><th>First Name</th><th>Last Name</th><th>Status</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['EOInumber'] . "</td>";
    echo "<td>" . $row['FirstName'] . "</td>";
    echo "<td>" . $row['LastName'] . "</td>";
    echo "<td>" . $row['Status'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($conn);
?>
