<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Data Pelanggan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            
                            <div class="col-md-8">
                                            <!-- hati hati disinilah terjadi kesalahan -->
                                <form action="index.php?page=post_edit" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="txt_id" value="<?= $data['pelangganid']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="txt_nama" value="<?= $data['namapelanggan']; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" name="txt_telp" value="<?= $data['nomortelepon']; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" name="txt_alamat" rows="3" required><?= $data['alamat']; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Foto Profile</label>
                                        <?php if(!empty($data['gambarprofil'])): ?>
                                            <img src="<?= $data['gambarprofil'] ?>" alt="Current photo" class="img-thumbnail mb-2" style="max-width: 200px"><br>
                                        <?php endif; ?>
                                        <input class="form-control" type="file" id="formFile" name="fl_foto">
                                        <input type="hidden" name="foto_lama" value="<?= $data['gambarprofil'] ?>">
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary" name="sbt_update">Simpan Perubahan</button>
                                        <a href="index.php?c=pelanggan&page=list" class="btn btn-secondary">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>