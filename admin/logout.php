<?php
session_start();
unset($_SESSION['login_user']);
unset($_SESSION['user_level']);
unset($_SESSION['user_key']);

session_destroy();

header("location:../index.php");
?>
