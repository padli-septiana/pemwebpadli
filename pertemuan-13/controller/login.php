<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM mahasiswa WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user'] = [
                'nim' => $user['nim'],
                'nama' => $user['nama'],
                'email' => $user['email']
            ];
            header("Location: ../index.php");
            exit();
        }
    }
    // login gagal
    header("Location: ../login.php?error=1");
    exit();
}
