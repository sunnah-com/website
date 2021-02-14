-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: sunnah-db.cotedeyqvejx.us-west-2.rds.amazonaws.com    Database: hadithdb
-- ------------------------------------------------------
-- Server version	5.7.26-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '';

--
-- Table structure for table `Collections`
--

DROP TABLE IF EXISTS `Collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Collections` (
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `collectionID` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `englishTitle` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `arabicTitle` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `hasvolumes` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `hasbooks` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `haschapters` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `numhadith` int(11) NOT NULL,
  `totalhadith` int(11) DEFAULT NULL,
  `englishgrade1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `arabicgrade1` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `showEnglishTranslationNumber` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `showInBookReference` tinyint(1) NOT NULL DEFAULT '1',
  `showOnHome` tinyint(1) NOT NULL DEFAULT '1',
  `reference_template` tinytext COLLATE utf8_unicode_ci,
  `annotation` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shortintro` text COLLATE utf8_unicode_ci NOT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `numberinginfodesc` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`collectionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Collections`
--

LOCK TABLES `Collections` WRITE;
/*!40000 ALTER TABLE `Collections` DISABLE KEYS */;
INSERT INTO `Collections` VALUES ('bukhari',1,'collection','Sahih al-Bukhari','صحيح البخاري','yes','yes','yes',7291,7291,NULL,'','yes',1,1,NULL,'<font color=green>(complete)</font>','Sahih al-Bukhari is a collection of hadith compiled by Imam Muhammad al-Bukhari (d. 256 AH/870 AD) (rahimahullah).\r\n\r\nHis collection is recognized by the overwhelming majority of the Muslim world to be the most authentic collection of reports of the <i>Sunnah</i> of the Prophet Muhammad (ﷺ). It contains over 7500 hadith (with repetitions) in 97 books.\r\n\r\nThe translation provided here is by Dr. M. Muhsin Khan.','Now included from file. This should not be visible on the website.','complete','The numbering below corresponds with Shaykh Muhammad Fuad `Abd al-Baqi\'s (rahimahullah) numbering scheme.'),('muslim',2,'collection','Sahih Muslim','صحيح مسلم','no','yes','yes',7470,7470,NULL,'','yes',1,1,NULL,'<font color=green>(complete)</font>','Sahih Muslim is a collection of hadith compiled by Imam Muslim ibn al-Hajjaj al-Naysaburi (rahimahullah).\r\nHis collection is considered to be one of the most authentic\r\ncollections of the Sunnah of the Prophet (ﷺ), and along with\r\nSahih al-Bukhari forms the \"Sahihain,\" or the \"Two Sahihs.\"\r\nIt contains roughly 7500 hadith (with repetitions) in 57 books.\r\n<br>\r\nThe translation provided here is by Abdul Hamid Siddiqui.','','complete','The numbering below corresponds with Shaykh Muhammad Fuad `Abd al-Baqi\'s (rahimahullah) numbering scheme.'),('malik',40,'collection','Muwatta Malik',' موطأ مالك','no','yes','yes',1973,1973,NULL,'','yes',1,1,NULL,'(<font color=green>complete</font>)','','','complete',''),('tirmidhi',30,'collection','Jami` at-Tirmidhi','جامع الترمذي ','yes','yes','yes',4039,3956,'Darussalam','','yes',1,1,NULL,'(<font color=blue>in progress</font>)','Jami` at-Tirmidhi is a collection of hadith compiled by Imam Abu `Isa Muhammad at-Tirmidhi (rahimahullah). His collection is unanimously considered to be one of the six canonical collections of hadith (Kutub as-Sittah) of the Sunnah of the Prophet (ﷺ). It contains roughly 4400 hadith (with repetitions) in 46 books. \r\n','','complete','The numbering below corresponds with the numbering scheme started by Shaykh Ahmad Shakir, then continued by Shaykh Muhammad Fu\'ad \'Abdul Baaqi, and finished by Shaykh Ibrahim \'Atwah \'Aood (rahimahumullah).'),('riyadussalihin',110,'selection','Riyad as-Salihin','رياض الصالحين ','no','yes','yes',1896,1895,NULL,'','no',1,1,NULL,'(<font color=green>complete</font>)','','','complete',''),('nasai',3,'collection','Sunan an-Nasa\'i','سنن النسائي','yes','yes','yes',5766,5766,'Darussalam','','yes',1,1,NULL,'(<font color=blue>in progress</font>)','Sunan an-Nasa\'i is a collection of hadith compiled by Imam Ahmad an-Nasa\'i (rahimahullah).\r\nHis collection is unanimously considered to be one of the six canonical collections of hadith (Kutub as-Sittah)\r\nof the Sunnah of the Prophet (ﷺ).\r\nIt contains roughly 5700 hadith (with repetitions) in 52 books.\r\n','','complete','The numbering below corresponds with Shaykh `Abd al-Fattah Abu Ghuddah\'s (rahimahullah) numbering scheme.'),('shamail',130,'selection','Ash-Shama\'il Al-Muhammadiyah','الشمائل المحمدية','no','yes','no',402,398,'Zubair `Aliza\'i','','no',1,1,NULL,NULL,'','','complete',''),('abudawud',10,'collection','Sunan Abi Dawud','سنن أبي داود','no','yes','yes',5276,5276,'Al-Albani','الألباني','yes',1,1,NULL,NULL,'Sunan Abi Dawud is a collection of hadith compiled by Imam Abu Dawud Sulayman ibn al-Ash\'ath as-Sijistani (rahimahullah). It is widely considered to be among the six canonical collections of hadith (Kutub as-Sittah) of the Sunnah of the Prophet (ﷺ). It consists of 5274 ahadith in 43 books.\r\n<br><br><a href=\"/abudawud/letter\">Letter from Imam Abu Dawud to the people of Makkah explaining his book, terms he uses, and his methodology.</a>','','complete','The numbering below corresponds with Shaykh Muhammad Muhi ad-Din `Abd al-Hameed\'s (rahimahullah) numbering scheme.'),('ibnmajah',38,'collection','Sunan Ibn Majah','سنن ابن ماجه','yes','yes','yes',4346,4341,'Darussalam','','yes',1,1,NULL,NULL,'Sunan Ibn Majah is a collection of hadith compiled by Imam Muhammad bin Yazid Ibn Majah al-Qazvini (rahimahullah). It is widely considered to be the sixth of the six canonical collection of hadith (Kutub as-Sittah) of the Sunnah of the Prophet (ﷺ). It consists of 4341 ahadith in 37 books.\n','','complete','The numbering below corresponds with Shaykh Muhammad Fuad `Abd al-Baqi\'s (rahimahullah) numbering scheme.'),('adab',115,'collection','Al-Adab Al-Mufrad','الأدب المفرد','no','yes','yes',1325,1322,'Al-Albani','الألباني','yes',1,1,NULL,NULL,'','','complete',''),('bulugh',200,'collection','Bulugh al-Maram','بلوغ المرام','no','yes','yes',1768,1582,NULL,'','yes',1,1,NULL,NULL,'','','complete',''),('hisn',300,'selection','Hisn al-Muslim','حصن المسلم','no','no','yes',268,268,NULL,'','no',1,1,NULL,'','','','complete',''),('ahmad',50,'collection','Musnad Ahmad','مسند أحمد','yes','yes','no',1359,28199,'Darussalam','','no',1,1,NULL,'(<font color=blue>in progress</font>)','Musnad Ahmad is a collection of hadith compiled by Imam Ahmad ibn Hanbal (d. 241 AH/855 AD - rahimahullah). It is one of the most famous and important collections of reports of the Sunnah of the Prophet Muhammad (ﷺ). It is the largest of the main books of hadith containing approximately 28,199 hadith sectioned based on individual Companions. The translation provided here is by Nasir Khattab.','','incomplete',''),('mishkat',113,'selection','Mishkat al-Masabih','مشكاة المصابيح','no','yes','yes',3445,6285,'Al-Albani','الألباني','no',1,1,NULL,NULL,'Mishkat al-Masabih is a selection of hadith compiled by Imam Khatib at-Tabrizi. Imam at-Tabrizi expanded on an earlier selection of hadith named Masabih as-Sunnah by Imam al-Baghawi. Mishkat al-Masabih contains approximately 6,000 hadith chosen from the Six Books, Musnad Ahmad, and various others. It is a comprehensive selection of hadith that covers almost all aspects of Islamic belief, jurisprudence (<i>fiqh</i>), and virtues. The translation provided here is by James Robson.','','incomplete',''),('forty',102,'selection','Collections of Forty','الأربعينات','no','yes','no',122,0,NULL,'','no',0,1,NULL,NULL,'','','complete','');
/*!40000 ALTER TABLE `Collections` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-14 20:42:13
