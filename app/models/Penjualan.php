<?php
require_once __DIR__ . "/../../config/Database.php";

class Penjualan {
    private $tabel_penjualan = "penjualan";
    private $tabel_detail = "detailpenjualan";
    private $dbkoneksi;

    public function __construct()
    {
        $this->dbkoneksi = new Database();
        $this->dbkoneksi = $this->dbkoneksi->sambungkan();
    }

    // Metode untuk menginisialisasi keranjang belanja dalam session
    public function initKeranjang() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }
    }

    // Metode untuk menambahkan produk ke keranjang
    public function tambahKeKeranjang($produkid, $jumlah = 1) {
        $this->initKeranjang();
        
        // Cek apakah produk sudah ada di keranjang
        if (isset($_SESSION['keranjang'][$produkid])) {
            // Jika sudah ada, tambahkan jumlahnya
            $_SESSION['keranjang'][$produkid]['jumlah'] += $jumlah;
        } else {
            // Jika belum ada, ambil data produk dari database
            $produk = $this->getProdukById($produkid);
            
            if ($produk) {
                $_SESSION['keranjang'][$produkid] = [
                    'produkid' => $produkid,
                    'namaproduk' => $produk['namaproduk'],
                    'harga' => $produk['Harga'],
                    'jumlah' => $jumlah,
                    'subtotal' => $produk['Harga'] * $jumlah
                ];
            }
        }
    }

    // Metode untuk mengupdate jumlah produk di keranjang
    public function updateKeranjang($produkid, $jumlah) {
        $this->initKeranjang();
        
        if (isset($_SESSION['keranjang'][$produkid])) {
            if ($jumlah <= 0) {
                // Jika jumlah 0 atau negatif, hapus produk dari keranjang
                $this->hapusDariKeranjang($produkid);
            } else {
                // Update jumlah dan subtotal
                $_SESSION['keranjang'][$produkid]['jumlah'] = $jumlah;
                $_SESSION['keranjang'][$produkid]['subtotal'] = $_SESSION['keranjang'][$produkid]['harga'] * $jumlah;
            }
        }
    }

    // Metode untuk menghapus produk dari keranjang
    public function hapusDariKeranjang($produkid) {
        $this->initKeranjang();
        
        if (isset($_SESSION['keranjang'][$produkid])) {
            unset($_SESSION['keranjang'][$produkid]);
        }
    }

    // Metode untuk mengosongkan keranjang
    public function kosongkanKeranjang() {
        $this->initKeranjang();
        $_SESSION['keranjang'] = [];
    }

    // Metode untuk mendapatkan isi keranjang
    public function getKeranjang() {
        $this->initKeranjang();
        return $_SESSION['keranjang'];
    }

    // Metode untuk menghitung total belanja
    public function getTotalKeranjang() {
        $this->initKeranjang();
        $total = 0;
        
        foreach ($_SESSION['keranjang'] as $item) {
            $total += $item['subtotal'];
        }
        
        return $total;
    }

    // Metode untuk mendapatkan data produk berdasarkan ID
    private function getProdukById($produkid) {
        $sql = "SELECT * FROM produk WHERE produkid = :produkid";
        $query = $this->dbkoneksi->prepare($sql);
        $query->bindParam(':produkid', $produkid);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Metode untuk memproses penjualan
    public function prosesPenjualan($pelangganid, $keranjang, $total) {
        try {
            // Mulai transaksi
            $this->dbkoneksi->beginTransaction();
            
            // Simpan data penjualan
            $tanggal = date('Y-m-d');
            $sql = "INSERT INTO $this->tabel_penjualan (pelangganid, tanggalpenjualan, totalharga) VALUES (:pelangganid, :tanggal, :total)";
            $query = $this->dbkoneksi->prepare($sql);
            $query->bindParam(':pelangganid', $pelangganid);
            $query->bindParam(':tanggal', $tanggal);
            $query->bindParam(':total', $total);
            $query->execute();
            
            // Ambil ID penjualan yang baru saja dibuat
            $penjualanid = $this->dbkoneksi->lastInsertId();
            
            // Cek apakah penjualanid berhasil didapatkan
            if (!$penjualanid) {
                // Jika tidak, coba ambil penjualanid dengan query
                $sql = "SELECT penjualanid FROM $this->tabel_penjualan WHERE pelangganid = :pelangganid AND tanggalpenjualan = :tanggal AND totalharga = :total ORDER BY penjualanid DESC LIMIT 1";
                $query = $this->dbkoneksi->prepare($sql);
                $query->bindParam(':pelangganid', $pelangganid);
                $query->bindParam(':tanggal', $tanggal);
                $query->bindParam(':total', $total);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                
                if ($result) {
                    $penjualanid = $result['penjualanid'];
                } else {
                    throw new Exception("Gagal mendapatkan ID penjualan");
                }
            }
            
            // Simpan detail penjualan
            $detailid = 1; // Mulai dari 1
            foreach ($keranjang as $item) {
                // Cek apakah detailid sudah ada
                $sql = "SELECT COUNT(*) as count FROM $this->tabel_detail WHERE detailid = :detailid";
                $query = $this->dbkoneksi->prepare($sql);
                $query->bindParam(':detailid', $detailid);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                
                // Jika detailid sudah ada, cari detailid yang belum digunakan
                while ($result['count'] > 0) {
                    $detailid++;
                    $query->bindParam(':detailid', $detailid);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                }
                
                $sql = "INSERT INTO $this->tabel_detail (detailid, penjualanid, produkid, jumlahproduk, subtotal) VALUES (:detailid, :penjualanid, :produkid, :jumlahproduk, :subtotal)";
                $query = $this->dbkoneksi->prepare($sql);
                $query->bindParam(':detailid', $detailid);
                $query->bindParam(':penjualanid', $penjualanid);
                $query->bindParam(':produkid', $item['produkid']);
                $query->bindParam(':jumlahproduk', $item['jumlah']);
                $query->bindParam(':subtotal', $item['subtotal']);
                $query->execute();
                
                // Update stok produk
                $sql = "UPDATE produk SET stok = stok - :jumlah WHERE produkid = :produkid";
                $query = $this->dbkoneksi->prepare($sql);
                $query->bindParam(':jumlah', $item['jumlah']);
                $query->bindParam(':produkid', $item['produkid']);
                $query->execute();
                
                $detailid++; // Increment untuk detail berikutnya
            }
            
            // Commit transaksi
            $this->dbkoneksi->commit();
            
            return $penjualanid;
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            $this->dbkoneksi->rollBack();
            throw $e;
        }
    }
    
    // Metode untuk mendapatkan riwayat pembelian
    public function getRiwayatPembelian($pelangganid) {
        $sql = "SELECT p.*, pl.namapelanggan FROM $this->tabel_penjualan p 
                JOIN pelanggan pl ON p.pelangganid = pl.pelangganid 
                WHERE p.pelangganid = :pelangganid 
                ORDER BY p.tanggalpenjualan DESC";
        $query = $this->dbkoneksi->prepare($sql);
        $query->bindParam(':pelangganid', $pelangganid);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Metode untuk mendapatkan detail pembelian
    public function getDetailPembelian($penjualanid) {
        $sql = "SELECT d.*, p.namaproduk, p.Harga FROM $this->tabel_detail d 
                JOIN produk p ON d.produkid = p.produkid 
                WHERE d.penjualanid = :penjualanid";
        $query = $this->dbkoneksi->prepare($sql);
        $query->bindParam(':penjualanid', $penjualanid);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Metode untuk mendapatkan data penjualan berdasarkan ID
    public function getPenjualanById($penjualanid) {
        $sql = "SELECT p.*, pl.namapelanggan FROM $this->tabel_penjualan p 
                JOIN pelanggan pl ON p.pelangganid = pl.pelangganid 
                WHERE p.penjualanid = :penjualanid";
        $query = $this->dbkoneksi->prepare($sql);
        $query->bindParam(':penjualanid', $penjualanid);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
