<?php
$pageTitle = "Enhancements | Admin Features and Security Upgrades";
$metaDescription = "Explanation of enhancements made to the admin section, including login system with lockout, session protection, and data display from the EOI form.";
$metaKeywords = "enhancements, admin login, session protection, PHP, eoi_data.php, lockout system, database table, phpMyAdmin, web development, student project";
include 'header.inc';
include 'nav.inc';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enhancements</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="global_style manage_style">
  <div id="main-container">
    <h1>Enhancements Implemented - By Davina</h1>

    <h2>1. Admin Registration Table in Database</h2>
    <p>
      I created a new table in <strong>phpMyAdmin</strong> called <code>admins</code>. This table includes two columns: <code>admin_id</code> and <code>password</code>. Each admin_id is based on the student ID of my group members, and the passwords are manually assigned to each. This setup allows for proper account-based access control.
      I used this table as the authentication source for admin login in my system. The data is securely accessed during login verification.
    </p>

    <h2>2. Admin Login System with Lockout Feature</h2>
    <p>
      I implemented a login system using PHP sessions that checks the submitted admin ID and password against the values stored in the <code>admins</code> table. If the login credentials match, the admin is logged in and redirected to the protected <code>eoi_data.php</code> page.
    </p>
    <p>
      If the admin enters the wrong ID or password three times in a row, a lockout is triggered. The system stores the number of failed attempts and the time of the last attempt in the session. Once locked, the admin must wait <strong>five minutes</strong> before trying again. This feature enhances the security of the login system by helping prevent brute-force attacks.
    </p>

    <h2>3. Display of Submitted Form Data (eoi_data.php)</h2>
    <p>
      I created a new page called <code>eoi_data.php</code> which is only accessible after successful admin login. This page fetches and displays all records from the <code>eoi</code> table in the database. Each record includes the full range of user-submitted information:
    </p>
    <ul>
      <li>EOI Number</li>
      <li>Job Reference Number</li>
      <li>First Name</li>
      <li>Last Name</li>
      <li>Date of Birth</li>
      <li>Gender</li>
      <li>Street Address</li>
      <li>Suburb/Town</li>
      <li>State</li>
      <li>Postcode</li>
      <li>Email Address</li>
      <li>Phone Number</li>
      <li>Skill 1, 2, and 3</li>
      <li>Other Skills</li>
      <li>Application Status</li>
      <li>Application Timestamp</li>
    </ul>
    <p>
      This page allows the admin to view all incoming applications from the form in a neat, structured table.
    </p>

    <h2>4. Session-Based Page Protection</h2>
    <p>
      I also secured admin-only pages by checking if the user is logged in using sessions. If a user tries to access the <code>eoi_data.php</code> page directly without logging in, they are redirected back to the login page. This ensures that no unauthorised users can see application data.
    </p>
  </div>
  <?php include 'footer.inc'; ?>
</body>
</html>
