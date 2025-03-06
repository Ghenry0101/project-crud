<?php
ob_start();
include __DIR__ . '/../pelanggan/tambah.php';
$konten = ob_get_clean();

// Mengganti teks dalam tag <h2> dan tombol
$konten = str_replace(
    '<h2 class="text-center">Tambah Data Pengguna</h2>', 
    '<h2 class="text-center">Register</h2>', 
    $konten
);

$konten = str_replace(
    '<button type="submit" class="btn btn-primary w-100" name="sbt_simpan" >Tambah</button>', 
    '<button type="submit" class="btn btn-primary w-100" name="sbt_simpan" >Daftar</button>', 
    $konten
);

echo $konten;
?>
