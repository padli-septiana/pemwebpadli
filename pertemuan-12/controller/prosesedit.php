<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $gender = $_POST['gender'];
    $telpon = $_POST['telpon'];

    if (!empty($_POST['password'])) {
        $passwordHashed = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $query = "UPDATE mahasiswa SET nama='$nama', password='$passwordHashed', gender='$gender', telpon='$telpon' WHERE nim='$nim'";
    } else {
        $query = "UPDATE mahasiswa SET nama='$nama', gender='$gender', telpon='$telpon' WHERE nim='$nim'";
    }

    $result = mysqli_query($connection, $query);

    if ($result) {
        header("Location: ../mahasiswa/index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
