-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 04:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `id_supplier` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode`, `nama`, `harga`, `stok`, `id_supplier`) VALUES
(1, 'BRS001', 'Beras 1 kg', 12000, 200, 1),
(2, 'BRS005', 'Beras 5 kg', 58000, 50, 1),
(3, 'KCP200', 'Kecap Manis 200ml', 7000, 80, 2),
(4, 'MIN1L', 'Minyak Goreng 1 L', 15000, 70, 2),
(5, 'GPL001', 'Gula Pasir 1 kg', 14000, 100, 3),
(6, 'GRM250', 'Garam 250 g', 3000, 150, 4),
(7, 'KOPISCH', 'Kopi Kapal Api Sachet', 2000, 200, 5),
(9, 'BRKHBKR2', 'Berkah Bakery Rasa Coklat', 6000, 90, 11),
(10, 'BRKHBKRK', 'Berkah Bakery Keju', 7000, 98, 11);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `tel` varchar(12) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `gender`, `tel`, `alamat`) VALUES
(1, 'Andi', 'L', '081211111111', 'Jl. Kenangan No.100'),
(2, 'Budi', 'L', '081222222222', 'Jl. Bahagia No.11'),
(3, 'Cici', 'P', '081233333333', 'Jl. Maju Jaya No.12'),
(4, 'Dewi', 'P', '081244444444', 'Jl. Teratai No.13'),
(5, 'Eko', 'L', '081255555555', 'Jl. Kemakmuran No.14'),
(6, 'Fajar', 'L', '081266666666', 'Jl. Bersama No.15'),
(7, 'Gita', 'P', '081277777777', 'Jl. Merdeka No.16'),
(8, 'Hani', 'P', '008', 'Jl Haji Supratman 1');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `waktuBayar` datetime NOT NULL,
  `total` int(11) NOT NULL,
  `metode` enum('tunai','transfer','edc') NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktuBayar`, `total`, `metode`, `id_transaksi`) VALUES
(1, '2024-01-01 10:00:00', 120000, 'tunai', 1),
(2, '2024-01-05 11:30:00', 30000, 'transfer', 2),
(3, '2024-01-10 13:00:00', 50000, 'edc', 3),
(4, '2024-01-15 15:20:00', 40000, 'tunai', 4),
(5, '2024-01-20 17:10:00', 75000, 'transfer', 5),
(6, '2024-01-25 09:15:00', 25000, 'edc', 6),
(7, '2024-01-30 14:45:00', 55000, 'tunai', 7);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tel` varchar(12) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `tel`, `alamat`) VALUES
(1, 'PT Berkah Sembako', '081289111111', 'Jl. Sembako No.123'),
(2, 'PT Minyak Sejahtera', '081289222222', 'Jl. Minyak No.2'),
(3, 'PT Gula Manis', '081289333333', 'Jl. Gula No.3'),
(4, 'PT Garam Nusantara', '081289444444', 'Jl. Garam No.4'),
(5, 'PT Kopi Mantap', '081289555555', 'Jl. Kopi No.5'),
(6, 'PT Teh Nusantara', '081289666666', 'Jl. Teh No.6'),
(7, 'PT Mie Instant', '081289777777', 'Jl. Mie No.7'),
(11, 'Hanif Brian', '001', 'Jl Niaga 2'),
(12, 'Hanif Brian I', '001', 'Jl Niaga 2'),
(14, '[value-2]', '[value-3]', '[value-4]');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `waktuTransaksi` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `total` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktuTransaksi`, `keterangan`, `total`, `id_pelanggan`) VALUES
(1, '2024-01-01', 'Pembelian bahan pokok', 70000, 1),
(2, '2024-01-05', 'Pembelian minuman', 14000, 2),
(3, '2024-01-10', 'Pembelian kebutuhan rumah tangga', 45000, 3),
(4, '2024-10-15', 'Pembelian makanan ringan', 28000, 4),
(5, '2024-10-20', 'Pembelian bahan pokok', 15000, 5),
(6, '2024-10-25', 'Pembelian minuman', 20000, 6),
(7, '2024-11-30', 'Pembelian kebutuhan rumah tangga', 55000, 7),
(25, '2024-11-14', '', 28000, 2),
(32, '2024-11-16', '-', 58000, 2),
(33, '2024-11-16', '-', 12000, 1),
(34, '2024-11-16', '-', 68000, 3),
(36, '2024-11-20', '-', 89000, 1),
(37, '2024-11-20', '-', 18000, 1),
(39, '2024-11-21', '-', 12000, 1),
(40, '2024-11-21', '-', 7000, 7),
(47, '2024-11-22', 'Test 2', 22000, 2),
(48, '2024-11-22', '', 73000, 2),
(49, '2024-11-23', 'oke', 26000, 1),
(50, '0000-00-00', NULL, 0, 1),
(51, '2024-11-23', '', 108000, 1),
(52, '0000-00-00', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id_transaksi` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga_total` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id_transaksi`, `id_barang`, `harga_total`, `qty`) VALUES
(1, 1, 12000, 1),
(1, 2, 58000, 1),
(2, 3, 14000, 2),
(3, 4, 45000, 3),
(4, 5, 28000, 2),
(5, 6, 15000, 5),
(6, 7, 20000, 10),
(25, 1, 12000, 1),
(25, 3, 14000, 2),
(25, 7, 2000, 1),
(32, 2, 58000, 1),
(33, 1, 12000, 1),
(34, 1, 24000, 2),
(34, 3, 14000, 2),
(34, 4, 30000, 2),
(36, 1, 24000, 2),
(36, 2, 58000, 1),
(36, 3, 7000, 1),
(37, 5, 14000, 1),
(37, 7, 4000, 2),
(39, 1, 12000, 1),
(40, 10, 7000, 1),
(47, 3, 7000, 1),
(47, 4, 15000, 1),
(48, 2, 58000, 1),
(48, 4, 15000, 1),
(49, 1, 12000, 1),
(49, 3, 14000, 2),
(51, 1, 108000, 9);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `pwd`, `nama`, `alamat`, `tel`, `level`) VALUES
(1, 'user1', '0cc175b9c0f1b6a831c399e269772661', 'Ahmad', 'Jl. A Yani No.1', '001', 1),
(2, 'user2', '45cb41b32dcfb917ccd8614f1536d6da', 'Budi', 'Jl. Maju Jaya No.2', '081234567891', 2),
(3, 'user3', '45cb41b32dcfb917ccd8614f1536d6da', 'Cici', 'Jl. Bersama No.3', '081234567892', 1),
(4, 'user4', '45cb41b32dcfb917ccd8614f1536d6da', 'Dewi', 'Jl. Teratai No.4', '081234567893', 2),
(5, 'user5', '45cb41b32dcfb917ccd8614f1536d6da', 'Eko', 'Jl. Merdeka No.5', '081234567894', 1),
(6, 'user6', '45cb41b32dcfb917ccd8614f1536d6da', 'Fajar', 'Jl. Bahagia No.6', '081234567895', 2),
(7, 'user7', '45cb41b32dcfb917ccd8614f1536d6da', 'Gita', 'Jl. Kemakmuran No.7', '081234567896', 1),
(10, 'user8', '45cb41b32dcfb917ccd8614f1536d6da', 'Hari', 'Jl A Yani 1', '008', 2),
(11, 'a', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', 'a', 'a', '5', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id_transaksi`,`id_barang`),
  ADD KEY `fk_barang` (`id_barang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `fk_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
