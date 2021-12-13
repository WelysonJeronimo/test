<?php
if (!$_SESSION['email']) {
    session_start();
    header('Location: access.php');
    exit();
}
?>