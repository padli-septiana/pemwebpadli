<?php
session_start();
$isLogin = isset($_SESSION['login']) && $_SESSION['login'] === true;
$name = $_SESSION['user']['nama'];

include '../controller/connection.php';
$query = "SELECT * FROM mahasiswa";
$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan 12 - Data Mahasiswa</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="bg-zinc-900 min-h-screen text-zinc-100">
    <div class="container mx-auto py-10">
        <div class="flex flex-col md:flex-row md:justify-between items-center mb-8 gap-4">
            <div class="space-y-2">
                <h1 class="text-3xl font-bold text-cyan-400">Data Mahasiswa</h1>
                <p>Halo, <?= htmlspecialchars($name); ?></p>
            </div>
            <div class="flex gap-2">
                <a href="tambah.php" class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded transition">Tambah Data</a>
                <a href="../index.php" class="bg-zinc-700 hover:bg-zinc-600 text-white px-4 py-2 rounded transition">Home</a>
            </div>
        </div>
        <div class="overflow-x-auto rounded-lg shadow-lg">
            <table class="min-w-full bg-zinc-800 rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-3 border-b border-zinc-700 text-left">NIM</th>
                        <th class="px-4 py-3 border-b border-zinc-700 text-left">Nama</th>
                        <th class="px-4 py-3 border-b border-zinc-700 text-left">Email</th>
                        <th class="px-4 py-3 border-b border-zinc-700 text-left">Gender</th>
                        <th class="px-4 py-3 border-b border-zinc-700 text-left">Telpon</th>
                        <th class="px-4 py-3 border-b border-zinc-700 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr class="hover:bg-zinc-700 transition">
                            <td class="px-4 py-2 border-b border-zinc-700"><?= htmlspecialchars($row['nim']); ?></td>
                            <td class="px-4 py-2 border-b border-zinc-700"><?= htmlspecialchars($row['nama']); ?></td>
                            <td class="px-4 py-2 border-b border-zinc-700"><?= htmlspecialchars($row['email']); ?></td>
                            <td class="px-4 py-2 border-b border-zinc-700"><?= htmlspecialchars($row['gender']); ?></td>
                            <td class="px-4 py-2 border-b border-zinc-700"><?= htmlspecialchars($row['telpon']); ?></td>
                            <td class="px-4 py-2 border-b border-zinc-700">
                                <a href="<?= "edit.php?nim=" . urlencode($row['nim']) ?>" class="text-cyan-400 hover:underline">Edit</a> |
                                <a href="<?= "../controller/proseshapus.php?nim=" . urlencode($row['nim']) ?>" class="text-red-400 hover:underline">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-zinc-400">Belum ada data mahasiswa.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>