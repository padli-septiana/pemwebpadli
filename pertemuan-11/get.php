<?php
include 'data.php';
$idUrl = isset($_GET['id']) ? $_GET['id'] : null;

$result = null;
if ($idUrl != null) {
    foreach ($books as $book) {
        if ($book['id'] == $idUrl) {
            $result = $book;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2302061 - M Padli Septiana</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <link href="./index.css" rel="stylesheet">
</head>

<body>
    <!-- navbar -->
    <nav class="nav">
        <h2 class="nav-title">Toko Buku</h2>
        <div class="nav-menu">
            <a href="./index.php">Beranda</a>
            <a href="./get.php">Get</a>
            <a href="./post.php">Post</a>
            <button class="button">Logout</button>
        </div>
    </nav>

    <!-- featured -->
    <section class="container">
        <h2><?= $result['judul'] ?></h2>
        <div class="cards-container">
            <?php
            foreach ($books as $book) : ?>
                <div class="card">
                    <img src="<?= $book['image']; ?>" alt="<?= $book['judul']; ?>" class="card-image">
                    <div class="card-content">
                        <h3 class="card-price">Rp. <?= number_format($book['harga'], 0, ',', '.'); ?></h3>
                        <h3 class="card-title"><?= $book['judul']; ?></h3>
                        <p class="card-description"><?= $book['author']; ?> | <?= $book['genre']; ?></p>
                        <form action="get.php" method="GET">
                            <input type="hidden" name="id" value="<?= $book['id']; ?>">
                            <button class="button">Lihat selengkapnya</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- modal popup -->
    <?php if ($result != null) : ?>
        <div class="modal-container">
            <div class="modal">
                <div class="close-button">
                    <button onclick="window.location.href='get.php';">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="modal-image">
                    <img src="<?= $result['image']; ?>" alt="<?= $result['judul']; ?>" class="card-image">
                </div>
                <div class="modal-content">
                    <p class="modal-price">Rp. <?= number_format($result['harga'], 0, ',', '.'); ?></p>
                    <h2 class="modal-title"><?= $result['judul']; ?></h2>
                    <p class="modal-description"><?= $result['author']; ?> | <?= $result['genre']; ?></p>
                    <p class="modal-description"><?= $result['tahun_terbit']; ?> | <?= $result['penerbit']; ?></p>
                    <p class="modal-description"><?= $result['deskripsi']; ?></p>
                    <button class="button">Beli Sekarang</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>