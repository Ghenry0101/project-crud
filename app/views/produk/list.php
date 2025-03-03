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
    <h1>Daftar Pelanggan</h1>
    <a href="index.php?page=tambah"><button type="button" class="btn btn-primary">Tambah Pelanggan</button></a>
    <table border="1" class="table table-striped">
        <thead>
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
            <td><?= $baris['pelangganid']   ?></td>
            <td><?= $baris['namapelanggan']   ?></td> 
            <td><?= $baris['nomortelepon']   ?></td>
            <td><img src="<?= $baris['gambarprofil'] ?>" alt="Foto Pelanggan" width="50"></td>
                <td>
                    <a href="index.php?page=detail&id=<?= $baris['pelangganid'] ?>"><button type="button" class="btn btn-danger">Detail</button></a>
                    <a href="index.php?page=edit&id=<?= $baris['pelangganid'] ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                    <a href="index.php?page=delete&id=<?= $baris['pelangganid'] ?>" onclick="return confirm('Apakah Anda yakin?')"><button type="button" class="btn btn-dark">Hapus</button></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>