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
        //redirect ke list
        $this->getlist();
    }

    //menampilkan halaman form tambah
    public function tambah(){
        //nanti  akan paggil model jika id ingin otomatis

        include "../app/views/pelanggan/tambah.php";
    
    }

    public function postTambah(){
        $data = [
            'id' => $_POST['txt_id'],
            'nama' => $_POST['txt_nama'],
            'notelp' => $_POST['txt_telp'],
            'alamat' => $_POST['txt_alamat']
        ];
        $this->model->tambahData($data);//manggil method tambah data
        //redirect ke list
        $this->getlist();
    }

    public function getEdit($id){
        $data = $this->model->ambilData($id);//ambil data berdasarkan id
        include "../app/views/pelanggan/edit.php";//mannggil edit
    }

    public function postEdit(){
            $data = [
                'id' => $_POST['txt_id'],
                'nama' => $_POST['txt_nama'],
                'notelp' => $_POST['txt_telp'],
                'alamat' => $_POST['txt_alamat']
            ];
        $this->model->editData($data);//manggil method edit data
        //redirect ke list
        $this->getlist();
    }



}
?>