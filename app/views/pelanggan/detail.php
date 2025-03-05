<?php
//print_r($data);
$pelanggan = [
    ['id' => 1, 'nama' => 'John Doe', 'no_telepon' => '08123456789', 'alamat' => 'Jl. Merpati No.12, Jakarta', 'foto' => 'image/image1.jpg']
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
        <h2 class="text-center">Detail Pelanggan</h2>
        <div class="card shadow-sm p-4 mt-3 text-center">
            <img src="<?= $data['gambarprofil'] ?>" alt="Foto Profil" class="img-thumbnail mb-3" style="width: 150px; height: 150px; object-fit: cover,; align-self: center;">
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td><?= $data['namapelanggan'] ?></td>
                </tr>
                <tr>
                    <th>Telepon</th>
                    <td><?= $data['nomortelepon'] ?></td>
                </tr> 
                <tr>
                    <th>Alamat</th>
                    <td><?= $data['alamat'] ?></td>
                </tr>
            </table>
        </div>
        <a href="index.php?c=pelanggan&page=list" class="btn btn-secondary mt-3">Kembali</a>
    </div>

</body>
</html>