<?php
//print_r($data);
// Contoh data pelanggan
$pelanggan = [
    ['pelangganid' => 1, 'namapelanggan' => 'Kayla', 'nomortelepon' => '085xxxxxx', 'foto' => 'image/image1.jpg']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4">
        <h1 class="mb-4">Daftar Produk</h1>
        <a href="tambah_produk.php" class="btn btn-primary mb-3">Tambah Produk</a>
        
        <div class="album py-3 bg-light">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    
                    <?php while ($data = $result->fetch_assoc()): ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <img src="<?= $data['gambar'] ?>" class="card-img-top" width="100%" height="225" alt="<?= $data['namaproduk'] ?>">
                            
                            <div class="card-body">
                                <h5 class="card-title"><?= $data['namaproduk'] ?></h5>
                                <p class="card-text">Harga: Rp<?= number_format($data['harga'], 0, ',', '.') ?></p>
                                <p class="card-text">Stok: <?= $data['stok'] ?> pcs</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="detail_produk.php?id=<?= $data['produkid'] ?>" class="btn btn-sm btn-outline-secondary">View</a>
                                        <a href="edit_produk.php?id=<?= $data['produkid'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        <a href="hapus_produk.php?id=<?= $data['produkid'] ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')" class="btn btn-sm btn-outline-danger">Delete</a>
                                    </div>
                                    <small class="text-muted">ID: <?= $data['produkid'] ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>