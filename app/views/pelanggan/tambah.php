<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
        <h2 class="text-center">Tambah Data Pengguna</h2>
        <div class="card shadow-sm p-4 mt-3">
            <!-- hati hati disinilah terjadi kesalahan -->
            <form action="index.php?page=simpan" method="POST" enctype="multipart/form-data"> 
                <div class="mb-3">
                    <label for="nama" class="form-label">id pelanggan</label>
                    <input type="text" class="form-control" id="nama" name="txt_id" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="txt_nama" required>
                </div>
                <div class="mb-3">
                    <label for="no_telepon" class="form-label">No telp</label>
                    <input type="no_telepon" class="no_telepon" id="no_telepon" name="txt_telp" required>
                </div>
                <div class="mb-3">
                    <label for="no_telepon" class="form-label">Alamat</label>
                    <textarea class="no_telepon" id="no_telepon" name="txt_alamat" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Masukkan Foto Profile</label>
                    <input class="form-control" type="file" id="formFile" name="fl_foto">
                </div>
                <button type="submit" class="btn btn-primary w-100" name="sbt_simpan">Tambah</button>
            </form>
        </div>
        <a href="index.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>
</html>