<?php
include "../app/models/Pelanggan.php";
class PelangganController{
    private $model;//membuat property

    public function __construct(){
        $this->model = new Pelanggan();//membuat objek untuk manggil pelanggan
    }

    public function getlist(){
        $data = $this->model->ambilSemua();//ambil data
        include "../app/views/pelanggan/list.php";//mannggil list 
    }

    public function getDetail($id){
        $data = $this->model->ambilData($id);//ambil data berdasarkan id
        include "../app/views/pelanggan/detail.php";//mannggil detail
    }

    public function delete($id){
        $query = $this->model->hapusData($id);//hapus data pelangganid
        // Ambil data untuk mendapatkan path foto
    $data = $this->model->ambilData($id);
    
    // Hapus file foto jika ada
    if(!empty($data['gambarprofil']) && file_exists($data['gambarprofil'])) {
        unlink($data['gambarprofil']);
    }
    
    // Hapus data pelanggan
    

    $this->model->hapusData($id);
        //redirect ke list
        $this->getlist();
    }

    //menampilkan halaman form tambah
    public function tambah(){
        //nanti  akan paggil model jika id ingin otomatis

        include "../app/views/pelanggan/tambah.php";
    
    }

    public function postTambah(){
        // Handle file upload
        $foto = '';
        if(isset($_FILES['fl_foto']) && $_FILES['fl_foto']['error'] == 0) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["fl_foto"]["name"]);
            if (move_uploaded_file($_FILES["fl_foto"]["tmp_name"], $target_file)) {
                $foto = $target_file;
            }
        }

        $data = [
            'id' => $_POST['txt_id'],
            'nama' => $_POST['txt_nama'],
            'notelp' => $_POST['txt_telp'],
            'foto' => $foto,
            'alamat' => $_POST['txt_alamat']
        ];
        $this->model->tambahData($data);
        $this->getlist();
    }

    public function getEdit($id){
        $data = $this->model->ambilData($id);//ambil data berdasarkan id
        include "../app/views/pelanggan/edit.php";//mannggil edit
    }

    public function postEdit(){
        // Ambil data lama untuk cek foto
    $data_lama = $this->model->ambilData($_POST['txt_id']);
    $foto = $data_lama['gambarprofil']; // Default ke foto lama

    // Jika ada upload foto baru
    if(isset($_FILES['fl_foto']) && $_FILES['fl_foto']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["fl_foto"]["name"]);
        
        // Upload foto baru
        if (move_uploaded_file($_FILES["fl_foto"]["tmp_name"], $target_file)) {
            // Hapus foto lama jika ada
            if(!empty($data_lama['gambarprofil']) && file_exists($data_lama['gambarprofil'])) {
                unlink($data_lama['gambarprofil']);
            }
            $foto = $target_file;
        }
    }

        $data = [
            'id' => $_POST['txt_id'],
            'nama' => $_POST['txt_nama'],
            'notelp' => $_POST['txt_telp'],
            'foto' => $foto,
            'alamat' => $_POST['txt_alamat']
        ];
        $this->model->editData($data);
        $this->getlist();
    }



}
?>