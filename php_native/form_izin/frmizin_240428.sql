/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 8.0.30 : Database - data_izin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `izin` */

DROP TABLE IF EXISTS `izin`;

CREATE TABLE `izin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `nik` char(15) DEFAULT NULL,
  `nama` char(30) DEFAULT NULL,
  `alasan` text,
  `foto` char(150) DEFAULT NULL,
  `exif_data` text,
  `updrec_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `izin` */

insert  into `izin`(`id`,`tanggal`,`nik`,`nama`,`alasan`,`foto`,`exif_data`,`updrec_date`) values 
(1,'2024-04-01',NULL,'nazar','sakit','Colours-IG-Photo-05.jpg',NULL,'2024-04-01 09:14:59'),
(2,'2024-04-03',NULL,'nazar','sakit','Colours-IG-Photo-05.jpg',NULL,'2024-04-01 09:15:41'),
(3,'2024-04-10',NULL,'nazar','melahirkan','DSCF7912.JPG','Array','2024-04-01 09:35:33'),
(4,'2024-04-01',NULL,'nazar','abc','IMG_20170418_153030.jpg','Array','2024-04-01 09:38:05'),
(5,'2024-04-02',NULL,'abc','asda','cuci.jpg','{\"FileName\":\"cuci.jpg\",\"FileDateTime\":1711939268,\"FileSize\":217296,\"FileType\":2,\"MimeType\":\"image/jpeg\",\"SectionsFound\":\"ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP\",\"COMPUTED\":{\"html\":\"width=\"882\" height=\"1258\"\",\"Height\":1258,\"Width\":882,\"IsColor\":1,\"ByteOrderMotorola\":0,\"Thumbnail.FileType\":2,\"Thumbnail.MimeType\":\"image/jpeg\"},\"Make\":\"Nokia\",\"Model\":\"5130c-2\",\"Orientation\":1,\"XResolution\":\"300/1\",\"YResolution\":\"300/1\",\"ResolutionUnit\":2,\"Software\":\"ACD Systems Digital Imaging\",\"DateTime\":\"2010:10:01 18:32:27\",\"YCbCrPositioning\":1,\"Exif_IFD_Pointer\":212,\"THUMBNAIL\":{\"Compression\":6,\"JPEGInterchangeFormat\":518,\"JPEGInterchangeFormatLength\":4728},\"ExifVersion\":\"0220\",\"DateTimeOriginal\":\"2010:10:01 18:24:17\",\"DateTimeDigitized\":\"2010:10:01 18:24:17\",\"ComponentsConfiguration\":\"u0001u0002u0003u0000\",\"SubSecTime\":\"953\",\"FlashPixVersion\":\"0100\",\"ColorSpace\":1,\"ExifImageWidth\":882,\"ExifImageLength\":1258,\"InteroperabilityOffset\":438,\"CustomRendered\":0,\"ExposureMode\":0,\"WhiteBalance\":0,\"DigitalZoomRatio\":\"1024/1024\",\"SceneCaptureType\":0,\"InterOperabilityIndex\":\"R98\",\"InterOperabilityVersion\":\"0100\"}','2024-04-01 09:41:08'),
(6,'2024-04-10',NULL,'aws','as','awis.jpg','{\"FileName\":\"awis.jpg\",\"FileDateTime\":1711940598,\"FileSize\":122165,\"FileType\":2,\"MimeType\":\"image/jpeg\",\"SectionsFound\":\"ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP\",\"COMPUTED\":{\"html\":\"width=\"678\" height=\"1096\"\",\"Height\":1096,\"Width\":678,\"IsColor\":1,\"ByteOrderMotorola\":0,\"Thumbnail.FileType\":2,\"Thumbnail.MimeType\":\"image/jpeg\"},\"Make\":\"Nokia\",\"Model\":\"5130c-2\",\"Orientation\":1,\"XResolution\":\"300/1\",\"YResolution\":\"300/1\",\"ResolutionUnit\":2,\"Software\":\"ACD Systems Digital Imaging\",\"DateTime\":\"2010:10:02 11:27:32\",\"YCbCrPositioning\":1,\"Exif_IFD_Pointer\":212,\"THUMBNAIL\":{\"Compression\":6,\"JPEGInterchangeFormat\":518,\"JPEGInterchangeFormatLength\":4121},\"ExifVersion\":\"0220\",\"DateTimeOriginal\":\"2010:10:02 11:09:49\",\"DateTimeDigitized\":\"2010:10:02 11:09:49\",\"ComponentsConfiguration\":\"u0001u0002u0003u0000\",\"SubSecTime\":\"296\",\"FlashPixVersion\":\"0100\",\"ColorSpace\":1,\"ExifImageWidth\":678,\"ExifImageLength\":1096,\"InteroperabilityOffset\":438,\"CustomRendered\":0,\"ExposureMode\":0,\"WhiteBalance\":0,\"DigitalZoomRatio\":\"1024/1024\",\"SceneCaptureType\":0,\"InterOperabilityIndex\":\"R98\",\"InterOperabilityVersion\":\"0100\"}','2024-04-01 10:03:18'),
(7,'2024-04-03',NULL,'we','ww','bareng rofiko.jpg','','2024-04-01 10:03:52'),
(8,'2024-04-02',NULL,'12','1','Zre0633.jpg','{\"FileName\":\"Zre0633.jpg\",\"FileDateTime\":1711940696,\"FileSize\":188319,\"FileType\":2,\"MimeType\":\"image/jpeg\",\"SectionsFound\":\"ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP\",\"COMPUTED\":{\"html\":\"width=\"730\" height=\"1114\"\",\"Height\":1114,\"Width\":730,\"IsColor\":1,\"ByteOrderMotorola\":0,\"Thumbnail.FileType\":2,\"Thumbnail.MimeType\":\"image/jpeg\"},\"Make\":\"Nokia\",\"Model\":\"5130c-2\",\"Orientation\":1,\"XResolution\":\"3000000/10000\",\"YResolution\":\"3000000/10000\",\"ResolutionUnit\":2,\"Software\":\"Adobe Photoshop CS2 Windows\",\"DateTime\":\"2010:02:08 07:37:14\",\"YCbCrPositioning\":1,\"Exif_IFD_Pointer\":212,\"THUMBNAIL\":{\"Compression\":6,\"XResolution\":\"72/1\",\"YResolution\":\"72/1\",\"ResolutionUnit\":2,\"JPEGInterchangeFormat\":574,\"JPEGInterchangeFormatLength\":3924},\"ExifVersion\":\"0220\",\"DateTimeOriginal\":\"2009:12:16 11:37:13\",\"DateTimeDigitized\":\"2009:12:16 11:37:13\",\"ComponentsConfiguration\":\"u0001u0002u0003u0000\",\"SubSecTime\":\"437\",\"FlashPixVersion\":\"0100\",\"ColorSpace\":1,\"ExifImageWidth\":730,\"ExifImageLength\":1114,\"InteroperabilityOffset\":448,\"CustomRendered\":0,\"ExposureMode\":0,\"WhiteBalance\":0,\"DigitalZoomRatio\":\"1024/1024\",\"SceneCaptureType\":0,\"InterOperabilityIndex\":\"R98\",\"InterOperabilityVersion\":\"0100\"}','2024-04-01 10:04:56'),
(9,'2024-04-03',NULL,'digital agencyfish','i','batu.jpg','{\"FileName\":\"batu.jpg\",\"FileDateTime\":1711940845,\"FileSize\":504222,\"FileType\":2,\"MimeType\":\"image/jpeg\",\"SectionsFound\":\"ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP\",\"Make\":\"Nokia\",\"Model\":\"5130c-2\",\"Orientation\":1,\"XResolution\":\"3000000/10000\",\"YResolution\":\"3000000/10000\",\"ResolutionUnit\":2,\"Software\":\"Adobe Photoshop CS2 Windows\",\"DateTime\":\"2010:02:01 10:09:32\",\"YCbCrPositioning\":1,\"Exif_IFD_Pointer\":212,\"ExifVersion\":\"0220\",\"DateTimeOriginal\":\"2010:02:02 08:15:13\",\"DateTimeDigitized\":\"2010:02:02 08:15:13\",\"ComponentsConfiguration\":\"u0001u0002u0003u0000\",\"SubSecTime\":\"171\",\"FlashPixVersion\":\"0100\",\"ColorSpace\":1,\"ExifImageWidth\":1200,\"ExifImageLength\":1152,\"InteroperabilityOffset\":448,\"CustomRendered\":0,\"ExposureMode\":0,\"WhiteBalance\":0,\"DigitalZoomRatio\":\"1024/1024\",\"SceneCaptureType\":0,\"InterOperabilityIndex\":\"R98\",\"InterOperabilityVersion\":\"0100\"}','2024-04-01 10:07:26'),
(10,'2024-04-02',NULL,'hjgh','rere','IMG_20170420_113132.jpg','{\"FileName\":\"IMG_20170420_113132.jpg\",\"FileDateTime\":1711940902,\"FileSize\":1663104,\"FileType\":2,\"MimeType\":\"image/jpeg\",\"SectionsFound\":\"ANY_TAG, IFD0, THUMBNAIL, EXIF, GPS, INTEROP\",\"Make\":\"Xiaomi\",\"Model\":\"Redmi 4\",\"XResolution\":\"72/1\",\"YResolution\":\"72/1\",\"ResolutionUnit\":2,\"DateTime\":\"2017:04:20 11:31:32\",\"YCbCrPositioning\":1,\"Exif_IFD_Pointer\":174,\"GPS_IFD_Pointer\":658,\"ExposureTime\":\"1/100\",\"FNumber\":\"220/100\",\"ExposureProgram\":0,\"ISOSpeedRatings\":200,\"ExifVersion\":\"0220\",\"DateTimeOriginal\":\"2017:04:20 11:31:32\",\"DateTimeDigitized\":\"2017:04:20 11:31:32\",\"ComponentsConfiguration\":\"u0001u0002u0003u0000\",\"ShutterSpeedValue\":\"6644/1000\",\"ApertureValue\":\"227/100\",\"BrightnessValue\":\"0/100\",\"MeteringMode\":2,\"Flash\":16,\"FocalLength\":\"368/100\",\"SubSecTime\":\"770883\",\"SubSecTimeOriginal\":\"770883\",\"SubSecTimeDigitized\":\"770883\",\"FlashPixVersion\":\"0100\",\"ColorSpace\":1,\"ExifImageWidth\":3120,\"ExifImageLength\":4160,\"InteroperabilityOffset\":627,\"SensingMethod\":2,\"SceneType\":\"u0001\",\"ExposureMode\":0,\"WhiteBalance\":0,\"FocalLengthIn35mmFilm\":0,\"SceneCaptureType\":0,\"GPSAltitudeRef\":\"220/100\",\"GPSDateStamp\":\"2017:04:20\",\"InterOperabilityIndex\":\"R98\",\"InterOperabilityVersion\":\"0100\"}','2024-04-01 10:08:23'),
(11,'2024-04-02',NULL,'332','223','1711941002016.jpg','{\"FileName\":\"1711941002016.jpg\",\"FileDateTime\":1711941063,\"FileSize\":3071861,\"FileType\":2,\"MimeType\":\"image/jpeg\",\"SectionsFound\":\"ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP\",\"ImageLength\":4080,\"Orientation\":1,\"YResolution\":\"72/1\",\"XResolution\":\"72/1\",\"ImageWidth\":3060,\"Software\":\"MediaTek Camera Application\",\"YCbCrPositioning\":2,\"Exif_IFD_Pointer\":214,\"ResolutionUnit\":2,\"ExifVersion\":\"0220\",\"ExposureBiasValue\":\"0/10\",\"ExposureProgram\":2,\"ColorSpace\":65535,\"MaxApertureValue\":\"144/100\",\"ExifImageLength\":4080,\"BrightnessValue\":\"0/10\",\"FlashPixVersion\":\"0100\",\"MakerNote\":\"Xiaomi\",\"InteroperabilityOffset\":609,\"UndefinedTag:0x8832\":0,\"ExposureMode\":0,\"UndefinedTag:0x9010\":\"+07:00\",\"ExifImageWidth\":3060,\"ComponentsConfiguration\":\"u0001u0002u0003u0000\",\"UndefinedTag:0x9012\":\"+07:00\",\"DigitalZoomRatio\":\"100/100\",\"MeteringMode\":2,\"UndefinedTag:0x8830\":0,\"UndefinedTag:0x9011\":\"+07:00\",\"SceneCaptureType\":0,\"LightSource\":255,\"InterOperabilityIndex\":\"R98\"}','2024-04-01 10:11:04'),
(12,'2024-04-28',NULL,'2','2221','her.jpg','{\"FileName\":\"her.jpg\",\"FileDateTime\":1714309015,\"FileSize\":137513,\"FileType\":2,\"MimeType\":\"image/jpeg\",\"SectionsFound\":\"\"}','2024-04-28 19:56:55');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
