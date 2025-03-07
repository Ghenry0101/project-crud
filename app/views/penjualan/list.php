<?php
// Get product data first
$produkModel = new Produk();
$data = $produkModel->ambilSemua(); // Fetch all products

// Now set the flag to hide certain actions
$hide_actions = true;

// Include the product list view
include __DIR__ . '/../produk/list.php';
?>