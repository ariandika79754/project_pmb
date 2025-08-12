-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Agu 2025 pada 10.11
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cmhsbaru`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `kode_jurusan` varchar(20) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `kode_jurusan`, `nama_jurusan`) VALUES
(1, '71', 'Budidaya Tanaman Pangan'),
(2, '72', 'Budidaya Tanaman Perkebunan'),
(3, '73', 'Teknologi Pertanian'),
(4, '74', 'Peternakan'),
(5, '75', 'Ekonomi dan Bisnis'),
(6, '76', 'Teknik'),
(7, '77', 'Perikanan dan Kelautan'),
(8, '78', 'Teknologi Informasi'),
(9, '70', 'S2 Terapan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `kode_peserta` varchar(50) DEFAULT NULL,
  `nomor_kip_k` varchar(100) DEFAULT NULL,
  `nama_prodi_terima` varchar(255) DEFAULT NULL,
  `jenjang_prodi_terima` varchar(10) DEFAULT NULL,
  `pilihan_terima` varchar(10) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `nama_ayah` varchar(255) DEFAULT NULL,
  `nama_ibu` varchar(255) DEFAULT NULL,
  `npsn` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` varchar(200) NOT NULL,
  `nama_sekolah` varchar(100) NOT NULL,
  `tipe_sekolah` varchar(50) NOT NULL,
  `jurusan_asal` varchar(100) NOT NULL,
  `tahun_lulus` year(4) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `agama` varchar(200) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `users_id` int(11) DEFAULT NULL,
  `jurusan_id` int(11) DEFAULT NULL,
  `prodi_id` int(11) DEFAULT NULL,
  `tahun_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `npm`
--

CREATE TABLE `npm` (
  `id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `npm` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `npm`
--

INSERT INTO `npm` (`id`, `mahasiswa_id`, `npm`, `created_at`, `updated_at`) VALUES
(11, 4473, '25754002', '2025-08-07 03:28:30', '2025-08-07 03:28:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi`
--

CREATE TABLE `prodi` (
  `id` int(11) NOT NULL,
  `kode_prodi` varchar(20) NOT NULL,
  `nama_prodi` varchar(100) NOT NULL,
  `jenjang_prodi` varchar(200) DEFAULT NULL,
  `total_kelas` varchar(200) DEFAULT NULL,
  `jurusan_id` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `prodi`
--

INSERT INTO `prodi` (`id`, `kode_prodi`, `nama_prodi`, `jenjang_prodi`, `total_kelas`, `jurusan_id`) VALUES
(1, '25711', 'Teknologi Produksi Tanaman Pangan', 'D4', '4', 1),
(2, '25712', 'Hortikultura', 'D3', '5', 1),
(3, '25713', 'Teknologi Perbenihan', 'D4', '3', 1),
(4, '25714', 'Teknologi Produksi Tanaman Hortikultura', 'D4', '', 1),
(5, '25721', 'Produksi Tanaman Perkebunan', 'D3', '', 2),
(6, '25722', 'Produksi Dan Manajemen Industri Perkebunan', 'D4', '', 2),
(7, '25723', 'Pengelolaan Perkebunan Kopi', 'D4', '', 2),
(8, '25724', 'Mekanisasi Pertanian', 'D3', '', 2),
(9, '25731', 'Teknologi Pangan', 'D3', '', 3),
(10, '25732', 'Pengembangan Produk Agro Industri', 'D4', '', 3),
(11, '25733', 'Pengelolaan Patiseri', 'D4', '', 3),
(12, '25735', 'Kimia Terapan', 'D3', '', 3),
(13, '25741', 'Agribisnis Peternakan', 'D4', '', 4),
(14, '25742', 'Teknologi Produksi Ternak', 'D4', '', 4),
(15, '25743', 'Teknologi Pakan Ternak', 'D4', '', 4),
(16, '25744', 'Pengelolaan Agribisnis', 'D4', '', 4),
(17, '25751', 'Akuntansi Bisnis Digital', 'D4', '', 5),
(18, '25752', 'Agribisnis Pangan', 'D4', '', 5),
(19, '25753', 'Akuntansi Perpajakan', 'D4', '', 5),
(20, '25754', 'Perjalanan Wisata', 'D3', '3', 5),
(21, '25755', 'Pengelolaan Perhotelan', 'D4', '', 5),
(22, '25756', 'Pengelolaan Konvensi dan Acara', 'D3', '', 5),
(23, '25758', 'Bahasa Inggris untuk Komunikasi Bisnis dan Profesional', 'D3', '', 5),
(24, '25761', 'Teknik Sumberdaya Lahan dan Lingkungan', 'D3', '', 6),
(25, '25762', 'Teknologi Rekayasa Kimia Industri', 'D3', '', 6),
(26, '25763', 'Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'D4', '', 6),
(27, '25764', 'Teknologi Rekayasa Otomotif', 'D3', '', 6),
(28, '25771', 'Budidaya Perikanan', 'D3', '', 7),
(29, '25772', 'Teknologi Pembenihan Ikan', 'D4', '', 7),
(30, '25773', 'Perikanan Tangkap', 'D3', '', 7),
(31, '25781', 'Manajemen Informatika', 'D3', '', 8),
(32, '25782', 'Teknologi Rekayasa Internet', 'D4', '', 8),
(33, '25783', 'Teknologi Rekayasa Perangkat Lunak', 'D4', '', 8),
(34, '25784', 'Teknologi Rekayasa Elektronika', 'D4', '', 8),
(35, '25785', 'Produksi Media', 'D3', '', 8),
(36, '25701', 'Ketahanan Pangan', 'S2', '', 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Mahasiswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun`
--

CREATE TABLE `tahun` (
  `id` int(11) NOT NULL,
  `kode_tahun` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tahun`
--

INSERT INTO `tahun` (`id`, `kode_tahun`) VALUES
(1, '2025');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `nama` varchar(200) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `nama`, `password`, `role_id`, `email`) VALUES
(1, 'admin', 'admin', '29e520fe9d18620e1bacd341f8263510f937e09479deebbbeab5ab758a659270', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`,`jurusan_id`,`prodi_id`,`tahun_id`);

--
-- Indeks untuk tabel `npm`
--
ALTER TABLE `npm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mahasiswa_id` (`mahasiswa_id`);

--
-- Indeks untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurusan_id` (`jurusan_id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tahun`
--
ALTER TABLE `tahun`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3959;

--
-- AUTO_INCREMENT untuk tabel `npm`
--
ALTER TABLE `npm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tahun`
--
ALTER TABLE `tahun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
