/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.21-MariaDB : Database - tracer_study
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tracer_study` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `tracer_study`;

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2019_08_19_000000_create_failed_jobs_table',1),
(3,'2017_05_02_140432_create_provinces_tables',2),
(4,'2017_05_02_140444_create_regencies_tables',2),
(5,'2017_05_02_140454_create_villages_tables',2),
(6,'2017_05_02_142019_create_districts_tables',2),
(7,'2014_10_12_000000_create_alumni_table',3);

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notifications` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `tb_alumni` */

DROP TABLE IF EXISTS `tb_alumni`;

CREATE TABLE `tb_alumni` (
  `id_alumni` int(11) NOT NULL AUTO_INCREMENT,
  `nama_alumni` varchar(255) DEFAULT NULL,
  `nik` bigint(20) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') DEFAULT NULL,
  `nim_alumni` varchar(255) DEFAULT NULL,
  `id_angkatan` int(11) DEFAULT NULL,
  `id_prodi` int(11) DEFAULT NULL,
  `alamat_alumni` varchar(255) DEFAULT NULL,
  `tahun_lulus` date DEFAULT NULL,
  `tahun_wisuda` date DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_telegram` varchar(255) DEFAULT NULL,
  `id_line` varchar(255) DEFAULT NULL,
  `transkrip` varchar(255) DEFAULT NULL,
  `transkrip_name` varchar(255) DEFAULT NULL,
  `status` enum('Menunggu Konfirmasi','Konfirmasi','Ditolak','Mengajukan Perbaikan') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `chat_id` varchar(255) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_alumni`),
  KEY `id_prodi` (`id_prodi`),
  KEY `id_angkatan` (`id_angkatan`),
  KEY `id_gender` (`jenis_kelamin`),
  KEY `id_periode_alumni` (`id_periode`),
  CONSTRAINT `tb_alumni_ibfk_2` FOREIGN KEY (`id_prodi`) REFERENCES `tb_prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_alumni_ibfk_3` FOREIGN KEY (`id_angkatan`) REFERENCES `tb_angkatan` (`id_angkatan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_alumni_ibfk_4` FOREIGN KEY (`id_periode`) REFERENCES `tb_periodealumni` (`id_periode_alumni`)
) ENGINE=InnoDB AUTO_INCREMENT=1185 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_alumni` */

insert  into `tb_alumni`(`id_alumni`,`nama_alumni`,`nik`,`jenis_kelamin`,`nim_alumni`,`id_angkatan`,`id_prodi`,`alamat_alumni`,`tahun_lulus`,`tahun_wisuda`,`no_hp`,`email`,`password`,`id_telegram`,`id_line`,`transkrip`,`transkrip_name`,`status`,`foto`,`chat_id`,`email_verified_at`,`id_periode`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Agus Guna Saputra',1234432112344321,'Laki-Laki','1805551076',5,1,'Sanur','2021-10-05','2021-10-05','6281246873224','guns@gmail.com','$2y$10$ABeEpFEvAMf2.gsG7VYZge80rARLQd6NKH0Fgw.Cq8s7jxoVhZY72','agusgun_sa\\\\','agusgun_sa','/storage/file/transkrip_alumni/1805551076_transkripNilai.pdf','1805551076_transkripNilai.pdf','Konfirmasi','/storage/image/alumni/profile/616b7e37bf8f9.png','585958250',NULL,1,'2021-10-09 02:00:59','2021-10-17 01:36:55',NULL),
(925,'adi',NULL,NULL,'1805551048',9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(927,'Adi Suadika',NULL,'',NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,'2021-10-27 14:44:00',NULL),
(928,'fff',NULL,'',NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,'2021-10-27 14:45:00',NULL),
(929,'Adi Suadika 1',NULL,'',NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,'2021-10-27 14:46:15',NULL),
(930,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(931,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(932,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(933,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(934,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(935,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(936,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(937,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(938,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(939,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(940,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(941,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(942,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(943,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(944,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(945,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(946,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(947,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(948,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(949,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(950,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(951,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(952,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(953,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(954,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(955,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(956,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(957,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(958,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(959,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(960,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(961,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(962,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(963,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(964,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(965,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(966,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(967,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(968,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(969,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(970,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(971,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(972,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(973,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(974,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(975,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(976,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(977,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(978,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(979,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(980,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(981,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(982,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(983,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(984,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(985,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(986,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(987,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(988,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(989,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(990,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(991,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(992,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(993,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(994,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(995,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(996,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(997,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(998,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL),
(999,NULL,NULL,NULL,NULL,9,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'584467570',NULL,2,NULL,NULL,NULL);

/*Table structure for table `tb_angkatan` */

DROP TABLE IF EXISTS `tb_angkatan`;

CREATE TABLE `tb_angkatan` (
  `id_angkatan` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_angkatan` year(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_angkatan`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_angkatan` */

insert  into `tb_angkatan`(`id_angkatan`,`tahun_angkatan`,`updated_at`,`deleted_at`,`created_at`) values 
(5,2018,NULL,NULL,NULL),
(9,2019,NULL,NULL,NULL),
(10,2020,'2021-10-01 14:03:42',NULL,'2021-09-07 05:45:42'),
(11,2014,'2021-10-23 07:27:47',NULL,'2021-10-23 07:27:47'),
(12,2015,'2021-10-23 07:27:58',NULL,'2021-10-23 07:27:58'),
(13,2016,'2021-10-23 07:28:05',NULL,'2021-10-23 07:28:05'),
(14,2021,'2021-10-23 07:28:13',NULL,'2021-10-23 07:28:13'),
(15,2022,'2021-10-28 14:45:48',NULL,'2021-10-23 07:28:19'),
(16,2023,'2021-10-23 07:28:29',NULL,'2021-10-23 07:28:29'),
(17,2013,'2021-10-23 07:30:58',NULL,'2021-10-23 07:30:58'),
(18,2012,'2021-10-23 15:04:23',NULL,'2021-10-23 15:04:23'),
(19,2017,'2021-10-26 00:15:07',NULL,'2021-10-26 00:15:07'),
(20,2026,'2021-10-28 14:42:51','2021-10-28 14:42:51','2021-10-28 14:40:26'),
(21,NULL,'2021-10-28 14:41:24','2021-10-28 14:41:24','2021-10-28 14:40:42'),
(22,0000,'2021-10-28 14:42:55','2021-10-28 14:42:55','2021-10-28 14:41:16');

/*Table structure for table `tb_detail_jawaban` */

DROP TABLE IF EXISTS `tb_detail_jawaban`;

CREATE TABLE `tb_detail_jawaban` (
  `id_detail_jawaban` int(11) NOT NULL AUTO_INCREMENT,
  `id_jawaban` int(11) DEFAULT NULL,
  `jawaban` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail_jawaban`),
  KEY `jawaban` (`jawaban`),
  CONSTRAINT `tb_detail_jawaban_ibfk_1` FOREIGN KEY (`jawaban`) REFERENCES `tb_opsi` (`id_opsi`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_detail_jawaban` */

/*Table structure for table `tb_detail_kuesioner` */

DROP TABLE IF EXISTS `tb_detail_kuesioner`;

CREATE TABLE `tb_detail_kuesioner` (
  `id_detail_kuesioner` int(11) NOT NULL AUTO_INCREMENT,
  `id_kuesioner` int(11) DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL COMMENT '1=ganda,2=singkat,3=checkbox,4=tanggal',
  `id_bank_soal` int(11) DEFAULT NULL,
  `pertanyaan` varchar(255) DEFAULT NULL,
  `status` enum('Konfirmasi','Menunggu Konfirmasi','Ditolak') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail_kuesioner`),
  KEY `tb_detail_kuesioner_ibfk_3` (`id_kuesioner`),
  KEY `tb_detail_kuesioner_ibfk_4` (`id_jenis`),
  KEY `id_bank_soal` (`id_bank_soal`),
  CONSTRAINT `tb_detail_kuesioner_ibfk_3` FOREIGN KEY (`id_kuesioner`) REFERENCES `tb_kuesioner` (`id_kuesioner`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_detail_kuesioner_ibfk_6` FOREIGN KEY (`id_bank_soal`) REFERENCES `tb_detail_soal_alumni` (`id_detail_soal_alumni`)
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_detail_kuesioner` */

insert  into `tb_detail_kuesioner`(`id_detail_kuesioner`,`id_kuesioner`,`id_jenis`,`id_bank_soal`,`pertanyaan`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(124,58,4,14,'Tanggal, Bulan dan Tahun Berapa Pertama Kali Diterima Kerja pada Perusahaan/ Tempat kerja tersebut','','2021-10-14 02:37:13','2021-11-12 02:36:31',NULL),
(125,58,2,15,'Nama Perusahaan/ Tempat Kerja?','Ditolak','2021-10-14 02:37:13','2021-10-17 09:12:32',NULL),
(126,58,2,16,'Gaji Pertama ?','Menunggu Konfirmasi','2021-10-14 02:37:13','2021-10-14 02:37:13',NULL),
(127,58,2,17,'Gaji Saat Ini ?','Menunggu Konfirmasi','2021-10-14 02:37:14','2021-10-14 02:37:14',NULL),
(128,59,2,18,'Apa Nama Perusahaan / Wirausaha yang dikelola?','Ditolak','2021-10-14 02:38:30','2021-10-16 05:28:22',NULL),
(129,59,2,19,'Jumlah Karyawan / Staff','Ditolak','2021-10-14 02:38:30','2021-10-16 05:28:20',NULL),
(130,60,2,20,'Angkatan','Menunggu Konfirmasi','2021-10-14 02:39:02','2021-10-14 02:39:02',NULL),
(131,60,2,21,'Program Studi / Jurusan','Menunggu Konfirmasi','2021-10-14 02:39:03','2021-10-14 02:39:03',NULL),
(132,60,2,22,'Fakultas / Sekolah','Menunggu Konfirmasi','2021-10-14 02:39:03','2021-10-14 02:39:03',NULL),
(133,60,2,23,'Universitas / Perguruan Tinggi','Menunggu Konfirmasi','2021-10-14 02:39:05','2021-10-14 02:39:05',NULL),
(134,61,4,14,'Tanggal, Bulan dan Tahun Berapa Pertama Kali Diterima Kerja pada Perusahaan/ Tempat kerja tersebut','Menunggu Konfirmasi','2021-10-14 02:41:15','2021-10-14 02:41:15',NULL),
(135,61,2,15,'Nama Perusahaan/ Tempat Kerja?','Menunggu Konfirmasi','2021-10-14 02:41:15','2021-10-14 02:41:15',NULL),
(136,61,2,16,'Gaji Pertama ?','Menunggu Konfirmasi','2021-10-14 02:41:15','2021-10-14 02:41:15',NULL),
(137,61,2,17,'Gaji Saat Ini ?','Menunggu Konfirmasi','2021-10-14 02:41:15','2021-10-14 02:41:15',NULL),
(138,62,2,18,'Apa Nama Perusahaan / Wirausaha yang dikelola?','Menunggu Konfirmasi','2021-10-14 02:41:44','2021-10-14 02:41:44',NULL),
(139,62,2,19,'Jumlah Karyawan / Staff','Menunggu Konfirmasi','2021-10-14 02:41:44','2021-10-14 02:41:44',NULL),
(140,62,2,20,'Angkatan','Menunggu Konfirmasi','2021-10-14 02:41:58','2021-10-14 02:41:58',NULL),
(141,62,2,21,'Program Studi / Jurusan','Menunggu Konfirmasi','2021-10-14 02:41:58','2021-10-14 02:41:58',NULL),
(142,62,2,22,'Fakultas / Sekolah','Menunggu Konfirmasi','2021-10-14 02:41:58','2021-10-14 02:41:58',NULL),
(143,62,2,23,'Universitas / Perguruan Tinggi','Menunggu Konfirmasi','2021-10-14 02:41:58','2021-10-14 02:41:58',NULL),
(144,63,2,20,'Angkatan','Menunggu Konfirmasi','2021-10-14 02:43:48','2021-10-14 02:43:48',NULL),
(145,63,2,21,'Program Studi / Jurusan','Menunggu Konfirmasi','2021-10-14 02:43:49','2021-10-14 02:43:49',NULL),
(146,63,2,22,'Fakultas / Sekolah','Menunggu Konfirmasi','2021-10-14 02:43:50','2021-10-14 02:43:50',NULL),
(147,63,2,23,'Universitas / Perguruan Tinggi','Menunggu Konfirmasi','2021-10-14 02:43:50','2021-10-14 02:43:50',NULL),
(148,64,4,14,'Tanggal, Bulan dan Tahun Berapa Pertama Kali Diterima Kerja pada Perusahaan/ Tempat kerja tersebut','Menunggu Konfirmasi','2021-10-14 02:45:25','2021-10-14 02:45:25',NULL),
(149,64,2,15,'Nama Perusahaan/ Tempat Kerja?','Menunggu Konfirmasi','2021-10-14 02:45:25','2021-10-14 02:45:25',NULL),
(150,64,2,16,'Gaji Pertama ?','Menunggu Konfirmasi','2021-10-14 02:45:25','2021-10-14 02:45:25',NULL),
(151,64,2,17,'Gaji Saat Ini ?','Menunggu Konfirmasi','2021-10-14 02:45:25','2021-10-14 02:45:25',NULL),
(152,65,2,18,'Apa Nama Perusahaan / Wirausaha yang dikelola?','Menunggu Konfirmasi','2021-10-14 02:46:06','2021-10-14 02:46:06',NULL),
(153,65,2,19,'Jumlah Karyawan / Staff','Menunggu Konfirmasi','2021-10-14 02:46:06','2021-10-14 02:46:06',NULL),
(154,66,2,20,'Angkatan','Menunggu Konfirmasi','2021-10-14 02:47:03','2021-10-14 02:47:03',NULL),
(155,66,2,21,'Program Studi / Jurusan','Menunggu Konfirmasi','2021-10-14 02:47:04','2021-10-14 02:47:04',NULL),
(156,66,2,22,'Fakultas / Sekolah','Menunggu Konfirmasi','2021-10-14 02:47:04','2021-10-14 02:47:04',NULL),
(157,66,2,23,'Universitas / Perguruan Tinggi','Menunggu Konfirmasi','2021-10-14 02:47:04','2021-10-14 02:47:04',NULL),
(158,67,4,14,'Tanggal, Bulan dan Tahun Berapa Pertama Kali Diterima Kerja pada Perusahaan/ Tempat kerja tersebut','Konfirmasi','2021-10-14 02:48:32','2021-10-14 02:48:32',NULL),
(159,67,2,15,'Nama Perusahaan/ Tempat Kerja?','Konfirmasi','2021-10-14 02:48:32','2021-10-14 02:48:32',NULL),
(160,67,2,16,'Gaji Pertama ?','Konfirmasi','2021-10-14 02:48:32','2021-10-14 02:48:32',NULL),
(161,67,2,17,'Gaji Saat Ini ?','Konfirmasi','2021-10-14 02:48:33','2021-10-14 02:48:33',NULL),
(162,68,2,18,'Apa Nama Perusahaan / Wirausaha yang dikelola?','Konfirmasi','2021-10-14 02:50:13','2021-10-14 02:50:13',NULL),
(163,68,2,19,'Jumlah Karyawan / Staff','Konfirmasi','2021-10-14 02:50:13','2021-10-14 02:50:13',NULL),
(164,69,2,20,'Angkatan','Menunggu Konfirmasi','2021-10-14 02:52:19','2021-10-14 02:52:19',NULL),
(165,69,2,21,'Program Studi / Jurusan','Menunggu Konfirmasi','2021-10-14 02:52:20','2021-10-14 02:52:20',NULL),
(166,69,2,22,'Fakultas / Sekolah','Menunggu Konfirmasi','2021-10-14 02:52:20','2021-10-14 02:52:20',NULL),
(167,69,2,23,'Universitas / Perguruan Tinggi','Menunggu Konfirmasi','2021-10-14 02:52:20','2021-10-14 02:52:20',NULL),
(168,67,2,23,'aqqqq','Menunggu Konfirmasi','2021-10-15 08:31:36','2021-10-15 13:34:37','2021-10-15 13:34:37'),
(169,72,2,14,'Tanggal, Bulan dan Tahun Berapa Pertama Kali Diterima Kerja pada Perusahaan/ Tempat kerja tersebut','Menunggu Konfirmasi','2021-10-16 12:20:06','2021-10-16 12:21:31','2021-10-16 12:21:31'),
(170,72,2,15,'Nama Perusahaan/ Tempat Kerja?','Menunggu Konfirmasi','2021-10-16 12:20:06','2021-10-16 12:20:06',NULL),
(171,72,2,16,'Gaji Pertama ?','Menunggu Konfirmasi','2021-10-16 12:20:07','2021-10-16 12:20:07',NULL),
(172,72,2,17,'Gaji Saat Ini ?','Menunggu Konfirmasi','2021-10-16 12:20:07','2021-10-16 12:20:07',NULL),
(173,72,2,18,'Apa Nama Perusahaan / Wirausaha yang dikelola?','Menunggu Konfirmasi','2021-10-16 12:20:07','2021-10-16 12:20:07',NULL),
(174,72,2,19,'Jumlah Karyawan / Staff','Menunggu Konfirmasi','2021-10-16 12:20:08','2021-10-16 12:20:08',NULL),
(175,72,2,20,'Angkatan','Menunggu Konfirmasi','2021-10-16 12:20:08','2021-10-16 12:20:08',NULL),
(176,72,2,21,'Program Studi / Jurusan','Menunggu Konfirmasi','2021-10-16 12:20:08','2021-10-16 12:20:08',NULL),
(177,72,2,22,'Fakultas / Sekolah','Menunggu Konfirmasi','2021-10-16 12:20:08','2021-10-16 12:20:08',NULL),
(178,72,2,23,'Universitas / Perguruan Tinggi','Menunggu Konfirmasi','2021-10-16 12:20:08','2021-10-16 12:20:08',NULL),
(179,59,1,NULL,'Berapa anda memiliki kantor?','Menunggu Konfirmasi','2021-10-22 17:09:08','2021-10-22 17:09:08',NULL),
(180,68,1,NULL,'Berapakah anda memili kantor?','Konfirmasi','2021-10-22 17:12:26','2021-10-22 17:12:26',NULL),
(181,74,NULL,14,'Tanggal, Bulan dan Tahun Berapa Pertama Kali Diterima Kerja pada Perusahaan/ Tempat kerja tersebut','Menunggu Konfirmasi','2021-10-23 06:09:10','2021-10-23 06:09:10',NULL),
(182,74,NULL,15,'Nama Perusahaan/ Tempat Kerja?','Menunggu Konfirmasi','2021-10-23 06:09:11','2021-10-23 06:09:11',NULL),
(183,74,NULL,16,'Gaji Pertama ?','Menunggu Konfirmasi','2021-10-23 06:09:11','2021-10-23 06:09:11',NULL),
(184,74,NULL,17,'Gaji Saat Ini ?','Menunggu Konfirmasi','2021-10-23 06:09:11','2021-10-23 06:09:11',NULL),
(185,58,2,NULL,'test123','Menunggu Konfirmasi','2021-10-24 09:24:12','2021-10-28 07:18:35','2021-10-28 07:18:35'),
(186,58,1,NULL,'Setelah lulus apakah anda bekerja ?','Menunggu Konfirmasi','2021-10-28 07:16:40','2021-10-28 07:18:23','2021-10-28 07:18:23'),
(187,58,2,NULL,'Setelah lulus apakah anda bekerja ?','Menunggu Konfirmasi','2021-10-28 07:17:50','2021-10-28 07:18:29','2021-10-28 07:18:29'),
(188,58,2,NULL,'Setelah lulus apakah anda bekerja ?','Menunggu Konfirmasi','2021-10-28 07:18:16','2021-10-28 07:18:43','2021-10-28 07:18:43'),
(189,58,2,20,'Angkatan1','Menunggu Konfirmasi','2021-10-28 07:21:38','2021-10-28 08:36:55',NULL);

/*Table structure for table `tb_detail_kuesioner_stakeholder` */

DROP TABLE IF EXISTS `tb_detail_kuesioner_stakeholder`;

CREATE TABLE `tb_detail_kuesioner_stakeholder` (
  `id_detail_kuesioner_stakeholder` int(11) NOT NULL AUTO_INCREMENT,
  `id_prodi` int(11) DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `id_soal_stakeholder` int(11) DEFAULT NULL,
  `pertanyaan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_detail_kuesioner_stakeholder`),
  KEY `id_prodi` (`id_prodi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tb_detail_kuesioner_stakeholder` */

/*Table structure for table `tb_detail_pengumuman` */

DROP TABLE IF EXISTS `tb_detail_pengumuman`;

CREATE TABLE `tb_detail_pengumuman` (
  `id_detail_pengumuman` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengumuman` int(11) DEFAULT NULL,
  `perihal` varchar(255) DEFAULT NULL,
  `lampiran_name` varchar(255) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `thumbnail_name` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_detail_pengumuman`),
  KEY `id_pengumuman` (`id_pengumuman`),
  CONSTRAINT `tb_detail_pengumuman_ibfk_1` FOREIGN KEY (`id_pengumuman`) REFERENCES `tb_pengumuman` (`id_pengumuman`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_detail_pengumuman` */

/*Table structure for table `tb_detail_soal_alumni` */

DROP TABLE IF EXISTS `tb_detail_soal_alumni`;

CREATE TABLE `tb_detail_soal_alumni` (
  `id_detail_soal_alumni` int(11) NOT NULL AUTO_INCREMENT,
  `id_soal_alumni` int(11) DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL COMMENT '1=ganda,2=singkat,3=checkbox,4=tanggal',
  `pertanyaan` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `status` enum('Menunggu Konfirmasi','Konfirmasi') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_detail_soal_alumni`),
  KEY `id_soal_alumni` (`id_soal_alumni`),
  CONSTRAINT `tb_detail_soal_alumni_ibfk_1` FOREIGN KEY (`id_soal_alumni`) REFERENCES `tb_soal_alumni` (`id_soal_alumni`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_detail_soal_alumni` */

insert  into `tb_detail_soal_alumni`(`id_detail_soal_alumni`,`id_soal_alumni`,`id_jenis`,`pertanyaan`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(10,4,1,'Tes','Menunggu Konfirmasi','2021-10-13 11:21:50','2021-10-14 02:23:20','2021-10-14 02:23:20'),
(11,7,2,'Nama Universitas','Menunggu Konfirmasi','2021-10-13 11:50:09','2021-10-14 02:26:17','2021-10-14 02:26:17'),
(12,7,1,'Apakah anda melanjutkan studi diluar kota','Menunggu Konfirmasi','2021-10-13 11:50:38','2021-10-14 02:26:23','2021-10-14 02:26:23'),
(13,7,3,'checkbox','Menunggu Konfirmasi','2021-10-13 11:52:26','2021-10-13 11:59:42','2021-10-13 11:59:42'),
(14,4,4,'Tanggal, Bulan dan Tahun Berapa Pertama Kali Diterima Kerja pada Perusahaan/ Tempat kerja tersebut','Menunggu Konfirmasi','2021-10-14 02:23:40','2021-10-14 02:23:40',NULL),
(15,4,2,'Nama Perusahaan/ Tempat Kerja?','Menunggu Konfirmasi','2021-10-14 02:23:53','2021-10-14 02:23:53',NULL),
(16,4,2,'Gaji Pertama ?','Menunggu Konfirmasi','2021-10-14 02:24:12','2021-10-14 02:24:12',NULL),
(17,4,2,'Gaji Saat Ini ?','Menunggu Konfirmasi','2021-10-14 02:24:33','2021-10-14 02:24:33',NULL),
(18,6,2,'Apa Nama Perusahaan / Wirausaha yang dikelola?','Konfirmasi','2021-10-14 02:25:21','2021-10-14 02:25:21',NULL),
(19,6,2,'Jumlah Karyawan / Staff','Konfirmasi','2021-10-14 02:25:30','2021-10-14 02:25:30',NULL),
(20,7,2,'Angkatan','Konfirmasi','2021-10-14 02:26:33','2021-10-14 02:26:33',NULL),
(21,7,2,'Program Studi / Jurusan','Konfirmasi','2021-10-14 02:26:51','2021-10-14 02:26:51',NULL),
(22,7,2,'Fakultas / Sekolah','Konfirmasi','2021-10-14 02:27:04','2021-10-14 02:27:04',NULL),
(23,7,2,'Universitas / Perguruan Tinggi','Konfirmasi','2021-10-14 02:27:21','2021-10-14 02:27:21',NULL),
(24,4,1,'teastaa','Menunggu Konfirmasi','2021-10-28 12:56:07','2021-10-28 13:16:21',NULL),
(25,4,1,'aaa','Menunggu Konfirmasi','2021-10-28 12:56:52','2021-10-28 12:56:52',NULL);

/*Table structure for table `tb_gender` */

DROP TABLE IF EXISTS `tb_gender`;

CREATE TABLE `tb_gender` (
  `id_gender` int(11) NOT NULL AUTO_INCREMENT,
  `gender` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_gender`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_gender` */

insert  into `tb_gender`(`id_gender`,`gender`) values 
(1,'Laki-Laki'),
(2,'Perempuan');

/*Table structure for table `tb_inbox` */

DROP TABLE IF EXISTS `tb_inbox`;

CREATE TABLE `tb_inbox` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pesan` bigint(20) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `chat_id` varchar(30) DEFAULT NULL,
  `chat` text DEFAULT NULL,
  `flag_chat` tinyint(4) DEFAULT NULL,
  `tipe_chat` enum('cekdaftar','daftar','kuesioner','pengumuman','unknown') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2291 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_inbox` */

insert  into `tb_inbox`(`id`,`id_pesan`,`username`,`chat_id`,`chat`,`flag_chat`,`tipe_chat`) values 
(1976,5114,'begoniaid','1492058996','/kuesioner',0,'kuesioner'),
(1977,5116,'begoniaid','1492058996','/2',10,'kuesioner'),
(1978,5118,'begoniaid','1492058996','PT. Makmur Jaya Sentosa',10,'kuesioner'),
(1979,5120,'begoniaid','1492058996','90',10,'kuesioner'),
(1980,5122,'begoniaid','1492058996','mobil',40,'unknown'),
(1981,5127,'begoniaid','1492058996','mobil',40,'unknown'),
(1982,5131,'begoniaid','1492058996','sad',40,'unknown'),
(1983,5133,'begoniaid','1492058996','/cekdaftar',70,'cekdaftar'),
(1984,5135,'begoniaid','1492058996','/daftar',60,'daftar'),
(1985,5137,'begoniaid','1492058996','1805551076',61,'daftar'),
(1986,5139,'begoniaid','1492058996','/cekdaftar',70,'cekdaftar'),
(1987,5141,'begoniaid','1492058996','/daftar',60,'daftar'),
(1988,5143,'begoniaid','1492058996','1805551076',61,'daftar'),
(1989,5145,'begoniaid','1492058996','/cekdaftar',70,'cekdaftar'),
(1990,5147,'begoniaid','1492058996','/daftar',60,'daftar'),
(1991,5149,'begoniaid','1492058996','1805551076',61,'daftar'),
(1992,5151,'adisuandika14','584467570','Test',40,'unknown'),
(1993,5185,'begoniaid','1492058996','sd',40,'unknown'),
(1994,5187,'begoniaid','1492058996','/cekdaftar',70,'cekdaftar'),
(1995,5189,'begoniaid','1492058996','/daftar',60,'daftar'),
(1996,5191,'begoniaid','1492058996','1805551076',61,'daftar'),
(1997,5379,'adisuandika14','584467570','daftar',40,'unknown'),
(1998,5382,'agusgun_sa','585958250','test',40,'unknown'),
(1999,5385,'agusgun_sa','585958250','das',40,'unknown'),
(2000,5391,'agusgun_sa','585958250','sadasd',40,'unknown'),
(2001,5396,'agusgun_sa','585958250','aedw',40,'unknown'),
(2002,5398,'agusgun_sa','585958250','/cekdaftar',70,'cekdaftar'),
(2003,5400,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2004,5400,'agusgun_sa','585958250','/daftar',61,'daftar'),
(2005,5402,'agusgun_sa','585958250','1805551055',40,'unknown'),
(2006,5404,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2007,5406,'agusgun_sa','585958250','1805551055',61,'daftar'),
(2008,5408,'agusgun_sa','585958250','/cekdaftar',70,'cekdaftar'),
(2009,5410,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2010,5412,'agusgun_sa','585958250','1805551053',61,'daftar'),
(2011,5414,'agusgun_sa','585958250','/cekdaftar',70,'cekdaftar'),
(2012,5416,'agusgun_sa','585958250','/cekdaftar',70,'cekdaftar'),
(2013,5418,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2014,5420,'agusgun_sa','585958250','1805551055',61,'daftar'),
(2015,5422,'agusgun_sa','585958250','/cekdaftar',70,'cekdaftar'),
(2016,5424,'agusgun_sa','585958250','/cekdaftar',70,'cekdaftar'),
(2017,5426,'agusgun_sa','585958250','test',40,'unknown'),
(2018,5428,'agusgun_sa','585958250','ad',40,'unknown'),
(2019,5428,'agusgun_sa','585958250','ad',40,'unknown'),
(2020,5431,'agusgun_sa','585958250','asd',40,'unknown'),
(2021,5433,'agusgun_sa','585958250','ads',40,'unknown'),
(2022,5435,'agusgun_sa','585958250','/cekdaftar',70,'cekdaftar'),
(2023,5437,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2024,5439,'agusgun_sa','585958250','uhasjkdhjkas',61,'daftar'),
(2025,5440,'agusgun_sa','585958250','test',40,'unknown'),
(2026,5442,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2027,5442,'agusgun_sa','585958250','/daftar',61,'daftar'),
(2028,5444,'agusgun_sa','585958250','2313123123',40,'unknown'),
(2029,5446,'agusgun_sa','585958250','/cekdaftar',70,'cekdaftar'),
(2030,5448,'adisuandika14','584467570','daftar',40,'unknown'),
(2031,5450,'agusgun_sa','585958250','/cekdaftar',70,'cekdaftar'),
(2032,5452,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2033,5454,'agusgun_sa','585958250','1805551031',61,'daftar'),
(2034,5456,'agusgun_sa','585958250','1231',40,'unknown'),
(2035,5458,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2036,5460,'agusgun_sa','585958250','asdasdsd',61,'daftar'),
(2037,5462,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2038,5464,'agusgun_sa','585958250','12312313213',61,'daftar'),
(2039,5466,'agusgun_sa','585958250','/start',40,'unknown'),
(2040,5468,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2041,5470,'agusgun_sa','585958250','1805551076',61,'daftar'),
(2042,5472,'agusgun_sa','585958250','/cekdaftar',70,'cekdaftar'),
(2043,5474,'agusgun_sa','585958250','/daftar',60,'daftar'),
(2044,5477,'agusgun_sa','585958250','180555531u',61,'daftar'),
(2045,5478,'yogasudharma','600446088','/start',40,'unknown'),
(2046,5481,'yogasudharma','600446088','/daftar',60,'daftar'),
(2047,5484,'yogasudharma','600446088','1705541002',61,'daftar'),
(2048,5486,'yogasudharma','600446088','/cekdaftar',70,'cekdaftar'),
(2049,5488,'arishndra','363020451','/start',40,'unknown'),
(2050,5489,'arishndra','363020451','1705552002',40,'unknown'),
(2051,5490,'arishndra','363020451','/daftar',60,'daftar'),
(2052,5491,'arishndra','363020451','1705552002',61,'daftar'),
(2053,5492,'arishndra','363020451','/daftar1705552002',40,'unknown'),
(2054,5503,'Prayoga401','1166455687','/start',40,'unknown'),
(2055,5504,'Prayoga401','1166455687','/daftar',60,'daftar'),
(2056,5505,'Aguspriska','384104973','/start',40,'unknown'),
(2057,5506,'Aguspriska','384104973','/daftar',60,'daftar'),
(2058,5507,'Prayoga401','1166455687','/start',61,'daftar'),
(2059,5508,'arishndra','363020451','/start',40,'unknown'),
(2060,5509,'Dianpuspitasukma','1006283833','/start',40,'unknown'),
(2061,5510,'pradnyaniwulan','425917481','/start',40,'unknown'),
(2062,5511,'Panjiw','428203128','/start',40,'unknown'),
(2063,5512,'Panjiw','428203128','/daftar',60,'daftar'),
(2064,5513,'Darmawandiki88','1693994291','/start',40,'unknown'),
(2065,5514,'Panjiw','428203128','/start',61,'daftar'),
(2066,5515,'Panjiw','428203128','start',40,'unknown'),
(2067,5516,'Krisnajnana','1267075998','/start',40,'unknown'),
(2068,5517,'Krisnajnana','1267075998','P',40,'unknown'),
(2069,5518,'Krisnajnana','1267075998','/start',40,'unknown'),
(2070,5519,'Mordekhaiyp','1786066848','/start',40,'unknown'),
(2071,5520,'Mordekhaiyp','1786066848','/start',40,'unknown'),
(2072,5521,'anandasatt','1899654102','/start',40,'unknown'),
(2073,5522,'Mordekhaiyp','1786066848','/daftar',60,'daftar'),
(2074,5523,'juliartarya','418166684','/start',40,'unknown'),
(2075,5524,'anandasatt','1899654102','/start',40,'unknown'),
(2076,5525,'juliartarya','418166684','/daftar',60,'daftar'),
(2077,5526,'anandasatt','1899654102','/start',40,'unknown'),
(2078,5527,'Mordekhaiyp','1786066848','/start',61,'daftar'),
(2079,5528,'Mordekhaiyp','1786066848','Start',40,'unknown'),
(2080,5529,'anandasatt','1899654102','start',40,'unknown'),
(2081,5530,'anandasatt','1899654102','/daftar',60,'daftar'),
(2082,5531,'anandasatt','1899654102','/daftar',61,'daftar'),
(2083,5532,'Mordekhaiyp','1786066848','/start',40,'unknown'),
(2084,5533,'pradnyaniwulan','425917481','/start',40,'unknown'),
(2085,5534,'Sinta07','319598851','/start',40,'unknown'),
(2086,5535,'Sinta07','319598851','/start',40,'unknown'),
(2087,5538,'andiprasta','378982159','/start',40,'unknown'),
(2088,5539,'pbnarendra','1115779223','/daftar',60,'daftar'),
(2089,5540,'Yaro2','695386385','/start',40,'unknown'),
(2090,5541,'pardena','564971043','/start',40,'unknown'),
(2091,5542,'pardena','564971043','/cekdaftar',70,'cekdaftar'),
(2092,5543,'mamam9999','1858966056','/start',40,'unknown'),
(2093,5544,'pardena','564971043','/daftar',60,'daftar'),
(2094,5545,'pardena','564971043','/start',61,'daftar'),
(2095,5546,'narapriyakamaha','1943487091','/start',40,'unknown'),
(2096,5547,'Prayoga401','1166455687','/start',40,'unknown'),
(2097,5548,'Odeeew','1424733372','/start',40,'unknown'),
(2098,5549,'kvnbrandon','1376712608','/start',40,'unknown'),
(2099,5550,'kvnbrandon','1376712608','/start',40,'unknown'),
(2100,5562,'Prayoga401','1166455687','1605512063',40,'unknown'),
(2101,5575,'Bangal88','1877191320','/start',40,'unknown'),
(2102,5577,'Dianpuspitasukma','1006283833','/cekdaftar',70,'cekdaftar'),
(2103,5582,'Panjiw','428203128','/daftar',60,'daftar'),
(2104,5586,'juliartarya','418166684','1705551031',61,'daftar'),
(2105,5588,'Dianpuspitasukma','1006283833','/daftar',60,'daftar'),
(2106,5601,'pardena','564971043','/daftar',60,'daftar'),
(2107,5602,'pardena','564971043','/daftar',61,'daftar'),
(2108,5605,'pardena','564971043','1519151052',40,'unknown'),
(2109,5607,'pardena','564971043','/daftar',60,'daftar'),
(2110,5611,'anandasatt','1899654102','/daftar',60,'daftar'),
(2111,5618,'Panjiw','428203128','1705551098',61,'daftar'),
(2112,5619,'andiprasta','378982159','/daftar',60,'daftar'),
(2113,5622,'juliartarya','418166684','/cekdaftar',70,'cekdaftar'),
(2114,5628,'anandasatt','1899654102','1705531069',61,'daftar'),
(2115,5630,'Panjiw','428203128','/cekdaftar',70,'cekdaftar'),
(2116,5632,'Prayoga401','1166455687','/daftar',60,'daftar'),
(2117,5635,'Aguspriska','384104973','/daftar',61,'daftar'),
(2118,5637,'Aguspriska','384104973','1981711024',40,'unknown'),
(2119,5639,'Dianpuspitasukma','1006283833','1705542008',61,'daftar'),
(2120,5640,'Aguspriska','384104973','/daftar',60,'daftar'),
(2121,5643,'Aguspriska','384104973','1981711024',61,'daftar'),
(2122,5644,'Dianpuspitasukma','1006283833','1705542008',40,'unknown'),
(2123,5645,'Aguspriska','384104973','/cekdaftar',70,'cekdaftar'),
(2124,5649,'Dianpuspitasukma','1006283833','/daftar',60,'daftar'),
(2125,5651,'Dianpuspitasukma','1006283833','1705542008',61,'daftar'),
(2126,5653,'Dianpuspitasukma','1006283833','/cekdaftar',70,'cekdaftar'),
(2127,5655,'Mordekhaiyp','1786066848','/daftar',60,'daftar'),
(2128,5656,'Dianpuspitasukma','1006283833','/daftar',60,'daftar'),
(2129,5659,'Mordekhaiyp','1786066848','1705531074',61,'daftar'),
(2130,5661,'Mordekhaiyp','1786066848','/cekdaftar',70,'cekdaftar'),
(2131,5662,'Dianpuspitasukma','1006283833','1705542008',61,'daftar'),
(2132,5665,'Dianpuspitasukma','1006283833','/daftar',60,'daftar'),
(2133,5667,'Dianpuspitasukma','1006283833','1705542008',61,'daftar'),
(2134,5669,'Dianpuspitasukma','1006283833','/daftar',60,'daftar'),
(2135,5670,'Odeeew','1424733372','/daftar',60,'daftar'),
(2136,5673,'Dianpuspitasukma','1006283833','1705542008',61,'daftar'),
(2137,5675,'Odeeew','1424733372','1705532005',61,'daftar'),
(2138,5677,'Odeeew','1424733372','/cekdaftar',70,'cekdaftar'),
(2139,5679,'martogitalenta','1269704556','/start',40,'unknown'),
(2140,5681,'martogitalenta','1269704556','/daftar',60,'daftar'),
(2141,5683,'martogitalenta','1269704556','1705511107',61,'daftar'),
(2142,5685,'martogitalenta','1269704556','/daftar',60,'daftar'),
(2143,5687,'martogitalenta','1269704556','1705511107',61,'daftar'),
(2144,5689,'martogitalenta','1269704556','/daftar',60,'daftar'),
(2145,5691,'martogitalenta','1269704556','1705511107',61,'daftar'),
(2146,5693,'martogitalenta','1269704556','/cekdaftar',70,'cekdaftar'),
(2147,5695,'martogitalenta','1269704556','/daftar',60,'daftar'),
(2148,5697,'martogitalenta','1269704556','1705511107',61,'daftar'),
(2149,5699,'pardena','564971043','1519151052',61,'daftar'),
(2150,5700,'arishndra','363020451','/daftar',60,'daftar'),
(2151,5703,'arishndra','363020451','1705552002',61,'daftar'),
(2152,5704,'pardena','564971043','/cekdaftar',70,'cekdaftar'),
(2153,5706,'arishndra','363020451','/cekdaftar',70,'cekdaftar'),
(2154,5709,'dekdwii','1073457868','/start',40,'unknown'),
(2155,5711,'dekdwii','1073457868','/daftar',60,'daftar'),
(2156,5712,'Sinta07','319598851','/daftar',60,'daftar'),
(2157,5714,'Sinta07','319598851','/cekdaftar',61,'daftar'),
(2158,5715,'dekdwii','1073457868','1705542012',61,'daftar'),
(2159,5719,'Sinta07','319598851','1504505033',40,'unknown'),
(2160,5721,'dekdwii','1073457868','/cekdaftar',70,'cekdaftar'),
(2161,5723,'dekdwii','1073457868','/daftar',60,'daftar'),
(2162,5724,'Sinta07','319598851','/cekdaftar',70,'cekdaftar'),
(2163,5727,'Sinta07','319598851','/daftar',60,'daftar'),
(2164,5728,'dekdwii','1073457868','1705542012',61,'daftar'),
(2165,5730,'Sinta07','319598851','1504505033',61,'daftar'),
(2166,5733,'Sinta07','319598851','/cekdaftar',70,'cekdaftar'),
(2167,5735,'dekdwii','1073457868','/daftar',60,'daftar'),
(2168,5737,'dekdwii','1073457868','1705542012',61,'daftar'),
(2169,5739,'dekdwii','1073457868','1705542012u',40,'unknown'),
(2170,5741,'dekdwii','1073457868','/daftar',60,'daftar'),
(2171,5743,'dekdwii','1073457868','170554201',61,'daftar'),
(2172,5745,'dekdwii','1073457868','1705542012',40,'unknown'),
(2173,5747,'dekdwii','1073457868','/daftar',60,'daftar'),
(2174,5749,'dekdwii','1073457868','1705542012',61,'daftar'),
(2175,5751,'anandasatt','1899654102','/cekdaftar',70,'cekdaftar'),
(2176,5754,'dekdwii','1073457868','/cekdaftar',70,'cekdaftar'),
(2177,5756,'dekdwii','1073457868','/daftar',60,'daftar'),
(2178,5758,'dekdwii','1073457868','1705542012',61,'daftar'),
(2179,5761,'trywiguna','383266280','/start',40,'unknown'),
(2180,5763,'trywiguna','383266280','/daftar',60,'daftar'),
(2181,5765,'trywiguna','383266280','1705551106',61,'daftar'),
(2182,5767,'Yaro2','695386385','/daftar',60,'daftar'),
(2183,5769,'Yaro2','695386385','1605521007',61,'daftar'),
(2184,5771,'dekdwii','1073457868','/start',40,'unknown'),
(2185,5772,'Yaro2','695386385','/cekdaftar',70,'cekdaftar'),
(2186,5774,'dekdwii','1073457868','/daftar',60,'daftar'),
(2187,5776,'trywiguna','383266280','1705551106',40,'unknown'),
(2188,5778,'trywiguna','383266280','/daftar',60,'daftar'),
(2189,5779,'dekdwii','1073457868','1705542012',61,'daftar'),
(2190,5781,'trywiguna','383266280','/daftar',61,'daftar'),
(2191,5785,'trywiguna','383266280','1705551106',40,'unknown'),
(2192,5787,'juliartarya','418166684','/daftar',60,'daftar'),
(2193,5788,'satyatamaa','1209420330','/start',40,'unknown'),
(2194,5789,'trywiguna','383266280','/daftar',60,'daftar'),
(2195,5791,'trywiguna','383266280','/daftar',61,'daftar'),
(2196,5792,'dekdwii','1073457868','/daftar',60,'daftar'),
(2197,5794,'trywiguna','383266280','/daftar',60,'daftar'),
(2198,5796,'trywiguna','383266280','/daftar',61,'daftar'),
(2199,5798,'trywiguna','383266280','1705551106',40,'unknown'),
(2200,5799,'juliartarya','418166684','1705551031',61,'daftar'),
(2201,5800,'satyatamaa','1209420330','/daftar',60,'daftar'),
(2202,5802,'dekdwii','1073457868','/start',61,'daftar'),
(2203,5804,'trywiguna','383266280','/cekdaftar',70,'cekdaftar'),
(2204,5806,'kvnbrandon','1376712608','/cekdaftar',70,'cekdaftar'),
(2205,5807,'dekdwii','1073457868','1705542012',40,'unknown'),
(2206,5809,'trywiguna','383266280','1705551106',40,'unknown'),
(2207,5811,'trywiguna','383266280','/daftar',60,'daftar'),
(2208,5816,'trywiguna','383266280','/daftar',61,'daftar'),
(2209,5818,'satyatamaa','1209420330','1705522001',61,'daftar'),
(2210,5820,'kvnbrandon','1376712608','/daftar',60,'daftar'),
(2211,5822,'dekdwii','1073457868','/daftar',60,'daftar'),
(2212,5823,'syazhrs','1233154199','/start',40,'unknown'),
(2213,5825,'trywiguna','383266280','/daftar',60,'daftar'),
(2214,5826,'trywiguna','383266280','/cekdaftar',61,'daftar'),
(2215,5828,'trywiguna','383266280','1705551106',40,'unknown'),
(2216,5834,'dekdwii','1073457868','1705542012',61,'daftar'),
(2217,5839,'syazhrs','1233154199','/daftar',60,'daftar'),
(2218,5842,'Dianpuspitasukma','1006283833','/daftar',60,'daftar'),
(2219,5843,'Ilisoft','870608984','/start',40,'unknown'),
(2220,5845,'syazhrs','1233154199','1705522033',61,'daftar'),
(2221,5846,'satyatamaa','1209420330','/daftar',60,'daftar'),
(2222,5848,'Dianpuspitasukma','1006283833','1705542008',61,'daftar'),
(2223,5849,'dekdwii','1073457868','/cekdaftar',70,'cekdaftar'),
(2224,5852,'Ilisoft','870608984','/daftar',60,'daftar'),
(2225,5854,'satyatamaa','1209420330','1705522001',61,'daftar'),
(2226,5857,'Ilisoft','870608984','1681711031',61,'daftar'),
(2227,5858,'mahardikaadi1','1920824968','/start',40,'unknown'),
(2228,5860,'dekdwii','1073457868','/daftar',60,'daftar'),
(2229,5864,'Ilisoft','870608984','/cekdaftar',70,'cekdaftar'),
(2230,5865,'mahardikaadi1','1920824968','/daftar',60,'daftar'),
(2231,5867,'dekdwii','1073457868','1705542012',61,'daftar'),
(2232,5869,'kvnbrandon','1376712608','1705531071',61,'daftar'),
(2233,5871,'mahardikaadi1','1920824968','1705522006',61,'daftar'),
(2234,5874,'kvnbrandon','1376712608','/daftar',60,'daftar'),
(2235,5876,'kvnbrandon','1376712608','1705531071',61,'daftar'),
(2236,5878,'yogasudharma','600446088','/daftar',60,'daftar'),
(2237,5880,'yogasudharma','600446088','1705541002',61,'daftar'),
(2238,5881,'kvnbrandon','1376712608','/cekdaftar',70,'cekdaftar'),
(2239,5883,'yogasudharma','600446088','/cekdaftar',70,'cekdaftar'),
(2240,5886,'kvnbrandon','1376712608','/daftar',60,'daftar'),
(2241,5888,'kvnbrandon','1376712608','1705531071',61,'daftar'),
(2242,5890,'kvnbrandon','1376712608','/daftar',60,'daftar'),
(2243,5892,'kvnbrandon','1376712608','1705531071',61,'daftar'),
(2244,5895,'kvnbrandon','1376712608','/start',40,'unknown'),
(2245,5897,'kvnbrandon','1376712608','/daftar',60,'daftar'),
(2246,5898,'Gungyoga','263720465','/start',40,'unknown'),
(2247,5900,'kvnbrandon','1376712608','1705531071',61,'daftar'),
(2248,5903,'narapriyakamaha','1943487091','/daftar',60,'daftar'),
(2249,5904,'Gungyoga','263720465','/daftar',60,'daftar'),
(2250,5906,'cuttasyay','1969407584','/start',40,'unknown'),
(2251,5908,'narapriyakamaha','1943487091','1504105111',61,'daftar'),
(2252,5910,'Gungyoga','263720465','1981511011',61,'daftar'),
(2253,5912,'kvnbrandon','1376712608','/daftar',60,'daftar'),
(2254,5914,'narapriyakamaha','1943487091','/cekdaftar',70,'cekdaftar'),
(2255,5915,'rianeka29','1929386317','/start',40,'unknown'),
(2256,5917,'cuttasyay','1969407584','/cekdaftar',70,'cekdaftar'),
(2257,5918,'kvnbrandon','1376712608','1705531071',61,'daftar'),
(2258,5920,'dharmawidya','1885736483','/start',40,'unknown'),
(2259,5921,'Gungyoga','263720465','/cekdaftar',70,'cekdaftar'),
(2260,5924,'rianeka29','1929386317','/daftar',60,'daftar'),
(2261,5926,'cuttasyay','1969407584','/daftar',60,'daftar'),
(2262,5930,'Gungyoga','263720465','/daftar',60,'daftar'),
(2263,5931,'dharmawidya','1885736483','/daftar',60,'daftar'),
(2264,5932,'rianeka29','1929386317','1605531083',61,'daftar'),
(2265,5935,'Mordekhaiyp','1786066848','/daftar',60,'daftar'),
(2266,5936,'cuttasyay','1969407584','1705531114',61,'daftar'),
(2267,5940,'dharmawidya','1885736483','1705522002',61,'daftar'),
(2268,5941,'Mordekhaiyp','1786066848','1705531074',61,'daftar'),
(2269,5943,'kvnbrandon','1376712608','/start',40,'unknown'),
(2270,5944,'Gungyoga','263720465','1981511011',61,'daftar'),
(2271,5945,'cuttasyay','1969407584','/cekdaftar',70,'cekdaftar'),
(2272,5948,'dharmawidya','1885736483','/cekdaftar',70,'cekdaftar'),
(2273,5949,'rianeka29','1929386317','/cekdaftar',70,'cekdaftar'),
(2274,5950,'Mordekhaiyp','1786066848','/cekdaftar',70,'cekdaftar'),
(2275,5954,'kvnbrandon','1376712608','/daftar',60,'daftar'),
(2276,5956,'dharmawidya','1885736483','Nice',40,'unknown'),
(2277,5959,'rianeka29','1929386317','/daftar',60,'daftar'),
(2278,5961,'kvnbrandon','1376712608','1705531071',61,'daftar'),
(2279,5965,'Darmawandiki88','1693994291','/cekdaftar',70,'cekdaftar'),
(2280,5967,'rianeka29','1929386317','1605531083',61,'daftar'),
(2281,5969,'Darmawandiki88','1693994291','/daftar',60,'daftar'),
(2282,5970,'rianeka29','1929386317','/daftar',60,'daftar'),
(2283,5973,'pradnyaniwulan','425917481','/daftar',60,'daftar'),
(2284,5974,'Darmawandiki88','1693994291','1705512019',61,'daftar'),
(2285,5976,'rianeka29','1929386317','1605531083',61,'daftar'),
(2286,5977,'pradnyaniwulan','425917481','1705552018',61,'daftar'),
(2287,5980,'pradnyaniwulan','425917481','/cekdaftar',70,'cekdaftar'),
(2288,5982,'pradnyaniwulan','425917481','/cekdaftar',70,'cekdaftar'),
(2289,5985,'Darmawandiki88','1693994291','/cekdaftar',70,'cekdaftar'),
(2290,5987,'juliartarya','418166684','/cekdaftar',70,'cekdaftar');

/*Table structure for table `tb_jawaban` */

DROP TABLE IF EXISTS `tb_jawaban`;

CREATE TABLE `tb_jawaban` (
  `id_jawaban` int(11) NOT NULL AUTO_INCREMENT,
  `id_alumni` int(11) NOT NULL,
  `id_detail_kuesioner` int(11) DEFAULT NULL,
  `jawaban` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_jawaban`),
  KEY `tb_jawaban_ibfk_1` (`id_alumni`),
  KEY `tb_jawaban_ibfk_2` (`id_detail_kuesioner`),
  CONSTRAINT `tb_jawaban_ibfk_1` FOREIGN KEY (`id_alumni`) REFERENCES `tb_alumni` (`id_alumni`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_jawaban_ibfk_2` FOREIGN KEY (`id_detail_kuesioner`) REFERENCES `tb_detail_kuesioner` (`id_detail_kuesioner`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_jawaban` */

/*Table structure for table `tb_jawaban_stakeholder` */

DROP TABLE IF EXISTS `tb_jawaban_stakeholder`;

CREATE TABLE `tb_jawaban_stakeholder` (
  `id_jawaban_stakeholder` int(11) NOT NULL AUTO_INCREMENT,
  `id_kuesioner_stakeholder` int(11) DEFAULT NULL,
  `id_stakeholder` int(11) DEFAULT NULL,
  `jawaban` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id_jawaban_stakeholder`),
  KEY `id_kuesioner_stackholder` (`id_kuesioner_stakeholder`),
  KEY `id_stakeholder` (`id_stakeholder`),
  CONSTRAINT `tb_jawaban_stakeholder_ibfk_1` FOREIGN KEY (`id_kuesioner_stakeholder`) REFERENCES `tb_kuesioner_stakeholder` (`id_kuesioner_stakeholder`),
  CONSTRAINT `tb_jawaban_stakeholder_ibfk_3` FOREIGN KEY (`id_stakeholder`) REFERENCES `tb_stakeholder` (`id_stakeholder`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_jawaban_stakeholder` */

insert  into `tb_jawaban_stakeholder`(`id_jawaban_stakeholder`,`id_kuesioner_stakeholder`,`id_stakeholder`,`jawaban`,`created_at`,`updated_at`,`deleted_at`) values 
(2,29,75,'Mantap Sekali Deh','2021-10-22 00:16:46','2021-10-21 17:16:45','0000-00-00 00:00:00'),
(3,30,75,'ya','2021-10-21 16:48:38','2021-10-21 16:48:38','0000-00-00 00:00:00'),
(4,55,75,'Sekali','2021-10-21 16:48:38','2021-10-21 16:48:38','0000-00-00 00:00:00'),
(5,56,75,'Deh','2021-10-21 16:48:38','2021-10-21 16:48:38','0000-00-00 00:00:00'),
(6,57,75,'Ci','2021-10-21 16:48:38','2021-10-21 16:48:38','0000-00-00 00:00:00'),
(7,58,75,'Kle','2021-10-21 16:48:38','2021-10-21 16:48:38','0000-00-00 00:00:00'),
(8,59,75,'n','2021-10-23 02:07:27','2021-10-22 19:07:25','0000-00-00 00:00:00'),
(9,29,75,'HEHE','2021-10-22 16:57:00','2021-10-22 16:57:00','0000-00-00 00:00:00'),
(10,30,75,'tidak','2021-10-22 16:57:04','2021-10-22 16:57:04','0000-00-00 00:00:00'),
(11,55,75,'HEHE','2021-10-22 16:57:07','2021-10-22 16:57:07','0000-00-00 00:00:00'),
(12,56,75,'HEHE','2021-10-22 16:57:08','2021-10-22 16:57:08','0000-00-00 00:00:00'),
(13,57,75,'Masuk','2021-10-22 16:57:09','2021-10-22 16:57:09','0000-00-00 00:00:00'),
(14,58,75,'21 Orang','2021-10-22 16:57:11','2021-10-22 16:57:11','0000-00-00 00:00:00'),
(15,59,75,'y','2021-10-22 16:57:12','2021-10-22 16:57:12','0000-00-00 00:00:00');

/*Table structure for table `tb_jenis_kuesioner` */

DROP TABLE IF EXISTS `tb_jenis_kuesioner`;

CREATE TABLE `tb_jenis_kuesioner` (
  `id_jenis` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_jenis_kuesioner` */

insert  into `tb_jenis_kuesioner`(`id_jenis`,`jenis`) values 
(1,'Pilihan Ganda'),
(2,'Jawab Singkat'),
(3,'Checkbox');

/*Table structure for table `tb_kota` */

DROP TABLE IF EXISTS `tb_kota`;

CREATE TABLE `tb_kota` (
  `id_kota` int(11) NOT NULL AUTO_INCREMENT,
  `id_provinsi` int(11) DEFAULT NULL,
  `nama_kota` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kota`),
  KEY `id_provinsi` (`id_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kota` */

/*Table structure for table `tb_kuesioner` */

DROP TABLE IF EXISTS `tb_kuesioner`;

CREATE TABLE `tb_kuesioner` (
  `id_kuesioner` int(11) NOT NULL AUTO_INCREMENT,
  `id_periode` int(11) DEFAULT NULL,
  `id_bank_soal` int(11) DEFAULT NULL,
  `type_kuesioner` varchar(255) DEFAULT NULL,
  `status` enum('Menunggu Konfirmasi','Konfirmasi','Ditolak') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_kuesioner`),
  KEY `id_periode` (`id_periode`),
  KEY `id_bank_soal` (`id_bank_soal`),
  CONSTRAINT `tb_kuesioner_ibfk_1` FOREIGN KEY (`id_periode`) REFERENCES `tb_periode_kuesioner` (`id_periode_kuesioner`),
  CONSTRAINT `tb_kuesioner_ibfk_2` FOREIGN KEY (`id_bank_soal`) REFERENCES `tb_soal_alumni` (`id_soal_alumni`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kuesioner` */

insert  into `tb_kuesioner`(`id_kuesioner`,`id_periode`,`id_bank_soal`,`type_kuesioner`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(58,9,4,'Bekerja Pada Perusahaan / Tempat Kerja','Menunggu Konfirmasi',NULL,NULL,NULL),
(59,9,6,'Mengelola Perusahaan Sendiri atau Berwirausaha','Menunggu Konfirmasi','2021-10-14 02:37:56','2021-10-14 02:37:56',NULL),
(60,9,7,'Melanjutkan Studi','Menunggu Konfirmasi','2021-10-14 02:37:56','2021-10-14 02:37:56',NULL),
(61,3,4,'Bekerja Pada Perusahaan atau tempat kerja','Menunggu Konfirmasi','2021-10-14 02:39:29','2021-10-23 06:06:45','2021-10-23 06:06:45'),
(62,3,6,'Mengelola Perusahaan Sendiri atau Berwirausaha','Menunggu Konfirmasi','2021-10-14 02:39:29','2021-10-23 06:06:36','2021-10-23 06:06:36'),
(63,3,7,'Melanjutkan Studi','Menunggu Konfirmasi','2021-10-14 02:39:29','2021-10-23 06:06:54','2021-10-23 06:06:54'),
(64,10,4,'Bekerja Pada Perusahaan atau tempat kerja','Menunggu Konfirmasi','2021-10-14 02:44:24','2021-11-07 03:28:26','2021-11-07 03:28:26'),
(65,10,6,'Mengelola Perusahaan Sendiri atau Berwirausaha','Menunggu Konfirmasi','2021-10-14 02:44:25','2021-11-07 03:28:30','2021-11-07 03:28:30'),
(66,10,7,'Melanjutkan Studi','Menunggu Konfirmasi','2021-10-14 02:44:25','2021-11-07 03:28:35','2021-11-07 03:28:35'),
(67,8,4,'Bekerja Pada Perusahaan atau tempat kerja','Menunggu Konfirmasi','2021-10-14 02:47:49','2021-10-14 02:47:49',NULL),
(68,8,6,'Mengelola Perusahaan Sendiri atau Berwirausaha','Menunggu Konfirmasi','2021-10-14 02:47:50','2021-10-14 02:47:50',NULL),
(69,8,7,'Melanjutkan Studi','Menunggu Konfirmasi','2021-10-14 02:47:50','2021-10-14 02:47:50',NULL),
(70,3,7,'aaa','Menunggu Konfirmasi','2021-10-16 12:01:54','2021-10-16 12:02:44','2021-10-16 12:02:44'),
(71,3,7,'Sekolah','Menunggu Konfirmasi','2021-10-16 12:04:11','2021-10-16 12:13:18','2021-10-16 12:13:18'),
(72,3,9,'bank soal baru','Menunggu Konfirmasi','2021-10-16 12:16:35','2021-10-23 05:50:12','2021-10-23 05:50:12'),
(73,3,9,'test','Menunggu Konfirmasi','2021-10-23 06:06:20','2021-10-23 06:07:03','2021-10-23 06:07:03'),
(74,4,4,'Bekerja Pada Perusahaan atau tempat kerja','Menunggu Konfirmasi','2021-10-23 06:07:59','2021-10-23 06:07:59',NULL),
(75,4,6,'Mengelola Perusahaan Sendiri atau Berwirausaha','Menunggu Konfirmasi','2021-10-23 06:07:59','2021-10-23 06:07:59',NULL),
(76,4,7,'Melanjutkan Studi','Menunggu Konfirmasi','2021-10-23 06:08:00','2021-10-23 06:08:00',NULL),
(77,10,7,'periode 2021 - 6','Menunggu Konfirmasi','2021-10-24 07:04:33','2021-11-07 03:28:38','2021-11-07 03:28:38'),
(78,10,NULL,'periode 2021 - 6 (2)','Menunggu Konfirmasi','2021-10-24 07:08:08','2021-11-07 03:28:42','2021-11-07 03:28:42'),
(79,3,NULL,'test','Menunggu Konfirmasi','2021-10-24 07:16:33','2021-10-24 07:16:33',NULL),
(86,3,NULL,'2021 periode 7','Menunggu Konfirmasi','2021-10-24 08:25:30','2021-10-24 08:25:30',NULL),
(87,3,NULL,'2021 periode 7','Menunggu Konfirmasi','2021-10-24 08:27:25','2021-10-24 08:27:25',NULL),
(88,3,NULL,'2021 periode 7','Menunggu Konfirmasi','2021-10-24 08:28:05','2021-10-24 08:28:05',NULL),
(90,NULL,NULL,'abc 2021 7','Menunggu Konfirmasi','2021-10-24 08:31:32','2021-10-24 08:31:32',NULL),
(91,5,NULL,NULL,NULL,NULL,NULL,NULL),
(98,NULL,NULL,'2021 periode 7','Menunggu Konfirmasi','2021-10-24 09:16:42','2021-10-24 09:16:42',NULL),
(99,NULL,NULL,'2021 periode 7','Menunggu Konfirmasi','2021-10-24 09:17:50','2021-10-24 09:17:50',NULL),
(100,9,NULL,'new kuesioner baru banget','Menunggu Konfirmasi','2021-10-24 09:20:42','2021-11-07 02:42:06','2021-11-07 02:42:06'),
(101,9,NULL,'2021 periode 7','Menunggu Konfirmasi','2021-10-28 07:12:52','2021-10-28 07:12:59','2021-10-28 07:12:59'),
(102,9,NULL,'2021 periode 7','Menunggu Konfirmasi','2021-10-28 07:13:51','2021-10-28 07:13:55','2021-10-28 07:13:55');

/*Table structure for table `tb_kuesioner_stakeholder` */

DROP TABLE IF EXISTS `tb_kuesioner_stakeholder`;

CREATE TABLE `tb_kuesioner_stakeholder` (
  `id_kuesioner_stakeholder` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis` int(11) DEFAULT NULL,
  `id_prodi` int(11) DEFAULT NULL COMMENT '1=ganda,2=singkat,3=checkbox,4=tanggal',
  `id_tahun_periode` int(11) DEFAULT NULL,
  `pertanyaan` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `status` enum('Menunggu Konfirmasi','Konfirmasi','Ditolak') DEFAULT NULL,
  `id_bank_soal` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_kuesioner_stakeholder`),
  KEY `id_jenis` (`id_jenis`),
  KEY `id_prodi` (`id_prodi`),
  KEY `id_tahun_periode` (`id_tahun_periode`),
  KEY `id_bank_soal` (`id_bank_soal`),
  CONSTRAINT `tb_kuesioner_stakeholder_ibfk_2` FOREIGN KEY (`id_prodi`) REFERENCES `tb_prodi` (`id_prodi`),
  CONSTRAINT `tb_kuesioner_stakeholder_ibfk_3` FOREIGN KEY (`id_tahun_periode`) REFERENCES `tb_tahun_periode` (`id_tahun_periode`),
  CONSTRAINT `tb_kuesioner_stakeholder_ibfk_4` FOREIGN KEY (`id_bank_soal`) REFERENCES `tb_soal_stakeholder` (`id_soal_stakeholder`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 CHECKSUM=1 DELAY_KEY_WRITE=1;

/*Data for the table `tb_kuesioner_stakeholder` */

insert  into `tb_kuesioner_stakeholder`(`id_kuesioner_stakeholder`,`id_jenis`,`id_prodi`,`id_tahun_periode`,`pertanyaan`,`status`,`id_bank_soal`,`created_at`,`updated_at`,`deleted_at`) values 
(1,2,1,6,'123Silakan memberi penjelasan dalam bentuk uraian tentang kepuasan terhadap alumni PSTM UNUD, dan mohon saran tentang skill dan kompetensi yang perlu ditambahkan untuk bisa bekerja di perusahaan anda saat ini.','Menunggu Konfirmasi',17,'2021-10-16 23:22:55','2021-10-28 08:59:59',NULL),
(18,2,1,2,'Setelah lulus apaka','Menunggu Konfirmasi',NULL,'2021-10-31 03:06:46','2021-10-31 05:41:57','2021-10-31 05:41:57'),
(19,2,1,6,'aabbaqtestaaas','Menunggu Konfirmasi',19,'2021-10-28 09:01:52','2021-10-29 15:24:56',NULL),
(20,1,1,6,'test',NULL,NULL,'2021-10-07 08:03:26','2021-10-07 08:22:27',NULL),
(22,1,1,5,'prodi elektro',NULL,NULL,'2021-10-09 08:57:29','2021-10-09 08:57:29',NULL),
(23,1,2,6,'elektro',NULL,NULL,'2021-10-09 08:57:57','2021-10-09 08:57:57',NULL),
(24,2,2,2,'test',NULL,NULL,'2021-10-09 08:58:17','2021-10-23 06:12:16','2021-10-23 06:12:16'),
(25,2,1,6,'hehe',NULL,NULL,'2021-10-14 09:32:06','2021-10-15 07:19:05','2021-10-15 07:19:05'),
(26,2,1,6,'sdgsdgs',NULL,NULL,'2021-10-14 09:34:11','2021-10-15 13:45:47','2021-10-15 13:45:47'),
(27,1,1,6,'hehe',NULL,NULL,'2021-10-14 09:35:53','2021-10-15 07:19:13','2021-10-15 07:19:13'),
(28,1,1,6,'wkwk',NULL,NULL,'2021-10-14 09:36:08','2021-10-15 14:58:39','2021-10-15 14:58:39'),
(29,2,1,6,'haha',NULL,NULL,'2021-10-14 09:38:01','2021-10-14 09:38:01',NULL),
(30,1,1,6,'xixixi',NULL,NULL,'2021-10-14 09:39:45','2021-10-14 09:39:45',NULL),
(31,1,2,6,'nama pengisi',NULL,1,'2021-10-14 10:33:28','2021-10-14 10:33:28',NULL),
(48,1,8,6,'test1',NULL,6,'2021-10-14 10:57:15','2021-10-14 10:57:15',NULL),
(49,2,1,2,'nama pengisi',NULL,1,'2021-10-15 03:17:32','2021-10-16 13:22:16','2021-10-16 13:22:16'),
(50,1,1,2,'haha',NULL,2,'2021-10-15 03:17:32','2021-10-16 13:22:25','2021-10-16 13:22:25'),
(51,1,1,2,'haha',NULL,3,'2021-10-15 03:17:32','2021-10-16 13:22:33','2021-10-16 13:22:33'),
(52,1,1,2,'test',NULL,4,'2021-10-15 03:17:33','2021-10-16 13:22:39','2021-10-16 13:22:39'),
(53,1,1,2,'Jumlah Karyawan / Staff',NULL,5,'2021-10-15 03:17:33','2021-10-16 13:22:46','2021-10-16 13:22:46'),
(54,1,1,2,'test1',NULL,6,'2021-10-15 03:17:33','2021-10-16 13:22:58','2021-10-16 13:22:58'),
(55,2,1,6,'haha',NULL,2,'2021-10-15 07:19:34','2021-10-15 07:19:34',NULL),
(56,2,1,6,'haha',NULL,3,'2021-10-15 07:19:34','2021-10-15 07:19:34',NULL),
(57,2,1,6,'test',NULL,4,'2021-10-15 07:19:35','2021-10-15 07:19:35',NULL),
(58,2,1,6,'Jumlah Karyawan / Staff',NULL,5,'2021-10-15 07:19:35','2021-10-15 07:19:35',NULL),
(59,1,1,6,'test1',NULL,6,'2021-10-15 07:19:35','2021-10-15 07:19:35',NULL),
(60,2,1,2,'qwerty',NULL,NULL,'2021-10-16 13:01:13','2021-10-16 13:23:06','2021-10-16 13:23:06'),
(61,1,1,2,'Etika',NULL,7,'2021-10-16 23:22:09','2021-10-16 23:22:09',NULL),
(62,1,1,2,'Keahlian Pada Bidang Ilmu (Kompetensi Utama)',NULL,11,'2021-10-16 23:22:10','2021-10-16 23:22:10',NULL),
(63,1,1,2,'Kemampuan Berbahasa Asing',NULL,12,'2021-10-16 23:22:10','2021-10-16 23:22:10',NULL),
(64,1,1,2,'Penggunaan Teknologi Informasi',NULL,13,'2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(65,1,1,2,'Kemampuan berkomunikasi',NULL,14,'2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(66,1,1,2,'Kerjasama tim',NULL,15,'2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(67,1,1,2,'Pengembangan diri',NULL,16,'2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(68,2,1,2,'Silakan memberi penjelasan dalam bentuk uraian tentang kepuasan terhadap alumni PSTM UNUD, dan mohon saran tentang skill dan kompetensi yang perlu ditambahkan untuk bisa bekerja di perusahaan anda saat ini.',NULL,17,'2021-10-16 23:22:13','2021-10-16 23:22:44','2021-10-16 23:22:44'),
(69,1,1,2,'Pengembangan diri',NULL,18,'2021-10-16 23:22:13','2021-10-16 23:22:13',NULL),
(71,1,1,9,'Etika',NULL,7,'2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(72,1,1,9,'Keahlian Pada Bidang Ilmu (Kompetensi Utama)',NULL,11,'2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(73,1,1,9,'Kemampuan Berbahasa Asing',NULL,12,'2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(74,1,1,9,'Penggunaan Teknologi Informasi',NULL,13,'2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(75,1,1,9,'Kemampuan berkomunikasi',NULL,14,'2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(76,1,1,9,'Kerjasama tim',NULL,15,'2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(77,1,1,9,'Pengembangan diri',NULL,16,'2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(78,2,1,9,'Silakan memberi penjelasan dalam bentuk uraian tentang kepuasan terhadap alumni PSTM UNUD, dan mohon saran tentang skill dan kompetensi yang perlu ditambahkan untuk bisa bekerja di perusahaan anda saat ini.',NULL,17,'2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(79,1,1,9,'Pengembangan diri',NULL,18,'2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(81,2,1,9,'aa',NULL,NULL,'2021-10-28 07:31:49','2021-10-28 07:50:27','2021-10-28 07:50:27'),
(82,2,1,9,'aa',NULL,NULL,'2021-10-28 07:52:53','2021-10-28 07:52:53',NULL),
(83,2,1,2,'Silakan memberi penjelasan dalam bentuk uraian tentang kepuasan terhadap alumni PSTM UNUD, dan mohon saran tentang skill dan kompetensi yang perlu ditambahkan untuk bisa bekerja di perusahaan anda saat ini.',NULL,17,'2021-10-28 09:01:52','2021-10-28 09:01:52',NULL),
(85,2,1,6,'aab','Menunggu Konfirmasi',19,'2021-10-28 07:24:16','2021-10-28 07:31:24',NULL),
(89,1,1,2,'createopsi',NULL,NULL,'2021-10-31 02:55:22','2021-10-31 05:42:24','2021-10-31 05:42:24');

/*Table structure for table `tb_lowongan` */

DROP TABLE IF EXISTS `tb_lowongan`;

CREATE TABLE `tb_lowongan` (
  `id_lowongan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  `jenis_pekerjaan` varchar(255) DEFAULT NULL,
  `tgl_post` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `lampiran_name` varchar(255) DEFAULT NULL,
  `thumbnail_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `lowongan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_lowongan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_lowongan` */

insert  into `tb_lowongan`(`id_lowongan`,`nama_perusahaan`,`jenis_pekerjaan`,`tgl_post`,`keterangan`,`lampiran`,`thumbnail`,`lampiran_name`,`thumbnail_name`,`created_at`,`updated_at`,`deleted_at`,`lowongan`) values 
(6,'Teknik Unud','Web Developer',NULL,NULL,'/storage/file/posts//Book1.xlsx','/storage/image/lowongan//Yw-VsZvZ.jpg','Book1.xlsx','Yw-VsZvZ.jpg','2021-09-08 14:43:36','2021-11-07 11:46:01',NULL,'\n');

/*Table structure for table `tb_master_kuesioner` */

DROP TABLE IF EXISTS `tb_master_kuesioner`;

CREATE TABLE `tb_master_kuesioner` (
  `id_master` int(11) NOT NULL AUTO_INCREMENT,
  `id prodi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_master`),
  KEY `id prodi` (`id prodi`),
  CONSTRAINT `tb_master_kuesioner_ibfk_1` FOREIGN KEY (`id prodi`) REFERENCES `tb_prodi` (`id_prodi`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_master_kuesioner` */

insert  into `tb_master_kuesioner`(`id_master`,`id prodi`) values 
(1,1),
(2,2),
(3,3),
(4,4),
(5,5),
(6,6),
(7,8);

/*Table structure for table `tb_notifikasi` */

DROP TABLE IF EXISTS `tb_notifikasi`;

CREATE TABLE `tb_notifikasi` (
  `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT,
  `id_alumni` int(11) DEFAULT NULL,
  `notifikasi` text DEFAULT NULL,
  `notifikasi_unique` varchar(32) NOT NULL,
  `status` enum('Ditolak','Menunggu Konfirmasi','Diterima') DEFAULT NULL,
  `flag` enum('1','0') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_notifikasi`),
  KEY `id_alumni` (`id_alumni`),
  CONSTRAINT `tb_notifikasi_ibfk_1` FOREIGN KEY (`id_alumni`) REFERENCES `tb_alumni` (`id_alumni`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_notifikasi` */

/*Table structure for table `tb_opsi` */

DROP TABLE IF EXISTS `tb_opsi`;

CREATE TABLE `tb_opsi` (
  `id_opsi` int(11) NOT NULL AUTO_INCREMENT,
  `opsi` varchar(255) DEFAULT NULL,
  `id_detail_kuesioner` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_opsi`),
  KEY `tb_opsi_ibfk_1` (`id_detail_kuesioner`),
  CONSTRAINT `tb_opsi_ibfk_1` FOREIGN KEY (`id_detail_kuesioner`) REFERENCES `tb_detail_kuesioner` (`id_detail_kuesioner`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_opsi` */

insert  into `tb_opsi`(`id_opsi`,`opsi`,`id_detail_kuesioner`,`created_at`,`updated_at`,`deleted_at`) values 
(222,'Ya',NULL,'2021-10-13 11:39:56','2021-10-13 11:39:56',NULL),
(223,'Tidak',NULL,'2021-10-13 11:39:56','2021-10-13 11:39:56',NULL),
(234,'1',179,'2021-10-22 17:09:11','2021-10-22 17:09:11',NULL),
(235,'2',179,'2021-10-22 17:09:11','2021-10-22 17:09:11',NULL),
(236,'3',179,'2021-10-22 17:09:11','2021-10-22 17:09:11',NULL),
(237,'4',179,'2021-10-22 17:09:11','2021-10-22 17:09:11',NULL),
(238,'1',180,'2021-10-22 17:12:27','2021-10-22 17:12:27',NULL),
(239,'2',180,'2021-10-22 17:12:27','2021-10-22 17:12:27',NULL),
(240,'3',180,'2021-10-22 17:12:27','2021-10-22 17:12:27',NULL),
(241,'4',180,'2021-10-22 17:12:27','2021-10-22 17:12:27',NULL),
(242,'Ya',186,'2021-10-28 07:16:40','2021-10-28 07:18:23','2021-10-28 07:18:23'),
(243,'Tidak',186,'2021-10-28 07:16:40','2021-10-28 07:18:23','2021-10-28 07:18:23');

/*Table structure for table `tb_opsi_bank_soal_alumni` */

DROP TABLE IF EXISTS `tb_opsi_bank_soal_alumni`;

CREATE TABLE `tb_opsi_bank_soal_alumni` (
  `id_opsi_bank_soal_alumni` int(11) NOT NULL AUTO_INCREMENT,
  `id_soal_alumni` int(11) DEFAULT NULL,
  `opsi` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_opsi_bank_soal_alumni`),
  KEY `tb_opsi_bank_soal_alumni_ibfk_1` (`id_soal_alumni`),
  CONSTRAINT `tb_opsi_bank_soal_alumni_ibfk_1` FOREIGN KEY (`id_soal_alumni`) REFERENCES `tb_detail_soal_alumni` (`id_detail_soal_alumni`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_opsi_bank_soal_alumni` */

insert  into `tb_opsi_bank_soal_alumni`(`id_opsi_bank_soal_alumni`,`id_soal_alumni`,`opsi`,`created_at`,`updated_at`,`deleted_at`) values 
(6,10,'Ya','2021-10-13 11:21:51','2021-10-13 11:21:51',NULL),
(7,10,'Tidak','2021-10-13 11:21:51','2021-10-13 11:21:51',NULL),
(8,12,'ya','2021-10-13 11:50:38','2021-10-13 11:50:38',NULL),
(9,12,'tidak','2021-10-13 11:50:39','2021-10-13 11:50:39',NULL),
(10,13,'1','2021-10-13 11:52:27','2021-10-13 11:52:27',NULL),
(11,13,'2','2021-10-13 11:52:27','2021-10-13 11:52:27',NULL),
(12,25,'1','2021-10-28 12:56:52','2021-10-28 12:56:52',NULL),
(13,25,'2','2021-10-28 12:56:52','2021-10-28 12:56:52',NULL),
(16,24,'1','2021-10-28 13:17:07','2021-10-28 13:17:20','2021-10-28 13:17:20'),
(17,24,'2','2021-10-28 13:17:08','2021-10-28 13:17:20','2021-10-28 13:17:20'),
(18,24,'1ya','2021-10-28 13:17:20','2021-10-28 13:17:20',NULL),
(19,24,'2tidak','2021-10-28 13:17:20','2021-10-28 13:17:20',NULL);

/*Table structure for table `tb_opsi_soal_stakeholder` */

DROP TABLE IF EXISTS `tb_opsi_soal_stakeholder`;

CREATE TABLE `tb_opsi_soal_stakeholder` (
  `id_opsi_soal_stakeholder` int(11) NOT NULL AUTO_INCREMENT,
  `id_soal_stakeholder` int(11) DEFAULT NULL,
  `opsi` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_opsi_soal_stakeholder`),
  KEY `id_soal_pengguna` (`id_soal_stakeholder`),
  CONSTRAINT `tb_opsi_soal_stakeholder_ibfk_1` FOREIGN KEY (`id_soal_stakeholder`) REFERENCES `tb_soal_stakeholder` (`id_soal_stakeholder`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_opsi_soal_stakeholder` */

insert  into `tb_opsi_soal_stakeholder`(`id_opsi_soal_stakeholder`,`id_soal_stakeholder`,`opsi`,`created_at`,`updated_at`,`deleted_at`) values 
(1,6,'y','2021-10-14 10:42:02','2021-10-14 10:42:02',NULL),
(2,6,'n','2021-10-14 10:42:02','2021-10-14 10:42:02',NULL),
(3,7,'Sangat Baik','2021-10-16 12:42:39','2021-10-16 12:42:39',NULL),
(4,7,'Baik','2021-10-16 12:42:39','2021-10-16 12:42:39',NULL),
(5,7,'Cukup','2021-10-16 12:42:39','2021-10-16 12:42:39',NULL),
(6,7,'Kurang','2021-10-16 12:42:39','2021-10-16 12:42:39',NULL),
(7,7,'kurang Sekali','2021-10-16 12:42:39','2021-10-16 12:42:39',NULL),
(8,11,'Sangat Baik','2021-10-16 13:09:44','2021-10-16 13:09:44',NULL),
(9,11,'Baik','2021-10-16 13:09:44','2021-10-16 13:09:44',NULL),
(10,11,'Cukup','2021-10-16 13:09:44','2021-10-16 13:09:44',NULL),
(11,11,'Kurang','2021-10-16 13:09:45','2021-10-16 13:09:45',NULL),
(12,11,'kurang Sekali','2021-10-16 13:09:45','2021-10-16 13:09:45',NULL),
(13,12,'Sangat Baik','2021-10-16 13:10:20','2021-10-16 13:10:20',NULL),
(14,12,'Baik','2021-10-16 13:10:20','2021-10-16 13:10:20',NULL),
(15,12,'Cukup','2021-10-16 13:10:21','2021-10-16 13:10:21',NULL),
(16,12,'Kurang','2021-10-16 13:10:21','2021-10-16 13:10:21',NULL),
(17,12,'kurang Sekali','2021-10-16 13:10:21','2021-10-16 13:10:21',NULL),
(18,13,'Sangat Baik','2021-10-16 13:11:01','2021-10-16 13:11:01',NULL),
(19,13,'Baik','2021-10-16 13:11:01','2021-10-16 13:11:01',NULL),
(20,13,'Cukup','2021-10-16 13:11:01','2021-10-16 13:11:01',NULL),
(21,13,'Kurang','2021-10-16 13:11:03','2021-10-16 13:11:03',NULL),
(22,13,'kurang Sekali','2021-10-16 13:11:03','2021-10-16 13:11:03',NULL),
(23,14,'Sangat Baik','2021-10-16 13:11:40','2021-10-16 13:11:40',NULL),
(24,14,'Baik','2021-10-16 13:11:40','2021-10-16 13:11:40',NULL),
(25,14,'Cukup','2021-10-16 13:11:41','2021-10-16 13:11:41',NULL),
(26,14,'Kurang','2021-10-16 13:11:41','2021-10-16 13:11:41',NULL),
(27,14,'kurang Sekali','2021-10-16 13:11:41','2021-10-16 13:11:41',NULL),
(28,15,'Sangat Baik','2021-10-16 13:12:12','2021-10-16 13:12:12',NULL),
(29,15,'Baik','2021-10-16 13:12:13','2021-10-16 13:12:13',NULL),
(30,15,'Cukup','2021-10-16 13:12:13','2021-10-16 13:12:13',NULL),
(31,15,'Kurang','2021-10-16 13:12:13','2021-10-16 13:12:13',NULL),
(32,15,'kurang Sekali','2021-10-16 13:12:13','2021-10-16 13:12:13',NULL),
(33,16,'Sangat Baik','2021-10-16 13:20:30','2021-10-16 13:20:30',NULL),
(34,16,'Baik','2021-10-16 13:20:31','2021-10-16 13:20:31',NULL),
(35,16,'Cukup','2021-10-16 13:20:33','2021-10-16 13:20:33',NULL),
(36,16,'Kurang','2021-10-16 13:20:33','2021-10-16 13:20:33',NULL),
(37,16,'kurang Sekali','2021-10-16 13:20:33','2021-10-16 13:20:33',NULL),
(38,18,'Sangat Baik','2021-10-16 13:33:28','2021-10-16 13:33:28',NULL),
(39,18,'Baik','2021-10-16 13:33:28','2021-10-16 13:33:28',NULL),
(40,18,'Cukup','2021-10-16 13:33:29','2021-10-16 13:33:29',NULL),
(41,18,'Kurang','2021-10-16 13:33:30','2021-10-16 13:33:30',NULL),
(42,18,'kurang Sekali','2021-10-16 13:34:05','2021-10-16 13:34:05',NULL),
(43,22,'a','2021-10-28 11:42:26','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(44,22,'b','2021-10-28 11:42:26','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(45,22,'bv','2021-10-28 11:42:27','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(46,22,'a','2021-10-28 11:43:55','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(47,22,'b','2021-10-28 11:43:55','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(48,22,'bv','2021-10-28 11:43:55','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(49,22,'a','2021-10-28 11:44:31','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(50,22,'b','2021-10-28 11:44:31','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(51,22,'bv','2021-10-28 11:44:31','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(52,22,'a','2021-10-28 11:44:31','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(53,22,'b','2021-10-28 11:44:31','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(54,22,'bv','2021-10-28 11:44:31','2021-10-28 11:44:46','2021-10-28 11:44:46'),
(55,22,'a','2021-10-28 11:44:46','2021-10-28 11:44:46',NULL),
(56,22,'b','2021-10-28 11:44:46','2021-10-28 11:44:46',NULL),
(57,22,'bv','2021-10-28 11:44:46','2021-10-28 11:44:46',NULL),
(58,22,'a','2021-10-28 11:44:46','2021-10-28 11:44:46',NULL),
(59,22,'b','2021-10-28 11:44:46','2021-10-28 11:44:46',NULL),
(60,22,'bv','2021-10-28 11:44:46','2021-10-28 11:44:46',NULL),
(61,26,'1','2021-10-28 13:22:36','2021-11-07 10:30:47','2021-11-07 10:30:47'),
(62,26,'12','2021-10-28 13:22:36','2021-11-07 10:30:47','2021-11-07 10:30:47');

/*Table structure for table `tb_opsi_stakeholder` */

DROP TABLE IF EXISTS `tb_opsi_stakeholder`;

CREATE TABLE `tb_opsi_stakeholder` (
  `id_opsi_stakeholder` int(11) NOT NULL AUTO_INCREMENT,
  `id_soal_pengguna` int(11) DEFAULT NULL,
  `opsi` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_opsi_stakeholder`),
  KEY `id_kuesioner_stackholder` (`id_soal_pengguna`),
  CONSTRAINT `tb_opsi_stakeholder_ibfk_1` FOREIGN KEY (`id_soal_pengguna`) REFERENCES `tb_kuesioner_stakeholder` (`id_kuesioner_stakeholder`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_opsi_stakeholder` */

insert  into `tb_opsi_stakeholder`(`id_opsi_stakeholder`,`id_soal_pengguna`,`opsi`,`created_at`,`updated_at`,`deleted_at`) values 
(4,20,'1','2021-10-07 08:03:27','2021-10-07 08:22:28','2021-10-07 08:22:28'),
(5,20,'2','2021-10-07 08:03:27','2021-10-07 08:22:28','2021-10-07 08:22:28'),
(6,22,'3','2021-10-09 08:57:29','2021-10-09 08:57:29',NULL),
(7,22,'4','2021-10-09 08:57:29','2021-10-09 08:57:29',NULL),
(8,23,'5','2021-10-09 08:57:58','2021-10-09 08:57:58',NULL),
(9,23,'6','2021-10-09 08:57:58','2021-10-09 08:57:58',NULL),
(10,27,'a','2021-10-14 09:35:53','2021-10-14 09:35:53',NULL),
(11,27,'b','2021-10-14 09:35:53','2021-10-14 09:35:53',NULL),
(12,28,'a','2021-10-14 09:36:09','2021-10-14 09:36:09',NULL),
(13,28,'b','2021-10-14 09:36:09','2021-10-14 09:36:09',NULL),
(14,30,'ya','2021-10-14 09:39:45','2021-10-14 09:39:45',NULL),
(15,30,'tidak','2021-10-14 09:39:45','2021-10-14 09:39:45',NULL),
(16,48,'y','2021-10-14 10:57:15','2021-10-14 10:57:15',NULL),
(17,48,'n','2021-10-14 10:57:15','2021-10-14 10:57:15',NULL),
(18,54,'y','2021-10-15 03:17:34','2021-10-15 03:17:34',NULL),
(19,54,'n','2021-10-15 03:17:34','2021-10-15 03:17:34',NULL),
(20,59,'y','2021-10-15 07:19:35','2021-10-15 07:19:35',NULL),
(21,59,'n','2021-10-15 07:19:36','2021-10-15 07:19:36',NULL),
(22,61,'Sangat Baik','2021-10-16 23:22:09','2021-10-16 23:22:09',NULL),
(23,61,'Baik','2021-10-16 23:22:09','2021-10-16 23:22:09',NULL),
(24,61,'Cukup','2021-10-16 23:22:09','2021-10-16 23:22:09',NULL),
(25,61,'Kurang','2021-10-16 23:22:09','2021-10-16 23:22:09',NULL),
(26,61,'kurang Sekali','2021-10-16 23:22:10','2021-10-16 23:22:10',NULL),
(27,62,'Sangat Baik','2021-10-16 23:22:10','2021-10-16 23:22:10',NULL),
(28,62,'Baik','2021-10-16 23:22:10','2021-10-16 23:22:10',NULL),
(29,62,'Cukup','2021-10-16 23:22:10','2021-10-16 23:22:10',NULL),
(30,62,'Kurang','2021-10-16 23:22:10','2021-10-16 23:22:10',NULL),
(31,62,'kurang Sekali','2021-10-16 23:22:10','2021-10-16 23:22:10',NULL),
(32,63,'Sangat Baik','2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(33,63,'Baik','2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(34,63,'Cukup','2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(35,63,'Kurang','2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(36,63,'kurang Sekali','2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(37,64,'Sangat Baik','2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(38,64,'Baik','2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(39,64,'Cukup','2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(40,64,'Kurang','2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(41,64,'kurang Sekali','2021-10-16 23:22:11','2021-10-16 23:22:11',NULL),
(42,65,'Sangat Baik','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(43,65,'Baik','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(44,65,'Cukup','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(45,65,'Kurang','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(46,65,'kurang Sekali','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(47,66,'Sangat Baik','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(48,66,'Baik','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(49,66,'Cukup','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(50,66,'Kurang','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(51,66,'kurang Sekali','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(52,67,'Sangat Baik','2021-10-16 23:22:12','2021-10-16 23:22:12',NULL),
(53,67,'Baik','2021-10-16 23:22:13','2021-10-16 23:22:13',NULL),
(54,67,'Cukup','2021-10-16 23:22:13','2021-10-16 23:22:13',NULL),
(55,67,'Kurang','2021-10-16 23:22:13','2021-10-16 23:22:13',NULL),
(56,67,'kurang Sekali','2021-10-16 23:22:13','2021-10-16 23:22:13',NULL),
(57,69,'Sangat Baik','2021-10-16 23:22:13','2021-10-16 23:22:13',NULL),
(58,69,'Baik','2021-10-16 23:22:13','2021-10-16 23:22:13',NULL),
(59,69,'Cukup','2021-10-16 23:22:13','2021-10-16 23:22:13',NULL),
(60,69,'Kurang','2021-10-16 23:22:13','2021-10-16 23:22:13',NULL),
(61,69,'kurang Sekali','2021-10-16 23:22:13','2021-10-16 23:22:13',NULL),
(62,71,'Sangat Baik','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(63,71,'Baik','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(64,71,'Cukup','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(65,71,'Kurang','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(66,71,'kurang Sekali','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(67,72,'Sangat Baik','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(68,72,'Baik','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(69,72,'Cukup','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(70,72,'Kurang','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(71,72,'kurang Sekali','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(72,73,'Sangat Baik','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(73,73,'Baik','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(74,73,'Cukup','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(75,73,'Kurang','2021-10-28 07:24:13','2021-10-28 07:24:13',NULL),
(76,73,'kurang Sekali','2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(77,74,'Sangat Baik','2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(78,74,'Baik','2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(79,74,'Cukup','2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(80,74,'Kurang','2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(81,74,'kurang Sekali','2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(82,75,'Sangat Baik','2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(83,75,'Baik','2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(84,75,'Cukup','2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(85,75,'Kurang','2021-10-28 07:24:14','2021-10-28 07:24:14',NULL),
(86,75,'kurang Sekali','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(87,76,'Sangat Baik','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(88,76,'Baik','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(89,76,'Cukup','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(90,76,'Kurang','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(91,76,'kurang Sekali','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(92,77,'Sangat Baik','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(93,77,'Baik','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(94,77,'Cukup','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(95,77,'Kurang','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(96,77,'kurang Sekali','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(97,79,'Sangat Baik','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(98,79,'Baik','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(99,79,'Cukup','2021-10-28 07:24:15','2021-10-28 07:24:15',NULL),
(100,79,'Kurang','2021-10-28 07:24:16','2021-10-28 07:24:16',NULL),
(101,79,'kurang Sekali','2021-10-28 07:24:16','2021-10-28 07:24:16',NULL),
(102,89,'a','2021-10-31 02:54:02','2021-10-31 02:54:02',NULL),
(103,89,'1','2021-10-31 02:55:22','2021-10-31 02:55:22',NULL),
(104,89,'2','2021-10-31 02:55:22','2021-10-31 02:55:22',NULL);

/*Table structure for table `tb_pengumuman` */

DROP TABLE IF EXISTS `tb_pengumuman`;

CREATE TABLE `tb_pengumuman` (
  `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` text DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `sifat_surat` varchar(255) DEFAULT NULL,
  `lampiran_name` varchar(255) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `thumbnail_name` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `perihal` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pengumuman`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_pengumuman` */

insert  into `tb_pengumuman`(`id_pengumuman`,`jenis`,`judul`,`sifat_surat`,`lampiran_name`,`lampiran`,`thumbnail_name`,`thumbnail`,`perihal`,`deleted_at`,`updated_at`,`created_at`) values 
(54,'Tracer Study Fakultas Teknik','Lulusan Alumni Fakultas Teknik','Tidak Bersurat',NULL,NULL,'Yw-VsZvZ.jpg','/storage/image/posts//Yw-VsZvZ.jpg','Selamat atas kelulusanmu dan semoga kamu beruntung untuk awal yang baru dalam hidup. Semoga kamu mencapai semua tujuanmu. Semua jerih payah yang kamu rasakan selama proses kuliah kini sudah berakhir. Meskipun banyak orang yang meragukan kemampuanmu, tapi',NULL,'2021-11-07 11:01:57','2021-10-28 14:13:06');

/*Table structure for table `tb_periode` */

DROP TABLE IF EXISTS `tb_periode`;

CREATE TABLE `tb_periode` (
  `id_periode` int(11) NOT NULL AUTO_INCREMENT,
  `periode` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_periode`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_periode` */

insert  into `tb_periode`(`id_periode`,`periode`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Periode 1','2021-09-07 05:45:42','2021-10-11 04:37:49',NULL),
(2,'Periode 2','2021-09-07 05:45:42','2021-10-11 04:30:55',NULL),
(3,'Periode 3','2021-09-07 05:45:42','2021-10-11 04:37:18',NULL),
(4,'Periode 4','2021-09-07 05:45:42','2021-10-11 04:37:24',NULL),
(5,'Periode 6','2021-09-07 05:45:42','2021-10-11 04:37:30',NULL),
(7,'Periode 7','2021-10-09 03:40:05','2021-10-11 04:37:35',NULL),
(10,'Periode 5',NULL,NULL,NULL);

/*Table structure for table `tb_periode_kuesioner` */

DROP TABLE IF EXISTS `tb_periode_kuesioner`;

CREATE TABLE `tb_periode_kuesioner` (
  `id_periode_kuesioner` int(11) NOT NULL AUTO_INCREMENT,
  `id_tahun_periode` int(11) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_periode_kuesioner`),
  KEY `tb_periode_kuesioner_ibfk_1` (`id_tahun_periode`),
  KEY `tb_periode_kuesioner_ibfk_2` (`id_periode`),
  CONSTRAINT `tb_periode_kuesioner_ibfk_1` FOREIGN KEY (`id_tahun_periode`) REFERENCES `tb_tahun_periode` (`id_tahun_periode`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_periode_kuesioner_ibfk_2` FOREIGN KEY (`id_periode`) REFERENCES `tb_periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `tb_periode_kuesioner` */

insert  into `tb_periode_kuesioner`(`id_periode_kuesioner`,`id_tahun_periode`,`id_periode`,`tanggal_mulai`,`tanggal_selesai`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(3,2,1,NULL,NULL,NULL,'2021-10-11 04:36:37','2021-10-24 06:05:35','2021-10-24 06:05:35'),
(4,2,2,NULL,NULL,NULL,'2021-10-11 11:00:31','2021-10-24 06:06:16','2021-10-24 06:06:16'),
(5,2,3,NULL,NULL,NULL,'2021-10-11 13:29:26','2021-10-24 06:06:24','2021-10-24 06:06:24'),
(8,2,4,NULL,NULL,NULL,'2021-10-11 13:30:49','2021-10-24 06:06:28','2021-10-24 06:06:28'),
(9,2,7,'2021-10-24','2021-10-24','Tidak Aktif',NULL,'2021-11-12 02:16:26',NULL),
(10,2,5,'2021-10-24','2021-10-24','Aktif','2021-10-23 12:33:16','2021-10-24 11:18:32',NULL),
(12,2,10,'2021-10-24','2021-12-24','Aktif','2021-10-23 12:34:12','2021-10-24 11:18:33',NULL),
(13,5,1,'2021-10-24','2021-11-19','Aktif','2021-10-24 05:43:03','2021-10-24 11:18:34',NULL),
(14,8,5,'2021-10-24','2021-10-25','Aktif','2021-10-24 05:46:25','2021-10-28 07:02:31','2021-10-28 07:02:31');

/*Table structure for table `tb_periodealumni` */

DROP TABLE IF EXISTS `tb_periodealumni`;

CREATE TABLE `tb_periodealumni` (
  `id_periode_alumni` int(11) NOT NULL AUTO_INCREMENT,
  `id_tahun_periode` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_periode_alumni`),
  KEY `id_tahun` (`id_tahun_periode`),
  CONSTRAINT `tb_periodealumni_ibfk_1` FOREIGN KEY (`id_tahun_periode`) REFERENCES `tb_tahun_periode` (`id_tahun_periode`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_periodealumni` */

insert  into `tb_periodealumni`(`id_periode_alumni`,`id_tahun_periode`,`created_at`,`updated_at`,`deleted_at`) values 
(1,2,NULL,'2021-11-06 04:49:13',NULL),
(2,5,'2021-10-23 15:05:26','2021-11-06 04:49:17',NULL),
(3,6,'2021-10-24 05:06:48','2021-11-06 04:49:20',NULL),
(4,8,'2021-10-27 15:50:01','2021-11-06 04:49:22',NULL);

/*Table structure for table `tb_prodi` */

DROP TABLE IF EXISTS `tb_prodi`;

CREATE TABLE `tb_prodi` (
  `id_prodi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_prodi` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_prodi`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_prodi` */

insert  into `tb_prodi`(`id_prodi`,`nama_prodi`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'S1 Teknik Sipil',NULL,'2021-10-25 11:54:12',NULL),
(2,'S1 Teknik Elektro',NULL,'2021-10-25 11:54:33',NULL),
(3,'S1 Arsitektur',NULL,'2021-10-25 11:54:49',NULL),
(4,'S1 Teknik Mesin',NULL,'2021-10-25 11:54:59',NULL),
(5,'S1 Teknologi Informasi',NULL,'2021-10-25 11:55:08',NULL),
(6,'S1 Teknik Linkungan','2021-04-01 05:43:36','2021-10-25 11:55:16',NULL),
(8,'S1 Teknik Industri','2021-04-01 05:44:07','2021-10-25 11:55:25',NULL),
(29,'S2 Arsitektur','2021-10-25 11:56:22','2021-10-25 11:56:22',NULL),
(30,'S2 Teknik Elektro','2021-10-25 11:56:47','2021-10-25 11:56:47',NULL),
(31,'S2 Teknik Mesin','2021-10-25 11:56:58','2021-10-25 11:56:58',NULL),
(32,'S2 Teknik Sipil','2021-10-25 11:57:27','2021-10-25 11:57:27',NULL),
(33,'S3 Ilmu teknik','2021-10-25 11:57:36','2021-10-25 11:57:36',NULL);

/*Table structure for table `tb_provinsi` */

DROP TABLE IF EXISTS `tb_provinsi`;

CREATE TABLE `tb_provinsi` (
  `id_provinsi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_provinsi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_provinsi` */

/*Table structure for table `tb_soal_alumni` */

DROP TABLE IF EXISTS `tb_soal_alumni`;

CREATE TABLE `tb_soal_alumni` (
  `id_soal_alumni` int(11) NOT NULL AUTO_INCREMENT,
  `pertanyaan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_soal_alumni`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_soal_alumni` */

insert  into `tb_soal_alumni`(`id_soal_alumni`,`pertanyaan`,`created_at`,`updated_at`,`deleted_at`) values 
(4,'Bekerja Pada Perusahaan atau tempat kerja','2021-10-11 09:16:43','2021-10-13 09:54:23',NULL),
(6,'Mengelola Perusahaan Sendiri atau Berwirausaha','2021-10-11 09:37:23','2021-10-14 02:24:59',NULL),
(7,'Melanjutkan Studi','2021-10-11 13:26:11','2021-10-14 02:26:03',NULL),
(9,'bank soal baru','2021-10-16 12:16:03','2021-10-23 05:49:30','2021-10-23 05:49:30'),
(10,'test','2021-10-28 10:47:18','2021-10-28 11:27:05','2021-10-28 11:27:05');

/*Table structure for table `tb_soal_stakeholder` */

DROP TABLE IF EXISTS `tb_soal_stakeholder`;

CREATE TABLE `tb_soal_stakeholder` (
  `id_soal_stakeholder` int(11) NOT NULL AUTO_INCREMENT,
  `pertanyaan` varchar(255) DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL COMMENT '1=ganda,2=singkat,3=checkbox,4=tanggal',
  `id_prodi` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_soal_stakeholder`),
  KEY `id_prodi` (`id_prodi`),
  CONSTRAINT `tb_soal_stakeholder_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `tb_prodi` (`id_prodi`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_soal_stakeholder` */

insert  into `tb_soal_stakeholder`(`id_soal_stakeholder`,`pertanyaan`,`id_jenis`,`id_prodi`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'nama pengisi',1,1,'2021-10-13 06:47:21','2021-10-16 13:06:05','2021-10-16 13:06:05'),
(2,'haha',1,2,'2021-10-14 10:37:26','2021-10-16 13:06:13','2021-10-16 13:06:13'),
(3,'haha',1,3,'2021-10-14 10:39:09','2021-10-16 13:07:41','2021-10-16 13:07:41'),
(4,'test',1,4,'2021-10-14 10:39:47','2021-10-16 13:07:47','2021-10-16 13:07:47'),
(5,'Jumlah Karyawan / Staff',1,5,'2021-10-14 10:40:51','2021-10-16 13:07:54','2021-10-16 13:07:54'),
(6,'test1',1,6,'2021-10-14 10:42:01','2021-10-16 13:08:00','2021-10-16 13:08:00'),
(7,'Etika',1,8,'2021-10-16 12:42:38','2021-10-16 12:42:38',NULL),
(8,'sss',2,1,'2021-10-16 12:45:32','2021-10-16 13:06:28','2021-10-16 13:06:28'),
(9,'zzz',2,2,'2021-10-16 12:52:56','2021-10-16 13:08:10','2021-10-16 13:08:10'),
(10,'aa',2,1,'2021-10-16 12:54:17','2021-10-16 13:08:17','2021-10-16 13:08:17'),
(11,'Keahlian Pada Bidang Ilmu (Kompetensi Utama)',1,8,'2021-10-16 13:09:42','2021-10-16 13:09:42',NULL),
(12,'Kemampuan Berbahasa Asing',1,8,'2021-10-16 13:10:19','2021-10-16 13:10:19',NULL),
(13,'Penggunaan Teknologi Informasi',1,8,'2021-10-16 13:10:59','2021-10-16 13:10:59',NULL),
(14,'Kemampuan berkomunikasi',1,8,'2021-10-16 13:11:39','2021-10-16 13:11:39',NULL),
(15,'Kerjasama tim',1,8,'2021-10-16 13:12:11','2021-10-16 13:12:11',NULL),
(16,'Pengembangan diri',1,8,'2021-10-16 13:20:29','2021-10-16 13:20:29',NULL),
(17,'Silakan memberi penjelasan dalam bentuk uraian tentang kepuasan terhadap alumni PSTM UNUD, dan mohon saran tentang skill dan kompetensi yang perlu ditambahkan untuk bisa bekerja di perusahaan anda saat ini.',2,8,'2021-10-16 13:21:13','2021-10-16 13:21:13',NULL),
(18,'Pengembangan diri',1,8,'2021-10-16 13:33:24','2021-10-16 13:33:24',NULL),
(19,'abc',2,33,'2021-10-21 06:11:28','2021-11-07 10:32:00','2021-11-07 10:32:00'),
(20,'sssswaa89',2,8,'2021-10-28 10:28:16','2021-11-07 10:31:51','2021-11-07 10:31:51'),
(21,'12345678',2,1,'2021-10-28 11:27:44','2021-11-07 10:29:28','2021-11-07 10:29:28'),
(22,'dleteopsi',1,1,'2021-10-28 11:42:26','2021-10-28 11:45:06','2021-10-28 11:45:06'),
(25,'createa',2,1,'2021-10-28 12:29:25','2021-11-07 10:29:44','2021-11-07 10:29:44'),
(26,'tambah',1,1,'2021-10-28 13:22:35','2021-11-07 10:30:46','2021-11-07 10:30:46'),
(27,'aa2222',2,1,'2021-10-29 11:40:50','2021-11-07 10:30:51','2021-11-07 10:30:51'),
(28,'zzzz',2,3,'2021-10-29 14:33:55','2021-11-07 10:31:36','2021-11-07 10:31:36');

/*Table structure for table `tb_stakeholder` */

DROP TABLE IF EXISTS `tb_stakeholder`;

CREATE TABLE `tb_stakeholder` (
  `id_stakeholder` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `nama_instansi` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `jabatan` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_stakeholder`),
  KEY `id_periode` (`id_periode`),
  CONSTRAINT `tb_stakeholder_ibfk_1` FOREIGN KEY (`id_periode`) REFERENCES `tb_periode_kuesioner` (`id_periode_kuesioner`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_stakeholder` */

insert  into `tb_stakeholder`(`id_stakeholder`,`nama`,`nama_instansi`,`jabatan`,`email`,`id_periode`,`created_at`,`updated_at`,`deleted_at`) values 
(73,'Ayu Cantik Sekali','Guna Saputra . CO','Manager','guna@guna.com',8,'2021-10-21 14:50:14','2021-10-21 14:50:14',NULL),
(74,'Guna Saputra','Mantap','Manager','gunsarichman3@gmail.com',8,'2021-10-21 14:59:00','2021-10-21 14:59:00',NULL),
(75,'Guna Ganteng','Mantap','Manager','adisuandika14@yahoo.com',8,'2021-10-21 14:59:56','2021-10-21 14:59:56',NULL),
(76,'Guna Ganteng','Guna Saputra . COS','Manager','bincrackerguna@gmail.com',8,'2021-10-21 15:01:20','2021-10-21 15:01:20',NULL),
(77,'Guna Ganteng','Mantap','Manager','guns@gmail.com2',8,'2021-10-21 15:05:35','2021-10-21 15:05:35',NULL),
(78,'Guna Ganteng','Guna Saputra . COS','Manager','adiandika73@gmail.comasd',8,'2021-10-21 15:06:00','2021-10-21 15:06:00',NULL),
(79,'Guna Ganteng','Mantap','Manager','bincrackerguna@gmail.com123',8,'2021-10-21 15:06:37','2021-10-21 15:06:37',NULL),
(80,'Guna Saputra','Guna Saputra . CO','Manager','gunsarichman3@gmail.come',8,'2021-10-21 15:16:55','2021-10-21 15:16:55',NULL),
(81,'Guna GantengAAA','Mantap','Manager','gunsarichman3@gmail.comasd',8,'2021-10-21 15:18:05','2021-10-21 15:18:05',NULL),
(82,'Guna Ganteng','Guna Saputra . COS','Manager','adisuandika14@yahoo.com12',8,'2021-10-21 15:24:38','2021-10-21 15:24:38',NULL),
(83,'Guna Ganteng','Mantap','123d','bincrackerguna@gmail.comdfsASDF',8,'2021-10-21 15:25:34','2021-10-21 15:25:34',NULL),
(84,'Guna Ganteng','Guna Saputra . CO','Manager','adiandika73@gmail.com',8,'2021-10-21 15:26:45','2021-10-21 15:26:45',NULL),
(85,'Guna Ganteng','Mantap','Manager','gunsarichman3@gmail.com134123',8,'2021-10-21 15:32:35','2021-10-21 15:32:35',NULL),
(86,'Guna Ganteng','Mantap','Manager','guns@gmail.comasdad',8,'2021-10-21 15:33:18','2021-10-21 15:33:18',NULL),
(87,'Guna Ganteng','Mantap','Manager','gunsarichman3@gmail.come2',8,'2021-10-21 15:47:56','2021-10-21 15:47:56',NULL),
(88,'Guna Ganteng','Mantap','Manager','gunsarichman3@gmail.come2sd',8,'2021-10-21 15:49:14','2021-10-21 15:49:14',NULL),
(89,'Guna Ganteng','Mantap','12312313','123123213@dasd',8,'2021-10-21 16:18:57','2021-10-21 16:18:57',NULL),
(90,'Guna Ganteng','Mantap','Manager','adiandika73@gmail.comqwe',8,'2021-10-21 16:44:17','2021-10-21 16:44:17',NULL),
(91,'Guna Ganteng','Mantap','Manager','guna@guna.comasdw',8,'2021-10-21 17:31:09','2021-10-21 17:31:09',NULL),
(92,'Guna Ganteng','Mantap','Manager','adiandika73@gmail.com123',8,'2021-10-21 17:33:08','2021-10-21 17:33:08',NULL),
(93,'Guna Ganteng','Mantap','Manager','bincrackerguna@gmail.comasd2e',8,'2021-10-21 17:33:50','2021-10-21 17:33:50',NULL),
(94,'Guna Ganteng','Guna Saputra . CO','Manager','bincrackerguna@gmail.comasdas',8,'2021-10-22 16:56:01','2021-10-22 16:56:01',NULL);

/*Table structure for table `tb_tahun_periode` */

DROP TABLE IF EXISTS `tb_tahun_periode`;

CREATE TABLE `tb_tahun_periode` (
  `id_tahun_periode` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_periode` year(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tahun_periode`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_tahun_periode` */

insert  into `tb_tahun_periode`(`id_tahun_periode`,`tahun_periode`,`created_at`,`updated_at`,`deleted_at`) values 
(2,2021,'2021-10-11 03:51:27','2021-10-24 05:59:27',NULL),
(5,2022,'2021-10-11 04:44:01','2021-10-11 04:44:01',NULL),
(6,2023,'2021-10-11 04:44:07','2021-10-11 04:44:07',NULL),
(8,2024,'2021-10-16 13:30:58','2021-10-16 13:30:58',NULL),
(9,2025,'2021-10-16 13:34:29','2021-10-16 13:34:29',NULL),
(10,2026,'2021-10-28 14:57:13','2021-10-31 02:34:03',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` bigint(20) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_tlp` bigint(14) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`nama`,`nip`,`username`,`email`,`email_verified_at`,`foto`,`no_tlp`,`password`,`remember_token`,`role`,`created_at`,`updated_at`) values 
(1,'User Pegawai',1805551048,'userpegawai','adisuandika14@yahoo.com',NULL,'/storage/image/admin/profile/6173baab59964.png',NULL,'$2y$10$ABeEpFEvAMf2.gsG7VYZge80rARLQd6NKH0Fgw.Cq8s7jxoVhZY72',NULL,1,NULL,'2021-10-23 07:32:59'),
(2,'User Pimpinan',1805551075,'gunsa12','gusnarichman@gmail.com','2021-09-28 15:30:43','/storage/image/admin/profile/613e071b910c3.png',NULL,'$2y$10$ABeEpFEvAMf2.gsG7VYZge80rARLQd6NKH0Fgw.Cq8s7jxoVhZY72',NULL,2,NULL,'2021-09-28 15:30:43'),
(3,'User pegawai st',1805551051,'aaaa','gushman@gmail.com','2021-09-28 15:30:43','/storage/image/admin/profile/613e071b910c3.png',NULL,'$2y$10$ABeEpFEvAMf2.gsG7VYZge80rARLQd6NKH0Fgw.Cq8s7jxoVhZY72',NULL,1,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
