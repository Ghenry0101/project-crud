<?php
//print_r($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4">
        <h1 class="mb-4">Daftar Produk</h1>
        <a href="index.php?c=produk&page=tambah" class="btn btn-primary mb-3">Tambah Produk</a>
        
        <div class="album py-3 bg-light">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    
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
                                        <a href="index.php?c=produk&page=detail&id=<?= htmlspecialchars($item['produkid'] ?? '') ?>" class="btn btn-sm btn-outline-secondary">View</a>
                                        <a href="index.php?c=produk&page=edit&id=<?= htmlspecialchars($item['produkid'] ?? '') ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        <a href="index.php?c=produk&page=delete&id=<?= htmlspecialchars($item['produkid'] ?? '') ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')" class="btn btn-sm btn-outline-danger">Delete</a>
                                    </div>
                                    <small class="text-muted">ID: <?= htmlspecialchars($item['produkid'] ?? 'N/A') ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>