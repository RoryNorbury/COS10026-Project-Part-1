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
    require_once("settings.php");
    include("menu_bar.inc"); // replace with menu bar file name
    if (empty($_POST["user_action"])) {
        $user_action = "-1";
    } else {
        $user_action = $_POST["user_action"];
    }
    ?>
    <div id="main-container">
        <h1>Manage Job Applications</h1>
        <h2>List all Applications</h2>
        <?php echo $user_action; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="user_action" value="1">
            <input type="submit" name="submit" value="Show all EOIs">
        </form>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="user_action" value="2">
            <input type="submit" name="submit" value="Show some EOIs">
        </form>
        <?php if (isset($user_action) && $user_action == "1")
            echo "<p>All EOIs<p>";
        if (isset($user_action) && $user_action == "2")
            echo "<p>Some EOIs<p>";
        ?>

    </div>
</body>

</html>