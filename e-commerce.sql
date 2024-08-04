-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 01, 2024 at 02:22 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat_konsumen`
--

CREATE TABLE `alamat_konsumen` (
  `id_alamat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `alamat` text DEFAULT NULL,
  `distrik` int(11) DEFAULT NULL,
  `provinsi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alamat_konsumen`
--

INSERT INTO `alamat_konsumen` (`id_alamat`, `id_user`, `alamat`, `distrik`, `provinsi`) VALUES
(1, 8, 'Jakarta', NULL, NULL),
(2, 12, 'Kebakkramat', 169, 10),
(3, 11, 'Karanganyar', 108, 9),
(4, 13, '', 169, 10);

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id_carousel` int(11) NOT NULL,
  `nama_gambar` varchar(100) NOT NULL,
  `nama_carousel` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id_carousel`, `nama_gambar`, `nama_carousel`, `deskripsi`) VALUES
(4, '1683856759_194793290b59b916fe7f.png', 'Mack Book', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Et illum in iste rerum perferendis suscipit ipsa commodi, dolores laborum iusto sequi, incidunt voluptas eos est molestiae temporibus minima corporis voluptatibus!'),
(5, '1683856818_643b5e207cab8fa75d26.png', 'Alexa', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Et illum in iste rerum perferendis suscipit ipsa commodi, dolores laborum iusto sequi, incidunt voluptas eos est molestiae temporibus minima corporis voluptatibus!'),
(6, '1683856829_8d5c2325057ca59aa51e.png', 'JBU', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Et illum in iste rerum perferendis suscipit ipsa commodi, dolores laborum iusto sequi, incidunt voluptas eos est molestiae temporibus minima corporis voluptatibus!'),
(7, '1683892769_417df6c3472da337829b.jpg', 'Ayam cemani', 'Ayam yang dapat hidup tanpa tangan'),
(8, '1688712233_7c0fbd19d019f174e222.jpeg', 'cek', 'cek');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_det_trans` int(11) NOT NULL,
  `id_transaksi` varchar(50) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_det_trans`, `id_transaksi`, `id_produk`, `harga`, `jumlah`, `subtotal`) VALUES
(4, '1653145808', 13, 42000, 1, 42000),
(5, '66759588', 13, 42000, 1, 42000);

-- --------------------------------------------------------

--
-- Table structure for table `gambar_produk`
--

CREATE TABLE `gambar_produk` (
  `id_gambar` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gambar_produk`
--

INSERT INTO `gambar_produk` (`id_gambar`, `id_produk`, `gambar`, `status`) VALUES
(10, 5, '1684411930_d7a997701dbe1011ba68.jpg', 1),
(11, 6, '1684412159_2e86077f5168f9c560c6.jpg', 1),
(12, 7, '1684412238_63bceeb6d9ef6b01eaf5.jpg', 1),
(13, 8, '1684412300_ce5bc7b90abaa62e7ff2.jpg', 1),
(14, 9, '1684412350_2956c623574e2a0ea5c2.jpg', 1),
(15, 10, '1684412502_6f34c63009c706d9d802.jpg', 1),
(16, 11, '1684412557_fc855f39ca6f435cbb09.jpg', 1),
(17, 12, '1684412617_34ea68d4364173c1d817.jpg', 1),
(21, 17, '1717244075_a1f30501354f5cb03b37.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`) VALUES
(2, 'Rautan'),
(3, 'Pensil');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `deskripsi_produk` text NOT NULL,
  `stok` int(11) NOT NULL,
  `berat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_satuan`, `id_kategori`, `nama_produk`, `harga_produk`, `deskripsi_produk`, `stok`, `berat`) VALUES
(5, NULL, NULL, 'CATRIDGE PRINTER 12A', 121000, '<p><br></p>', 10000, 4000),
(6, NULL, NULL, 'CATRIDGE PRINTER 17A', 423000, '', 9999, 4000),
(7, NULL, NULL, 'CATRIDGE PRINTER 79A', 320500, '', 10000, 4000),
(8, 1, NULL, 'CD RW', 39000, '', 10000, 250),
(9, NULL, NULL, 'FLASHDISK 8 GB', 29500, '', 10000, 100),
(10, NULL, NULL, 'FLASHDISK 16 GB', 50500, '', 10000, 100),
(11, NULL, NULL, 'FLASHDISK 16 GB USB 3.0', 45500, '', 10000, 100),
(12, NULL, NULL, 'FLASHDISK HP 16 GB', 49000, '', 9998, 100),
(13, 1, NULL, 'FLASHDISK 32 GB', 42000, '', 9944, 100),
(16, 1, 2, 'cek', 123, '<p>fdsfa</p>', 4337, 300),
(17, 4, 2, 'cek1234', 20000, '', 10, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `satuan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `satuan`) VALUES
(1, 'PCS'),
(4, 'cekfdsf');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id_setting` int(11) NOT NULL,
  `nama_web` varchar(100) NOT NULL,
  `logo_web` varchar(100) NOT NULL,
  `gambar_toko` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `provinsi` int(11) NOT NULL,
  `distrik` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `kontak` varchar(200) NOT NULL,
  `tentang_kami` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id_setting`, `nama_web`, `logo_web`, `gambar_toko`, `alamat`, `provinsi`, `distrik`, `deskripsi`, `kontak`, `tentang_kami`) VALUES
(1, ' TRI MULIA STATIONARY', '1683855510_c1cd9566132d882e5d5e.jpg', '1688712087_22ef589d89dd663049dc.jpeg', 'Toko Tri Mulia Stationary, Ruko, Jl. Dramaga Pratama Raya I Jl. Raya Cibadak No.12, Cibadak, Kec. Ciampea, Bogor Barat, Jawa Barat 16620', 9, 78, '<p>Tri Mulia Stationary merupakan toko yang bergerak dibidang fotocopy\r\ndan penjualan alat tulis. Usaha didirikan pada tahun 2002 ini berkembang semakin\r\npesat dari tahun ketahun. Hal ini dibuktikan dengan semakin banyaknya\r\npembelian dan pesanan Alat Tulis Kantor seperti kertas, buku, maupun alat tulis\r\nlainnya</p>', '<p><br></p>', 'Tri Mulia Stationary merupakan toko yang bergerak dibidang fotocopy\r\ndan penjualan alat tulis. Usaha didirikan pada tahun 2002 ini berkembang semakin\r\npesat dari tahun ketahun. Hal ini dibuktikan dengan semakin banyaknya\r\npembelian dan pesanan Alat Tulis Kantor seperti kertas, buku, maupun alat tulis\r\nlainnya');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(50) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `status_pembayaran` varchar(20) NOT NULL,
  `status_transaksi` enum('gagal','pending','dikemas','dikirim','selesai') NOT NULL,
  `telp` varchar(20) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `noresi` varchar(50) DEFAULT NULL,
  `distrik` varchar(50) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kodepos` varchar(10) NOT NULL,
  `ekspedisi` varchar(50) NOT NULL,
  `paket` varchar(50) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `total_berat` int(11) NOT NULL,
  `estimasi` varchar(20) NOT NULL,
  `tipe_pembayaran` varchar(100) NOT NULL,
  `link_pdf` varchar(150) NOT NULL,
  `snapToken` varchar(50) NOT NULL,
  `total_bayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `tanggal`, `status_pembayaran`, `status_transaksi`, `telp`, `alamat`, `noresi`, `distrik`, `provinsi`, `kodepos`, `ekspedisi`, `paket`, `ongkir`, `total_berat`, `estimasi`, `tipe_pembayaran`, `link_pdf`, `snapToken`, `total_bayar`) VALUES
('1653145808', 13, '2024-05-26 23:22:35', 'settlement', 'pending', '62123456789', 'karanganyar', NULL, 'Karanganyar', 'Jawa Tengah', '57718', 'jne', 'OKE', 19000, 100, '3-6', 'bank_transfer', 'https://app.sandbox.midtrans.com/snap/v1/transactions/25182428-4706-40f3-a9f5-95db597cf8a0/pdf', '25182428-4706-40f3-a9f5-95db597cf8a0', 61000),
('66759588', 13, '2024-05-28 22:16:44', 'settlement', 'pending', '62123456789', 'cek', NULL, 'Karanganyar', 'Jawa Tengah', '57718', 'jne', 'OKE', 19000, 100, '3-6', 'bank_transfer', 'https://app.sandbox.midtrans.com/snap/v1/transactions/3d122464-189e-480f-9682-05f8f5335b45/pdf', '3d122464-189e-480f-9682-05f8f5335b45', 61000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `telp` char(13) NOT NULL,
  `foto_profil` varchar(100) NOT NULL,
  `token_lupa_password` varchar(100) DEFAULT NULL,
  `role` enum('admin','konsumen') NOT NULL,
  `aktifasi_akun` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `nama_lengkap`, `telp`, `foto_profil`, `token_lupa_password`, `role`, `aktifasi_akun`) VALUES
(7, 'andiazizp123@gmail.com', '$2y$10$.oFTKG3uVZCmlntsl7RhK.yZW4LGysM9Hz6is3ygyGhmtIY2XOFCa', 'FANDI AZIZ', '6262628953925', '1683612551_6e32fcf9b9c17fd4c54d.png', NULL, 'admin', 1),
(8, 'fankdiazizp@gmail.com', '$2y$10$Ym3SOJ4J.ZKBggtoA8kEE.DIRcqnnhgwmjc9IfJ7HpJJ2mGFXb2EK', 'Robert Joni', '6262628953925', '1684308912_4e37d2e6382b6d5be891.png', NULL, 'admin', 1),
(11, 'andiazizp1234@gmail.com', '$2y$10$Ym3SOJ4J.ZKBggtoA8kEE.DIRcqnnhgwmjc9IfJ7HpJJ2mGFXb2EK', 'fandi', '6289539251850', 'default.jpg', NULL, 'konsumen', 1),
(12, 'fandi.web2ti20a4@gmail.com', '$2y$10$ijqiPDLa7xBBoUy.RGlCq.pqIr02Q4tpqvwswpQ3WIaeEXPKgZI5C', 'Robert', '6289539251850', '1684240476_30678675073f6b4086d4.png', NULL, 'konsumen', 1),
(13, 'cek@gmail.com', '$2y$10$Ym3SOJ4J.ZKBggtoA8kEE.DIRcqnnhgwmjc9IfJ7HpJJ2mGFXb2EK', 'cek', '62123456789', 'default.jpg', NULL, 'konsumen', 1),
(14, 'cekbanget@gmail.com', '$2y$10$CKRwnb5TOBRPkWIBK3YDP.XSPM9o.L0HkRf4RGAD8BomrtUugBlO2', 'fandi', '6289539251850', 'default.jpg', NULL, 'admin', 1),
(15, 'andiazizp12345@gmail.com', '$2y$10$5UXJCVlDarFOqDWnRuWVqO2AF1b/IdU6l2KnayQgpT9fj9CuN60oy', 'fsd', '6208953925185', 'default.jpg', NULL, 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat_konsumen`
--
ALTER TABLE `alamat_konsumen`
  ADD PRIMARY KEY (`id_alamat`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id_carousel`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_det_trans`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `gambar_produk`
--
ALTER TABLE `gambar_produk`
  ADD PRIMARY KEY (`id_gambar`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_satuan` (`id_satuan`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamat_konsumen`
--
ALTER TABLE `alamat_konsumen`
  MODIFY `id_alamat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id_carousel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_det_trans` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gambar_produk`
--
ALTER TABLE `gambar_produk`
  MODIFY `id_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamat_konsumen`
--
ALTER TABLE `alamat_konsumen`
  ADD CONSTRAINT `alamat_konsumen_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`),
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`),
  ADD CONSTRAINT `detail_transaksi_ibfk_3` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `detail_transaksi_ibfk_4` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`);

--
-- Constraints for table `gambar_produk`
--
ALTER TABLE `gambar_produk`
  ADD CONSTRAINT `gambar_produk_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id_satuan`),
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
