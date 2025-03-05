<?php
//print_r($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Detail Produk</h2>
    <div class="card shadow-sm p-4 mt-3 text-center">
        <img src="<?= $data['gambarproduk'] ?>" alt="Foto Produk" class="img-thumbnail mb-3" style="width: 200px; height: 200px; object-fit: cover;">
        <table class="table table-bordered">
            <tr>
                <th>Nama Produk</th>
                <td><?= $data['namaproduk'] ?></td>
            </tr>
            <tr>
                <th>Harga</th>
                <td>Rp <?= number_format($data['harga'], 0, ',', '.') ?></td>
            </tr> 
            <tr>
                <th>Stok</th>
                <td><?= $data['stok'] ?></td>
            </tr>
        </table>
    </div>
    <a href="index.php?c=" class="btn btn-secondary mt-3">Kembali</a>
</div>

</body>
</html>
