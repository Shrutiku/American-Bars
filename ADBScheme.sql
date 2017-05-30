-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: adb.cra57zqpaph8.us-east-1.rds.amazonaws.com    Database: ADB
-- ------------------------------------------------------
-- Server version	5.6.27-log

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
-- Table structure for table `sss_Color`
--

DROP TABLE IF EXISTS `sss_Color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_Color` (
  `Color_id` int(11) NOT NULL AUTO_INCREMENT,
  `color_name` varchar(25) NOT NULL,
  `color_image` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`Color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_Size`
--

DROP TABLE IF EXISTS `sss_Size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_Size` (
  `Size_id` int(11) NOT NULL AUTO_INCREMENT,
  `size_name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`Size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_admin`
--

DROP TABLE IF EXISTS `sss_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `admin_type` int(10) NOT NULL DEFAULT '2',
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `active` enum('Active','Inactive') DEFAULT 'Active',
  `date_added` date NOT NULL,
  `login_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_admin_login`
--

DROP TABLE IF EXISTS `sss_admin_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_admin_login` (
  `login_id` int(100) NOT NULL AUTO_INCREMENT,
  `admin_id` int(100) NOT NULL,
  `login_ip` varchar(255) DEFAULT NULL,
  `login_date` datetime NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3882 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_advertisement_master`
--

DROP TABLE IF EXISTS `sss_advertisement_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_advertisement_master` (
  `advertisement_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_zip` varchar(255) NOT NULL,
  `s_type` enum('city','zipcode','','') NOT NULL DEFAULT 'city',
  `advertisement_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `advertisement_image` varchar(255) NOT NULL,
  `size` varchar(55) NOT NULL,
  `number_click` int(11) NOT NULL,
  `number_visit` int(11) NOT NULL,
  `position` varchar(55) NOT NULL,
  `client_id` int(11) NOT NULL,
  `pages` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` enum('click','visit','','') NOT NULL DEFAULT 'click',
  `total_click` int(11) NOT NULL,
  `total_visit` int(11) NOT NULL,
  PRIMARY KEY (`advertisement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_album`
--

DROP TABLE IF EXISTS `sss_album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_album` (
  `bar_gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_added` datetime NOT NULL,
  `gallery` enum('postcard','gallery','','') NOT NULL DEFAULT 'gallery',
  `status` enum('Active','Inactive') NOT NULL,
  `reorder` int(11) DEFAULT '1',
  PRIMARY KEY (`bar_gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_album_images`
--

DROP TABLE IF EXISTS `sss_album_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_album_images` (
  `bar_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_gallery_id` int(11) NOT NULL,
  `bar_image_name` varchar(255) NOT NULL,
  `image_title` varchar(255) NOT NULL,
  PRIMARY KEY (`bar_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_all_likes`
--

DROP TABLE IF EXISTS `sss_all_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_all_likes` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `beer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `beer_comment_id` int(11) NOT NULL,
  `cocktail_id` int(11) NOT NULL,
  `cocktail_comment_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `like_flag` tinyint(4) NOT NULL,
  `fav_flag` int(11) NOT NULL DEFAULT '0',
  `beer_fav_flag` int(11) NOT NULL DEFAULT '0',
  `bar_fav_flag` int(11) NOT NULL DEFAULT '0',
  `bar_id` int(11) NOT NULL,
  `liquor_id` int(11) NOT NULL,
  `liquor_comment_id` int(11) NOT NULL,
  PRIMARY KEY (`like_id`),
  KEY `beer_id` (`beer_id`),
  KEY `user_id` (`user_id`),
  KEY `like_flag` (`like_flag`)
) ENGINE=InnoDB AUTO_INCREMENT=727 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_android_stored_notification`
--

DROP TABLE IF EXISTS `sss_android_stored_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_android_stored_notification` (
  `android_stored_notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `notification` text NOT NULL,
  PRIMARY KEY (`android_stored_notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_banner_pages`
--

DROP TABLE IF EXISTS `sss_banner_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_banner_pages` (
  `banner_pages_id` int(11) NOT NULL AUTO_INCREMENT,
  `find_trivia_app_state` varchar(255) NOT NULL,
  `find_trivia_app` varchar(255) NOT NULL,
  `find_bar` varchar(255) NOT NULL,
  `beer_directory` varchar(255) NOT NULL,
  `cocktail_directory` varchar(255) NOT NULL,
  `suggest_bar` varchar(255) NOT NULL,
  `contact_us` varchar(255) NOT NULL,
  `photo_gallery` varchar(255) NOT NULL,
  `media` varchar(255) NOT NULL,
  `forum` varchar(255) NOT NULL,
  `liqur_directory` varchar(255) NOT NULL,
  `taxi_directory` varchar(255) NOT NULL,
  `resource_directory` varchar(255) NOT NULL DEFAULT 'dsd',
  `find_trivia_state` int(1) NOT NULL DEFAULT '0',
  `trivia` varchar(100) NOT NULL,
  `find_bar_state` int(1) NOT NULL DEFAULT '0',
  `beer_directory_state` int(1) NOT NULL DEFAULT '0',
  `cocktail_directory_state` int(1) NOT NULL DEFAULT '0',
  `suggest_bar_state` int(1) NOT NULL DEFAULT '0',
  `contact_us_state` int(1) NOT NULL DEFAULT '0',
  `photo_gallery_state` int(1) NOT NULL DEFAULT '0',
  `media_state` int(1) NOT NULL DEFAULT '0',
  `forum_state` int(1) NOT NULL DEFAULT '0',
  `liqur_directory_state` int(1) NOT NULL DEFAULT '0',
  `taxi_directory_state` int(1) NOT NULL DEFAULT '0',
  `resource_directory_state` int(1) NOT NULL DEFAULT '0',
  `article` varchar(100) NOT NULL,
  `find_article_state` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`banner_pages_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_banner_pages_master`
--

DROP TABLE IF EXISTS `sss_banner_pages_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_banner_pages_master` (
  `banner_pages_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_zip` varchar(255) NOT NULL,
  `s_type` enum('city','zipcode','','') NOT NULL DEFAULT 'city',
  `banner_pages_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `banner_pages_image` varchar(255) NOT NULL,
  `size` varchar(55) NOT NULL,
  `number_click` int(11) NOT NULL,
  `number_visit` int(11) NOT NULL,
  `position` varchar(55) NOT NULL,
  `client_id` int(11) NOT NULL,
  `pages` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` enum('click','visit','','') NOT NULL DEFAULT 'click',
  `total_click` int(11) NOT NULL,
  `total_visit` int(11) NOT NULL,
  PRIMARY KEY (`banner_pages_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_category`
--

DROP TABLE IF EXISTS `sss_bar_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_category` (
  `bar_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_category_name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_added` datetime NOT NULL,
  `module_type` enum('Bar','Event') NOT NULL DEFAULT 'Bar',
  PRIMARY KEY (`bar_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_classified`
--

DROP TABLE IF EXISTS `sss_bar_classified`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_classified` (
  `classified_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(555) NOT NULL,
  `answer` text NOT NULL,
  `classified_category` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`classified_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_comment`
--

DROP TABLE IF EXISTS `sss_bar_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_comment` (
  `bar_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_title` varchar(900) NOT NULL,
  `comment` text NOT NULL,
  `bar_rating` tinyint(4) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL DEFAULT 'no',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`bar_comment_id`),
  KEY `bar_id` (`bar_id`),
  KEY `user_id` (`user_id`),
  KEY `bar_id_2` (`bar_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_features`
--

DROP TABLE IF EXISTS `sss_bar_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_features` (
  `bar_feature_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_id` int(11) NOT NULL,
  `feature_id` varchar(255) NOT NULL,
  PRIMARY KEY (`bar_feature_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_gallery`
--

DROP TABLE IF EXISTS `sss_bar_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_gallery` (
  `bar_gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_added` datetime NOT NULL,
  `gallery` enum('postcard','gallery','','') NOT NULL DEFAULT 'gallery',
  `status` enum('Active','Inactive') NOT NULL,
  `reorder` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bar_gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_hours`
--

DROP TABLE IF EXISTS `sss_bar_hours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_hours` (
  `hours_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `days_id` int(11) NOT NULL,
  `start_from` time DEFAULT NULL,
  `start_to` time DEFAULT NULL,
  `is_closed` enum('yes','no') NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`hours_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1401 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_images`
--

DROP TABLE IF EXISTS `sss_bar_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_images` (
  `bar_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_gallery_id` int(11) NOT NULL,
  `bar_image_name` varchar(255) NOT NULL,
  `image_title` varchar(255) NOT NULL,
  `image_link` varchar(255) NOT NULL,
  PRIMARY KEY (`bar_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=820 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_payment_setting`
--

DROP TABLE IF EXISTS `sss_bar_payment_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_payment_setting` (
  `paypal_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_status` varchar(100) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `vendor` varchar(255) NOT NULL,
  `paypal_username` varchar(255) NOT NULL,
  `paypal_password` varchar(255) NOT NULL,
  PRIMARY KEY (`paypal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_post_card`
--

DROP TABLE IF EXISTS `sss_bar_post_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_post_card` (
  `postcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(512) NOT NULL,
  `post_message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `card_type` enum('half_mug','full_mug') NOT NULL,
  `status` enum('active','inactive','pending','deliver') NOT NULL,
  `is_delete` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`postcard_id`),
  KEY `user_id` (`user_id`),
  KEY `bar_id` (`bar_id`),
  KEY `bar_id_2` (`bar_id`),
  KEY `is_delete` (`is_delete`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_special_hours`
--

DROP TABLE IF EXISTS `sss_bar_special_hours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_special_hours` (
  `bar_hour_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_beer_id` int(11) NOT NULL,
  `sp_beer_price` varchar(255) NOT NULL,
  `sp_cocktail_id` int(11) NOT NULL,
  `sp_cocktail_price` varchar(255) NOT NULL,
  `sp_liquor_id` int(11) NOT NULL,
  `sp_liquor_price` varchar(255) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `food_price` varchar(255) NOT NULL,
  `other_name` varchar(255) NOT NULL,
  `other_price` varchar(255) NOT NULL,
  `day` int(1) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `days` varchar(255) NOT NULL,
  `hour_from` varchar(255) NOT NULL,
  `hour_to` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `speciality` varchar(255) NOT NULL,
  `rand` varchar(255) NOT NULL,
  `cat` varchar(255) NOT NULL,
  PRIMARY KEY (`bar_hour_id`)
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_special_hours_old`
--

DROP TABLE IF EXISTS `sss_bar_special_hours_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_special_hours_old` (
  `bar_hour_id` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(1) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `days` varchar(255) NOT NULL,
  `hour_from` varchar(255) NOT NULL,
  `hour_to` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `speciality` varchar(255) NOT NULL,
  PRIMARY KEY (`bar_hour_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_statistic`
--

DROP TABLE IF EXISTS `sss_bar_statistic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_statistic` (
  `bar_statistic_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `category` varchar(55) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`bar_statistic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bar_term`
--

DROP TABLE IF EXISTS `sss_bar_term`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bar_term` (
  `term_id` int(11) NOT NULL AUTO_INCREMENT,
  `term_title` varchar(55) NOT NULL,
  `description` varchar(255) NOT NULL,
  `term_usage` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bars`
--

DROP TABLE IF EXISTS `sss_bars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bars` (
  `bar_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_title` varchar(550) NOT NULL,
  `bar_first_name` varchar(255) NOT NULL,
  `bar_last_name` varchar(255) NOT NULL,
  `bar_desc` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_type` varchar(255) NOT NULL,
  `owner_name` varchar(512) NOT NULL,
  `address` varchar(555) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `bar_type` enum('half_mug','full_mug','unclaimed') NOT NULL,
  `website` varchar(255) NOT NULL,
  `bar_logo` varchar(255) NOT NULL,
  `bar_banner` varchar(255) NOT NULL,
  `bar_video` varchar(512) NOT NULL,
  `bar_video_link` varchar(512) NOT NULL,
  `is_claimed` tinyint(4) NOT NULL,
  `status` enum('active','inactive','archived') NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `facebook_link` varchar(255) NOT NULL,
  `twitter_link` varchar(255) NOT NULL,
  `linkedin_link` varchar(255) NOT NULL,
  `google_plus_link` varchar(255) NOT NULL,
  `dribble_link` varchar(255) NOT NULL,
  `pinterest_link` varchar(255) NOT NULL,
  `bar_video_file` varchar(255) NOT NULL,
  `bar_slug` varchar(255) NOT NULL,
  `bar_meta_title` varchar(255) NOT NULL,
  `bar_meta_keyword` varchar(255) NOT NULL,
  `bar_meta_description` varchar(255) NOT NULL,
  `serve_as` enum('cocktail','liquor','','') NOT NULL DEFAULT 'cocktail',
  `suggest_by_user_id` int(11) NOT NULL DEFAULT '0',
  `cap_logo` varchar(255) NOT NULL,
  `tshirt_logo` varchar(255) NOT NULL,
  `prcap` enum('enable','disable','','') NOT NULL DEFAULT 'disable',
  `prtshirt` enum('enable','disable','','') NOT NULL DEFAULT 'disable',
  `cash_p` enum('0','1') NOT NULL DEFAULT '0',
  `master_p` enum('0','1') NOT NULL DEFAULT '0',
  `american_p` enum('0','1') NOT NULL DEFAULT '0',
  `visa_p` enum('0','1') NOT NULL DEFAULT '0',
  `paypal_p` enum('0','1') NOT NULL DEFAULT '0',
  `bitcoin_p` enum('0','1') NOT NULL DEFAULT '0',
  `apple_p` enum('0','1') NOT NULL DEFAULT '0',
  `lat` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `gt` enum('0','1') NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL,
  `claim` enum('claimed','unclaimed') NOT NULL DEFAULT 'unclaimed',
  `instagram_link` varchar(255) NOT NULL,
  `bar_category` varchar(255) NOT NULL,
  `is_managed` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`bar_id`),
  KEY `bar_id` (`bar_id`),
  KEY `bar_title` (`bar_title`(255))
) ENGINE=InnoDB AUTO_INCREMENT=68879 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bars_lat`
--

DROP TABLE IF EXISTS `sss_bars_lat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bars_lat` (
  `bar_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_title` varchar(550) NOT NULL,
  `bar_first_name` varchar(255) NOT NULL,
  `bar_last_name` varchar(255) NOT NULL,
  `bar_desc` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_type` varchar(255) NOT NULL,
  `owner_name` varchar(512) NOT NULL,
  `address` varchar(555) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `bar_type` enum('half_mug','full_mug','unclaimed') NOT NULL,
  `website` varchar(255) NOT NULL,
  `bar_logo` varchar(255) NOT NULL,
  `bar_banner` varchar(255) NOT NULL,
  `bar_video` varchar(512) NOT NULL,
  `bar_video_link` varchar(512) NOT NULL,
  `is_claimed` tinyint(4) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `facebook_link` varchar(255) NOT NULL,
  `twitter_link` varchar(255) NOT NULL,
  `linkedin_link` varchar(255) NOT NULL,
  `google_plus_link` varchar(255) NOT NULL,
  `dribble_link` varchar(255) NOT NULL,
  `pinterest_link` varchar(255) NOT NULL,
  `bar_video_file` varchar(255) NOT NULL,
  `bar_slug` varchar(255) NOT NULL,
  `bar_meta_title` varchar(255) NOT NULL,
  `bar_meta_keyword` varchar(255) NOT NULL,
  `bar_meta_description` varchar(255) NOT NULL,
  `serve_as` enum('cocktail','liquor','','') NOT NULL DEFAULT 'cocktail',
  `suggest_by_user_id` int(11) NOT NULL DEFAULT '0',
  `cap_logo` varchar(255) NOT NULL,
  `tshirt_logo` varchar(255) NOT NULL,
  `prcap` enum('enable','disable','','') NOT NULL DEFAULT 'enable',
  `prtshirt` enum('enable','disable','','') NOT NULL DEFAULT 'enable',
  `cash_p` enum('0','1') NOT NULL DEFAULT '0',
  `master_p` enum('0','1') NOT NULL DEFAULT '0',
  `american_p` enum('0','1') NOT NULL DEFAULT '0',
  `visa_p` enum('0','1') NOT NULL DEFAULT '0',
  `paypal_p` enum('0','1') NOT NULL DEFAULT '0',
  `bitcoin_p` enum('0','1') NOT NULL DEFAULT '0',
  `apple_p` enum('0','1') NOT NULL DEFAULT '0',
  `lat` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `gt` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`bar_id`),
  KEY `bar_id` (`bar_id`),
  KEY `bar_title` (`bar_title`(255))
) ENGINE=InnoDB AUTO_INCREMENT=62417 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_bars_or`
--

DROP TABLE IF EXISTS `sss_bars_or`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_bars_or` (
  `bar_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_title` varchar(550) NOT NULL,
  `bar_first_name` varchar(255) NOT NULL,
  `bar_last_name` varchar(255) NOT NULL,
  `bar_desc` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_type` varchar(255) NOT NULL,
  `owner_name` varchar(512) NOT NULL,
  `address` varchar(555) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `bar_type` enum('half_mug','full_mug','unclaimed') NOT NULL,
  `website` varchar(255) NOT NULL,
  `bar_logo` varchar(255) NOT NULL,
  `bar_banner` varchar(255) NOT NULL,
  `bar_video` varchar(512) NOT NULL,
  `bar_video_link` varchar(512) NOT NULL,
  `is_claimed` tinyint(4) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `facebook_link` varchar(255) NOT NULL,
  `twitter_link` varchar(255) NOT NULL,
  `linkedin_link` varchar(255) NOT NULL,
  `google_plus_link` varchar(255) NOT NULL,
  `dribble_link` varchar(255) NOT NULL,
  `pinterest_link` varchar(255) NOT NULL,
  `bar_video_file` varchar(255) NOT NULL,
  `bar_slug` varchar(255) NOT NULL,
  `bar_meta_title` varchar(255) NOT NULL,
  `bar_meta_keyword` varchar(255) NOT NULL,
  `bar_meta_description` varchar(255) NOT NULL,
  `serve_as` enum('cocktail','liquor','','') NOT NULL DEFAULT 'cocktail',
  `suggest_by_user_id` int(11) NOT NULL DEFAULT '0',
  `cap_logo` varchar(255) NOT NULL,
  `tshirt_logo` varchar(255) NOT NULL,
  `prcap` enum('enable','disable','','') NOT NULL DEFAULT 'enable',
  `prtshirt` enum('enable','disable','','') NOT NULL DEFAULT 'enable',
  `cash_p` enum('0','1') NOT NULL DEFAULT '0',
  `master_p` enum('0','1') NOT NULL DEFAULT '0',
  `american_p` enum('0','1') NOT NULL DEFAULT '0',
  `visa_p` enum('0','1') NOT NULL DEFAULT '0',
  `paypal_p` enum('0','1') NOT NULL DEFAULT '0',
  `bitcoin_p` enum('0','1') NOT NULL DEFAULT '0',
  `apple_p` enum('0','1') NOT NULL DEFAULT '0',
  `lat` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `gt` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`bar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62295 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_beer_bars`
--

DROP TABLE IF EXISTS `sss_beer_bars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_beer_bars` (
  `beer_bar_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_id` int(11) NOT NULL,
  `beer_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `tap` enum('yes','no','','') NOT NULL DEFAULT 'no',
  `bottle` enum('yes','no','','') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`beer_bar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_beer_comment`
--

DROP TABLE IF EXISTS `sss_beer_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_beer_comment` (
  `beer_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `beer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_title` varchar(500) NOT NULL,
  `comment` text NOT NULL,
  `comment_image` varchar(255) NOT NULL,
  `comment_video` varchar(255) NOT NULL,
  `beer_rating` tinyint(4) NOT NULL,
  `master_comment_id` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` tinyint(2) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`beer_comment_id`),
  KEY `beer_id` (`beer_id`),
  KEY `user_id` (`user_id`),
  KEY `beer_id_2` (`beer_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_beer_directory`
--

DROP TABLE IF EXISTS `sss_beer_directory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_beer_directory` (
  `beer_id` int(11) NOT NULL AUTO_INCREMENT,
  `beer_name` varchar(500) NOT NULL,
  `beer_type` varchar(255) NOT NULL,
  `producer` varchar(555) NOT NULL,
  `city_produced` varchar(255) NOT NULL,
  `beer_desc` text NOT NULL,
  `beer_image` varchar(255) NOT NULL,
  `beer_website` varchar(555) NOT NULL,
  `abv` varchar(255) NOT NULL,
  `status` enum('active','inactive','pending','archived') NOT NULL,
  `bar_id` int(11) NOT NULL,
  `is_suggested` tinyint(4) NOT NULL,
  `is_deleted` enum('yes','no') NOT NULL DEFAULT 'no',
  `total_likes` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `beer_slug` varchar(255) NOT NULL,
  `beer_meta_title` varchar(255) NOT NULL,
  `beer_meta_keyword` varchar(255) NOT NULL,
  `beer_meta_description` varchar(255) NOT NULL,
  `states` enum('read','unread','','') NOT NULL DEFAULT 'unread',
  `beer_state` varchar(255) NOT NULL,
  `beer_address` varchar(255) NOT NULL,
  `beer_country` varchar(255) NOT NULL,
  `beer_zipcode` varchar(255) NOT NULL,
  `beer_phone` varchar(255) NOT NULL,
  `upload_type` enum('video','image') NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `image_default` varchar(255) NOT NULL,
  PRIMARY KEY (`beer_id`),
  KEY `bar_id` (`bar_id`),
  KEY `beer_type` (`beer_type`),
  KEY `is_suggested` (`is_suggested`)
) ENGINE=InnoDB AUTO_INCREMENT=63994 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_beer_directory_o`
--

DROP TABLE IF EXISTS `sss_beer_directory_o`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_beer_directory_o` (
  `beer_id` int(11) NOT NULL AUTO_INCREMENT,
  `beer_name` varchar(500) NOT NULL,
  `beer_type` varchar(255) NOT NULL,
  `producer` varchar(555) NOT NULL,
  `city_produced` varchar(255) NOT NULL,
  `beer_desc` text NOT NULL,
  `beer_image` varchar(255) NOT NULL,
  `beer_website` varchar(555) NOT NULL,
  `abv` varchar(255) NOT NULL,
  `status` enum('active','inactive','pending') NOT NULL,
  `bar_id` int(11) NOT NULL,
  `is_suggested` tinyint(4) NOT NULL,
  `is_deleted` enum('yes','no') NOT NULL DEFAULT 'no',
  `total_likes` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `beer_slug` varchar(255) NOT NULL,
  `beer_meta_title` varchar(255) NOT NULL,
  `beer_meta_keyword` varchar(255) NOT NULL,
  `beer_meta_description` varchar(255) NOT NULL,
  `states` enum('read','unread','','') NOT NULL DEFAULT 'unread',
  `beer_state` varchar(255) NOT NULL,
  `beer_address` varchar(255) NOT NULL,
  `beer_country` varchar(255) NOT NULL,
  `beer_zipcode` varchar(255) NOT NULL,
  `beer_phone` varchar(255) NOT NULL,
  `upload_type` enum('video','image') NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `image_default` varchar(255) NOT NULL,
  PRIMARY KEY (`beer_id`),
  KEY `bar_id` (`bar_id`),
  KEY `beer_type` (`beer_type`),
  KEY `is_suggested` (`is_suggested`)
) ENGINE=InnoDB AUTO_INCREMENT=64003 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_beer_directory_suggest`
--

DROP TABLE IF EXISTS `sss_beer_directory_suggest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_beer_directory_suggest` (
  `beer_id` int(11) NOT NULL AUTO_INCREMENT,
  `beer_name` varchar(255) NOT NULL,
  `beer_type` varchar(255) NOT NULL,
  `producer` varchar(555) NOT NULL,
  `city_produced` varchar(255) NOT NULL,
  `beer_desc` text NOT NULL,
  `beer_image` varchar(255) NOT NULL,
  `beer_website` varchar(555) NOT NULL,
  `abv` varchar(255) NOT NULL,
  `status` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `bar_id` int(11) NOT NULL,
  `is_suggested` tinyint(4) NOT NULL,
  `is_deleted` enum('yes','no') NOT NULL DEFAULT 'no',
  `total_likes` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `beer_slug` varchar(255) NOT NULL,
  PRIMARY KEY (`beer_id`),
  KEY `bar_id` (`bar_id`),
  KEY `beer_name` (`beer_name`),
  KEY `beer_type` (`beer_type`),
  KEY `is_suggested` (`is_suggested`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_blog`
--

DROP TABLE IF EXISTS `sss_blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_blog` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_image` varchar(255) NOT NULL,
  `blog_description` text NOT NULL,
  `date_added` datetime NOT NULL,
  `master_id` int(11) NOT NULL,
  `blog_meta_title` varchar(255) NOT NULL,
  `blog_meta_keyword` varchar(255) NOT NULL,
  `blog_meta_description` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `path` varchar(255) NOT NULL DEFAULT 'https://americanbars.com/upload/blog_thumb/',
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`blog_id`),
  KEY `user_id` (`user_id`),
  KEY `master_id` (`master_id`)
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_blog_comment`
--

DROP TABLE IF EXISTS `sss_blog_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_blog_comment` (
  `blog_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `master_comment_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_title` varchar(900) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`blog_comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_blog_rating`
--

DROP TABLE IF EXISTS `sss_blog_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_blog_rating` (
  `blog_rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blog_rating` tinyint(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL,
  PRIMARY KEY (`blog_rating_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_broadcast_message`
--

DROP TABLE IF EXISTS `sss_broadcast_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_broadcast_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_type` varchar(255) NOT NULL,
  `from_user_type` varchar(255) NOT NULL,
  `master_message_id` int(11) NOT NULL,
  `subject` varchar(55) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(55) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `number` varchar(200) NOT NULL,
  `is_read` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_business_hours`
--

DROP TABLE IF EXISTS `sss_business_hours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_business_hours` (
  `hours_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `days_id` int(11) NOT NULL,
  `start_from` time DEFAULT NULL,
  `start_to` time DEFAULT NULL,
  `is_closed` enum('yes','no') NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`hours_id`)
) ENGINE=InnoDB AUTO_INCREMENT=414 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_category`
--

DROP TABLE IF EXISTS `sss_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `category_type` enum('video','blog','article') NOT NULL,
  `is_deleted` enum('y','n') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `category_type` (`category_type`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_ci_sessions`
--

DROP TABLE IF EXISTS `sss_ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_ci_sessions_front`
--

DROP TABLE IF EXISTS `sss_ci_sessions_front`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_ci_sessions_front` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_cocktail_bars`
--

DROP TABLE IF EXISTS `sss_cocktail_bars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_cocktail_bars` (
  `cocktail_bar_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_id` int(11) NOT NULL,
  `cocktail_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`cocktail_bar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_cocktail_comment`
--

DROP TABLE IF EXISTS `sss_cocktail_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_cocktail_comment` (
  `cocktail_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `cocktail_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_title` varchar(500) NOT NULL,
  `comment` text NOT NULL,
  `cocktail_rating` tinyint(4) NOT NULL,
  `master_comment_id` int(11) NOT NULL,
  `comment_video` varchar(255) NOT NULL,
  `comment_image` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` tinyint(2) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`cocktail_comment_id`),
  KEY `cocktail_id` (`cocktail_id`),
  KEY `user_id` (`user_id`),
  KEY `master_comment_id` (`master_comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_cocktail_directory`
--

DROP TABLE IF EXISTS `sss_cocktail_directory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_cocktail_directory` (
  `cocktail_id` int(11) NOT NULL AUTO_INCREMENT,
  `cocktail_name` varchar(255) NOT NULL,
  `glassware` varchar(255) NOT NULL,
  `ingredients` text NOT NULL,
  `how_to_make_it` text NOT NULL,
  `cocktail_image` varchar(255) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `is_suggested` tinyint(1) NOT NULL,
  `base_spirit` varchar(255) NOT NULL,
  `type` text NOT NULL,
  `served` text NOT NULL,
  `preparation` text NOT NULL,
  `strength` text NOT NULL,
  `difficulty` text NOT NULL,
  `flavor_profile` text NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL,
  `total_likes` int(11) NOT NULL,
  `status` enum('active','inactive','pending','archived') NOT NULL,
  `cocktail_slug` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `upload_type` enum('video','image','','') NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `image_default` varchar(255) NOT NULL,
  `cocktail_meta_title` varchar(255) NOT NULL,
  `cocktail_meta_keyword` varchar(255) NOT NULL,
  `cocktail_meta_description` varchar(255) NOT NULL,
  `states` enum('read','unread','','') NOT NULL DEFAULT 'unread',
  PRIMARY KEY (`cocktail_id`),
  KEY `bar_id` (`bar_id`),
  KEY `cocktail_name` (`cocktail_name`)
) ENGINE=InnoDB AUTO_INCREMENT=976 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_contact_inquiry`
--

DROP TABLE IF EXISTS `sss_contact_inquiry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_contact_inquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `ip` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_count_clcik_advertisement`
--

DROP TABLE IF EXISTS `sss_count_clcik_advertisement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_count_clcik_advertisement` (
  `click_advertisement_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `advertisement_id` int(11) NOT NULL,
  `click_type` enum('click','visit') NOT NULL,
  PRIMARY KEY (`click_advertisement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_count_clcik_advertisement_banner`
--

DROP TABLE IF EXISTS `sss_count_clcik_advertisement_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_count_clcik_advertisement_banner` (
  `click_advertisement_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `banner_pages_id` int(11) NOT NULL,
  `click_type` enum('click','visit') NOT NULL,
  PRIMARY KEY (`click_advertisement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_count_clcik_bar`
--

DROP TABLE IF EXISTS `sss_count_clcik_bar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_count_clcik_bar` (
  `click_bar_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `bar_id` int(11) NOT NULL,
  `impression` int(11) NOT NULL DEFAULT '0',
  `visit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`click_bar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71849 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_days`
--

DROP TABLE IF EXISTS `sss_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_days` (
  `days_id` int(11) NOT NULL AUTO_INCREMENT,
  `days` varchar(255) NOT NULL,
  PRIMARY KEY (`days_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_device_master`
--

DROP TABLE IF EXISTS `sss_device_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_device_master` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `latitude` float(10,7) NOT NULL,
  `longitude` float(10,7) NOT NULL,
  `device_name` varchar(255) NOT NULL,
  `unique_code` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`device_id`),
  KEY `user_id` (`user_id`,`device_name`,`unique_code`),
  KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1431 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_dictionary`
--

DROP TABLE IF EXISTS `sss_dictionary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_dictionary` (
  `dictionary_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `dictionary_title` varchar(255) NOT NULL,
  `dictionary_description` text NOT NULL,
  `date_added` datetime NOT NULL,
  `master_id` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`dictionary_id`),
  KEY `user_id` (`user_id`),
  KEY `master_id` (`master_id`)
) ENGINE=InnoDB AUTO_INCREMENT=474 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_divebar_findout`
--

DROP TABLE IF EXISTS `sss_divebar_findout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_divebar_findout` (
  `divebar_findout_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `divebar_findout_title` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `master_id` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`divebar_findout_id`),
  KEY `user_id` (`user_id`),
  KEY `master_id` (`master_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_divebar_findout_topic`
--

DROP TABLE IF EXISTS `sss_divebar_findout_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_divebar_findout_topic` (
  `divebar_findout_topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `divebar_findout_id` int(11) NOT NULL,
  `divebar_findout_description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`divebar_findout_topic_id`),
  KEY `user_id` (`divebar_findout_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_email_setting`
--

DROP TABLE IF EXISTS `sss_email_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_email_setting` (
  `email_setting_id` int(10) NOT NULL AUTO_INCREMENT,
  `mailer` varchar(50) DEFAULT NULL,
  `sendmail_path` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(50) DEFAULT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_email` varchar(255) DEFAULT NULL,
  `smtp_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`email_setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_email_template`
--

DROP TABLE IF EXISTS `sss_email_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_email_template` (
  `email_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(255) DEFAULT NULL,
  `from_address` varchar(255) DEFAULT NULL,
  `reply_address` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`email_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_event_attend`
--

DROP TABLE IF EXISTS `sss_event_attend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_event_attend` (
  `event_attend_id` int(11) NOT NULL AUTO_INCREMENT,
  `is_attend` enum('no','yes') NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`event_attend_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_event_category`
--

DROP TABLE IF EXISTS `sss_event_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_event_category` (
  `event_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_category_name` char(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_added` datetime NOT NULL,
  `module_type` enum('Bar','Event') NOT NULL DEFAULT 'Bar',
  PRIMARY KEY (`event_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_event_images`
--

DROP TABLE IF EXISTS `sss_event_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_event_images` (
  `event_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_eventgallery_id` int(11) NOT NULL,
  `event_image_name` varchar(255) NOT NULL,
  PRIMARY KEY (`event_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35083 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_event_images_test`
--

DROP TABLE IF EXISTS `sss_event_images_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_event_images_test` (
  `event_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_eventgallery_id` int(11) NOT NULL,
  `event_image_name` varchar(255) NOT NULL,
  PRIMARY KEY (`event_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4129 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_event_time`
--

DROP TABLE IF EXISTS `sss_event_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_event_time` (
  `sss_event_time_id` int(11) NOT NULL AUTO_INCREMENT,
  `eventdate` date NOT NULL,
  `eventstarttime` varchar(255) NOT NULL,
  `eventendtime` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`sss_event_time_id`)
) ENGINE=InnoDB AUTO_INCREMENT=508398 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_event_time_test`
--

DROP TABLE IF EXISTS `sss_event_time_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_event_time_test` (
  `sss_event_time_id` int(11) NOT NULL AUTO_INCREMENT,
  `eventdate` date NOT NULL,
  `eventstarttime` varchar(255) NOT NULL,
  `eventendtime` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`sss_event_time_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34075 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_events`
--

DROP TABLE IF EXISTS `sss_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(900) NOT NULL,
  `eid` varchar(255) NOT NULL,
  `event_desc` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `phone` varchar(34) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `event_video` varchar(255) NOT NULL,
  `event_video_link` varchar(500) NOT NULL,
  `is_power_boost_event` tinyint(4) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL,
  `date_added` datetime NOT NULL,
  `event_meta_title` varchar(255) NOT NULL,
  `event_meta_keyword` varchar(255) NOT NULL,
  `event_meta_description` text NOT NULL,
  `organizer` varchar(255) NOT NULL,
  `event_category` text NOT NULL,
  `admission` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `event_fb_link` varchar(255) NOT NULL,
  `event_twitter_link` varchar(255) NOT NULL,
  `event_google_plus_link` varchar(255) NOT NULL,
  `event_pinterest_link` varchar(255) NOT NULL,
  `event_upload_type` varchar(255) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `buy_ticket` varchar(255) NOT NULL,
  `event_lat` varchar(255) NOT NULL,
  `event_lng` varchar(255) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `bar_id` (`bar_id`),
  KEY `city` (`city`),
  KEY `state` (`state`),
  KEY `zipcode` (`zipcode`),
  KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=37276 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_events_test`
--

DROP TABLE IF EXISTS `sss_events_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_events_test` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(900) NOT NULL,
  `eid` varchar(255) NOT NULL,
  `event_desc` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `phone` varchar(34) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `event_video` varchar(255) NOT NULL,
  `event_video_link` varchar(500) NOT NULL,
  `is_power_boost_event` tinyint(4) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL,
  `date_added` datetime NOT NULL,
  `event_meta_title` varchar(255) NOT NULL,
  `event_meta_keyword` varchar(255) NOT NULL,
  `event_meta_description` text NOT NULL,
  `organizer` varchar(255) NOT NULL,
  `event_category` text NOT NULL,
  `admission` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `event_fb_link` varchar(255) NOT NULL,
  `event_twitter_link` varchar(255) NOT NULL,
  `event_google_plus_link` varchar(255) NOT NULL,
  `event_pinterest_link` varchar(255) NOT NULL,
  `event_upload_type` varchar(255) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `buy_ticket` varchar(255) NOT NULL,
  `event_lat` varchar(255) NOT NULL,
  `event_lng` varchar(255) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `bar_id` (`bar_id`),
  KEY `city` (`city`),
  KEY `state` (`state`),
  KEY `zipcode` (`zipcode`),
  KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=929 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_facebook_setting`
--

DROP TABLE IF EXISTS `sss_facebook_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_facebook_setting` (
  `facebook_setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `facebook_application_id` varchar(255) DEFAULT NULL,
  `facebook_login_enable` varchar(255) DEFAULT NULL,
  `facebook_access_token` varchar(255) DEFAULT NULL,
  `facebook_api_key` varchar(255) DEFAULT NULL,
  `facebook_secret_key` varchar(255) DEFAULT NULL,
  `facebook_user_autopost` varchar(255) DEFAULT NULL,
  `facebook_wall_post` varchar(255) DEFAULT NULL,
  `facebook_url` text,
  PRIMARY KEY (`facebook_setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_faq`
--

DROP TABLE IF EXISTS `sss_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_faq` (
  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
  `faq_question` text NOT NULL,
  `faq_answer` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`faq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_feature`
--

DROP TABLE IF EXISTS `sss_feature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_feature` (
  `feature_id` int(11) NOT NULL AUTO_INCREMENT,
  `halfmug` varchar(255) NOT NULL,
  `fullmug` varchar(255) NOT NULL,
  `managedmug` varchar(255) NOT NULL,
  PRIMARY KEY (`feature_id`)
) ENGINE=InnoDB AUTO_INCREMENT=524 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_forum`
--

DROP TABLE IF EXISTS `sss_forum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_forum` (
  `forum_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `topic_name` varchar(255) NOT NULL,
  `forum_category` int(11) NOT NULL,
  `forum_decription` text NOT NULL,
  `master_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `status` enum('active','inactive','pending') NOT NULL,
  `view` int(11) NOT NULL DEFAULT '0',
  `states` enum('read','unread','','') NOT NULL DEFAULT 'unread',
  `forum_meta_title` varchar(255) NOT NULL,
  `forum_meta_keyword` varchar(255) NOT NULL,
  `forum_meta_description` text NOT NULL,
  PRIMARY KEY (`forum_id`),
  KEY `user_id` (`user_id`),
  KEY `master_id` (`master_id`)
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_forum_category`
--

DROP TABLE IF EXISTS `sss_forum_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_forum_category` (
  `forum_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_category_name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`forum_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_forum_comment`
--

DROP TABLE IF EXISTS `sss_forum_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_forum_comment` (
  `forum_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_title` varchar(900) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`forum_comment_id`),
  KEY `forum_id` (`forum_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_forum_rating`
--

DROP TABLE IF EXISTS `sss_forum_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_forum_rating` (
  `forum_rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `forum_rating` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL,
  PRIMARY KEY (`forum_rating_id`),
  KEY `forum_id` (`forum_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_google_setting`
--

DROP TABLE IF EXISTS `sss_google_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_google_setting` (
  `google_setting_id` int(40) NOT NULL AUTO_INCREMENT,
  `google_client_id` varchar(225) NOT NULL,
  `google_url` varchar(225) NOT NULL,
  `google_login_enable` tinyint(3) NOT NULL,
  `google_client_secret` varchar(225) NOT NULL,
  PRIMARY KEY (`google_setting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_image_setting`
--

DROP TABLE IF EXISTS `sss_image_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_image_setting` (
  `image_setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_list_width` varchar(255) NOT NULL DEFAULT '120',
  `bar_list_height` varchar(255) NOT NULL DEFAULT '120',
  `user_width` int(50) NOT NULL DEFAULT '100',
  `user_height` int(50) NOT NULL DEFAULT '100',
  `image_width` int(100) NOT NULL DEFAULT '100',
  `image_height` int(100) NOT NULL DEFAULT '100',
  `beer_width` int(11) NOT NULL,
  `beer_height` int(11) NOT NULL,
  `event_width` int(11) NOT NULL,
  `event_height` int(11) NOT NULL,
  `photo_gallery_width` int(11) NOT NULL,
  `photo_gallery_height` int(11) NOT NULL,
  `cocktail_width` int(11) NOT NULL,
  `cocktail_height` int(11) NOT NULL,
  `banner_width` int(11) NOT NULL,
  `banner_height` int(11) NOT NULL,
  `comment_image_width` int(11) NOT NULL,
  `comment_image_height` int(11) NOT NULL,
  PRIMARY KEY (`image_setting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_iphone_stored_notification`
--

DROP TABLE IF EXISTS `sss_iphone_stored_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_iphone_stored_notification` (
  `iphone_stored_notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `notification` text NOT NULL,
  PRIMARY KEY (`iphone_stored_notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_jobs`
--

DROP TABLE IF EXISTS `sss_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_jobs` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(600) NOT NULL,
  `job_desc` text NOT NULL,
  `job_category` varchar(255) NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`job_id`),
  KEY `bar_id` (`bar_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_language`
--

DROP TABLE IF EXISTS `sss_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_language` (
  `language_id` int(10) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(255) DEFAULT NULL,
  `language_prefix` varchar(255) DEFAULT NULL,
  `language_folder` varchar(255) DEFAULT NULL,
  `language_active` int(20) NOT NULL DEFAULT '0',
  `default_language` int(10) NOT NULL DEFAULT '0',
  `language_direction` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_liquor_comment`
--

DROP TABLE IF EXISTS `sss_liquor_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_liquor_comment` (
  `liquor_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `liquor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_title` varchar(500) NOT NULL,
  `comment` text NOT NULL,
  `liquor_rating` tinyint(4) NOT NULL,
  `master_comment_id` int(11) NOT NULL,
  `comment_video` varchar(255) NOT NULL,
  `comment_image` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` tinyint(2) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`liquor_comment_id`),
  KEY `cocktail_id` (`liquor_id`),
  KEY `user_id` (`user_id`),
  KEY `master_comment_id` (`master_comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_liquors`
--

DROP TABLE IF EXISTS `sss_liquors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_liquors` (
  `liquor_id` int(11) NOT NULL AUTO_INCREMENT,
  `liquor_title` varchar(900) NOT NULL,
  `liquor_description` text NOT NULL,
  `type` text NOT NULL,
  `proof` varchar(255) NOT NULL,
  `producer` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `liquor_image` varchar(255) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `status` enum('active','inactive','pending','archived') NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL,
  `date_added` datetime NOT NULL,
  `liquor_slug` varchar(255) NOT NULL,
  `upload_type` enum('video','image') NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `image_default` varchar(255) NOT NULL,
  `liquor_meta_title` varchar(255) NOT NULL,
  `liquor_meta_keyword` varchar(255) NOT NULL,
  `liquor_meta_description` varchar(255) NOT NULL,
  `states` enum('read','unread','','') NOT NULL DEFAULT 'unread',
  `size` varchar(100) NOT NULL,
  PRIMARY KEY (`liquor_id`),
  KEY `bar_id` (`bar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1334 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_liquors_bars`
--

DROP TABLE IF EXISTS `sss_liquors_bars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_liquors_bars` (
  `liquor_bar_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_id` int(11) NOT NULL,
  `liquor_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`liquor_bar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_mappi`
--

DROP TABLE IF EXISTS `sss_mappi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_mappi` (
  `api_id` int(11) NOT NULL AUTO_INCREMENT,
  `key123` varchar(255) NOT NULL,
  `k1` varchar(255) NOT NULL,
  `k2` varchar(255) NOT NULL,
  `k3` varchar(255) NOT NULL,
  `k4` varchar(255) NOT NULL,
  `k5` varchar(255) NOT NULL,
  `k6` varchar(255) NOT NULL,
  `k7` varchar(255) NOT NULL,
  `k8` varchar(255) NOT NULL,
  `k9` varchar(255) NOT NULL,
  `k10` varchar(255) NOT NULL,
  `k11` varchar(255) NOT NULL,
  `k12` varchar(255) NOT NULL,
  `k13` varchar(255) NOT NULL,
  `k14` varchar(255) NOT NULL,
  `k15` varchar(255) NOT NULL,
  `k16` varchar(255) NOT NULL,
  `k17` varchar(255) NOT NULL,
  `k18` varchar(255) NOT NULL,
  `k19` varchar(255) NOT NULL,
  PRIMARY KEY (`api_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_message`
--

DROP TABLE IF EXISTS `sss_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_type` varchar(255) NOT NULL,
  `from_user_type` varchar(255) NOT NULL,
  `master_message_id` int(11) NOT NULL,
  `subject` varchar(55) NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_read` int(2) NOT NULL,
  `ip_address` varchar(55) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_message_user`
--

DROP TABLE IF EXISTS `sss_message_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_message_user` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_type` varchar(255) NOT NULL,
  `from_user_type` varchar(255) NOT NULL,
  `master_message_id` int(11) NOT NULL,
  `subject` varchar(55) NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_read` int(2) NOT NULL,
  `ip_address` varchar(55) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_meta_setting`
--

DROP TABLE IF EXISTS `sss_meta_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_meta_setting` (
  `meta_setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`meta_setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_module`
--

DROP TABLE IF EXISTS `sss_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_news`
--

DROP TABLE IF EXISTS `sss_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(512) NOT NULL,
  `news_desc` text NOT NULL,
  `news_category` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `hits` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_newsletter`
--

DROP TABLE IF EXISTS `sss_newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_newsletter` (
  `newsletter_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  PRIMARY KEY (`newsletter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_order_detail`
--

DROP TABLE IF EXISTS `sss_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_order_detail` (
  `order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float(10,2) NOT NULL,
  `total` float(10,2) NOT NULL,
  `color_id` varchar(255) NOT NULL,
  `size_id` varchar(255) NOT NULL,
  `bar_id` int(11) NOT NULL,
  PRIMARY KEY (`order_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_order_master`
--

DROP TABLE IF EXISTS `sss_order_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_order_master` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `update_on` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `status` enum('Pending','Shipped','Completed','Canceled','Closed') NOT NULL,
  `total` float(10,2) NOT NULL,
  `qty` int(100) NOT NULL,
  `is_deleted` varchar(1) NOT NULL DEFAULT 'N',
  `tracking_code` varchar(255) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_pages`
--

DROP TABLE IF EXISTS `sss_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_pages` (
  `pages_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `pages_title` varchar(255) DEFAULT NULL,
  `description` text,
  `description1` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `active` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pages_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_payment_fail`
--

DROP TABLE IF EXISTS `sss_payment_fail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_payment_fail` (
  `payment_fail_record_id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`payment_fail_record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_paypal`
--

DROP TABLE IF EXISTS `sss_paypal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_paypal` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `site_status` varchar(25) DEFAULT '''sandbox'',''live''',
  `admin_commision` int(11) NOT NULL,
  `application_id` varchar(255) DEFAULT NULL,
  `paypal_email` varchar(250) DEFAULT NULL,
  `paypal_username` varchar(150) DEFAULT NULL,
  `paypal_password` varchar(255) DEFAULT NULL,
  `paypal_signature` varchar(255) DEFAULT NULL,
  `gateway_status` int(2) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `vendor` varchar(255) NOT NULL,
  `partner_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_photo_gallery`
--

DROP TABLE IF EXISTS `sss_photo_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_photo_gallery` (
  `gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_type` varchar(255) NOT NULL,
  `video_type` varchar(255) NOT NULL,
  `custom_url` varchar(255) NOT NULL,
  `upload_video` varchar(255) NOT NULL,
  `banner_type` varchar(255) NOT NULL,
  `photo_title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `photo_image` varchar(255) NOT NULL,
  `gallery_type` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_product`
--

DROP TABLE IF EXISTS `sss_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_title` varchar(512) NOT NULL,
  `product_desc` text NOT NULL,
  `bar_id` int(11) NOT NULL,
  `bar_owner_id` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `discount` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_added` datetime NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_product_images`
--

DROP TABLE IF EXISTS `sss_product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_product_images` (
  `product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_image_name` varchar(255) NOT NULL,
  PRIMARY KEY (`product_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_push_message`
--

DROP TABLE IF EXISTS `sss_push_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_push_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_type` varchar(255) NOT NULL,
  `from_user_type` varchar(255) NOT NULL,
  `master_message_id` int(11) NOT NULL,
  `subject` varchar(55) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ip_address` varchar(55) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `number` varchar(200) NOT NULL,
  `is_read` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=341 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_quiz_answer`
--

DROP TABLE IF EXISTS `sss_quiz_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_quiz_answer` (
  `quiz_answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `right_answer` varchar(255) NOT NULL,
  `wring` varchar(255) NOT NULL,
  `no_result` varchar(255) NOT NULL,
  `sessionuserid` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `q_id` int(11) NOT NULL,
  PRIMARY KEY (`quiz_answer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5767 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_quiz_user`
--

DROP TABLE IF EXISTS `sss_quiz_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_quiz_user` (
  `quiz_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `sessuserid` int(1) NOT NULL,
  PRIMARY KEY (`quiz_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=887 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_registered_android`
--

DROP TABLE IF EXISTS `sss_registered_android`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_registered_android` (
  `registered_android_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `gcm_regid` text NOT NULL,
  `device_id` varchar(510) NOT NULL,
  `android_session` enum('0','1') NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`registered_android_id`)
) ENGINE=InnoDB AUTO_INCREMENT=659 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_registered_iphone`
--

DROP TABLE IF EXISTS `sss_registered_iphone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_registered_iphone` (
  `registered_iphone_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `token_id` text NOT NULL,
  `device_id` varchar(510) NOT NULL,
  `sound_name` varchar(255) NOT NULL DEFAULT 'default',
  `iphone_session` enum('0','1') NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`registered_iphone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=522 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_report`
--

DROP TABLE IF EXISTS `sss_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_report` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `desc` text NOT NULL,
  `reported_by` varchar(255) NOT NULL,
  `r_st` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_report_taxi`
--

DROP TABLE IF EXISTS `sss_report_taxi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_report_taxi` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  `taxi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `desc` text NOT NULL,
  `reported_by` varchar(255) NOT NULL,
  `r_st` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_reservation_master`
--

DROP TABLE IF EXISTS `sss_reservation_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_reservation_master` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `reserve_place` int(11) NOT NULL,
  `take_away_own_stuff` enum('yes','no') DEFAULT 'no',
  `take_away_we_supply` enum('yes','no') NOT NULL DEFAULT 'no',
  `delivery_we_deliver` enum('yes','no') NOT NULL DEFAULT 'no',
  `delivery_taxi` enum('yes','no') NOT NULL DEFAULT 'no',
  `cook_id` int(11) NOT NULL,
  `eat_id` int(11) NOT NULL,
  `fees` float NOT NULL,
  `reservation_date` datetime NOT NULL,
  `add_date` datetime NOT NULL,
  `status` enum('Completed','Pending','Confirmed') NOT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_resource`
--

DROP TABLE IF EXISTS `sss_resource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_resource` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_title` varchar(555) NOT NULL,
  `resource_desc` text NOT NULL,
  `resource_category` varchar(255) NOT NULL,
  `resource_category_id` int(11) NOT NULL,
  `website` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_added` datetime NOT NULL,
  `resource_meta_title` varchar(255) NOT NULL,
  `resource_meta_keyword` varchar(255) NOT NULL,
  `resource_meta_description` text NOT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_rights`
--

DROP TABLE IF EXISTS `sss_rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_rights` (
  `rights_id` int(100) NOT NULL AUTO_INCREMENT,
  `rights_name` varchar(255) DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`rights_id`)
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_rights_assign`
--

DROP TABLE IF EXISTS `sss_rights_assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_rights_assign` (
  `assign_id` int(100) NOT NULL AUTO_INCREMENT,
  `admin_id` int(100) NOT NULL,
  `rights_id` int(100) NOT NULL,
  `rights_set` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`assign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4932 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_rights_assign_old`
--

DROP TABLE IF EXISTS `sss_rights_assign_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_rights_assign_old` (
  `assign_id` int(100) NOT NULL AUTO_INCREMENT,
  `admin_id` int(100) NOT NULL,
  `rights_id` int(100) NOT NULL,
  `rights_set` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`assign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1503 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_rights_old`
--

DROP TABLE IF EXISTS `sss_rights_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_rights_old` (
  `rights_id` int(100) NOT NULL AUTO_INCREMENT,
  `rights_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rights_id`)
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_site_setting`
--

DROP TABLE IF EXISTS `sss_site_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_site_setting` (
  `site_setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_online` int(10) NOT NULL DEFAULT '1',
  `captcha_enable` int(10) NOT NULL DEFAULT '0',
  `site_name` varchar(255) DEFAULT NULL,
  `site_version` varchar(255) DEFAULT NULL,
  `site_language` varchar(255) DEFAULT NULL,
  `currency_symbol` varchar(255) DEFAULT NULL,
  `currency_code` varchar(255) DEFAULT NULL,
  `date_format` varchar(255) DEFAULT NULL,
  `time_format` varchar(255) DEFAULT NULL,
  `date_time_format` varchar(255) DEFAULT NULL,
  `site_tracker` varchar(255) DEFAULT NULL,
  `robots` varchar(255) DEFAULT NULL,
  `how_it_works_video` varchar(255) DEFAULT NULL,
  `zipcode_min` int(20) NOT NULL DEFAULT '4',
  `zipcode_max` int(20) NOT NULL DEFAULT '8',
  `site_timezone` varchar(255) DEFAULT NULL,
  `google_map_key` varchar(255) DEFAULT NULL,
  `poker_coach_price` double NOT NULL,
  `default_longitude` varchar(255) DEFAULT NULL,
  `default_latitude` varchar(255) DEFAULT NULL,
  `site_address` varchar(900) NOT NULL,
  `site_email` varchar(255) NOT NULL,
  `header_text` varchar(255) NOT NULL,
  `archieve_duration` tinyint(4) NOT NULL,
  `mailchimp_apikey` varchar(255) NOT NULL,
  `patient_mailchimp_listid` varchar(255) NOT NULL,
  `operator_mailchimp_listid` varchar(255) NOT NULL,
  `newsletter_mailchimp_listid` varchar(255) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `enthusiast_user_guide` text NOT NULL,
  `halfmug_user_guide` text NOT NULL,
  `fullmug_user_guide` text NOT NULL,
  `email_conversation` varchar(255) NOT NULL,
  `managed_account_amount` varchar(100) NOT NULL,
  `pin` varchar(255) NOT NULL,
  PRIMARY KEY (`site_setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_sitemap`
--

DROP TABLE IF EXISTS `sss_sitemap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_sitemap` (
  `sitemap_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`sitemap_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3708 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_social_post`
--

DROP TABLE IF EXISTS `sss_social_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_social_post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `post_to` varchar(255) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_state_master`
--

DROP TABLE IF EXISTS `sss_state_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_state_master` (
  `state_id` int(10) NOT NULL AUTO_INCREMENT,
  `country_id` int(10) NOT NULL,
  `country_code` varchar(2) COLLATE utf8_persian_ci DEFAULT NULL,
  `state_code` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `state_name` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_persian_ci NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`state_id`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`),
  KEY `country_code` (`country_code`,`state_code`,`state_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3875 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_store`
--

DROP TABLE IF EXISTS `sss_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `status` enum('active','inactive','','') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `product_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('store','adbstore','','') COLLATE utf8_unicode_ci NOT NULL,
  `product_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `back_col` enum('black','white','','') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'white',
  `store_meta_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `store_meta_keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `store_meta_description` text COLLATE utf8_unicode_ci NOT NULL,
  `bar_id` int(11) NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_suggest_advertise`
--

DROP TABLE IF EXISTS `sss_suggest_advertise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_suggest_advertise` (
  `suggest_ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `states` enum('read','unread','','') NOT NULL DEFAULT 'unread',
  PRIMARY KEY (`suggest_ad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_suggest_bars`
--

DROP TABLE IF EXISTS `sss_suggest_bars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_suggest_bars` (
  `suggest_bar_id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `bar_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `address` text NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `states` enum('read','unread') DEFAULT 'unread',
  `date` date NOT NULL,
  `count` int(11) NOT NULL,
  `status` enum('pending','approve','','') NOT NULL DEFAULT 'pending',
  `sugget_by_user` int(11) NOT NULL,
  PRIMARY KEY (`suggest_bar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=675 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_taxi_directory`
--

DROP TABLE IF EXISTS `sss_taxi_directory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_taxi_directory` (
  `taxi_id` int(11) NOT NULL AUTO_INCREMENT,
  `taxi_company` varchar(255) NOT NULL,
  `taxi_desc` text NOT NULL,
  `address` varchar(900) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `phone_number` varchar(25) NOT NULL,
  `taxi_image` varchar(255) NOT NULL,
  `taxi_banner` varchar(255) NOT NULL,
  `taxi_type` enum('half_mug','full_mug','unclaimed') NOT NULL,
  `taxi_owner_id` int(11) NOT NULL,
  `status` enum('active','inactive','archived') NOT NULL,
  `is_sugested` tinyint(4) NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL,
  `date_added` datetime NOT NULL,
  `cmpn_zipcode` varchar(255) NOT NULL,
  `cmpn_email` varchar(255) NOT NULL,
  `cmpn_website` varchar(255) NOT NULL,
  `taxi_meta_title` varchar(255) NOT NULL,
  `taxi_meta_keyword` varchar(255) NOT NULL,
  `taxi_meta_description` text NOT NULL,
  PRIMARY KEY (`taxi_id`),
  KEY `state` (`state`),
  KEY `phone_number` (`phone_number`),
  KEY `city` (`city`),
  KEY `taxi_company` (`taxi_company`)
) ENGINE=InnoDB AUTO_INCREMENT=9430 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_temp_bar`
--

DROP TABLE IF EXISTS `sss_temp_bar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_temp_bar` (
  `temp_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `address` varchar(255) NOT NULL,
  `bar_title` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `confpass` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `tax_company_name` varchar(255) NOT NULL,
  `tax_cmpn_address` varchar(255) NOT NULL,
  `texi_company_phone_number` varchar(255) NOT NULL,
  `taxi_company_website` varchar(255) NOT NULL,
  `reciew` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `bar_meta_title` varchar(255) NOT NULL,
  `bar_meta_keyword` varchar(255) NOT NULL,
  `bar_meta_description` varchar(255) NOT NULL,
  `serve_as` enum('cocktail','liquor','','') NOT NULL DEFAULT 'cocktail',
  `bar_category` varchar(255) NOT NULL,
  PRIMARY KEY (`temp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=385 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_temp_bar_features`
--

DROP TABLE IF EXISTS `sss_temp_bar_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_temp_bar_features` (
  `bar_feature_id` int(11) NOT NULL AUTO_INCREMENT,
  `temp_bar_id` int(11) NOT NULL,
  `feature_id` varchar(255) NOT NULL,
  PRIMARY KEY (`bar_feature_id`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_template_manager`
--

DROP TABLE IF EXISTS `sss_template_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_template_manager` (
  `template_id` int(100) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) DEFAULT NULL,
  `template_logo` varchar(255) DEFAULT NULL,
  `template_logo_hover` varchar(255) DEFAULT NULL,
  `active_template` int(50) NOT NULL DEFAULT '0',
  `is_admin_template` int(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_transaction`
--

DROP TABLE IF EXISTS `sss_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_transaction` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pay_email` varchar(255) NOT NULL,
  `pay_user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `taxi_id` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `transaction_status` varchar(255) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `transaction_ip` varchar(255) NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`transaction_id`),
  KEY `user_id` (`user_id`),
  KEY `txn_id` (`txn_id`),
  KEY `product_id` (`product_id`),
  KEY `bar_id` (`bar_id`),
  KEY `taxi_id` (`taxi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_transaction_order`
--

DROP TABLE IF EXISTS `sss_transaction_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_transaction_order` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pay_email` varchar(255) NOT NULL,
  `pay_user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `bar_id` int(11) NOT NULL,
  `taxi_id` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `transaction_status` varchar(255) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `transaction_ip` varchar(255) NOT NULL,
  `is_deleted` enum('no','yes') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`transaction_id`),
  KEY `user_id` (`user_id`),
  KEY `txn_id` (`txn_id`),
  KEY `product_id` (`product_id`),
  KEY `bar_id` (`bar_id`),
  KEY `taxi_id` (`taxi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_trivia`
--

DROP TABLE IF EXISTS `sss_trivia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_trivia` (
  `trivia_id` int(11) NOT NULL AUTO_INCREMENT,
  `question1` varchar(255) NOT NULL,
  `question2` varchar(255) NOT NULL,
  `question3` varchar(255) NOT NULL,
  `question4` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`trivia_id`)
) ENGINE=InnoDB AUTO_INCREMENT=686 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_twilio_setting`
--

DROP TABLE IF EXISTS `sss_twilio_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_twilio_setting` (
  `twilio_id` int(11) NOT NULL AUTO_INCREMENT,
  `mode` varchar(255) NOT NULL,
  `account_sid` varchar(255) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  `api_version` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  PRIMARY KEY (`twilio_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_user_login`
--

DROP TABLE IF EXISTS `sss_user_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_user_login` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` double DEFAULT NULL,
  `login_date_time` datetime DEFAULT NULL,
  `logout_date_time` datetime DEFAULT NULL,
  `login_ip` varchar(765) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_status` varchar(21) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1286 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_user_master`
--

DROP TABLE IF EXISTS `sss_user_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_user_master` (
  `user_id` int(100) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(256) DEFAULT NULL,
  `last_name` varchar(256) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_verification_code` varchar(255) DEFAULT NULL,
  `verify_email` int(20) NOT NULL DEFAULT '0',
  `forget_password_code` varchar(255) DEFAULT NULL,
  `forget_password_request` int(10) NOT NULL DEFAULT '0',
  `status` enum('active','inactive') NOT NULL COMMENT '0=inactive,1=active,2=suspend',
  `user_type` enum('user','bar_owner','taxi_owner') NOT NULL DEFAULT 'user',
  `sign_up_date` datetime NOT NULL,
  `sign_up_ip` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(256) DEFAULT NULL,
  `phone_no` varchar(256) DEFAULT NULL,
  `profile_image` varchar(255) NOT NULL,
  `about_user` text NOT NULL,
  `fb_id` varchar(255) NOT NULL,
  `forget_password_flag` tinyint(4) NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `birthdate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `reset_password_date` datetime NOT NULL,
  `is_deleted` enum('yes','no') NOT NULL DEFAULT 'no',
  `confirm_code` varchar(255) NOT NULL,
  `expire_date` date NOT NULL,
  `credit_card_id` varchar(255) NOT NULL,
  `flag` int(11) NOT NULL DEFAULT '0',
  `tax_company_name` varchar(255) NOT NULL,
  `tax_cmpn_address` varchar(255) NOT NULL,
  `texi_company_phone_number` varchar(255) NOT NULL,
  `taxi_company_website` varchar(255) NOT NULL,
  `reciew` text NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_state` varchar(255) NOT NULL,
  `user_zip` varchar(255) NOT NULL,
  `user_banner` varchar(255) NOT NULL,
  `fb_link` varchar(255) NOT NULL,
  `gplus_link` varchar(255) NOT NULL,
  `twitter_link` varchar(255) NOT NULL,
  `linkedin_link` varchar(255) NOT NULL,
  `pinterest_link` varchar(255) NOT NULL,
  `instagram_link` varchar(255) NOT NULL,
  `nick_name` varchar(255) NOT NULL,
  `billing_address1` varchar(255) NOT NULL,
  `billing_address2` varchar(255) NOT NULL,
  `billing_city` varchar(255) NOT NULL,
  `billing_state` varchar(255) NOT NULL,
  `billing_zipcode` varchar(255) NOT NULL,
  `billing_country` varchar(255) NOT NULL,
  `PNREF` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1578 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sss_user_setting`
--

DROP TABLE IF EXISTS `sss_user_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sss_user_setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fname` enum('0','1','','') NOT NULL DEFAULT '0',
  `lname` enum('0','1','','') NOT NULL DEFAULT '0',
  `email1` enum('0','1','','') NOT NULL DEFAULT '0',
  `gender1` enum('0','1','','') NOT NULL DEFAULT '0',
  `address1` enum('0','1','','') NOT NULL DEFAULT '0',
  `mnum` enum('0','1','','') NOT NULL DEFAULT '0',
  `abt` enum('0','1','','') NOT NULL DEFAULT '0',
  `pic` enum('0','1','','') NOT NULL DEFAULT '0',
  `album` enum('0','1','','') NOT NULL DEFAULT '0',
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=595 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1669 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB AUTO_INCREMENT=675 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(20) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-23 22:24:45
