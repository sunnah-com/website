-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: sunnah-db.cotedeyqvejx.us-west-2.rds.amazonaws.com
-- Generation Time: Dec 21, 2022 at 10:39 AM
-- Server version: 5.7.38-log
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hadithdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `BookData`
--

CREATE TABLE `BookData` (
  `collection` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `englishBookID` decimal(3,1) NOT NULL DEFAULT '0.0',
  `englishBookNumber` int(11) NOT NULL,
  `englishBookName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `englishBookIntro` text COLLATE utf8_unicode_ci,
  `arabicBookID` decimal(3,1) DEFAULT NULL,
  `arabicBookNumber` int(11) NOT NULL,
  `arabicBookName` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `arabicBookIntro` text COLLATE utf8_unicode_ci,
  `indonesianBookID` decimal(3,1) DEFAULT NULL,
  `indonesianBookNum` int(11) NOT NULL,
  `indonesianBookName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `urduBookID` decimal(3,1) DEFAULT NULL,
  `urduBookNum` int(11) NOT NULL,
  `urduBookName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `banglaBookID` decimal(3,1) DEFAULT NULL,
  `banglaBookNum` int(11) NOT NULL,
  `banglaBookName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `ourBookID` int(11) NOT NULL,
  `ourBookNum` tinytext COLLATE utf8_unicode_ci,
  `linkpath` tinytext COLLATE utf8_unicode_ci,
  `reference_template` tinytext COLLATE utf8_unicode_ci,
  `firstNumber` int(11) NOT NULL,
  `lastNumber` int(11) NOT NULL,
  `firstURN` int(11) DEFAULT NULL,
  `lastURN` int(11) DEFAULT NULL,
  `totalNumber` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT '2015-01-01 08:00:00',
  `lastHadithUpdated` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `BookData`
--

INSERT INTO `BookData` (`collection`, `englishBookID`, `englishBookNumber`, `englishBookName`, `englishBookIntro`, `arabicBookID`, `arabicBookNumber`, `arabicBookName`, `arabicBookIntro`, `indonesianBookID`, `indonesianBookNum`, `indonesianBookName`, `urduBookID`, `urduBookNum`, `urduBookName`, `banglaBookID`, `banglaBookNum`, `banglaBookName`, `ourBookID`, `ourBookNum`, `linkpath`, `reference_template`, `firstNumber`, `lastNumber`, `firstURN`, `lastURN`, `totalNumber`, `status`, `last_updated`, `lastHadithUpdated`) VALUES
('bukhari', '1.0', 1, 'Revelation', NULL, '1.0', 1, 'كتاب بدء الوحى ', NULL, '1.0', 1, 'Permulaan Wahyu', '1.0', 1, 'کتاب وحی کے بیان میں', '1.0', 1, 'ওহীর সূচনা অধ্যায়', 1, NULL, NULL, NULL, 1, 7, 10, 60, 7, 4, '2013-09-15 22:22:05', NULL),
('bukhari', '2.0', 2, 'Belief', NULL, '2.0', 2, 'كتاب الإيمان ', NULL, '2.0', 2, 'Iman', '2.0', 2, 'کتاب ایمان کے بیان میں', '2.0', 2, 'ঈমান', 2, NULL, NULL, NULL, 8, 58, 70, 550, 51, 4, '2013-09-15 22:22:05', NULL),
('bukhari', '3.0', 3, 'Knowledge', NULL, '3.0', 3, 'كتاب العلم ', NULL, '3.0', 3, 'Ilmu', '3.0', 3, 'کتاب علم کے بیان میں', '3.0', 3, 'ইল্‌ম', 3, NULL, NULL, NULL, 59, 134, 560, 1370, 76, 4, '2013-09-15 22:22:05', NULL),
('bukhari', '4.0', 4, 'Ablutions (Wudu\')', NULL, '4.0', 4, 'كتاب الوضوء', NULL, '4.0', 4, 'Wudlu', '4.0', 4, 'کتاب وضو کے بیان میں', '4.0', 4, 'ওজু', 4, NULL, NULL, NULL, 135, 247, 1380, 2480, 113, 4, '2013-09-15 22:22:05', NULL),
('bukhari', '5.0', 5, 'Bathing (Ghusl)', 'The statement of Allah Most High \"O you who have believed, when you rise to [perform] prayer, wash your faces and your forearms to the elbows and wipe over your heads and wash your feet to the ankles. And if you are in a state of janabah, then purify yourselves. But if you are ill or on a journey or one of you comes from the place of relieving himself or you have contacted women and do not find water, then seek clean earth and wipe over your faces and hands with it. Allah does not intend to make difficulty for you, but He intends to purify you and complete His favor upon you that you may be grateful.\"\r\n<br>\r\nAnd His statement: \"O you who have believed, do not approach prayer while you are intoxicated until you know what you are saying or in a state of janabah, except those passing through [a place of prayer], until you have washed [your whole body]. And if you are ill or on a journey or one of you comes from the place of relieving himself or you have contacted women and find no water, then seek clean earth and wipe over your faces and your hands [with it]. Indeed, Allah is ever Pardoning and Forgiving.\"', '5.0', 5, 'كتاب الغسل ', 'وَقَوْلِ اللَّهِ تَعَالَى ‏{‏وَإِنْ كُنْتُمْ جُنُبًا فَاطَّهَّرُوا وَإِنْ كُنْتُمْ مَرْضَى أَوْ عَلَى سَفَرٍ أَوْ جَاءَ أَحَدٌ مِنْكُمْ مِنَ الْغَائِطِ أَوْ لاَمَسْتُمُ النِّسَاءَ فَلَمْ تَجِدُوا مَاءً فَتَيَمَّمُوا صَعِيدًا طَيِّبًا فَامْسَحُوا بِوُجُوهِكُمْ وَأَيْدِيكُمْ مِنْهُ مَا يُرِيدُ اللَّهُ لِيَجْعَلَ عَلَيْكُمْ مِنْ حَرَجٍ وَلَكِنْ يُرِيدُ لِيُطَهِّرَكُمْ وَلِيُتِمَّ نِعْمَتَهُ عَلَيْكُمْ لَعَلَّكُمْ تَشْكُرُونَ‏}‏ وَقَوْلِهِ جَلَّ ذِكْرُهُ ‏{‏يَا أَيُّهَا الَّذِينَ آمَنُوا لاَ تَقْرَبُوا الصَّلاَةَ وَأَنْتُمْ سُكَارَى حَتَّى تَعْلَمُوا مَا تَقُولُونَ وَلاَ جُنُبًا إِلاَّ عَابِرِي سَبِيلٍ حَتَّى تَغْتَسِلُوا وَإِنْ كُنْتُمْ مَرْضَى أَوْ عَلَى سَفَرٍ أَوْ جَاءَ أَحَدٌ مِنْكُمْ مِنَ الْغَائِطِ أَوْ لاَمَسْتُمُ النِّسَاءَ فَلَمْ تَجِدُوا مَاءً فَتَيَمَّمُوا صَعِيدًا طَيِّبًا فَامْسَحُوا بِوُجُوهِكُمْ وَأَيْدِيكُمْ إِنَّ اللَّهَ كَانَ عَفُوًّا غَفُورًا‏}‏‏.‏', '5.0', 5, 'Mandi', '5.0', 5, 'کتاب غسل کے احکام و مسائل', '5.0', 5, 'গোসল', 5, NULL, NULL, NULL, 248, 293, 2490, 2930, 45, 4, '2020-03-30 03:48:35', NULL),
('bukhari', '6.0', 6, 'Menstrual Periods', 'The statement of Allah Most High \"And they ask you about menstruation. Say, \'It is harm, so keep away from wives during menstruation. And do not approach them until they are pure. And when they have purified themselves, then come to them from where Allah has ordained for you. Indeed, Allah loves those who are constantly repentant and loves those who purify themselves.\'\"', '6.0', 6, 'كتاب الحيض ', 'وَقَوْلِ اللَّهِ تَعَالَى ‏{‏وَيَسْأَلُونَكَ عَنِ الْمَحِيضِ قُلْ هُوَ أَذًى‏}‏ إِلَى قَوْلِهِ ‏{‏وَيُحِبُّ الْمُتَطَهِّرِينَ‏}‏', '6.0', 6, 'Haidl', '6.0', 6, 'کتاب حیض کے احکام و مسائل', '6.0', 6, 'হায়েজ', 6, NULL, NULL, NULL, 294, 333, 2940, 3300, 37, 4, '2020-03-30 03:50:04', NULL),
('bukhari', '7.0', 7, 'Rubbing hands and feet with dust (Tayammum)', 'The saying of Allah: \"But if you ... cannot find water, then purify yourselves with clean earth by wiping your faces and hands.\"', '7.0', 7, 'كتاب التيمم ', 'قَوْلِ اللَّهِ تَعَالَ: فَلَمْ تَجِدُوا مَاءً فَتَيَمَّمُوا صَعِيدًا طَيِّبًا فَامْسَحُوا بِوُجُوهِكُمْ وَأَيْدِيكُم مِّنْهُ', '7.0', 7, 'Tayamum', '7.0', 7, 'کتاب تیمم کے احکام و مسائل', '7.0', 7, 'তায়াম্মুম', 7, NULL, NULL, NULL, 334, 348, 3310, 3450, 15, 4, '2013-09-15 22:22:05', NULL),
('bukhari', '8.0', 8, 'Prayers (Salat)', NULL, '8.0', 8, 'كتاب الصلاة ', NULL, '8.0', 8, 'Shalat', '8.0', 8, 'کتاب نماز کے احکام و مسائل', '8.0', 8, 'সালাত', 8, NULL, NULL, NULL, 349, 520, 3460, 5020, 167, 4, '2013-09-15 22:22:05', NULL),
('bukhari', '10.0', 10, 'Times of the Prayers', NULL, '9.0', 9, 'كتاب مواقيت الصلاة ', NULL, '9.0', 9, 'Waktu-waktu shalat', '9.0', 9, 'کتاب اوقات نماز کے بیان میں', NULL, 0, '', 9, NULL, NULL, NULL, 521, 602, 5030, 5790, 77, 4, '2013-09-15 22:22:05', NULL),
('bukhari', '11.0', 11, 'Call to Prayers (Adhaan)', NULL, '10.0', 10, 'كتاب الأذان ', NULL, '10.0', 10, 'Adzan', '10.0', 10, 'کتاب اذان کے مسائل کے بیان میں', '10.0', 10, 'আযান', 10, NULL, NULL, NULL, 603, 875, 5800, 8358, 266, 4, '2013-09-15 22:22:05', NULL),
('bukhari', '13.0', 13, 'Friday Prayer', NULL, '11.0', 11, 'كتاب الجمعة ', NULL, '11.1', 11, 'Jum\'at', '11.0', 11, 'کتاب جمعہ کے بیان میں', '11.0', 11, 'জুমু\'আ', 11, NULL, NULL, NULL, 876, 941, 8360, 8980, 65, 4, '2013-09-15 22:22:05', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BookData`
--
ALTER TABLE `BookData`
  ADD PRIMARY KEY (`collection`,`ourBookID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
