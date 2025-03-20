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

            // Debugging: Menampilkan data yang dikirim
            // echo "ID: $pelangganid, Nama: $namapelanggan"; exit;

            $pelanggan = $this->pelangganModel->login($pelangganid, $namapelanggan);

            if ($pelanggan) {
                // Login berhasil, simpan data pelanggan ke session
                session_start();
                $_SESSION['pelanggan_id'] = $pelanggan['pelangganid'];
                $_SESSION['pelanggan_nama'] = $pelanggan['namapelanggan'];
                $_SESSION['is_logged_in'] = true;
                
                // Cek apakah pengguna adalah admin
                if (strtolower($pelanggan['namapelanggan']) === 'admin') {
                    $_SESSION['is_admin'] = true;
                    // Redirect ke halaman admin
                    header("Location: /27rpla-15-kasir/public/index.php?c=produk&page=list");
                } else {
                    $_SESSION['is_admin'] = false;
                    // Redirect ke halaman penjualan untuk pengguna biasa
                    header("Location: /27rpla-15-kasir/public/index.php?c=penjualan&page=list");
                }
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

    public function getRegister() {
        include __DIR__ . "/../views/login/register.php";
    }

    public function prosesRegister() {
        $pelangganid = $_POST['txt_pelangganid'];
        $namapelanggan = $_POST['txt_namapelanggan'];
        $alamat = $_POST['txt_alamat'];

        // Validasi input
        if (empty($pelangganid) || empty($namapelanggan) || empty($alamat)) {
            $_SESSION['error'] = "Semua field harus diisi!";
            header("Location: index.php?c=login&page=register");
            exit;
        }

        // Cek apakah ID sudah digunakan
        $existingPelanggan = $this->pelangganModel->getById($pelangganid);
        if ($existingPelanggan) {
            $_SESSION['error'] = "ID Pelanggan sudah digunakan!";
            header("Location: index.php?c=login&page=register");
            exit;
        }

        // Proses registrasi
        $result = $this->pelangganModel->register($pelangganid, $namapelanggan, $alamat);
        
        if ($result) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: index.php?c=login&page=login");
        } else {
            $_SESSION['error'] = "Gagal melakukan registrasi!";
            header("Location: index.php?c=login&page=register");
        }
        exit;
    }
} 