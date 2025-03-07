<?php
require_once __DIR__ . "/../models/Pelanggan.php";

class LoginController {
    private $pelangganModel;

    public function __construct() {
        $this->pelangganModel = new Pelanggan();
    }

    public function getLogin() {
        include __DIR__ . "/../views/login/login.php";
    }

    public function prosesLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pelangganid = $_POST['txt_pelangganid'];
            $namapelanggan = $_POST['txt_namapelanggan'];

            // Debugging: Tampilkan data yang dikirim
            // echo "ID: $pelangganid, Nama: $namapelanggan"; exit;

            $pelanggan = $this->pelangganModel->login($pelangganid, $namapelanggan);

            if ($pelanggan) {
                // Login berhasil, simpan data pelanggan ke session
                session_start();
                $_SESSION['pelanggan_id'] = $pelanggan['pelangganid'];
                $_SESSION['pelanggan_nama'] = $pelanggan['namapelanggan'];
                $_SESSION['is_logged_in'] = true;

                // Redirect ke halaman penjualan melalui controller dengan path absolut
                header("Location: /27rpla-15-kasir/public/index.php?c=penjualan&page=list");
                exit;
            } else {
                // Login gagal
                echo "<script>alert('Data pelanggan tidak ditemukan! Pastikan ID Pelanggan dan Nama Pelanggan benar.'); window.location.href='/27rpla-15-kasir/public/index.php?c=login&page=login';</script>";
                exit;
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?c=login&page=login");
        exit;
    }
} 