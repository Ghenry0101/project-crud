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

    // Other methods for handling sales...
}
