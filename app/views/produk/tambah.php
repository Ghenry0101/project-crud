<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
        <h2 class="text-center">Tambah Produk</h2>
        <div class="card shadow-sm p-4 mt-3">
            <!-- Form untuk menambah produk -->
            <form action="index.php?page=simpan_produk" method="POST" enctype="multipart/form-data"> 
                <div class="mb-3">
                    <label for="produk_id" class="form-label">ID Produk</label>
                    <input type="text" class="form-control" id="produk_id" name="txt_id" required>
                </div>
                <div class="mb-3">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="nama_produk" name="txt_nama" required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="txt_harga" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="txt_stok" required>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Gambar Produk</label>
                    <input class="form-control" type="file" id="formFile" name="fl_gambar">
                </div>
                <button type="submit" class="btn btn-primary w-100" name="sbt_simpan">Tambah</button>
            </form>
        </div>
        <a href="index.php?page=produk" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>
</html>
