-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: imooc_singcms
-- ------------------------------------------------------
-- Server version	5.6.21-log

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
-- Table structure for table `cms_admin`
--

DROP TABLE IF EXISTS `cms_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_admin` (
  `admin_id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `lastloginip` varchar(15) DEFAULT '0',
  `lastlogintime` int(10) unsigned DEFAULT '0',
  `email` varchar(40) DEFAULT '',
  `realname` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`admin_id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_admin`
--

LOCK TABLES `cms_admin` WRITE;
/*!40000 ALTER TABLE `cms_admin` DISABLE KEYS */;
INSERT INTO `cms_admin` VALUES (1,'admin','d099d126030d3207ba102efa8e60630a','0',1460907997,'tracywxh0830@126.com','singwa',1),(2,'singwa','a8ea3a23aa715c8772dd5b4a981ba6f4','0',1458139801,'','',-1);
/*!40000 ALTER TABLE `cms_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_menu`
--

DROP TABLE IF EXISTS `cms_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_menu` (
  `menu_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `parentid` smallint(6) NOT NULL DEFAULT '0',
  `m` varchar(20) NOT NULL DEFAULT '',
  `c` varchar(20) NOT NULL DEFAULT '',
  `f` varchar(20) NOT NULL DEFAULT '',
  `data` varchar(100) NOT NULL DEFAULT '',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`),
  KEY `listorder` (`listorder`),
  KEY `parentid` (`parentid`),
  KEY `module` (`m`,`c`,`f`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_menu`
--

LOCK TABLES `cms_menu` WRITE;
/*!40000 ALTER TABLE `cms_menu` DISABLE KEYS */;
INSERT INTO `cms_menu` VALUES (1,'菜单管理',0,'admin','menu','index','',4,1,1),(2,'文章管理',0,'admin','Content','index','',0,-1,1),(3,'体育',0,'home','cat','index','',2,1,0),(4,'科技',0,'home','cat ','index','',0,-1,0),(5,'汽车',0,'home','cat','index','',0,-1,0),(6,'文章管理',0,'admin','content','index','',3,1,1),(7,'用户管理',0,'admin','user','index','',0,-1,1),(8,'科技',0,'home','cat','index','',0,1,0),(9,'推荐位管理',0,'admin','position','index','',2,1,1),(10,'推荐位内容管理',0,'admin','positioncontent','index','',1,1,1),(11,'基本管理',0,'admin','basic','index','',0,1,1),(12,'新闻',0,'home','cat','index','',0,1,0),(13,'用户管理',0,'admin','admin','index','',0,1,1);
/*!40000 ALTER TABLE `cms_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_news`
--

DROP TABLE IF EXISTS `cms_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_news` (
  `news_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(80) NOT NULL DEFAULT '',
  `small_title` varchar(30) NOT NULL DEFAULT '',
  `title_font_color` varchar(250) DEFAULT NULL COMMENT '������ɫ',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL COMMENT '��������',
  `posids` varchar(250) NOT NULL DEFAULT '',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `copyfrom` varchar(250) DEFAULT NULL COMMENT '��Դ',
  `username` char(20) NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`),
  KEY `status` (`status`),
  KEY `listorder` (`listorder`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_news`
--

LOCK TABLES `cms_news` WRITE;
/*!40000 ALTER TABLE `cms_news` DISABLE KEYS */;
INSERT INTO `cms_news` VALUES (17,3,'test','test','#5674ed','/upload/2016/07/28/57995e1074ca7.png','sss','sss','',1,1,'0','admin',1455756856,0,1),(18,3,'bb','1','#ed568b','/upload/2016/07/28/57995e2dafc41.jpg','关键字aa','1','',2,1,'3','admin',1455756999,0,1),(19,8,'1','11','#5674ed','/upload/2016/02/28/56d312b12ccec.png','1','1','',0,1,'0','admin',1456673467,0,1),(20,3,'aa','11','','/upload/2016/07/28/57995d7649122.jpg','1','简短的描述','',3,1,'0','admin',1456674909,0,1),(21,3,'ϰ','新闻aaa','','/upload/2016/03/13/56e519a185c93.png','关键字~','简短的描述','',0,1,'1','admin',1457854896,0,76),(22,12,'tests','新闻bbb','','/upload/2016/03/13/56e51b6ac8ce2.jpg','关键字','简短的一点描述','',0,1,'0','admin',1457855362,0,38),(23,3,'test2','111','#5674ed','/upload/2016/07/21/579055539c891.jpg','22','1','',12,1,'0','admin',1457855680,0,32),(24,3,'test3','新闻ccc','','/upload/2016/03/13/56e51fc82b13a.png','关键字','简短的一点描述','',1,1,'0','admin',1457856460,0,27),(34,3,'你好呀','h','#5674ed','/upload/2016/07/19/578de62852210.gif','22','11','',0,1,'0','admin',1468917300,0,1),(32,8,'11as','22','#5674ed','/upload/2016/07/12/57845a6b7e301.gif','关键字','简短的一点描述','',1,1,'0','admin',1468293252,0,2),(33,3,'aa','11','#5674ed','/upload/2016/07/28/57995da0db134.jpg','1','简短的一点描述','',2,1,'0','admin',1468293659,0,2),(35,3,'hihi~','11','#5674ed','/upload/2016/07/28/57995df622bc9.jpg','2','1','',0,1,'0','admin',1468918140,0,2),(36,12,'aa','1','#ed568b','/upload/2016/07/28/57995d64eaecc.jpg','1','1','',0,1,'0','',1469668712,0,10);
/*!40000 ALTER TABLE `cms_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_news_content`
--

DROP TABLE IF EXISTS `cms_news_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_news_content` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` mediumint(8) unsigned NOT NULL,
  `content` mediumtext NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_news_content`
--

LOCK TABLES `cms_news_content` WRITE;
/*!40000 ALTER TABLE `cms_news_content` DISABLE KEYS */;
INSERT INTO `cms_news_content` VALUES (7,17,'&lt;p&gt;\r\ngsdggsgsgsgsg\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\nsgsg\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\ngsdgsg?\r\n&lt;/p&gt;\r\n&lt;p style=&quot;text-align:center;&quot;&gt;\r\n? ? ? ?ggg\r\n&lt;/p&gt;',1455756856,0),(8,18,'........3412532454543我好你好好啊好.......&lt;p&gt;	&lt;br /&gt;&lt;/p&gt;',1455756999,0),(9,19,'111',1456673467,0),(10,20,'111',1456674909,0),(11,21,'&lt;p&gt;\r\n	&lt;span style=&quot;font-family:\'Microsoft YaHei\', u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53;font-size:16px;line-height:32px;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; 3哈哈哈哈1111111111111323144321&lt;img src=&quot;/upload/2016/07/28/5799bfd00f883.gif&quot; alt=&quot;&quot; /&gt;&lt;/span&gt;\r\n&lt;/p&gt;',1457854896,0),(12,22,'&lt;p style=&quot;font-size:16px;font-family:\'Microsoft YaHei\', u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53;&quot;&gt;\r\n&amp;nbsp; &amp;nbsp; \"',1457855362,0),(13,23,'&lt;p&gt;\r\n	&lt;br /&gt;\r\n&lt;/p&gt;',1457855680,0),(14,24,'<p>\r\n<br />\r\n</p>\r\n<p>\r\n',1457856460,0),(15,32,'&lt;p&gt;\r\n	122111111111111111\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	retwtrewtsgddgds\r\n&lt;/p&gt;\r\n&lt;p style=&quot;text-align:center;&quot;&gt;\r\n	hdfgdhfgrwe\r\n&lt;/p&gt;',1468293252,0),(16,33,'2131414asdsd',1468293659,0),(17,34,'哈哈哈哈哈',1468917300,0),(18,35,'122222222222222222',1468918140,0),(19,36,'1111111111111111111111',1469668712,0);
/*!40000 ALTER TABLE `cms_news_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_position`
--

DROP TABLE IF EXISTS `cms_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_position` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `description` char(100) DEFAULT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_position`
--

LOCK TABLES `cms_position` WRITE;
/*!40000 ALTER TABLE `cms_position` DISABLE KEYS */;
INSERT INTO `cms_position` VALUES (1,'首页大图',1,'这是描述',1455634352,1469251373),(2,'小图推荐',1,'չʾ',1455634715,0),(3,'Сͼ',-1,'Сͼ',1456665873,0),(4,'dd',-1,'',1457248469,0),(5,'右侧广告位',1,'',1457873143,0);
/*!40000 ALTER TABLE `cms_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_position_content`
--

DROP TABLE IF EXISTS `cms_position_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_position_content` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `position_id` int(5) unsigned NOT NULL,
  `title` varchar(30) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(100) DEFAULT NULL,
  `news_id` mediumint(8) unsigned NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_position_content`
--

LOCK TABLES `cms_position_content` WRITE;
/*!40000 ALTER TABLE `cms_position_content` DISABLE KEYS */;
INSERT INTO `cms_position_content` VALUES (28,2,'ϰ','/upload/2016/03/13/56e519a185c93.png',NULL,21,0,1,1457854896,0),(27,2,'','/upload/2016/03/07/56dcc0158f70e.JPG','',18,0,-1,1457306930,0),(26,2,'ss','/upload/2016/03/07/56dcbce02cab9.JPG','http://sina.com.cn',0,0,-1,1457306890,0),(25,3,'test','/upload/2016/03/06/56dbdc0c483af.JPG',NULL,17,0,-1,1455756856,0),(23,2,'test','/upload/2016/03/06/56dbdc0c483af.JPG',NULL,17,1,-1,1455756856,0),(24,2,'','/upload/2016/03/06/56dbdc015e662.JPG',NULL,18,2,-1,1455756999,0),(29,3,'','/upload/2016/03/13/56e51b6ac8ce2.jpg',NULL,22,12,1,1457855362,0),(30,3,'','/upload/2016/03/13/56e51cbd34470.png',NULL,23,0,1,1457855680,0),(31,3,'','/upload/2016/03/13/56e51fc82b13a.png',NULL,24,0,1,1457856460,0),(32,5,'2015','/upload/2016/03/13/56e5612d525c3.png','http://sports.sina.com.cn/laureus/moment2015/',0,0,1,1457873220,0),(33,5,'singwa','/upload/2016/03/13/56e56211c68e7.jpg','http://t.imooc.com/space/teacher/id/255838',0,0,1,1457873435,0),(34,2,'ϰ','/upload/2016/03/13/56e519a185c93.png',NULL,21,0,1,1457854896,0),(35,2,'','/upload/2016/03/13/56e51fc82b13a.png',NULL,24,0,1,1457856460,0),(36,1,'test2','/upload/2016/07/21/579055539c891.jpg',NULL,23,0,1,1457855680,0),(37,1,'test3','/upload/2016/03/13/56e51fc82b13a.png',NULL,24,0,1,1457856460,0),(38,1,'11as','/upload/2016/07/12/57845a6b7e301.gif',NULL,32,0,1,1468293252,0),(39,1,'aa','/upload/2016/07/12/5784620da2b00.jpg',NULL,33,0,1,1468293659,0),(40,2,'aa','/upload/2016/02/28/56d3185781237.png',NULL,20,0,1,1456674909,0),(41,2,'ϰ','/upload/2016/03/13/56e519a185c93.png',NULL,21,0,1,1457854896,0),(42,1,'ss','/upload/2016/07/26/57971be97c11e.jpg','http://sina.com.cn',0,0,1,0,0),(43,1,'文章33测试','/upload/2016/07/12/5784620da2b00.jpg','',33,5,1,0,0),(44,1,'aaanan','/upload/2016/07/26/57972749cc6ff.jpg','http://www.w3.com',0,0,-1,0,0),(45,1,'bbnn','/upload/2016/07/26/579731b2eec76.gif','http://www.yahoo.com',0,4,1,0,0);
/*!40000 ALTER TABLE `cms_position_content` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-02 15:57:53
