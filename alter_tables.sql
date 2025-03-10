-- Menghapus constraint foreign key
ALTER TABLE `detailpenjualan` DROP FOREIGN KEY `detailpenjualan_ibfk_1`;

-- Mengubah struktur tabel penjualan
ALTER TABLE `penjualan` MODIFY `penjualanid` int NOT NULL AUTO_INCREMENT;

-- Mengubah struktur tabel detailpenjualan
ALTER TABLE `detailpenjualan` MODIFY `detailid` int NOT NULL AUTO_INCREMENT;

-- Menambahkan kembali constraint foreign key
ALTER TABLE `detailpenjualan` ADD CONSTRAINT `detailpenjualan_ibfk_1` FOREIGN KEY (`penjualanid`) REFERENCES `penjualan` (`penjualanid`); 