<div class="mt-3">
    <form action="index.php?c=penjualan&page=tambah_ke_keranjang" method="POST">
        <input type="hidden" name="produkid" value="<?= $data['produkid'] ?>">
        <div class="input-group mb-3">
            <span class="input-group-text">Jumlah</span>
            <input type="number" name="jumlah" class="form-control" value="1" min="1" max="<?= $data['stok'] ?>">
            <button type="submit" class="btn btn-primary">Tambahkan ke Keranjang</button>
        </div>
    </form>
</div> 