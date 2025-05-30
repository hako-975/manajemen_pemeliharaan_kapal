-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Bulan Mei 2025 pada 14.40
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manajemen_pemeliharaan_kapal`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_perawatan`
--

CREATE TABLE `detail_perawatan` (
  `id_detail_perawatan` int(11) NOT NULL,
  `id_perawatan` int(11) NOT NULL,
  `id_kondisi` int(11) NOT NULL,
  `catatan_kondisi` text DEFAULT NULL,
  `foto_kondisi` text DEFAULT NULL,
  `status_kondisi` enum('Sudah','Belum') DEFAULT 'Belum',
  `tanggal_cek_kondisi` datetime DEFAULT NULL,
  `tanda_tangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_perawatan`
--

INSERT INTO `detail_perawatan` (`id_detail_perawatan`, `id_perawatan`, `id_kondisi`, `catatan_kondisi`, `foto_kondisi`, `status_kondisi`, `tanggal_cek_kondisi`, `tanda_tangan`) VALUES
(1, 1, 1, '213123', NULL, 'Sudah', '2025-05-29 16:17:30', 'ttg_6838292cbd36b.png'),
(2, 1, 2, '123', NULL, 'Sudah', '2025-05-29 16:17:36', ''),
(3, 1, 3, 'tes', NULL, 'Sudah', '2025-05-29 16:17:40', ''),
(4, 1, 4, '', NULL, 'Sudah', '2025-05-29 16:17:42', ''),
(5, 2, 1, 'Belum', '', '', NULL, ''),
(6, 2, 2, 'Belum', '', '', NULL, ''),
(7, 2, 3, 'Belum', '', '', NULL, ''),
(8, 2, 4, 'Belum', '', '', NULL, ''),
(9, 3, 1, 'tes\n', '68382b735f7fa_IMG_7477.JPG', 'Sudah', '2025-05-29 16:40:07', NULL),
(10, 3, 2, '', '', 'Belum', NULL, ''),
(11, 3, 3, '', '', 'Belum', NULL, ''),
(12, 3, 4, '', '', 'Belum', NULL, ''),
(13, 4, 1, '', '', 'Belum', NULL, ''),
(14, 4, 2, '', '', 'Belum', NULL, ''),
(15, 4, 3, '', '', 'Belum', NULL, ''),
(16, 4, 4, '', '', 'Belum', NULL, ''),
(17, 6, 8, '', '', 'Belum', NULL, ''),
(18, 6, 9, '', '', 'Belum', NULL, ''),
(19, 6, 10, '', '', 'Belum', NULL, ''),
(20, 6, 11, '', '', 'Belum', NULL, ''),
(21, 6, 12, '', '', 'Belum', NULL, ''),
(22, 6, 13, '', '', 'Belum', NULL, ''),
(23, 7, 1, 'tes', '6838314df3c07_Andri Firman Saputra.png', 'Sudah', '2025-05-29 17:05:11', 'ttg_68383161e1688.png'),
(24, 7, 2, '', '', 'Sudah', '2025-05-29 17:05:13', 'ttg_68383165c236e.png'),
(25, 7, 3, '', '', 'Sudah', '2025-05-29 17:05:16', 'ttg_6838316a6dd9a.png'),
(26, 7, 4, '', '', 'Sudah', '2025-05-29 17:05:19', 'ttg_6838316f91234.png'),
(27, 8, 14, '', '', 'Sudah', '2025-05-29 17:11:14', 'ttg_683832d7b92d7.png'),
(28, 8, 15, '', '', 'Sudah', '2025-05-29 17:11:16', 'ttg_683832db48417.png'),
(29, 8, 16, '', '', 'Sudah', '2025-05-29 17:11:18', 'ttg_683832de5cfc3.png'),
(30, 8, 17, '', '', 'Sudah', '2025-05-29 17:11:20', 'ttg_683832e1be9f9.png'),
(31, 8, 18, '', '', 'Sudah', '2025-05-29 17:11:23', 'ttg_683832e595b6e.png'),
(32, 8, 19, '', '', 'Sudah', '2025-05-29 17:11:26', 'ttg_683832e8a9046.png'),
(33, 8, 20, '', '', 'Sudah', '2025-05-29 17:11:29', 'ttg_683832eb782b7.png'),
(34, 8, 21, '', '', 'Sudah', '2025-05-29 17:11:32', 'ttg_683832ee9f828.png'),
(35, 9, 1, '', '', 'Belum', NULL, ''),
(36, 9, 2, '', '', 'Belum', NULL, ''),
(37, 9, 3, '', '', 'Belum', NULL, ''),
(38, 9, 4, '', '', 'Belum', NULL, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_perawatan`
--

CREATE TABLE `jenis_perawatan` (
  `id_jenis_perawatan` int(11) NOT NULL,
  `jenis_perawatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_perawatan`
--

INSERT INTO `jenis_perawatan` (`id_jenis_perawatan`, `jenis_perawatan`) VALUES
(1, 'Lambung Kapal'),
(2, 'Alat Navigasi'),
(3, 'Alat Kebakaran & Alat Keselamatan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kapal`
--

CREATE TABLE `kapal` (
  `id_kapal` int(11) NOT NULL,
  `nama_kapal` varchar(255) NOT NULL,
  `foto_kapal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kapal`
--

INSERT INTO `kapal` (`id_kapal`, `nama_kapal`, `foto_kapal`) VALUES
(1, 'SPOB BSP XXV', '1.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kondisi`
--

CREATE TABLE `kondisi` (
  `id_kondisi` int(11) NOT NULL,
  `kondisi` text NOT NULL,
  `id_jenis_perawatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kondisi`
--

INSERT INTO `kondisi` (`id_kondisi`, `kondisi`, `id_jenis_perawatan`) VALUES
(1, 'Bebas dari kerusakan?', 1),
(2, 'Kondisi cat?', 1),
(3, 'Kondisi karat?', 1),
(4, 'Tanda Lambung Timbul dan Nama Kapal jelas?', 1),
(8, 'Radar (mendeteksi objek sekitar kapal)', 2),
(9, 'GPS (penentuan posisi)', 2),
(10, 'AIS (identifikasi kapal lain)', 2),
(11, 'Echo Sounder (ukur kedalaman laut)', 2),
(12, 'VHF (komunikasi radio)', 2),
(13, 'Lampu Navigasi (untuk kapal jalan malam hari)', 2),
(14, 'Life jacket (Pelampung)', 3),
(15, 'Life raft (Rakit)', 3),
(16, 'Sekoci (Untuk meninggalkan kapal kalau kapal kecelakaan)', 3),
(17, 'Apar (Alat Pemadam Api Ringan)', 3),
(18, 'Emergency fire hydrant', 3),
(19, 'Fix co2 sistem', 3),
(20, 'EEBD (Emergency Escape Breathing Device)', 3),
(21, 'Breathing aparatus', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `perawatan`
--

CREATE TABLE `perawatan` (
  `id_perawatan` int(11) NOT NULL,
  `id_kapal` int(11) NOT NULL,
  `id_teknisi` int(11) NOT NULL,
  `id_jenis_perawatan` int(11) NOT NULL,
  `tanggal_perawatan` datetime NOT NULL,
  `status` enum('Sudah','Belum') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perawatan`
--

INSERT INTO `perawatan` (`id_perawatan`, `id_kapal`, `id_teknisi`, `id_jenis_perawatan`, `tanggal_perawatan`, `status`) VALUES
(6, 1, 2, 2, '2025-05-29 17:04:43', 'Sudah'),
(7, 1, 1, 1, '2025-05-29 17:04:53', 'Sudah'),
(8, 1, 3, 3, '2025-05-29 17:04:57', 'Sudah'),
(9, 1, 1, 1, '2025-05-29 17:11:09', 'Sudah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `teknisi`
--

CREATE TABLE `teknisi` (
  `id_teknisi` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `id_jenis_perawatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `teknisi`
--

INSERT INTO `teknisi` (`id_teknisi`, `nama`, `jabatan`, `id_jenis_perawatan`) VALUES
(1, 'Mualim 1', 'Chief Officer', 1),
(2, 'mualim 2', 'Second Officer', 2),
(3, 'Mualim 3', 'Third Officer', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrator','Operator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `username`, `password`, `role`) VALUES
(1, 'Admin', 'admin', '$2y$10$8Jp9oTzG8Da2ViApZt6lwOsgfVWohP7frPnQaehfG99qO1diwZOq.', 'Administrator'),
(3, 'Operator', 'operator', '$2y$10$rzxGkRc79Fi2D95Bdy/cResM1N5XKS/UWrkxLKj.8Xpy9o7sAIuNC', 'Operator');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_perawatan`
--
ALTER TABLE `detail_perawatan`
  ADD PRIMARY KEY (`id_detail_perawatan`),
  ADD KEY `id_perawatan` (`id_perawatan`),
  ADD KEY `id_kondisi` (`id_kondisi`);

--
-- Indeks untuk tabel `jenis_perawatan`
--
ALTER TABLE `jenis_perawatan`
  ADD PRIMARY KEY (`id_jenis_perawatan`);

--
-- Indeks untuk tabel `kapal`
--
ALTER TABLE `kapal`
  ADD PRIMARY KEY (`id_kapal`);

--
-- Indeks untuk tabel `kondisi`
--
ALTER TABLE `kondisi`
  ADD PRIMARY KEY (`id_kondisi`),
  ADD KEY `id_jenis_perawatan` (`id_jenis_perawatan`);

--
-- Indeks untuk tabel `perawatan`
--
ALTER TABLE `perawatan`
  ADD PRIMARY KEY (`id_perawatan`),
  ADD KEY `id_teknisi` (`id_teknisi`),
  ADD KEY `id_jenis_perawatan` (`id_jenis_perawatan`),
  ADD KEY `id_kapal` (`id_kapal`);

--
-- Indeks untuk tabel `teknisi`
--
ALTER TABLE `teknisi`
  ADD PRIMARY KEY (`id_teknisi`),
  ADD KEY `id_jenis_perawatan` (`id_jenis_perawatan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_perawatan`
--
ALTER TABLE `detail_perawatan`
  MODIFY `id_detail_perawatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `jenis_perawatan`
--
ALTER TABLE `jenis_perawatan`
  MODIFY `id_jenis_perawatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kapal`
--
ALTER TABLE `kapal`
  MODIFY `id_kapal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kondisi`
--
ALTER TABLE `kondisi`
  MODIFY `id_kondisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `perawatan`
--
ALTER TABLE `perawatan`
  MODIFY `id_perawatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `teknisi`
--
ALTER TABLE `teknisi`
  MODIFY `id_teknisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kondisi`
--
ALTER TABLE `kondisi`
  ADD CONSTRAINT `kondisi_ibfk_1` FOREIGN KEY (`id_jenis_perawatan`) REFERENCES `jenis_perawatan` (`id_jenis_perawatan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `perawatan`
--
ALTER TABLE `perawatan`
  ADD CONSTRAINT `perawatan_ibfk_1` FOREIGN KEY (`id_jenis_perawatan`) REFERENCES `jenis_perawatan` (`id_jenis_perawatan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `teknisi`
--
ALTER TABLE `teknisi`
  ADD CONSTRAINT `teknisi_ibfk_1` FOREIGN KEY (`id_jenis_perawatan`) REFERENCES `jenis_perawatan` (`id_jenis_perawatan`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
