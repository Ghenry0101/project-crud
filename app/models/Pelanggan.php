<?php
include "../config/Database.php";
class Pelanggan{
    private $tabel = "pelanggan";
    private $dbkoneksi;

    public function __construct()
    {
        $this->dbkoneksi = new Database();
        $this->dbkoneksi = $this->dbkoneksi->sambungkan();
    }

    //method untuk ambil semua data pelanggan
    public function ambilSemua(){
        //siapin perintah sql yang mau dijalankan
        $sql = "SELECT * FROM $this->tabel";
        //menyiapkan koneksi
        $query = $this->dbkoneksi->prepare($sql);
        //melakukan esekusi
        $query->execute();
        //ambil semua data
        $hasil = $query->fetchAll(PDO::FETCH_ASSOC);
        //mengeluarkan hasil dari esekusi
        return $hasil;
    }

    //method untuk ambil data pelanggan berdasarkan id
    public function ambilData($filter){
        $sql = "SELECT * FROM $this->tabel WHERE pelangganid ='$filter'";//sql untuk ambil data pelangganid
        $query = $this->dbkoneksi->prepare($sql);//siapkan koneksi
        $query->execute();//esekusi
        $hasil = $query->fetch(PDO::FETCH_ASSOC);//mengambil data
        return $hasil;//keluar hasil
    }

    public function hapusData($filter){
        $sql = "DELETE FROM $this->tabel WHERE pelangganid ='$filter'";//sql untuk hapus data pelangganid
        $query = $this->dbkoneksi->prepare($sql);//siapkan koneksi
        $query->execute();//esekusi
        return $query;//data dihapus
    }

    public function tambahData($data){
        $sql ="INSERT INTO $this->tabel 
        (pelangganid, namapelanggan, nomortelepon, alamat) 
        VALUES (:id, :nama, :notelp, :alamat)";

        $query = $this->dbkoneksi->prepare($sql);
        $query->execute($data);
        return $query;
    }

    public function updateData($data){
        $sql ="INSERT INTO $this->tabel 
        (pelangganid, namapelanggan, nomortelepon, alamat) 
        VALUES (:id, :nama, :notelp, :alamat)";

        $query = $this->dbkoneksi->prepare($sql);
        $query->execute($data);
        return $query;
    }
}
?>