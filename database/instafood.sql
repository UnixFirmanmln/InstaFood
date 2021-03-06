-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 28 Nov 2021 pada 02.26
-- Versi server: 10.6.5-MariaDB
-- Versi PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instafood`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `followers`
--

CREATE TABLE `followers` (
  `id_register` int(11) DEFAULT NULL,
  `id_followed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `followers`
--

INSERT INTO `followers` (`id_register`, `id_followed`) VALUES
(17, 15),
(18, 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `posting`
--

CREATE TABLE `posting` (
  `id_posting` int(11) NOT NULL,
  `id_register` int(11) DEFAULT NULL,
  `gambar` mediumblob DEFAULT NULL,
  `pesan` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil`
--

CREATE TABLE `profil` (
  `id_profil` int(11) NOT NULL,
  `id_register` int(11) NOT NULL,
  `foto` mediumblob DEFAULT NULL,
  `notelp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `bio` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `register`
--

CREATE TABLE `register` (
  `id_register` int(11) NOT NULL,
  `nama_lengkap` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur` int(11) DEFAULT NULL,
  `jns_kel` enum('pria','wanita') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` enum('member','admin') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `register`
--

INSERT INTO `register` (`id_register`, `nama_lengkap`, `umur`, `jns_kel`, `alamat`, `email`, `username`, `password`, `level`) VALUES
(15, 'Firman Maulana', 21, 'pria', 'Probolinggo', 'fm28496@gmail.com', 'UnixFirmanmln', '98f3dd7251ab55e1267efe93b94583071dba6145cc6eb4789e1fc9a0b57f01ce', 'member'),
(17, 'bayekgukguk', 22, 'pria', 'Jakarta', 'bayek123@gmail.com', 'bayekgukguk', 'eda87db5ef734ef257b5a2add4422ff022fc67a4c1993ddae86b60e92ebe5f14', 'member'),
(18, 'Oliphochi', 21, 'wanita', 'Jakarta', 'unixkenzo@gmail.com', 'unixkenzo', '1fd53b5eeb3ae140e0749905588d8327dd533e3e288fb35549c8fcf73e57fa01', 'member'),
(22, 'Admin Sakura', 19, 'wanita', 'Jepang', 'sakuragun@gmail.com', 'sakuragun', 'd3bbb679748ca8231323ab09a3e91b6a2b8b848867a58cd47a4767aba063c699', 'admin');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_profil`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_profil` (
`id_register` int(11)
,`foto` mediumblob
,`username` varchar(30)
,`bio` varchar(300)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_profil`
--
DROP TABLE IF EXISTS `view_profil`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `view_profil`  AS SELECT `register`.`id_register` AS `id_register`, `profil`.`foto` AS `foto`, `register`.`username` AS `username`, `profil`.`bio` AS `bio` FROM (`register` join `profil` on(`register`.`id_register` = `profil`.`id_register`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `followers`
--
ALTER TABLE `followers`
  ADD KEY `id_register` (`id_register`),
  ADD KEY `id_followed` (`id_followed`);

--
-- Indeks untuk tabel `posting`
--
ALTER TABLE `posting`
  ADD PRIMARY KEY (`id_posting`),
  ADD KEY `id_register` (`id_register`);

--
-- Indeks untuk tabel `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id_profil`),
  ADD KEY `id_register` (`id_register`);

--
-- Indeks untuk tabel `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id_register`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `posting`
--
ALTER TABLE `posting`
  MODIFY `id_posting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT untuk tabel `profil`
--
ALTER TABLE `profil`
  MODIFY `id_profil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `register`
--
ALTER TABLE `register`
  MODIFY `id_register` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`id_register`) REFERENCES `register` (`id_register`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`id_followed`) REFERENCES `register` (`id_register`);

--
-- Ketidakleluasaan untuk tabel `posting`
--
ALTER TABLE `posting`
  ADD CONSTRAINT `posting_ibfk_1` FOREIGN KEY (`id_register`) REFERENCES `register` (`id_register`);

--
-- Ketidakleluasaan untuk tabel `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`id_register`) REFERENCES `register` (`id_register`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
