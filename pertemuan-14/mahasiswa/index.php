<?php
session_start();
$isLogin = isset($_SESSION['login']) && $_SESSION['login'] === true;
$name = $_SESSION['user']['nama'] ?? 'Guest';

include '../controller/connection.php';

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$limit = 2;
$offset = ($page - 1) * $limit;

$where = '';
if ($search !== '') {
    $searchEscaped = mysqli_real_escape_string($connection, $search);
    $where = "WHERE nim LIKE '%$searchEscaped%' OR nama LIKE '%$searchEscaped%'";
}

$query = "SELECT * FROM mahasiswa $where ORDER BY nim ASC LIMIT $limit OFFSET $offset";
$result = mysqli_query($connection, $query);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

$countQuery = "SELECT COUNT(*) as total FROM mahasiswa $where";
$countResult = mysqli_query($connection, $countQuery);
$totalRows = (int)mysqli_fetch_assoc($countResult)['total'];
$totalPages = max(1, ceil($totalRows / $limit));

function renderTableBody($data)
{
    ob_start();
    foreach ($data as $row) {
        echo "<tr class=\"hover:bg-zinc-700 transition\">";
        echo "<td class=\"px-4 py-2 border-b border-zinc-700\">" . htmlspecialchars($row['nim']) . "</td>";
        echo "<td class=\"px-4 py-2 border-b border-zinc-700\">" . htmlspecialchars($row['nama']) . "</td>";
        echo "<td class=\"px-4 py-2 border-b border-zinc-700\">" . htmlspecialchars($row['email']) . "</td>";
        echo "<td class=\"px-4 py-2 border-b border-zinc-700\">" . htmlspecialchars($row['gender']) . "</td>";
        echo "<td class=\"px-4 py-2 border-b border-zinc-700\">" . htmlspecialchars($row['telpon']) . "</td>";
        echo "<td class=\"px-4 py-2 border-b border-zinc-700\">";
        echo "<a href=\"edit.php?nim=" . urlencode($row['nim']) . "\" class=\"text-cyan-400 hover:underline\">Edit</a> | ";
        echo "<a href=\"../controller/proseshapus.php?nim=" . urlencode($row['nim']) . "\" class=\"text-red-400 hover:underline\">Hapus</a>";
        echo "</td></tr>";
    }
    if (empty($data)) {
        echo "<tr><td colspan=\"6\" class=\"px-4 py-6 text-center text-zinc-400\">Belum ada data mahasiswa.</td></tr>";
    }
    return ob_get_clean();
}

function renderPagination($totalPages, $page, $search)
{
    ob_start();
    echo '<nav class="flex space-x-2">';
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = $i == $page ? 'bg-cyan-400 text-zinc-800' : 'bg-zinc-700 text-zinc-100';
        echo "<a href=\"?page=$i&search=" . urlencode($search) . "\" data-page=\"$i\" class=\"px-4 py-2 $active rounded hover:bg-zinc-600 transition\">$i</a>";
    }
    echo '</nav>';
    return ob_get_clean();
}

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    echo json_encode([
        'tbody' => renderTableBody($data),
        'pagination' => renderPagination($totalPages, $page, $search)
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-zinc-900 text-zinc-100">
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
        <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full bg-zinc-800">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b border-zinc-700 text-left">NIM</th>
                        <th class="px-4 py-2 border-b border-zinc-700 text-left">Nama</th>
                        <th class="px-4 py-2 border-b border-zinc-700 text-left">Email</th>
                        <th class="px-4 py-2 border-b border-zinc-700 text-left">Gender</th>
                        <th class="px-4 py-2 border-b border-zinc-700 text-left">Telpon</th>
                        <th class="px-4 py-2 border-b border-zinc-700 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody id="mahasiswa-tbody">
                    <?= renderTableBody($data) ?>
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center" id="pagination-wrapper">
            <?= renderPagination($totalPages, $page, $search) ?>
        </div>
    </div>
    <script>
        const searchInput = document.getElementById('search');
        const tbody = document.getElementById('mahasiswa-tbody');
        const paginationWrapper = document.getElementById('pagination-wrapper');
        let timeout;
        let currentSearch = "<?= htmlspecialchars($search) ?>";

        function fetchData(page = 1, search = '') {
            const params = new URLSearchParams({
                page,
                search
            });
            fetch(`?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    tbody.innerHTML = data.tbody;
                    paginationWrapper.innerHTML = data.pagination;
                    attachPaginationEvents();
                    updateURL(page, search);
                });
        }

        function attachPaginationEvents() {
            document.querySelectorAll('[data-page]').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const page = parseInt(link.dataset.page);
                    fetchData(page, currentSearch);
                });
            });
        }

        function updateURL(page, search) {
            const params = new URLSearchParams();
            if (page > 1) params.set('page', page);
            if (search) params.set('search', search);
            history.pushState({}, '', '?' + params.toString());
        }

        searchInput.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                currentSearch = searchInput.value.trim();
                fetchData(1, currentSearch);
            }, 300);
        });

        attachPaginationEvents();
    </script>
</body>

</html>