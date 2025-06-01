<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit();
}
include '../controller/connection.php';

if (!isset($_GET['nim'])) {
    header("Location: index.php");
    exit();
}

$nim = $_GET['nim'];
$query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
$result = mysqli_query($connection, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: index.php");
    exit();
}
$mhs = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-zinc-900 flex items-center justify-center min-h-screen transition-colors">
    <div class="bg-zinc-800 shadow-lg rounded-lg p-8 w-full max-w-md transition-colors">
        <h2 class="text-2xl font-bold mb-6 text-center text-zinc-100">Edit Data Mahasiswa</h2>
        <form action="../controller/prosesedit.php" method="post" class="space-y-4">
            <input type="hidden" name="nim" value="<?= htmlspecialchars($mhs['nim']) ?>">
            <div>
                <label for="nim" class="block text-zinc-300 mb-1">NIM</label>
                <input type="text" id="nim" value="<?= htmlspecialchars($mhs['nim']) ?>" disabled class="w-full px-3 py-2 border border-zinc-700 rounded bg-zinc-700 text-zinc-400">
            </div>
            <div>
                <label for="email" class="block text-zinc-300 mb-1">Email</label>
                <input type="email" id="email" disabled value="<?= htmlspecialchars($mhs['email']) ?>" class="w-full px-3 py-2 border border-zinc-700 rounded bg-zinc-700 text-zinc-400">
            </div>
            <div>
                <label for="nama" class="block text-zinc-300 mb-1">Nama</label>
                <input type="text" id="nama" name="nama" required value="<?= htmlspecialchars($mhs['nama']) ?>" class="w-full px-3 py-2 border border-zinc-700 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-zinc-700 text-zinc-100">
            </div>
            <div>
                <label for="password" class="block text-zinc-300 mb-1">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-zinc-700 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-zinc-700 text-zinc-100">
            </div>
            <div>
                <label for="gender" class="block text-zinc-300 mb-1">Gender</label>
                <select name="gender" id="gender" required class="w-full px-3 py-2 border border-zinc-700 rounded bg-zinc-700 text-zinc-100">
                    <option value="Laki-laki" <?= $mhs['gender'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $mhs['gender'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div>
                <label for="telpon" class="block text-zinc-300 mb-1">Telpon</label>
                <input type="text" id="telpon" name="telpon" required value="<?= htmlspecialchars($mhs['telpon']) ?>" class="w-full px-3 py-2 border border-zinc-700 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-zinc-700 text-zinc-100">
            </div>
            <button type="submit" class="w-full bg-cyan-400 text-white py-2 rounded hover:bg-cyan-500 transition">Update</button>
            <a href="index.php" class="w-full block mt-2 bg-zinc-700 text-white py-2 rounded hover:bg-zinc-600 transition text-center">Kembali</a>
        </form>
    </div>
</body>

</html>