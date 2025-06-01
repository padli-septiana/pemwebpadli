<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan 12 - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-zinc-900 flex items-center justify-center min-h-screen transition-colors">
    <div class="bg-zinc-800 shadow-lg rounded-lg p-8 w-full max-w-sm transition-colors">
        <h2 class="text-2xl font-bold mb-6 text-center text-zinc-100">Login</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="mb-4 text-red-400 text-center">Email atau password salah!</div>
        <?php endif; ?>
        <form action="controller/login.php" method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-zinc-300 mb-1">Email</label>
                <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-zinc-700 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-zinc-700 text-zinc-100">
            </div>
            <div>
                <label for="password" class="block text-zinc-300 mb-1">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-3 py-2 border border-zinc-700 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-zinc-700 text-zinc-100">
            </div>
            <button type="submit" class="w-full bg-cyan-400 text-white py-2 rounded hover:bg-cyan-500 transition">Login</button>
        </form>
    </div>
</body>

</html>