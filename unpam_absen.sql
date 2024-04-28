/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.11.6-MariaDB-cll-lve : Database - n42r3y_tes
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `unpam_matkul` */

DROP TABLE IF EXISTS `unpam_matkul`;

CREATE TABLE `unpam_matkul` (
  `matkul_fk_id` int(11) NOT NULL AUTO_INCREMENT,
  `matkul_desk` char(50) DEFAULT NULL,
  `matkul_link` varchar(500) DEFAULT NULL,
  `matkul_tugas` char(50) DEFAULT NULL,
  `matkul_pertemuan` char(50) DEFAULT NULL,
  `matkul_fordis` decimal(5,0) DEFAULT NULL,
  `updrec_date` datetime DEFAULT NULL,
  `updrec_by` char(10) DEFAULT NULL,
  `matkul_kelas` char(10) DEFAULT NULL,
  PRIMARY KEY (`matkul_fk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `unpam_matkul` */

/*Table structure for table `unpam_setting` */

DROP TABLE IF EXISTS `unpam_setting`;

CREATE TABLE `unpam_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` char(20) DEFAULT NULL,
  `konten` varchar(500) DEFAULT NULL,
  `sks` char(20) DEFAULT NULL,
  `recid` char(1) DEFAULT NULL,
  `updrec_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `unpam_setting` */

insert  into `unpam_setting`(`id`,`jenis`,`konten`,`sks`,`recid`,`updrec_date`) values 
(1,'url','http://localhost/web/absenunpam/',NULL,NULL,NULL),
(2,'kelas','TPLE004','TEKNIK INFORMATIKA S',NULL,NULL),
(3,'matkul','BASIC ACADEMIC ENGLISH','2',NULL,NULL),
(4,'matkul','PENDIDIKAN AGAMA','2',NULL,NULL),
(5,'matkul','PENDIDIKAN PANCASILA','2',NULL,NULL),
(6,'matkul','PENGANTAR TEKNOLOGI INFORMASI','2',NULL,NULL),
(7,'matkul','ALGORITMA DAN PEMROGRAMAN I','3',NULL,NULL),
(8,'matkul','FISIKA DASAR','3',NULL,NULL),
(9,'matkul','KALKULUS I','3',NULL,NULL),
(10,'matkul','LOGIKA INFORMATIKA','3',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
