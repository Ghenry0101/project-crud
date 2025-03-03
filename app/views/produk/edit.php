<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Produk</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <form action="index.php?page=post_edit_produk" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="txt_id" value="<?= $data['produkid']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" name="txt_nama" value="<?= $data['namaproduk']; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Harga</label>
                                        <input type="number" class="form-control" name="txt_harga" value="<?= $data['harga']; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Stok</label>
                                        <input type="number" class="form-control" name="txt_stok" value="<?= $data['stok']; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Gambar Produk</label>
                                        <?php if (!empty($data['gambar'])): ?>
                                            <img src="<?= $data['gambar'] ?>" alt="Current photo" class="img-thumbnail mb-2" style="max-width: 200px"><br>
                                        <?php endif; ?>
                                        <input class="form-control" type="file" id="formFile" name="fl_gambar">
                                        <input type="hidden" name="gambar_lama" value="<?= $data['gambar'] ?>">
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary" name="sbt_update">Simpan Perubahan</button>
                                        <a href="index.php?page=produk" class="btn btn-secondary">Kembali</a>
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
