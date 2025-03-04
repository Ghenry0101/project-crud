<?php
include "../config/Database.php";
class Produk{
    private $tabel = "produk";
    private $dbkoneksi;

    public function __construct()
    {
        $this->dbkoneksi = new Database();
        $this->dbkoneksi = $this->dbkoneksi->sambungkan();
    }

    //method untuk ambil semua data produk
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

    //method untuk ambil data produk berdasarkan id
    public function ambilData($filter){
        $sql = "SELECT * FROM $this->tabel WHERE produkid ='$filter'";//sql untuk ambil data produkid
        $query = $this->dbkoneksi->prepare($sql);//siapkan koneksi
        $query->execute();//esekusi
        $hasil = $query->fetch(PDO::FETCH_ASSOC);//mengambil data
        return $hasil;//keluar hasil
    }

    public function hapusData($filter){
        $sql = "DELETE FROM $this->tabel WHERE produkid ='$filter'";//sql untuk hapus data produkid
        $query = $this->dbkoneksi->prepare($sql);//siapkan koneksi
        $query->execute();//esekusi
        return $query;//data dihapus
    }

    public function tambahData($data){
        $sql ="INSERT INTO $this->tabel 
        (produkid, namaproduk, harga, stok, gambarproduk) 
        VALUES (:id, :nama, :harga, :stok, :gambar)";

        $query = $this->dbkoneksi->prepare($sql);
        $query->execute($data);
        return $query;
    }

    public function editData($data)
    {
        $sql = "UPDATE $this->tabel 
                SET namaproduk = :nama,
                    harga = :harga,
                    stok = :stok,
                    gambarproduk = :gambar
                WHERE produkid = :id";

        $query = $this->dbkoneksi->prepare($sql);
        $query->execute($data);
        return $query;
    }
}