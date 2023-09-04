<?php
session_start();
$_SESSION['ck_Member'] = "";
unset($_SESSION['ck_Member']);
$_SESSION['authMsg'] = "You have been logged out";
header("Location: login");
?>
