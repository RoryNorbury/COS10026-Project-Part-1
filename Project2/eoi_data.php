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
echo "<table border='1'>
<tr>
  <th>EOI Number</th>
  <th>Job Reference</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Date of Birth</th>
  <th>Gender</th>
  <th>Street Address</th>
  <th>Suburb/Town</th>
  <th>State</th>
  <th>Postcode</th>
  <th>Email</th>
  <th>Phone</th>
  <th>Skill 1</th>
  <th>Skill 2</th>
  <th>Skill 3</th>
  <th>Other Skills</th>
  <th>Status</th>
  <th>Timestamp</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['EOInumber']) . "</td>";
    echo "<td>" . htmlspecialchars($row['JobReferenceNumber']) . "</td>";
    echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
    echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
    echo "<td>" . htmlspecialchars($row['DateOfBirth']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Gender']) . "</td>";
    echo "<td>" . htmlspecialchars($row['StreetAddress']) . "</td>";
    echo "<td>" . htmlspecialchars($row['SuburbTown']) . "</td>";
    echo "<td>" . htmlspecialchars($row['State']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Postcode']) . "</td>";
    echo "<td>" . htmlspecialchars($row['EmailAddress']) . "</td>";
    echo "<td>" . htmlspecialchars($row['PhoneNumber']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Skill1']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Skill2']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Skill3']) . "</td>";
    echo "<td>" . htmlspecialchars($row['OtherSkills']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
    echo "<td>" . htmlspecialchars($row['ApplicationTimestamp']) . "</td>";
    echo "</tr>";
}

echo "</table>";
mysqli_close($conn);
?>
