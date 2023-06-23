-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 23 Jun 2023 pada 10.58
-- Versi server: 10.5.20-MariaDB
-- Versi PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id20943756_posyandu_anggrek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian`
--

CREATE TABLE `antrian` (
  `no_antrian` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `status_antrian` enum('Pending','Selesai','Dibatalkan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `nik` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrator','Pelanggan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`nik`, `nama_lengkap`, `password`, `role`) VALUES
('1207649928489', 'Teguh', '202cb962ac59075b964b07152d234b70', 'Pelanggan'),
('123', 'Administrator', '21232f297a57a5a743894a0e4a801fc3', 'Administrator'),
('12345', 'Alvin Hendrawan', '202cb962ac59075b964b07152d234b70', 'Pelanggan'),
('123456789', 'Juspayanti', '63160165ff49db0fe921cf4d780d1342', 'Pelanggan'),
('12345678910', 'Aisyah Rahmawati', '202cb962ac59075b964b07152d234b70', 'Pelanggan'),
('2580', 'akbareee', '30eeeeac739d229a88493c0fc11cd1e2', 'Pelanggan'),
('3674016807724000', 'milda', 'baf588d0f36f29cf8fa0310a4eb68c92', 'Pelanggan'),
('3674072901021001', 'Andri Firman Saputra', 'aef33c8371e8e94a713d117b8b876727', 'Pelanggan'),
('564918039', 'Alvin Hendrawan', '202cb962ac59075b964b07152d234b70', 'Pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`no_antrian`),
  ADD KEY `nik` (`nik`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nik`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `antrian`
--
ALTER TABLE `antrian`
  MODIFY `no_antrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD CONSTRAINT `antrian_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `user` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
