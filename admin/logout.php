<?php
session_start();
$_SESSION['ck_Admin'] = "";
unset($_SESSION['ck_Admin']);
$_SESSION['authMsg'] = "You have been logged out";
header("Location: login");
?>
