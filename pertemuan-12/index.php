<?php
session_start();
$isLogin = isset($_SESSION['login']) && $_SESSION['login'] === true;
$namaDepan = '';
if ($isLogin && isset($_SESSION['user']['nama'])) {
    $namaDepan = explode(' ', $_SESSION['user']['nama'])[0];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan 12</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="bg-zinc-900 flex items-center justify-center min-h-screen transition-colors">
    <div class="bg-zinc-800 shadow-lg rounded-lg p-8 w-full max-w-sm transition-colors">
        <?php if ($isLogin): ?>
            <h2 class="text-2xl font-bold mb-6 text-center text-zinc-100 capitalize">Halo <?= htmlspecialchars($namaDepan) ?></h2>
            <a href="mahasiswa/index.php" class="w-full block bg-cyan-400 text-white py-2 rounded hover:bg-cyan-500 transition text-center mb-4">Lihat Data Mahasiswa</a>
            <a href="controller/logout.php" class="w-full block bg-red-400 text-white py-2 rounded hover:bg-red-500 transition text-center">Logout</a>
        <?php else: ?>
            <h2 class="text-2xl font-bold mb-6 text-center text-zinc-100 capitalize">Silahkan login terlebih dahulu</h2>
            <a href="login.php" class="w-full block bg-cyan-400 text-white py-2 rounded hover:bg-cyan-500 transition text-center">Login</a>
        <?php endif; ?>
    </div>
</body>

</html>