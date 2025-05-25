<?php
$pageTitle = "Open Job Positions";
$metaDescription = "Explore open job positions at Meow Meows";
$metaKeywords = "Jobs, Careers, Meow Meows, Tech, Consciousness Upload";
include 'header.inc';
include 'nav.inc';
include_once '../settings.php';



// returns the umber of positions to display
function get_job_count()
{
    global $host, $user, $pswd, $dbnm;
    $db_conn = mysqli_connect($host, $user, $pswd, $dbnm);
    if (!$db_conn) {
        echo "<p>Unable to connect to database</p>";
    } else {
        $query = "SELECT id FROM jobs";
        $result = mysqli_query($db_conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $job_ids[] = $row['id'];
            }
            ;
        } else {
            echo "" . mysqli_error($db_conn);
        }
        mysqli_close($db_conn);
    }
    return $job_ids;
}

function get_job_data($db_conn, $job_id, $info_type)
{
    // responsibilities
    $data = [];
    $query = "SELECT info FROM job_data WHERE job_id = $job_id AND info_type = '$info_type'";
    $result = mysqli_query($db_conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row['info'];
        }
    } else {
        echo "" . mysqli_error($db_conn);
        mysqli_close($db_conn);
        return;
    }
    return $data;
}

// returns formatted string ready for echo
function get_job_listing($job_id)
{
    global $host, $user, $pswd, $dbnm;
    $db_conn = mysqli_connect($host, $user, $pswd, $dbnm);
    if ($db_conn) {
        // single-entry fields
        $query = "SELECT * FROM jobs WHERE id = $job_id LIMIT 1";
        $result = mysqli_query($db_conn, $query);
        if ($result) {
            $data = mysqli_fetch_assoc($result);
            $position = $data['Name'];
            $ref_no = $data['Reference_number'];
            $salary = $data['Salary'];
            $reports_to = $data['Reports_to'];
            $description = $data['Description'];
        } else {
            echo "" . mysqli_error($db_conn);
            mysqli_close($db_conn);
            return;
        }

        // multi-entry fields
        $responsibilities = get_job_data($db_conn, $job_id, "Responsibility");
        $essentials = get_job_data($db_conn, $job_id, "Essential_qualification");
        $preferables = get_job_data($db_conn, $job_id, "Preferable_qualification");

        // put it all into one string to be output
        $output_string = "
            <section>
                <h2>Position: $position</h2>
                <p><strong>Reference Number: </strong> $ref_no</p>
                <p><strong>Salary:</strong> $salary</p>"
            . (($reports_to != "") ? "<p><strong>Reports To:</strong> $reports_to</p>" : "") . "
                <h3>Position Overview</h3>
                <p>$description</p>";

        $output_string .= "
        <h3>Key Responsibilities</h3><ul>";
        
        // add responsibilities
        foreach ($responsibilities as $entry) {
            $output_string .= "<li>$entry</li>";
        }
        $output_string .= "
        </ul><h3>Required Qualifications & Skills</h3><ol><li><strong>Essential</strong><ul>";
        
        // add essential qualifications
        foreach ($essentials as $entry) {
            $output_string .= "<li>$entry</li>";
        }
        $output_string .= "
        </ul></li><li><strong>Preferable</strong><ul>";
        
        // add preferable qualifications
        foreach ($preferables as $entry) {
            $output_string .= "<li>$entry</li>";
        }
        $output_string .=" </ul></li></ol></section>";
        mysqli_close($db_conn);
    } else {
        echo "<p>Unable to connect to database</p>";
    }
    return $output_string;
}
?>

<!-- Main content container, offset by nav bar -->
<div id="main-container">
    <h1>Current Job Openings</h1>

    <?php
    $job_ids = get_job_count();
    if (!empty($job_ids)) {
        for ($i = 0; $i < count($job_ids); $i++) {
            echo get_job_listing($job_ids[$i]);
        }
    }
    ?>

    <!-- Aside now positioned below the job sections -->
    <aside class="job-aside">
        <h2>Why Work at Meow Meows?</h2>
        <p>We offer more than just a job. Our perks include:</p>
        <ul>
            <li>On-site therapists for mental well-being</li>
            <li>Fully stocked sushi bar</li>
            <li>Cozy café to recharge your energy</li>
            <li>A workplace culture built on curiosity, comfort, and cats</li>
        </ul>
    </aside>
</div>

<!-- Footer with basic site links -->
<?php include 'footer.inc'; ?>