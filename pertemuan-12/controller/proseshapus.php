<?php
include 'connection.php';

$nim = $_GET['nim'];
mysqli_query($connection, "DELETE FROM mahasiswa WHERE nim = '$nim'") or die(mysqli_error($connection));

header("location:../mahasiswa/index.php");
exit();
