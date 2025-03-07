<?php
include "../app/models/Produk.php";
include "../app/models/Penjualan.php"; // Assuming you have this model

class PenjualanController {
    private $produkModel;
    private $penjualanModel;

    public function __construct() {
        $this->produkModel = new Produk();
        $this->penjualanModel = new Penjualan(); // If you have a Penjualan model
    }

    public function getList() {
        $data = $this->produkModel->ambilSemua(); // Get all products
        include "../app/views/penjualan/list.php";
    }

    // Other methods for handling sales...
}
?>