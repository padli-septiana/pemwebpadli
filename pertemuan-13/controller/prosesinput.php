<?php
include 'connection.php';

$nim = $_POST['nim'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$telpon = $_POST['telpon'];
$passwordHashed = password_hash($_POST['password'], PASSWORD_BCRYPT);

$query = "INSERT INTO mahasiswa (nim, nama, email, password, gender, telpon) VALUES ('$nim', '$nama', '$email', '$passwordHashed', '$gender', '$telpon')";

$result = mysqli_query($connection, $query);

if ($result) {
    header("Location: ../mahasiswa/index.php");
    exit();
} else {
    echo "Error: " . mysqli_error($connection);
}
