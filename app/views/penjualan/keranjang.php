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
    <title>Keranjang Belanja</title>
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
                        <a class="nav-link active" href="index.php?c=penjualan&page=keranjang">Keranjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=penjualan&page=riwayat">Riwayat</a>
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
                        <a class="nav-link active" href="index.php?c=penjualan&page=keranjang">Keranjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=penjualan&page=riwayat">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=login&page=logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <h1 class="mb-4">Keranjang Belanja</h1>
    
    <?php if (empty($keranjang)): ?>
    <div class="alert alert-info">
        Keranjang belanja Anda kosong. <a href="index.php?c=penjualan&page=list" class="alert-link">Kembali berbelanja</a>.
    </div>
    <?php else: ?>
    <div id="keranjang-container">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($keranjang as $produkid => $item): 
                ?>
                <tr data-produkid="<?= $produkid ?>" data-harga="<?= $item['harga'] ?>">
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($item['namaproduk']) ?></td>
                    <td class="harga">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td>
                        <input type="number" name="jumlah" class="form-control jumlah-input" value="<?= $item['jumlah'] ?>" min="1" style="width: 80px;" data-produkid="<?= $produkid ?>">
                    </td>
                    <td class="subtotal">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    <td>
                        <a href="index.php?c=penjualan&page=hapus_dari_keranjang&id=<?= $produkid ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini dari keranjang?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-primary">
                    <th colspan="4" class="text-end">Total</th>
                    <th id="total-harga">Rp <?= number_format($total, 0, ',', '.') ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        
        <div class="d-flex justify-content-between mt-3">
            <div>
                <a href="index.php?c=penjualan&page=kosongkan_keranjang" class="btn btn-warning" onclick="return confirm('Yakin ingin mengosongkan keranjang?')">Kosongkan Keranjang</a>
                <a href="index.php?c=penjualan&page=list" class="btn btn-secondary">Lanjutkan Belanja</a>
            </div>
            <div>
                <a href="index.php?c=penjualan&page=checkout" class="btn btn-success">Checkout</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ambil semua input jumlah
    const jumlahInputs = document.querySelectorAll('.jumlah-input');
    
    // Tambahkan event listener untuk setiap input
    jumlahInputs.forEach(input => {
        input.addEventListener('change', function() {
            updateKeranjang(this);
        });
    });
    
    // Fungsi untuk mengupdate keranjang
    function updateKeranjang(input) {
        const produkid = input.dataset.produkid;
        const jumlah = parseInt(input.value);
        const row = input.closest('tr');
        const harga = parseFloat(row.dataset.harga);
        
        // Hitung subtotal baru
        const subtotal = harga * jumlah;
        
        // Update tampilan subtotal
        row.querySelector('.subtotal').textContent = 'Rp ' + formatNumber(subtotal);
        
        // Update total
        updateTotal();
        
        // Kirim data ke server menggunakan fetch API
        fetch('index.php?c=penjualan&page=update_keranjang_ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'produkid=' + produkid + '&jumlah=' + jumlah
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Keranjang berhasil diupdate');
            } else {
                console.error('Gagal mengupdate keranjang');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    // Fungsi untuk mengupdate total
    function updateTotal() {
        let total = 0;
        const rows = document.querySelectorAll('tr[data-produkid]');
        
        rows.forEach(row => {
            const jumlah = parseInt(row.querySelector('.jumlah-input').value);
            const harga = parseFloat(row.dataset.harga);
            total += harga * jumlah;
        });
        
        document.getElementById('total-harga').textContent = 'Rp ' + formatNumber(total);
    }
    
    // Fungsi untuk memformat angka
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
});
</script>
</body>
</html>
