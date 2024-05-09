<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "csc_350";

if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
    die("Failed to connect!");
}

?>