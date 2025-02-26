<?php
// Contoh data pelanggan
$pelanggan = [
    ['id' => 1, 'nama' => 'John Doe', 'no_telepon' => '08123456789', 'alamat' => 'Jl. Merpati No.12, Jakarta', 'foto' => 'foto2.jpg'],
    ['id' => 2, 'nama' => 'Kayla', 'no_telepon' => '085xxxxxx', 'alamat' => 'Jl. Contoh No.1, Bandung', 'foto' => 'foto1.jpg'],
    ['id' => 3, 'nama' => 'Michael', 'no_telepon' => '085xxxxxx', 'alamat' => 'Jl. Contoh No.2, Surabaya', 'foto' => 'foto3.jpg']
];

$id = $_GET['id'];
$detail = array_filter($pelanggan, function($p) use ($id) {
    return $p['id'] == $id;
});
$detail = array_values($detail)[0];

if(!isset($detail)) {
    header("Location: index.php");
    exit();
}
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
                            <div class="col-md-4 text-center">
                                <!-- Menampilkan foto current -->
                                <img src="uploads/<?php echo $detail['foto']; ?>" class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                                <h5><?php echo $detail['nama']; ?></h5>
                            </div>
                            <div class="col-md-8">
                                <form action="index.php?action=postEdit" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="txt_id" value="<?php echo $detail['id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="txt_nama" value="<?php echo $detail['nama']; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" name="txt_telp" value="<?php echo $detail['no_telepon']; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" name="txt_alamat" rows="3" required><?php echo $detail['alamat']; ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Foto Baru (Opsional)</label>
                                        <input type="file" class="form-control" name="foto" accept="image/*">
                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        <a href="index.php" class="btn btn-secondary">Kembali</a>
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