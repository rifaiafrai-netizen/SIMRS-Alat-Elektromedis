-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Nov 2026 pada 07.40
-- Versi server: 10.11.16-MariaDB
-- Versi PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `simrs`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alat`
--

CREATE TABLE `alat` (
  `id` int(11) NOT NULL,
  `nama_alat` varchar(100) NOT NULL,
  `tahun` year(4) NOT NULL,
  `merek` varchar(60) NOT NULL,
  `lokasi` varchar(10) NOT NULL,
  `kondisi` varchar(30) DEFAULT 'Baik'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alat`
--

INSERT INTO `alat` (`id`, `nama_alat`, `tahun`, `merek`, `lokasi`, `kondisi`) VALUES
(1, 'Monitor Pasien', '2023', 'Mindray', 'ICU', 'Baik'),
(2, 'Baby Incubator', '2022', 'BISAMED', 'NICU', 'Baik'),
(3, 'Tensimeter Digital', '2023', 'OMRON', 'IGD', 'Baik'),
(5, 'Termometer', '2021', 'OMRON', 'Rawat Inap', 'Dalam Perbaikan'),
(6, 'Puls Oximeter', '2026', 'Beurer', 'Poli Umum', 'Baik'),
(7, 'Stetoskop', '2025', '3M Littmann', 'Poli Umum', 'Baik'),
(8, 'Nebulizer', '2019', 'OMRON', 'IGD', 'Tidak Baik'),
(9, 'Elektrodakardiograf (EKG)', '2023', 'GE Healthcare', 'Poli Jantu', 'Baik'),
(10, 'Pompa Infus', '2025', 'B. Braun', 'Rawat Inap', 'Tidak Baik'),
(11, 'Pompa', '2021', 'Mindray', 'Operasai', 'Baik'),
(12, 'Ultrasonografi (USG)', '2025', 'GE Healthcare', 'Radiologi', 'Baik'),
(13, 'Termometer Digital', '2021', 'Braun', 'Rawat Inap', 'Baik'),
(14, 'Tensimeter Digital', '2022', 'Beurer', 'Poli Umum', 'Dalam Perbaikan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'Rifai', '$2y$12$7DiLGCXZviWvuUZ4HmisOuCfRaUm8BUoo.QBzoL2ROtpPufuFp1aC', '2026-11-20 04:11:06');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alat`
--
ALTER TABLE `alat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
