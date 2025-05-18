<!DOCTYPE php>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Manage Job Applications">
    <meta name="keywords" content="job, Application, query, sql, manage">
    <meta name="author" content="Meow Meows HR">
    <title>Manage Job Applications</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <?php
    /*
    User actions:
    none: none chosen
    a: List all EOIs
    b: List all EOIs for a particular position (given a job reference number)
    c: List all EOIs for a particular applicant given their first name, last name or both
    d: Delete all EOIs with a specified job reference number
    e: Change the Status of an EOI
    */
    require_once("settings.php");
    // include("menu_bar.inc");
    var_dump($_POST);
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
    function results_table($columns, $rows)
    {
        echo "<table><tr>";
        while ($column = mysqli_fetch_assoc($columns)) {
            $fields[] = $column["Field"];
            echo "<th>" . $column["Field"] . "</th>";
        }
        echo "</tr><tr>";
        while ($row = mysqli_fetch_assoc($rows)) {
            for ($i = 0; $i < count($fields); $i++) {
                echo "<td>" . $row[$fields[$i]] . "</td>";
            }
        }
        echo "</td>";
    }
    // input handling
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
        $address = htmlspecialchars($_SERVER["PHP_SELF"]);
        if ($user_option_name != "") {
            echo "<h2>$user_option_name</h2>";
        }
        // option-specific interface:
        // List all EOIs
        if ($user_option == "a") {
            echo
                "<form method='post' action = $address>
                <input type='hidden' name='user_option' value='$user_option'>
                <input type='hidden' name='user_option_name' value='$user_option_name'>
                <input type='submit' name='action' value='Go'>
                </form>";
            // appears if go is pressed
            if ($action == "Go") {
                $db_conn = mysqli_connect($host, $user, $pswd, $dbnm);
                if ($db_conn) {
                    $query = "SHOW COLUMNS FROM eoi";
                    $columns = mysqli_query($db_conn, $query);
                    $query = "SELECT * FROM eoi";
                    $rows = mysqli_query($db_conn, $query);

                    if ($columns && $rows) {
                        results_table($columns, $rows);
                    } else {
                        echo "" . mysqli_error($db_conn);
                        mysqli_close($db_conn);
                    }
                    mysqli_close($db_conn);
                } else {
                    echo "<p>Unable to connect to database</p>";
                }
            }
        }

        // List all EOIs for a particular position (given a job reference number)
        if ($user_option == "b") {
            if (empty($_POST["job_ref_no"])) {
                $job_ref_no = "";
            } else {
                $job_ref_no = $_POST["job_ref_no"];
            }
            echo
                "<form method='post' action = $address>
                <input type='hidden' name='user_option' value='$user_option'>
                <input type='hidden' name='user_option_name' value='$user_option_name'>
                <label for='job_ref_no'>Job reference number: </label>
                <select id=;'job_ref_no' name='job_ref_no' required>
				    <option value='MM26C'".(($job_ref_no == "MM26C") ? "Selected" : "").">Data Analyst (MM26C)</option>
				    <option value='MM00C'".(($job_ref_no == "MM00C") ? "Selected" : "").">Transition Technician (MM00C)</option>
                    </select>
                <br>
                <input type='submit' name='action' value='Go'>
                </form>";
            // appears if go is pressed
            if ($action == "Go" && $job_ref_no != "") {
                $db_conn = mysqli_connect($host, $user, $pswd, $dbnm);
                if ($db_conn) {
                    $query = "SHOW COLUMNS FROM eoi";
                    $columns = mysqli_query($db_conn, $query);
                    $query = "SELECT * FROM eoi WHERE JobReferenceNumber = '".$job_ref_no."'";
                    $rows = mysqli_query($db_conn, $query);

                    if ($columns && $rows) {
                        results_table($columns, $rows);
                    } else {
                        echo "" . mysqli_error($db_conn);
                        mysqli_close($db_conn);
                    }
                    mysqli_close($db_conn);
                } else {
                    echo "<p>Unable to connect to database</p>";
                }
            }
        }
        ?>

    </div>
    <?php //include ("footer.inc") ?>
</body>

</html>