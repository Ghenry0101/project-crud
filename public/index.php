<?php
require_once "../app/controllers/PelangganController.php";
require_once "../app/controllers/ProdukController.php";
require_once "../app/controllers/PenjualanController.php";
require_once "../app/controllers/LoginController.php";

$controllerName = isset($_GET['c']) ? strtolower($_GET['c']) : '';
$action = isset($_GET['page']) ? $_GET['page'] : 'list';

// Root URL: default to ProdukController::getList()
if (!$controllerName) {
    $controller = new ProdukController();
    $controller->getList();
    exit;
}

// Determine controller
if ($controllerName === 'pelanggan') {
    $controller = new PelangganController();
} elseif ($controllerName === 'produk') {
    $controller = new ProdukController();
} elseif ($controllerName === 'penjualan') {
    $controller = new PenjualanController();
    
    // Handle penjualan actions separately
    if ($action === 'list') {
        $controller->getList();
        exit;
    } elseif ($action === 'detail' && isset($_GET['id'])) {
        // Redirect to produk detail for now
        header("Location: index.php?c=produk&page=detail&id=" . $_GET['id']);
        exit;
    }
} elseif ($controllerName === 'login') {
    $controller = new LoginController();
    
    // Handle login actions separately
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
    // Fallback to ProdukController if invalid
    $controller = new ProdukController();
    $controller->getList();
    exit;
}

// Route actions for other controllers
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