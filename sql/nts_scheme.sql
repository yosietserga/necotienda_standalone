-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 31, 2015 at 01:46 PM
-- Server version: 5.5.37-0ubuntu0.13.10.1
-- PHP Version: 5.5.3-1ubuntu2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nt_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `nts_address`
--

CREATE TABLE IF NOT EXISTS `nts_address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `company` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lastname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address_1` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address_2` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `postcode` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `city` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `street` varchar(250) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `zone_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`address_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_balance`
--

CREATE TABLE IF NOT EXISTS `nts_balance` (
  `balance_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `type` varchar(3) NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `description` text NOT NULL,
  `amount_available` decimal(10,4) NOT NULL,
  `amount_blocked` decimal(10,4) NOT NULL,
  `amount_total` decimal(10,4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`balance_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_bank`
--

CREATE TABLE IF NOT EXISTS `nts_bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_bank_account`
--

CREATE TABLE IF NOT EXISTS `nts_bank_account` (
  `bank_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` int(11) NOT NULL,
  `number` varchar(250) NOT NULL,
  `accountholder` varchar(250) NOT NULL,
  `type` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rif` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`bank_account_id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_bank_account_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_bank_account_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `bank_account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`bank_account_id`),
  UNIQUE KEY `store_id_2` (`store_id`,`bank_account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_banner`
--

CREATE TABLE IF NOT EXISTS `nts_banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `jquery_plugin` varchar(150) NOT NULL,
  `params` text NOT NULL,
  `publish_date_start` date NOT NULL,
  `publish_date_end` date NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_banner_item`
--

CREATE TABLE IF NOT EXISTS `nts_banner_item` (
  `banner_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) NOT NULL,
  `image` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`banner_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_banner_item_description`
--

CREATE TABLE IF NOT EXISTS `nts_banner_item_description` (
  `banner_item_description_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_item_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`banner_item_description_id`),
  UNIQUE KEY `description` (`banner_item_id`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_banner_property`
--

CREATE TABLE IF NOT EXISTS `nts_banner_property` (
  `banner_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) NOT NULL,
  `group` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`banner_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_banner_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_banner_to_store` (
  `banner_to_store_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  PRIMARY KEY (`banner_to_store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_campaign`
--

CREATE TABLE IF NOT EXISTS `nts_campaign` (
  `campaign_id` int(11) NOT NULL AUTO_INCREMENT,
  `newsletter_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `subject` varchar(70) NOT NULL,
  `from_name` varchar(70) NOT NULL,
  `from_email` varchar(100) NOT NULL,
  `replyto_email` varchar(100) NOT NULL,
  `trace_email` int(1) NOT NULL,
  `trace_click` int(1) NOT NULL,
  `embed_image` int(1) NOT NULL,
  `repeat` varchar(50) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_campaign_contact`
--

CREATE TABLE IF NOT EXISTS `nts_campaign_contact` (
  `campaign_contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `task_queue_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`campaign_contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_campaign_link`
--

CREATE TABLE IF NOT EXISTS `nts_campaign_link` (
  `campaign_link_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `url` varchar(250) NOT NULL,
  `redirect` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`campaign_link_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_campaign_link_stat`
--

CREATE TABLE IF NOT EXISTS `nts_campaign_link_stat` (
  `campaign_link_stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `link` varchar(250) NOT NULL,
  `store_url` varchar(250) NOT NULL,
  `server` text NOT NULL,
  `session` text NOT NULL,
  `request` text NOT NULL,
  `ref` varchar(250) NOT NULL,
  `browser` varchar(150) NOT NULL,
  `browser_version` varchar(50) NOT NULL,
  `os` varchar(150) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`campaign_link_stat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_campaign_property`
--

CREATE TABLE IF NOT EXISTS `nts_campaign_property` (
  `campaign_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `group` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`campaign_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_campaign_stat`
--

CREATE TABLE IF NOT EXISTS `nts_campaign_stat` (
  `campaign_stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `store_url` varchar(250) NOT NULL,
  `server` text NOT NULL,
  `session` text NOT NULL,
  `request` text NOT NULL,
  `ref` varchar(250) NOT NULL,
  `browser` varchar(150) NOT NULL,
  `browser_version` varchar(50) NOT NULL,
  `os` varchar(150) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`campaign_stat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_category`
--

CREATE TABLE IF NOT EXISTS `nts_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `viewed` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_category_description`
--

CREATE TABLE IF NOT EXISTS `nts_category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`category_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_category_property`
--

CREATE TABLE IF NOT EXISTS `nts_category_property` (
  `category_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `group` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`category_property_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_category_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_category_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_contact`
--

CREATE TABLE IF NOT EXISTS `nts_contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `provider` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `date_deleted` datetime NOT NULL,
  `is_active` int(1) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_contact_list`
--

CREATE TABLE IF NOT EXISTS `nts_contact_list` (
  `contact_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `total_contacts` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`contact_list_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_contact_property`
--

CREATE TABLE IF NOT EXISTS `nts_contact_property` (
  `contact_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `group` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`contact_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_contact_to_list`
--

CREATE TABLE IF NOT EXISTS `nts_contact_to_list` (
  `contact_to_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_list_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`contact_to_list_id`),
  UNIQUE KEY `contact_list` (`contact_list_id`,`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_country`
--

CREATE TABLE IF NOT EXISTS `nts_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `iso_code_2` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `iso_code_3` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address_format` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_coupon`
--

CREATE TABLE IF NOT EXISTS `nts_coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(24) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `logged` int(1) NOT NULL,
  `shipping` int(1) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `uses_total` int(11) NOT NULL,
  `uses_customer` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_coupon_description`
--

CREATE TABLE IF NOT EXISTS `nts_coupon_description` (
  `coupon_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`coupon_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_coupon_product`
--

CREATE TABLE IF NOT EXISTS `nts_coupon_product` (
  `coupon_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`coupon_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_coupon_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_coupon_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`coupon_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_crm_sale_opportunity_property`
--

CREATE TABLE IF NOT EXISTS `nts_crm_sale_opportunity_property` (
  `sale_opportunity_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_` int(11) DEFAULT NULL,
  `group` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `key` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `value` text COLLATE utf8_spanish2_ci,
  PRIMARY KEY (`sale_opportunity_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_crm_sale_opportunity_status`
--

CREATE TABLE IF NOT EXISTS `nts_crm_sale_opportunity_status` (
  `sale_opportunity_status_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	',
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `properties` text COLLATE utf8_spanish2_ci,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`sale_opportunity_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_crm_sale_product`
--

CREATE TABLE IF NOT EXISTS `nts_crm_sale_product` (
  `sale_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `sale_opportunity_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `campaign_link_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `product_price` decimal(10,4) DEFAULT NULL,
  `product_options` text COLLATE utf8_spanish2_ci,
  `product_quantity` int(11) DEFAULT NULL,
  `product_currency` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `product_total_value` decimal(10,4) DEFAULT NULL,
  `product_total_text` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`sale_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_crm_sale_product_property`
--

CREATE TABLE IF NOT EXISTS `nts_crm_sale_product_property` (
  `sale_product_property_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	',
  `sale_product_id` int(11) DEFAULT NULL,
  `group` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `key` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `value` text COLLATE utf8_spanish2_ci,
  PRIMARY KEY (`sale_product_property_id`),
  KEY `group` (`group`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_crm_sale_step`
--

CREATE TABLE IF NOT EXISTS `nts_crm_sale_step` (
  `sale_step_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `properties` text COLLATE utf8_spanish2_ci,
  `sort_order` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL COMMENT '		',
  PRIMARY KEY (`sale_step_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_currency`
--

CREATE TABLE IF NOT EXISTS `nts_currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `code` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `symbol_left` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `symbol_right` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `decimal_place` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` float(15,8) NOT NULL,
  `status` int(1) NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_customer`
--

CREATE TABLE IF NOT EXISTS `nts_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `address_id` int(11) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL,
  `referenced_by` int(11) NOT NULL,
  `firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lastname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(96) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `telephone` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fax` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sex` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cart` text CHARACTER SET utf8 COLLATE utf8_bin,
  `newsletter` int(1) NOT NULL DEFAULT '0',
  `rif` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `company` varchar(90) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `activation_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `birthday` date NOT NULL,
  `congrats` int(1) NOT NULL DEFAULT '1',
  `blog` varchar(96) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(96) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `profesion` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `titulo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `msn` varchar(96) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `gmail` varchar(96) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `yahoo` varchar(96) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `skype` varchar(96) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `facebook` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `twitter` varchar(96) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `status` int(1) NOT NULL,
  `banned` int(1) NOT NULL,
  `approved` int(1) NOT NULL DEFAULT '0',
  `complete` int(1) NOT NULL DEFAULT '0',
  `visits` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `twitter_oauth_provider` varchar(50) NOT NULL,
  `twitter_oauth_uid` text NOT NULL,
  `twitter_oauth_token` text NOT NULL,
  `twitter_oauth_secret` text NOT NULL,
  `facebook_oauth_provider` varchar(150) NOT NULL,
  `facebook_oauth_id` text NOT NULL,
  `facebook_oauth_token` text NOT NULL,
  `facebook_oauth_secret` text NOT NULL,
  `facebook_code` text NOT NULL,
  `google_oauth_provider` varchar(150) NOT NULL,
  `google_oauth_id` text NOT NULL,
  `google_oauth_token` text NOT NULL,
  `google_oauth_secret` text NOT NULL,
  `google_code` text NOT NULL,
  `google_oauth_refresh` text NOT NULL,
  `live_oauth_id` text NOT NULL,
  `live_oauth_secret` text NOT NULL,
  `live_oauth_token` text NOT NULL,
  `live_code` text NOT NULL,
  `live_oauth_provider` varchar(250) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_customer_group`
--

CREATE TABLE IF NOT EXISTS `nts_customer_group` (
  `customer_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `params` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`customer_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_customer_group_property`
--

CREATE TABLE IF NOT EXISTS `nts_customer_group_property` (
  `customer_group_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_group_id` int(11) NOT NULL,
  `group` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`customer_group_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_customer_property`
--

CREATE TABLE IF NOT EXISTS `nts_customer_property` (
  `customer_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `group` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`customer_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_customer_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_customer_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_download`
--

CREATE TABLE IF NOT EXISTS `nts_download` (
  `download_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mask` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `remaining` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`download_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_download_description`
--

CREATE TABLE IF NOT EXISTS `nts_download_description` (
  `download_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`download_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_download_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_download_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`download_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_extension`
--

CREATE TABLE IF NOT EXISTS `nts_extension` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) COLLATE utf8_bin NOT NULL,
  `app` varchar(50) COLLATE utf8_bin NOT NULL,
  `key` varchar(32) COLLATE utf8_bin NOT NULL,
  `license` varchar(250) COLLATE utf8_bin NOT NULL,
  `install` varchar(250) COLLATE utf8_bin NOT NULL,
  `uninstall` varchar(250) COLLATE utf8_bin NOT NULL,
  `url_developer` varchar(250) COLLATE utf8_bin NOT NULL,
  `settings` text COLLATE utf8_bin NOT NULL,
  `version` varchar(25) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL,
  `last_update` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`extension_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `nts_geo_zone`
--

CREATE TABLE IF NOT EXISTS `nts_geo_zone` (
  `geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`geo_zone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_im_attachment`
--

CREATE TABLE IF NOT EXISTS `nts_im_attachment` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '\n\n',
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `description` text COLLATE utf8_spanish2_ci,
  `type` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `size` bigint(20) NOT NULL,
  `checksum` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `permissions` int(11) NOT NULL,
  `mimetype` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `extension` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL COMMENT '\n \n\n',
  PRIMARY KEY (`attachment_id`),
  KEY `file` (`name`,`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_im_conversation`
--

CREATE TABLE IF NOT EXISTS `nts_im_conversation` (
  `conversation_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `conversation_channel_id` int(11) NOT NULL,
  `conversation_status_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `type` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'ticket, chat, qa, sale_opportunity, contact',
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL COMMENT '			',
  PRIMARY KEY (`conversation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_im_conversation_channel`
--

CREATE TABLE IF NOT EXISTS `nts_im_conversation_channel` (
  `conversation_channel_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '		',
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `properties` text COLLATE utf8_spanish2_ci,
  `status` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL COMMENT '	',
  PRIMARY KEY (`conversation_channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_im_conversation_property`
--

CREATE TABLE IF NOT EXISTS `nts_im_conversation_property` (
  `conversation_property_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	',
  `conversation_id` int(11) NOT NULL,
  `group` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `value` text COLLATE utf8_spanish2_ci,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`conversation_property_id`),
  KEY `key` (`group`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_im_conversation_status`
--

CREATE TABLE IF NOT EXISTS `nts_im_conversation_status` (
  `conversation_status_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	',
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `properties` text COLLATE utf8_spanish2_ci,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`conversation_status_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_im_message`
--

CREATE TABLE IF NOT EXISTS `nts_im_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `human_id` int(11) NOT NULL COMMENT 'user_id, contact_id, customer_id',
  `human_type` varchar(45) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'user, contact, customer',
  `conversation_id` int(11) NOT NULL,
  `attachment_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `message` text COLLATE utf8_spanish2_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_im_message_object`
--

CREATE TABLE IF NOT EXISTS `nts_im_message_object` (
  `message_object_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '\n',
  `message_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`message_object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nts_language`
--

CREATE TABLE IF NOT EXISTS `nts_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `code` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `locale` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `image` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `directory` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `filename` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL,
  PRIMARY KEY (`language_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_length_class`
--

CREATE TABLE IF NOT EXISTS `nts_length_class` (
  `length_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(15,8) NOT NULL,
  PRIMARY KEY (`length_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_length_class_description`
--

CREATE TABLE IF NOT EXISTS `nts_length_class_description` (
  `length_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `unit` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`length_class_id`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_manufacturer`
--

CREATE TABLE IF NOT EXISTS `nts_manufacturer` (
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `viewed` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`manufacturer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_manufacturer_property`
--

CREATE TABLE IF NOT EXISTS `nts_manufacturer_property` (
  `manufacturer_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_id` int(11) NOT NULL,
  `group` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`manufacturer_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_manufacturer_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_manufacturer_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`manufacturer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_menu`
--

CREATE TABLE IF NOT EXISTS `nts_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `route` varchar(150) NOT NULL,
  `status` int(1) NOT NULL,
  `default` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_menu_link`
--

CREATE TABLE IF NOT EXISTS `nts_menu_link` (
  `menu_link_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `link` varchar(250) NOT NULL,
  `tag` varchar(250) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`menu_link_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_menu_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_menu_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_message`
--

CREATE TABLE IF NOT EXISTS `nts_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `subject` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_message_to_customer`
--

CREATE TABLE IF NOT EXISTS `nts_message_to_customer` (
  `message_to_customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`message_to_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_movement`
--

CREATE TABLE IF NOT EXISTS `nts_movement` (
  `movement_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `shelf_id` int(11) NOT NULL,
  `batch_number` varchar(50) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `weight` decimal(11,0) NOT NULL,
  `qty` decimal(11,0) NOT NULL,
  `movement` varchar(50) NOT NULL,
  `rotation` varchar(50) NOT NULL,
  `barcode_number` varchar(50) NOT NULL,
  `barcode_type` varchar(50) NOT NULL,
  `date_leave` datetime NOT NULL,
  `date_expiration` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`movement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_newsletter`
--

CREATE TABLE IF NOT EXISTS `nts_newsletter` (
  `newsletter_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `textbody` text NOT NULL,
  `htmlbody` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`newsletter_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_notification`
--

CREATE TABLE IF NOT EXISTS `nts_notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(50) NOT NULL,
  `message` varchar(250) DEFAULT NULL COMMENT 'Mensaje que sera traducido',
  `url` varchar(250) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_order`
--

CREATE TABLE IF NOT EXISTS `nts_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `invoice_prefix` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `store_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `store_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL DEFAULT '0',
  `firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lastname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `telephone` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fax` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(96) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_lastname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_company` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_address_1` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_address_2` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_city` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_postcode` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_zone` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_zone_id` int(11) NOT NULL,
  `shipping_country` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_country_id` int(11) NOT NULL,
  `shipping_address_format` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shipping_method` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_lastname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_company` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_address_1` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_address_2` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_city` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_postcode` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_zone` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_zone_id` int(11) NOT NULL,
  `payment_country` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_country_id` int(11) NOT NULL,
  `payment_address_format` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payment_method` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `order_status_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currency` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` decimal(15,8) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_order_download`
--

CREATE TABLE IF NOT EXISTS `nts_order_download` (
  `order_download_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `filename` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mask` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `remaining` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_download_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_order_history`
--

CREATE TABLE IF NOT EXISTS `nts_order_history` (
  `order_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_status_id` int(5) NOT NULL,
  `notify` int(1) NOT NULL DEFAULT '0',
  `comment` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`order_history_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_order_option`
--

CREATE TABLE IF NOT EXISTS `nts_order_option` (
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `product_option_value_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `prefix` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`order_option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_order_payment`
--

CREATE TABLE IF NOT EXISTS `nts_order_payment` (
  `order_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `bank_account_id` int(11) NOT NULL,
  `order_payment_status_id` int(11) NOT NULL,
  `transac_number` varchar(250) NOT NULL,
  `transac_date` date NOT NULL,
  `bank_from` varchar(250) NOT NULL,
  `payment_method` varchar(250) NOT NULL,
  `amount` decimal(11,0) NOT NULL,
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`order_payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_order_payment_status`
--

CREATE TABLE IF NOT EXISTS `nts_order_payment_status` (
  `order_payment_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`order_payment_status_id`,`language_id`),
  UNIQUE KEY `status_id` (`language_id`,`order_payment_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_order_product`
--

CREATE TABLE IF NOT EXISTS `nts_order_product` (
  `order_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `model` varchar(24) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `quantity` int(4) NOT NULL DEFAULT '0',
  `subtract` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_order_property`
--

CREATE TABLE IF NOT EXISTS `nts_order_property` (
  `order_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `group` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`order_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_order_status`
--

CREATE TABLE IF NOT EXISTS `nts_order_status` (
  `order_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`order_status_id`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_order_total`
--

CREATE TABLE IF NOT EXISTS `nts_order_total` (
  `order_total_id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `text` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`order_total_id`),
  KEY `idx_orders_total_orders_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_post`
--

CREATE TABLE IF NOT EXISTS `nts_post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `post_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `sort_order` int(11) NOT NULL,
  `image` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `status` int(1) NOT NULL,
  `date_publish_start` datetime NOT NULL,
  `date_publish_end` datetime NOT NULL,
  `publish` int(1) NOT NULL,
  `allow_reviews` int(1) NOT NULL,
  `template` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_post_category`
--

CREATE TABLE IF NOT EXISTS `nts_post_category` (
  `post_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `viewed` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`post_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_post_category_description`
--

CREATE TABLE IF NOT EXISTS `nts_post_category_description` (
  `post_category_description_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `meta_keywords` varchar(155) NOT NULL,
  `meta_description` varchar(155) NOT NULL,
  `seo_title` varchar(70) NOT NULL,
  PRIMARY KEY (`post_category_description_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_post_category_property`
--

CREATE TABLE IF NOT EXISTS `nts_post_category_property` (
  `post_category_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_category_id` int(11) NOT NULL,
  `group` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`post_category_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_post_category_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_post_category_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `post_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`post_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_post_description`
--

CREATE TABLE IF NOT EXISTS `nts_post_description` (
  `post_description_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `seo_title` varchar(70) NOT NULL,
  `meta_description` varchar(155) NOT NULL,
  `meta_keywords` varchar(155) NOT NULL,
  PRIMARY KEY (`post_description_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_post_property`
--

CREATE TABLE IF NOT EXISTS `nts_post_property` (
  `post_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `group` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`post_property_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_post_to_category`
--

CREATE TABLE IF NOT EXISTS `nts_post_to_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `post_category_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post` (`post_id`,`post_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_post_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_post_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product`
--

CREATE TABLE IF NOT EXISTS `nts_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sku` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `location` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `stock_status_id` int(11) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `shipping` int(1) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax_class_id` int(11) NOT NULL,
  `date_available` date NOT NULL,
  `weight` decimal(5,2) NOT NULL DEFAULT '0.00',
  `weight_class_id` int(11) NOT NULL DEFAULT '0',
  `length` decimal(5,2) NOT NULL DEFAULT '0.00',
  `width` decimal(5,2) NOT NULL DEFAULT '0.00',
  `height` decimal(5,2) NOT NULL DEFAULT '0.00',
  `length_class_id` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `viewed` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `subtract` int(1) NOT NULL DEFAULT '1',
  `minimum` int(11) NOT NULL DEFAULT '1',
  `cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `model` (`model`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_description`
--

CREATE TABLE IF NOT EXISTS `nts_product_description` (
  `product_description_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`product_description_id`),
  UNIQUE KEY `product_id` (`product_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_discount`
--

CREATE TABLE IF NOT EXISTS `nts_product_discount` (
  `product_discount_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`product_discount_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_featured`
--

CREATE TABLE IF NOT EXISTS `nts_product_featured` (
  `product_featured_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_featured_id`),
  UNIQUE KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_image`
--

CREATE TABLE IF NOT EXISTS `nts_product_image` (
  `product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`product_image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_option`
--

CREATE TABLE IF NOT EXISTS `nts_product_option` (
  `product_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_option_description`
--

CREATE TABLE IF NOT EXISTS `nts_product_option_description` (
  `product_option_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`product_option_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_option_value`
--

CREATE TABLE IF NOT EXISTS `nts_product_option_value` (
  `product_option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `subtract` int(1) NOT NULL DEFAULT '0',
  `price` decimal(15,4) NOT NULL,
  `prefix` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`product_option_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_option_value_description`
--

CREATE TABLE IF NOT EXISTS `nts_product_option_value_description` (
  `product_option_value_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`product_option_value_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_property`
--

CREATE TABLE IF NOT EXISTS `nts_product_property` (
  `product_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `group` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`product_property_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_related`
--

CREATE TABLE IF NOT EXISTS `nts_product_related` (
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`related_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_special`
--

CREATE TABLE IF NOT EXISTS `nts_product_special` (
  `product_special_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`product_special_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_tags`
--

CREATE TABLE IF NOT EXISTS `nts_product_tags` (
  `product_id` int(11) NOT NULL,
  `tag` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `language_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`tag`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_to_category`
--

CREATE TABLE IF NOT EXISTS `nts_product_to_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_to_download`
--

CREATE TABLE IF NOT EXISTS `nts_product_to_download` (
  `product_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`download_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_product_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_product_to_zone`
--

CREATE TABLE IF NOT EXISTS `nts_product_to_zone` (
  `product_to_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_id` int(11) NOT NULL,
  `product_id` int(1) NOT NULL,
  PRIMARY KEY (`product_to_zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_review`
--

CREATE TABLE IF NOT EXISTS `nts_review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `object_type` varchar(50) NOT NULL,
  `author` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `rating` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_review_likes`
--

CREATE TABLE IF NOT EXISTS `nts_review_likes` (
  `review_likes_id` int(11) NOT NULL AUTO_INCREMENT,
  `review_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `object_type` varchar(50) NOT NULL,
  `like` int(1) NOT NULL DEFAULT '0',
  `dislike` int(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`review_likes_id`),
  UNIQUE KEY `review_like` (`review_id`,`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_search`
--

CREATE TABLE IF NOT EXISTS `nts_search` (
  `search_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `customer_id` text NOT NULL,
  `urlQuery` text NOT NULL,
  `browser` varchar(250) NOT NULL,
  `browser_version` varchar(250) NOT NULL,
  `os` varchar(250) NOT NULL,
  `server` text NOT NULL,
  `session` text NOT NULL,
  `request` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`search_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_setting`
--

CREATE TABLE IF NOT EXISTS `nts_setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `group` varchar(32) COLLATE utf8_bin NOT NULL,
  `key` varchar(64) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `nts_stat`
--

CREATE TABLE IF NOT EXISTS `nts_stat` (
  `stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(250) NOT NULL,
  `store_id` int(11) NOT NULL,
  `store_url` varchar(250) NOT NULL,
  `server` text NOT NULL,
  `session` text NOT NULL,
  `request` text NOT NULL,
  `ref` varchar(250) NOT NULL,
  `browser` varchar(150) NOT NULL,
  `browser_version` varchar(50) NOT NULL,
  `os` varchar(150) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`stat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_stock_status`
--

CREATE TABLE IF NOT EXISTS `nts_stock_status` (
  `stock_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`stock_status_id`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_store`
--

CREATE TABLE IF NOT EXISTS `nts_store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `folder` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `nts_store_description`
--

CREATE TABLE IF NOT EXISTS `nts_store_description` (
  `store_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`store_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `nts_task`
--

CREATE TABLE IF NOT EXISTS `nts_task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(50) NOT NULL,
  `task` varchar(250) NOT NULL,
  `type` varchar(50) NOT NULL,
  `params` text NOT NULL,
  `time_interval` varchar(50) NOT NULL,
  `time_exec` datetime NOT NULL,
  `time_last_exec` datetime NOT NULL,
  `run_once` int(1) NOT NULL,
  `status` int(2) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `data_added` datetime NOT NULL,
  `date_start_exec` datetime NOT NULL,
  `date_end_exec` datetime NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_task_exec`
--

CREATE TABLE IF NOT EXISTS `nts_task_exec` (
  `task_exec_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`task_exec_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_task_queue`
--

CREATE TABLE IF NOT EXISTS `nts_task_queue` (
  `task_queue_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `params` text NOT NULL,
  `time_exec` datetime NOT NULL,
  `status` int(2) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`task_queue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_tax_class`
--

CREATE TABLE IF NOT EXISTS `nts_tax_class` (
  `tax_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tax_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_tax_rate`
--

CREATE TABLE IF NOT EXISTS `nts_tax_rate` (
  `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `geo_zone_id` int(11) NOT NULL DEFAULT '0',
  `tax_class_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `rate` decimal(7,4) NOT NULL DEFAULT '0.0000',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tax_rate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_template`
--

CREATE TABLE IF NOT EXISTS `nts_template` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `version` varchar(20) NOT NULL,
  `for_nt_version` varchar(20) NOT NULL,
  `colors` varchar(250) NOT NULL,
  `cols` int(1) NOT NULL,
  `scheme` varchar(250) NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_template_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_template_to_store` (
  `template_to_store_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `default` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `date_publish_start` datetime NOT NULL,
  `date_publish_end` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`template_to_store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_theme`
--

CREATE TABLE IF NOT EXISTS `nts_theme` (
  `theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `template` varchar(150) NOT NULL DEFAULT 'default',
  `default` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `date_publish_start` datetime NOT NULL,
  `date_publish_end` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_theme_style`
--

CREATE TABLE IF NOT EXISTS `nts_theme_style` (
  `theme_style_id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_id` int(11) NOT NULL,
  `selector` varchar(250) NOT NULL,
  `property` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY (`theme_style_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_theme_to_store`
--

CREATE TABLE IF NOT EXISTS `nts_theme_to_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_url_alias`
--

CREATE TABLE IF NOT EXISTS `nts_url_alias` (
  `url_alias_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `object_type` varchar(50) COLLATE utf8_bin NOT NULL,
  `query` varchar(255) COLLATE utf8_bin NOT NULL,
  `keyword` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`url_alias_id`),
  UNIQUE KEY `keyword` (`keyword`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `nts_user`
--

CREATE TABLE IF NOT EXISTS `nts_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(250) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(96) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL,
  `ip` varchar(15) COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `nts_user_activity`
--

CREATE TABLE IF NOT EXISTS `nts_user_activity` (
  `user_activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(50) NOT NULL,
  `event` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `browser` varchar(50) NOT NULL,
  `browser_version` varchar(20) NOT NULL,
  `os` varchar(50) NOT NULL,
  `session` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`user_activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_user_group`
--

CREATE TABLE IF NOT EXISTS `nts_user_group` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `permission` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `nts_weight_class`
--

CREATE TABLE IF NOT EXISTS `nts_weight_class` (
  `weight_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  PRIMARY KEY (`weight_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_weight_class_description`
--

CREATE TABLE IF NOT EXISTS `nts_weight_class_description` (
  `weight_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `unit` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`weight_class_id`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_widget`
--

CREATE TABLE IF NOT EXISTS `nts_widget` (
  `widget_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `code` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `extension` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `app` varchar(50) NOT NULL,
  `order` int(2) NOT NULL,
  `settings` text NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`widget_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_widget_landing_page`
--

CREATE TABLE IF NOT EXISTS `nts_widget_landing_page` (
  `widget_landing_page_id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_id` int(11) NOT NULL,
  `landing_page` varchar(150) NOT NULL,
  PRIMARY KEY (`widget_landing_page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_zone`
--

CREATE TABLE IF NOT EXISTS `nts_zone` (
  `zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`zone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nts_zone_to_geo_zone`
--

CREATE TABLE IF NOT EXISTS `nts_zone_to_geo_zone` (
  `zone_to_geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL DEFAULT '0',
  `geo_zone_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`zone_to_geo_zone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prefix_crm_sale_opportunity`
--

CREATE TABLE IF NOT EXISTS `prefix_crm_sale_opportunity` (
  `sale_opportunity_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_step_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'seller',
  `conversation_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`sale_opportunity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
