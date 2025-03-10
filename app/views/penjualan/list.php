<?php
//print_r($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4">
        <?php
        // Mulai session jika belum dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Tampilkan menu navigasi jika pengguna adalah admin
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): 
        ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin Panel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=produk&page=list">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=pelanggan&page=list">Pelanggan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php?c=penjualan&page=list">Penjualan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=login&page=logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php else: ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Toko Online</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php?c=penjualan&page=list">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=penjualan&page=keranjang">Keranjang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=login&page=logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php endif; ?>

        <h1 class="mb-4">Daftar Penjualan</h1>
        
        <div class="album py-3 bg-light">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    
                    <?php if (isset($data) && is_array($data) && count($data) > 0): ?>
                        <?php foreach ($data as $item): ?>
                        <div class="col">
                            <div class="card shadow-sm">
                                <?php if (!empty($item['gambarproduk'])): ?>
                                    <img src="<?= htmlspecialchars($item['gambarproduk']) ?>" class="card-img-top" width="100%" height="225" alt="<?= htmlspecialchars($item['namaproduk'] ?? 'Produk') ?>">
                                <?php else: ?>
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 225px;">
                                        <span>No Image</span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($item['namaproduk'] ?? 'Nama Produk Tidak Tersedia') ?></h5>
                                    <p class="card-text">Harga: Rp<?= number_format(floatval($item['Harga'] ?? 0), 0, ',', '.') ?></p>
                                    <p class="card-text">Stok: <?= intval($item['stok'] ?? 0) ?> pcs</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="index.php?c=penjualan&page=detail&id=<?= htmlspecialchars($item['produkid'] ?? '') ?>" class="btn btn-sm btn-outline-secondary">View</a>
                                            <a href="index.php?c=penjualan&page=tambah_ke_keranjang&id=<?= htmlspecialchars($item['produkid'] ?? '') ?>" class="btn btn-sm btn-outline-primary">Keranjang</a>
                                        </div>
                                        <small class="text-muted">ID: <?= htmlspecialchars($item['produkid'] ?? 'N/A') ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p>Tidak ada produk yang tersedia.</p>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>
