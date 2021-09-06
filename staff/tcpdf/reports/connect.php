<?php 

ob_start();
$link = mysqli_connect("localhost", "root", "", "dbworktracker");
  

    if($link === false){

        die("ERROR: Could not connect. " . mysqli_connect_error());

    }
?>