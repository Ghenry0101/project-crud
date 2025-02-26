<?php
class Database{
    private $dbms = "mysql";
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $namadb = "27_rpla_15_kasir";
    public $koneksi;

    public function sambungkan(){
        $this->koneksi = new PDO("$this->dbms:host=$this->host; 
                                dbname=$this->namadb",
                                $this->user,
                                $this->pass);
    $this->koneksi->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    return $this->koneksi;
    }
}
?>