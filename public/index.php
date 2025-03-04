<?php
include "../app/controllers/PelangganController.php";
include "../app/controllers/ProdukController.php";

// Determine which controller to use based on the page
if(isset($_GET['page'])) {
    $halaman = $_GET['page'];
    
    // Check if it's a product page
    if(strpos($halaman, 'produk') !== false || 
       in_array($halaman, ['tambah_produk', 'detail_produk', 'edit_produk', 'delete_produk', 'simpan_produk', 'post_edit_produk'])) {
        $controller = new ProdukController();
    } else {
        $controller = new PelangganController();
    }
} else {
    $halaman = 'list';
    $controller = new PelangganController();
}

// Route for pelanggan pages
if($halaman == 'list'){
    $controller->getList();//manggil method getList
}
elseif($halaman == 'detail' && isset($_GET['id'])){
    $id = $_GET['id'];
    $controller->getDetail($id);//manggil method getDetail
}
elseif($halaman == 'delete' && isset($_GET['id'])){
    $id = $_GET['id'];
    $controller->delete($id);//manggil method delete
}
elseif($halaman == 'tambah'){
    $controller->tambah();//manggil method tambah
}
elseif($halaman == 'simpan' && isset($_POST['sbt_simpan'])){
    $controller->postTambah();//manggil method postTambah
}
elseif($halaman == 'edit' && isset($_GET['id'])){
    $id = $_GET['id'];
    $controller->getEdit($id);//manggil method getEdit
}
elseif($halaman == 'post_edit' && isset($_POST['sbt_update'])){
    $controller->postEdit();//manggil method postEdit
}

// Routes for produk pages
elseif($halaman == 'produk'){
    $produkController = new ProdukController();
    $produkController->getList();//menampilkan daftar produk
}
elseif($halaman == 'detail_produk' && isset($_GET['id'])){
    $id = $_GET['id'];
    $produkController = new ProdukController();
    $produkController->getDetail($id);
}
elseif($halaman == 'delete_produk' && isset($_GET['id'])){
    $id = $_GET['id'];
    $produkController = new ProdukController();
    $produkController->delete($id);
}
elseif($halaman == 'tambah_produk'){
    $produkController = new ProdukController();
    $produkController->tambah();
}
elseif($halaman == 'simpan_produk' && isset($_POST['sbt_simpan'])){
    $produkController = new ProdukController();
    $produkController->postTambah();
}