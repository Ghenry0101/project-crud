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

    public function delete($id)
    {
        // Mengambil data terlebih dahulu untuk mendapatkan path foto
        $data = $this->model->ambilData($id);

        // Menghapus file foto jika ada
        if (!empty($data['gambarprofil']) && file_exists($data['gambarprofil'])) {
            unlink($data['gambarprofil']);
        }

        // Menghapus data pelanggan dari database
        $this->model->hapusData($id);

        // Mengarahkan kembali ke tampilan list
        $this->getlist();
    }

    //menampilkan halaman form tambah
    public function tambah(){
        //nanti  akan paggil model jika id ingin otomatis

        include "../app/views/pelanggan/tambah.php";
    
    }

    public function postTambah()
    {
        // Proses unggah file foto dengan penamaan unik yang aman
        $foto = '';
        if (isset($_FILES['fl_foto']) && $_FILES['fl_foto']['error'] == 0) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            // Mendapatkan ekstensi file
            $extension = pathinfo($_FILES["fl_foto"]["name"], PATHINFO_EXTENSION);
            // Membuat nama file unik dan aman menggunakan bin2hex(random_bytes(16))
            $uniqueName = bin2hex(random_bytes(5)) . '.' . $extension;
            $target_file = $target_dir . $uniqueName;

            if (move_uploaded_file($_FILES["fl_foto"]["tmp_name"], $target_file)) {
                $foto = $target_file;
            }
        }

        // Validasi jenis file
        $allowed_types = ['jpg', 'jpeg', 'png']; // Hanya izinkan JPG & PNG
        $extension = strtolower(pathinfo($_FILES["fl_foto"]["name"], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed_types)) {
            echo "<script>alert('File tidak bisa diterima, hanya JPG dan PNG saja!'); window.history.back();</script>";
            exit();
        }

        // Menyiapkan data untuk disimpan ke database
        $data = [
            'id'     => $_POST['txt_id'],
            'nama'   => $_POST['txt_nama'],
            'notelp' => $_POST['txt_telp'],
            'foto'   => $foto,
            'alamat' => $_POST['txt_alamat']
        ];

        $this->model->tambahData($data);
        $this->getlist();
    }

    public function getEdit($id){
        $data = $this->model->ambilData($id);//ambil data berdasarkan id
        include "../app/views/pelanggan/edit.php";//mannggil edit
    }

    public function postEdit()
    {
        // Mengambil data lama untuk mengecek foto yang sedang digunakan
        $data_lama = $this->model->ambilData($_POST['txt_id']);
        $foto = $data_lama['gambarprofil']; // Default menggunakan foto lama

        // Jika ada upload foto baru
        if (isset($_FILES['fl_foto']) && $_FILES['fl_foto']['error'] == 0) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Validasi jenis file
        $allowed_types = ['jpg', 'jpeg', 'png']; // Hanya izinkan JPG & PNG
        $extension = strtolower(pathinfo($_FILES["fl_foto"]["name"], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed_types)) {
            echo "<script>alert('File tidak bisa diterima, hanya JPG dan PNG saja!'); window.history.back();</script>";
            exit();
        }

            // Mendapatkan ekstensi file
            $extension = pathinfo($_FILES["fl_foto"]["name"], PATHINFO_EXTENSION);
            // Membuat nama file unik dan aman menggunakan bin2hex(random_bytes(16))
            $uniqueName = bin2hex(random_bytes(5)) . '.' . $extension;
            $target_file = $target_dir . $uniqueName;

            if (move_uploaded_file($_FILES["fl_foto"]["tmp_name"], $target_file)) {
                // Menghapus foto lama jika ada
                if (!empty($data_lama['gambarprofil']) && file_exists($data_lama['gambarprofil'])) {
                    unlink($data_lama['gambarprofil']);
                }
                $foto = $target_file;
            }
        }

        // Menyiapkan data untuk update ke database
        $data = [
            'id'     => $_POST['txt_id'],
            'nama'   => $_POST['txt_nama'],
            'notelp' => $_POST['txt_telp'],
            'foto'   => $foto,
            'alamat' => $_POST['txt_alamat']
        ];

        $this->model->editData($data);
        $this->getlist();
    }

    


}
?>