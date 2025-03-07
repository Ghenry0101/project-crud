-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2025 at 03:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `27_rpla_15_kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `detailpenjualan`
--

CREATE TABLE `detailpenjualan` (
  `detailid` int NOT NULL,
  `penjualanid` int NOT NULL,
  `produkid` int NOT NULL,
  `jumlahproduk` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `pelangganid` int NOT NULL,
  `namapelanggan` varchar(255) NOT NULL,
  `alamat` text,
  `nomortelepon` varchar(15) DEFAULT NULL,
  `gambarprofil` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`pelangganid`, `namapelanggan`, `alamat`, `nomortelepon`, `gambarprofil`) VALUES
(9, 'danish', 'sgbsbf', '085760032131', 'uploads/3c8c2c586223b3144b8e8640b948b47b.jpg'),
(68, 'satria', 'bekasi kota bintang', '08123456775', 'uploads/942872d0d87042cb4ca98fdb5623c31f.jpg'),
(100, 'pak sat', 'kalimalamg', '09565852', 'uploads/7cd46d98a4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `penjualanid` int NOT NULL,
  `tanggalpenjualan` date NOT NULL,
  `totalharga` decimal(10,2) NOT NULL,
  `pelangganid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `produkid` int NOT NULL,
  `namaproduk` varchar(255) NOT NULL,
  `Harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL,
  `gambarproduk` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`produkid`, `namaproduk`, `Harga`, `stok`, `gambarproduk`) VALUES
(68, 'tws', 50000.00, 79, 'uploads/549f7e2940.jpg'),
(100, 'hape', 7.00, 56, 'uploads/98abe03152.jpg'),
(101, 'hape', 7.00, 56, 'uploads/6c2e823c3b.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  ADD PRIMARY KEY (`detailid`),
  ADD KEY `penjualanid` (`penjualanid`),
  ADD KEY `produkid` (`produkid`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`pelangganid`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`penjualanid`),
  ADD KEY `pelangganid` (`pelangganid`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`produkid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  ADD CONSTRAINT `detailpenjualan_ibfk_1` FOREIGN KEY (`penjualanid`) REFERENCES `penjualan` (`penjualanid`),
  ADD CONSTRAINT `detailpenjualan_ibfk_2` FOREIGN KEY (`produkid`) REFERENCES `produk` (`produkid`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`pelangganid`) REFERENCES `pelanggan` (`pelangganid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
