<?php
$pageTitle = "Apply for a Job";
$metaDescription = "Job Application";
$metaKeywords = "job, Application, apply, data, Technician";
include 'header.inc';
include 'nav.inc';
?>

<body class="global_style manage_style">
    <div id="main-container">
        <h1>About Us</h1>

        <!-- Group Info -->
        <section class="info-box">
            <h2>Group Name & Class Info</h2>
            <ul>
                <li>Group Name: Meow Meows
                    <ul>
                        <li>Class Time: 12:30</li>
                        <li>Class Date: Monday</li>
                    </ul>
                </li>
            </ul>
        </section>

        <!-- Student IDs -->
        <section class="info-box student-ids standalone-right">
            <h2>Student IDs</h2>
            <ul>
                <li>Students:
                    <ul class="student-id-list">
                        <li><span class="name">Rory:</span> <span class="id">105914122</span></li>
                        <li><span class="name">Oscar:</span> <span class="id">105337978</span></li>
                        <li><span class="name">Davina:</span> <span class="id">105213476</span></li>
                        <li><span class="name">Renad:</span> <span class="id">104799438</span></li>
                    </ul>
                </li>
            </ul>
        </section>

        <!-- Tutor Info -->
        <section class="info-box">
            <h2>Tutor</h2>
            <p>Enrique Ketterer Ortiz</p>
        </section>

        <!-- Member Contributions -->
        <section class="info-box">
            <h2>Member Contributions</h2>
            <dl class="contributions">
                <dt>Rory</dt>
                <dd>Created the repository and coded the Job Application page. Additionally, worked on HR Manager Queries and manage EOIs with filters, and created the job descriptions table in MySQL and dynamically generated the job descriptions via PHP.</dd>
                <dt>Oscar</dt>
                <dd>Coded the Company Information page. Additionally, created the EOI table in MySQL and developed the `process_eoi.php` script to add validated records to the EOI table and handle server-side validation.</dd>
                <dt>Davina</dt>
                <dd>Designed the website template, handled styling, and created the company logo. Additionally, worked on updateing the About Us page, including members' contributions, and enhanceing the site, specifically with the 'Other skills' checkbox functionality and form validation.</dd>
                <dt>Renad</dt>
                <dd>Coded the About Us page and Position Description page. Additionally, worked on implementing PHP includes for modularizing common elements (header, footer, menu), and created the 'settings.php' file for database connection variables, and resolving previous work errors.</dd>
            </dl>
        </section>

        <!-- Member Interests -->
        <section class="info-box">
            <h2>Member Interests</h2>
            <table>
                <caption>Our Interests</caption>
                <tr>
                    <th>Name</th>
                    <th>Interests</th>
                </tr>
                <tr>
                    <td>Rory</td>
                    <td>Gaming (Elden Ring, Factorio), Gym</td>
                </tr>
                <tr>
                    <td>Oscar</td>
                    <td>Computational Neuroscience, Intelligence, Cooking and Politics</td>
                </tr>
                <tr>
                    <td>Davina</td>
                    <td>Hibernation</td>
                </tr>
                <tr>
                    <td>Renad</td>
                    <td>Video games, Warhammer 40k lore</td>
                </tr>
            </table>
        </section>

        <!-- Group Photo -->
        <figure class="group-photo">
            <img src="images/group-photo.JPG" alt="Photo of Meow Meows group" width="400">
            <figcaption>Meow Meows - Innovating with claws and code</figcaption>
        </figure>
    </div>
</body>
    <!-- Footer -->
    <?php include 'footer.inc'; ?>