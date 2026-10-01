-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for pustaka_nusa
CREATE DATABASE IF NOT EXISTS `pustaka_nusa` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pustaka_nusa`;

-- Dumping structure for table pustaka_nusa.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pustaka_nusa.admin: ~0 rows (approximately)
INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
	(1, 'KeyBiztech', 'Key', '$2y$10$pDZ0kzTzLMXh3ziSB5iaMeJcpQeAsoo5WtRNlVvGO4DH5ICwX.kFO', '2026-09-30 15:08:13');

-- Dumping structure for table pustaka_nusa.buku
CREATE TABLE IF NOT EXISTS `buku` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(200) NOT NULL,
  `penulis` varchar(150) NOT NULL,
  `penerbit` varchar(150) NOT NULL,
  `tahun_terbit` year NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `harga` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stok` int NOT NULL DEFAULT '0',
  `deskripsi` text,
  `cover` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pustaka_nusa.buku: ~3 rows (approximately)
INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `kategori`, `harga`, `stok`, `deskripsi`, `cover`, `created_at`, `updated_at`) VALUES
	(1, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', '2005', 'Novel', 95000.00, 15, 'Novel tentang perjuangan, persahabatan, dan pendidikan.', 'Laskar_Pelangi.jpg', '2026-09-29 17:34:38', '2026-10-01 02:48:31'),
	(2, 'Bumi', 'Tere Liye', 'Gramedia Pustaka Utama', '2014', 'Fiksi', 89000.00, 12, 'Kisah petualangan dalam dunia fantasi.', 'Bumi.jpg', '2026-09-29 17:34:38', '2026-10-01 02:48:47'),
	(3, 'Filosofi Teras', 'Henry Manampiring', 'Penerbit Buku Kompas', '2018', 'Pengembangan Diri', 98000.00, 55, 'Pengantar filsafat Stoisisme untuk kehidupan sehari-hari.', 'Filosofi_Teras.jpg', '2026-09-29 17:34:38', '2026-10-01 06:10:12');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
