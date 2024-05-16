/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 8.0.30 : Database - unpam
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `log_data` */

DROP TABLE IF EXISTS `log_data`;

CREATE TABLE `log_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipe` char(10) DEFAULT NULL,
  `script` char(20) DEFAULT NULL,
  `running` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `log_data` */

insert  into `log_data`(`id`,`tipe`,`script`,`running`) values 
(1,'event','cek_data','2024-05-16 13:00:00'),
(2,'event','cek_data','2024-05-16 14:00:00'),
(3,'event','cek_data','2024-05-16 15:00:00'),
(4,'event','cek_data','2024-05-16 16:00:00');

/*Table structure for table `unpam_absen_log` */

DROP TABLE IF EXISTS `unpam_absen_log`;

CREATE TABLE `unpam_absen_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `obj_dosen` char(100) DEFAULT NULL,
  `obj_data` text,
  `obj_url` text,
  `obj_fordis` text,
  `obj_fordis_title` text,
  `obj_kelas` char(20) DEFAULT NULL,
  `updrec_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updrec_by` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `unpam_absen_log` */

insert  into `unpam_absen_log`(`id`,`obj_dosen`,`obj_data`,`obj_url`,`obj_fordis`,`obj_fordis_title`,`obj_kelas`,`updrec_date`,`updrec_by`) values 
(1,'RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','[{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17135551\",\"waktu\":\"Monday, 13 May 2024, 9:27 PM\"},{\"nama\":\"MAULANA ROYYAN TSUBAISA 231011450122-55201-E\",\"postid\":\"17138857\",\"waktu\":\"Monday, 13 May 2024, 9:39 PM\"},{\"nama\":\"ROYAN ALFA REZZA 231011450102-55201-E\",\"postid\":\"17310388\",\"waktu\":\"Tuesday, 14 May 2024, 1:40 PM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17546113\",\"waktu\":\"Tuesday, 14 May 2024, 11:09 PM\"},{\"nama\":\"ICTHIAR FERDY YULISTIAWAN 231011450115-55201-E\",\"postid\":\"17555311\",\"waktu\":\"Tuesday, 14 May 2024, 11:31 PM\"},{\"nama\":\"MAULANA ROYYAN TSUBAISA 231011450122-55201-E\",\"postid\":\"18031429\",\"waktu\":\"Wednesday, 15 May 2024, 6:37 PM\"},{\"nama\":\"MAULANA ROYYAN TSUBAISA 231011450122-55201-E\",\"postid\":\"18031639\",\"waktu\":\"Wednesday, 15 May 2024, 6:37 PM\"},{\"nama\":\"ROYAN ALFA REZZA 231011450102-55201-E\",\"postid\":\"17310733\",\"waktu\":\"Tuesday, 14 May 2024, 1:42 PM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17545969\",\"waktu\":\"Tuesday, 14 May 2024, 11:09 PM\"},{\"nama\":\"MAULANA ROYYAN TSUBAISA 231011450122-55201-E\",\"postid\":\"17138974\",\"waktu\":\"Monday, 13 May 2024, 9:40 PM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17546824\",\"waktu\":\"Tuesday, 14 May 2024, 11:11 PM\"},{\"nama\":\"MAULANA ROYYAN TSUBAISA 231011450122-55201-E\",\"postid\":\"17139169\",\"waktu\":\"Monday, 13 May 2024, 9:40 PM\"},{\"nama\":\"ILHAM FAUZI 231011450300-55201-E\",\"postid\":\"17145121\",\"waktu\":\"Monday, 13 May 2024, 10:07 PM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17546392\",\"waktu\":\"Tuesday, 14 May 2024, 11:10 PM\"},{\"nama\":\"ILHAM FAUZI 231011450300-55201-E\",\"postid\":\"17145397\",\"waktu\":\"Monday, 13 May 2024, 10:08 PM\"},{\"nama\":\"ROYAN ALFA REZZA 231011450102-55201-E\",\"postid\":\"17312218\",\"waktu\":\"Tuesday, 14 May 2024, 1:49 PM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17546557\",\"waktu\":\"Tuesday, 14 May 2024, 11:11 PM\"},{\"nama\":\"ANDI BAGJA DINATA 231011450261-55201-E\",\"postid\":\"17150957\",\"waktu\":\"Monday, 13 May 2024, 10:35 PM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17547217\",\"waktu\":\"Tuesday, 14 May 2024, 11:12 PM\"},{\"nama\":\"RIZAL KURNIAWAN 231011450747-55201-E\",\"postid\":\"17151422\",\"waktu\":\"Monday, 13 May 2024, 10:37 PM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17547448\",\"waktu\":\"Tuesday, 14 May 2024, 11:13 PM\"},{\"nama\":\"RIZAL KURNIAWAN 231011450747-55201-E\",\"postid\":\"17152199\",\"waktu\":\"Monday, 13 May 2024, 10:40 PM\"},{\"nama\":\"MAESTRO ARJUNA SAKTI 231011450113-55201-E\",\"postid\":\"17158558\",\"waktu\":\"Monday, 13 May 2024, 11:13 PM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17547607\",\"waktu\":\"Tuesday, 14 May 2024, 11:14 PM\"},{\"nama\":\"MUH FATHURRAHMAN 231011450661-55201-E\",\"postid\":\"17167684\",\"waktu\":\"Tuesday, 14 May 2024, 12:03 AM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17547907\",\"waktu\":\"Tuesday, 14 May 2024, 11:14 PM\"},{\"nama\":\"MANARUL HIDAYAH 231011450126-55201-E\",\"postid\":\"17732608\",\"waktu\":\"Wednesday, 15 May 2024, 9:37 AM\"},{\"nama\":\"MOCH SANDI 231011450111-55201-E\",\"postid\":\"17799055\",\"waktu\":\"Wednesday, 15 May 2024, 11:30 AM\"},{\"nama\":\"MAESTRO ARJUNA SAKTI 231011450113-55201-E\",\"postid\":\"17156974\",\"waktu\":\"Monday, 13 May 2024, 11:05 PM\"},{\"nama\":\"MAESTRO ARJUNA SAKTI 231011450113-55201-E\",\"postid\":\"17157628\",\"waktu\":\"Monday, 13 May 2024, 11:09 PM\"},{\"nama\":\"MAESTRO ARJUNA SAKTI 231011450113-55201-E\",\"postid\":\"17158996\",\"waktu\":\"Monday, 13 May 2024, 11:16 PM\"},{\"nama\":\"MUH FATHURRAHMAN 231011450661-55201-E\",\"postid\":\"17167417\",\"waktu\":\"Tuesday, 14 May 2024, 12:01 AM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"17548264\",\"waktu\":\"Tuesday, 14 May 2024, 11:15 PM\"},{\"nama\":\"ARYA PRATAMA 231011450640-55201-E\",\"postid\":\"17181866\",\"waktu\":\"Tuesday, 14 May 2024, 1:52 AM\"},{\"nama\":\"MANARUL HIDAYAH 231011450126-55201-E\",\"postid\":\"17200588\",\"waktu\":\"Tuesday, 14 May 2024, 6:15 AM\"},{\"nama\":\"ICTHIAR FERDY YULISTIAWAN 231011450115-55201-E\",\"postid\":\"17553586\",\"waktu\":\"Tuesday, 14 May 2024, 11:28 PM\"},{\"nama\":\"MOCH SANDI 231011450111-55201-E\",\"postid\":\"17799691\",\"waktu\":\"Wednesday, 15 May 2024, 11:31 AM\"},{\"nama\":\"MUH FATHURRAHMAN 231011450661-55201-E\",\"postid\":\"17167141\",\"waktu\":\"Monday, 13 May 2024, 11:59 PM\"},{\"nama\":\"MUHAMMAD RIFA`I AKBAR SAPUTRO 231011450414-55201-E\",\"postid\":\"17181089\",\"waktu\":\"Tuesday, 14 May 2024, 1:42 AM\"},{\"nama\":\"MUHAMMAD RIFA`I AKBAR SAPUTRO 231011450414-55201-E\",\"postid\":\"17181161\",\"waktu\":\"Tuesday, 14 May 2024, 1:43 AM\"},{\"nama\":\"ARYA PRATAMA 231011450640-55201-E\",\"postid\":\"17181296\",\"waktu\":\"Tuesday, 14 May 2024, 1:45 AM\"},{\"nama\":\"MANARUL HIDAYAH 231011450126-55201-E\",\"postid\":\"17200120\",\"waktu\":\"Tuesday, 14 May 2024, 6:11 AM\"},{\"nama\":\"MANARUL HIDAYAH 231011450126-55201-E\",\"postid\":\"17200225\",\"waktu\":\"Tuesday, 14 May 2024, 6:12 AM\"},{\"nama\":\"ARDIANSYAH 231011450107-55201-E\",\"postid\":\"17408527\",\"waktu\":\"Tuesday, 14 May 2024, 7:19 PM\"},{\"nama\":\"SALMA CAHYANI AULIA PUTRI 231011450116-55201-E\",\"postid\":\"17428483\",\"waktu\":\"Tuesday, 14 May 2024, 7:52 PM\"},{\"nama\":\"MUHAMMAD ILHAM ARDIANSYAH 231011450716-55201-E\",\"postid\":\"17214229\",\"waktu\":\"Tuesday, 14 May 2024, 7:33 AM\"},{\"nama\":\"VICKY PRIYADI 231011450110-55201-E\",\"postid\":\"17249005\",\"waktu\":\"Tuesday, 14 May 2024, 9:52 AM\"},{\"nama\":\"VICKY PRIYADI 231011450110-55201-E\",\"postid\":\"17249077\",\"waktu\":\"Tuesday, 14 May 2024, 9:53 AM\"},{\"nama\":\"VICKY PRIYADI 231011450110-55201-E\",\"postid\":\"17249140\",\"waktu\":\"Tuesday, 14 May 2024, 9:53 AM\"},{\"nama\":\"ADITYA ALBANI 231011450129-55201-E\",\"postid\":\"17295983\",\"waktu\":\"Tuesday, 14 May 2024, 12:44 PM\"},{\"nama\":\"ADITYA ALBANI 231011450129-55201-E\",\"postid\":\"17297084\",\"waktu\":\"Tuesday, 14 May 2024, 12:47 PM\"},{\"nama\":\"MUHAMAD AZID 231011450407-55201-E\",\"postid\":\"17313247\",\"waktu\":\"Tuesday, 14 May 2024, 1:54 PM\"},{\"nama\":\"MUHAMAD AZID 231011450407-55201-E\",\"postid\":\"17313607\",\"waktu\":\"Tuesday, 14 May 2024, 1:56 PM\"},{\"nama\":\"MUHAMAD AZID 231011450407-55201-E\",\"postid\":\"17313850\",\"waktu\":\"Tuesday, 14 May 2024, 1:57 PM\"},{\"nama\":\"SALMA CAHYANI AULIA PUTRI 231011450116-55201-E\",\"postid\":\"17425027\",\"waktu\":\"Tuesday, 14 May 2024, 7:46 PM\"},{\"nama\":\"DALPA KHOIRUN NISA 231011450736-55201-E\",\"postid\":\"17365723\",\"waktu\":\"Tuesday, 14 May 2024, 5:42 PM\"},{\"nama\":\"DALPA KHOIRUN NISA 231011450736-55201-E\",\"postid\":\"17365870\",\"waktu\":\"Tuesday, 14 May 2024, 5:43 PM\"},{\"nama\":\"MUHAMMAD ZAHAVY AL ZENITA 231011450125-55201-E\",\"postid\":\"17377555\",\"waktu\":\"Tuesday, 14 May 2024, 6:19 PM\"},{\"nama\":\"MUHAMMAD ZAHAVY AL ZENITA 231011450125-55201-E\",\"postid\":\"17378455\",\"waktu\":\"Tuesday, 14 May 2024, 6:21 PM\"},{\"nama\":\"MUHAMMAD RIDWAN 231011450611-55201-E\",\"postid\":\"17397250\",\"waktu\":\"Tuesday, 14 May 2024, 6:58 PM\"},{\"nama\":\"MUHAMMAD RIDWAN 231011450611-55201-E\",\"postid\":\"17397583\",\"waktu\":\"Tuesday, 14 May 2024, 6:59 PM\"},{\"nama\":\"MUHAMMAD RIDWAN 231011450611-55201-E\",\"postid\":\"17399311\",\"waktu\":\"Tuesday, 14 May 2024, 7:02 PM\"},{\"nama\":\"ARDIANSYAH 231011450107-55201-E\",\"postid\":\"17405473\",\"waktu\":\"Tuesday, 14 May 2024, 7:13 PM\"},{\"nama\":\"ARDIANSYAH 231011450107-55201-E\",\"postid\":\"17410213\",\"waktu\":\"Tuesday, 14 May 2024, 7:22 PM\"},{\"nama\":\"SALMA CAHYANI AULIA PUTRI 231011450116-55201-E\",\"postid\":\"17412949\",\"waktu\":\"Tuesday, 14 May 2024, 7:27 PM\"},{\"nama\":\"MUHAMAD FIKRI FERDIANSYAH 231011450293-55201-E\",\"postid\":\"17470840\",\"waktu\":\"Tuesday, 14 May 2024, 9:02 PM\"},{\"nama\":\"MUHAMAD FIKRI FERDIANSYAH 231011450293-55201-E\",\"postid\":\"17471062\",\"waktu\":\"Tuesday, 14 May 2024, 9:03 PM\"},{\"nama\":\"ANDI BAGJA DINATA 231011450261-55201-E\",\"postid\":\"17495608\",\"waktu\":\"Tuesday, 14 May 2024, 9:44 PM\"},{\"nama\":\"ANDI BAGJA DINATA 231011450261-55201-E\",\"postid\":\"17499202\",\"waktu\":\"Tuesday, 14 May 2024, 9:49 PM\"},{\"nama\":\"ICTHIAR FERDY YULISTIAWAN 231011450115-55201-E\",\"postid\":\"17550433\",\"waktu\":\"Tuesday, 14 May 2024, 11:21 PM\"},{\"nama\":\"FAUZAN HANIF ILYASA 231011450444-55201-E\",\"postid\":\"17555878\",\"waktu\":\"Tuesday, 14 May 2024, 11:32 PM\"},{\"nama\":\"FAUZAN HANIF ILYASA 231011450444-55201-E\",\"postid\":\"17556397\",\"waktu\":\"Tuesday, 14 May 2024, 11:34 PM\"},{\"nama\":\"ICTHIAR FERDY YULISTIAWAN 231011450115-55201-E\",\"postid\":\"17560018\",\"waktu\":\"Tuesday, 14 May 2024, 11:42 PM\"},{\"nama\":\"ICTHIAR FERDY YULISTIAWAN 231011450115-55201-E\",\"postid\":\"17558875\",\"waktu\":\"Tuesday, 14 May 2024, 11:39 PM\"},{\"nama\":\"ILAN ALFIAN FAZA 231011450686-55201-E\",\"postid\":\"17615059\",\"waktu\":\"Wednesday, 15 May 2024, 3:30 AM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"18118667\",\"waktu\":\"Wednesday, 15 May 2024, 9:41 PM\"},{\"nama\":\"ILAN ALFIAN FAZA 231011450686-55201-E\",\"postid\":\"17615251\",\"waktu\":\"Wednesday, 15 May 2024, 3:32 AM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"18117668\",\"waktu\":\"Wednesday, 15 May 2024, 9:39 PM\"},{\"nama\":\"ALVIS JULIANDRY 231011450312-55201-E\",\"postid\":\"17697400\",\"waktu\":\"Wednesday, 15 May 2024, 8:34 AM\"},{\"nama\":\"ALVIS JULIANDRY 231011450312-55201-E\",\"postid\":\"17697670\",\"waktu\":\"Wednesday, 15 May 2024, 8:35 AM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"18116894\",\"waktu\":\"Wednesday, 15 May 2024, 9:38 PM\"},{\"nama\":\"MOCH SANDI 231011450111-55201-E\",\"postid\":\"17800783\",\"waktu\":\"Wednesday, 15 May 2024, 11:33 AM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"18116207\",\"waktu\":\"Wednesday, 15 May 2024, 9:37 PM\"},{\"nama\":\"CAHYO YOGI PRAYOGO 231011450127-55201-E\",\"postid\":\"18029566\",\"waktu\":\"Wednesday, 15 May 2024, 6:34 PM\"},{\"nama\":\"CAHYO YOGI PRAYOGO 231011450127-55201-E\",\"postid\":\"18031528\",\"waktu\":\"Wednesday, 15 May 2024, 6:37 PM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"18115355\",\"waktu\":\"Wednesday, 15 May 2024, 9:36 PM\"},{\"nama\":\"RAFLY BATISTUTA 191011402005-55201-E\",\"postid\":\"18110576\",\"waktu\":\"Wednesday, 15 May 2024, 9:28 PM\"},{\"nama\":\"RAFLY BATISTUTA 191011402005-55201-E\",\"postid\":\"18111032\",\"waktu\":\"Wednesday, 15 May 2024, 9:29 PM\"},{\"nama\":\"RISWAL HANAFI SIREGAR S.Si, M.Eng Dosen-00268\",\"postid\":\"18114752\",\"waktu\":\"Wednesday, 15 May 2024, 9:35 PM\"}]','http://localhost/web/unpam_project/contoh/fisika.html','FORUM DISKUSI 12','FORUM DISKUSI PERTEMUAN KE 12 : Kapasitor','TPLE004','2024-05-16 16:31:30','Nazar');

/*Table structure for table `unpam_absensi` */

DROP TABLE IF EXISTS `unpam_absensi`;

CREATE TABLE `unpam_absensi` (
  `id_post` char(15) NOT NULL,
  `url_matkul` varchar(300) NOT NULL,
  `nim` char(50) NOT NULL,
  `nama` char(50) NOT NULL,
  `kelas` char(20) DEFAULT NULL,
  `absen_time` datetime DEFAULT NULL,
  `updrec_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updrec_by` char(20) DEFAULT NULL,
  PRIMARY KEY (`id_post`,`url_matkul`,`nim`,`nama`),
  KEY `id` (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `unpam_absensi` */

insert  into `unpam_absensi`(`id_post`,`url_matkul`,`nim`,`nama`,`kelas`,`absen_time`,`updrec_date`,`updrec_by`) values 
('17135551','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-13 21:27:00','2024-05-16 16:31:30','Nazar'),
('17138857','http://localhost/web/unpam_project/contoh/fisika.html','231011450122-55201-E','MAULANA ROYYAN TSUBAISA','TPLE004','2024-05-13 21:39:00','2024-05-16 16:31:30','Nazar'),
('17138974','http://localhost/web/unpam_project/contoh/fisika.html','231011450122-55201-E','MAULANA ROYYAN TSUBAISA','TPLE004','2024-05-13 21:40:00','2024-05-16 16:31:30','Nazar'),
('17139169','http://localhost/web/unpam_project/contoh/fisika.html','231011450122-55201-E','MAULANA ROYYAN TSUBAISA','TPLE004','2024-05-13 21:40:00','2024-05-16 16:31:30','Nazar'),
('17145121','http://localhost/web/unpam_project/contoh/fisika.html','231011450300-55201-E','ILHAM FAUZI','TPLE004','2024-05-13 22:07:00','2024-05-16 16:31:30','Nazar'),
('17145397','http://localhost/web/unpam_project/contoh/fisika.html','231011450300-55201-E','ILHAM FAUZI','TPLE004','2024-05-13 22:08:00','2024-05-16 16:31:30','Nazar'),
('17150957','http://localhost/web/unpam_project/contoh/fisika.html','231011450261-55201-E','ANDI BAGJA DINATA','TPLE004','2024-05-13 22:35:00','2024-05-16 16:31:30','Nazar'),
('17151422','http://localhost/web/unpam_project/contoh/fisika.html','231011450747-55201-E','RIZAL KURNIAWAN','TPLE004','2024-05-13 22:37:00','2024-05-16 16:31:30','Nazar'),
('17152199','http://localhost/web/unpam_project/contoh/fisika.html','231011450747-55201-E','RIZAL KURNIAWAN','TPLE004','2024-05-13 22:40:00','2024-05-16 16:31:30','Nazar'),
('17156974','http://localhost/web/unpam_project/contoh/fisika.html','231011450113-55201-E','MAESTRO ARJUNA SAKTI','TPLE004','2024-05-13 23:05:00','2024-05-16 16:31:30','Nazar'),
('17157628','http://localhost/web/unpam_project/contoh/fisika.html','231011450113-55201-E','MAESTRO ARJUNA SAKTI','TPLE004','2024-05-13 23:09:00','2024-05-16 16:31:30','Nazar'),
('17158558','http://localhost/web/unpam_project/contoh/fisika.html','231011450113-55201-E','MAESTRO ARJUNA SAKTI','TPLE004','2024-05-13 23:13:00','2024-05-16 16:31:30','Nazar'),
('17158996','http://localhost/web/unpam_project/contoh/fisika.html','231011450113-55201-E','MAESTRO ARJUNA SAKTI','TPLE004','2024-05-13 23:16:00','2024-05-16 16:31:30','Nazar'),
('17167141','http://localhost/web/unpam_project/contoh/fisika.html','231011450661-55201-E','MUH FATHURRAHMAN','TPLE004','2024-05-13 23:59:00','2024-05-16 16:31:31','Nazar'),
('17167417','http://localhost/web/unpam_project/contoh/fisika.html','231011450661-55201-E','MUH FATHURRAHMAN','TPLE004','2024-05-14 00:01:00','2024-05-16 16:31:30','Nazar'),
('17167684','http://localhost/web/unpam_project/contoh/fisika.html','231011450661-55201-E','MUH FATHURRAHMAN','TPLE004','2024-05-14 00:03:00','2024-05-16 16:31:30','Nazar'),
('17181089','http://localhost/web/unpam_project/contoh/fisika.html','231011450414-55201-E','MUHAMMAD RIFA`I AKBAR SAPUTRO','TPLE004','2024-05-14 01:42:00','2024-05-16 16:31:31','Nazar'),
('17181161','http://localhost/web/unpam_project/contoh/fisika.html','231011450414-55201-E','MUHAMMAD RIFA`I AKBAR SAPUTRO','TPLE004','2024-05-14 01:43:00','2024-05-16 16:31:31','Nazar'),
('17181296','http://localhost/web/unpam_project/contoh/fisika.html','231011450640-55201-E','ARYA PRATAMA','TPLE004','2024-05-14 01:45:00','2024-05-16 16:31:31','Nazar'),
('17181866','http://localhost/web/unpam_project/contoh/fisika.html','231011450640-55201-E','ARYA PRATAMA','TPLE004','2024-05-14 01:52:00','2024-05-16 16:31:31','Nazar'),
('17200120','http://localhost/web/unpam_project/contoh/fisika.html','231011450126-55201-E','MANARUL HIDAYAH','TPLE004','2024-05-14 06:11:00','2024-05-16 16:31:31','Nazar'),
('17200225','http://localhost/web/unpam_project/contoh/fisika.html','231011450126-55201-E','MANARUL HIDAYAH','TPLE004','2024-05-14 06:12:00','2024-05-16 16:31:31','Nazar'),
('17200588','http://localhost/web/unpam_project/contoh/fisika.html','231011450126-55201-E','MANARUL HIDAYAH','TPLE004','2024-05-14 06:15:00','2024-05-16 16:31:31','Nazar'),
('17214229','http://localhost/web/unpam_project/contoh/fisika.html','231011450716-55201-E','MUHAMMAD ILHAM ARDIANSYAH','TPLE004','2024-05-14 07:33:00','2024-05-16 16:31:31','Nazar'),
('17249005','http://localhost/web/unpam_project/contoh/fisika.html','231011450110-55201-E','VICKY PRIYADI','TPLE004','2024-05-14 09:52:00','2024-05-16 16:31:31','Nazar'),
('17249077','http://localhost/web/unpam_project/contoh/fisika.html','231011450110-55201-E','VICKY PRIYADI','TPLE004','2024-05-14 09:53:00','2024-05-16 16:31:31','Nazar'),
('17249140','http://localhost/web/unpam_project/contoh/fisika.html','231011450110-55201-E','VICKY PRIYADI','TPLE004','2024-05-14 09:53:00','2024-05-16 16:31:31','Nazar'),
('17295983','http://localhost/web/unpam_project/contoh/fisika.html','231011450129-55201-E','ADITYA ALBANI','TPLE004','2024-05-14 12:44:00','2024-05-16 16:31:31','Nazar'),
('17297084','http://localhost/web/unpam_project/contoh/fisika.html','231011450129-55201-E','ADITYA ALBANI','TPLE004','2024-05-14 12:47:00','2024-05-16 16:31:31','Nazar'),
('17310388','http://localhost/web/unpam_project/contoh/fisika.html','231011450102-55201-E','ROYAN ALFA REZZA','TPLE004','2024-05-14 13:40:00','2024-05-16 16:31:30','Nazar'),
('17310733','http://localhost/web/unpam_project/contoh/fisika.html','231011450102-55201-E','ROYAN ALFA REZZA','TPLE004','2024-05-14 13:42:00','2024-05-16 16:31:30','Nazar'),
('17312218','http://localhost/web/unpam_project/contoh/fisika.html','231011450102-55201-E','ROYAN ALFA REZZA','TPLE004','2024-05-14 13:49:00','2024-05-16 16:31:30','Nazar'),
('17313247','http://localhost/web/unpam_project/contoh/fisika.html','231011450407-55201-E','MUHAMAD AZID','TPLE004','2024-05-14 13:54:00','2024-05-16 16:31:31','Nazar'),
('17313607','http://localhost/web/unpam_project/contoh/fisika.html','231011450407-55201-E','MUHAMAD AZID','TPLE004','2024-05-14 13:56:00','2024-05-16 16:31:31','Nazar'),
('17313850','http://localhost/web/unpam_project/contoh/fisika.html','231011450407-55201-E','MUHAMAD AZID','TPLE004','2024-05-14 13:57:00','2024-05-16 16:31:31','Nazar'),
('17365723','http://localhost/web/unpam_project/contoh/fisika.html','231011450736-55201-E','DALPA KHOIRUN NISA','TPLE004','2024-05-14 17:42:00','2024-05-16 16:31:31','Nazar'),
('17365870','http://localhost/web/unpam_project/contoh/fisika.html','231011450736-55201-E','DALPA KHOIRUN NISA','TPLE004','2024-05-14 17:43:00','2024-05-16 16:31:31','Nazar'),
('17377555','http://localhost/web/unpam_project/contoh/fisika.html','231011450125-55201-E','MUHAMMAD ZAHAVY AL ZENITA','TPLE004','2024-05-14 18:19:00','2024-05-16 16:31:31','Nazar'),
('17378455','http://localhost/web/unpam_project/contoh/fisika.html','231011450125-55201-E','MUHAMMAD ZAHAVY AL ZENITA','TPLE004','2024-05-14 18:21:00','2024-05-16 16:31:31','Nazar'),
('17397250','http://localhost/web/unpam_project/contoh/fisika.html','231011450611-55201-E','MUHAMMAD RIDWAN','TPLE004','2024-05-14 18:58:00','2024-05-16 16:31:31','Nazar'),
('17397583','http://localhost/web/unpam_project/contoh/fisika.html','231011450611-55201-E','MUHAMMAD RIDWAN','TPLE004','2024-05-14 18:59:00','2024-05-16 16:31:31','Nazar'),
('17399311','http://localhost/web/unpam_project/contoh/fisika.html','231011450611-55201-E','MUHAMMAD RIDWAN','TPLE004','2024-05-14 19:02:00','2024-05-16 16:31:31','Nazar'),
('17405473','http://localhost/web/unpam_project/contoh/fisika.html','231011450107-55201-E','ARDIANSYAH','TPLE004','2024-05-14 19:13:00','2024-05-16 16:31:31','Nazar'),
('17408527','http://localhost/web/unpam_project/contoh/fisika.html','231011450107-55201-E','ARDIANSYAH','TPLE004','2024-05-14 19:19:00','2024-05-16 16:31:31','Nazar'),
('17410213','http://localhost/web/unpam_project/contoh/fisika.html','231011450107-55201-E','ARDIANSYAH','TPLE004','2024-05-14 19:22:00','2024-05-16 16:31:31','Nazar'),
('17412949','http://localhost/web/unpam_project/contoh/fisika.html','231011450116-55201-E','SALMA CAHYANI AULIA PUTRI','TPLE004','2024-05-14 19:27:00','2024-05-16 16:31:31','Nazar'),
('17425027','http://localhost/web/unpam_project/contoh/fisika.html','231011450116-55201-E','SALMA CAHYANI AULIA PUTRI','TPLE004','2024-05-14 19:46:00','2024-05-16 16:31:31','Nazar'),
('17428483','http://localhost/web/unpam_project/contoh/fisika.html','231011450116-55201-E','SALMA CAHYANI AULIA PUTRI','TPLE004','2024-05-14 19:52:00','2024-05-16 16:31:31','Nazar'),
('17470840','http://localhost/web/unpam_project/contoh/fisika.html','231011450293-55201-E','MUHAMAD FIKRI FERDIANSYAH','TPLE004','2024-05-14 21:02:00','2024-05-16 16:31:31','Nazar'),
('17471062','http://localhost/web/unpam_project/contoh/fisika.html','231011450293-55201-E','MUHAMAD FIKRI FERDIANSYAH','TPLE004','2024-05-14 21:03:00','2024-05-16 16:31:31','Nazar'),
('17495608','http://localhost/web/unpam_project/contoh/fisika.html','231011450261-55201-E','ANDI BAGJA DINATA','TPLE004','2024-05-14 21:44:00','2024-05-16 16:31:31','Nazar'),
('17499202','http://localhost/web/unpam_project/contoh/fisika.html','231011450261-55201-E','ANDI BAGJA DINATA','TPLE004','2024-05-14 21:49:00','2024-05-16 16:31:31','Nazar'),
('17545969','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-14 23:09:00','2024-05-16 16:31:30','Nazar'),
('17546113','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-14 23:09:00','2024-05-16 16:31:30','Nazar'),
('17546392','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-14 23:10:00','2024-05-16 16:31:30','Nazar'),
('17546557','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-14 23:11:00','2024-05-16 16:31:30','Nazar'),
('17546824','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-14 23:11:00','2024-05-16 16:31:30','Nazar'),
('17547217','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-14 23:12:00','2024-05-16 16:31:30','Nazar'),
('17547448','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-14 23:13:00','2024-05-16 16:31:30','Nazar'),
('17547607','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-14 23:14:00','2024-05-16 16:31:30','Nazar'),
('17547907','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-14 23:14:00','2024-05-16 16:31:30','Nazar'),
('17548264','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-14 23:15:00','2024-05-16 16:31:31','Nazar'),
('17550433','http://localhost/web/unpam_project/contoh/fisika.html','231011450115-55201-E','ICTHIAR FERDY YULISTIAWAN','TPLE004','2024-05-14 23:21:00','2024-05-16 16:31:31','Nazar'),
('17553586','http://localhost/web/unpam_project/contoh/fisika.html','231011450115-55201-E','ICTHIAR FERDY YULISTIAWAN','TPLE004','2024-05-14 23:28:00','2024-05-16 16:31:31','Nazar'),
('17555311','http://localhost/web/unpam_project/contoh/fisika.html','231011450115-55201-E','ICTHIAR FERDY YULISTIAWAN','TPLE004','2024-05-14 23:31:00','2024-05-16 16:31:30','Nazar'),
('17555878','http://localhost/web/unpam_project/contoh/fisika.html','231011450444-55201-E','FAUZAN HANIF ILYASA','TPLE004','2024-05-14 23:32:00','2024-05-16 16:31:31','Nazar'),
('17556397','http://localhost/web/unpam_project/contoh/fisika.html','231011450444-55201-E','FAUZAN HANIF ILYASA','TPLE004','2024-05-14 23:34:00','2024-05-16 16:31:31','Nazar'),
('17558875','http://localhost/web/unpam_project/contoh/fisika.html','231011450115-55201-E','ICTHIAR FERDY YULISTIAWAN','TPLE004','2024-05-14 23:39:00','2024-05-16 16:31:31','Nazar'),
('17560018','http://localhost/web/unpam_project/contoh/fisika.html','231011450115-55201-E','ICTHIAR FERDY YULISTIAWAN','TPLE004','2024-05-14 23:42:00','2024-05-16 16:31:31','Nazar'),
('17615059','http://localhost/web/unpam_project/contoh/fisika.html','231011450686-55201-E','ILAN ALFIAN FAZA','TPLE004','2024-05-15 03:30:00','2024-05-16 16:31:31','Nazar'),
('17615251','http://localhost/web/unpam_project/contoh/fisika.html','231011450686-55201-E','ILAN ALFIAN FAZA','TPLE004','2024-05-15 03:32:00','2024-05-16 16:31:31','Nazar'),
('17697400','http://localhost/web/unpam_project/contoh/fisika.html','231011450312-55201-E','ALVIS JULIANDRY','TPLE004','2024-05-15 08:34:00','2024-05-16 16:31:31','Nazar'),
('17697670','http://localhost/web/unpam_project/contoh/fisika.html','231011450312-55201-E','ALVIS JULIANDRY','TPLE004','2024-05-15 08:35:00','2024-05-16 16:31:31','Nazar'),
('17732608','http://localhost/web/unpam_project/contoh/fisika.html','231011450126-55201-E','MANARUL HIDAYAH','TPLE004','2024-05-15 09:37:00','2024-05-16 16:31:30','Nazar'),
('17799055','http://localhost/web/unpam_project/contoh/fisika.html','231011450111-55201-E','MOCH SANDI','TPLE004','2024-05-15 11:30:00','2024-05-16 16:31:30','Nazar'),
('17799691','http://localhost/web/unpam_project/contoh/fisika.html','231011450111-55201-E','MOCH SANDI','TPLE004','2024-05-15 11:31:00','2024-05-16 16:31:31','Nazar'),
('17800783','http://localhost/web/unpam_project/contoh/fisika.html','231011450111-55201-E','MOCH SANDI','TPLE004','2024-05-15 11:33:00','2024-05-16 16:31:31','Nazar'),
('18029566','http://localhost/web/unpam_project/contoh/fisika.html','231011450127-55201-E','CAHYO YOGI PRAYOGO','TPLE004','2024-05-15 18:34:00','2024-05-16 16:31:31','Nazar'),
('18031429','http://localhost/web/unpam_project/contoh/fisika.html','231011450122-55201-E','MAULANA ROYYAN TSUBAISA','TPLE004','2024-05-15 18:37:00','2024-05-16 16:31:30','Nazar'),
('18031528','http://localhost/web/unpam_project/contoh/fisika.html','231011450127-55201-E','CAHYO YOGI PRAYOGO','TPLE004','2024-05-15 18:37:00','2024-05-16 16:31:31','Nazar'),
('18031639','http://localhost/web/unpam_project/contoh/fisika.html','231011450122-55201-E','MAULANA ROYYAN TSUBAISA','TPLE004','2024-05-15 18:37:00','2024-05-16 16:31:30','Nazar'),
('18110576','http://localhost/web/unpam_project/contoh/fisika.html','191011402005-55201-E','RAFLY BATISTUTA','TPLE004','2024-05-15 21:28:00','2024-05-16 16:31:31','Nazar'),
('18111032','http://localhost/web/unpam_project/contoh/fisika.html','191011402005-55201-E','RAFLY BATISTUTA','TPLE004','2024-05-15 21:29:00','2024-05-16 16:31:31','Nazar'),
('18114752','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-15 21:35:00','2024-05-16 16:31:31','Nazar'),
('18115355','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-15 21:36:00','2024-05-16 16:31:31','Nazar'),
('18116207','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-15 21:37:00','2024-05-16 16:31:31','Nazar'),
('18116894','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-15 21:38:00','2024-05-16 16:31:31','Nazar'),
('18117668','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-15 21:39:00','2024-05-16 16:31:31','Nazar'),
('18118667','http://localhost/web/unpam_project/contoh/fisika.html','Dosen','RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n','TPLE004','2024-05-15 21:41:00','2024-05-16 16:31:31','Nazar');

/*Table structure for table `unpam_dosen_matkul` */

DROP TABLE IF EXISTS `unpam_dosen_matkul`;

CREATE TABLE `unpam_dosen_matkul` (
  `dm_id` int NOT NULL AUTO_INCREMENT,
  `matkul_dosen` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `matkul_desk` char(50) DEFAULT NULL,
  `matkul_url` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `matkul_min_absen` int DEFAULT NULL,
  `matkul_tugas` char(50) DEFAULT NULL,
  `matkul_pertemuan` char(50) DEFAULT NULL,
  `matkul_fordis` char(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `matkul_fordis_title` char(150) DEFAULT NULL,
  `matkul_kelas` char(10) DEFAULT NULL,
  `updrec_date` datetime DEFAULT NULL,
  `updrec_by` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`dm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `unpam_dosen_matkul` */

insert  into `unpam_dosen_matkul`(`dm_id`,`matkul_dosen`,`matkul_desk`,`matkul_url`,`matkul_min_absen`,`matkul_tugas`,`matkul_pertemuan`,`matkul_fordis`,`matkul_fordis_title`,`matkul_kelas`,`updrec_date`,`updrec_by`) values 
(1,'RISWAL HANAFI SIREGAR S.Si, M.Eng\r\n',NULL,'http://localhost/web/unpam_project/contoh/fisika.html',NULL,NULL,NULL,'FORUM DISKUSI 12','FORUM DISKUSI PERTEMUAN KE 12 : Kapasitor','TPLE004','2024-05-16 16:31:31','Nazar');

/*Table structure for table `unpam_mahasiswa` */

DROP TABLE IF EXISTS `unpam_mahasiswa`;

CREATE TABLE `unpam_mahasiswa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` char(50) NOT NULL,
  `nim` char(50) NOT NULL,
  `kelas` char(10) NOT NULL,
  `updrec_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`nama`,`nim`,`kelas`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

/*Data for the table `unpam_mahasiswa` */

insert  into `unpam_mahasiswa`(`id`,`nama`,`nim`,`kelas`,`updrec_date`) values 
(1,'ADITYA ALBANI','231011450129','TPLE004','2024-05-13 22:34:25'),
(2,'AFIQ NUR IZZA ADDAKHIL','231011450119','TPLE004','2024-05-13 22:34:25'),
(3,'AHMAD PAISAL','231011450105','TPLE004','2024-05-13 22:34:25'),
(4,'ALVIS JULIANDRY','231011450312','TPLE004','2024-05-13 22:34:25'),
(5,'ANDI BAGJA DINATA','231011450261','TPLE004','2024-05-13 22:34:25'),
(6,'ARDIANSYAH','231011450107','TPLE004','2024-05-13 22:34:25'),
(18,'ARYA PRATAMA','231011450640','TPLE004','2024-05-13 22:34:25'),
(19,'CAHYO YOGI PRAYOGO','231011450127','TPLE004','2024-05-13 22:34:25'),
(20,'DALPA KHOIRUN NISA','231011450736','TPLE004','2024-05-13 22:34:25'),
(17,'DESI RAHMAWATI','231011450252','TPLE004','2024-05-13 22:34:25'),
(21,'FAUZAN HANIF ILYASA','231011450444','TPLE004','2024-05-13 22:34:25'),
(22,'HAZIM ZAIN','231011450410','TPLE004','2024-05-13 22:34:25'),
(23,'ICTHIAR FERDY YULISTIAWAN','231011450115','TPLE004','2024-05-13 22:34:25'),
(7,'ILAN ALFIAN FAZA','231011450686','TPLE004','2024-05-13 22:34:25'),
(24,'ILHAM FAUZI','231011450300','TPLE004','2024-05-13 22:34:25'),
(25,'MAESTRO ARJUNA SAKTI','231011450113','TPLE004','2024-05-13 22:34:25'),
(8,'MANARUL HIDAYAH','231011450126','TPLE004','2024-05-13 22:34:25'),
(26,'MARCHELINO STEVENSON MAKUSI','231011450327','TPLE004','2024-05-13 22:34:25'),
(9,'MAULANA ROYYAN TSUBAISA','231011450122','TPLE004','2024-05-13 22:34:25'),
(10,'MOCH SANDI','231011450111','TPLE004','2024-05-13 22:34:25'),
(11,'MUH FATHURRAHMAN','231011450661','TPLE004','2024-05-13 22:34:25'),
(27,'MUHAMAD ABDUL YAZKY ZAELANI','231011450456','TPLE004','2024-05-13 22:34:25'),
(12,'MUHAMAD ALVIAN ADAM','231011450443','TPLE004','2024-05-13 22:34:25'),
(13,'MUHAMAD AZID','231011450407','TPLE004','2024-05-13 22:34:25'),
(28,'MUHAMAD FIKRI FERDIANSYAH','231011450293','TPLE004','2024-05-13 22:34:25'),
(29,'MUHAMAD WAHYU HIDAYAT','231011450568','TPLE004','2024-05-13 22:34:26'),
(30,'MUHAMMAD ILHAM ARDIANSYAH','231011450716','TPLE004','2024-05-13 22:34:26'),
(31,'MUHAMMAD RIDWAN','231011450611','TPLE004','2024-05-13 22:34:26'),
(32,'MUHAMMAD RIFA`I AKBAR SAPUTRO','231011450414','TPLE004','2024-05-13 22:34:26'),
(33,'MUHAMMAD ZAHAVY AL ZENITA','231011450125','TPLE004','2024-05-13 22:34:26'),
(14,'NAZA RUDIN','231011450485','TPLE004','2024-05-13 22:34:25'),
(34,'PRADEWA MUSTOFA','231011450727','TPLE004','2024-05-13 22:34:26'),
(35,'RIZAL KURNIAWAN','231011450747','TPLE004','2024-05-13 22:34:26'),
(36,'ROYAN ALFA REZZA','231011450102','TPLE004','2024-05-13 22:34:26'),
(37,'SALMA CAHYANI AULIA PUTRI','231011450116','TPLE004','2024-05-13 22:34:26'),
(15,'SHEVCENKO RADJARTHA','231011450438','TPLE004','2024-05-13 22:34:25'),
(16,'VICKY PRIYADI','231011450110','TPLE004','2024-05-13 22:34:25');

/*Table structure for table `unpam_setting` */

DROP TABLE IF EXISTS `unpam_setting`;

CREATE TABLE `unpam_setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis` char(20) DEFAULT NULL,
  `konten` varchar(500) DEFAULT NULL,
  `sks` char(20) DEFAULT NULL,
  `recid` char(1) DEFAULT NULL,
  `updrec_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

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

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `cek_data` */

/*!50106 DROP EVENT IF EXISTS `cek_data`*/;

DELIMITER $$

/*!50106 CREATE DEFINER=`root`@`localhost` EVENT `cek_data` ON SCHEDULE EVERY 1 HOUR STARTS '2024-05-16 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	
	    delete from unpam_absen_log where obj_url not in (select distinct(url_matkul) from unpam_absensi);
		delete from unpam_absen_log where obj_url not in (select distinct(matkul_url) from unpam_dosen_matkul);
		insert into log_data (tipe,script,running) values ('event','cek_data',now());
	END */$$
DELIMITER ;

/* Procedure structure for procedure `cek_absen` */

/*!50003 DROP PROCEDURE IF EXISTS  `cek_absen` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `cek_absen`(IN vurl VARCHAR(200),IN vabsen CHAR(2))
BEGIN

	SELECT a.nama,a.nim,IFNULL(b.absen,0) AS absen,IFNULL(b.hasil,0) AS hasil FROM unpam_mahasiswa a LEFT JOIN (
	SELECT a.nama,COUNT(1) AS absen,IF(COUNT(1)<vabsen,COUNT(1)-vabsen,IF(COUNT(1)>vabsen,IF(COUNT(1)<6,"Semangat","Luar Biasa"),"standar")) hasil FROM unpam_mahasiswa a
	LEFT JOIN unpam_absensi b ON a.`nama`=b.`nama`
	WHERE url_matkul=vurl
	AND b.nim LIKE '%55201-E'
	GROUP BY a.nama ORDER BY 2 DESC) b ON a.`nama`=b.nama
	ORDER BY 3 DESC;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `dele_url` */

/*!50003 DROP PROCEDURE IF EXISTS  `dele_url` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `dele_url`(in url char(100))
BEGIN
		delete from unpam_absensi where url_matkul=url;
		delete from unpam_absen_log where obj_url=url;
		delete from unpam_dosen_matkul where matkul_url=url;
	END */$$
DELIMITER ;

/*Table structure for table `absen_mahasiswa` */

DROP TABLE IF EXISTS `absen_mahasiswa`;

/*!50001 DROP VIEW IF EXISTS `absen_mahasiswa` */;
/*!50001 DROP TABLE IF EXISTS `absen_mahasiswa` */;

/*!50001 CREATE TABLE  `absen_mahasiswa`(
 `matkul_dosen` char(50) ,
 `matkul_fordis` char(100) ,
 `matkul_fordis_title` char(150) ,
 `nama` char(50) ,
 `absen` bigint ,
 `url_matkul` varchar(300) 
)*/;

/*Table structure for table `absen_matkul` */

DROP TABLE IF EXISTS `absen_matkul`;

/*!50001 DROP VIEW IF EXISTS `absen_matkul` */;
/*!50001 DROP TABLE IF EXISTS `absen_matkul` */;

/*!50001 CREATE TABLE  `absen_matkul`(
 `matkul_dosen` char(50) ,
 `matkul_fordis` char(100) ,
 `matkul_fordis_title` char(150) ,
 `absen` bigint 
)*/;

/*View structure for view absen_mahasiswa */

/*!50001 DROP TABLE IF EXISTS `absen_mahasiswa` */;
/*!50001 DROP VIEW IF EXISTS `absen_mahasiswa` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `absen_mahasiswa` AS select `b`.`matkul_dosen` AS `matkul_dosen`,`b`.`matkul_fordis` AS `matkul_fordis`,`b`.`matkul_fordis_title` AS `matkul_fordis_title`,`a`.`nama` AS `nama`,count(1) AS `absen`,`a`.`url_matkul` AS `url_matkul` from (`unpam_absensi` `a` left join `unpam_dosen_matkul` `b` on((`a`.`url_matkul` = `b`.`matkul_url`))) where ((not((`a`.`url_matkul` like '%localhost%'))) and (`a`.`nim` <> 'Dosen')) group by `b`.`matkul_dosen`,`b`.`matkul_fordis`,`b`.`matkul_fordis_title`,`a`.`nama`,`a`.`url_matkul` */;

/*View structure for view absen_matkul */

/*!50001 DROP TABLE IF EXISTS `absen_matkul` */;
/*!50001 DROP VIEW IF EXISTS `absen_matkul` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `absen_matkul` AS select `b`.`matkul_dosen` AS `matkul_dosen`,`b`.`matkul_fordis` AS `matkul_fordis`,`b`.`matkul_fordis_title` AS `matkul_fordis_title`,count(1) AS `absen` from (`unpam_absensi` `a` left join `unpam_dosen_matkul` `b` on((`a`.`url_matkul` = `b`.`matkul_url`))) where ((not((`a`.`url_matkul` like '%localhost%'))) and (`a`.`nim` <> 'Dosen')) group by `b`.`matkul_dosen`,`b`.`matkul_fordis`,`b`.`matkul_fordis_title` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
