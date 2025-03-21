<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Login</h2>
    <div class="card shadow-sm p-4 mt-3">
        <form action="/27rpla-15-kasir/public/index.php?c=login&page=proses" method="POST">
            <div class="mb-3">
                <label for="pelangganid" class="form-label">ID Pelanggan</label>
                <input type="text" class="form-control" id="pelangganid" name="txt_pelangganid" required>
            </div>
            <div class="mb-3">
                <label for="namapelanggan" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" id="namapelanggan" name="txt_namapelanggan" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center">
        Belum punya akun? 
        <a href="index.php?c=login&page=register" class="btn btn-link">Daftar disini</a>
        </p>
    </div>
</div>
</body>
</html>
