<?php
// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4">
    <?php
    // Tampilkan menu navigasi sesuai jenis pengguna
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
                        <a class="nav-link" href="index.php?c=penjualan&page=list">Penjualan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=penjualan&page=keranjang">Keranjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?c=penjualan&page=riwayat">Riwayat</a>
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
                        <a class="nav-link" href="index.php?c=penjualan&page=list">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=penjualan&page=keranjang">Keranjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?c=penjualan&page=riwayat">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=login&page=logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Detail Pembelian #<?= $penjualan['penjualanid'] ?></h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="card-title">Informasi Pembelian</h5>
                        <p><strong>Tanggal:</strong> <?= date('d-m-Y', strtotime($penjualan['tanggalpenjualan'])) ?></p>
                        <p><strong>Pelanggan:</strong> <?= htmlspecialchars($penjualan['namapelanggan']) ?></p>
                        <p><strong>Total:</strong> Rp <?= number_format($penjualan['totalharga'], 0, ',', '.') ?></p>
                    </div>
                    
                    <h5 class="card-title mb-3">Detail Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($detail as $item): 
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($item['namaproduk']) ?></td>
                                    <td>Rp <?= number_format($item['Harga'], 0, ',', '.') ?></td>
                                    <td><?= $item['jumlahproduk'] ?></td>
                                    <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-info">
                                    <th colspan="4" class="text-end">Total</th>
                                    <th>Rp <?= number_format($penjualan['totalharga'], 0, ',', '.') ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <a href="index.php?c=penjualan&page=riwayat" class="btn btn-secondary">Kembali ke Riwayat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html> 