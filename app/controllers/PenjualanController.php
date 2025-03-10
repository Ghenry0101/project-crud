<?php
require_once __DIR__ . "/../models/Produk.php";
require_once __DIR__ . "/../models/Penjualan.php";

class PenjualanController {
    private $produkModel;
    private $penjualanModel;

    public function __construct() {
        $this->produkModel = new Produk();
        $this->penjualanModel = new Penjualan();
    }

    public function getList() {
        try {
            $data = $this->produkModel->ambilSemua(); // Get all products
            
            // Debugging: Periksa apakah $data berisi data
            if (empty($data)) {
                $data = []; // Pastikan $data adalah array kosong, bukan null
                // echo "Data produk kosong!"; // Uncomment untuk debugging
            }
            
            include __DIR__ . "/../views/penjualan/list.php";
        } catch (Exception $e) {
            // Tangani kesalahan
            echo "Terjadi kesalahan: " . $e->getMessage();
        }
    }

    public function getDetail($id) {
        try {
            $data = $this->produkModel->ambilData($id);
            include __DIR__ . "/../views/penjualan/detail.php";
        } catch (Exception $e) {
            echo "Terjadi kesalahan: " . $e->getMessage();
        }
    }

    // Metode untuk menampilkan halaman keranjang
    public function getKeranjang() {
        try {
            $keranjang = $this->penjualanModel->getKeranjang();
            $total = $this->penjualanModel->getTotalKeranjang();
            include __DIR__ . "/../views/penjualan/keranjang.php";
        } catch (Exception $e) {
            echo "Terjadi kesalahan: " . $e->getMessage();
        }
    }

    // Metode untuk menambahkan produk ke keranjang
    public function tambahKeKeranjang() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produkid = isset($_POST['produkid']) ? $_POST['produkid'] : null;
            $jumlah = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 1;
            
            if ($produkid) {
                $this->penjualanModel->tambahKeKeranjang($produkid, $jumlah);
                header("Location: index.php?c=penjualan&page=keranjang");
                exit;
            }
        } elseif (isset($_GET['id'])) {
            // Jika dipanggil melalui link dengan parameter id
            $produkid = $_GET['id'];
            $this->penjualanModel->tambahKeKeranjang($produkid, 1);
            header("Location: index.php?c=penjualan&page=keranjang");
            exit;
        }
        
        // Jika tidak ada produk yang ditambahkan, kembali ke halaman produk
        header("Location: index.php?c=penjualan&page=list");
        exit;
    }

    // Metode untuk mengupdate jumlah produk di keranjang
    public function updateKeranjang() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_keranjang'])) {
            foreach ($_POST['jumlah'] as $produkid => $jumlah) {
                $this->penjualanModel->updateKeranjang($produkid, (int)$jumlah);
            }
            header("Location: index.php?c=penjualan&page=keranjang");
            exit;
        }
        
        header("Location: index.php?c=penjualan&page=keranjang");
        exit;
    }

    // Metode untuk menghapus produk dari keranjang
    public function hapusDariKeranjang() {
        if (isset($_GET['id'])) {
            $produkid = $_GET['id'];
            $this->penjualanModel->hapusDariKeranjang($produkid);
        }
        
        header("Location: index.php?c=penjualan&page=keranjang");
        exit;
    }

    // Metode untuk mengosongkan keranjang
    public function kosongkanKeranjang() {
        $this->penjualanModel->kosongkanKeranjang();
        header("Location: index.php?c=penjualan&page=keranjang");
        exit;
    }

    // Metode untuk mengupdate jumlah produk di keranjang via AJAX
    public function updateKeranjangAjax() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produkid = isset($_POST['produkid']) ? $_POST['produkid'] : null;
            $jumlah = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 1;
            
            if ($produkid) {
                $this->penjualanModel->updateKeranjang($produkid, $jumlah);
                
                // Kirim respons JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            }
        }
        
        // Jika ada kesalahan
        header('Content-Type: application/json');
        echo json_encode(['success' => false]);
        exit;
    }

    // Metode untuk proses checkout
    public function checkout() {
        try {
            $keranjang = $this->penjualanModel->getKeranjang();
            $total = $this->penjualanModel->getTotalKeranjang();
            
            if (empty($keranjang)) {
                echo "<script>alert('Keranjang belanja Anda kosong!'); window.location.href='index.php?c=penjualan&page=list';</script>";
                exit;
            }
            
            // Jika form checkout disubmit
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
                // Ambil data pelanggan dari session
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $pelangganid = $_SESSION['pelanggan_id'];
                
                // Proses checkout
                $penjualanid = $this->penjualanModel->prosesPenjualan($pelangganid, $keranjang, $total);
                
                if ($penjualanid) {
                    // Kosongkan keranjang setelah checkout berhasil
                    $this->penjualanModel->kosongkanKeranjang();
                    
                    // Redirect ke halaman sukses atau riwayat
                    echo "<script>alert('Checkout berhasil!'); window.location.href='index.php?c=penjualan&page=riwayat';</script>";
                    exit;
                } else {
                    echo "<script>alert('Checkout gagal!'); window.location.href='index.php?c=penjualan&page=keranjang';</script>";
                    exit;
                }
            }
            
            // Tampilkan halaman checkout
            include __DIR__ . "/../views/penjualan/checkout.php";
        } catch (Exception $e) {
            echo "Terjadi kesalahan: " . $e->getMessage();
        }
    }

    // Metode untuk menampilkan riwayat pembelian
    public function getRiwayat() {
        try {
            // Ambil data pelanggan dari session
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $pelangganid = $_SESSION['pelanggan_id'];
            
            // Ambil riwayat pembelian
            $riwayat = $this->penjualanModel->getRiwayatPembelian($pelangganid);
            
            // Tampilkan halaman riwayat
            include __DIR__ . "/../views/penjualan/riwayat.php";
        } catch (Exception $e) {
            echo "Terjadi kesalahan: " . $e->getMessage();
        }
    }

    // Metode untuk menampilkan detail riwayat pembelian
    public function getDetailRiwayat() {
        try {
            if (isset($_GET['id'])) {
                $penjualanid = $_GET['id'];
                
                // Ambil detail pembelian
                $detail = $this->penjualanModel->getDetailPembelian($penjualanid);
                $penjualan = $this->penjualanModel->getPenjualanById($penjualanid);
                
                // Tampilkan halaman detail riwayat
                include __DIR__ . "/../views/penjualan/detail_riwayat.php";
            } else {
                header("Location: index.php?c=penjualan&page=riwayat");
                exit;
            }
        } catch (Exception $e) {
            echo "Terjadi kesalahan: " . $e->getMessage();
        }
    }

    // Other methods for handling sales...
}
