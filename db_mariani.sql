-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 12, 2017 at 07:34 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mariani`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `harga` int(15) NOT NULL,
  `jumlah_produk` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id_cart`, `id_produk`, `id_user`, `harga`, `jumlah_produk`) VALUES
(8, 1, 1, 500000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(20) NOT NULL,
  `desk_kategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `desk_kategori`) VALUES
(2, 'Celana', 'Ini Celana....'),
(3, 'Kemeja', 'Ini Kemeja....'),
(10, 'Dress', 'Dress merupakan.....'),
(11, 'Atasan', 'Atasan merupakan'),
(12, 'Rok', 'Rok merupakan....'),
(13, 'Batik & Kebaya', 'Batik & Kebaya merupakan...'),
(14, 'Pakaian Dalam', 'Pakaian Dalam merupakan....'),
(15, 'Outwear', 'Outwear merupakan....'),
(16, 'Jeans', 'Jeans merupakan....'),
(17, 'Lainnya Perempuan', 'Lain-lain Perempuan merupakan.');

-- --------------------------------------------------------

--
-- Table structure for table `kirim`
--

CREATE TABLE `kirim` (
  `id_kirim` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `alamat_kirim` varchar(100) NOT NULL,
  `tgl_kirim` datetime NOT NULL,
  `jenis_kurir` varchar(25) NOT NULL,
  `jenis_paket` varchar(25) NOT NULL,
  `berat_paket` int(10) NOT NULL,
  `no_resi` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kirim`
--

INSERT INTO `kirim` (`id_kirim`, `id_order`, `alamat_kirim`, `tgl_kirim`, `jenis_kurir`, `jenis_paket`, `berat_paket`, `no_resi`) VALUES
(17, 4, 'Jl. Monas no 7 Boalemo, Gorontalo, 20222', '2017-06-12 03:18:08', 'PT POS IND', 'Surat Kilat Khusus', 2000, '11112222333344445555');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id_order_detail` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah_produk` int(10) NOT NULL,
  `harga` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id_order_detail`, `id_order`, `id_produk`, `jumlah_produk`, `harga`) VALUES
(7, 3, 1, 4, 1000000),
(8, 3, 8, 6, 600000),
(9, 3, 2, 1, 300000),
(10, 4, 2, 4, 1200000),
(11, 5, 4, 1, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `pengurus`
--

CREATE TABLE `pengurus` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengurus`
--

INSERT INTO `pengurus` (`id`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Budi', 'budi123', '$2y$10$pe5815qUUdo5342k5PXkXeNpgjffxPGwSggjIQKGj1w75aF1lxULq', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `kode_SKU` varchar(20) NOT NULL,
  `nama_brg` varchar(25) NOT NULL,
  `merk` varchar(10) NOT NULL,
  `harga` int(15) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `berat` int(10) NOT NULL,
  `gender` enum('MEN','WOMEN') NOT NULL,
  `tgl_update` datetime NOT NULL,
  `stok` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `kode_SKU`, `nama_brg`, `merk`, `harga`, `deskripsi`, `gambar`, `berat`, `gender`, `tgl_update`, `stok`) VALUES
(2, 2, '46486454', 'Celana Jeans', 'Levis', 300000, 'Ini Celana Jeans....', '460673.jpg', 500, 'WOMEN', '2017-06-09 05:00:58', 66),
(4, 2, '37368734', 'Baju Kaos Oblong', 'Adidas', 100000, 'Ini Kaos Oblong', '391994.jpg', 500, 'WOMEN', '2017-06-09 05:01:07', 60),
(7, 3, '48647545', 'Kemeja Kotak kotak', 'Specs', 150000, 'Kemeja Jokowi', '771289.jpg', 500, 'MEN', '2017-06-09 05:01:24', 12),
(8, 11, '465654654', 'Kaos Metallica', 'Puma', 100000, 'Metal....', '752221.jpg', 500, 'WOMEN', '2017-06-09 05:01:39', 7),
(9, 11, '5589789789', 'Sweater Tebal', 'Nike', 400000, 'asdfasdfds', '379054.jpg', 500, 'MEN', '2017-06-09 05:01:56', 5),
(10, 10, '6778787', 'Celana Nike', 'Nike', 40000, 'Olahraga', '422517.jpg', 500, 'WOMEN', '2017-06-09 05:02:14', 56),
(11, 2, '6778787', 'Celana Nike', 'Mizuno', 40000, 'Olahraga', '951678.jpg', 500, 'MEN', '2017-06-09 05:02:32', 56),
(12, 2, '2347586', 'Celana Joger', 'Kelme', 450000, 'JOgerrrrr', '274381.jpg', 500, 'WOMEN', '2017-06-09 05:03:05', 7),
(13, 12, '464849784', 'Baju Pink', 'Joma', 450000, 'gggggg', '365169.jpg', 500, 'WOMEN', '2017-06-09 05:03:21', 7),
(14, 13, '7945645', 'Baju Cewek', 'Specs', 4366600, 'ceweee', '92641.jpg', 500, 'WOMEN', '2017-06-09 05:03:36', 89),
(15, 15, '7945645', 'Baju Cewekk', 'Umbro', 436660, 'ceweee', '169771.jpg', 500, 'MEN', '2017-06-09 05:03:54', 89),
(17, 17, '123456', 'Baju Koko', 'Adidas', 250000, 'Ini Baju Koko....', '265076.jpg', 500, 'MEN', '2017-06-09 05:04:12', 67);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pengurus` int(11) NOT NULL,
  `id_kirim` int(11) NOT NULL,
  `no_kontak` varchar(15) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `kabupaten` varchar(25) NOT NULL,
  `provinsi` varchar(25) NOT NULL,
  `kodepos` varchar(10) NOT NULL,
  `tgl_order` datetime NOT NULL,
  `desk_order` varchar(100) NOT NULL,
  `jenis_kurir` varchar(25) NOT NULL,
  `jenis_paket` varchar(20) NOT NULL,
  `ongkir` int(20) NOT NULL,
  `berat_order` int(20) NOT NULL,
  `status_order` varchar(15) NOT NULL,
  `nama_bank` varchar(12) DEFAULT NULL,
  `nama_rek` varchar(25) DEFAULT NULL,
  `no_rek` varchar(20) DEFAULT NULL,
  `nominal_transfer` int(15) DEFAULT NULL,
  `detail_transfer` varchar(100) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id_order`, `id_user`, `id_pengurus`, `id_kirim`, `no_kontak`, `alamat`, `kabupaten`, `provinsi`, `kodepos`, `tgl_order`, `desk_order`, `jenis_kurir`, `jenis_paket`, `ongkir`, `berat_order`, `status_order`, `nama_bank`, `nama_rek`, `no_rek`, `nominal_transfer`, `detail_transfer`, `note`) VALUES
(3, 2, 0, 0, '085748630093', 'Jl. Monas no 7', 'Jakarta Pu', 'DKI Jakart', '20222', '2017-06-11 14:33:14', 'BYEEEE', 'PT POS IND', 'Paketpos Biasa', 148975, 16500, 'Belum dibayar', NULL, NULL, NULL, NULL, NULL, ''),
(4, 2, 1, 17, '085748630093', 'Jl. Monas no 7', 'Boalemo', 'Gorontalo', '20222', '2017-06-11 15:35:14', 'Ini yg kedua', 'PT POS IND', 'Surat Kilat Khusus', 120000, 2000, 'Dikirim', 'BCA', 'Kuncoro Nani', '78586000', 1320000, '', 'asdfaergrs'),
(5, 2, 0, 0, '085748630093', 'Jl. Monas no 7', 'Jakarta Barat', 'DKI Jakarta', '20222', '2017-06-11 16:10:42', '', 'PT POS INDONESIA', 'Surat Kilat Khusus', 17500, 500, 'Belum dibayar', NULL, NULL, NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `kota` varchar(20) DEFAULT NULL,
  `provinsi` varchar(30) DEFAULT NULL,
  `kodepos` int(10) DEFAULT NULL,
  `tgl_registrasi` datetime NOT NULL,
  `no_kontak` varchar(15) DEFAULT NULL,
  `alamat_1` varchar(100) DEFAULT NULL,
  `alamat_2` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `first_name`, `last_name`, `kota`, `provinsi`, `kodepos`, `tgl_registrasi`, `no_kontak`, `alamat_1`, `alamat_2`) VALUES
(1, 'budi123', '$2y$10$pe5815qUUdo5342k5PXkXeNpgjffxPGwSggjIQKGj1w75aF1lxULq', 'Budi', 'Sialagan', NULL, NULL, NULL, '2017-06-05 17:37:18', NULL, NULL, NULL),
(2, 'andi123', '$2y$10$2CpahCceIWkVhrGXERPb5On1uJGNg86VSRGE4KWbOWvGL.5ZiiVs6', 'Andi', 'Lukman', 'Jakarta Pusat', 'DKI Jakarta', 20222, '2017-06-05 19:53:45', '085748630093', 'Jl. Monas no 7', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kirim`
--
ALTER TABLE `kirim`
  ADD PRIMARY KEY (`id_kirim`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id_order_detail`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `pengurus`
--
ALTER TABLE `pengurus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_pengurus` (`id_pengurus`),
  ADD KEY `id_kirim` (`id_kirim`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `kirim`
--
ALTER TABLE `kirim`
  MODIFY `id_kirim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id_order_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `pengurus`
--
ALTER TABLE `pengurus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
