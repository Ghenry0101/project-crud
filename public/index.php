<?php
include "../app/controllers/PelangganController.php";

$controller = new PelangganController();

if(isset($_GET['page']))
{
    $halaman = $_GET['page'];
}else{
    $halaman = 'list';
}

if($halaman == 'list'){
    $controller->getList();//manggil method getList
}
elseif($halaman == 'detail' && isset($_GET['id'])){
    $id = $_GET['id'];
    $controller->getDetail($id);//manggil method getDetail
}
elseif($halaman == 'delete' && isset($_GET['id'])){
    $id = $_GET['id'];
    $controller->delete($id);//manggil method getDetail
}
elseif($halaman == 'tambah'){
    $controller->tambah();//manggil method tambah
}
elseif($halaman == 'simpan' && isset($_POST['sbt_simpan'])){
    $controller->postTambah();//manggil method postTambah

}
else{
    $controller->getlist();//manggil method getlist
}


?>