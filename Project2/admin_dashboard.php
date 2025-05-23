<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
require_once 'settings.php';

// connect
$conn = mysqli_connect($host, $user, $pswd, $dbnm) 
    or die("DB connection failed: " . mysqli_connect_error());

// helper
function render_table($result) {
    echo "<table class='admin-table'><tr>";
    $fields = mysqli_fetch_fields($result);
    foreach ($fields as $f) {
        echo "<th>" . htmlspecialchars($f->name) . "</th>";
    }
    echo "</tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

// get tables
$tables = [];
$res = mysqli_query($conn, "SHOW TABLES");
while ($r = mysqli_fetch_row($res)) {
    $tables[] = $r[0];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
  <?php include 'nav.inc'; ?>
  <div id="main-container" class="admin-dashboard">
    <h1>🛠️ Admin Dashboard</h1>
    <p>Below you’ll find every table in <code>meowmeows_db</code>:</p>

    <?php foreach ($tables as $table): ?>
      <h2><?= htmlspecialchars($table) ?></h2>
      <?php
        $q = mysqli_query($conn, "SELECT * FROM `$table`");
        render_table($q);
      ?>
    <?php endforeach; ?>

  </div>
  <?php include 'footer.inc'; ?>
</body>
</html>
<?php mysqli_close($conn); ?>
