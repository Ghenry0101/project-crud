<?php
require_once "../app/controllers/PelangganController.php";
require_once "../app/controllers/ProdukController.php";
require_once "../app/controllers/PenjualanController.php";
require_once "../app/controllers/LoginController.php";

$controllerName = isset($_GET['c']) ? strtolower($_GET['c']) : '';
$action = isset($_GET['page']) ? $_GET['page'] : 'list';

// URL Root: default ke LoginController::getLogin()
if (!$controllerName) {
    $controller = new LoginController();
    $controller->getLogin();
    exit;
}

// Menentukan controller
if ($controllerName === 'pelanggan') {
    $controller = new PelangganController();
} elseif ($controllerName === 'produk') {
    $controller = new ProdukController();
} elseif ($controllerName === 'penjualan') {
    $controller = new PenjualanController();
    
    // Menangani aksi penjualan secara terpisah
    if ($action === 'list') {
        $controller->getList();
        exit;
    } elseif ($action === 'detail' && isset($_GET['id'])) {
        // Redirect ke detail produk untuk sementara
        header("Location: index.php?c=produk&page=detail&id=" . $_GET['id']);
        exit;
    } elseif ($action === 'keranjang') {
        $controller->getKeranjang();
        exit;
    } elseif ($action === 'tambah_ke_keranjang') {
        $controller->tambahKeKeranjang();
        exit;
    } elseif ($action === 'update_keranjang') {
        $controller->updateKeranjang();
        exit;
    } elseif ($action === 'update_keranjang_ajax') {
        $controller->updateKeranjangAjax();
        exit;
    } elseif ($action === 'hapus_dari_keranjang') {
        $controller->hapusDariKeranjang();
        exit;
    } elseif ($action === 'kosongkan_keranjang') {
        $controller->kosongkanKeranjang();
        exit;
    } elseif ($action === 'checkout') {
        $controller->checkout();
        exit;
    } elseif ($action === 'riwayat') {
        $controller->getRiwayat();
        exit;
    } elseif ($action === 'detail_riwayat') {
        $controller->getDetailRiwayat();
        exit;
    }
} elseif ($controllerName === 'login') {
    $controller = new LoginController();
    
    // Menangani aksi login secara terpisah
    if ($action === 'login') {
        $controller->getLogin();
        exit;
    } elseif ($action === 'proses') {
        $controller->prosesLogin();
        exit;
    } elseif ($action === 'logout') {
        $controller->logout();
        exit;
    } else {
        $controller->getLogin();
        exit;
    }
} else {
    // Kembali ke ProdukController jika tidak valid
    $controller = new ProdukController();
    $controller->getList();
    exit;
}

// Mengarahkan aksi untuk controller lainnya
if ($action === 'list') {
    $controller->getList();
} elseif ($action === 'detail' && isset($_GET['id'])) {
    $controller->getDetail($_GET['id']);
} elseif ($action === 'delete' && isset($_GET['id'])) {
    $controller->delete($_GET['id']);
} elseif ($action === 'tambah') {
    $controller->tambah();
} elseif ($action === 'simpan' && isset($_POST['sbt_simpan'])) {
    $controller->postTambah();
} elseif ($action === 'edit' && isset($_GET['id'])) {
    $controller->getEdit($_GET['id']);
} elseif ($action === 'post_edit' && isset($_POST['sbt_update'])) {
    $controller->postEdit();
} else {
    $controller->getList();
}