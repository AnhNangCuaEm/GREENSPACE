-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: greenspace
-- ------------------------------------------------------
-- Server version	8.0.40

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

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `park_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `park_id` (`park_id`),
  KEY `user_email` (`user_email`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`park_id`) REFERENCES `park` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (4,3,'bbb@gmail.com','','綺麗です','2025-01-17 02:31:50','2025-01-17 02:31:50'),(5,14,'bbb@gmail.com','','test test comment','2025-01-17 14:34:49','2025-01-17 14:34:49');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `time` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `price` varchar(100) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `location_yomi` varchar(255) DEFAULT NULL,
  `name_yomi` varchar(255) DEFAULT NULL,
  `location_romaji` varchar(255) DEFAULT NULL,
  `name_romaji` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,'アースデイ東京2025','2025年4月19日(土) ~ 4月20日(日)','10:00 ~ 19:00','環境について考えるイベント。フリーマーケットやワークショップ、オーガニックフードの出店などを通じて、地球環境や持続可能なライフスタイルについて楽しみながら学べます。','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/event/%E3%82%A2%E3%83%BC%E3%83%88%E3%83%95%E3%82%A7%E3%82%A2%E6%9D%B1%E4%BA%AC2025.jpg','0','代々木公園イベント広場','よよぎこうえんイベントひろば','アースデイとうきょう2025','Yoyogi Park','Earth Day Tokyo 2025'),(2,'東京レインボープライド2025','2025年6月開催','別参考','パレードやステージイベント、飲食ブースなどが展開されるLGBTQの祭典で、多様性を祝うとともに、コミュニティへの理解を深めることを目指しています。','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/event/%E6%9D%B1%E4%BA%AC%E3%83%AC%E3%82%A4%E3%83%B3%E3%83%9C%E3%83%BC%E3%83%97%E3%83%A9%E3%82%A4%E3%83%892025.jpg','0','代々木公園（東京都渋谷区）','よよぎこうえん（とうきょうとしぶやく）','とうきょうレインボープライド2025','Yoyogi Park','Tokyo RainBow Pride 2025'),(3,'Anime Japan 2025','2025年3月22日(土) ~ 3月23日(日)','10:00 ~ 18:00','アニメ関連企業や作品の展示会で、ファン向けイベントやグッズ販売、トークショー、特別ステージなど、アニメ愛好者が楽しめる要素が満載です。','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/event/Anime%20Japan%202025.webp','1500','東京ビッグサイト','とうきょうビッグサイト','アニメジャパン 2025','Tokyo Big Sight','Anime Japan 2025'),(4,'肉フェス東京2025','2025年4月26日(土) ~ 5月6日(火)','11:00 ~ 20:00','日本全国のグルメや地域特産品を楽しめるフードイベントで、特に厳選された肉料理が注目のイベントです。ファミリーや友人同士での参加にぴったりです。','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/event/%E8%82%89%E3%83%95%E3%82%A7%E3%82%B9%E6%9D%B1%E4%BA%AC2025.webp','500','日比谷公園','ひびやこうえん','にくフェスとうきょう2025','Hibiya Park','Meat Festival 2025'),(5,'スーパースイーツビュッフェ2025','2024年12月1日(日)～2025年3月31日(月)','11:30～ 90分間','いちごの王様「博多あまおう」をふんだんに使用したスイーツフェアで、甘党にはたまらない贅沢なビュッフェをお楽しみいただけます。','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/event/%E3%82%B9%E3%83%BC%E3%83%91%E3%83%BC%E3%82%B9%E3%82%A4%E3%83%BC%E3%83%84%E3%83%93%E3%83%A5%E3%83%83%E3%83%95%E3%82%A72025.jpg','7000','ホテルニューオータニ','ホテルニューオータニ','スーパースイーツビュッフェ2025','NewOtani Hotel','Super Sweet Buffet 2025'),(6,'アートフェア東京2025','2025年3月7日(金) ~ 3月9日(日)','10:00 ~ 18:00','国内外の現代アート作品の展示と販売が行われるイベントで、新進気鋭のアーティストから有名作家まで、多彩なアートに触れることができます。','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/event/%E3%82%A2%E3%83%BC%E3%82%B9%E3%83%87%E3%82%A4%E6%9D%B1%E4%BA%AC2025.jpg','1500','東京国際フォーラム','とうきょうこくさいフォーラム','アートフェアとうきょう2025','Tokyo International Forum','Art Fair Tokyo 2025'),(7,'サマーソニック2025','2025年8月16日(土) ~ 8月17日(日)','10:00 ~ 22:00','国内外の有名アーティストが出演する大型音楽フェスで、ロック、ポップ、エレクトロニカなど、さまざまなジャンルの音楽を楽しめる最高の夏イベントです。','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/event/%E3%82%B5%E3%83%9E%E3%83%BC%E3%82%BD%E3%83%8B%E3%83%83%E3%82%AF2025.png','12000','ZOZOマリンスタジアム＆幕張メッセ','ZOZOマリンスタジアム＆まくはりメッセ','サマーソニック2025','ZOZO Marines Stadium','Summer Sonic 2025'),(8,'東京イルミリア','2024年11月6日(水)～2025年2月14日(金)','16:30～23:30','東京駅八重洲口から日本橋へ続く日本橋さくら通りを中心に、八重洲・日本橋エリアの街を美しく灯すイルミネーションで、冬の夜を華やかに彩ります。','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/event/%E6%9D%B1%E4%BA%AC%E3%82%A4%E3%83%AB%E3%83%9F%E3%83%AA%E3%82%A2.jpg','0','さくら通り（外堀通り～昭和通り）、八重洲仲通り','さくらどおり（そとぼりどおり～しょうわどおり）、やえすなかどおり','とうきょうイルミリア','Sakura Street','Tokyo Illumilia'),(9,'よみうりランド　ジュエルミネーション','2024年10月24日(木)～2025年4月6日(日)','16:00～20:30','世界的な照明デザイナーが手がけた、よみうりランドの夜を彩る幻想的なイルミネーション。家族や友人と楽しめる特別な体験を提供します。','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/event/%E3%82%88%E3%81%BF%E3%81%86%E3%82%8A%E3%83%A9%E3%83%B3%E3%83%89%E3%80%80%E3%82%B8%E3%83%A5%E3%82%A8%E3%83%AB%E3%83%9F%E3%83%8D%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3.jpg','1800円','よみうりランド ','よみうりランド ','よみうりランド　ジュエルミネーション','Yomiuri Land','YomiuriLand Jewellumination');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_saved`
--

DROP TABLE IF EXISTS `event_saved`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_saved` (
  `event_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_id`,`user_email`),
  KEY `user_email` (`user_email`),
  CONSTRAINT `event_saved_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `event_saved_ibfk_2` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_saved`
--

LOCK TABLES `event_saved` WRITE;
/*!40000 ALTER TABLE `event_saved` DISABLE KEYS */;
INSERT INTO `event_saved` VALUES (2,'bbb@gmail.com','2025-01-16 01:09:13'),(3,'bbb@gmail.com','2025-01-24 01:13:47'),(5,'bbb@gmail.com','2025-01-03 13:25:15');
/*!40000 ALTER TABLE `event_saved` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `uiux` int NOT NULL,
  `content_rating` int NOT NULL,
  `overall` int NOT NULL,
  `feedback_content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  `is_important` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
INSERT INTO `feedback` VALUES (1,'sss@gmail.com',5,4,1,'12/25 8:58PM','2024-12-25 11:58:10',1,0),(55,'sss@gmail.com',5,5,5,'feed back test after change verify login status from session to cookie','2024-12-27 13:29:15',0,0),(57,'bbb@gmail.com',1,1,1,'Beautiful','2025-01-22 09:32:31',0,0);
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_tokens`
--

DROP TABLE IF EXISTS `login_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `email` (`email`),
  CONSTRAINT `login_tokens_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_tokens`
--

LOCK TABLES `login_tokens` WRITE;
/*!40000 ALTER TABLE `login_tokens` DISABLE KEYS */;
INSERT INTO `login_tokens` VALUES (2,'bbb@gmail.com','1fc62684d08f093379a51bd1284bba1c','2024-12-27 21:26:38'),(3,'sss@gmail.com','5464965ebab517b90bc63b57505f8f1f','2024-12-27 21:26:57'),(4,'bbb@gmail.com','b44995676c20812359e83aaed205e3bd','2024-12-27 21:27:25'),(5,'bbb@gmail.com','32c4f8398e2e6770dd9734efe3dbf2ca','2024-12-27 21:28:48'),(8,'bbb@gmail.com','1ea4d3d21e1997651b9822ad9ef9909a','2024-12-27 21:36:08'),(9,'sss@gmail.com','a0eadfe829e918570bc7ebea22633be3','2024-12-27 21:37:07'),(14,'bbb@gmail.com','c20ea91f6d5fb6ddadbaa1a929c54782','2024-12-28 15:30:16'),(15,'qqq@gmail.com','8b7f301407b482dac68f7300c241d3c3','2024-12-28 15:31:14'),(16,'qqq@gmail.com','78f761f14e5cd49fc70b05fbcff19bd0','2024-12-28 16:10:46'),(18,'bbb@gmail.com','f3d6655c3db151ffc132f1384adafa24','2024-12-30 22:39:34'),(20,'bbb@gmail.com','424a6fc6ba0ad10442e5163f04cec277','2024-12-30 22:42:14'),(21,'bbc@gmail.com','774cb6f41c41f3cdb66fe0f4b7968184','2025-01-02 13:39:49'),(22,'sss@gmail.com','90e07d87951ce4cd251caa5b40822fcc','2025-01-04 12:40:01'),(23,'bbb@gmail.com','a759097ffff501955f506019c0ee0d9c','2025-01-04 17:46:04'),(25,'bbb@gmail.com','a74b94743d8e4748e297648fb14f4d9e','2025-01-13 18:47:37'),(26,'bbb@gmail.com','bc41d7410558702e96ec0fed81dd8415','2025-01-14 12:32:23'),(27,'qqq@gmail.com','9b88f7b14ae1be13816c005e30a0c0da','2025-01-16 11:07:51'),(28,'bbb@gmail.com','184c084db8ed4b189eb63c4de38a2ef3','2025-01-17 20:34:51'),(29,'sss@gmail.com','ad0a87f5b842d58283627312cd3707b8','2025-01-18 20:32:53'),(30,'bbb@gmail.com','e6164196a5dd3176907adccd68deb5e7','2025-01-19 19:53:35'),(31,'bbb@gmail.com','a333b7e9de1e020d8bc3356d8abe40f2','2025-01-21 13:33:02'),(32,'hal@gmail.com','8be8f8f68ac99eb1c310c4253aa5b5d7','2025-01-22 12:52:21'),(33,'hal@gmail.com','4b21ca3d802c9656997e4d2ccfe8ce38','2025-01-22 13:02:52'),(34,'bbb@gmail.com','472a6a6b485c9ac05b653ec565c53d8b','2025-01-24 11:53:35'),(35,'hal@gmail.com','b368e1ea0a1f68dba3668080752a4ffb','2025-01-25 18:40:04'),(36,'hal@gmail.com','90748afad9651b88bd620d017d97de12','2025-01-25 18:41:34'),(37,'hal@gmail.com','d0d62357c17eef1be6dbe04e79f2e3a5','2025-01-25 18:48:16');
/*!40000 ALTER TABLE `login_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `target_type` enum('all','specific') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'Test ADD Notification 1','Notification content test','all','2025-01-22 09:21:14','bbb@gmail.com'),(2,'Test ADD Notification 2 ','Notification test 2Notification test 2Notification test 2\nTest test','all','2025-01-22 09:24:56','bbb@gmail.com');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_visits`
--

DROP TABLE IF EXISTS `page_visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_visits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_name` varchar(50) NOT NULL,
  `visitor_ip` varchar(45) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `visit_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `device_type` varchar(20) DEFAULT NULL,
  `browser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_email` (`user_email`),
  CONSTRAINT `page_visits_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=422 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_visits`
--

LOCK TABLES `page_visits` WRITE;
/*!40000 ALTER TABLE `page_visits` DISABLE KEYS */;
INSERT INTO `page_visits` VALUES (1,'index.php','::1','bbb@gmail.com','2025-01-18 10:34:50','desktop','Chrome'),(2,'event.php','::1','bbb@gmail.com','2025-01-18 10:34:55','desktop','Chrome'),(3,'all-event.php','::1','bbb@gmail.com','2025-01-18 10:34:57','desktop','Chrome'),(4,'event.php','::1','bbb@gmail.com','2025-01-18 10:34:58','desktop','Chrome'),(5,'all.php','::1','bbb@gmail.com','2025-01-18 10:35:00','desktop','Chrome'),(6,'profile.php','::1','bbb@gmail.com','2025-01-18 10:35:04','desktop','Chrome'),(7,'index.php','::1','bbb@gmail.com','2025-01-18 10:35:07','desktop','Chrome'),(8,'profile.php','::1','bbb@gmail.com','2025-01-18 10:39:20','desktop','Chrome'),(9,'index.php','::1','bbb@gmail.com','2025-01-18 11:11:42','desktop','Chrome'),(10,'index.php','::1','sss@gmail.com','2025-01-18 11:32:53','desktop','Chrome'),(12,'park.php?id=7','::1','bbb@gmail.com','2025-01-18 11:46:30','desktop','Chrome'),(13,'park.php?id=4','::1','bbb@gmail.com','2025-01-18 11:46:38','desktop','Chrome'),(14,'park.php?id=7','::1','bbb@gmail.com','2025-01-18 11:46:48','desktop','Chrome'),(15,'park.php?id=2','::1','bbb@gmail.com','2025-01-18 11:46:54','desktop','Chrome'),(16,'all-event.php','::1','bbb@gmail.com','2025-01-18 12:11:48','desktop','Chrome'),(17,'all.php','::1','bbb@gmail.com','2025-01-18 12:11:51','desktop','Chrome'),(18,'all-event.php','::1','bbb@gmail.com','2025-01-18 12:12:44','desktop','Chrome'),(19,'event.php?id=5','::1','bbb@gmail.com','2025-01-18 12:12:48','desktop','Chrome'),(20,'all.php','::1','bbb@gmail.com','2025-01-18 16:06:55','desktop','Chrome'),(21,'park.php?id=15','::1','bbb@gmail.com','2025-01-18 16:06:57','desktop','Chrome'),(22,'event.php?id=5','::1','bbb@gmail.com','2025-01-18 16:09:19','desktop','Chrome'),(23,'event.php?id=5','::1','bbb@gmail.com','2025-01-18 16:09:50','desktop','Chrome'),(24,'event.php?id=5','::1','bbb@gmail.com','2025-01-19 02:06:43','desktop','Chrome'),(25,'privacy.php','192.168.0.19','bbb@gmail.com','2025-01-19 05:10:09','mobile','Safari'),(26,'index.php','::1','bbb@gmail.com','2025-01-19 07:18:35','desktop','Chrome'),(27,'park.php?id=3','::1','bbb@gmail.com','2025-01-19 07:19:02','desktop','Chrome'),(28,'index.php','::1','bbb@gmail.com','2025-01-19 07:23:40','desktop','Chrome'),(29,'index.php','::1','bbb@gmail.com','2025-01-19 10:37:45','desktop','Chrome'),(30,'event.php?id=3','::1','bbb@gmail.com','2025-01-19 10:37:58','desktop','Chrome'),(31,'index.php','::1','bbb@gmail.com','2025-01-19 10:49:50','desktop','Chrome'),(32,'index.php','::1','bbb@gmail.com','2025-01-19 10:51:24','desktop','Chrome'),(33,'all.php','::1','bbb@gmail.com','2025-01-19 10:51:54','desktop','Chrome'),(34,'index.php','::1','bbb@gmail.com','2025-01-19 10:53:35','desktop','Chrome'),(35,'profile.php','::1','bbb@gmail.com','2025-01-19 10:55:16','desktop','Chrome'),(36,'all.php','::1','bbb@gmail.com','2025-01-19 10:56:12','desktop','Chrome'),(37,'index.php','::1','bbb@gmail.com','2025-01-19 10:56:22','desktop','Chrome'),(38,'all.php','::1','bbb@gmail.com','2025-01-19 10:57:45','desktop','Chrome'),(39,'index.php','::1','bbb@gmail.com','2025-01-19 11:01:24','desktop','Chrome'),(40,'all.php','::1','bbb@gmail.com','2025-01-19 11:02:03','desktop','Chrome'),(41,'index.php','::1','bbb@gmail.com','2025-01-19 11:03:47','desktop','Chrome'),(42,'index.php','::1','bbb@gmail.com','2025-01-20 01:35:23','desktop','Chrome'),(43,'index.php','::1','bbb@gmail.com','2025-01-21 02:19:12','desktop','Chrome'),(44,'index.php','::1','bbb@gmail.com','2025-01-21 02:23:58','desktop','Chrome'),(45,'all.php','::1','bbb@gmail.com','2025-01-21 02:27:19','desktop','Chrome'),(46,'all-event.php','::1','bbb@gmail.com','2025-01-21 02:27:26','desktop','Chrome'),(47,'all.php','::1','bbb@gmail.com','2025-01-21 02:27:32','desktop','Chrome'),(48,'index.php','::1','bbb@gmail.com','2025-01-21 02:27:47','desktop','Chrome'),(49,'index.php','::1','bbb@gmail.com','2025-01-21 02:32:10','desktop','Chrome'),(50,'index.php','::1','bbb@gmail.com','2025-01-21 02:32:40','desktop','Chrome'),(51,'index.php','::1','bbb@gmail.com','2025-01-21 02:35:15','desktop','Chrome'),(52,'all.php','::1','bbb@gmail.com','2025-01-21 02:36:38','desktop','Chrome'),(53,'all.php','::1','bbb@gmail.com','2025-01-21 02:37:16','desktop','Chrome'),(54,'all.php','::1','bbb@gmail.com','2025-01-21 02:37:30','desktop','Chrome'),(55,'index.php','::1','bbb@gmail.com','2025-01-21 02:37:40','desktop','Chrome'),(56,'all.php','::1','bbb@gmail.com','2025-01-21 02:37:44','desktop','Chrome'),(57,'all.php','::1','bbb@gmail.com','2025-01-21 02:38:16','desktop','Chrome'),(58,'all.php','::1','bbb@gmail.com','2025-01-21 02:43:47','desktop','Chrome'),(59,'profile.php','::1','bbb@gmail.com','2025-01-21 02:44:11','desktop','Chrome'),(60,'index.php','::1','bbb@gmail.com','2025-01-21 02:44:13','desktop','Chrome'),(61,'all.php','::1','bbb@gmail.com','2025-01-21 02:44:15','desktop','Chrome'),(62,'all-event.php','::1','bbb@gmail.com','2025-01-21 02:44:16','desktop','Chrome'),(63,'all-event.php','::1','bbb@gmail.com','2025-01-21 02:46:01','desktop','Chrome'),(64,'all-event.php','::1','bbb@gmail.com','2025-01-21 02:46:04','desktop','Chrome'),(65,'all-event.php','::1','bbb@gmail.com','2025-01-21 02:46:05','desktop','Chrome'),(66,'all.php','::1','bbb@gmail.com','2025-01-21 02:46:08','desktop','Chrome'),(67,'all-event.php','::1','bbb@gmail.com','2025-01-21 02:46:09','desktop','Chrome'),(68,'index.php','::1','bbb@gmail.com','2025-01-21 02:46:11','desktop','Chrome'),(69,'index.php','::1','bbb@gmail.com','2025-01-21 02:46:24','desktop','Chrome'),(70,'index.php','::1','bbb@gmail.com','2025-01-21 02:46:57','desktop','Chrome'),(71,'index.php','::1','bbb@gmail.com','2025-01-21 02:46:59','desktop','Chrome'),(72,'index.php','::1','bbb@gmail.com','2025-01-21 02:47:01','desktop','Chrome'),(73,'index.php','::1','bbb@gmail.com','2025-01-21 02:47:42','desktop','Chrome'),(74,'index.php','::1','bbb@gmail.com','2025-01-21 02:47:50','desktop','Chrome'),(75,'index.php','::1','bbb@gmail.com','2025-01-21 02:47:52','desktop','Chrome'),(76,'index.php','::1','bbb@gmail.com','2025-01-21 02:47:53','desktop','Chrome'),(77,'index.php','::1','bbb@gmail.com','2025-01-21 02:47:55','desktop','Chrome'),(78,'index.php','::1','bbb@gmail.com','2025-01-21 02:47:56','desktop','Chrome'),(79,'all-event.php','::1','bbb@gmail.com','2025-01-21 02:47:59','desktop','Chrome'),(80,'event.php?id=2','::1','bbb@gmail.com','2025-01-21 02:48:00','desktop','Chrome'),(81,'event.php?id=3','::1','bbb@gmail.com','2025-01-21 02:48:02','desktop','Chrome'),(82,'event.php?id=2','::1','bbb@gmail.com','2025-01-21 02:48:05','desktop','Chrome'),(83,'event.php?id=1','::1','bbb@gmail.com','2025-01-21 02:48:06','desktop','Chrome'),(84,'event.php?id=9','::1','bbb@gmail.com','2025-01-21 02:48:07','desktop','Chrome'),(85,'index.php','::1','bbb@gmail.com','2025-01-21 02:48:08','desktop','Chrome'),(86,'index.php','::1','bbb@gmail.com','2025-01-21 02:49:03','desktop','Chrome'),(87,'park.php?id=13','::1','bbb@gmail.com','2025-01-21 02:49:08','desktop','Chrome'),(88,'park.php?id=14','::1','bbb@gmail.com','2025-01-21 02:49:10','desktop','Chrome'),(89,'park.php?id=15','::1','bbb@gmail.com','2025-01-21 02:49:12','desktop','Chrome'),(90,'park.php?id=1','::1','bbb@gmail.com','2025-01-21 02:49:14','desktop','Chrome'),(91,'park.php?id=2','::1','bbb@gmail.com','2025-01-21 02:49:59','desktop','Chrome'),(92,'index.php','::1','bbb@gmail.com','2025-01-21 02:50:26','desktop','Chrome'),(93,'index.php','::1','bbb@gmail.com','2025-01-21 02:53:02','desktop','Chrome'),(94,'all.php','::1','bbb@gmail.com','2025-01-21 02:53:05','desktop','Chrome'),(95,'all-event.php','::1','bbb@gmail.com','2025-01-21 02:53:06','desktop','Chrome'),(96,'index.php','::1','bbb@gmail.com','2025-01-21 02:53:09','desktop','Chrome'),(97,'index.php','::1','bbb@gmail.com','2025-01-21 02:53:13','desktop','Chrome'),(98,'all.php','::1','bbb@gmail.com','2025-01-21 02:53:17','desktop','Chrome'),(99,'all-event.php','::1','bbb@gmail.com','2025-01-21 02:53:18','desktop','Chrome'),(100,'index.php','::1','bbb@gmail.com','2025-01-21 02:53:19','desktop','Chrome'),(101,'index.php','::1','bbb@gmail.com','2025-01-21 02:55:23','desktop','Chrome'),(102,'index.php','::1','bbb@gmail.com','2025-01-21 02:55:25','desktop','Chrome'),(103,'all.php','::1','bbb@gmail.com','2025-01-21 02:55:26','desktop','Chrome'),(104,'all.php','::1','bbb@gmail.com','2025-01-21 02:55:27','desktop','Chrome'),(105,'index.php','::1','bbb@gmail.com','2025-01-21 02:55:34','desktop','Chrome'),(106,'all.php','::1','bbb@gmail.com','2025-01-21 02:55:38','desktop','Chrome'),(107,'all-event.php','::1','bbb@gmail.com','2025-01-21 02:55:40','desktop','Chrome'),(108,'index.php','::1','bbb@gmail.com','2025-01-21 02:55:41','desktop','Chrome'),(109,'index.php','::1','bbb@gmail.com','2025-01-21 02:55:41','desktop','Chrome'),(110,'index.php','::1','bbb@gmail.com','2025-01-21 02:55:48','desktop','Chrome'),(111,'index.php','::1','bbb@gmail.com','2025-01-21 02:56:18','desktop','Chrome'),(112,'index.php','::1','bbb@gmail.com','2025-01-21 02:56:50','desktop','Chrome'),(113,'index.php','::1','bbb@gmail.com','2025-01-21 02:58:36','desktop','Chrome'),(114,'index.php','::1','bbb@gmail.com','2025-01-21 02:59:20','desktop','Chrome'),(115,'index.php','::1','bbb@gmail.com','2025-01-21 03:00:22','desktop','Chrome'),(116,'index.php','::1','bbb@gmail.com','2025-01-21 03:00:30','desktop','Chrome'),(117,'index.php','::1','bbb@gmail.com','2025-01-21 03:01:16','desktop','Chrome'),(118,'index.php','::1','bbb@gmail.com','2025-01-21 03:03:38','desktop','Chrome'),(119,'index.php','::1','bbb@gmail.com','2025-01-21 03:06:09','desktop','Chrome'),(120,'all.php','::1','bbb@gmail.com','2025-01-21 03:06:16','desktop','Chrome'),(121,'all.php','::1','bbb@gmail.com','2025-01-21 03:08:05','desktop','Chrome'),(122,'profile.php','::1','bbb@gmail.com','2025-01-21 03:13:01','desktop','Chrome'),(123,'index.php','::1','bbb@gmail.com','2025-01-21 03:13:04','desktop','Chrome'),(124,'index.php','::1','bbb@gmail.com','2025-01-21 03:26:38','desktop','Chrome'),(125,'index.php','::1','bbb@gmail.com','2025-01-21 03:26:40','desktop','Chrome'),(126,'index.php','::1','bbb@gmail.com','2025-01-21 03:27:18','desktop','Chrome'),(127,'contact.php','::1','bbb@gmail.com','2025-01-21 03:28:18','desktop','Chrome'),(128,'privacy.php','::1','bbb@gmail.com','2025-01-21 03:28:23','desktop','Chrome'),(129,'credit.php','::1','bbb@gmail.com','2025-01-21 03:28:53','desktop','Chrome'),(130,'index.php','::1','bbb@gmail.com','2025-01-21 03:29:16','desktop','Chrome'),(131,'index.php','::1','bbb@gmail.com','2025-01-21 04:33:02','desktop','Chrome'),(132,'all.php','::1','bbb@gmail.com','2025-01-21 04:33:12','desktop','Chrome'),(133,'all.php','::1','bbb@gmail.com','2025-01-21 04:34:11','desktop','Chrome'),(134,'all.php','::1','bbb@gmail.com','2025-01-21 04:34:14','desktop','Chrome'),(135,'all.php','::1','bbb@gmail.com','2025-01-21 04:43:49','desktop','Chrome'),(136,'profile.php','::1','bbb@gmail.com','2025-01-21 04:47:33','desktop','Chrome'),(137,'index.php','::1','bbb@gmail.com','2025-01-21 04:47:38','desktop','Chrome'),(138,'park.php?id=3','::1','bbb@gmail.com','2025-01-21 04:52:33','desktop','Chrome'),(139,'park.php?id=99','::1','bbb@gmail.com','2025-01-21 04:52:37','desktop','Chrome'),(140,'park.php?id=99','::1','bbb@gmail.com','2025-01-21 04:53:09','desktop','Chrome'),(141,'park.php?id=99','::1','bbb@gmail.com','2025-01-21 04:54:43','desktop','Chrome'),(142,'park.php?id=99','::1','bbb@gmail.com','2025-01-21 04:54:44','desktop','Chrome'),(143,'park.php?id=99','::1','bbb@gmail.com','2025-01-21 04:57:35','desktop','Chrome'),(144,'index.php','::1','bbb@gmail.com','2025-01-21 04:57:39','desktop','Chrome'),(145,'park.php?id=10','::1','bbb@gmail.com','2025-01-21 05:00:36','desktop','Chrome'),(146,'park.php?id=10','::1','bbb@gmail.com','2025-01-21 05:00:50','desktop','Chrome'),(147,'park.php?id=99','::1','bbb@gmail.com','2025-01-21 05:00:56','desktop','Chrome'),(148,'park.php','::1','bbb@gmail.com','2025-01-21 05:01:02','desktop','Chrome'),(149,'index.php','::1','bbb@gmail.com','2025-01-21 05:01:02','desktop','Chrome'),(150,'park.php?id=13','::1','bbb@gmail.com','2025-01-21 05:01:04','desktop','Chrome'),(151,'park.php?id=25','::1','bbb@gmail.com','2025-01-21 05:01:07','desktop','Chrome'),(152,'index.php','::1','bbb@gmail.com','2025-01-21 05:01:17','desktop','Chrome'),(153,'event.php?id=1','::1','bbb@gmail.com','2025-01-21 05:03:03','desktop','Chrome'),(154,'event.php?id=1','::1','bbb@gmail.com','2025-01-21 05:03:04','desktop','Chrome'),(155,'event.php?id=99','::1','bbb@gmail.com','2025-01-21 05:03:07','desktop','Chrome'),(156,'index.php','::1','bbb@gmail.com','2025-01-21 05:03:11','desktop','Chrome'),(157,'index.php','::1','bbb@gmail.com','2025-01-21 05:03:17','desktop','Chrome'),(158,'all-event.php','::1','bbb@gmail.com','2025-01-21 05:04:52','desktop','Chrome'),(159,'all.php','::1','bbb@gmail.com','2025-01-21 05:04:55','desktop','Chrome'),(160,'all.php','::1','bbb@gmail.com','2025-01-21 05:18:55','desktop','Chrome'),(161,'all.php','::1','bbb@gmail.com','2025-01-21 05:19:58','desktop','Chrome'),(162,'all.php','::1','bbb@gmail.com','2025-01-22 02:36:48','desktop','Chrome'),(163,'index.php','::1','bbb@gmail.com','2025-01-22 02:36:52','desktop','Chrome'),(164,'profile.php','::1','bbb@gmail.com','2025-01-22 03:13:26','desktop','Chrome'),(165,'contact.php','::1','bbb@gmail.com','2025-01-22 03:17:05','desktop','Chrome'),(166,'index.php','::1','bbb@gmail.com','2025-01-22 03:18:16','desktop','Chrome'),(167,'contact.php','::1','bbb@gmail.com','2025-01-22 03:27:55','desktop','Chrome'),(168,'profile.php','::1','bbb@gmail.com','2025-01-22 03:44:55','desktop','Chrome'),(169,'index.php','::1','hal@gmail.com','2025-01-22 03:52:21','desktop','Chrome'),(170,'profile.php','::1','hal@gmail.com','2025-01-22 03:52:25','desktop','Chrome'),(171,'profile.php','::1','bbb@gmail.com','2025-01-22 04:02:02','desktop','Chrome'),(172,'index.php','::1','hal@gmail.com','2025-01-22 04:02:52','desktop','Chrome'),(173,'profile.php','::1','hal@gmail.com','2025-01-22 04:02:54','desktop','Chrome'),(174,'profile.php','::1','hal@gmail.com','2025-01-22 04:03:08','desktop','Chrome'),(175,'profile.php','::1','bbb@gmail.com','2025-01-22 04:15:01','desktop','Chrome'),(176,'credit.php','::1','bbb@gmail.com','2025-01-22 05:05:21','desktop','Chrome'),(177,'credit.php','::1','bbb@gmail.com','2025-01-22 07:54:43','desktop','Chrome'),(178,'credit.php','::1','bbb@gmail.com','2025-01-22 07:55:24','desktop','Chrome'),(179,'credit.php','::1','bbb@gmail.com','2025-01-22 07:55:46','desktop','Chrome'),(180,'profile.php','::1','bbb@gmail.com','2025-01-22 07:56:10','desktop','Chrome'),(181,'credit.php','::1','bbb@gmail.com','2025-01-22 07:58:12','desktop','Chrome'),(182,'credit.php','::1','bbb@gmail.com','2025-01-22 07:59:13','desktop','Chrome'),(183,'credit.php','::1','bbb@gmail.com','2025-01-22 08:00:42','desktop','Chrome'),(184,'credit.php','::1','bbb@gmail.com','2025-01-22 08:01:17','desktop','Chrome'),(185,'profile.php','::1','bbb@gmail.com','2025-01-22 08:01:19','desktop','Chrome'),(186,'credit.php','::1','bbb@gmail.com','2025-01-22 08:01:43','desktop','Chrome'),(187,'credit.php','::1','bbb@gmail.com','2025-01-22 08:01:56','desktop','Chrome'),(188,'credit.php','::1','bbb@gmail.com','2025-01-22 08:02:31','desktop','Chrome'),(189,'credit.php','::1','bbb@gmail.com','2025-01-22 08:05:56','desktop','Chrome'),(190,'credit.php','::1','bbb@gmail.com','2025-01-22 08:44:53','desktop','Chrome'),(191,'credit.php','::1','bbb@gmail.com','2025-01-22 08:47:04','desktop','Chrome'),(192,'credit.php','::1','bbb@gmail.com','2025-01-22 08:49:31','desktop','Chrome'),(193,'credit.php','::1','bbb@gmail.com','2025-01-22 08:50:49','desktop','Chrome'),(194,'credit.php','::1','bbb@gmail.com','2025-01-22 08:51:06','desktop','Chrome'),(195,'credit.php','::1','bbb@gmail.com','2025-01-22 08:52:02','desktop','Chrome'),(196,'credit.php','::1','bbb@gmail.com','2025-01-22 08:54:00','desktop','Chrome'),(197,'credit.php','::1','bbb@gmail.com','2025-01-22 08:54:03','desktop','Chrome'),(198,'credit.php','::1','bbb@gmail.com','2025-01-22 08:55:50','desktop','Chrome'),(199,'profile.php','::1','bbb@gmail.com','2025-01-22 09:32:18','desktop','Chrome'),(200,'contact.php','::1','bbb@gmail.com','2025-01-22 09:32:21','desktop','Chrome'),(201,'index.php','::1','bbb@gmail.com','2025-01-23 00:36:48','desktop','Chrome'),(202,'event.php?id=6','::1','bbb@gmail.com','2025-01-23 00:37:18','desktop','Chrome'),(203,'all.php','::1','bbb@gmail.com','2025-01-23 01:35:38','desktop','Chrome'),(204,'index.php','::1','bbb@gmail.com','2025-01-23 01:35:43','desktop','Chrome'),(205,'profile.php','::1','bbb@gmail.com','2025-01-23 01:35:48','desktop','Chrome'),(206,'profile.php','::1','bbb@gmail.com','2025-01-23 07:17:07','desktop','Chrome'),(207,'profile.php','::1','bbb@gmail.com','2025-01-23 07:28:44','desktop','Chrome'),(208,'park.php?id=7','::1','bbb@gmail.com','2025-01-23 07:33:00','desktop','Chrome'),(209,'profile.php','::1','bbb@gmail.com','2025-01-23 07:33:01','desktop','Chrome'),(210,'all.php','::1','bbb@gmail.com','2025-01-23 07:34:04','desktop','Chrome'),(211,'all-event.php','::1','bbb@gmail.com','2025-01-23 07:34:11','desktop','Chrome'),(212,'index.php','::1','bbb@gmail.com','2025-01-23 07:34:18','desktop','Chrome'),(213,'profile.php','::1','bbb@gmail.com','2025-01-23 07:34:32','desktop','Chrome'),(214,'all-event.php','::1','bbb@gmail.com','2025-01-23 07:34:35','desktop','Chrome'),(215,'index.php','::1','bbb@gmail.com','2025-01-23 07:34:43','desktop','Chrome'),(216,'index.php','::1','bbb@gmail.com','2025-01-23 07:36:40','desktop','Chrome'),(217,'index.php','::1','bbb@gmail.com','2025-01-23 07:37:06','desktop','Chrome'),(218,'index.php','::1','bbb@gmail.com','2025-01-23 07:37:51','desktop','Chrome'),(219,'all-event.php','::1','bbb@gmail.com','2025-01-23 07:37:55','desktop','Chrome'),(220,'profile.php','::1','bbb@gmail.com','2025-01-23 07:37:57','desktop','Chrome'),(221,'profile.php','::1','bbb@gmail.com','2025-01-23 07:38:29','desktop','Chrome'),(222,'profile.php','::1','bbb@gmail.com','2025-01-23 07:39:03','desktop','Chrome'),(223,'index.php','::1','bbb@gmail.com','2025-01-23 07:39:40','desktop','Chrome'),(224,'profile.php','::1','bbb@gmail.com','2025-01-23 07:39:59','desktop','Chrome'),(225,'profile.php','::1','bbb@gmail.com','2025-01-23 07:41:00','desktop','Chrome'),(226,'index.php','::1','bbb@gmail.com','2025-01-23 07:51:50','desktop','Chrome'),(227,'index.php','::1','bbb@gmail.com','2025-01-23 07:53:16','desktop','Chrome'),(228,'profile.php','::1','bbb@gmail.com','2025-01-23 07:53:17','desktop','Chrome'),(229,'profile.php','::1','bbb@gmail.com','2025-01-23 07:54:04','desktop','Chrome'),(230,'index.php','::1','bbb@gmail.com','2025-01-24 00:36:21','desktop','Chrome'),(231,'profile.php','::1','bbb@gmail.com','2025-01-24 01:13:16','desktop','Chrome'),(232,'all-event.php','::1','bbb@gmail.com','2025-01-24 01:13:41','desktop','Chrome'),(233,'profile.php','::1','bbb@gmail.com','2025-01-24 01:13:48','desktop','Chrome'),(234,'all-event.php','::1','bbb@gmail.com','2025-01-24 01:13:52','desktop','Chrome'),(235,'index.php','::1','bbb@gmail.com','2025-01-24 01:14:05','desktop','Chrome'),(236,'profile.php','::1','bbb@gmail.com','2025-01-24 01:14:19','desktop','Chrome'),(237,'profile.php','::1','bbb@gmail.com','2025-01-24 01:22:07','desktop','Chrome'),(238,'profile.php','::1','bbb@gmail.com','2025-01-24 02:22:46','desktop','Chrome'),(239,'index.php','::1','bbb@gmail.com','2025-01-24 02:22:48','desktop','Chrome'),(240,'profile.php','::1','bbb@gmail.com','2025-01-24 02:23:13','desktop','Chrome'),(241,'index.php','::1','bbb@gmail.com','2025-01-24 02:43:26','desktop','Chrome'),(242,'index.php','::1','bbb@gmail.com','2025-01-24 02:43:38','desktop','Chrome'),(243,'index.php','10.205.115.91','bbb@gmail.com','2025-01-24 02:53:35','mobile','Safari'),(244,'all.php','10.205.115.91','bbb@gmail.com','2025-01-24 02:56:53','mobile','Safari'),(245,'credit.php','10.205.115.91','bbb@gmail.com','2025-01-24 02:57:05','mobile','Safari'),(246,'credit.php','10.205.115.91','bbb@gmail.com','2025-01-24 02:59:42','mobile','Safari'),(247,'index.php','10.205.115.91','bbb@gmail.com','2025-01-24 02:59:45','mobile','Safari'),(248,'index.php','::1','bbb@gmail.com','2025-01-25 01:32:55','desktop','Chrome'),(249,'index.php','::1','bbb@gmail.com','2025-01-25 01:44:17','desktop','Chrome'),(250,'park.php?id=2','::1','bbb@gmail.com','2025-01-25 01:51:08','desktop','Chrome'),(251,'privacy.php','::1','bbb@gmail.com','2025-01-25 01:51:25','desktop','Chrome'),(252,'credit.php','::1','bbb@gmail.com','2025-01-25 01:52:20','desktop','Chrome'),(253,'profile.php','::1','bbb@gmail.com','2025-01-25 01:53:51','desktop','Chrome'),(254,'park.php?id=7','::1','bbb@gmail.com','2025-01-25 01:54:18','desktop','Chrome'),(255,'index.php','::1','bbb@gmail.com','2025-01-25 09:33:27','desktop','Chrome'),(256,'profile.php','::1','bbb@gmail.com','2025-01-25 09:33:36','desktop','Chrome'),(257,'profile.php','::1','bbb@gmail.com','2025-01-25 09:35:22','desktop','Chrome'),(258,'index.php','::1','hal@gmail.com','2025-01-25 09:40:04','desktop','Chrome'),(259,'index.php','::1','hal@gmail.com','2025-01-25 09:40:14','desktop','Chrome'),(260,'all.php','::1','hal@gmail.com','2025-01-25 09:40:18','desktop','Chrome'),(261,'all-event.php','::1','hal@gmail.com','2025-01-25 09:40:20','desktop','Chrome'),(262,'profile.php','::1','hal@gmail.com','2025-01-25 09:40:32','desktop','Chrome'),(263,'index.php','192.168.0.19','hal@gmail.com','2025-01-25 09:41:34','mobile','Safari'),(264,'all-event.php','192.168.0.19','hal@gmail.com','2025-01-25 09:43:10','mobile','Safari'),(265,'contact.php','192.168.0.19','hal@gmail.com','2025-01-25 09:43:16','mobile','Safari'),(266,'privacy.php','192.168.0.19','hal@gmail.com','2025-01-25 09:43:36','mobile','Safari'),(267,'credit.php','192.168.0.19','hal@gmail.com','2025-01-25 09:43:45','mobile','Safari'),(268,'profile.php','192.168.0.19','hal@gmail.com','2025-01-25 09:44:00','mobile','Safari'),(269,'profile.php','192.168.0.19','hal@gmail.com','2025-01-25 09:44:08','mobile','Safari'),(270,'index.php','192.168.0.19','hal@gmail.com','2025-01-25 09:44:09','mobile','Safari'),(271,'index.php','::1','hal@gmail.com','2025-01-25 09:45:00','desktop','Chrome'),(272,'index.php','::1','hal@gmail.com','2025-01-25 09:47:27','desktop','Chrome'),(273,'index.php','192.168.0.19','hal@gmail.com','2025-01-25 09:47:37','mobile','Safari'),(274,'profile.php','192.168.0.19','hal@gmail.com','2025-01-25 09:47:56','mobile','Safari'),(275,'index.php','192.168.0.19','hal@gmail.com','2025-01-25 09:48:16','mobile','Safari'),(276,'contact.php','192.168.0.19','hal@gmail.com','2025-01-25 09:50:17','mobile','Safari'),(277,'contact.php','192.168.0.19','hal@gmail.com','2025-01-25 09:50:21','mobile','Safari'),(278,'contact.php','192.168.0.19','hal@gmail.com','2025-01-25 09:50:29','mobile','Safari'),(279,'profile.php','::1','hal@gmail.com','2025-01-25 09:54:04','desktop','Chrome'),(280,'profile.php','::1','hal@gmail.com','2025-01-25 09:54:27','desktop','Chrome'),(281,'profile.php','::1','hal@gmail.com','2025-01-25 09:54:33','desktop','Chrome'),(282,'profile.php','::1','hal@gmail.com','2025-01-25 10:06:59','desktop','Chrome'),(283,'profile.php','::1','hal@gmail.com','2025-01-25 10:08:13','desktop','Chrome'),(284,'profile.php','::1','hal@gmail.com','2025-01-25 10:10:02','desktop','Chrome'),(285,'profile.php','::1','hal@gmail.com','2025-01-25 10:14:58','desktop','Chrome'),(286,'profile.php','::1','hal@gmail.com','2025-01-25 10:17:49','desktop','Chrome'),(287,'profile.php','::1','hal@gmail.com','2025-01-25 10:18:35','desktop','Chrome'),(288,'profile.php','::1','hal@gmail.com','2025-01-25 10:19:38','desktop','Chrome'),(289,'profile.php','::1','hal@gmail.com','2025-01-25 10:19:54','desktop','Chrome'),(290,'profile.php','::1','hal@gmail.com','2025-01-25 10:20:34','desktop','Chrome'),(291,'profile.php','::1','hal@gmail.com','2025-01-25 10:21:17','desktop','Chrome'),(292,'profile.php','::1','hal@gmail.com','2025-01-25 10:21:39','desktop','Chrome'),(293,'profile.php','::1','hal@gmail.com','2025-01-25 10:21:43','desktop','Chrome'),(294,'index.php','::1','hal@gmail.com','2025-01-25 10:24:56','desktop','Chrome'),(295,'all.php','::1','hal@gmail.com','2025-01-25 10:25:14','desktop','Chrome'),(296,'privacy.php','::1','hal@gmail.com','2025-01-25 10:25:23','desktop','Chrome'),(297,'privacy.php','::1','hal@gmail.com','2025-01-25 12:06:00','desktop','Chrome'),(298,'contact.php','192.168.0.19','hal@gmail.com','2025-01-25 12:06:11','mobile','Safari'),(299,'index.php','192.168.0.19','hal@gmail.com','2025-01-25 12:06:53','mobile','Safari'),(300,'index.php','::1','hal@gmail.com','2025-01-25 12:07:07','desktop','Chrome'),(301,'index.php','::1','hal@gmail.com','2025-01-25 15:12:28','desktop','Chrome'),(302,'index.php','::1','hal@gmail.com','2025-01-25 15:12:53','desktop','Chrome'),(303,'index.php','::1','hal@gmail.com','2025-01-25 15:12:54','desktop','Chrome'),(304,'index.php','::1','hal@gmail.com','2025-01-25 15:13:02','desktop','Chrome'),(305,'index.php','::1','hal@gmail.com','2025-01-25 15:13:15','desktop','Chrome'),(306,'index.php','::1','hal@gmail.com','2025-01-25 15:14:27','desktop','Chrome'),(307,'index.php','::1','hal@gmail.com','2025-01-25 15:14:43','desktop','Chrome'),(308,'index.php','::1','hal@gmail.com','2025-01-25 15:14:55','desktop','Chrome'),(309,'index.php','::1','hal@gmail.com','2025-01-25 15:15:21','desktop','Chrome'),(310,'index.php','::1','hal@gmail.com','2025-01-25 15:15:35','desktop','Chrome'),(311,'index.php','::1','hal@gmail.com','2025-01-25 15:15:47','desktop','Chrome'),(312,'index.php','::1','hal@gmail.com','2025-01-25 15:16:00','desktop','Chrome'),(313,'index.php','::1','hal@gmail.com','2025-01-26 00:44:41','desktop','Chrome'),(314,'index.php','::1','hal@gmail.com','2025-01-26 07:08:54','desktop','Chrome'),(315,'profile.php','::1','hal@gmail.com','2025-01-26 07:09:07','desktop','Chrome'),(316,'index.php','::1','hal@gmail.com','2025-01-26 07:09:17','desktop','Chrome'),(317,'index.php','192.168.0.19','hal@gmail.com','2025-01-26 07:51:16','mobile','Safari'),(318,'park.php?id=14','192.168.0.19','hal@gmail.com','2025-01-26 07:51:41','mobile','Safari'),(319,'park.php?id=13','192.168.0.19','hal@gmail.com','2025-01-26 07:51:51','mobile','Safari'),(320,'all.php','192.168.0.19','hal@gmail.com','2025-01-26 07:52:03','mobile','Safari'),(321,'contact.php','192.168.0.19','hal@gmail.com','2025-01-26 07:52:15','mobile','Safari'),(322,'contact.php','192.168.0.19','hal@gmail.com','2025-01-26 07:52:33','mobile','Safari'),(323,'privacy.php','192.168.0.19','hal@gmail.com','2025-01-26 07:52:35','mobile','Safari'),(324,'privacy.php','::1','hal@gmail.com','2025-01-26 07:53:04','desktop','Chrome'),(325,'privacy.php','::1','hal@gmail.com','2025-01-26 07:54:27','desktop','Chrome'),(326,'privacy.php','192.168.0.19','hal@gmail.com','2025-01-26 07:54:30','mobile','Safari'),(327,'profile.php','192.168.0.19','hal@gmail.com','2025-01-26 07:54:43','mobile','Safari'),(328,'privacy.php','192.168.0.19','hal@gmail.com','2025-01-26 07:54:46','mobile','Safari'),(329,'privacy.php','::1','hal@gmail.com','2025-01-26 07:55:24','desktop','Chrome'),(330,'privacy.php','::1','hal@gmail.com','2025-01-26 07:55:25','desktop','Chrome'),(331,'credit.php','192.168.0.19','hal@gmail.com','2025-01-26 07:55:39','mobile','Safari'),(332,'index.php','::1','hal@gmail.com','2025-01-26 09:53:27','desktop','Chrome'),(333,'all.php','::1','hal@gmail.com','2025-01-26 09:53:30','desktop','Chrome'),(334,'park.php?id=1','::1','hal@gmail.com','2025-01-26 09:53:34','desktop','Chrome'),(335,'all.php','::1','hal@gmail.com','2025-01-26 09:54:31','desktop','Chrome'),(336,'park.php?id=3','::1','hal@gmail.com','2025-01-26 09:55:08','desktop','Chrome'),(337,'park.php?id=4','::1','hal@gmail.com','2025-01-26 09:56:44','desktop','Chrome'),(338,'park.php?id=5','::1','hal@gmail.com','2025-01-26 09:56:45','desktop','Chrome'),(339,'park.php?id=4','::1','hal@gmail.com','2025-01-26 09:56:46','desktop','Chrome'),(340,'park.php?id=3','::1','hal@gmail.com','2025-01-26 09:56:47','desktop','Chrome'),(341,'park.php?id=2','::1','hal@gmail.com','2025-01-26 09:56:47','desktop','Chrome'),(342,'park.php?id=1','::1','hal@gmail.com','2025-01-26 09:56:48','desktop','Chrome'),(343,'park.php?id=2','::1','hal@gmail.com','2025-01-26 09:56:49','desktop','Chrome'),(344,'park.php?id=3','::1','hal@gmail.com','2025-01-26 09:56:52','desktop','Chrome'),(345,'park.php?id=4','::1','hal@gmail.com','2025-01-26 09:56:53','desktop','Chrome'),(346,'park.php?id=5','::1','hal@gmail.com','2025-01-26 09:56:55','desktop','Chrome'),(347,'park.php?id=6','::1','hal@gmail.com','2025-01-26 09:58:49','desktop','Chrome'),(348,'park.php?id=7','::1','hal@gmail.com','2025-01-26 09:59:01','desktop','Chrome'),(349,'park.php?id=8','::1','hal@gmail.com','2025-01-26 09:59:03','desktop','Chrome'),(350,'park.php?id=9','::1','hal@gmail.com','2025-01-26 10:00:06','desktop','Chrome'),(351,'park.php?id=10','::1','hal@gmail.com','2025-01-26 10:00:13','desktop','Chrome'),(352,'park.php?id=11','::1','hal@gmail.com','2025-01-26 10:00:23','desktop','Chrome'),(353,'park.php?id=12','::1','hal@gmail.com','2025-01-26 10:03:36','desktop','Chrome'),(354,'park.php?id=12','::1','hal@gmail.com','2025-01-26 10:06:14','desktop','Chrome'),(355,'park.php?id=11','::1','hal@gmail.com','2025-01-26 10:06:17','desktop','Chrome'),(356,'park.php?id=11','::1','hal@gmail.com','2025-01-26 10:06:22','desktop','Chrome'),(357,'park.php?id=11','::1','hal@gmail.com','2025-01-26 10:06:43','desktop','Chrome'),(358,'park.php?id=12','::1','hal@gmail.com','2025-01-26 10:06:48','desktop','Chrome'),(359,'park.php?id=12','::1','hal@gmail.com','2025-01-26 10:07:08','desktop','Chrome'),(360,'park.php?id=13','::1','hal@gmail.com','2025-01-26 10:07:10','desktop','Chrome'),(361,'park.php?id=12','::1','hal@gmail.com','2025-01-26 10:07:12','desktop','Chrome'),(362,'park.php?id=11','::1','hal@gmail.com','2025-01-26 10:07:13','desktop','Chrome'),(363,'park.php?id=12','::1','hal@gmail.com','2025-01-26 10:07:36','desktop','Chrome'),(364,'park.php?id=13','::1','hal@gmail.com','2025-01-26 10:07:49','desktop','Chrome'),(365,'park.php?id=14','::1','hal@gmail.com','2025-01-26 10:07:58','desktop','Chrome'),(366,'park.php?id=15','::1','hal@gmail.com','2025-01-26 10:09:26','desktop','Chrome'),(367,'park.php?id=1','::1','hal@gmail.com','2025-01-26 10:09:28','desktop','Chrome'),(368,'park.php?id=15','::1','hal@gmail.com','2025-01-26 10:09:29','desktop','Chrome'),(369,'index.php','::1','hal@gmail.com','2025-01-26 10:19:31','desktop','Chrome'),(370,'park.php?id=5','::1','hal@gmail.com','2025-01-26 10:19:36','desktop','Chrome'),(371,'index.php','::1','hal@gmail.com','2025-01-27 07:46:08','desktop','Chrome'),(372,'credit.php','192.168.0.19','hal@gmail.com','2025-01-27 11:29:52','mobile','Safari'),(373,'index.php','::1','hal@gmail.com','2025-01-28 01:10:26','desktop','Chrome'),(374,'all.php','::1','hal@gmail.com','2025-01-28 07:25:12','desktop','Chrome'),(375,'park.php?id=7','::1','hal@gmail.com','2025-01-28 07:32:54','desktop','Chrome'),(376,'index.php','::1','hal@gmail.com','2025-01-28 07:45:10','desktop','Chrome'),(377,'all.php','::1','hal@gmail.com','2025-01-28 07:45:11','desktop','Chrome'),(378,'all.php','::1','hal@gmail.com','2025-01-28 07:45:13','desktop','Chrome'),(379,'all.php','::1','hal@gmail.com','2025-01-28 07:45:14','desktop','Chrome'),(380,'park.php?id=5','::1','hal@gmail.com','2025-01-28 07:45:23','desktop','Chrome'),(381,'park.php?id=5','::1','hal@gmail.com','2025-01-28 07:47:04','desktop','Chrome'),(382,'park.php?id=5','::1','hal@gmail.com','2025-01-28 07:47:47','desktop','Chrome'),(383,'park.php?id=5','::1','hal@gmail.com','2025-01-28 07:49:04','desktop','Chrome'),(384,'park.php?id=5','::1','hal@gmail.com','2025-01-28 07:49:40','desktop','Chrome'),(385,'all.php','::1','hal@gmail.com','2025-01-28 07:52:20','desktop','Chrome'),(386,'park.php?id=3','::1','hal@gmail.com','2025-01-28 07:54:43','desktop','Chrome'),(387,'park.php?id=1','::1','hal@gmail.com','2025-01-28 07:55:37','desktop','Chrome'),(388,'all.php','::1','hal@gmail.com','2025-01-28 07:57:17','desktop','Chrome'),(389,'park.php?id=9','::1','hal@gmail.com','2025-01-28 07:57:22','desktop','Chrome'),(390,'park.php?id=8','::1','hal@gmail.com','2025-01-28 07:57:22','desktop','Chrome'),(391,'park.php?id=10','::1','hal@gmail.com','2025-01-28 07:57:23','desktop','Chrome'),(392,'park.php?id=11','::1','hal@gmail.com','2025-01-28 07:57:24','desktop','Chrome'),(393,'park.php?id=12','::1','hal@gmail.com','2025-01-28 07:57:24','desktop','Chrome'),(394,'park.php?id=11','::1','hal@gmail.com','2025-01-28 08:06:53','desktop','Chrome'),(395,'all.php','::1','hal@gmail.com','2025-01-28 08:07:16','desktop','Chrome'),(396,'profile.php','192.168.0.19','hal@gmail.com','2025-01-29 01:58:19','mobile','Safari'),(397,'privacy.php','192.168.0.19','hal@gmail.com','2025-01-29 02:07:23','mobile','Safari'),(398,'privacy.php','192.168.0.19','hal@gmail.com','2025-01-29 02:07:41','mobile','Safari'),(399,'credit.php','192.168.0.19','hal@gmail.com','2025-01-29 02:07:43','mobile','Safari'),(400,'all.php','192.168.0.19','hal@gmail.com','2025-01-29 02:08:13','mobile','Safari'),(401,'park.php?id=5','192.168.0.19','hal@gmail.com','2025-01-29 02:08:22','mobile','Safari'),(402,'profile.php','192.168.0.19','hal@gmail.com','2025-01-29 02:08:40','mobile','Safari'),(403,'profile.php','192.168.0.19','hal@gmail.com','2025-01-29 02:09:27','mobile','Safari'),(404,'index.php','192.168.0.19','hal@gmail.com','2025-01-29 02:09:37','mobile','Safari'),(405,'index.php','::1','hal@gmail.com','2025-01-29 11:36:05','desktop','Chrome'),(406,'all-event.php','::1','hal@gmail.com','2025-01-29 11:36:32','desktop','Chrome'),(407,'index.php','::1','hal@gmail.com','2025-01-29 11:36:55','desktop','Chrome'),(408,'index.php','::1','hal@gmail.com','2025-01-29 13:24:32','desktop','Chrome'),(409,'all.php','::1','hal@gmail.com','2025-01-29 13:24:44','desktop','Chrome'),(410,'park.php?id=2','::1','hal@gmail.com','2025-01-29 13:24:55','desktop','Chrome'),(411,'profile.php','192.168.0.19','hal@gmail.com','2025-01-29 13:26:17','mobile','Safari'),(412,'index.php','192.168.0.19','hal@gmail.com','2025-01-29 13:26:20','mobile','Safari'),(413,'index.php','192.168.0.19','hal@gmail.com','2025-01-29 13:26:22','mobile','Safari'),(414,'index.php','192.168.0.19','hal@gmail.com','2025-01-29 13:26:24','mobile','Safari'),(415,'index.php','192.168.0.19','hal@gmail.com','2025-01-29 13:26:25','mobile','Safari'),(416,'index.php','192.168.0.19','hal@gmail.com','2025-01-29 13:26:27','mobile','Safari'),(417,'park.php?id=2','192.168.0.19','hal@gmail.com','2025-01-29 13:26:37','mobile','Safari'),(418,'park.php?id=2','192.168.0.19','hal@gmail.com','2025-01-29 13:26:45','mobile','Safari'),(419,'index.php','192.168.0.19','hal@gmail.com','2025-01-29 13:26:54','mobile','Safari'),(420,'park.php?id=14','192.168.0.19','hal@gmail.com','2025-01-29 13:26:59','mobile','Safari'),(421,'park.php?id=14','192.168.0.19','hal@gmail.com','2025-01-29 13:27:05','mobile','Safari');
/*!40000 ALTER TABLE `page_visits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `park`
--

DROP TABLE IF EXISTS `park`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `park` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `location` varchar(500) NOT NULL,
  `description` text,
  `price` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `thumbnail` varchar(255) DEFAULT NULL,
  `map` varchar(500) DEFAULT NULL,
  `nearest` varchar(255) DEFAULT NULL,
  `special` varchar(255) DEFAULT NULL,
  `parkfeature` varchar(255) DEFAULT NULL,
  `location_yomi` varchar(255) DEFAULT NULL,
  `name_yomi` varchar(255) DEFAULT NULL,
  `location_romaji` varchar(255) DEFAULT NULL,
  `name_romaji` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `park`
--

LOCK TABLES `park` WRITE;
/*!40000 ALTER TABLE `park` DISABLE KEYS */;
INSERT INTO `park` VALUES (1,'上野恩賜公園','530,000\n','東京都台東区上野公園5-20','東京を代表する歴史的な公園で、美術館や博物館など文化的な施設が充実しています。不忍池では四季折々の自然を楽しむことができ、特に春には桜の名所として多くの人が訪れます。','入園無料（一部施設有料）','2024-12-24 21:00:23','2025-01-17 22:25:19','/GREENSPACE/img/img/dummy-green.png','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3239.4660255062136!2d139.76866759678958!3d35.714755700000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188e9b45906ac3%3A0xb1cb3623124e645a!2z5LiK6YeO5oGp6LOc5YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120042654!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','上野駅（JR山手線・東京メトロ銀座線）から徒歩5分<br>京成上野駅（京成線）から徒歩3分','美術館や博物館が多く併設され、不忍池ではボート遊びが楽しめる。桜の名所としても知られる。','東京を代表する歴史的な公園で、美術館や博物館など文化的な施設が充実しています。不忍池では四季折々の自然を楽しむことができ、特に春には桜の名所として多くの人が訪れます。','とうきょうとたいとうくうえのこうえん5-20','うえのおんしこーえん','5-20 Ueno-koen, Taito-ku, Tokyo','Ueno Park'),(2,'代々木公園','540,000','東京都渋谷区代々木神園町2-1','東京最大級の緑豊かな公園で、広大な芝生広場やジョギングコースがあります。季節ごとにイベントやフェスティバルが開催され、都会のオアシスとして人気です。','入園無料','2024-12-24 21:00:23','2025-01-29 22:23:56','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Yoyogi/IMG_2927.jpg','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.281532826417!2d139.69239067715077!3d35.67006923058478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188cb479620a33%3A0x34bcc78ce7f8bf3e!2z5Luj44CF5pyo5YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120063915!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','原宿駅（JR山手線）から徒歩5分<br>代々木公園駅（東京メトロ千代田線）から徒歩3分','大規模なイベントが行われることが多く、ジョギングやサイクリングに最適。','東京最大級の緑豊かな公園で、広大な芝生広場やジョギングコースがあります。季節ごとにイベントやフェスティバルが開催され、都会のオアシスとして人気です。','とうきょうとしぶやくよよぎかみぞのちょう2-1','よよぎこーえん','2-1 Yoyogi-Kamizono-cho, Shibuya-ku, Tokyo','Yoyogi Park'),(3,'日比谷公園','160,000\n','東京都千代田区日比谷公園1-6','日本初の洋風庭園で、四季折々の花壇や噴水が美しい景観を作り出しています。散策や読書を楽しむのに適した静かな空間です。','入園無料','2024-12-24 21:00:23','2025-01-17 22:25:19','/GREENSPACE/img/img/dummy.png','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6482.264404043464!2d139.75113589991193!3d35.67374665595228!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188bf23857acc7%3A0x709c7696a9fafab4!2z5pel5q-U6LC35YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120101178!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','日比谷駅（東京メトロ日比谷線）から徒歩2分<br>有楽町駅（JR山手線）から徒歩5分','大きな噴水とステージがあり、コンサートやイベントが頻繁に開催される。\n','日本初の洋風庭園で、四季折々の花壇や噴水が美しい景観を作り出しています。散策や読書を楽しむのに適した静かな空間です。','とうきょうとちよだくひびやこうえん1-6','ひびやこーえん',' - 1-6 Hibiya-koen, Chiyoda-ku, Tokyo','Hibiya Park'),(4,'新宿御苑','58,000','東京都新宿区内藤町11','日本庭園と洋風庭園が融合した広大で美しい庭園です。春には桜が見事で、秋には紅葉も楽しめます。都会の喧騒を忘れる癒しのスポットです。','大人500円','2024-12-24 21:00:23','2025-01-28 16:38:15','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShinjukuGyoen/2024_12_25_14_31_IMG_2763.jpg','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.6678124029854!2d139.707476777151!3d35.68518062975499!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188cc21b93233f%3A0x6a1eb1b5a117f287!2z5paw5a6_5b6h6IuR!5e0!3m2!1sja!2sjp!4v1737120116307!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','新宿御苑前駅（東京メトロ丸ノ内線）から徒歩5分<br>千駄ヶ谷駅（JR中央・総武線）から徒歩10分','桜の名所として有名で、広大な敷地に日本庭園やフランス庭園が併設。','日本庭園と洋風庭園が融合した広大で美しい庭園です。春には桜が見事で、秋には紅葉も楽しめます。都会の喧騒を忘れる癒しのスポットです。','とうきょうとしんじゅくくないふじまち11','しんじゅくぎょえん',' - 11 Naito-machi, Shinjuku-ku, Tokyo','Shinjuku Gyoen National Garden'),(5,'国営昭和記念公園','1,800,000','東京都立川市緑町3173','広大な敷地内には花畑やバーベキュー施設、子供向けの遊具エリアがあります。サイクリングやボート遊びなどアクティブな楽しみ方ができ、家族連れに人気です。','大人450円','2024-12-24 21:00:23','2025-01-28 16:44:37','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShowaKinen/IMG_2860.jpg','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d20180.312061200882!2d139.3786310680867!3d35.70195966832971!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018e1ace14bd40b%3A0xd7da4db683b53513!2z5Zu95Za25pit5ZKM6KiY5b-15YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120135380!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','西立川駅（JR青梅線）から徒歩2分<br>立川駅（JR中央線）から徒歩15分','四季折々の花が咲き誇る大規模な国営公園で、サイクリングやボート遊びが楽しめる。','広大な敷地内には花畑やバーベキュー施設、子供向けの遊具エリアがあります。サイクリングやボート遊びなどアクティブな楽しみ方ができ、家族連れに人気です。','とうきょうとたちかわしみどりちょう3173','こくえーしょーわきねんこーえん',' - 3173 Midori-cho, Tachikawa-shi, Tokyo','Showa Memorial Park'),(6,'井の頭恩賜公園','380,000','東京都武蔵野市御殿山1-18-31','吉祥寺駅から徒歩5分の便利な立地にある公園です。ボート遊びや動物園が楽しめるほか、散策路や池の風景も魅力的です。','入園無料（一部施設有料）','2024-12-24 21:00:23','2025-01-28 16:41:45','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Inokashira/IMG_2838.jpg','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.075813619153!2d139.57112687715153!3d35.69975192895409!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018ee357495662d%3A0x8067c21dd5e0f34f!2z5LqV44Gu6aCt5oGp6LOc5YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120152354!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','吉祥寺駅（JR中央線・京王井の頭線）から徒歩5分','池のボート遊びが人気で、動物園やアートギャラリーも併設されている。','吉祥寺駅から徒歩5分の便利な立地にある公園です。ボート遊びや動物園が楽しめるほか、散策路や池の風景も魅力的です。','とうきょうとむさしのしごてんやま1-18-31','いのかしらおんしこーえん',' - 1-18-31 Gotenyama, Musashino-shi, Tokyo','Inokashira Park'),(7,'新宿中央公園','10,000','東京都新宿区新宿1-2-3','新宿駅から徒歩5分の立地にあり、都会の中で気軽に緑を楽しめる公園です。季節の花や広場があり、リフレッシュに最適です。','入園無料','2024-12-24 21:00:23','2025-01-28 16:34:43','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShinjukuChuo/2024_12_25_12_52_IMG_2723.jpg','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6481.00050485088!2d139.68732287715125!3d35.68930542952814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018f32ca605ba2f%3A0xe4650320bae9e91f!2z5paw5a6_5Lit5aSu5YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120171829!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','西新宿五丁目駅（都営大江戸線）から徒歩5分<br>都庁前駅（都営大江戸線）から徒歩10分 ','都心に位置しながら滝のある風景や広い芝生広場が楽しめる公園。','新宿駅から徒歩5分の立地にあり、都会の中で気軽に緑を楽しめる公園です。季節の花や広場があり、リフレッシュに最適です。','とうきょうとしんじゅくくしんじゅく1-2-3','しんじゅくちゅーおーこーえん',' - 1-2-3 Shinjuku, Shinjuku-ku, Tokyo','Shinjuku Central Park'),(8,'小石川後楽園','75,000','東京都文京区後楽1-6-6','日本庭園と中国庭園の要素を取り入れた歴史的な庭園です。特に紅葉の季節には訪れる人が多く、池を中心とした景観が見事です。','一般300円','2024-12-24 21:00:23','2025-01-28 17:01:45','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Koishikawa/IMG_2910.jpg','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6479.668548856097!2d139.74669687715155!3d35.70569562862756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188c4646de5005%3A0x1b220216ae23c25e!2z5bCP55-z5bed5b6M5qW95ZyS!5e0!3m2!1sja!2sjp!4v1737120187797!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','後楽園駅（東京メトロ丸ノ内線）から徒歩8分<br>飯田橋駅（JR中央・総武線）から徒歩10分 ','都内屈指の日本庭園で、中国風の意匠が取り入れられている。','日本庭園と中国庭園の要素を取り入れた歴史的な庭園です。特に紅葉の季節には訪れる人が多く、池を中心とした景観が見事です。','とうきょうとぶんきょうくこうらく1-6-6','こいしかわこーらくえん','1-6-6 Koraku, Bunkyo-ku, Tokyo','Koishikawa Korakuen Garden'),(9,'木場公園','250,000','東京都江東区木場4-6-1','元材木置き場を再開発した公園で、スポーツ施設やイベントスペースが充実しています。桜並木や日本庭園もあり、季節の変化が楽しめます。','入園無料','2024-12-24 21:00:23','2025-01-17 22:25:19','/GREENSPACE/img/img/dummy-sapphire.png','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.009083470972!2d139.80508117715087!3d35.67677833021628!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018891b727edb75%3A0xb2db2f7412f07a0c!2z5pyo5aC05YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120204510!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','木場駅（東京メトロ東西線）から徒歩5分\n','バーベキュー施設や運動広場があり、家族で楽しめるアクティビティが充実。\n','元材木置き場を再開発した公園で、スポーツ施設やイベントスペースが充実しています。桜並木や日本庭園もあり、季節の変化が楽しめます。','とうきょうとこうとうくきば4-6-1','きばこーえん','4-6-1 Kiba, Koto-ku, Tokyo','Kiba Park'),(10,'旧古河庭園','50,000','東京都北区西ヶ原1-27-39','洋館と日本庭園が調和した大正時代の庭園です。特にバラ園が有名で、春と秋のバラフェスティバルが人気です。','一般150円','2024-12-24 21:00:23','2025-01-17 22:25:19','/GREENSPACE/img/img/dummy.png','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3238.3160027237986!2d139.74419377715242!3d35.74303702657405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188d9108c52f07%3A0x4cf4f7cf5b8a95ed!2z5pen5Y-k5rKz5bqt5ZyS!5e0!3m2!1sja!2sjp!4v1737120221937!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','西ヶ原駅（東京メトロ南北線）から徒歩7分<br>上中里駅（JR京浜東北線）から徒歩15分\r ','バラ園が有名で、洋館と日本庭園のコントラストが美しい。\n','洋館と日本庭園が調和した大正時代の庭園です。特にバラ園が有名で、春と秋のバラフェスティバルが人気です。','とうきょうときたくにしがはら1-27-39','きゅーこがてーえん','1-27-39 Nishigahara, Kita-ku, Tokyo','Kyu-Furukawa Gardens'),(11,'砧公園','268,000','東京都世田谷区砧公園1-1','広大な芝生広場が特徴で、ピクニックや家族でのんびり過ごすのにぴったりの公園です。子供向けの遊具も充実しています。','入園無料','2024-12-24 21:00:23','2025-01-28 17:06:13','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Kinuta/2024_12_25_13_21_IMG_2757.jpg','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6485.692621454004!2d139.61533504990823!3d35.63151516061629!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018f3e795140aa3%3A0x2a6930d1ecff350!2z56Cn5YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120243578!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','用賀駅（東急田園都市線）から徒歩15分','広大な芝生広場とジョギングコースがあり、家族連れやペット連れに人気。','広大な芝生広場が特徴で、ピクニックや家族でのんびり過ごすのにぴったりの公園です。子供向けの遊具も充実しています。','とうきょうとせたがやくきぬたこうえん1-1','きぬたこーえん','1-1 Kinuta-koen, Setagaya-ku, Tokyo','Kinuta Park'),(12,'六義園','240,000\n','東京都文京区本駒込6-16-3','江戸時代の大名庭園で、春のしだれ桜や秋の紅葉が見どころです。特にライトアップされた夜の庭園は幻想的な雰囲気です。','一般300円','2024-12-24 21:00:23','2025-01-17 22:25:19','/GREENSPACE/img/img/dummy-blue.png','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6477.439950543846!2d139.74086259426707!3d35.73310475640501!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188dbdf73e4461%3A0x7648774313f66fe5!2z5YWt576p5ZyS!5e0!3m2!1sja!2sjp!4v1737120256271!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','駒込駅（JR山手線）から徒歩7分<br>千石駅（都営三田線）から徒歩10分\r ','「回遊式築山泉水庭園」の代表例で、美しい紅葉と桜が楽しめる。\n','江戸時代の大名庭園で、春のしだれ桜や秋の紅葉が見どころです。特にライトアップされた夜の庭園は幻想的な雰囲気です。','とうきょうとぶんきょうくほんこまごめ6-16-3','りくぎえん','6-16-3 Honkomagome, Bunkyo-ku, Tokyo','Rikugien Garden'),(13,'行船公園','44,000','東京都江戸川区北葛西3丁目2-1','行船公園は、東京都江戸川区に位置する緑豊かな公園です。公園内には小さな動物園「自然動物園」があり、無料で動物たちを観察できます。また、四季折々の自然が楽しめる散歩コースや日本庭園が整備されており、家族連れや地域の人々に親しまれています。','入園無料','2025-01-01 21:26:52','2025-01-17 22:25:19','/GREENSPACE/img/img/dummy-green.png','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3118.7543714347403!2d139.85716747199638!3d35.67221713025718!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x601887dec6ac0bc1%3A0x6e525d595cade45f!2z6KGM6Ii55YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120277599!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','西葛西駅（東京メトロ東西線）から徒歩15分<br>船堀駅（都営新宿線）から徒歩20分\r ','大きな池があり、自然観察が楽しめる。子供向けの動物ふれあい広場がある。\n','行船公園は、東京都江戸川区に位置する緑豊かな公園です。公園内には小さな動物園「自然動物園」があり、無料で動物たちを観察できます。','とうきょうとえどがわくきたかさい3ちょうめ2-1','ぎょーせんこーえん','3-2-1 Kita-Kasai, Edogawa-ku, Tokyo','Gyosen Park'),(14,'妙正寺公園','12,000','東京都杉並区清水3丁目1','妙正寺公園は、妙正寺川沿いに広がる静かな公園で、地元の人々に愛されています。公園内には広場や遊具、池があり、自然を感じながらリラックスできる空間が広がっています。また、春には桜が美しく咲き誇り、散歩やピクニックに最適なスポットです。','入園無料','2025-01-01 21:44:58','2025-01-17 22:25:19','/GREENSPACE/img/img/dummy-brown.png','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d900.3078131389925!2d139.61773916409064!3d35.71715922803962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018ede79347fb93%3A0x7bb69fa2249799cd!2z5p2J5Lim5Yy656uL5aaZ5q2j5a-65YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120295515!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','鷺ノ宮駅（西武新宿線）から徒歩12分\n','静かな住宅街にあり、野球場や遊具のある広場が特徴的。\n','妙正寺公園は、妙正寺川沿いに広がる静かな公園で、地元の人々に愛されています。公園内には広場や遊具、池があり、自然を感じながらリラックスできる空間が広がっています。','とうきょうとすぎなみくしみず3ちょうめ1','みょーしょーじこーえん','3-1 Shimizu, Suginami-ku, Tokyo','Myoshoji Park'),(15,'善福寺公園','220,000\n','東京都杉並区善福寺3丁目','善福寺公園は、善福寺池を中心に自然が広がる静かな公園です。公園は上下二つの池に分かれ、散策路やベンチが整備されており、訪れる人々がのんびりとした時間を過ごせる場所です。春には桜、秋には紅葉が美しく、バードウォッチングにも最適なスポットとして知られています。また、池ではボート遊びも楽しむことができます。','入園無料（ボート利用は有料）','2025-01-01 21:49:30','2025-01-17 22:25:19','/GREENSPACE/img/img/dummy-green.png','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3239.4629471758058!2d139.58865777715152!3d35.71483142812511!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018ee69a0e4d655%3A0x2fdb82c32c6db9c3!2z5ZaE56aP5a-65YWs5ZyS!5e0!3m2!1sja!2sjp!4v1737120305437!5m2!1sja!2sjp\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','西荻窪駅（JR中央・総武線）から徒歩20分<br>吉祥寺駅（JR中央・総武線）からバス10分＋徒歩5分\r ','善福寺池を中心とした自然豊かな公園で、バードウォッチングに最適。\n','善福寺公園は、善福寺池を中心に自然が広がる静かな公園です。公園は上下二つの池に分かれ、散策路やベンチが整備されており、訪れる人々がのんびりとした時間を過ごせる場所です。','とうきょうとすぎなみくぜんぷくじ3ちょうめ','ぜんぷくじこーえん','3-chome Zenpukuji, Suginami-ku, Tokyo','Zenpukuji Park');
/*!40000 ALTER TABLE `park` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `park_images`
--

DROP TABLE IF EXISTS `park_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `park_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `park_id` int NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `park_id` (`park_id`),
  CONSTRAINT `park_images_ibfk_1` FOREIGN KEY (`park_id`) REFERENCES `park` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=374 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `park_images`
--

LOCK TABLES `park_images` WRITE;
/*!40000 ALTER TABLE `park_images` DISABLE KEYS */;
INSERT INTO `park_images` VALUES (171,1,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(179,9,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(180,10,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(182,12,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(184,14,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(185,15,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(190,3,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(196,9,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(197,10,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(199,12,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(201,14,'/GREENSPACE/img/img/dummy-brown.png'),(202,15,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(205,1,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(207,3,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/dummy-brown.png'),(213,9,'https://pw11a12425.blob.core.windows.net/park/2024_12_25_12_57_IMG_2732.jpg'),(216,12,'/GREENSPACE/img/img/dummy-blue.png'),(218,14,'/GREENSPACE/img/img/dummy-brown.png'),(224,3,'/GREENSPACE/img/img/dummy-blue.png'),(299,10,'/GREENSPACE/img/img/dummy-brown.png'),(352,7,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShinjukuChuo/2024_12_25_13_02_IMG_2737.jpg'),(353,7,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShinjukuChuo/2024_12_25_13_16_IMG_2752.jpg'),(354,7,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShinjukuChuo/2024_12_25_13_19_IMG_2756.jpg'),(355,4,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShinjukuGyoen/2024_12_25_14_36_IMG_2767.jpg'),(356,4,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShinjukuGyoen/2024_12_25_14_47_IMG_2774.jpg'),(357,4,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShinjukuGyoen/2024_12_25_15_15_IMG_2795.jpg'),(358,6,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Inokashira/IMG_2835.jpg'),(359,6,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Inokashira/IMG_2837.jpg'),(360,6,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Inokashira/IMG_2840.jpg'),(361,5,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShowaKinen/IMG_2871.jpg'),(362,5,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShowaKinen/IMG_2874.jpg'),(363,5,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/ShowaKinen/IMG_2919.jpg'),(364,8,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Koishikawa/IMG_2897.jpg'),(365,8,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Koishikawa/IMG_2878.jpg'),(366,8,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Koishikawa/IMG_2875.jpg'),(367,11,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Kinuta/2024_12_25_14_27_IMG_2760.jpg'),(368,11,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Kinuta/2024_12_25_14_45_IMG_2771.jpg'),(369,11,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Kinuta/2024_12_25_14_49_IMG_2777.jpg'),(370,2,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Yoyogi/IMG_2923.jpg'),(371,2,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Yoyogi/IMG_2924.jpg'),(372,2,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Yoyogi/IMG_2925.jpg'),(373,2,'https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/Park/Yoyogi/IMG_2926.jpg');
/*!40000 ALTER TABLE `park_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `park_likes`
--

DROP TABLE IF EXISTS `park_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `park_likes` (
  `park_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`park_id`,`user_email`),
  KEY `user_email` (`user_email`),
  CONSTRAINT `park_likes_ibfk_1` FOREIGN KEY (`park_id`) REFERENCES `park` (`id`),
  CONSTRAINT `park_likes_ibfk_2` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `park_likes`
--

LOCK TABLES `park_likes` WRITE;
/*!40000 ALTER TABLE `park_likes` DISABLE KEYS */;
INSERT INTO `park_likes` VALUES (2,'eee@gmail.com','2024-12-30 04:47:30'),(2,'sss@gmail.com','2024-12-30 12:49:08'),(3,'bbb@gmail.com','2025-01-17 02:31:39'),(3,'eee@gmail.com','2024-12-30 04:47:43'),(7,'bbb@gmail.com','2025-01-17 13:54:14'),(10,'eee@gmail.com','2024-12-30 05:46:09'),(11,'eee@gmail.com','2024-12-30 05:46:11'),(12,'sss@gmail.com','2024-12-30 12:49:01'),(14,'bbb@gmail.com','2025-01-14 03:33:40'),(15,'sss@gmail.com','2024-12-30 12:43:04');
/*!40000 ALTER TABLE `park_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT '/GREENSPACE/img/avatar/panda.png',
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` enum('user','admin') DEFAULT 'user',
  `status` enum('active','banned') DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'bbb@gmail.com','$2y$10$9PCk0AhjPEptcC9Bgw7pgOcWKG8FDefKjih5jNufQV8aqq7xqK4ba','Mr.Pig','0','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Pig.jpg','Minato','2024-12-21 12:27:13','2025-01-25 09:58:16','admin','active'),(4,'zzz@gmail.com','$2y$10$B.wFf/6JLcIwO0ybHlGljefDMdtEEwV9FmPYayqJafBaDWcnddykm','Fox','0','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Bear.jpg','Shibuya','2024-12-24 09:44:25','2025-01-25 09:58:16','user','active'),(5,'aaa@gmail.com','$2y$10$dd2.iFO8OS3KC5zV5aD4HOobVl5OUWYI.spB9rKSqvODnhNjkqCvi','Panda','0','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Rabbit.jpg','Shinjuku','2024-12-24 09:46:36','2025-01-25 09:58:16','user','active'),(6,'sss@gmail.com','$2y$10$mF9kLhphC3iFL7Si8wnoieeh94S1CY2gJ4NY8oKhsxitGrU0SvMHK','Deer','909999999','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Dog.jpg','Meguro','2024-12-24 10:28:41','2025-01-25 09:58:16','user','active'),(7,'xxx@gmail.com','$2y$10$m1le6Wc2lMLRNeYZXF6A/ezIjDwEG8JOkk.2sTcMqb0ybormqdT.2','Cat','0','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Lion.jpg','Shinjuku','2024-12-26 01:04:27','2025-01-25 09:58:16','user','active'),(8,'bbc@gmail.com','$2y$10$C64UdEmwxt6cPGsJB2AB1OweCiwME1iJC4ktomtphYOCh.qqQ1UIC','Dog','0','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Wolf.jpg','Adachi','2024-12-27 06:26:36','2025-01-25 09:58:16','user','banned'),(9,'qqq@gmail.com','$2y$10$T2Gj4TiIHsFrliAKs7Fd/.yr4y3eA0x2fmAkVspAXzFvmU1IKWgW6','Deeer','0','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Deer.jpg','Nakano','2024-12-28 05:47:50','2025-01-25 09:58:16','user','active'),(10,'eee@gmail.com','$2y$10$cvL1ccD1v1g1W7AuVxgQvuqZzENxBD3y824d..D3b54ROIjd1fCDW','パンダ','90123456789','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Panda.jpg','Shinjuku','2024-12-28 05:48:34','2025-01-25 09:58:16','user','active'),(11,'hal@gmail.com','$2y$10$zef6hxN100o5IjKr3qGsLe6etMZEDrDpXMYni9xu7WXk/eJr5twtq','HAL','0','https://greenspacestorage.sgp1.cdn.digitaloceanspaces.com/avatar/Cat.jpg','Shinjuku','2025-01-22 03:52:21','2025-01-25 10:21:42','admin','active');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_notifications`
--

DROP TABLE IF EXISTS `user_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notification_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_notification_user` (`notification_id`,`user_email`),
  KEY `user_email` (`user_email`),
  CONSTRAINT `user_notifications_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`),
  CONSTRAINT `user_notifications_ibfk_2` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_notifications`
--

LOCK TABLES `user_notifications` WRITE;
/*!40000 ALTER TABLE `user_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_notifications` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-29 22:27:59
