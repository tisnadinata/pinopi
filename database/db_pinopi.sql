-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 11 Feb 2017 pada 11.44
-- Versi Server: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pinopi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_bank`
--

CREATE TABLE `tbl_bank` (
  `id_bank` int(11) NOT NULL,
  `nama_bank` varchar(50) NOT NULL,
  `nomor_rekening` varchar(100) NOT NULL,
  `atas_nama` varchar(50) NOT NULL,
  `status_bank` varchar(20) NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_bank`
--

INSERT INTO `tbl_bank` (`id_bank`, `nama_bank`, `nomor_rekening`, `atas_nama`, `status_bank`, `last_edited`) VALUES
(1, 'BANK MANDIRI', '1234567890', 'PINOPI.COM', 'aktif', '2017-02-11 07:56:28'),
(2, 'BANK BRI', '0987654321', 'ADITYA', 'tidak aktif', '0000-00-00 00:00:00'),
(3, 'BANK BRI', '0987654321', 'PINOPI', 'aktif', '2017-02-11 07:56:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `id_banner` int(11) NOT NULL,
  `url_foto` varchar(100) NOT NULL,
  `url_banner` varchar(200) NOT NULL DEFAULT '#',
  `tipe_banner` varchar(25) NOT NULL,
  `status` varchar(25) NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_banner`
--

INSERT INTO `tbl_banner` (`id_banner`, `url_foto`, `url_banner`, `tipe_banner`, `status`, `last_edited`) VALUES
(1, 'img/banner1.jpg', '#', 'persegi', 'aktif', '2017-02-04 07:19:40'),
(2, 'img/banner2.jpg', '#', 'panjang', 'aktif', '2017-02-04 07:19:44'),
(3, 'img/banner2b.jpg', '#', 'panjang', 'aktif', '2017-02-04 07:19:47'),
(4, 'img/banner2.jpg', '#', 'panjang', 'tidak aktif', '2017-02-04 07:19:45'),
(5, 'img/banner1b.jpg', '#', 'persegi', 'aktif', '2017-02-04 07:19:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_diskon`
--

CREATE TABLE `tbl_diskon` (
  `id_diskon` int(11) NOT NULL,
  `tipe_diskon` varchar(20) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jenis_diskon` varchar(5) NOT NULL,
  `jumlah_diskon` int(11) NOT NULL,
  `status_diskon` varchar(15) NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_diskon`
--

INSERT INTO `tbl_diskon` (`id_diskon`, `tipe_diskon`, `id_produk`, `jenis_diskon`, `jumlah_diskon`, `status_diskon`, `last_edited`) VALUES
(1, 'semua', 0, '%', 10, 'aktif', '0000-00-00 00:00:00'),
(2, 'produk', 4, '%', 10, 'aktif', '2017-02-04 07:31:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(20) NOT NULL,
  `deskripsi_kategori` varchar(500) NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama_kategori`, `deskripsi_kategori`, `last_edited`) VALUES
(1, 'kalung', '', '2017-02-04 08:00:47'),
(2, 'cincin', '', '2017-02-04 08:00:51'),
(3, 'sarung', '', '2017-02-04 08:00:53'),
(4, 'rok', '', '2017-02-04 08:00:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_keranjang`
--

CREATE TABLE `tbl_keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `ip_customer` varchar(25) NOT NULL,
  `id_produk_paket` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kupon`
--

CREATE TABLE `tbl_kupon` (
  `id_kupon` int(11) NOT NULL,
  `kode_kupon` varchar(20) NOT NULL,
  `tipe_potongan` varchar(5) NOT NULL,
  `jumlah_potongan` int(11) NOT NULL,
  `maksimal_potongan` int(11) NOT NULL,
  `minimal_belanja` int(11) NOT NULL,
  `status_kupon` varchar(15) NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_kupon`
--

INSERT INTO `tbl_kupon` (`id_kupon`, `kode_kupon`, `tipe_potongan`, `jumlah_potongan`, `maksimal_potongan`, `minimal_belanja`, `status_kupon`, `last_edited`) VALUES
(1, 'OPENING', 'rp', 25000, 25000, 100000, 'aktif', '2017-02-08 01:07:30'),
(2, 'VALENTINE', '%', 14, 500000, 500000, 'aktif', '2017-02-08 01:07:43'),
(4, 'BETA', 'rp', 25000, 0, 100000, 'tidak aktif', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengaturan`
--

CREATE TABLE `tbl_pengaturan` (
  `id_pengaturan` int(11) NOT NULL,
  `nama_pengaturan` varchar(60) NOT NULL,
  `value_pengaturan` varchar(500) NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pengaturan`
--

INSERT INTO `tbl_pengaturan` (`id_pengaturan`, `nama_pengaturan`, `value_pengaturan`, `last_edited`) VALUES
(1, 'url_web', 'http://localhost/projek/pinopi', '0000-00-00 00:00:00'),
(2, 'nama_web', 'pinopi', '0000-00-00 00:00:00'),
(3, 'judul_web', 'PINOPI Toko Aksesoris', '0000-00-00 00:00:00'),
(4, 'alamat', 'Jalan Anggadireja Baleendah', '0000-00-00 00:00:00'),
(5, 'telepon', '089655440395', '0000-00-00 00:00:00'),
(6, 'email', 'cs@pinopi.com', '2017-02-04 06:51:31'),
(7, 'facebook', 'http://facebook.com', '0000-00-00 00:00:00'),
(8, 'instagram', 'http://instagram.com', '0000-00-00 00:00:00'),
(9, 'logo', 'img/logo-16.png', '2017-02-04 07:05:35'),
(10, 'deskripsi_toko', 'Ini adalah toko aksesoris perempuan dengan banyak pilihan dari mulai kalung, cincin, dan lainnya', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `berat_produk` int(11) NOT NULL,
  `deskripsi_produk` varchar(500) NOT NULL,
  `stok_produk` int(11) NOT NULL,
  `warna_produk` varchar(20) NOT NULL,
  `url_foto` varchar(100) NOT NULL,
  `status_produk` varchar(15) NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_produk`
--

INSERT INTO `tbl_produk` (`id_produk`, `id_kategori`, `nama_produk`, `harga_produk`, `berat_produk`, `deskripsi_produk`, `stok_produk`, `warna_produk`, `url_foto`, `status_produk`, `last_edited`) VALUES
(0, 1, '', 0, 0, '', 0, '', '', 'tidak aktif', '2017-02-04 05:50:49'),
(1, 1, 'Ikat Rambut Pelangi', 100000, 100, 'qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm ', 5, 'merah', 'img/produk.jpg', 'aktif', '2017-02-04 12:04:08'),
(2, 2, 'Kalung Khatulistiwa', 200000, 100, 'qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm ', 0, 'merah', 'img/produk.jpg', 'aktif', '2017-02-06 04:31:52'),
(3, 1, 'Cincin Saturnus', 300000, 100, 'qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm ', 7, 'merah', 'img/produk.jpg', 'aktif', '2017-02-05 14:20:40'),
(4, 2, 'Gelang Galaksi', 400000, 100, 'qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm ', 8, 'merah', 'img/produk.jpg', 'aktif', '2017-02-05 15:25:06'),
(5, 2, 'Gelang Sakti', 400000, 100, 'qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm ', 8, 'merah', 'img/produk.jpg', 'aktif', '2017-02-05 14:20:43'),
(6, 2, 'Gelang Sakti', 400000, 100, 'qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm ', 8, 'merah', 'img/produk.jpg', 'aktif', '2017-02-05 14:20:43'),
(15, 2, 'Gelang Sakti', 400000, 100, 'qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm ', 8, 'merah', 'img/produk.jpg', 'aktif', '2017-02-05 14:20:43'),
(16, 2, 'Gelang Sakti', 400000, 100, 'qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm qwertyuioplkjhgfdsazxcvbnm ', 8, 'merah', 'img/produk.jpg', 'aktif', '2017-02-05 14:20:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_produk_paket`
--

CREATE TABLE `tbl_produk_paket` (
  `id_produk_paket` int(11) NOT NULL,
  `nama_paket` varchar(50) NOT NULL,
  `potongan_harga` int(11) NOT NULL,
  `isi_paket` varchar(100) NOT NULL,
  `deskripsi_paket` varchar(500) NOT NULL,
  `url_foto` varchar(100) NOT NULL,
  `status_paket` varchar(15) NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_produk_paket`
--

INSERT INTO `tbl_produk_paket` (`id_produk_paket`, `nama_paket`, `potongan_harga`, `isi_paket`, `deskripsi_paket`, `url_foto`, `status_paket`, `last_edited`) VALUES
(1, 'Paket Hemat Untuk Anak', 10000, ',1,2,3,4,', 'Deskripsi paket 1', 'img/paket.jpg', 'aktif', '2017-02-04 12:03:48'),
(2, 'Paket Spesial Valentine', 25000, ',1,2,3,4,', 'Deskripsi paket 2', 'img/paket.jpg', 'aktif', '2017-02-04 12:29:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `invoice_transaksi` varchar(50) NOT NULL,
  `atas_nama` varchar(50) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `kode_unik` int(11) NOT NULL,
  `diskon_transaksi` int(11) NOT NULL,
  `total_transaksi` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_transaksi`
--

INSERT INTO `tbl_transaksi` (`id_transaksi`, `invoice_transaksi`, `atas_nama`, `tanggal_transaksi`, `kode_unik`, `diskon_transaksi`, `total_transaksi`, `email`) VALUES
(5, 'PNP-17-II-101', 'muhammad aditya tisnadinata', '2017-02-11 14:29:49', 105, 0, 7525000, 'tisnadinata@gmail.com'),
(6, 'PNP-17-II-102', 'muhammad aditya tisnadinata', '2017-02-11 14:37:07', 102, 500000, 7525000, 'tisnadinata@gmail.com'),
(7, 'PNP-17-II-103', 'muhammad aditya tisnadinata', '2017-02-11 14:39:44', 103, 0, 7525000, 'tisnadinata@gmail.com'),
(8, 'PNP-17-II-104', 'muhammad aditya tisnadinata', '2017-02-11 14:46:20', 104, 0, 7525000, 'tisnadinata@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksi_detail`
--

CREATE TABLE `tbl_transaksi_detail` (
  `id_transaksi_detail` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `nama_paket` varchar(50) NOT NULL,
  `isi_paket` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_paket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_transaksi_detail`
--

INSERT INTO `tbl_transaksi_detail` (`id_transaksi_detail`, `id_transaksi`, `nama_paket`, `isi_paket`, `qty`, `harga_paket`) VALUES
(1, 7, 'Paket Hemat Untuk Anak', ',1,2,3,4,', 3, 2850000),
(2, 7, 'Paket Spesial Valentine', ',1,2,3,4,', 5, 4675000),
(3, 8, 'Paket Hemat Untuk Anak', ',1,2,3,4,', 3, 2850000),
(4, 8, 'Paket Spesial Valentine', ',1,2,3,4,', 5, 4675000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksi_pembayaran`
--

CREATE TABLE `tbl_transaksi_pembayaran` (
  `id_transaksi_pembayaran` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `metode_pembayaran` varchar(25) NOT NULL,
  `tujuan_pembayaran` varchar(25) DEFAULT NULL,
  `atas_nama` varchar(50) DEFAULT NULL,
  `nomor_rekening` varchar(50) DEFAULT NULL,
  `nama_bank` varchar(50) DEFAULT NULL,
  `jumlah_dibayar` int(11) DEFAULT NULL,
  `bukti_pembayaran` varchar(200) DEFAULT NULL,
  `waktu_transfer` date DEFAULT NULL,
  `status_pembayaran` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_transaksi_pembayaran`
--

INSERT INTO `tbl_transaksi_pembayaran` (`id_transaksi_pembayaran`, `id_transaksi`, `metode_pembayaran`, `tujuan_pembayaran`, `atas_nama`, `nomor_rekening`, `nama_bank`, `jumlah_dibayar`, `bukti_pembayaran`, `waktu_transfer`, `status_pembayaran`) VALUES
(5, 5, 'bank transfer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menunggu pembayaran'),
(6, 6, 'bank transfer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menunggu pembayaran'),
(7, 7, 'bank transfer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menunggu pembayaran'),
(8, 8, 'bank transfer', '1', 'ADITYA', '112233445566', 'BANK SAYA', 7169, 'bukti_pembayaran/pnp-17-ii-104.jpg', '2017-02-11', 'sudah dibayar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksi_pengiriman`
--

CREATE TABLE `tbl_transaksi_pengiriman` (
  `id_transaksi_pengiriman` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `metode_pengiriman` varchar(25) NOT NULL,
  `biaya_pengiriman` int(11) NOT NULL,
  `nama_penerima` varchar(50) NOT NULL,
  `alamat_pengiriman` varchar(500) NOT NULL,
  `provinsi_pengiriman` varchar(59) NOT NULL,
  `kota_pengiriman` varchar(59) NOT NULL,
  `kode_pos` varchar(8) NOT NULL,
  `telepon_pengiriman` varchar(15) NOT NULL,
  `catatan_pengiriman` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_transaksi_pengiriman`
--

INSERT INTO `tbl_transaksi_pengiriman` (`id_transaksi_pengiriman`, `id_transaksi`, `metode_pengiriman`, `biaya_pengiriman`, `nama_penerima`, `alamat_pengiriman`, `provinsi_pengiriman`, `kota_pengiriman`, `kode_pos`, `telepon_pengiriman`, `catatan_pengiriman`) VALUES
(5, 5, 'OKE', 40000, 'muhammad aditya tisnadinata', 'Jalan Anggadireja 49', 'Jawa Barat', 'Kabupaten Bandung', '40375', '089655440395', 'Packing yang bagus'),
(6, 6, 'YES', 88000, 'muhammad aditya tisnadinata', 'Jalan Anggadireja No. 49', 'Jawa Barat', 'Kabupaten Bandung', '40375', '089655440395', 'Packing yang bagus ya'),
(7, 7, 'REG', 44000, 'muhammad aditya tisnadinata', 'Jalan ANggadireja 49', 'Jawa Barat', 'Kabupaten Bandung', '40375', '089655440395', 'Packing lagi ya'),
(8, 8, 'OKE', 40000, 'muhammad aditya tisnadinata', 'Jalan Anggadireja 49', 'Jawa Barat', 'Kabupaten Bandung', '40375', '089655440395', 'Catatan pengiriman nya ini saja');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksi_status`
--

CREATE TABLE `tbl_transaksi_status` (
  `id_transaksi_status` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `status_transaksi` varchar(15) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_transaksi_status`
--

INSERT INTO `tbl_transaksi_status` (`id_transaksi_status`, `id_transaksi`, `tanggal`, `status_transaksi`, `keterangan`) VALUES
(5, 5, '2017-02-11 14:29:49', 'PENDING', 'Pesanan kami terima, menunggu konfirmasi pembayaran'),
(6, 6, '2017-02-11 14:37:07', 'PENDING', 'Pesanan kami terima, menunggu konfirmasi pembayaran'),
(7, 7, '2017-02-11 14:39:44', 'PENDING', 'Pesanan kami terima, menunggu konfirmasi pembayaran'),
(8, 8, '2017-02-11 14:46:20', 'PENDING', 'Pesanan kami terima, menunggu konfirmasi pembayaran'),
(12, 8, '2017-02-11 16:53:19', 'CONFIRMED', 'Customer melakukan konfirmasi pembayaran');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indexes for table `tbl_diskon`
--
ALTER TABLE `tbl_diskon`
  ADD PRIMARY KEY (`id_diskon`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_produk` (`id_produk_paket`);

--
-- Indexes for table `tbl_kupon`
--
ALTER TABLE `tbl_kupon`
  ADD PRIMARY KEY (`id_kupon`),
  ADD UNIQUE KEY `kode_kupon` (`kode_kupon`);

--
-- Indexes for table `tbl_pengaturan`
--
ALTER TABLE `tbl_pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `tbl_produk_paket`
--
ALTER TABLE `tbl_produk_paket`
  ADD PRIMARY KEY (`id_produk_paket`);

--
-- Indexes for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `kode_transaksi` (`invoice_transaksi`);

--
-- Indexes for table `tbl_transaksi_detail`
--
ALTER TABLE `tbl_transaksi_detail`
  ADD PRIMARY KEY (`id_transaksi_detail`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `tbl_transaksi_pembayaran`
--
ALTER TABLE `tbl_transaksi_pembayaran`
  ADD PRIMARY KEY (`id_transaksi_pembayaran`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `tbl_transaksi_pengiriman`
--
ALTER TABLE `tbl_transaksi_pengiriman`
  ADD PRIMARY KEY (`id_transaksi_pengiriman`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `tbl_transaksi_status`
--
ALTER TABLE `tbl_transaksi_status`
  ADD PRIMARY KEY (`id_transaksi_status`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id_banner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_diskon`
--
ALTER TABLE `tbl_diskon`
  MODIFY `id_diskon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_kupon`
--
ALTER TABLE `tbl_kupon`
  MODIFY `id_kupon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_pengaturan`
--
ALTER TABLE `tbl_pengaturan`
  MODIFY `id_pengaturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_produk_paket`
--
ALTER TABLE `tbl_produk_paket`
  MODIFY `id_produk_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_transaksi_detail`
--
ALTER TABLE `tbl_transaksi_detail`
  MODIFY `id_transaksi_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_transaksi_pembayaran`
--
ALTER TABLE `tbl_transaksi_pembayaran`
  MODIFY `id_transaksi_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_transaksi_pengiriman`
--
ALTER TABLE `tbl_transaksi_pengiriman`
  MODIFY `id_transaksi_pengiriman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_transaksi_status`
--
ALTER TABLE `tbl_transaksi_status`
  MODIFY `id_transaksi_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_diskon`
--
ALTER TABLE `tbl_diskon`
  ADD CONSTRAINT `fk_diskon_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_produk` (`id_produk`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
  ADD CONSTRAINT `fk_keranjang` FOREIGN KEY (`id_produk_paket`) REFERENCES `tbl_produk_paket` (`id_produk_paket`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tbl_transaksi_detail`
--
ALTER TABLE `tbl_transaksi_detail`
  ADD CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tbl_transaksi_pembayaran`
--
ALTER TABLE `tbl_transaksi_pembayaran`
  ADD CONSTRAINT `fk_pembayaran_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tbl_transaksi_pengiriman`
--
ALTER TABLE `tbl_transaksi_pengiriman`
  ADD CONSTRAINT `fk_pengiriman_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tbl_transaksi_status`
--
ALTER TABLE `tbl_transaksi_status`
  ADD CONSTRAINT `fk_transaksi_status` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
