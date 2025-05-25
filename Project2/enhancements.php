<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enhancements</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
  <?php include 'nav.inc'; ?>

  <div class="container">
    <h1>Enhancements</h1>

    <h2>1. Sort EOIs by Field</h2>
    <p>I added a dropdown in <code>manage.php</code> that allows the manager to select a field (like first name, last name, status, or application date) to sort the EOIs by. This uses the <code>GET</code> method and updates the SQL query accordingly to display sorted records. This makes it easier for managers to view the EOIs in their preferred order.</p>

    <h2>2. Manager Registration Page</h2>
    <p>I created a separate registration page where a new manager can sign up. The form checks that the username is unique and enforces a password rule (e.g., minimum 8 characters, at least one number). The data is saved into the <code>managers</code> table using server-side validation.</p>

    <h2>3. Access Control for manage.php</h2>
    <p>I added session-based access control to <code>manage.php</code>. This means only logged-in managers (via a successful login with the correct username and password) can access the page. If someone tries to access it directly without logging in, they are redirected to the login page.</p>

    <h2>4. Temporary Lockout on Failed Logins</h2>
    <p>After 3 failed login attempts, access to the login page is disabled for 5 minutes. This helps prevent brute force attacks and increases the security of the system. This was implemented using PHP sessions and a simple timestamp check.</p>
  </div>

  <?php include 'footer.inc'; ?>
</body>
</html>
