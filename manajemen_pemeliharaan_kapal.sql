-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Agu 2025 pada 11.20
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
  `tanggal_cek_kondisi` datetime DEFAULT NULL,
  `tanda_tangan` text DEFAULT NULL,
  `nama_kru` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_perawatan`
--

INSERT INTO `detail_perawatan` (`id_detail_perawatan`, `id_perawatan`, `id_kondisi`, `catatan_kondisi`, `foto_kondisi`, `tanggal_cek_kondisi`, `tanda_tangan`, `nama_kru`) VALUES
(5, 2, 1, '', '', NULL, '', ''),
(6, 2, 2, '', '', NULL, '', ''),
(7, 2, 3, '', '', NULL, '', ''),
(8, 2, 4, '', '', NULL, '', ''),
(9, 3, 1, 'baik', '6864ccf5d1330_Screenshot (1).png', '2025-07-02 13:14:11', 'ttg_6864cd447afd7.png', 'tes123\n'),
(10, 3, 2, 'baik', '6864cf23a1c9d_Screenshot (6).png', '2025-07-02 13:18:26', 'ttg_6864cf2b5f9cb.png', 'joy'),
(11, 3, 3, 'baik', '', NULL, '', ''),
(12, 3, 4, 'baik', '', NULL, '', ''),
(13, 4, 8, 'baik', '', '2025-07-02 13:40:30', '', ''),
(14, 4, 9, '', '', NULL, '', ''),
(15, 4, 10, '', '', NULL, '', ''),
(16, 4, 11, '', '', NULL, '', ''),
(17, 4, 12, '', '', NULL, '', ''),
(18, 4, 13, '', '', NULL, '', '');

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
(1, 'Apakah bebas dari kerusakan?', 1),
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
-- Struktur dari tabel `kru`
--

CREATE TABLE `kru` (
  `id_kru` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `id_jenis_perawatan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kru`
--

INSERT INTO `kru` (`id_kru`, `nama`, `jabatan`, `id_jenis_perawatan`, `id_user`) VALUES
(1, 'Mualim 1', 'Chief Officer', 1, 1),
(2, 'mualim 2', 'Second Officer', 2, 1),
(3, 'Mualim 3', 'Third Officer', 3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `perawatan`
--

CREATE TABLE `perawatan` (
  `id_perawatan` int(11) NOT NULL,
  `id_kapal` int(11) NOT NULL,
  `id_kru` int(11) NOT NULL,
  `id_jenis_perawatan` int(11) NOT NULL,
  `tanggal_perawatan` datetime NOT NULL,
  `status` enum('Sudah','Belum Dibaca','Perlu Direvisi') DEFAULT NULL,
  `catatan_revisi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perawatan`
--

INSERT INTO `perawatan` (`id_perawatan`, `id_kapal`, `id_kru`, `id_jenis_perawatan`, `tanggal_perawatan`, `status`, `catatan_revisi`) VALUES
(2, 1, 1, 1, '2025-07-02 12:05:17', 'Sudah', ''),
(3, 1, 1, 1, '2025-07-02 13:08:23', 'Perlu Direvisi', 'kondisi 3 dan 4 masih kosong'),
(4, 1, 2, 2, '2025-07-02 13:40:20', 'Perlu Direvisi', 'belum kelar nih');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrator','Kru Lambung Kapal','Kru Alat Navigasi Kapal','Kru Alat Kebakaran dan Keselamatan Kapal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `username`, `password`, `role`) VALUES
(1, 'Admin', 'admin', '$2y$10$8Jp9oTzG8Da2ViApZt6lwOsgfVWohP7frPnQaehfG99qO1diwZOq.', 'Administrator'),
(4, 'Kru Lambung Kapal', 'krulk', '$2y$10$fyjVbQL3/wmmZ3ODNDptuORnmNWCv0ZWLRiF2FuAxTBH/ZQFZytC.', 'Kru Lambung Kapal'),
(6, 'Kru Alat Navigasi Kapal', 'kruan', '$2y$10$H0/T5V9WAqFdiV.DVvZGIe/a3dIqzYJMAMKE46DC/dqQ0e.oY1Xa2', 'Kru Alat Navigasi Kapal'),
(7, 'Kru Alat Kebakaran dan Keselamatan Kapal', 'kruak', '$2y$10$YpC2WDjmF.ju0xDQtK.F0.8iHtIjEEV4UWziWknFPuj1871WaHryK', 'Kru Alat Kebakaran dan Keselamatan Kapal');

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
-- Indeks untuk tabel `kru`
--
ALTER TABLE `kru`
  ADD PRIMARY KEY (`id_kru`),
  ADD KEY `id_jenis_perawatan` (`id_jenis_perawatan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `perawatan`
--
ALTER TABLE `perawatan`
  ADD PRIMARY KEY (`id_perawatan`),
  ADD KEY `id_teknisi` (`id_kru`),
  ADD KEY `id_jenis_perawatan` (`id_jenis_perawatan`),
  ADD KEY `id_kapal` (`id_kapal`);

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
  MODIFY `id_detail_perawatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `jenis_perawatan`
--
ALTER TABLE `jenis_perawatan`
  MODIFY `id_jenis_perawatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kapal`
--
ALTER TABLE `kapal`
  MODIFY `id_kapal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kondisi`
--
ALTER TABLE `kondisi`
  MODIFY `id_kondisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `kru`
--
ALTER TABLE `kru`
  MODIFY `id_kru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `perawatan`
--
ALTER TABLE `perawatan`
  MODIFY `id_perawatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_perawatan`
--
ALTER TABLE `detail_perawatan`
  ADD CONSTRAINT `detail_perawatan_ibfk_1` FOREIGN KEY (`id_kondisi`) REFERENCES `kondisi` (`id_kondisi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detail_perawatan_ibfk_2` FOREIGN KEY (`id_perawatan`) REFERENCES `perawatan` (`id_perawatan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `kondisi`
--
ALTER TABLE `kondisi`
  ADD CONSTRAINT `kondisi_ibfk_1` FOREIGN KEY (`id_jenis_perawatan`) REFERENCES `jenis_perawatan` (`id_jenis_perawatan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `kru`
--
ALTER TABLE `kru`
  ADD CONSTRAINT `kru_ibfk_1` FOREIGN KEY (`id_jenis_perawatan`) REFERENCES `jenis_perawatan` (`id_jenis_perawatan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `kru_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `perawatan`
--
ALTER TABLE `perawatan`
  ADD CONSTRAINT `perawatan_ibfk_1` FOREIGN KEY (`id_jenis_perawatan`) REFERENCES `jenis_perawatan` (`id_jenis_perawatan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `perawatan_ibfk_2` FOREIGN KEY (`id_kru`) REFERENCES `kru` (`id_kru`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `perawatan_ibfk_3` FOREIGN KEY (`id_kapal`) REFERENCES `kapal` (`id_kapal`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
