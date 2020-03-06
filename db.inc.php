<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbNam = "login";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbNam);
mysqli_set_charset($conn, 'UTF8');
?>