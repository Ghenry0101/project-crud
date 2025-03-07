<?php
include_once "../config/Database.php";

class Penjualan {
    private $tabel_penjualan = "penjualan";
    private $tabel_detail = "penjualan_detail";
    private $dbkoneksi;

    public function __construct()
    {
        $this->dbkoneksi = new Database();
        $this->dbkoneksi = $this->dbkoneksi->sambungkan();
    }

    // Method untuk membuat penjualan baru
    public function buatPenjualan($data)
    {
        try {
            // Begin transaction
            $this->dbkoneksi->beginTransaction();
            
            // Insert ke tabel penjualan
            $sql = "INSERT INTO $this->tabel_penjualan 
                   (penjualanid, pelangganid, tanggal_penjualan, total) 
                   VALUES (:id, :pelangganid, :tanggal, :total)";
            
            $query = $this->dbkoneksi->prepare($sql);
            $query->execute([
                'id' => $data['id'],
                'pelangganid' => $data['pelangganid'],
                'tanggal' => $data['tanggal'],
                'total' => $data['total']
            ]);
            
            // Insert detail penjualan
            foreach ($data['items'] as $item) {
                $sql_detail = "INSERT INTO $this->tabel_detail 
                              (penjualanid, produkid, jumlah, harga, subtotal) 
                              VALUES (:penjualanid, :produkid, :jumlah, :harga, :subtotal)";
                
                $query_detail = $this->dbkoneksi->prepare($sql_detail);
                $query_detail->execute([
                    'penjualanid' => $data['id'],
                    'produkid' => $item['produkid'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal']
                ]);
                
                // Update stok produk
                $this->updateStokProduk($item['produkid'], $item['jumlah']);
            }
            
            // Commit transaction
            $this->dbkoneksi->commit();
            return true;
        } catch (PDOException $e) {
            // Rollback jika terjadi kesalahan
            $this->dbkoneksi->rollBack();
            error_log("Error creating sale: " . $e->getMessage());
            return false;
        }
    }
    
    // Method untuk update stok produk setelah penjualan
    private function updateStokProduk($produkid, $jumlah)
    {
        $sql = "UPDATE produk SET stok = stok - :jumlah WHERE produkid = :id";
        $query = $this->dbkoneksi->prepare($sql);
        $query->execute([
            'jumlah' => $jumlah,
            'id' => $produkid
        ]);
    }
    
    // Method untuk mengambil semua data penjualan
    public function ambilSemuaPenjualan()
    {
        $sql = "SELECT p.*, pl.namapelanggan 
                FROM $this->tabel_penjualan p
                JOIN pelanggan pl ON p.pelangganid = pl.pelangganid
                ORDER BY p.tanggal_penjualan DESC";
        $query = $this->dbkoneksi->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Method untuk mengambil detail penjualan berdasarkan ID
    public function ambilDetailPenjualan($penjualanid)
    {
        // Ambil header penjualan
        $sql_header = "SELECT p.*, pl.namapelanggan 
                      FROM $this->tabel_penjualan p
                      JOIN pelanggan pl ON p.pelangganid = pl.pelangganid
                      WHERE p.penjualanid = :id";
        $query_header = $this->dbkoneksi->prepare($sql_header);
        $query_header->execute(['id' => $penjualanid]);
        $header = $query_header->fetch(PDO::FETCH_ASSOC);
        
        // Ambil detail penjualan
        $sql_detail = "SELECT pd.*, pr.namaproduk 
                      FROM $this->tabel_detail pd
                      JOIN produk pr ON pd.produkid = pr.produkid
                      WHERE pd.penjualanid = :id";
        $query_detail = $this->dbkoneksi->prepare($sql_detail);
        $query_detail->execute(['id' => $penjualanid]);
        $detail = $query_detail->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'header' => $header,
            'detail' => $detail
        ];
    }
    
    // Method untuk menghapus penjualan (jika diperlukan)
    public function hapusPenjualan($penjualanid)
    {
        try {
            $this->dbkoneksi->beginTransaction();
            
            // Get items first to restore stock
            $sql_items = "SELECT produkid, jumlah FROM $this->tabel_detail WHERE penjualanid = :id";
            $query_items = $this->dbkoneksi->prepare($sql_items);
            $query_items->execute(['id' => $penjualanid]);
            $items = $query_items->fetchAll(PDO::FETCH_ASSOC);
            
            // Restore stock for each item
            foreach ($items as $item) {
                $sql_restore = "UPDATE produk SET stok = stok + :jumlah WHERE produkid = :id";
                $query_restore = $this->dbkoneksi->prepare($sql_restore);
                $query_restore->execute([
                    'jumlah' => $item['jumlah'],
                    'id' => $item['produkid']
                ]);
            }
            
            // Delete detail records
            $sql_delete_detail = "DELETE FROM $this->tabel_detail WHERE penjualanid = :id";
            $query_delete_detail = $this->dbkoneksi->prepare($sql_delete_detail);
            $query_delete_detail->execute(['id' => $penjualanid]);
            
            // Delete header record
            $sql_delete_header = "DELETE FROM $this->tabel_penjualan WHERE penjualanid = :id";
            $query_delete_header = $this->dbkoneksi->prepare($sql_delete_header);
            $query_delete_header->execute(['id' => $penjualanid]);
            
            $this->dbkoneksi->commit();
            return true;
        } catch (PDOException $e) {
            $this->dbkoneksi->rollBack();
            error_log("Error deleting sale: " . $e->getMessage());
            return false;
        }
    }
    
    // Method untuk fungsi keranjang belanja
    public function tambahKeKeranjang($item)
    {
        // Diasumsikan item disimpan dalam session
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }
        
        // Check if product already in cart
        $produkid = $item['produkid'];
        $found = false;
        
        foreach ($_SESSION['keranjang'] as &$cart_item) {
            if ($cart_item['produkid'] == $produkid) {
                $cart_item['jumlah'] += $item['jumlah'];
                $cart_item['subtotal'] = $cart_item['jumlah'] * $cart_item['harga'];
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $_SESSION['keranjang'][] = [
                'produkid' => $item['produkid'],
                'namaproduk' => $item['namaproduk'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['harga'] * $item['jumlah']
            ];
        }
        
        return true;
    }
    
    // Method untuk mendapatkan isi keranjang
    public function ambilKeranjang()
    {
        return isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
    }
    
    // Method untuk menghapus item dari keranjang
    public function hapusItemKeranjang($index)
    {
        if (isset($_SESSION['keranjang'][$index])) {
            unset($_SESSION['keranjang'][$index]);
            // Re-index array
            $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
            return true;
        }
        return false;
    }
    
    // Method untuk kosongkan keranjang
    public function kosongkanKeranjang()
    {
        $_SESSION['keranjang'] = [];
        return true;
    }
    
    // Method untuk menghasilkan ID penjualan baru
    public function generatePenjualanId()
    {
        $prefix = 'PJ' . date('Ymd');
        
        // Get the last ID with this prefix
        $sql = "SELECT MAX(penjualanid) as max_id FROM $this->tabel_penjualan 
                WHERE penjualanid LIKE :prefix";
        $query = $this->dbkoneksi->prepare($sql);
        $query->execute(['prefix' => $prefix . '%']);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if (!$result['max_id']) {
            return $prefix . '001';
        }
        
        // Extract the numeric part and increment
        $last_number = intval(substr($result['max_id'], -3));
        $new_number = $last_number + 1;
        
        // Format with leading zeros
        return $prefix . str_pad($new_number, 3, '0', STR_PAD_LEFT);
    }
}
?>