<?php
$pageTitle = "Apply for a Job";
$metaDescription = "Job Application";
$metaKeywords = "job, Application, apply, data, Technician";
include 'header.inc';
include 'nav.inc';
?>

<body>
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
                <dd>Created repository and coded Job Application page</dd>
                <dt>Oscar</dt>
                <dd>Coded Company Information page</dd>
                <dt>Davina</dt>
                <dd>Website template, styling, and company logo</dd>
                <dt>Renad</dt>
                <dd>Coded About Us page and Position Description page</dd>
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

    <!-- Footer -->
    <?php include 'footer.inc'; ?>