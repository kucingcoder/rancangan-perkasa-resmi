CREATE TABLE `kategori` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nama_kategori` varchar(128) UNIQUE NOT NULL,
  `ukuran` int NOT NULL,
  `satuan` varchar(16) NOT NULL,
  `biaya_sales` int NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `biaya_pengiriman` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `wilayah` varchar(128) UNIQUE NOT NULL,
  `nominal` int NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `pembeli` (
  `id` char(36) PRIMARY KEY,
  `nama` varchar(128) NOT NULL,
  `alamat` text NOT NULL,
  `no_wa` varchar(15) UNIQUE NOT NULL,
  `email` varchar(364) UNIQUE,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `akun` (
  `id` char(36) PRIMARY KEY,
  `email` varchar(364) UNIQUE NOT NULL,
  `no_wa` varchar(15) UNIQUE NOT NULL,
  `password` char(32) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `foto` varchar(45) NOT NULL,
  `jenis_kelamin` ENUM ('laki-laki', 'perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `jenis_akun` ENUM ('owner', 'admin', 'sales') NOT NULL DEFAULT 'sales',
  `status` ENUM ('aktif', 'non aktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `barang` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nama_barang` varchar(128) NOT NULL,
  `kategori_id` int NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `foto` char(45) UNIQUE NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `daftar_barang` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `barang_id` int NOT NULL,
  `keranjang_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `keranjang` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `judul` varchar(128) NOT NULL,
  `akun_id` char(36) NOT NULL,
  `pembeli_id` char(36) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `expedisi` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nama` varchar(128) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `pengiriman` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nama_kurir` varchar(128) NOT NULL,
  `no_wa_kurir` varchar(15) NOT NULL,
  `foto_kurir` varchar(45) NOT NULL,
  `expedisi_id` int NOT NULL,
  `wilayah_id` int NOT NULL,
  `alamat` text NOT NULL,
  `jumlah` int NOT NULL,
  `foto_bukti` varchar(45) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `pesanan` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `keranjang_id` int NOT NULL,
  `nota` char(32) DEFAULT '',
  `laporan` char(32) DEFAULT '',
  `bukti_pelunasan` char(45) DEFAULT '',
  `pengiriman_id` int,
  `status` ENUM ('diperiksa', 'diterima', 'ditolak', 'diproses', 'dikirim', 'selesai') NOT NULL DEFAULT 'diperiksa',
  `alasan` text,
  `jenis_transaksi` ENUM ('langsung', 'payment gateway') NOT NULL DEFAULT 'langsung',
  `transaksi_id` char(36) DEFAULT '',
  `pendapatan_kotor` int NOT NULL,
  `pendapatan_bersih` int NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `karyawan` (
  `id` char(36) PRIMARY KEY,
  `nama` varchar(128) NOT NULL,
  `jenis_kelamin` ENUM ('laki-laki', 'perempuan') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_wa` varchar(15) UNIQUE NOT NULL,
  `foto` char(45) UNIQUE NOT NULL,
  `gaji` int NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `daftar_karyawan` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `karyawan_id` char(36) NOT NULL,
  `gaji_tambahan` int NOT NULL,
  `lembur_id` int NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `lembur` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `judul` varchar(128) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `barang` ADD FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

ALTER TABLE `daftar_barang` ADD FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);

ALTER TABLE `daftar_barang` ADD FOREIGN KEY (`keranjang_id`) REFERENCES `keranjang` (`id`);

ALTER TABLE `keranjang` ADD FOREIGN KEY (`akun_id`) REFERENCES `akun` (`id`);

ALTER TABLE `keranjang` ADD FOREIGN KEY (`pembeli_id`) REFERENCES `pembeli` (`id`);

ALTER TABLE `pengiriman` ADD FOREIGN KEY (`expedisi_id`) REFERENCES `expedisi` (`id`);

ALTER TABLE `pengiriman` ADD FOREIGN KEY (`wilayah_id`) REFERENCES `biaya_pengiriman` (`id`);

ALTER TABLE `daftar_karyawan` ADD FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`);

ALTER TABLE `daftar_karyawan` ADD FOREIGN KEY (`lembur_id`) REFERENCES `lembur` (`id`);

ALTER TABLE `pesanan` ADD FOREIGN KEY (`pengiriman_id`) REFERENCES `pengiriman` (`id`);

ALTER TABLE `pesanan` ADD FOREIGN KEY (`keranjang_id`) REFERENCES `pesanan` (`id`);