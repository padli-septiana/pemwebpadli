<?php
$server = "localhost";
$username = "root";
$password = "root";

$connection = mysqli_connect($server, $username, $password);
mysqli_select_db($connection, "pemweb") or die("Database not found");
