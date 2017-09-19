<?php
//session start
session_start();

// destroy session and go to home
session_destroy();
echo "<script>window.open('index.php','_self')</script>";
?>