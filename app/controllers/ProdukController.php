<?php
include "../app/models/Produk.php";
class ProdukController{
    private $model;//membuat property

    public function __construct(){
        $this->model = new Produk();//membuat objek untuk manggil produk
    }

    public function getlist(){
        $data = $this->model->ambilSemua();//ambil data
        include "../app/views/produk/list.php";//mannggil list 
    }

    public function getDetail($id){
        $data = $this->model->ambilData($id);//ambil data berdasarkan id
        include "../app/views/produk/detail.php";//mannggil detail
    }

    public function delete($id)
    {
        // Mengambil data terlebih dahulu untuk mendapatkan path gambar
        $data = $this->model->ambilData($id);

        // Menghapus file gambar jika ada
        if (!empty($data['gambarproduk']) && file_exists($data['gambarproduk'])) {
            unlink($data['gambarproduk']);
        }

        // Menghapus data produk dari database
        $this->model->hapusData($id);

        // Mengarahkan kembali ke tampilan list
        $this->getlist();
    }

    //menampilkan halaman form tambah
    public function tambah(){
        //nanti akan panggil model jika id ingin otomatis
        include "../app/views/produk/tambah.php";
    }

    public function postTambah()
    {
        try {
            // Proses unggah file gambar dengan penamaan unik yang aman
            $gambar = '';
            if (isset($_FILES['fl_gambar']) && $_FILES['fl_gambar']['error'] == 0) {
                $target_dir = "uploads/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                // Mendapatkan ekstensi file
                $extension = pathinfo($_FILES["fl_gambar"]["name"], PATHINFO_EXTENSION);
                
                // Validasi jenis file
                $allowed_types = ['jpg', 'jpeg', 'png']; // Hanya izinkan JPG & PNG
                if (!in_array(strtolower($extension), $allowed_types)) {
                    echo "<script>alert('File tidak bisa diterima, hanya JPG dan PNG saja!'); window.history.back();</script>";
                    exit();
                }
                
                // Membuat nama file unik dan aman menggunakan bin2hex(random_bytes(5))
                $uniqueName = bin2hex(random_bytes(5)) . '.' . $extension;
                $target_file = $target_dir . $uniqueName;

                if (move_uploaded_file($_FILES["fl_gambar"]["tmp_name"], $target_file)) {
                    $gambar = $target_file;
                }
            }

            // Menyiapkan data untuk disimpan ke database
            $data = [
                'id'     => $_POST['txt_id'],
                'nama'   => $_POST['txt_nama'],
                'harga'  => $_POST['txt_harga'],
                'stok'   => $_POST['txt_stok'],
                'gambar' => $gambar
            ];

            $this->model->tambahData($data);
            $this->getlist();
        } catch (Exception $e) {
            // Handle any exceptions
            echo "<script>alert('Error: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
            exit();
        }
    }

    public function getEdit($id){
        $data = $this->model->ambilData($id);//ambil data berdasarkan id
        include "../app/views/produk/edit.php";//mannggil edit
    }

    public function postEdit()
    {
        // Mengambil data lama untuk mengecek gambar yang sedang digunakan
        $data_lama = $this->model->ambilData($_POST['txt_id']);
        $gambar = $data_lama['gambarproduk']; // Default menggunakan gambar lama

        // Jika ada upload gambar baru
        if (isset($_FILES['fl_gambar']) && $_FILES['fl_gambar']['error'] == 0) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            // Validasi jenis file
            $extension = strtolower(pathinfo($_FILES["fl_gambar"]["name"], PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png']; // Hanya izinkan JPG & PNG
            
            if (!in_array($extension, $allowed_types)) {
                echo "<script>alert('File tidak bisa diterima, hanya JPG, JPEG, dan PNG saja!'); window.history.back();</script>";
                exit();
            }

            // Membuat nama file unik dan aman
            $uniqueName = bin2hex(random_bytes(5)) . '.' . $extension;
            $target_file = $target_dir . $uniqueName;

            if (move_uploaded_file($_FILES["fl_gambar"]["tmp_name"], $target_file)) {
                // Menghapus gambar lama jika ada
                if (!empty($data_lama['gambarproduk']) && file_exists($data_lama['gambarproduk'])) {
                    unlink($data_lama['gambarproduk']);
                }
                $gambar = $target_file;
            }
        }

        // Menyiapkan data untuk update ke database
        $data = [
            'id'     => $_POST['txt_id'],
            'nama'   => $_POST['txt_nama'],
            'harga'  => $_POST['txt_harga'],
            'stok'   => $_POST['txt_stok'],
            'gambar' => $gambar
        ];

        $this->model->editData($data);
        $this->getlist();
    }
}
?>