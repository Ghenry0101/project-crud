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
        <?php
        // Mulai session jika belum dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Cek apakah pengguna adalah admin
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            // Redirect ke halaman login jika bukan admin
            header("Location: /27rpla-15-kasir/public/index.php?c=login&page=login");
            exit;
        }
        
        // Tampilkan menu navigasi untuk admin
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
                            <a class="nav-link active" href="index.php?c=pelanggan&page=list">Pelanggan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=penjualan&page=list">Penjualan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?c=login&page=logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <h1 class="mb-4">Daftar Pelanggan</h1>
        <a href="index.php?c=pelanggan&page=tambah" class="btn btn-primary mb-3">Tambah Pelanggan</a>
        
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No Telepon</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $baris): ?>
                <tr>
                    <td><?= $baris['pelangganid'] ?></td>
                    <td><?= $baris['namapelanggan'] ?></td> 
                    <td><?= $baris['nomortelepon'] ?></td>
                    <td>
                        <?php if (!empty($baris['gambarprofil'])): ?>
                            <img src="<?= $baris['gambarprofil'] ?>" alt="Foto Pelanggan" width="50" class="img-thumbnail">
                        <?php else: ?>
                            <span class="badge bg-secondary">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="index.php?c=pelanggan&page=detail&id=<?= $baris['pelangganid'] ?>" class="btn btn-sm btn-info">Detail</a>
                        <a href="index.php?c=pelanggan&page=edit&id=<?= $baris['pelangganid'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="index.php?c=pelanggan&page=delete&id=<?= $baris['pelangganid'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>