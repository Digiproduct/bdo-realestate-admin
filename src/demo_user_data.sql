-- MySQL dump 10.13  Distrib 5.7.23, for osx10.9 (x86_64)
--
-- Host: localhost    Database: bdo_realestate
-- ------------------------------------------------------
-- Server version	5.7.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `balance_data`
--

DROP TABLE IF EXISTS `balance_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance_data` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `contract_number` int(10) unsigned DEFAULT NULL,
  `unit_cost` int(11) unsigned DEFAULT NULL,
  `funds` int(11) DEFAULT NULL,
  `land_amount` int(11) DEFAULT NULL,
  `land_completeness` tinyint(11) unsigned DEFAULT NULL,
  `construction_amount` int(11) DEFAULT NULL,
  `construction_completeness` tinyint(11) unsigned DEFAULT NULL,
  `management_amount` int(11) DEFAULT NULL,
  `management_completeness` tinyint(11) unsigned DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance_data`
--

LOCK TABLES `balance_data` WRITE;
/*!40000 ALTER TABLE `balance_data` DISABLE KEYS */;
INSERT INTO `balance_data` VALUES (1,'published',2,'2019-02-24 05:40:00',111111,1950000,1100000,1000000,100,186830,21,12128,25,-98959,'2017-01-01');
/*!40000 ALTER TABLE `balance_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `construction_progress`
--

DROP TABLE IF EXISTS `construction_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `construction_progress` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `group` int(10) unsigned DEFAULT NULL,
  `milestone_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_complete` tinyint(3) unsigned DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `construction_progress`
--

LOCK TABLES `construction_progress` WRITE;
/*!40000 ALTER TABLE `construction_progress` DISABLE KEYS */;
INSERT INTO `construction_progress` VALUES (1,'published',1,'2019-02-24 06:24:40',1,'נובמבר 2013 - זכיה במכרז',1,'2014-05-25'),(2,'published',1,'2019-02-24 06:25:44',1,'ינואר 2014- הסכם שיתוף',1,'2017-01-01'),(3,'published',1,'2019-02-24 06:26:36',1,'אוקטובר 2014- תכנון ובקשת היתר',1,'2018-01-01'),(4,'published',1,'2019-02-24 06:26:59',1,'ינואר 2015- הכנת דוח אפס',1,'2018-01-01'),(5,'published',1,'2019-02-24 06:27:21',1,'אוקטובר 2015 - ליווי בנקאי',1,'2018-01-01'),(6,'published',1,'2019-02-24 06:27:46',1,'ינואר 2016- התחלת בניה',1,'2018-01-01'),(7,'published',1,'2019-02-24 06:28:17',1,'דצמבר 2016- סיום שלד',1,'2018-01-01'),(8,'published',1,'2019-02-24 06:29:18',1,'יולי 2017- סיום מערכות בניין',0,'2018-01-01'),(9,'published',1,'2019-02-24 06:29:45',1,'דצמבר 2017- גימורים ופיתוח',0,'2018-01-01');
/*!40000 ALTER TABLE `construction_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contracts`
--

DROP TABLE IF EXISTS `contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts` (
  `status` varchar(20) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `building_plot` int(11) DEFAULT NULL,
  `building_number` varchar(20) DEFAULT NULL,
  `floor` varchar(30) DEFAULT NULL,
  `apartment` int(11) DEFAULT NULL,
  `rooms` varchar(30) DEFAULT NULL,
  `contract_number` int(11) NOT NULL,
  `group` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`contract_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contracts`
--

LOCK TABLES `contracts` WRITE;
/*!40000 ALTER TABLE `contracts` DISABLE KEYS */;
INSERT INTO `contracts` VALUES ('published',2,'2019-01-24 00:27:53',2,803,'E14','1',3,'4 חד\'',111111,1);
/*!40000 ALTER TABLE `contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_activity`
--

DROP TABLE IF EXISTS `directus_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(45) NOT NULL,
  `action_by` int(11) unsigned NOT NULL DEFAULT '0',
  `action_on` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `collection` varchar(64) NOT NULL,
  `item` varchar(255) NOT NULL,
  `edited_on` datetime DEFAULT NULL,
  `comment` text,
  `comment_deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_activity`
--

LOCK TABLES `directus_activity` WRITE;
/*!40000 ALTER TABLE `directus_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `directus_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_activity_seen`
--

DROP TABLE IF EXISTS `directus_activity_seen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_activity_seen` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity` int(11) unsigned NOT NULL,
  `user` int(11) unsigned NOT NULL DEFAULT '0',
  `seen_on` datetime DEFAULT NULL,
  `archived` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_activity_seen`
--

LOCK TABLES `directus_activity_seen` WRITE;
/*!40000 ALTER TABLE `directus_activity_seen` DISABLE KEYS */;
/*!40000 ALTER TABLE `directus_activity_seen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_collection_presets`
--

DROP TABLE IF EXISTS `directus_collection_presets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_collection_presets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `user` int(11) unsigned DEFAULT NULL,
  `role` int(11) unsigned DEFAULT NULL,
  `collection` varchar(64) NOT NULL,
  `search_query` varchar(100) DEFAULT NULL,
  `filters` text,
  `view_type` varchar(100) NOT NULL DEFAULT 'tabular',
  `view_query` text,
  `view_options` text,
  `translation` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_collection_title` (`user`,`collection`,`title`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_collection_presets`
--

LOCK TABLES `directus_collection_presets` WRITE;
/*!40000 ALTER TABLE `directus_collection_presets` DISABLE KEYS */;
INSERT INTO `directus_collection_presets` VALUES (1,NULL,NULL,NULL,'directus_activity',NULL,NULL,'tabular','{\"tabular\":{\"sort\":\"-action_on\",\"fields\":\"action,action_by,action_on,collection,item\"}}','{\"tabular\":{\"widths\":{\"action\":170,\"action_by\":170,\"action_on\":180,\"collection\":200,\"item\":200}}}',NULL),(2,NULL,NULL,NULL,'directus_files',NULL,NULL,'cards',NULL,'{\"cards\":{\"title\":\"title\",\"subtitle\":\"type\",\"content\":\"description\",\"src\":\"data\"}}',NULL),(3,NULL,NULL,NULL,'directus_users',NULL,NULL,'cards',NULL,'{\"cards\":{\"title\":\"first_name\",\"subtitle\":\"last_name\",\"content\":\"title\",\"src\":\"avatar\",\"icon\":\"person\"}}',NULL),(4,NULL,1,NULL,'messages',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,to,subject,read_date,created_on\"}}',NULL,NULL),(5,NULL,1,NULL,'directus_users',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,last_name,email,roles\"}}','{\"cards\":{\"title\":\"first_name\",\"subtitle\":\"last_name\",\"content\":\"title\",\"src\":\"avatar\",\"icon\":\"person\"},\"tabular\":{\"widths\":{\"status\":81,\"email\":200,\"roles\":200,\"last_name\":200}}}',NULL),(6,NULL,1,NULL,'profiles',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,customer,passport,phone_1,phone_2,home_address\"}}',NULL,NULL),(7,NULL,1,NULL,'contracts',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,contract_number,group,customer,building_plot,building_number,floor,apartment,rooms,created_by\"}}',NULL,NULL),(8,NULL,1,NULL,'group_info',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,created_by,created_on,modified_by,modified_on,phone\"}}',NULL,NULL),(9,NULL,1,NULL,'group_info',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,id,group_name,phone,email\"}}','{\"cards\":{\"src\":\"photo_4\",\"title\":\"group_name\"}}',NULL),(10,NULL,1,NULL,'feedback',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"created_on,first_name,last_name,phone,email,details\"}}',NULL,NULL),(11,NULL,1,NULL,'construction_progress',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,group,milestone_name,is_complete,updated_date\"}}',NULL,NULL),(12,NULL,1,NULL,'receipts',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,contract_number,total_amount,updated_date\"}}',NULL,NULL),(13,NULL,1,NULL,'funding_reports',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,contract_number,total_debit,total_credit,total_balance,updated_date\"}}',NULL,NULL),(14,NULL,1,NULL,'transactions',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,funding_report,details,debit,credit,balance\"}}',NULL,NULL),(15,NULL,1,NULL,'balance_data',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"status,contract_number,balance,updated_date\"}}',NULL,NULL),(16,NULL,1,NULL,'imports',NULL,NULL,'tabular','{\"tabular\":{\"fields\":\"created_on,import_target,items_created,items_rejected\"}}',NULL,NULL);
/*!40000 ALTER TABLE `directus_collection_presets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_collections`
--

DROP TABLE IF EXISTS `directus_collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_collections` (
  `collection` varchar(64) NOT NULL,
  `managed` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `single` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `icon` varchar(30) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `translation` text,
  PRIMARY KEY (`collection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_collections`
--

LOCK TABLES `directus_collections` WRITE;
/*!40000 ALTER TABLE `directus_collections` DISABLE KEYS */;
INSERT INTO `directus_collections` VALUES ('balance_data',1,0,0,NULL,NULL,NULL),('construction_progress',1,0,0,NULL,NULL,NULL),('contracts',1,0,0,NULL,NULL,NULL),('feedback',1,0,0,NULL,NULL,NULL),('funding_reports',1,0,0,NULL,NULL,NULL),('group_info',1,0,0,NULL,NULL,NULL),('imports',1,0,0,NULL,NULL,NULL),('messages',1,0,0,NULL,NULL,NULL),('profiles',1,0,0,NULL,NULL,NULL),('receipts',1,0,0,NULL,NULL,NULL),('transactions',1,0,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `directus_collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_fields`
--

DROP TABLE IF EXISTS `directus_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `collection` varchar(64) NOT NULL,
  `field` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `interface` varchar(64) DEFAULT NULL,
  `options` text,
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `validation` varchar(255) DEFAULT NULL,
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `readonly` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hidden_detail` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hidden_browse` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` int(11) unsigned DEFAULT NULL,
  `width` int(11) unsigned NOT NULL DEFAULT '4',
  `group` int(11) unsigned DEFAULT NULL,
  `note` varchar(1024) DEFAULT NULL,
  `translation` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_collection_field` (`collection`,`field`)
) ENGINE=InnoDB AUTO_INCREMENT=290 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_fields`
--

LOCK TABLES `directus_fields` WRITE;
/*!40000 ALTER TABLE `directus_fields` DISABLE KEYS */;
INSERT INTO `directus_fields` VALUES (1,'directus_activity','id','integer','primary-key',NULL,1,NULL,1,1,1,0,NULL,4,NULL,NULL,NULL),(2,'directus_activity','action','string','activity-icon',NULL,1,NULL,0,1,0,0,1,4,NULL,NULL,NULL),(3,'directus_activity','collection','string','collections',NULL,1,NULL,0,1,0,0,2,2,NULL,NULL,NULL),(4,'directus_activity','item','string','text-input',NULL,1,NULL,0,1,0,0,3,2,NULL,NULL,NULL),(5,'directus_activity','action_by','integer','user',NULL,1,NULL,0,1,0,0,4,2,NULL,NULL,NULL),(6,'directus_activity','action_on','datetime','datetime','{\"showRelative\":true}',1,NULL,0,1,0,0,5,2,NULL,NULL,NULL),(7,'directus_activity','edited_on','datetime','datetime','{\"showRelative\":true}',1,NULL,0,1,0,0,6,2,NULL,NULL,NULL),(8,'directus_activity','comment_deleted_on','datetime','datetime','{\"showRelative\":true}',1,NULL,0,1,0,0,7,2,NULL,NULL,NULL),(9,'directus_activity','ip','string','text-input',NULL,1,NULL,0,1,0,0,8,2,NULL,NULL,NULL),(10,'directus_activity','user_agent','string','text-input',NULL,1,NULL,0,1,0,0,9,2,NULL,NULL,NULL),(11,'directus_activity','comment','string','textarea',NULL,1,NULL,0,1,0,0,10,4,NULL,NULL,NULL),(12,'directus_collection_presets','id','integer','primary-key',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(13,'directus_collection_presets','title','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(14,'directus_collection_presets','user','integer','user',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(15,'directus_collection_presets','role','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(16,'directus_collection_presets','collection','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(17,'directus_collection_presets','search_query','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(18,'directus_collection_presets','filters','json','code',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(19,'directus_collection_presets','view_options','json','code',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(20,'directus_collection_presets','view_type','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(21,'directus_collection_presets','view_query','json','code',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(22,'directus_collections','fields','o2m','one-to-many',NULL,1,NULL,0,0,1,1,1,4,NULL,NULL,NULL),(23,'directus_collections','collection','string','primary-key',NULL,1,NULL,1,1,0,0,2,2,NULL,NULL,NULL),(24,'directus_collections','note','string','text-input',NULL,1,NULL,0,0,0,0,3,2,NULL,NULL,NULL),(25,'directus_collections','managed','boolean','toggle',NULL,1,NULL,0,0,0,0,4,1,NULL,NULL,NULL),(26,'directus_collections','hidden','boolean','toggle',NULL,1,NULL,0,0,0,0,5,1,NULL,NULL,NULL),(27,'directus_collections','single','boolean','toggle',NULL,1,NULL,0,0,0,0,6,1,NULL,NULL,NULL),(28,'directus_collections','translation','json','code',NULL,1,NULL,0,0,1,0,7,4,NULL,NULL,NULL),(29,'directus_collections','icon','string','icon',NULL,1,NULL,0,0,0,0,8,4,NULL,NULL,NULL),(30,'directus_fields','id','integer','primary-key',NULL,1,NULL,1,0,1,0,NULL,4,NULL,NULL,NULL),(31,'directus_fields','collection','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(32,'directus_fields','field','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(33,'directus_fields','type','string','primary-key',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(34,'directus_fields','interface','string','primary-key',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(35,'directus_fields','options','json','code',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(36,'directus_fields','locked','boolean','toggle',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(37,'directus_fields','translation','json','code',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(38,'directus_fields','readonly','boolean','toggle',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(39,'directus_fields','validation','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(40,'directus_fields','required','boolean','toggle',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(41,'directus_fields','sort','sort','sort',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(42,'directus_fields','note','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(43,'directus_fields','hidden_detail','boolean','toggle',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(44,'directus_fields','hidden_browse','boolean','toggle',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(45,'directus_fields','width','integer','numeric',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(46,'directus_fields','group','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(47,'directus_files','data','alias','file',NULL,1,NULL,0,0,1,0,0,4,NULL,NULL,NULL),(48,'directus_files','id','integer','primary-key',NULL,1,NULL,1,0,1,0,1,4,NULL,NULL,NULL),(49,'directus_files','preview','alias','file-preview',NULL,1,NULL,0,0,0,0,2,4,NULL,NULL,NULL),(50,'directus_files','title','string','text-input','{\"placeholder\":\"Enter a descriptive title...\",\"iconRight\":\"title\"}',1,NULL,0,0,0,0,3,2,NULL,NULL,NULL),(51,'directus_files','filename','string','text-input','{\"placeholder\":\"Enter a unique file name...\",\"iconRight\":\"insert_drive_file\"}',1,NULL,0,1,0,0,4,2,NULL,NULL,NULL),(52,'directus_files','tags','array','tags',NULL,0,NULL,0,0,0,0,5,2,NULL,NULL,NULL),(53,'directus_files','location','string','text-input','{\"placeholder\":\"Enter a location...\",\"iconRight\":\"place\"}',0,NULL,0,0,0,0,6,2,NULL,NULL,NULL),(54,'directus_files','description','string','wysiwyg','{\"placeholder\":\"Enter a caption or description...\"}',0,NULL,0,0,0,0,7,4,NULL,NULL,NULL),(55,'directus_files','width','integer','numeric','{\"iconRight\":\"straighten\"}',1,NULL,0,1,0,0,8,1,NULL,NULL,NULL),(56,'directus_files','height','integer','numeric','{\"iconRight\":\"straighten\"}',1,NULL,0,1,0,0,9,1,NULL,NULL,NULL),(57,'directus_files','duration','integer','numeric','{\"iconRight\":\"timer\"}',1,NULL,0,1,0,0,10,1,NULL,NULL,NULL),(58,'directus_files','filesize','integer','file-size','{\"iconRight\":\"storage\"}',1,NULL,0,1,0,0,11,1,NULL,NULL,NULL),(59,'directus_files','uploaded_on','datetime','datetime','{\"iconRight\":\"today\"}',1,NULL,0,1,0,0,12,2,NULL,NULL,NULL),(60,'directus_files','uploaded_by','integer','user',NULL,1,NULL,0,1,0,0,13,2,NULL,NULL,NULL),(61,'directus_files','metadata','json','code',NULL,1,NULL,0,0,0,0,14,4,NULL,NULL,NULL),(62,'directus_files','type','string','text-input',NULL,1,NULL,0,1,1,0,NULL,4,NULL,NULL,NULL),(63,'directus_files','charset','string','text-input',NULL,1,NULL,0,1,1,1,NULL,4,NULL,NULL,NULL),(64,'directus_files','embed','string','text-input',NULL,1,NULL,0,1,1,0,NULL,4,NULL,NULL,NULL),(65,'directus_files','folder','m2o','many-to-one',NULL,1,NULL,0,0,1,0,NULL,4,NULL,NULL,NULL),(66,'directus_files','storage','string','text-input',NULL,1,NULL,0,0,1,1,NULL,4,NULL,NULL,NULL),(67,'directus_folders','id','integer','primary-key',NULL,1,NULL,1,0,1,0,NULL,4,NULL,NULL,NULL),(68,'directus_folders','name','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(69,'directus_folders','parent_folder','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(70,'directus_permissions','id','integer','primary-key',NULL,1,NULL,1,0,1,0,NULL,4,NULL,NULL,NULL),(71,'directus_permissions','collection','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(72,'directus_permissions','role','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(73,'directus_permissions','status','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(74,'directus_permissions','create','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(75,'directus_permissions','read','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(76,'directus_permissions','update','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(77,'directus_permissions','delete','string','primary-key',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(78,'directus_permissions','comment','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(79,'directus_permissions','explain','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(80,'directus_permissions','status_blacklist','array','tags',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(81,'directus_permissions','read_field_blacklist','array','tags',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(82,'directus_permissions','write_field_blacklist','array','tags',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(83,'directus_relations','id','integer','primary-key',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(84,'directus_relations','collection_many','string','collections',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(85,'directus_relations','field_many','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(86,'directus_relations','collection_one','string','collections',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(87,'directus_relations','field_one','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(88,'directus_relations','junction_field','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(89,'directus_revisions','id','integer','primary-key',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(90,'directus_revisions','activity','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(91,'directus_revisions','collection','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(92,'directus_revisions','item','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(93,'directus_revisions','data','json','code',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(94,'directus_revisions','delta','json','code',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(95,'directus_revisions','parent_item','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(96,'directus_revisions','parent_collection','string','collections',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(97,'directus_revisions','parent_changed','boolean','toggle',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(98,'directus_roles','id','integer','primary-key',NULL,1,NULL,1,0,1,0,NULL,4,NULL,NULL,NULL),(99,'directus_roles','external_id','string','text-input',NULL,1,NULL,0,1,1,1,NULL,4,NULL,NULL,NULL),(100,'directus_roles','name','string','text-input',NULL,1,NULL,0,0,0,0,1,2,NULL,NULL,NULL),(101,'directus_roles','description','string','text-input',NULL,1,NULL,0,0,0,0,2,2,NULL,NULL,NULL),(102,'directus_roles','ip_whitelist','string','textarea',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(103,'directus_roles','nav_blacklist','string','textarea',NULL,1,NULL,0,0,1,1,NULL,4,NULL,NULL,NULL),(104,'directus_settings','project_name','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(105,'directus_settings','project_url','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(106,'directus_settings','app_url','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(107,'directus_settings','logo','file','file',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(108,'directus_settings','color','string','color-palette',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(109,'directus_settings','default_limit','integer','numeric',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(110,'directus_settings','sort_null_last','boolean','toggle',NULL,1,NULL,0,0,0,0,NULL,4,NULL,'Will sort values with null at the end of the result',NULL),(111,'directus_settings','auto_sign_out','integer','numeric',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(112,'directus_settings','trusted_proxies','array','tags',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(113,'directus_settings','youtube_api','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(114,'directus_settings','thumbnail_dimensions','array','tags',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(115,'directus_settings','thumbnail_quality_tags','json','code',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(116,'directus_settings','thumbnail_actions','json','code',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(117,'directus_settings','thumbnail_cache_ttl','integer','numeric',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(118,'directus_settings','thumbnail_not_found_location','string','text-input',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(119,'directus_users','id','integer','primary-key',NULL,1,NULL,1,0,1,0,1,4,NULL,NULL,NULL),(120,'directus_users','status','status','status','{\"status_mapping\":{\"draft\":{\"name\":\"Draft\",\"text_color\":\"white\",\"background_color\":\"light-gray\",\"listing_subdued\":false,\"listing_badge\":true,\"soft_delete\":false},\"invited\":{\"name\":\"Invited\",\"text_color\":\"white\",\"background_color\":\"light-gray\",\"listing_subdued\":false,\"listing_badge\":true,\"soft_delete\":false},\"active\":{\"name\":\"Active\",\"text_color\":\"white\",\"background_color\":\"success\",\"listing_subdued\":false,\"listing_badge\":false,\"soft_delete\":false},\"suspended\":{\"name\":\"Suspended\",\"text_color\":\"white\",\"background_color\":\"light-gray\",\"listing_subdued\":false,\"listing_badge\":true,\"soft_delete\":false},\"deleted\":{\"name\":\"Deleted\",\"text_color\":\"white\",\"background_color\":\"danger\",\"listing_subdued\":false,\"listing_badge\":true,\"soft_delete\":true}}}',1,NULL,0,0,0,0,2,4,NULL,NULL,NULL),(121,'directus_users','first_name','string','text-input','{\"placeholder\":\"Enter your give name...\"}',1,NULL,1,0,0,0,3,2,NULL,NULL,NULL),(122,'directus_users','last_name','string','text-input','{\"placeholder\":\"Enter your surname...\"}',1,NULL,1,0,0,0,4,2,NULL,NULL,NULL),(123,'directus_users','email','string','text-input','{\"placeholder\":\"Enter your email address...\"}',1,'$email',1,0,0,0,5,2,NULL,NULL,NULL),(124,'directus_users','email_notifications','boolean','toggle',NULL,1,NULL,0,0,0,0,6,2,NULL,NULL,NULL),(125,'directus_users','password','string','password',NULL,1,NULL,1,0,0,0,7,2,NULL,NULL,NULL),(126,'directus_users','roles','o2m','user-roles',NULL,1,NULL,0,0,0,0,8,2,NULL,NULL,NULL),(127,'directus_users','company','string','text-input','{\"placeholder\":\"Enter your company or organization name...\"}',0,NULL,0,0,0,0,9,2,NULL,NULL,NULL),(128,'directus_users','title','string','text-input','{\"placeholder\":\"Enter your title or role...\"}',0,NULL,0,0,0,0,10,2,NULL,NULL,NULL),(129,'directus_users','timezone','string','dropdown','{\"choices\":{\"Pacific\\/Midway\":\"(UTC-11:00) Midway Island\",\"Pacific\\/Samoa\":\"(UTC-11:00) Samoa\",\"Pacific\\/Honolulu\":\"(UTC-10:00) Hawaii\",\"US\\/Alaska\":\"(UTC-09:00) Alaska\",\"America\\/Los_Angeles\":\"(UTC-08:00) Pacific Time (US & Canada)\",\"America\\/Tijuana\":\"(UTC-08:00) Tijuana\",\"US\\/Arizona\":\"(UTC-07:00) Arizona\",\"America\\/Chihuahua\":\"(UTC-07:00) Chihuahua\",\"America\\/Mexico\\/La_Paz\":\"(UTC-07:00) La Paz\",\"America\\/Mazatlan\":\"(UTC-07:00) Mazatlan\",\"US\\/Mountain\":\"(UTC-07:00) Mountain Time (US & Canada)\",\"America\\/Managua\":\"(UTC-06:00) Central America\",\"US\\/Central\":\"(UTC-06:00) Central Time (US & Canada)\",\"America\\/Guadalajara\":\"(UTC-06:00) Guadalajara\",\"America\\/Mexico_City\":\"(UTC-06:00) Mexico City\",\"America\\/Monterrey\":\"(UTC-06:00) Monterrey\",\"Canada\\/Saskatchewan\":\"(UTC-06:00) Saskatchewan\",\"America\\/Bogota\":\"(UTC-05:00) Bogota\",\"US\\/Eastern\":\"(UTC-05:00) Eastern Time (US & Canada)\",\"US\\/East-Indiana\":\"(UTC-05:00) Indiana (East)\",\"America\\/Lima\":\"(UTC-05:00) Lima\",\"America\\/Quito\":\"(UTC-05:00) Quito\",\"Canada\\/Atlantic\":\"(UTC-04:00) Atlantic Time (Canada)\",\"America\\/New_York\":\"(UTC-04:00) New York\",\"America\\/Caracas\":\"(UTC-04:30) Caracas\",\"America\\/La_Paz\":\"(UTC-04:00) La Paz\",\"America\\/Santiago\":\"(UTC-04:00) Santiago\",\"America\\/Santo_Domingo\":\"(UTC-04:00) Santo Domingo\",\"Canada\\/Newfoundland\":\"(UTC-03:30) Newfoundland\",\"America\\/Sao_Paulo\":\"(UTC-03:00) Brasilia\",\"America\\/Argentina\\/Buenos_Aires\":\"(UTC-03:00) Buenos Aires\",\"America\\/Argentina\\/GeorgeTown\":\"(UTC-03:00) Georgetown\",\"America\\/Godthab\":\"(UTC-03:00) Greenland\",\"America\\/Noronha\":\"(UTC-02:00) Mid-Atlantic\",\"Atlantic\\/Azores\":\"(UTC-01:00) Azores\",\"Atlantic\\/Cape_Verde\":\"(UTC-01:00) Cape Verde Is.\",\"Africa\\/Casablanca\":\"(UTC+00:00) Casablanca\",\"Europe\\/Edinburgh\":\"(UTC+00:00) Edinburgh\",\"Etc\\/Greenwich\":\"(UTC+00:00) Greenwich Mean Time : Dublin\",\"Europe\\/Lisbon\":\"(UTC+00:00) Lisbon\",\"Europe\\/London\":\"(UTC+00:00) London\",\"Africa\\/Monrovia\":\"(UTC+00:00) Monrovia\",\"UTC\":\"(UTC+00:00) UTC\",\"Europe\\/Amsterdam\":\"(UTC+01:00) Amsterdam\",\"Europe\\/Belgrade\":\"(UTC+01:00) Belgrade\",\"Europe\\/Berlin\":\"(UTC+01:00) Berlin\",\"Europe\\/Bern\":\"(UTC+01:00) Bern\",\"Europe\\/Bratislava\":\"(UTC+01:00) Bratislava\",\"Europe\\/Brussels\":\"(UTC+01:00) Brussels\",\"Europe\\/Budapest\":\"(UTC+01:00) Budapest\",\"Europe\\/Copenhagen\":\"(UTC+01:00) Copenhagen\",\"Europe\\/Ljubljana\":\"(UTC+01:00) Ljubljana\",\"Europe\\/Madrid\":\"(UTC+01:00) Madrid\",\"Europe\\/Paris\":\"(UTC+01:00) Paris\",\"Europe\\/Prague\":\"(UTC+01:00) Prague\",\"Europe\\/Rome\":\"(UTC+01:00) Rome\",\"Europe\\/Sarajevo\":\"(UTC+01:00) Sarajevo\",\"Europe\\/Skopje\":\"(UTC+01:00) Skopje\",\"Europe\\/Stockholm\":\"(UTC+01:00) Stockholm\",\"Europe\\/Vienna\":\"(UTC+01:00) Vienna\",\"Europe\\/Warsaw\":\"(UTC+01:00) Warsaw\",\"Africa\\/Lagos\":\"(UTC+01:00) West Central Africa\",\"Europe\\/Zagreb\":\"(UTC+01:00) Zagreb\",\"Europe\\/Athens\":\"(UTC+02:00) Athens\",\"Europe\\/Bucharest\":\"(UTC+02:00) Bucharest\",\"Africa\\/Cairo\":\"(UTC+02:00) Cairo\",\"Africa\\/Harare\":\"(UTC+02:00) Harare\",\"Europe\\/Helsinki\":\"(UTC+02:00) Helsinki\",\"Europe\\/Istanbul\":\"(UTC+02:00) Istanbul\",\"Asia\\/Jerusalem\":\"(UTC+02:00) Jerusalem\",\"Europe\\/Kyiv\":\"(UTC+02:00) Kyiv\",\"Africa\\/Johannesburg\":\"(UTC+02:00) Pretoria\",\"Europe\\/Riga\":\"(UTC+02:00) Riga\",\"Europe\\/Sofia\":\"(UTC+02:00) Sofia\",\"Europe\\/Tallinn\":\"(UTC+02:00) Tallinn\",\"Europe\\/Vilnius\":\"(UTC+02:00) Vilnius\",\"Asia\\/Baghdad\":\"(UTC+03:00) Baghdad\",\"Asia\\/Kuwait\":\"(UTC+03:00) Kuwait\",\"Europe\\/Minsk\":\"(UTC+03:00) Minsk\",\"Africa\\/Nairobi\":\"(UTC+03:00) Nairobi\",\"Asia\\/Riyadh\":\"(UTC+03:00) Riyadh\",\"Europe\\/Volgograd\":\"(UTC+03:00) Volgograd\",\"Asia\\/Tehran\":\"(UTC+03:30) Tehran\",\"Asia\\/Abu_Dhabi\":\"(UTC+04:00) Abu Dhabi\",\"Asia\\/Baku\":\"(UTC+04:00) Baku\",\"Europe\\/Moscow\":\"(UTC+04:00) Moscow\",\"Asia\\/Muscat\":\"(UTC+04:00) Muscat\",\"Europe\\/St_Petersburg\":\"(UTC+04:00) St. Petersburg\",\"Asia\\/Tbilisi\":\"(UTC+04:00) Tbilisi\",\"Asia\\/Yerevan\":\"(UTC+04:00) Yerevan\",\"Asia\\/Kabul\":\"(UTC+04:30) Kabul\",\"Asia\\/Islamabad\":\"(UTC+05:00) Islamabad\",\"Asia\\/Karachi\":\"(UTC+05:00) Karachi\",\"Asia\\/Tashkent\":\"(UTC+05:00) Tashkent\",\"Asia\\/Calcutta\":\"(UTC+05:30) Chennai\",\"Asia\\/Kolkata\":\"(UTC+05:30) Kolkata\",\"Asia\\/Mumbai\":\"(UTC+05:30) Mumbai\",\"Asia\\/New_Delhi\":\"(UTC+05:30) New Delhi\",\"Asia\\/Sri_Jayawardenepura\":\"(UTC+05:30) Sri Jayawardenepura\",\"Asia\\/Katmandu\":\"(UTC+05:45) Kathmandu\",\"Asia\\/Almaty\":\"(UTC+06:00) Almaty\",\"Asia\\/Astana\":\"(UTC+06:00) Astana\",\"Asia\\/Dhaka\":\"(UTC+06:00) Dhaka\",\"Asia\\/Yekaterinburg\":\"(UTC+06:00) Ekaterinburg\",\"Asia\\/Rangoon\":\"(UTC+06:30) Rangoon\",\"Asia\\/Bangkok\":\"(UTC+07:00) Bangkok\",\"Asia\\/Hanoi\":\"(UTC+07:00) Hanoi\",\"Asia\\/Jakarta\":\"(UTC+07:00) Jakarta\",\"Asia\\/Novosibirsk\":\"(UTC+07:00) Novosibirsk\",\"Asia\\/Beijing\":\"(UTC+08:00) Beijing\",\"Asia\\/Chongqing\":\"(UTC+08:00) Chongqing\",\"Asia\\/Hong_Kong\":\"(UTC+08:00) Hong Kong\",\"Asia\\/Krasnoyarsk\":\"(UTC+08:00) Krasnoyarsk\",\"Asia\\/Kuala_Lumpur\":\"(UTC+08:00) Kuala Lumpur\",\"Australia\\/Perth\":\"(UTC+08:00) Perth\",\"Asia\\/Singapore\":\"(UTC+08:00) Singapore\",\"Asia\\/Taipei\":\"(UTC+08:00) Taipei\",\"Asia\\/Ulan_Bator\":\"(UTC+08:00) Ulaan Bataar\",\"Asia\\/Urumqi\":\"(UTC+08:00) Urumqi\",\"Asia\\/Irkutsk\":\"(UTC+09:00) Irkutsk\",\"Asia\\/Osaka\":\"(UTC+09:00) Osaka\",\"Asia\\/Sapporo\":\"(UTC+09:00) Sapporo\",\"Asia\\/Seoul\":\"(UTC+09:00) Seoul\",\"Asia\\/Tokyo\":\"(UTC+09:00) Tokyo\",\"Australia\\/Adelaide\":\"(UTC+09:30) Adelaide\",\"Australia\\/Darwin\":\"(UTC+09:30) Darwin\",\"Australia\\/Brisbane\":\"(UTC+10:00) Brisbane\",\"Australia\\/Canberra\":\"(UTC+10:00) Canberra\",\"Pacific\\/Guam\":\"(UTC+10:00) Guam\",\"Australia\\/Hobart\":\"(UTC+10:00) Hobart\",\"Australia\\/Melbourne\":\"(UTC+10:00) Melbourne\",\"Pacific\\/Port_Moresby\":\"(UTC+10:00) Port Moresby\",\"Australia\\/Sydney\":\"(UTC+10:00) Sydney\",\"Asia\\/Yakutsk\":\"(UTC+10:00) Yakutsk\",\"Asia\\/Vladivostok\":\"(UTC+11:00) Vladivostok\",\"Pacific\\/Auckland\":\"(UTC+12:00) Auckland\",\"Pacific\\/Fiji\":\"(UTC+12:00) Fiji\",\"Pacific\\/Kwajalein\":\"(UTC+12:00) International Date Line West\",\"Asia\\/Kamchatka\":\"(UTC+12:00) Kamchatka\",\"Asia\\/Magadan\":\"(UTC+12:00) Magadan\",\"Pacific\\/Marshall_Is\":\"(UTC+12:00) Marshall Is.\",\"Asia\\/New_Caledonia\":\"(UTC+12:00) New Caledonia\",\"Asia\\/Solomon_Is\":\"(UTC+12:00) Solomon Is.\",\"Pacific\\/Wellington\":\"(UTC+12:00) Wellington\",\"Pacific\\/Tongatapu\":\"(UTC+13:00) Nuku\'alofa\"},\"placeholder\":\"Choose a timezone...\"}',1,NULL,0,0,0,0,11,2,NULL,NULL,NULL),(130,'directus_users','locale','string','language','{\"limit\":true}',1,NULL,0,0,0,0,12,2,NULL,NULL,NULL),(131,'directus_users','locale_options','json','code',NULL,1,NULL,0,0,1,1,13,4,NULL,NULL,NULL),(132,'directus_users','token','string','text-input',NULL,1,NULL,0,0,1,1,14,4,NULL,NULL,NULL),(133,'directus_users','last_login','datetime','datetime',NULL,1,NULL,0,1,0,0,15,2,NULL,NULL,NULL),(134,'directus_users','last_access_on','datetime','datetime',NULL,1,NULL,0,1,1,0,16,2,NULL,NULL,NULL),(135,'directus_users','last_page','string','text-input',NULL,1,NULL,0,1,1,1,17,2,NULL,NULL,NULL),(136,'directus_users','avatar','file','file',NULL,1,NULL,0,0,0,0,18,4,NULL,NULL,NULL),(137,'directus_users','invite_token','string','text-input',NULL,1,NULL,0,0,1,1,NULL,4,NULL,NULL,NULL),(138,'directus_users','invite_accepted','boolean','toggle',NULL,1,NULL,0,0,1,1,NULL,4,NULL,NULL,NULL),(139,'directus_users','last_ip','string','text-input',NULL,1,NULL,0,1,1,0,NULL,4,NULL,NULL,NULL),(140,'directus_users','external_id','string','text-input',NULL,1,NULL,0,1,1,0,NULL,4,NULL,NULL,NULL),(141,'directus_user_roles','id','integer','primary-key',NULL,1,NULL,1,0,1,0,NULL,4,NULL,NULL,NULL),(142,'directus_user_roles','user','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(143,'directus_user_roles','role','m2o','many-to-one',NULL,1,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(150,'messages','id','integer','primary-key',NULL,0,NULL,0,0,1,1,1,4,NULL,NULL,NULL),(151,'messages','status','status','status','{\"status_mapping\":{\"published\":{\"name\":\"Published\",\"text_color\":\"white\",\"background_color\":\"accent\",\"browse_subdued\":false,\"browse_badge\":true,\"soft_delete\":false,\"published\":true},\"draft\":{\"name\":\"Draft\",\"text_color\":\"white\",\"background_color\":\"blue-grey-200\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":false,\"published\":false},\"deleted\":{\"name\":\"Deleted\",\"text_color\":\"white\",\"background_color\":\"red\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":true,\"published\":false}}}',0,NULL,0,0,0,0,9,4,NULL,NULL,NULL),(152,'messages','created_on','datetime_created','datetime-created',NULL,0,NULL,0,1,1,1,10,4,NULL,NULL,NULL),(153,'messages','subject','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,1,0,0,0,3,4,NULL,NULL,NULL),(154,'messages','to','integer','user','{\"template\":\"{{last_name}}\",\"placeholder\":\"Choose a Customer\",\"display\":\"name\"}',0,NULL,1,0,0,0,2,4,NULL,'',NULL),(155,'messages','message','string','markdown','{\"rows\":5,\"placeholder\":\"Enter **markdown** here...\"}',0,NULL,1,0,0,0,4,4,NULL,NULL,NULL),(156,'messages','attachment_1','file','file','{\"viewType\":\"cards\",\"viewOptions\":{\"title\":\"title\",\"subtitle\":\"type\",\"content\":\"description\",\"src\":\"data\"},\"viewQuery\":[],\"filters\":[]}',0,NULL,0,0,0,0,5,4,NULL,NULL,NULL),(157,'messages','attachment_2','file','file','{\"viewType\":\"cards\",\"viewOptions\":{\"title\":\"title\",\"subtitle\":\"type\",\"content\":\"description\",\"src\":\"data\"},\"viewQuery\":[],\"filters\":[]}',0,NULL,0,0,0,0,6,4,NULL,NULL,NULL),(158,'messages','attachment_3','file','file','{\"viewType\":\"cards\",\"viewOptions\":{\"title\":\"title\",\"subtitle\":\"type\",\"content\":\"description\",\"src\":\"data\"},\"viewQuery\":[],\"filters\":[]}',0,NULL,0,0,0,0,7,4,NULL,NULL,NULL),(159,'messages','read_date','datetime','datetime','{\"localized\":true}',0,NULL,0,0,0,0,8,4,NULL,'',NULL),(160,'messages','created_by','user_created','user-created','{\"template\":\"{{first_name}} {{last_name}}\",\"display\":\"name\"}',0,NULL,0,0,1,1,NULL,4,NULL,NULL,NULL),(161,'profiles','id','integer','primary-key',NULL,0,NULL,0,0,1,1,1,4,NULL,NULL,NULL),(162,'profiles','status','status','status','{\"status_mapping\":{\"published\":{\"name\":\"Published\",\"text_color\":\"white\",\"background_color\":\"accent\",\"browse_subdued\":false,\"browse_badge\":true,\"soft_delete\":false,\"published\":true},\"draft\":{\"name\":\"Draft\",\"text_color\":\"white\",\"background_color\":\"blue-grey-200\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":false,\"published\":false},\"deleted\":{\"name\":\"Deleted\",\"text_color\":\"white\",\"background_color\":\"red\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":true,\"published\":false}}}',0,NULL,0,0,0,0,8,4,NULL,NULL,NULL),(163,'profiles','created_by','user_created','user-created','{\"template\":\"{{last_name}}\",\"display\":\"name\"}',0,NULL,0,1,1,1,9,4,NULL,'',NULL),(164,'profiles','created_on','datetime_created','datetime-created',NULL,0,NULL,0,1,1,1,10,4,NULL,NULL,NULL),(165,'profiles','modified_by','user_updated','user-updated','{\"template\":\"{{last_name}}\",\"display\":\"name\"}',0,NULL,0,1,1,1,11,4,NULL,'',NULL),(166,'profiles','modified_on','datetime_updated','datetime-updated',NULL,0,NULL,0,1,1,1,12,4,NULL,NULL,NULL),(168,'profiles','passport','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,0,0,0,0,3,4,NULL,NULL,NULL),(169,'profiles','phone_1','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,4,4,NULL,NULL,NULL),(170,'profiles','phone_2','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,5,4,NULL,NULL,NULL),(174,'contracts','status','status','status','{\"status_mapping\":{\"published\":{\"name\":\"Published\",\"text_color\":\"white\",\"background_color\":\"accent\",\"browse_subdued\":false,\"browse_badge\":true,\"soft_delete\":false,\"published\":true},\"draft\":{\"name\":\"Draft\",\"text_color\":\"white\",\"background_color\":\"blue-grey-200\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":false,\"published\":false},\"deleted\":{\"name\":\"Deleted\",\"text_color\":\"white\",\"background_color\":\"red\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":true,\"published\":false}}}',0,NULL,0,0,0,0,9,4,NULL,NULL,NULL),(175,'contracts','created_by','user_created','user-created','{\"template\":\"{{last_name}}\",\"display\":\"name\"}',0,NULL,0,1,1,1,10,4,NULL,'',NULL),(176,'contracts','created_on','datetime_created','datetime-created',NULL,0,NULL,0,1,1,1,11,4,NULL,NULL,NULL),(177,'contracts','customer','integer','user','{\"template\":\"{{last_name}}\",\"placeholder\":\"Choose a Customer\",\"display\":\"name\"}',0,NULL,1,0,0,0,3,4,NULL,NULL,NULL),(178,'profiles','customer','integer','user','{\"template\":\"{{last_name}}\",\"placeholder\":\"Choose a Customer\",\"display\":\"name\"}',0,NULL,1,0,0,0,2,4,NULL,'',NULL),(179,'contracts','building_plot','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,4,4,NULL,NULL,NULL),(180,'contracts','building_number','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"small\"}',0,NULL,0,0,0,0,5,4,NULL,NULL,NULL),(181,'contracts','floor','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"small\"}',0,NULL,0,0,0,0,6,4,NULL,NULL,NULL),(182,'contracts','apartment','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,7,4,NULL,NULL,NULL),(183,'contracts','rooms','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"small\"}',0,NULL,0,0,0,0,8,4,NULL,NULL,NULL),(184,'contracts','contract_number','integer','primary-key','{\"localized\":false}',0,NULL,1,0,0,0,1,4,NULL,'',NULL),(185,'group_info','id','integer','primary-key',NULL,0,NULL,0,0,1,1,1,4,NULL,NULL,NULL),(186,'group_info','status','status','status','{\"status_mapping\":{\"published\":{\"name\":\"Published\",\"text_color\":\"white\",\"background_color\":\"accent\",\"browse_subdued\":false,\"browse_badge\":true,\"soft_delete\":false,\"published\":true},\"draft\":{\"name\":\"Draft\",\"text_color\":\"white\",\"background_color\":\"blue-grey-200\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":false,\"published\":false},\"deleted\":{\"name\":\"Deleted\",\"text_color\":\"white\",\"background_color\":\"red\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":true,\"published\":false}}}',0,NULL,0,0,0,0,9,4,NULL,NULL,NULL),(187,'group_info','created_by','user_created','user-created','{\"template\":\"{{first_name}} {{last_name}}\",\"display\":\"both\"}',0,NULL,0,1,1,1,10,4,NULL,NULL,NULL),(188,'group_info','created_on','datetime_created','datetime-created',NULL,0,NULL,0,1,1,1,11,4,NULL,NULL,NULL),(189,'group_info','modified_by','user_updated','user-updated','{\"template\":\"{{first_name}} {{last_name}}\",\"display\":\"both\"}',0,NULL,0,1,1,1,12,4,NULL,NULL,NULL),(190,'group_info','modified_on','datetime_updated','datetime-updated',NULL,0,NULL,0,1,1,1,13,4,NULL,NULL,NULL),(191,'group_info','phone','integer','numeric','{\"placeholder\":\"Phone in any format\",\"localized\":false}',0,NULL,0,0,0,0,3,4,NULL,'Phone on contacts screen',NULL),(192,'group_info','email','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"small\"}',0,NULL,0,0,0,0,4,4,NULL,'',NULL),(193,'group_info','photo_1','file','file','{\"viewType\":\"cards\",\"viewOptions\":{\"title\":\"title\",\"subtitle\":\"type\",\"content\":\"description\",\"src\":\"data\"},\"viewQuery\":[],\"filters\":[]}',0,NULL,0,0,0,0,5,4,NULL,'',NULL),(194,'group_info','photo_2','file','file','{\"viewType\":\"cards\",\"viewOptions\":{\"title\":\"title\",\"subtitle\":\"type\",\"content\":\"description\",\"src\":\"data\"},\"viewQuery\":[],\"filters\":[]}',0,NULL,0,0,0,0,6,4,NULL,'',NULL),(195,'group_info','photo_3','file','file','{\"viewType\":\"cards\",\"viewOptions\":{\"title\":\"title\",\"subtitle\":\"type\",\"content\":\"description\",\"src\":\"data\"},\"viewQuery\":[],\"filters\":[]}',0,NULL,0,0,0,0,7,4,NULL,'',NULL),(196,'group_info','photo_4','file','file','{\"viewType\":\"cards\",\"viewOptions\":{\"title\":\"title\",\"subtitle\":\"type\",\"content\":\"description\",\"src\":\"data\"},\"viewQuery\":[],\"filters\":[]}',0,NULL,0,0,0,0,8,4,NULL,'',NULL),(197,'group_info','group_name','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,1,0,0,0,2,4,NULL,'',NULL),(200,'contracts','group','m2o','many-to-one','{\"template\":\"{{group_name}}\",\"placeholder\":\"Select one\"}',0,NULL,1,0,0,0,2,4,NULL,NULL,NULL),(201,'profiles','home_address','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,0,0,0,0,7,4,NULL,'',NULL),(202,'feedback','id','integer','primary-key',NULL,0,NULL,0,0,1,1,1,4,NULL,NULL,NULL),(203,'feedback','created_on','datetime_created','datetime-created',NULL,0,NULL,0,1,1,1,7,4,NULL,NULL,NULL),(204,'feedback','first_name','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,0,1,0,0,2,4,NULL,'',NULL),(205,'feedback','last_name','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,0,1,0,0,3,4,NULL,'',NULL),(206,'feedback','phone','integer','numeric','{\"localized\":false}',0,NULL,0,1,0,0,4,4,NULL,'',NULL),(207,'feedback','email','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,0,1,0,0,5,4,NULL,'',NULL),(208,'feedback','details','string','textarea','{\"rows\":12}',0,NULL,0,1,0,0,6,4,NULL,'',NULL),(209,'balance_data','id','integer','primary-key',NULL,0,NULL,0,0,1,1,1,4,NULL,NULL,NULL),(210,'balance_data','status','status','status','{\"status_mapping\":{\"published\":{\"name\":\"Published\",\"text_color\":\"white\",\"background_color\":\"accent\",\"browse_subdued\":false,\"browse_badge\":true,\"soft_delete\":false,\"published\":true},\"draft\":{\"name\":\"Draft\",\"text_color\":\"white\",\"background_color\":\"blue-grey-200\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":false,\"published\":false},\"deleted\":{\"name\":\"Deleted\",\"text_color\":\"white\",\"background_color\":\"red\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":true,\"published\":false}}}',0,NULL,0,0,0,0,2,4,NULL,NULL,NULL),(211,'balance_data','created_by','user_created','user-created','{\"template\":\"{{first_name}} {{last_name}}\",\"display\":\"both\"}',0,NULL,0,1,1,1,14,4,NULL,NULL,NULL),(212,'balance_data','created_on','datetime_created','datetime-created',NULL,0,NULL,0,1,1,1,15,4,NULL,NULL,NULL),(213,'balance_data','contract_number','m2o','many-to-one','{\"placeholder\":\"Select one\",\"threshold\":20,\"template\":\"{{contract_number}}\",\"preferences\":{\"viewType\":\"tabular\",\"viewQuery\":{\"fields\":[\"contract_number\",\"customer\"]}}}',0,NULL,1,0,0,0,3,4,NULL,'',NULL),(214,'balance_data','unit_cost','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,4,4,NULL,NULL,NULL),(215,'balance_data','funds','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,5,4,NULL,NULL,NULL),(216,'balance_data','land_amount','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,6,4,NULL,NULL,NULL),(217,'balance_data','land_completeness','integer','slider','{\"localized\":false,\"minimum\":0,\"maximum\":100,\"step\":1,\"unit\":\"percents\"}',0,NULL,1,0,0,0,7,4,NULL,NULL,NULL),(218,'balance_data','construction_amount','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,8,4,NULL,NULL,NULL),(219,'balance_data','construction_completeness','integer','slider','{\"minimum\":0,\"maximum\":100,\"step\":1,\"unit\":\"percents\"}',0,NULL,1,0,0,0,9,4,NULL,NULL,NULL),(220,'balance_data','management_amount','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,10,4,NULL,NULL,NULL),(221,'balance_data','management_completeness','integer','slider','{\"minimum\":0,\"maximum\":100,\"step\":1,\"unit\":\"percents\"}',0,NULL,1,0,0,0,11,4,NULL,NULL,NULL),(222,'balance_data','balance','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,12,4,NULL,NULL,NULL),(223,'balance_data','updated_date','date','date','{\"localized\":true,\"showRelative\":false}',0,NULL,1,0,0,0,13,4,NULL,NULL,NULL),(224,'construction_progress','id','integer','primary-key',NULL,0,NULL,0,0,1,1,1,4,NULL,NULL,NULL),(225,'construction_progress','status','status','status','{\"status_mapping\":{\"published\":{\"name\":\"Published\",\"text_color\":\"white\",\"background_color\":\"accent\",\"browse_subdued\":false,\"browse_badge\":true,\"soft_delete\":false,\"published\":true},\"draft\":{\"name\":\"Draft\",\"text_color\":\"white\",\"background_color\":\"blue-grey-200\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":false,\"published\":false},\"deleted\":{\"name\":\"Deleted\",\"text_color\":\"white\",\"background_color\":\"red\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":true,\"published\":false}}}',0,NULL,0,0,0,0,2,4,NULL,NULL,NULL),(226,'construction_progress','created_by','user_created','user-created','{\"template\":\"{{first_name}} {{last_name}}\",\"display\":\"both\"}',0,NULL,0,1,1,1,7,4,NULL,NULL,NULL),(227,'construction_progress','created_on','datetime_created','datetime-created',NULL,0,NULL,0,1,1,1,8,4,NULL,NULL,NULL),(228,'construction_progress','group','m2o','many-to-one','{\"template\":\"{{group_name}}\",\"placeholder\":\"Select one\",\"threshold\":20}',0,NULL,1,0,0,0,3,4,NULL,NULL,NULL),(229,'construction_progress','milestone_name','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,1,0,0,0,4,4,NULL,NULL,NULL),(230,'construction_progress','is_complete','boolean','toggle','{\"choices\":{\"value1\":\"Option 1\",\"value2\":\"Option 2\",\"value3\":\"Option 3\",\"value4\":\"Option 4\",\"value5\":\"Option 5\",\"value6\":\"Option 6\",\"value7\":\"Option 7\",\"value8\":\"Option 8\"},\"wrap\":false,\"formatting\":true,\"checkbox\":true}',0,NULL,0,0,0,0,5,4,NULL,NULL,NULL),(231,'construction_progress','updated_date','date','date','{\"localized\":true,\"showRelative\":false}',0,NULL,1,0,0,0,6,4,NULL,NULL,NULL),(232,'receipts','id','integer','primary-key',NULL,0,NULL,0,0,1,1,1,4,NULL,NULL,NULL),(233,'receipts','status','status','status','{\"status_mapping\":{\"published\":{\"name\":\"Published\",\"text_color\":\"white\",\"background_color\":\"accent\",\"browse_subdued\":false,\"browse_badge\":true,\"soft_delete\":false,\"published\":true},\"draft\":{\"name\":\"Draft\",\"text_color\":\"white\",\"background_color\":\"blue-grey-200\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":false,\"published\":false},\"deleted\":{\"name\":\"Deleted\",\"text_color\":\"white\",\"background_color\":\"red\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":true,\"published\":false}}}',0,NULL,0,0,0,0,2,4,NULL,NULL,NULL),(234,'receipts','created_by','user_created','user-created','{\"template\":\"{{first_name}} {{last_name}}\",\"display\":\"both\"}',0,NULL,0,1,1,1,15,4,NULL,NULL,NULL),(235,'receipts','created_on','datetime_created','datetime-created',NULL,0,NULL,0,1,1,1,16,4,NULL,NULL,NULL),(236,'receipts','contract_number','m2o','many-to-one','{\"template\":\"{{contract_number}}\",\"placeholder\":\"Select one\",\"threshold\":20,\"preferences\":{\"viewType\":\"tabular\",\"viewQuery\":{\"fields\":[\"contract_number\",\"customer\"]}}}',0,NULL,1,0,0,0,3,4,NULL,'',NULL),(237,'receipts','request_amount','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,4,4,NULL,NULL,NULL),(238,'receipts','request_description','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,1,0,0,0,5,4,NULL,NULL,NULL),(239,'receipts','request_date','date','date','{\"localized\":true,\"showRelative\":false}',0,NULL,1,0,0,0,6,4,NULL,NULL,NULL),(240,'receipts','request_amount_2','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,7,4,NULL,NULL,NULL),(241,'receipts','request_description_2','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,0,0,0,0,8,4,NULL,NULL,NULL),(242,'receipts','request_date_2','date','date','{\"localized\":true,\"showRelative\":false}',0,NULL,0,0,0,0,9,4,NULL,NULL,NULL),(243,'receipts','request_amount_3','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,10,4,NULL,NULL,NULL),(244,'receipts','request_description_3','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,0,0,0,0,11,4,NULL,NULL,NULL),(245,'receipts','request_date_3','date','date','{\"localized\":true,\"showRelative\":false}',0,NULL,0,0,0,0,12,4,NULL,NULL,NULL),(246,'receipts','total_amount','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,13,4,NULL,NULL,NULL),(247,'receipts','updated_date','date','date','{\"localized\":true,\"showRelative\":false}',0,NULL,1,0,0,0,14,4,NULL,NULL,NULL),(248,'funding_reports','id','integer','primary-key',NULL,0,NULL,0,0,1,1,1,4,NULL,NULL,NULL),(249,'funding_reports','status','status','status','{\"status_mapping\":{\"published\":{\"name\":\"Published\",\"text_color\":\"white\",\"background_color\":\"accent\",\"browse_subdued\":false,\"browse_badge\":true,\"soft_delete\":false,\"published\":true},\"draft\":{\"name\":\"Draft\",\"text_color\":\"white\",\"background_color\":\"blue-grey-200\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":false,\"published\":false},\"deleted\":{\"name\":\"Deleted\",\"text_color\":\"white\",\"background_color\":\"red\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":true,\"published\":false}}}',0,NULL,0,0,0,0,2,4,NULL,NULL,NULL),(250,'funding_reports','created_by','user_created','user-created','{\"template\":\"{{first_name}} {{last_name}}\",\"display\":\"both\"}',0,NULL,0,1,1,1,9,4,NULL,NULL,NULL),(251,'funding_reports','created_on','datetime_created','datetime-created',NULL,0,NULL,0,1,1,1,10,4,NULL,NULL,NULL),(252,'funding_reports','contract_number','m2o','many-to-one','{\"template\":\"{{contract_number}}\",\"placeholder\":\"Select one\",\"threshold\":20,\"preferences\":{\"viewType\":\"tabular\",\"viewQuery\":{\"fields\":[\"contract_number\",\"customer\"]}}}',0,NULL,1,0,0,0,3,4,NULL,'',NULL),(253,'funding_reports','date_range','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,1,0,0,0,4,4,NULL,NULL,NULL),(254,'funding_reports','total_debit','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,5,4,NULL,NULL,NULL),(255,'funding_reports','total_credit','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,6,4,NULL,NULL,NULL),(256,'funding_reports','total_balance','integer','numeric','{\"localized\":false}',0,NULL,1,0,0,0,7,4,NULL,NULL,NULL),(257,'funding_reports','updated_date','date','date','{\"localized\":true,\"showRelative\":false}',0,NULL,1,0,0,0,8,4,NULL,NULL,NULL),(258,'transactions','id','integer','primary-key',NULL,0,NULL,0,0,1,1,1,4,NULL,NULL,NULL),(259,'transactions','status','status','status','{\"status_mapping\":{\"published\":{\"name\":\"Published\",\"text_color\":\"white\",\"background_color\":\"accent\",\"browse_subdued\":false,\"browse_badge\":true,\"soft_delete\":false,\"published\":true},\"draft\":{\"name\":\"Draft\",\"text_color\":\"white\",\"background_color\":\"blue-grey-200\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":false,\"published\":false},\"deleted\":{\"name\":\"Deleted\",\"text_color\":\"white\",\"background_color\":\"red\",\"browse_subdued\":true,\"browse_badge\":true,\"soft_delete\":true,\"published\":false}}}',0,NULL,0,0,0,0,2,4,NULL,NULL,NULL),(260,'transactions','created_by','user_created','user-created','{\"template\":\"{{first_name}} {{last_name}}\",\"display\":\"both\"}',0,NULL,0,1,1,1,16,4,NULL,NULL,NULL),(261,'transactions','created_on','datetime_created','datetime-created',NULL,0,NULL,0,1,1,1,17,4,NULL,NULL,NULL),(263,'transactions','funding_report','m2o','many-to-one','{\"template\":\"{{contract_number.contract_number}} {{updated_date}}\",\"placeholder\":\"Select one\",\"threshold\":20}',0,NULL,1,0,0,0,3,4,NULL,NULL,NULL),(264,'transactions','title','integer','numeric','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\",\"localized\":false}',0,NULL,0,0,0,0,4,4,NULL,NULL,NULL),(265,'transactions','move','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,5,4,NULL,NULL,NULL),(266,'transactions','ration','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,6,4,NULL,NULL,NULL),(267,'transactions','counter_account','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,7,4,NULL,NULL,NULL),(270,'transactions','date_1','date','date','{\"localized\":true,\"showRelative\":false}',0,NULL,0,0,0,0,8,4,NULL,NULL,NULL),(271,'transactions','date_2','date','date','{\"localized\":true,\"showRelative\":false}',0,NULL,0,0,0,0,9,4,NULL,NULL,NULL),(272,'transactions','reference_1','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,10,4,NULL,NULL,NULL),(273,'transactions','reference_2','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,11,4,NULL,NULL,NULL),(274,'transactions','details','string','text-input','{\"trim\":true,\"showCharacterCount\":true,\"formatValue\":false,\"width\":\"auto\"}',0,NULL,0,0,0,0,12,4,NULL,NULL,NULL),(275,'transactions','debit','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,13,4,NULL,NULL,NULL),(276,'transactions','credit','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,14,4,NULL,NULL,NULL),(277,'transactions','balance','integer','numeric','{\"localized\":false}',0,NULL,0,0,0,0,15,4,NULL,NULL,NULL),(278,'directus_roles','users','o2m','many-to-many',NULL,0,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(279,'directus_files','checksum','string','text-input',NULL,0,NULL,0,0,0,0,NULL,4,NULL,NULL,NULL),(283,'imports','excel_file','file','file','{\"viewType\":\"cards\",\"viewOptions\":{\"title\":\"title\",\"subtitle\":\"type\",\"content\":\"description\",\"src\":\"data\"},\"viewQuery\":[],\"filters\":[{\"field\":\"type\",\"operator\":\"in\",\"value\":[\"application\\/msexcel\",\"application\\/vnd.openxmlformats-officedocument.spreadsheetml.sheet\"]}]}',0,NULL,1,0,0,0,2,4,NULL,'',NULL),(284,'imports','import_target','string','radio-buttons','{\"choices\":{\"profiles\":\"Profiles\",\"balance_data\":\"Balance Data\",\"construction_progress\":\"Construction Progress\",\"funding_reports\":\"Funding Reports\",\"receipts\":\"Receipts\"},\"format\":true}',0,NULL,1,0,0,0,3,4,NULL,'',NULL),(285,'imports','id','integer','primary-key','[]',0,NULL,1,0,1,1,1,4,NULL,'',NULL),(286,'imports','created_by','user_created','user-created','{\"template\":\"{{first_name}} {{last_name}}\",\"display\":\"name\"}',0,NULL,0,0,1,0,4,4,NULL,'',NULL),(287,'imports','created_on','datetime_created','datetime-created','[]',0,NULL,0,0,1,0,5,4,NULL,'',NULL),(288,'imports','items_created','integer','numeric','{\"localized\":false}',0,NULL,0,1,0,0,6,4,NULL,'',NULL),(289,'imports','items_rejected','integer','numeric','{\"localized\":false}',0,NULL,0,1,0,0,7,4,NULL,'',NULL);
/*!40000 ALTER TABLE `directus_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_files`
--

DROP TABLE IF EXISTS `directus_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `storage` varchar(50) NOT NULL DEFAULT 'local',
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) unsigned NOT NULL,
  `uploaded_on` datetime NOT NULL,
  `charset` varchar(50) DEFAULT NULL,
  `filesize` int(11) unsigned NOT NULL DEFAULT '0',
  `width` int(11) unsigned DEFAULT NULL,
  `height` int(11) unsigned DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `embed` varchar(200) DEFAULT NULL,
  `folder` int(11) unsigned DEFAULT NULL,
  `description` text,
  `location` varchar(200) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `metadata` text,
  `checksum` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_files`
--

LOCK TABLES `directus_files` WRITE;
/*!40000 ALTER TABLE `directus_files` DISABLE KEYS */;
INSERT INTO `directus_files` VALUES (6,'local','photo1.jpg','Photo1','image/jpeg',1,'2019-01-24 05:31:54','binary',219786,616,398,NULL,NULL,NULL,'','','',NULL,NULL),(8,'local','photo3.jpg','Photo3','image/jpeg',1,'2019-01-24 05:32:08','binary',243956,616,398,NULL,NULL,NULL,'','','',NULL,NULL),(9,'local','photo2_fullsize.jpg','Photo2 Fullsize','image/jpeg',1,'2019-01-24 05:32:17','binary',451222,1202,801,NULL,NULL,NULL,'','','',NULL,NULL),(10,'local','photo4.jpg','Photo4','image/jpeg',1,'2019-01-24 05:32:23','binary',226412,616,398,NULL,NULL,NULL,'','','',NULL,NULL);
/*!40000 ALTER TABLE `directus_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_folders`
--

DROP TABLE IF EXISTS `directus_folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_folders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 NOT NULL,
  `parent_folder` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_name_parent_folder` (`name`,`parent_folder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_folders`
--

LOCK TABLES `directus_folders` WRITE;
/*!40000 ALTER TABLE `directus_folders` DISABLE KEYS */;
/*!40000 ALTER TABLE `directus_folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_migrations`
--

DROP TABLE IF EXISTS `directus_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_migrations` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_migrations`
--

LOCK TABLES `directus_migrations` WRITE;
/*!40000 ALTER TABLE `directus_migrations` DISABLE KEYS */;
INSERT INTO `directus_migrations` VALUES (20180220023138,'CreateActivityTable','2019-01-22 15:52:06','2019-01-22 15:52:06',0),(20180220023144,'CreateActivitySeenTable','2019-01-22 15:52:06','2019-01-22 15:52:06',0),(20180220023152,'CreateCollectionsPresetsTable','2019-01-22 15:52:06','2019-01-22 15:52:07',0),(20180220023157,'CreateCollectionsTable','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20180220023202,'CreateFieldsTable','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20180220023208,'CreateFilesTable','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20180220023213,'CreateFoldersTable','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20180220023217,'CreateRolesTable','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20180220023226,'CreatePermissionsTable','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20180220023232,'CreateRelationsTable','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20180220023238,'CreateRevisionsTable','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20180220023243,'CreateSettingsTable','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20180220023248,'CreateUsersTable','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20180426173310,'CreateUserRoles','2019-01-22 15:52:07','2019-01-22 15:52:07',0),(20181022175715,'Upgrade070003','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20181102153600,'TimezoneChoices','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20181105165224,'Upgrade070006','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20181122195602,'LocaleInterface','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20181123171520,'RemoveScope','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20181210204720,'AddTrustedProxiesSettingField','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20181222023800,'AddProjectUrlSettingField','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20181227042755,'IncreaseUsersLastPageLength','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20190104155309,'AddUsersEmailValidation','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20190111193724,'AddAppUrlSettingField','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20190111212736,'AddMissingSettingsField','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20190118181424,'AddRolesUsersField','2019-03-03 10:51:50','2019-03-03 10:51:50',0),(20190130215921,'AddFilesChecksumField','2019-03-03 10:51:50','2019-03-03 10:51:50',0);
/*!40000 ALTER TABLE `directus_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_permissions`
--

DROP TABLE IF EXISTS `directus_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `collection` varchar(64) NOT NULL,
  `role` int(11) unsigned NOT NULL,
  `status` varchar(64) DEFAULT NULL,
  `create` varchar(16) DEFAULT 'none',
  `read` varchar(16) DEFAULT 'none',
  `update` varchar(16) DEFAULT 'none',
  `delete` varchar(16) DEFAULT 'none',
  `comment` varchar(8) DEFAULT 'none',
  `explain` varchar(8) DEFAULT 'none',
  `read_field_blacklist` varchar(1000) DEFAULT NULL,
  `write_field_blacklist` varchar(1000) DEFAULT NULL,
  `status_blacklist` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_permissions`
--

LOCK TABLES `directus_permissions` WRITE;
/*!40000 ALTER TABLE `directus_permissions` DISABLE KEYS */;
INSERT INTO `directus_permissions` VALUES (1,'directus_activity',3,NULL,'full','mine','none','none','update','none',NULL,NULL,NULL),(2,'directus_activity_seen',3,NULL,'full','mine','mine','mine','none','none',NULL,NULL,NULL),(3,'directus_collection_presets',3,NULL,'full','full','mine','mine','none','none',NULL,NULL,NULL),(4,'directus_collections',3,NULL,'none','full','none','none','none','none',NULL,NULL,NULL),(5,'directus_fields',3,NULL,'none','full','none','none','none','none',NULL,NULL,NULL),(6,'directus_files',3,NULL,'full','full','full','full','none','none',NULL,NULL,NULL),(7,'directus_folders',3,NULL,'full','full','full','full','none','none',NULL,NULL,NULL),(8,'directus_permissions',3,NULL,'none','mine','none','none','none','none',NULL,NULL,NULL),(9,'directus_relations',3,NULL,'none','full','none','none','none','none',NULL,NULL,NULL),(10,'directus_revisions',3,NULL,'full','full','none','none','none','none',NULL,NULL,NULL),(11,'directus_roles',3,NULL,'none','mine','none','none','none','none',NULL,NULL,NULL),(12,'directus_settings',3,NULL,'none','full','none','none','none','none',NULL,NULL,NULL),(13,'directus_user_roles',3,NULL,'none','mine','none','none','none','none',NULL,NULL,NULL),(14,'directus_users',3,'active','none','full','mine','mine','none','none',NULL,NULL,NULL),(15,'directus_users',3,'deleted','none','none','none','none','none','none',NULL,NULL,NULL),(16,'directus_users',3,'draft','none','none','none','none','none','none',NULL,NULL,NULL),(17,'directus_users',3,'invited','none','none','none','none','none','none',NULL,NULL,NULL),(18,'directus_users',3,'suspended','none','none','none','none','none','none',NULL,NULL,NULL),(19,'directus_activity',4,NULL,'full','mine','none','none','update','none',NULL,NULL,NULL),(20,'directus_activity_seen',4,NULL,'full','mine','mine','mine','none','none',NULL,NULL,NULL),(21,'directus_collection_presets',4,NULL,'full','full','mine','mine','none','none',NULL,NULL,NULL),(22,'directus_collections',4,NULL,'none','full','none','none','none','none',NULL,NULL,NULL),(23,'directus_fields',4,NULL,'none','full','none','none','none','none',NULL,NULL,NULL),(24,'directus_files',4,NULL,'full','full','full','full','none','none',NULL,NULL,NULL),(25,'directus_folders',4,NULL,'full','full','full','full','none','none',NULL,NULL,NULL),(26,'directus_permissions',4,NULL,'none','mine','none','none','none','none',NULL,NULL,NULL),(27,'directus_relations',4,NULL,'none','full','none','none','none','none',NULL,NULL,NULL),(28,'directus_revisions',4,NULL,'full','full','none','none','none','none',NULL,NULL,NULL),(29,'directus_roles',4,NULL,'none','mine','none','none','none','none',NULL,NULL,NULL),(30,'directus_settings',4,NULL,'none','full','none','none','none','none',NULL,NULL,NULL),(31,'directus_user_roles',4,NULL,'none','mine','none','none','none','none',NULL,NULL,NULL),(32,'directus_users',4,'active','none','full','mine','mine','none','none',NULL,NULL,NULL),(33,'directus_users',4,'deleted','none','none','none','none','none','none',NULL,NULL,NULL),(34,'directus_users',4,'draft','none','none','none','none','none','none',NULL,NULL,NULL),(35,'directus_users',4,'invited','none','none','none','none','none','none',NULL,NULL,NULL),(36,'directus_users',4,'suspended','none','none','none','none','none','none',NULL,NULL,NULL),(37,'group_info',4,'published','none','role','role','none','full','none',NULL,NULL,NULL),(38,'group_info',4,'draft','none','role','role','none','full','none',NULL,NULL,NULL),(39,'group_info',4,'deleted','none','role','role','none','full','none',NULL,NULL,NULL),(40,'contracts',3,'published','none','mine','none','none','none','none',NULL,NULL,''),(41,'contracts',3,'draft','none','none','none','none','none','none',NULL,NULL,NULL),(42,'contracts',3,'deleted','none','none','none','none','none','none',NULL,NULL,NULL),(43,'group_info',3,'published','none','full','none','none','none','none',NULL,NULL,NULL),(44,'group_info',3,'draft','none','none','none','none','none','none',NULL,NULL,NULL),(45,'group_info',3,'deleted','none','none','none','none','none','none',NULL,NULL,NULL),(46,'profiles',3,'published','none','mine','mine','none','none','none',NULL,'id,status,created_by,created_on,modified_by,modified_on,customer,passport',NULL),(47,'profiles',3,'draft','none','none','none','none','none','none',NULL,NULL,NULL),(48,'profiles',3,'deleted','none','none','none','none','none','none',NULL,NULL,NULL),(49,'messages',3,'published','none','mine','mine','none','none','none',NULL,'id,status,created_on,subject,to,message,attachment_1,attachment_2,attachment_3,created_by',''),(50,'messages',3,'draft','none','none','none','none','none','none',NULL,NULL,NULL),(51,'messages',3,'deleted','none','none','none','none','none','none',NULL,NULL,NULL),(52,'messages',3,'$create','none','none','none','none','none','none','attachment_2','attachment_1','deleted'),(53,'contracts',3,'$create','none','none','none','none','none','none',NULL,NULL,'deleted'),(54,'feedback',2,NULL,'full','none','none','none','none','none',NULL,NULL,NULL),(55,'feedback',3,NULL,'full','none','none','none','none','none',NULL,NULL,NULL),(56,'balance_data',3,'published','none','mine','none','none','none','none',NULL,NULL,NULL),(57,'construction_progress',3,'published','none','full','none','none','none','none',NULL,NULL,NULL),(58,'construction_progress',3,'draft','none','none','none','none','none','none',NULL,NULL,NULL),(59,'construction_progress',3,'deleted','none','none','none','none','none','none',NULL,NULL,NULL),(60,'receipts',3,'published','none','mine','none','none','none','none',NULL,NULL,NULL),(61,'funding_reports',3,'published','none','mine','none','none','none','none',NULL,NULL,NULL),(62,'transactions',3,'published','none','mine','none','none','none','none',NULL,NULL,NULL);
/*!40000 ALTER TABLE `directus_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_relations`
--

DROP TABLE IF EXISTS `directus_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_relations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `collection_many` varchar(64) NOT NULL,
  `field_many` varchar(45) NOT NULL,
  `collection_one` varchar(64) DEFAULT NULL,
  `field_one` varchar(64) DEFAULT NULL,
  `junction_field` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_relations`
--

LOCK TABLES `directus_relations` WRITE;
/*!40000 ALTER TABLE `directus_relations` DISABLE KEYS */;
INSERT INTO `directus_relations` VALUES (1,'directus_activity','action_by','directus_users',NULL,NULL),(2,'directus_activity_seen','user','directus_users',NULL,NULL),(3,'directus_activity_seen','activity','directus_activity',NULL,NULL),(4,'directus_collections_presets','user','directus_users',NULL,NULL),(5,'directus_collections_presets','group','directus_groups',NULL,NULL),(6,'directus_files','uploaded_by','directus_users',NULL,NULL),(7,'directus_files','folder','directus_folders',NULL,NULL),(8,'directus_folders','parent_folder','directus_folders',NULL,NULL),(9,'directus_permissions','group','directus_groups',NULL,NULL),(10,'directus_revisions','activity','directus_activity',NULL,NULL),(11,'directus_user_roles','user','directus_users','roles','role'),(12,'directus_user_roles','role','directus_roles','users','user'),(13,'directus_users','avatar','directus_files',NULL,NULL),(14,'directus_fields','collection','directus_collections','fields',NULL),(15,'contracts','group_m21','group_info',NULL,NULL),(16,'contracts','group','group_info',NULL,NULL),(17,'balance_data','contract_number','contracts',NULL,NULL),(18,'construction_progress','group','group_info',NULL,NULL),(19,'receipts','contract_number','contracts',NULL,NULL),(20,'funding_reports','contract_number','contracts',NULL,NULL),(22,'transactions','funding_report','funding_reports',NULL,NULL);
/*!40000 ALTER TABLE `directus_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_revisions`
--

DROP TABLE IF EXISTS `directus_revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_revisions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity` int(11) unsigned NOT NULL,
  `collection` varchar(64) NOT NULL,
  `item` varchar(255) NOT NULL,
  `data` longtext NOT NULL,
  `delta` longtext,
  `parent_collection` varchar(64) DEFAULT NULL,
  `parent_item` varchar(255) DEFAULT NULL,
  `parent_changed` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_revisions`
--

LOCK TABLES `directus_revisions` WRITE;
/*!40000 ALTER TABLE `directus_revisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `directus_revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_roles`
--

DROP TABLE IF EXISTS `directus_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `ip_whitelist` text,
  `nav_blacklist` text,
  `external_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_group_name` (`name`),
  UNIQUE KEY `idx_roles_external_id` (`external_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_roles`
--

LOCK TABLES `directus_roles` WRITE;
/*!40000 ALTER TABLE `directus_roles` DISABLE KEYS */;
INSERT INTO `directus_roles` VALUES (1,'Super Admin','Admins have access to all managed data within the system by default',NULL,NULL,NULL),(2,'Public','This sets the data that is publicly available through the API without a token',NULL,NULL,NULL),(3,'Customers',NULL,NULL,NULL,'6157098c-8bc6-4377-96db-ae232c9606f4');
/*!40000 ALTER TABLE `directus_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_settings`
--

DROP TABLE IF EXISTS `directus_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_settings`
--

LOCK TABLES `directus_settings` WRITE;
/*!40000 ALTER TABLE `directus_settings` DISABLE KEYS */;
INSERT INTO `directus_settings` VALUES (1,'project_name','BDO Realestate'),(2,'project_url',''),(3,'app_url',''),(4,'logo',''),(5,'color','red'),(6,'default_limit','200'),(7,'sort_null_last','1'),(8,'auto_sign_out','180'),(9,'youtube_api_key',''),(10,'trusted_proxies',''),(11,'thumbnail_dimensions','200x200'),(12,'thumbnail_quality_tags','{\"poor\": 25, \"good\": 50, \"better\":  75, \"best\": 100}'),(13,'thumbnail_actions','{\"contain\":{\"options\":{\"resizeCanvas\":false,\"position\":\"center\",\"resizeRelative\":false,\"canvasBackground\":\"ccc\"}},\"crop\":{\"options\":{\"position\":\"center\"}}}'),(14,'thumbnail_cache_ttl','86400'),(15,'thumbnail_not_found_location','');
/*!40000 ALTER TABLE `directus_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_user_roles`
--

DROP TABLE IF EXISTS `directus_user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_user_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) unsigned DEFAULT NULL,
  `role` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_role` (`user`,`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_user_roles`
--

LOCK TABLES `directus_user_roles` WRITE;
/*!40000 ALTER TABLE `directus_user_roles` DISABLE KEYS */;
INSERT INTO `directus_user_roles` VALUES (1,1,1),(2,2,3);
/*!40000 ALTER TABLE `directus_user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directus_users`
--

DROP TABLE IF EXISTS `directus_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directus_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(16) NOT NULL DEFAULT 'draft',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `timezone` varchar(32) NOT NULL DEFAULT 'America/New_York',
  `locale` varchar(8) DEFAULT 'en-US',
  `locale_options` text,
  `avatar` int(11) unsigned DEFAULT NULL,
  `company` varchar(191) DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `email_notifications` int(1) NOT NULL DEFAULT '1',
  `last_access_on` datetime DEFAULT NULL,
  `last_page` varchar(192) DEFAULT NULL,
  `external_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_users_email` (`email`),
  UNIQUE KEY `idx_users_token` (`token`),
  UNIQUE KEY `idx_users_external_id` (`external_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directus_users`
--

LOCK TABLES `directus_users` WRITE;
/*!40000 ALTER TABLE `directus_users` DISABLE KEYS */;
INSERT INTO `directus_users` VALUES (1,'active','Admin','User','ZipiF@bdo.co.il','$2y$10$v2lxYD5LANkUsmzj19AyceEE9IScwTsjsG1qMXuezGI86drvdcreK',NULL,'Asia/Jerusalem','en-US',NULL,NULL,NULL,NULL,0,'2019-03-30 18:19:50','/users',NULL),(2,'active','ישראל ישראלי','ישראל ישראלי','demo@example.com','$2y$10$VRcx5zhtZiCd3eTMWKjBv.IzI8jfMWD5hOa.t4WZn9i32ge/YNDjO',NULL,'Asia/Jerusalem','en-US',NULL,NULL,NULL,NULL,0,'2019-01-24 07:24:01','/collections','5d1d1125-b406-456f-9c79-23303cea4ad4');
/*!40000 ALTER TABLE `directus_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `created_on` datetime DEFAULT NULL,
  `first_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` bigint(11) unsigned DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funding_reports`
--

DROP TABLE IF EXISTS `funding_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funding_reports` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `contract_number` int(10) unsigned DEFAULT NULL,
  `date_range` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_debit` int(11) DEFAULT NULL,
  `total_credit` int(10) DEFAULT NULL,
  `total_balance` int(10) DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funding_reports`
--

LOCK TABLES `funding_reports` WRITE;
/*!40000 ALTER TABLE `funding_reports` DISABLE KEYS */;
INSERT INTO `funding_reports` VALUES (1,'published',2,'2019-02-24 07:28:16',111111,'תאריך מ..עד ‎01/01/1980  >> 31/12/2029',36573,1656573,1620000,'2019-01-01');
/*!40000 ALTER TABLE `funding_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_info`
--

DROP TABLE IF EXISTS `group_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_info` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `phone` bigint(11) unsigned DEFAULT NULL COMMENT 'Phone on contacts screen',
  `email` varchar(255) DEFAULT NULL,
  `photo_1` int(10) unsigned DEFAULT NULL,
  `photo_2` int(10) unsigned DEFAULT NULL,
  `photo_3` int(10) unsigned DEFAULT NULL,
  `photo_4` int(10) unsigned DEFAULT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_info`
--

LOCK TABLES `group_info` WRITE;
/*!40000 ALTER TABLE `group_info` DISABLE KEYS */;
INSERT INTO `group_info` VALUES (1,'published',1,'2019-01-24 00:33:09',1,'2019-01-24 00:43:35',972737145300,'bdo@bdo.co.il',6,9,8,10,'אחיסמך');
/*!40000 ALTER TABLE `group_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imports`
--

DROP TABLE IF EXISTS `imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `excel_file` int(10) unsigned DEFAULT NULL,
  `import_target` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items_created` int(11) unsigned DEFAULT NULL,
  `items_rejected` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imports`
--

LOCK TABLES `imports` WRITE;
/*!40000 ALTER TABLE `imports` DISABLE KEYS */;
/*!40000 ALTER TABLE `imports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `to` int(10) DEFAULT NULL,
  `message` text,
  `attachment_1` int(10) unsigned DEFAULT NULL,
  `attachment_2` int(10) unsigned DEFAULT NULL,
  `attachment_3` int(10) unsigned DEFAULT NULL,
  `read_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'published','2019-01-23 09:32:07','Welcome to BDO realestate',2,'Login is your email.\n\nPassword: `password`\n\n[Profile link](http://)',9,NULL,10,'2019-03-09 10:00:23',2),(2,'published','2019-02-24 08:33:22','new test',2,'Hi from developer',6,NULL,NULL,'2019-03-09 10:00:28',2);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `passport` varchar(200) DEFAULT NULL,
  `phone_1` bigint(19) unsigned DEFAULT NULL,
  `phone_2` bigint(11) unsigned DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `home_address` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer` (`customer`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,'published',2,'2019-01-24 00:25:50',1,'2019-02-24 05:06:24','50599448',NULL,NULL,2,NULL);
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receipts`
--

DROP TABLE IF EXISTS `receipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipts` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `contract_number` int(10) unsigned DEFAULT NULL,
  `request_amount` int(11) DEFAULT NULL,
  `request_description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `request_amount_2` int(11) DEFAULT NULL,
  `request_description_2` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_date_2` date DEFAULT NULL,
  `request_amount_3` int(10) DEFAULT NULL,
  `request_description_3` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_date_3` date DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receipts`
--

LOCK TABLES `receipts` WRITE;
/*!40000 ALTER TABLE `receipts` DISABLE KEYS */;
INSERT INTO `receipts` VALUES (1,'published',2,'2019-02-24 06:56:53',111111,50000,'השלמת הון עצמי לפני מימון','2015-03-08',30000,'השלמת הון עצמי לפני מימון','2015-02-19',100000,'השלמת הון עצמי לפני מימון','2015-01-10',180000,'2019-01-25');
/*!40000 ALTER TABLE `receipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `funding_report` int(10) unsigned DEFAULT NULL,
  `title` int(11) DEFAULT NULL,
  `move` int(11) DEFAULT NULL,
  `ration` int(10) DEFAULT NULL,
  `counter_account` int(10) DEFAULT NULL,
  `date_1` date DEFAULT NULL,
  `date_2` date DEFAULT NULL,
  `reference_1` int(11) DEFAULT NULL,
  `reference_2` int(10) DEFAULT NULL,
  `details` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit` int(11) DEFAULT NULL,
  `credit` int(10) DEFAULT NULL,
  `balance` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,'published',2,'2019-02-24 07:44:14',1,127,254,1,10001,'2013-06-18','2013-06-18',72,0,'אדלר משה יואב\'',NULL,450000,450000),(2,'published',2,'2019-02-24 07:46:21',1,547,1086,9999,10001,'2016-02-23','2016-02-23',NULL,15092,'העברה ישירה לבנק',NULL,70000,520000),(3,'published',2,'2019-02-24 07:48:11',1,791,1574,9997,20025,'2017-02-27','2017-02-27',60003,NULL,'עמלת טריא',36573,NULL,593300);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-30 23:24:35
