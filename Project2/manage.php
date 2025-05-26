<?php

session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$pageTitle = "Manage Job Applications";
$metaDescription = "Admin - Manage Job Applications";
$metaKeywords = "job, application, query, sql, manage";
include 'header.inc';
include 'nav.inc';
echo '<body class="global_style manage_style">';

/*
User actions:
none: none chosen
a: List all EOIs
b: List all EOIs for a particular position (given a job reference number)
c: List all EOIs for a particular applicant given their first name, last name or both
d: Delete all EOIs with a specified job reference number
e: Change the Status of an EOI
*/
require_once("../settings.php");
// include("menu_bar.inc");
function user_option_button($option_name, $option_value)
{
    $address = htmlspecialchars($_SERVER["PHP_SELF"]);
    echo
        "<form method='post' action='$address'>
            <input type='hidden' name='user_option' value='$option_value'>
            <input type='hidden' name='user_option_name' value='$option_name'>
            <input type='submit' name='submit' value='$option_name'>
        </form>
        ";
}
// creates a table from the results of a mysql query
function results_table($query, $host, $user, $pswd, $dbnm)
{
    $db_conn = mysqli_connect($host, $user, $pswd, $dbnm);
    if ($db_conn) {
        $result = mysqli_query($db_conn, $query);
        if ($result) {
            echo "<div class='eoi_data_table'><table style='width:auto'><tr>";
            while ($col = mysqli_fetch_field($result)) {
                $fields[] = $col->name;
                echo "<th class='no-gradient'>" . $col->name . "</th>";
            }
            echo "</tr>";
            // echo rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                for ($i = 0; $i < count($fields); $i++) {
                    echo "<td>" . $row[$fields[$i]] . "</td>";
                }
                echo "</tr>";
            }
            echo "</td></table></div>";
        } else {
            echo "" . mysqli_error($db_conn);
        }
        mysqli_close($db_conn);
    } else {
        echo "<p>Unable to connect to database</p>";
    }
}
// data handling
if (empty($_POST["user_option"])) {
    $user_option = "none";
} else {
    $user_option = $_POST["user_option"];
}
if (empty($_POST["user_option_name"])) {
    $user_option_name = "";
} else {
    $user_option_name = $_POST["user_option_name"];
}
if (empty($_POST["action"])) {
    $action = "";
} else {
    $action = $_POST["action"];
}
?>
<div id="main-container">
    <h1>Manage Job Applications</h1>
    <h2>User options:</h2>
    <?php
    // buttons for each action
    user_option_button("List all EOIs", "a");
    user_option_button("List EOIs for a particular position", "b");
    user_option_button("List EOIs for a specific applicant", "c");
    user_option_button("Delete all EOIs for specific position", "d");
    user_option_button("Change status of EOI", "e");
    user_option_button("List all Consciousness Uploads", "f");
    user_option_button("List uploads by status", "g");
    user_option_button("Update upload status", "h");
    $address = htmlspecialchars($_SERVER["PHP_SELF"]);
    if ($user_option_name != "") {
        echo "<h2>$user_option_name</h2>";
    }
    // option-specific interface:
    // List all EOIs
    if ($user_option == "a") {
        $query = "SELECT * FROM eoi";
        results_table($query, $host, $user, $pswd, $dbnm);
    }

    // List all EOIs for a particular position (given a job reference number)
    if ($user_option == "b") {
        // data handling
        if (empty($_POST["job_ref_no"])) {
            $job_ref_no = "";
        } else {
            $job_ref_no = $_POST["job_ref_no"];
        }
        echo
            "<form method='post' action=$address>
                <input type='hidden' name='user_option' value='$user_option'>
                <input type='hidden' name='user_option_name' value='$user_option_name'>
                <p>Job reference number:
                <select id=;'job_ref_no' name='job_ref_no' required>
                    <option value='MM26C'" . (($job_ref_no == "MM26C") ? "Selected" : "") . ">Data Analyst (MM26C)</option>
                    <option value='MM00C'" . (($job_ref_no == "MM00C") ? "Selected" : "") . ">Transition Technician (MM00C)</option>
                </select>
                </p>
                <input type='submit' name='action' value='Go'>
                </form>";
        // appears if go is pressed
        if ($action == "Go" && $job_ref_no != "") {
            $query = "SELECT * FROM eoi WHERE JobReferenceNumber = '" . $job_ref_no . "'";
            results_table($query, $host, $user, $pswd, $dbnm);
        }
    }

    // List all EOIs for a particular applicant given their first name, last name or both
    if ($user_option == "c") {
        // data handling
        if (empty($_POST["fname"])) {
            $fname = "";
        } else {
            $fname = $_POST["fname"];
        }
        if (empty($_POST["lname"])) {
            $lname = "";
        } else {
            $lname = $_POST["lname"];
        }
        echo
            "<form method='post' action=$address>
                <input type='hidden' name='user_option' value='$user_option'>
                <input type='hidden' name='user_option_name' value='$user_option_name'>
                <p>First Name: <input type='text' id='fname' name='fname'" . (($fname != "") ? "value='$fname'" : "") . "><p>
                <p>Last Name: <input type='text' id='lname' name='lname'" . (($lname != "") ? "value='$lname'" : "") . "><p>
                <input type='submit' name='action' value='Go'>
                </form>";
        if ($action == "Go") {
            $query = "";
            if ($fname != "" && $lname != "") {
                $query = "SELECT * FROM eoi WHERE FirstName = '" . $fname . "' AND LastName = '" . $lname . "'";
            } elseif ($fname != "") {
                $query = "SELECT * FROM eoi WHERE FirstName = '" . $fname . "'";
            } else if ($lname != "") {
                $query = "SELECT * FROM eoi WHERE LastName = '" . $lname . "'";
            } else {
                echo "<p style=color:red><strong>Please enter a first or last name</strong></p>";
            }
            if ($query != "") {
                results_table($query, $host, $user, $pswd, $dbnm);
            }
        }
    }

    // Delete all EOIs with a specified job reference number
    if ($user_option == "d") {
        // data handling
        if (empty($_POST["job_ref_no"])) {
            $job_ref_no = "";
        } else {
            $job_ref_no = $_POST["job_ref_no"];
        }
        echo
            "<form method='post' action=$address>
                <input type='hidden' name='user_option' value='$user_option'>
                <input type='hidden' name='user_option_name' value='$user_option_name'>
                <p>Job reference number:
                <select id='job_ref_no' name='job_ref_no' required>
                    <option value='MM26C'" . (($job_ref_no == "MM26C") ? "Selected" : "") . ">Data Analyst (MM26C)</option>
                    <option value='MM00C'" . (($job_ref_no == "MM00C") ? "Selected" : "") . ">Transition Technician (MM00C)</option>
                </select>
                </p>
                <input type='submit' name='action' value='Go'> <span style='color:red'> WARNING: This will action cannot be undone!</span>
                </form>";
        if ($action == "Go" && $job_ref_no != "") {
            $query = "DELETE FROM eoi WHERE JobReferenceNumber = '" . $job_ref_no . "'";
            $db_conn = mysqli_connect($host, $user, $pswd, $dbnm);
            if ($db_conn) {
                $result = mysqli_query($db_conn, $query);
                if ($result) {
                    echo "Deletion " . ($result ? "successful" : "unsuccessful");
                } else {
                    echo "" . mysqli_error($db_conn);
                    mysqli_close($db_conn);
                }
            } else {
                echo "<p>Unable to connect to database</p>";
            }
        }
    }

    // Change the Status of an EOI
    if ($user_option == "e") {
        // data handling
        if (empty($_POST["eoi_num"])) {
            $eoi_num = "";
        } else {
            $eoi_num = $_POST["eoi_num"];
        }
        if (empty($_POST["set_status"])) {
            $set_status = "";
        } else {
            $set_status = $_POST["set_status"];
        }
        echo
            "<form method='post' action=$address>
            <input type='hidden' name='user_option' value='$user_option'>
            <input type='hidden' name='user_option_name' value='$user_option_name'>
            <p>EOI Number: <input type='number' name='eoi_num' min='0' value='" . (($eoi_num != "") ? $eoi_num : "") . "' required</p>
            <p>Set status to: <select id='set_status' name='set_status' required>
            <option value='new'>New</option>
            <option value='current'>Current</option>
            <option value='final'>Final</option>
            </select></p>
            <input type='submit' name='action' value='Go'>
            </form>
            ";
        if ($action == "Go" && $eoi_num != "" && $set_status != "") {
            $query = "UPDATE eoi SET Status = '" . $set_status . "' WHERE EOInumber = $eoi_num";
            $db_conn = mysqli_connect($host, $user, $pswd, $dbnm);
            if ($db_conn) {
                $result = mysqli_query($db_conn, $query);
                if (!$result) {
                    echo "" . mysqli_error($db_conn);
                    mysqli_close($db_conn);
                }
            } else {
                echo "<p>Unable to connect to database</p>";
            }
        }
        echo "<h3>Current Applications:</h3>";
        $query = "SELECT EOInumber, Status, JobReferenceNumber, FirstName, LastName FROM eoi";
        results_table($query, $host, $user, $pswd, $dbnm);
    }

    // list all consciousness uploads
    if ($user_option == "f") {
        $query = "SELECT UploadID, FirstName, LastName, Email, SubscriptionPlan, Status, UploadTimestamp FROM consciousness_uploads ORDER BY UploadTimestamp DESC";
        results_table($query, $host, $user, $pswd, $dbnm);
    }

    // list uploads by status
    if ($user_option == "g") {
        if (empty($_POST["status_filter"])) {
            $status_filter = "";
        } else {
            $status_filter = $_POST["status_filter"];
        }
        echo
            "<form method='post' action=$address>
                <input type='hidden' name='user_option' value='$user_option'>
                <input type='hidden' name='user_option_name' value='$user_option_name'>
                <p>Filter by status:
                <select id='status_filter' name='status_filter' required>
                    <option value='Pending'" . (($status_filter == "Pending") ? " selected" : "") . ">Pending</option>
                    <option value='Processing'" . (($status_filter == "Processing") ? " selected" : "") . ">Processing</option>
                    <option value='Uploaded'" . (($status_filter == "Uploaded") ? " selected" : "") . ">Uploaded</option>
                    <option value='Failed'" . (($status_filter == "Failed") ? " selected" : "") . ">Failed</option>
                </select>
                </p>
                <input type='submit' name='action' value='Go'>
                </form>";

        if ($action == "Go" && $status_filter != "") {
            $query = "SELECT UploadID, FirstName, LastName, Email, SubscriptionPlan, Status, UploadTimestamp FROM consciousness_uploads WHERE Status = '" . $status_filter . "' ORDER BY UploadTimestamp DESC";
            results_table($query, $host, $user, $pswd, $dbnm);
        }
    }

    // update upload status
    if ($user_option == "h") {
        if (empty($_POST["upload_id"])) {
            $upload_id = "";
        } else {
            $upload_id = $_POST["upload_id"];
        }
        if (empty($_POST["new_status"])) {
            $new_status = "";
        } else {
            $new_status = $_POST["new_status"];
        }

        echo
            "<form method='post' action=$address>
            <input type='hidden' name='user_option' value='$user_option'>
            <input type='hidden' name='user_option_name' value='$user_option_name'>
            <p>Upload ID: <input type='number' name='upload_id' min='1' value='" . (($upload_id != "") ? $upload_id : "") . "' required></p>
            <p>New Status: <select id='new_status' name='new_status' required>
            <option value='Pending'>Pending</option>
            <option value='Processing'>Processing</option>
            <option value='Uploaded'>Uploaded</option>
            <option value='Failed'>Failed</option>
            </select></p>
            <input type='submit' name='action' value='Update'>
            </form>
            ";

        if ($action == "Update" && $upload_id != "" && $new_status != "") {
            $query = "UPDATE consciousness_uploads SET Status = '" . $new_status . "' WHERE UploadID = $upload_id";
            $db_conn = mysqli_connect($host, $user, $pswd, $dbnm);
            if ($db_conn) {
                $result = mysqli_query($db_conn, $query);
                if ($result) {
                    echo "<p>Status updated successfully!</p>";
                } else {
                    echo "<p>Error updating status: " . mysqli_error($db_conn) . "</p>";
                }
                mysqli_close($db_conn);
            }
        }

        echo "<h3>Current Uploads:</h3>";
        $query = "SELECT UploadID, FirstName, LastName, Status, UploadTimestamp FROM consciousness_uploads ORDER BY UploadTimestamp DESC";
        results_table($query, $host, $user, $pswd, $dbnm);
    }

    ?>

</div>
<?php include ("footer.inc") ?>
</body>

</html>