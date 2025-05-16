<!DOCTYPE php>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="description" content="Job Application">
	<meta name="keywords" content="job, Application, apply, data, Technician">
	<meta name="author" content="Meow Meows HR">
	<title>Apply for a Job</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>

<body>
	<!-- Menu bar -->
	<nav>
		<img src="images/logo.PNG" alt="company logo">
		<a href="index.html">Home Page</a>
		<a href="jobs.html">Open Job Positions</a>
		<a href="apply.php" class="current">Apply for a Job</a>
		<a href="about.html">About Us</a>
		<a href="upload.html">Upload Consciousness</a>
	  </nav>
	  
	<div id="main-container">
		<h1>Job Application</h1>
		<form action="http://localhost/COS10026-Project-Part-1/process_eoi.php" method="post" novalidate="novalidate">
			<!-- Dropdown to select which job to apply for -->
			<label for="job_selection">Select job listing</label>
			<select id="job_selection" name="job_selection" required>
				<option value="">Choose a position</option>
				<option value="MM26C">Data Analyst (MM26C)</option>
				<option value="MM00C">Transition Technician (MM00C)</option>
			</select><br>
			<!-- Personal details -->
			<fieldset>
				<legend>Personal details</legend>
				<!-- Applicant's first name -->
				<label for="first_name">First Name: </label>
				<input type="text" id="first_name" name="first_name" pattern="[A-Za-z]{1,20}" maxlength="20"
					required><br>
				<!-- Applicant's last name -->
				<label for="last_name">Last Name: </label>
				<input type="text" id="last_name" name="last_name" pattern="[A-Za-z]{1,20}" maxlength="20" required><br>
				<!-- Applicant's date of birth -->
				<label for="dob">Date of Birth: </label>
				<input type="text" id="dob" name="dob" placeholder="dd/mm/yyyy" pattern="^\d{2}\/\d{2}\/\d{4}$"
					required>
				<!-- Radio options for Applicant's gender -->
				<p>Gender:
					<input type="radio" id="male" name="gender" value="Male" required>
					<label for="male">Male</label>

					<input type="radio" id="female" name="gender" value="Female">
					<label for="female">Female</label>

					<input type="radio" id="other" name="gender" value="Other">
					<label for="other">Other</label>

					<input type="radio" id="undisclosed" name="gender" value="Prefer not to say">
					<label for="undisclosed">Prefer not to say</label>
				</p>
			</fieldset>
			<!-- Applicant's address -->
			<fieldset>
				<legend>Your address</legend>
				<label for="address">Street Address: </label>
				<input type="text" name="address" id="address" placeholder="14 Smith Street" pattern=".{1,40}"
					maxlength="40" required><br>
				<label for="suburb">Suburb/Town: </label>
				<input type="text" name="suburb" id="suburb" pattern=".{1,40}" maxlength="40" required><br>
				<label for="state">State: </label>
				<select id="state" name="state" required>
					<option value="">Choose state</option>
					<option value="VIC">VIC</option>
					<option value="NSW">NSW</option>
					<option value="QLD">QLD</option>
					<option value="NT">NT</option>
					<option value="WA">WA</option>
					<option value="SA">SA</option>
					<option value="TAS">TAS</option>
					<option value="ACT">ACT</option>
				</select> <br>
				<label for="postcode">Postcode</label>
				<input type="text" id="postcode" name="postcode" pattern="[\d]{4}" maxlength="4" required><br>
			</fieldset>
			<!-- Applicant's contact information -->
			<fieldset>
				<legend>Contact Information</legend>
				<label for="email">Email: </label>
				<input type="email" id="email" name="email" pattern="^.+@.+[.].+$" required><br>
				<label for="phone">Phone Number: </label>
				<input type="tel" id="phone" name="phone" pattern="[\d\s]{8,12}" required><br>
			</fieldset>
			<!-- Checkboxes to indicate the applicant's technical skills -->
			<fieldset>
				<legend>Technical skills</legend>
				<label for="skill1">Basic Networking Understanding</label>
				<input type="checkbox" id="skill1" name="skill1" value="1"><br>
				<label for="skill2">Awareness of Privacy Protocols</label>
				<input type="checkbox" id="skill2" name="skill2" value="1"><br>
				<label for="skill3">Cloud Platforms Familiarity</label>
				<input type="checkbox" id="skill3" name="skill3" value="1"><br>
				<!-- space for applicant to fill in any other relevant skills -->
				<label for="other_skills">Other skills: </label>
				<textarea id="other_skills" name="other_skills" rows="5" placeholder="Describe any other relevant skills you possess..."></textarea><br>
				<!-- Button to submit application -->
				<input type="submit" id="submit" name="submit" value="Apply">
			</fieldset>
		</form>
	</div>
	<footer>
		<p>&copy; 2025 Meow Meows Inc. All rights reserved. | Bringing digital purr-fection to life.</p>
		<a href="terms.html">Terms & Conditions</a> 
		<a href="privacy.html">Privacy Policy</a> 
	</footer>
</body>
</html>