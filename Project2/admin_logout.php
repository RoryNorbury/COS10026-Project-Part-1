<?php
if (isset($_SESSION['admin_logged_in'])) {
    unset($_SESSION['admin_logged_in']);
}
?>