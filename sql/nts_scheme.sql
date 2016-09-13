-- phpMyAdmin SQL Dump
-- version 4.4.15.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-07-2016 a las 22:37:54
-- Versión del servidor: 5.6.15-log
-- Versión de PHP: 5.4.24

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `nt_shop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_address`
--

CREATE TABLE IF NOT EXISTS `nts93j_address` (
  `address_id` int(11) NOT NULL,
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
  `zone_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_balance`
--

CREATE TABLE IF NOT EXISTS `nts93j_balance` (
  `balance_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `type` varchar(3) NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `description` text NOT NULL,
  `amount_available` decimal(10,4) NOT NULL,
  `amount_blocked` decimal(10,4) NOT NULL,
  `amount_total` decimal(10,4) NOT NULL,
  `currency_code` varchar(50) NOT NULL,
  `currency_value` decimal(10,4) NOT NULL,
  `currency_title` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_bank`
--

CREATE TABLE IF NOT EXISTS `nts93j_bank` (
  `bank_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_bank_account`
--

CREATE TABLE IF NOT EXISTS `nts93j_bank_account` (
  `bank_account_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `number` varchar(250) NOT NULL,
  `accountholder` varchar(250) NOT NULL,
  `type` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rif` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_bank_account_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_bank_account_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `bank_account_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_banner`
--

CREATE TABLE IF NOT EXISTS `nts93j_banner` (
  `banner_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `jquery_plugin` varchar(150) NOT NULL,
  `params` text NOT NULL,
  `publish_date_start` date NOT NULL,
  `publish_date_end` date NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_banner_item`
--

CREATE TABLE IF NOT EXISTS `nts93j_banner_item` (
  `banner_item_id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `image` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_banner_item_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_banner_item_description` (
  `banner_item_description_id` int(11) NOT NULL,
  `banner_item_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_banner_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_banner_property` (
  `banner_property_id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_banner_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_banner_to_store` (
  `banner_to_store_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_campaign`
--

CREATE TABLE IF NOT EXISTS `nts93j_campaign` (
  `campaign_id` int(11) NOT NULL,
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
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_campaign_contact`
--

CREATE TABLE IF NOT EXISTS `nts93j_campaign_contact` (
  `campaign_contact_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `task_queue_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_campaign_link`
--

CREATE TABLE IF NOT EXISTS `nts93j_campaign_link` (
  `campaign_link_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `url` varchar(250) NOT NULL,
  `redirect` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_campaign_link_stat`
--

CREATE TABLE IF NOT EXISTS `nts93j_campaign_link_stat` (
  `campaign_link_stat_id` int(11) NOT NULL,
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
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_campaign_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_campaign_property` (
  `campaign_property_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_campaign_stat`
--

CREATE TABLE IF NOT EXISTS `nts93j_campaign_stat` (
  `campaign_stat_id` int(11) NOT NULL,
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
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_category`
--

CREATE TABLE IF NOT EXISTS `nts93j_category` (
  `category_id` int(11) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `viewed` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_category_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_category_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_category_property` (
  `category_property_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_category_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_category_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_contact`
--

CREATE TABLE IF NOT EXISTS `nts93j_contact` (
  `contact_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `provider` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `date_deleted` datetime NOT NULL,
  `is_active` int(1) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_contact_list`
--

CREATE TABLE IF NOT EXISTS `nts93j_contact_list` (
  `contact_list_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `total_contacts` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_contact_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_contact_property` (
  `contact_property_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_contact_to_list`
--

CREATE TABLE IF NOT EXISTS `nts93j_contact_to_list` (
  `contact_to_list_id` int(11) NOT NULL,
  `contact_list_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_country`
--

CREATE TABLE IF NOT EXISTS `nts93j_country` (
  `country_id` int(11) NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `iso_code_2` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `iso_code_3` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address_format` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_coupon`
--

CREATE TABLE IF NOT EXISTS `nts93j_coupon` (
  `coupon_id` int(11) NOT NULL,
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
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_coupon_category`
--

CREATE TABLE IF NOT EXISTS `nts93j_coupon_category` (
  `coupon_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_coupon_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_coupon_description` (
  `coupon_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_coupon_history`
--

CREATE TABLE IF NOT EXISTS `nts93j_coupon_history` (
  `coupon_history_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_coupon_product`
--

CREATE TABLE IF NOT EXISTS `nts93j_coupon_product` (
  `coupon_product_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_coupon_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_coupon_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_crm_sale_opportunity_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_crm_sale_opportunity_property` (
  `sale_opportunity_property_id` int(11) NOT NULL,
  `sale_` int(11) DEFAULT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_spanish2_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_crm_sale_opportunity_status`
--

CREATE TABLE IF NOT EXISTS `nts93j_crm_sale_opportunity_status` (
  `sale_opportunity_status_id` int(11) NOT NULL COMMENT '	',
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `properties` text COLLATE utf8_spanish2_ci,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_crm_sale_product`
--

CREATE TABLE IF NOT EXISTS `nts93j_crm_sale_product` (
  `sale_product_id` int(11) NOT NULL,
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
  `date_modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_crm_sale_product_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_crm_sale_product_property` (
  `sale_product_property_id` int(11) NOT NULL COMMENT '	',
  `sale_product_id` int(11) DEFAULT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_spanish2_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_crm_sale_step`
--

CREATE TABLE IF NOT EXISTS `nts93j_crm_sale_step` (
  `sale_step_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `properties` text COLLATE utf8_spanish2_ci,
  `sort_order` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL COMMENT '		'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_currency`
--

CREATE TABLE IF NOT EXISTS `nts93j_currency` (
  `currency_id` int(11) NOT NULL,
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `code` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `symbol_left` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `symbol_right` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `decimal_place` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` float(15,8) NOT NULL,
  `status` int(1) NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_customer`
--

CREATE TABLE IF NOT EXISTS `nts93j_customer` (
  `customer_id` int(11) NOT NULL,
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
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_customer_group`
--

CREATE TABLE IF NOT EXISTS `nts93j_customer_group` (
  `customer_group_id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `params` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_customer_group_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_customer_group_property` (
  `customer_group_property_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_customer_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_customer_property` (
  `customer_property_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_customer_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_customer_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_download`
--

CREATE TABLE IF NOT EXISTS `nts93j_download` (
  `download_id` int(11) NOT NULL,
  `filename` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mask` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `remaining` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_download_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_download_description` (
  `download_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_download_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_download_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_extension`
--

CREATE TABLE IF NOT EXISTS `nts93j_extension` (
  `extension_id` int(11) NOT NULL,
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
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_geo_zone`
--

CREATE TABLE IF NOT EXISTS `nts93j_geo_zone` (
  `geo_zone_id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_im_attachment`
--

CREATE TABLE IF NOT EXISTS `nts93j_im_attachment` (
  `attachment_id` int(11) NOT NULL COMMENT '\n\n',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
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
  `date_modified` datetime DEFAULT NULL COMMENT '\n \n\n'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_im_conversation`
--

CREATE TABLE IF NOT EXISTS `nts93j_im_conversation` (
  `conversation_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `conversation_channel_id` int(11) NOT NULL,
  `conversation_status_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `type` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'ticket, chat, qa, sale_opportunity, contact',
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL COMMENT '			'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_im_conversation_channel`
--

CREATE TABLE IF NOT EXISTS `nts93j_im_conversation_channel` (
  `conversation_channel_id` int(11) NOT NULL COMMENT '		',
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `properties` text COLLATE utf8_spanish2_ci,
  `status` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL COMMENT '	'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_im_conversation_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_im_conversation_property` (
  `conversation_property_id` int(11) NOT NULL COMMENT '	',
  `conversation_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_spanish2_ci,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_im_conversation_status`
--

CREATE TABLE IF NOT EXISTS `nts93j_im_conversation_status` (
  `conversation_status_id` int(11) NOT NULL COMMENT '	',
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `properties` text COLLATE utf8_spanish2_ci,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_im_message`
--

CREATE TABLE IF NOT EXISTS `nts93j_im_message` (
  `message_id` int(11) NOT NULL,
  `human_id` int(11) NOT NULL COMMENT 'user_id, contact_id, customer_id',
  `human_type` varchar(45) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'user, contact, customer',
  `conversation_id` int(11) NOT NULL,
  `attachment_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `message` text COLLATE utf8_spanish2_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_im_message_object`
--

CREATE TABLE IF NOT EXISTS `nts93j_im_message_object` (
  `message_object_id` int(11) NOT NULL COMMENT '\n',
  `message_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(45) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_language`
--

CREATE TABLE IF NOT EXISTS `nts93j_language` (
  `language_id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `code` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `locale` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `image` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `directory` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `filename` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_layer_slider`
--

CREATE TABLE IF NOT EXISTS `nts93j_layer_slider` (
  `layer_slider_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `params` text NOT NULL,
  `publish_date_start` date NOT NULL,
  `publish_date_end` date NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_layer_slider_item`
--

CREATE TABLE IF NOT EXISTS `nts93j_layer_slider_item` (
  `layer_slider_item_id` int(11) NOT NULL,
  `layer_slider_id` int(11) NOT NULL,
  `content_type` varchar(250) NOT NULL,
  `content` varchar(250) NOT NULL,
  `params` text NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_length_class`
--

CREATE TABLE IF NOT EXISTS `nts93j_length_class` (
  `length_class_id` int(11) NOT NULL,
  `value` decimal(15,8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_length_class_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_length_class_description` (
  `length_class_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `unit` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_manufacturer`
--

CREATE TABLE IF NOT EXISTS `nts93j_manufacturer` (
  `manufacturer_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `viewed` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_manufacturer_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_manufacturer_property` (
  `manufacturer_property_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_manufacturer_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_manufacturer_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_mediafile`
--

CREATE TABLE IF NOT EXISTS `nts93j_mediafile` (
  `mediafile_id` int(11) NOT NULL,
  `mimetype` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `filesize` decimal(10,4) NOT NULL COMMENT 'kilobytes always',
  `fileextension` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filepath` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `checksum` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_mediafile_permission`
--

CREATE TABLE IF NOT EXISTS `nts93j_mediafile_permission` (
  `mediafile_permission_id` int(11) NOT NULL,
  `mediafile_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `can_read` int(1) NOT NULL,
  `can_edit` int(1) NOT NULL,
  `can_download` int(1) NOT NULL,
  `can_upload` int(1) NOT NULL,
  `can_share` int(1) NOT NULL,
  `can_delete` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_mediafile_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_mediafile_property` (
  `mediafile_property_id` int(11) NOT NULL,
  `mediafile_id` int(11) NOT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_menu`
--

CREATE TABLE IF NOT EXISTS `nts93j_menu` (
  `menu_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `route` varchar(150) NOT NULL,
  `status` int(1) NOT NULL,
  `default` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_menu_link`
--

CREATE TABLE IF NOT EXISTS `nts93j_menu_link` (
  `menu_link_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `link` varchar(250) NOT NULL,
  `tag` varchar(250) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_menu_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_menu_property` (
  `menu_property_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_menu_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_menu_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_message`
--

CREATE TABLE IF NOT EXISTS `nts93j_message` (
  `message_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `subject` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_message_to_customer`
--

CREATE TABLE IF NOT EXISTS `nts93j_message_to_customer` (
  `message_to_customer_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_movement`
--

CREATE TABLE IF NOT EXISTS `nts93j_movement` (
  `movement_id` int(11) NOT NULL,
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
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_newsletter`
--

CREATE TABLE IF NOT EXISTS `nts93j_newsletter` (
  `newsletter_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `textbody` text NOT NULL,
  `htmlbody` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_notification`
--

CREATE TABLE IF NOT EXISTS `nts93j_notification` (
  `notification_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(50) NOT NULL,
  `message` varchar(250) DEFAULT NULL COMMENT 'Mensaje que sera traducido',
  `url` varchar(250) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_object_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_object_to_store` (
  `object_to_store_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(50) NOT NULL,
  `params` text,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_order`
--

CREATE TABLE IF NOT EXISTS `nts93j_order` (
  `order_id` int(11) NOT NULL,
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
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_order_download`
--

CREATE TABLE IF NOT EXISTS `nts93j_order_download` (
  `order_download_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `filename` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mask` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `remaining` int(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_order_history`
--

CREATE TABLE IF NOT EXISTS `nts93j_order_history` (
  `order_history_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_status_id` int(5) NOT NULL,
  `notify` int(1) NOT NULL DEFAULT '0',
  `comment` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_order_option`
--

CREATE TABLE IF NOT EXISTS `nts93j_order_option` (
  `order_option_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `product_option_value_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `prefix` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_order_payment`
--

CREATE TABLE IF NOT EXISTS `nts93j_order_payment` (
  `order_payment_id` int(11) NOT NULL,
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
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_order_payment_status`
--

CREATE TABLE IF NOT EXISTS `nts93j_order_payment_status` (
  `order_payment_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_order_product`
--

CREATE TABLE IF NOT EXISTS `nts93j_order_product` (
  `order_product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `model` varchar(24) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `quantity` int(4) NOT NULL DEFAULT '0',
  `subtract` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_order_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_order_property` (
  `order_property_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_order_status`
--

CREATE TABLE IF NOT EXISTS `nts93j_order_status` (
  `order_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_order_total`
--

CREATE TABLE IF NOT EXISTS `nts93j_order_total` (
  `order_total_id` int(10) NOT NULL,
  `order_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `text` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_post`
--

CREATE TABLE IF NOT EXISTS `nts93j_post` (
  `post_id` int(11) NOT NULL,
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
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_post_category`
--

CREATE TABLE IF NOT EXISTS `nts93j_post_category` (
  `post_category_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `viewed` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_post_category_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_post_category_description` (
  `post_category_description_id` int(11) NOT NULL,
  `post_category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `meta_keywords` varchar(155) NOT NULL,
  `meta_description` varchar(155) NOT NULL,
  `seo_title` varchar(70) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_post_category_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_post_category_property` (
  `post_category_property_id` int(11) NOT NULL,
  `post_category_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_post_category_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_post_category_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `post_category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_post_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_post_description` (
  `post_description_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `seo_title` varchar(70) NOT NULL,
  `meta_description` varchar(155) NOT NULL,
  `meta_keywords` varchar(155) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_post_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_post_property` (
  `post_property_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_post_to_category`
--

CREATE TABLE IF NOT EXISTS `nts93j_post_to_category` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post_category_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_post_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_post_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product`
--

CREATE TABLE IF NOT EXISTS `nts93j_product` (
  `product_id` int(11) NOT NULL,
  `model` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sku` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `location` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `stock_status_id` int(11) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `shipping` int(1) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `demourl` varchar(255) NOT NULL,
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
  `cost` decimal(15,4) NOT NULL DEFAULT '0.0000'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_attribute`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_attribute` (
  `product_attribute_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_attribute_group_id` int(11) NOT NULL,
  `group` varchar(50) NOT NULL,
  `label` varchar(250) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `pattern` varchar(250) NOT NULL,
  `default` varchar(250) NOT NULL,
  `required` int(1) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_attribute_group`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_attribute_group` (
  `product_attribute_group_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_attribute_to_category`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_attribute_to_category` (
  `product_attribute_to_category_id` int(11) NOT NULL,
  `product_attribute_group_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_description` (
  `product_description_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_discount`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_discount` (
  `product_discount_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_featured`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_featured` (
  `product_featured_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_image`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_image` (
  `product_image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_option`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_option` (
  `product_option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_option_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_option_description` (
  `product_option_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_option_value`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_option_value` (
  `product_option_value_id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `subtract` int(1) NOT NULL DEFAULT '0',
  `price` decimal(15,4) NOT NULL,
  `prefix` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_option_value_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_option_value_description` (
  `product_option_value_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_property` (
  `product_property_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_related`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_related` (
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_special`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_special` (
  `product_special_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_tags`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_tags` (
  `product_id` int(11) NOT NULL,
  `tag` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `language_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_to_category`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_to_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_to_download`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_to_download` (
  `product_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_product_to_zone`
--

CREATE TABLE IF NOT EXISTS `nts93j_product_to_zone` (
  `product_to_zone_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `product_id` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_property` (
  `property_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(150) NOT NULL,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_review`
--

CREATE TABLE IF NOT EXISTS `nts93j_review` (
  `review_id` int(11) NOT NULL,
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
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_review_likes`
--

CREATE TABLE IF NOT EXISTS `nts93j_review_likes` (
  `review_likes_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `object_type` varchar(50) NOT NULL,
  `like` int(1) NOT NULL DEFAULT '0',
  `dislike` int(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_search`
--

CREATE TABLE IF NOT EXISTS `nts93j_search` (
  `search_id` int(11) NOT NULL,
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
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_setting`
--

CREATE TABLE IF NOT EXISTS `nts93j_setting` (
  `setting_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `group` varchar(32) COLLATE utf8_bin NOT NULL,
  `key` varchar(64) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_stat`
--

CREATE TABLE IF NOT EXISTS `nts93j_stat` (
  `stat_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
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
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_stock_status`
--

CREATE TABLE IF NOT EXISTS `nts93j_stock_status` (
  `stock_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_store` (
  `store_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `folder` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_store_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_store_description` (
  `store_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_task`
--

CREATE TABLE IF NOT EXISTS `nts93j_task` (
  `task_id` int(11) NOT NULL,
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
  `date_end_exec` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_task_exec`
--

CREATE TABLE IF NOT EXISTS `nts93j_task_exec` (
  `task_exec_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_task_queue`
--

CREATE TABLE IF NOT EXISTS `nts93j_task_queue` (
  `task_queue_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `params` text NOT NULL,
  `time_exec` datetime NOT NULL,
  `status` int(2) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_tax_class`
--

CREATE TABLE IF NOT EXISTS `nts93j_tax_class` (
  `tax_class_id` int(11) NOT NULL,
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_tax_rate`
--

CREATE TABLE IF NOT EXISTS `nts93j_tax_rate` (
  `tax_rate_id` int(11) NOT NULL,
  `geo_zone_id` int(11) NOT NULL DEFAULT '0',
  `tax_class_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `rate` decimal(7,4) NOT NULL DEFAULT '0.0000',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_template`
--

CREATE TABLE IF NOT EXISTS `nts93j_template` (
  `template_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `version` varchar(20) NOT NULL,
  `for_nt_version` varchar(20) NOT NULL,
  `colors` varchar(250) NOT NULL,
  `cols` int(1) NOT NULL,
  `scheme` varchar(250) NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_template_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_template_to_store` (
  `template_to_store_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `default` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `date_publish_start` datetime NOT NULL,
  `date_publish_end` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_theme`
--

CREATE TABLE IF NOT EXISTS `nts93j_theme` (
  `theme_id` int(11) NOT NULL,
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
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_theme_style`
--

CREATE TABLE IF NOT EXISTS `nts93j_theme_style` (
  `theme_style_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  `selector` varchar(250) NOT NULL,
  `property` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_theme_to_store`
--

CREATE TABLE IF NOT EXISTS `nts93j_theme_to_store` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_url_alias`
--

CREATE TABLE IF NOT EXISTS `nts93j_url_alias` (
  `url_alias_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `object_type` varchar(50) COLLATE utf8_bin NOT NULL,
  `query` varchar(255) COLLATE utf8_bin NOT NULL,
  `keyword` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_user`
--

CREATE TABLE IF NOT EXISTS `nts93j_user` (
  `user_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(100) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(96) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL,
  `ip` varchar(15) COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_user_activity`
--

CREATE TABLE IF NOT EXISTS `nts93j_user_activity` (
  `user_activity_id` int(11) NOT NULL,
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
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_user_group`
--

CREATE TABLE IF NOT EXISTS `nts93j_user_group` (
  `user_group_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `permission` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_user_property`
--

CREATE TABLE IF NOT EXISTS `nts93j_user_property` (
  `user_property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_weight_class`
--

CREATE TABLE IF NOT EXISTS `nts93j_weight_class` (
  `weight_class_id` int(11) NOT NULL,
  `value` decimal(15,8) NOT NULL DEFAULT '0.00000000'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_weight_class_description`
--

CREATE TABLE IF NOT EXISTS `nts93j_weight_class_description` (
  `weight_class_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `unit` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_widget`
--

CREATE TABLE IF NOT EXISTS `nts93j_widget` (
  `widget_id` bigint(20) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `code` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `extension` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `app` varchar(50) NOT NULL,
  `order` int(2) NOT NULL,
  `settings` text NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_widget_landing_page`
--

CREATE TABLE IF NOT EXISTS `nts93j_widget_landing_page` (
  `widget_landing_page_id` int(11) NOT NULL,
  `widget_id` int(11) NOT NULL,
  `landing_page` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_zone`
--

CREATE TABLE IF NOT EXISTS `nts93j_zone` (
  `zone_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nts93j_zone_to_geo_zone`
--

CREATE TABLE IF NOT EXISTS `nts93j_zone_to_geo_zone` (
  `zone_to_geo_zone_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL DEFAULT '0',
  `geo_zone_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `nts93j_address`
--
ALTER TABLE `nts93j_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indices de la tabla `nts93j_balance`
--
ALTER TABLE `nts93j_balance`
  ADD PRIMARY KEY (`balance_id`);

--
-- Indices de la tabla `nts93j_bank`
--
ALTER TABLE `nts93j_bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indices de la tabla `nts93j_bank_account`
--
ALTER TABLE `nts93j_bank_account`
  ADD PRIMARY KEY (`bank_account_id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indices de la tabla `nts93j_bank_account_to_store`
--
ALTER TABLE `nts93j_bank_account_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`bank_account_id`),
  ADD UNIQUE KEY `store_id_2` (`store_id`,`bank_account_id`);

--
-- Indices de la tabla `nts93j_banner`
--
ALTER TABLE `nts93j_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indices de la tabla `nts93j_banner_item`
--
ALTER TABLE `nts93j_banner_item`
  ADD PRIMARY KEY (`banner_item_id`);

--
-- Indices de la tabla `nts93j_banner_item_description`
--
ALTER TABLE `nts93j_banner_item_description`
  ADD PRIMARY KEY (`banner_item_description_id`),
  ADD UNIQUE KEY `description` (`banner_item_id`,`language_id`);

--
-- Indices de la tabla `nts93j_banner_property`
--
ALTER TABLE `nts93j_banner_property`
  ADD PRIMARY KEY (`banner_property_id`);

--
-- Indices de la tabla `nts93j_banner_to_store`
--
ALTER TABLE `nts93j_banner_to_store`
  ADD PRIMARY KEY (`banner_to_store_id`);

--
-- Indices de la tabla `nts93j_campaign`
--
ALTER TABLE `nts93j_campaign`
  ADD PRIMARY KEY (`campaign_id`);

--
-- Indices de la tabla `nts93j_campaign_contact`
--
ALTER TABLE `nts93j_campaign_contact`
  ADD PRIMARY KEY (`campaign_contact_id`);

--
-- Indices de la tabla `nts93j_campaign_link`
--
ALTER TABLE `nts93j_campaign_link`
  ADD PRIMARY KEY (`campaign_link_id`);

--
-- Indices de la tabla `nts93j_campaign_link_stat`
--
ALTER TABLE `nts93j_campaign_link_stat`
  ADD PRIMARY KEY (`campaign_link_stat_id`);

--
-- Indices de la tabla `nts93j_campaign_property`
--
ALTER TABLE `nts93j_campaign_property`
  ADD PRIMARY KEY (`campaign_property_id`);

--
-- Indices de la tabla `nts93j_campaign_stat`
--
ALTER TABLE `nts93j_campaign_stat`
  ADD PRIMARY KEY (`campaign_stat_id`);

--
-- Indices de la tabla `nts93j_category`
--
ALTER TABLE `nts93j_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indices de la tabla `nts93j_category_description`
--
ALTER TABLE `nts93j_category_description`
  ADD PRIMARY KEY (`category_id`,`language_id`),
  ADD KEY `name` (`name`);

--
-- Indices de la tabla `nts93j_category_property`
--
ALTER TABLE `nts93j_category_property`
  ADD PRIMARY KEY (`category_property_id`);

--
-- Indices de la tabla `nts93j_category_to_store`
--
ALTER TABLE `nts93j_category_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`category_id`);

--
-- Indices de la tabla `nts93j_contact`
--
ALTER TABLE `nts93j_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indices de la tabla `nts93j_contact_list`
--
ALTER TABLE `nts93j_contact_list`
  ADD PRIMARY KEY (`contact_list_id`);

--
-- Indices de la tabla `nts93j_contact_property`
--
ALTER TABLE `nts93j_contact_property`
  ADD PRIMARY KEY (`contact_property_id`);

--
-- Indices de la tabla `nts93j_contact_to_list`
--
ALTER TABLE `nts93j_contact_to_list`
  ADD PRIMARY KEY (`contact_to_list_id`),
  ADD UNIQUE KEY `contact_list` (`contact_list_id`,`contact_id`);

--
-- Indices de la tabla `nts93j_country`
--
ALTER TABLE `nts93j_country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indices de la tabla `nts93j_coupon`
--
ALTER TABLE `nts93j_coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indices de la tabla `nts93j_coupon_category`
--
ALTER TABLE `nts93j_coupon_category`
  ADD PRIMARY KEY (`coupon_id`,`category_id`);

--
-- Indices de la tabla `nts93j_coupon_description`
--
ALTER TABLE `nts93j_coupon_description`
  ADD PRIMARY KEY (`coupon_id`,`language_id`);

--
-- Indices de la tabla `nts93j_coupon_history`
--
ALTER TABLE `nts93j_coupon_history`
  ADD PRIMARY KEY (`coupon_history_id`);

--
-- Indices de la tabla `nts93j_coupon_product`
--
ALTER TABLE `nts93j_coupon_product`
  ADD PRIMARY KEY (`coupon_product_id`);

--
-- Indices de la tabla `nts93j_coupon_to_store`
--
ALTER TABLE `nts93j_coupon_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`coupon_id`);

--
-- Indices de la tabla `nts93j_crm_sale_opportunity_property`
--
ALTER TABLE `nts93j_crm_sale_opportunity_property`
  ADD PRIMARY KEY (`sale_opportunity_property_id`);

--
-- Indices de la tabla `nts93j_crm_sale_opportunity_status`
--
ALTER TABLE `nts93j_crm_sale_opportunity_status`
  ADD PRIMARY KEY (`sale_opportunity_status_id`);

--
-- Indices de la tabla `nts93j_crm_sale_product`
--
ALTER TABLE `nts93j_crm_sale_product`
  ADD PRIMARY KEY (`sale_product_id`);

--
-- Indices de la tabla `nts93j_crm_sale_product_property`
--
ALTER TABLE `nts93j_crm_sale_product_property`
  ADD PRIMARY KEY (`sale_product_property_id`),
  ADD KEY `group` (`group`,`key`);

--
-- Indices de la tabla `nts93j_crm_sale_step`
--
ALTER TABLE `nts93j_crm_sale_step`
  ADD PRIMARY KEY (`sale_step_id`);

--
-- Indices de la tabla `nts93j_currency`
--
ALTER TABLE `nts93j_currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indices de la tabla `nts93j_customer`
--
ALTER TABLE `nts93j_customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `nts93j_customer_group`
--
ALTER TABLE `nts93j_customer_group`
  ADD PRIMARY KEY (`customer_group_id`);

--
-- Indices de la tabla `nts93j_customer_group_property`
--
ALTER TABLE `nts93j_customer_group_property`
  ADD PRIMARY KEY (`customer_group_property_id`);

--
-- Indices de la tabla `nts93j_customer_property`
--
ALTER TABLE `nts93j_customer_property`
  ADD PRIMARY KEY (`customer_property_id`);

--
-- Indices de la tabla `nts93j_customer_to_store`
--
ALTER TABLE `nts93j_customer_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`customer_id`);

--
-- Indices de la tabla `nts93j_download`
--
ALTER TABLE `nts93j_download`
  ADD PRIMARY KEY (`download_id`);

--
-- Indices de la tabla `nts93j_download_description`
--
ALTER TABLE `nts93j_download_description`
  ADD PRIMARY KEY (`download_id`,`language_id`);

--
-- Indices de la tabla `nts93j_download_to_store`
--
ALTER TABLE `nts93j_download_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`download_id`);

--
-- Indices de la tabla `nts93j_extension`
--
ALTER TABLE `nts93j_extension`
  ADD PRIMARY KEY (`extension_id`);

--
-- Indices de la tabla `nts93j_geo_zone`
--
ALTER TABLE `nts93j_geo_zone`
  ADD PRIMARY KEY (`geo_zone_id`);

--
-- Indices de la tabla `nts93j_im_attachment`
--
ALTER TABLE `nts93j_im_attachment`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `file` (`name`,`path`);

--
-- Indices de la tabla `nts93j_im_conversation`
--
ALTER TABLE `nts93j_im_conversation`
  ADD PRIMARY KEY (`conversation_id`);

--
-- Indices de la tabla `nts93j_im_conversation_channel`
--
ALTER TABLE `nts93j_im_conversation_channel`
  ADD PRIMARY KEY (`conversation_channel_id`);

--
-- Indices de la tabla `nts93j_im_conversation_property`
--
ALTER TABLE `nts93j_im_conversation_property`
  ADD PRIMARY KEY (`conversation_property_id`),
  ADD KEY `key` (`group`,`key`);

--
-- Indices de la tabla `nts93j_im_conversation_status`
--
ALTER TABLE `nts93j_im_conversation_status`
  ADD PRIMARY KEY (`conversation_status_id`),
  ADD KEY `name` (`name`);

--
-- Indices de la tabla `nts93j_im_message`
--
ALTER TABLE `nts93j_im_message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indices de la tabla `nts93j_im_message_object`
--
ALTER TABLE `nts93j_im_message_object`
  ADD PRIMARY KEY (`message_object_id`);

--
-- Indices de la tabla `nts93j_language`
--
ALTER TABLE `nts93j_language`
  ADD PRIMARY KEY (`language_id`),
  ADD KEY `name` (`name`);

--
-- Indices de la tabla `nts93j_layer_slider`
--
ALTER TABLE `nts93j_layer_slider`
  ADD PRIMARY KEY (`layer_slider_id`);

--
-- Indices de la tabla `nts93j_layer_slider_item`
--
ALTER TABLE `nts93j_layer_slider_item`
  ADD PRIMARY KEY (`layer_slider_item_id`);

--
-- Indices de la tabla `nts93j_length_class`
--
ALTER TABLE `nts93j_length_class`
  ADD PRIMARY KEY (`length_class_id`);

--
-- Indices de la tabla `nts93j_length_class_description`
--
ALTER TABLE `nts93j_length_class_description`
  ADD PRIMARY KEY (`length_class_id`,`language_id`);

--
-- Indices de la tabla `nts93j_manufacturer`
--
ALTER TABLE `nts93j_manufacturer`
  ADD PRIMARY KEY (`manufacturer_id`);

--
-- Indices de la tabla `nts93j_manufacturer_property`
--
ALTER TABLE `nts93j_manufacturer_property`
  ADD PRIMARY KEY (`manufacturer_property_id`);

--
-- Indices de la tabla `nts93j_manufacturer_to_store`
--
ALTER TABLE `nts93j_manufacturer_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`manufacturer_id`);

--
-- Indices de la tabla `nts93j_mediafile_permission`
--
ALTER TABLE `nts93j_mediafile_permission`
  ADD PRIMARY KEY (`mediafile_permission_id`);

--
-- Indices de la tabla `nts93j_mediafile_property`
--
ALTER TABLE `nts93j_mediafile_property`
  ADD PRIMARY KEY (`mediafile_property_id`);

--
-- Indices de la tabla `nts93j_menu`
--
ALTER TABLE `nts93j_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indices de la tabla `nts93j_menu_link`
--
ALTER TABLE `nts93j_menu_link`
  ADD PRIMARY KEY (`menu_link_id`);

--
-- Indices de la tabla `nts93j_menu_property`
--
ALTER TABLE `nts93j_menu_property`
  ADD PRIMARY KEY (`menu_property_id`),
  ADD UNIQUE KEY `property` (`menu_id`,`group`,`key`);

--
-- Indices de la tabla `nts93j_menu_to_store`
--
ALTER TABLE `nts93j_menu_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`menu_id`);

--
-- Indices de la tabla `nts93j_message`
--
ALTER TABLE `nts93j_message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indices de la tabla `nts93j_message_to_customer`
--
ALTER TABLE `nts93j_message_to_customer`
  ADD PRIMARY KEY (`message_to_customer_id`);

--
-- Indices de la tabla `nts93j_movement`
--
ALTER TABLE `nts93j_movement`
  ADD PRIMARY KEY (`movement_id`);

--
-- Indices de la tabla `nts93j_newsletter`
--
ALTER TABLE `nts93j_newsletter`
  ADD PRIMARY KEY (`newsletter_id`);

--
-- Indices de la tabla `nts93j_notification`
--
ALTER TABLE `nts93j_notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indices de la tabla `nts93j_object_to_store`
--
ALTER TABLE `nts93j_object_to_store`
  ADD PRIMARY KEY (`object_to_store_id`),
  ADD UNIQUE KEY `object_to_store` (`object_id`,`object_type`,`store_id`);

--
-- Indices de la tabla `nts93j_order`
--
ALTER TABLE `nts93j_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indices de la tabla `nts93j_order_download`
--
ALTER TABLE `nts93j_order_download`
  ADD PRIMARY KEY (`order_download_id`);

--
-- Indices de la tabla `nts93j_order_history`
--
ALTER TABLE `nts93j_order_history`
  ADD PRIMARY KEY (`order_history_id`);

--
-- Indices de la tabla `nts93j_order_option`
--
ALTER TABLE `nts93j_order_option`
  ADD PRIMARY KEY (`order_option_id`);

--
-- Indices de la tabla `nts93j_order_payment`
--
ALTER TABLE `nts93j_order_payment`
  ADD PRIMARY KEY (`order_payment_id`);

--
-- Indices de la tabla `nts93j_order_payment_status`
--
ALTER TABLE `nts93j_order_payment_status`
  ADD PRIMARY KEY (`order_payment_status_id`,`language_id`),
  ADD UNIQUE KEY `status_id` (`language_id`,`order_payment_status_id`);

--
-- Indices de la tabla `nts93j_order_product`
--
ALTER TABLE `nts93j_order_product`
  ADD PRIMARY KEY (`order_product_id`);

--
-- Indices de la tabla `nts93j_order_property`
--
ALTER TABLE `nts93j_order_property`
  ADD PRIMARY KEY (`order_property_id`);

--
-- Indices de la tabla `nts93j_order_status`
--
ALTER TABLE `nts93j_order_status`
  ADD PRIMARY KEY (`order_status_id`,`language_id`);

--
-- Indices de la tabla `nts93j_order_total`
--
ALTER TABLE `nts93j_order_total`
  ADD PRIMARY KEY (`order_total_id`),
  ADD KEY `idx_orders_total_orders_id` (`order_id`);

--
-- Indices de la tabla `nts93j_post`
--
ALTER TABLE `nts93j_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indices de la tabla `nts93j_post_category`
--
ALTER TABLE `nts93j_post_category`
  ADD PRIMARY KEY (`post_category_id`);

--
-- Indices de la tabla `nts93j_post_category_description`
--
ALTER TABLE `nts93j_post_category_description`
  ADD PRIMARY KEY (`post_category_description_id`);

--
-- Indices de la tabla `nts93j_post_category_property`
--
ALTER TABLE `nts93j_post_category_property`
  ADD PRIMARY KEY (`post_category_property_id`);

--
-- Indices de la tabla `nts93j_post_category_to_store`
--
ALTER TABLE `nts93j_post_category_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`post_category_id`);

--
-- Indices de la tabla `nts93j_post_description`
--
ALTER TABLE `nts93j_post_description`
  ADD PRIMARY KEY (`post_description_id`);

--
-- Indices de la tabla `nts93j_post_property`
--
ALTER TABLE `nts93j_post_property`
  ADD PRIMARY KEY (`post_property_id`);

--
-- Indices de la tabla `nts93j_post_to_category`
--
ALTER TABLE `nts93j_post_to_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post` (`post_id`,`post_category_id`);

--
-- Indices de la tabla `nts93j_post_to_store`
--
ALTER TABLE `nts93j_post_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`post_id`);

--
-- Indices de la tabla `nts93j_product`
--
ALTER TABLE `nts93j_product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `model` (`model`);

--
-- Indices de la tabla `nts93j_product_attribute`
--
ALTER TABLE `nts93j_product_attribute`
  ADD PRIMARY KEY (`product_attribute_id`);

--
-- Indices de la tabla `nts93j_product_attribute_group`
--
ALTER TABLE `nts93j_product_attribute_group`
  ADD PRIMARY KEY (`product_attribute_group_id`);

--
-- Indices de la tabla `nts93j_product_attribute_to_category`
--
ALTER TABLE `nts93j_product_attribute_to_category`
  ADD PRIMARY KEY (`product_attribute_to_category_id`);

--
-- Indices de la tabla `nts93j_product_description`
--
ALTER TABLE `nts93j_product_description`
  ADD PRIMARY KEY (`product_description_id`),
  ADD UNIQUE KEY `product_id` (`product_id`,`language_id`),
  ADD KEY `name` (`name`);

--
-- Indices de la tabla `nts93j_product_discount`
--
ALTER TABLE `nts93j_product_discount`
  ADD PRIMARY KEY (`product_discount_id`);

--
-- Indices de la tabla `nts93j_product_featured`
--
ALTER TABLE `nts93j_product_featured`
  ADD PRIMARY KEY (`product_featured_id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indices de la tabla `nts93j_product_image`
--
ALTER TABLE `nts93j_product_image`
  ADD PRIMARY KEY (`product_image_id`);

--
-- Indices de la tabla `nts93j_product_option`
--
ALTER TABLE `nts93j_product_option`
  ADD PRIMARY KEY (`product_option_id`);

--
-- Indices de la tabla `nts93j_product_option_description`
--
ALTER TABLE `nts93j_product_option_description`
  ADD PRIMARY KEY (`product_option_id`,`language_id`);

--
-- Indices de la tabla `nts93j_product_option_value`
--
ALTER TABLE `nts93j_product_option_value`
  ADD PRIMARY KEY (`product_option_value_id`);

--
-- Indices de la tabla `nts93j_product_option_value_description`
--
ALTER TABLE `nts93j_product_option_value_description`
  ADD PRIMARY KEY (`product_option_value_id`,`language_id`);

--
-- Indices de la tabla `nts93j_product_property`
--
ALTER TABLE `nts93j_product_property`
  ADD PRIMARY KEY (`product_property_id`);

--
-- Indices de la tabla `nts93j_product_related`
--
ALTER TABLE `nts93j_product_related`
  ADD PRIMARY KEY (`product_id`,`related_id`);

--
-- Indices de la tabla `nts93j_product_special`
--
ALTER TABLE `nts93j_product_special`
  ADD PRIMARY KEY (`product_special_id`);

--
-- Indices de la tabla `nts93j_product_tags`
--
ALTER TABLE `nts93j_product_tags`
  ADD PRIMARY KEY (`product_id`,`tag`,`language_id`);

--
-- Indices de la tabla `nts93j_product_to_category`
--
ALTER TABLE `nts93j_product_to_category`
  ADD PRIMARY KEY (`product_id`,`category_id`);

--
-- Indices de la tabla `nts93j_product_to_download`
--
ALTER TABLE `nts93j_product_to_download`
  ADD PRIMARY KEY (`product_id`,`download_id`);

--
-- Indices de la tabla `nts93j_product_to_store`
--
ALTER TABLE `nts93j_product_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`product_id`);

--
-- Indices de la tabla `nts93j_product_to_zone`
--
ALTER TABLE `nts93j_product_to_zone`
  ADD PRIMARY KEY (`product_to_zone_id`);

--
-- Indices de la tabla `nts93j_property`
--
ALTER TABLE `nts93j_property`
  ADD PRIMARY KEY (`property_id`),
  ADD UNIQUE KEY `property` (`object_id`,`object_type`,`group`,`key`);

--
-- Indices de la tabla `nts93j_review`
--
ALTER TABLE `nts93j_review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indices de la tabla `nts93j_review_likes`
--
ALTER TABLE `nts93j_review_likes`
  ADD PRIMARY KEY (`review_likes_id`),
  ADD UNIQUE KEY `review_like` (`review_id`,`customer_id`);

--
-- Indices de la tabla `nts93j_search`
--
ALTER TABLE `nts93j_search`
  ADD PRIMARY KEY (`search_id`);

--
-- Indices de la tabla `nts93j_setting`
--
ALTER TABLE `nts93j_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indices de la tabla `nts93j_stat`
--
ALTER TABLE `nts93j_stat`
  ADD PRIMARY KEY (`stat_id`);

--
-- Indices de la tabla `nts93j_stock_status`
--
ALTER TABLE `nts93j_stock_status`
  ADD PRIMARY KEY (`stock_status_id`,`language_id`);

--
-- Indices de la tabla `nts93j_store`
--
ALTER TABLE `nts93j_store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indices de la tabla `nts93j_store_description`
--
ALTER TABLE `nts93j_store_description`
  ADD PRIMARY KEY (`store_id`,`language_id`);

--
-- Indices de la tabla `nts93j_task`
--
ALTER TABLE `nts93j_task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indices de la tabla `nts93j_task_exec`
--
ALTER TABLE `nts93j_task_exec`
  ADD PRIMARY KEY (`task_exec_id`);

--
-- Indices de la tabla `nts93j_task_queue`
--
ALTER TABLE `nts93j_task_queue`
  ADD PRIMARY KEY (`task_queue_id`);

--
-- Indices de la tabla `nts93j_tax_class`
--
ALTER TABLE `nts93j_tax_class`
  ADD PRIMARY KEY (`tax_class_id`);

--
-- Indices de la tabla `nts93j_tax_rate`
--
ALTER TABLE `nts93j_tax_rate`
  ADD PRIMARY KEY (`tax_rate_id`);

--
-- Indices de la tabla `nts93j_template`
--
ALTER TABLE `nts93j_template`
  ADD PRIMARY KEY (`template_id`);

--
-- Indices de la tabla `nts93j_template_to_store`
--
ALTER TABLE `nts93j_template_to_store`
  ADD PRIMARY KEY (`template_to_store_id`);

--
-- Indices de la tabla `nts93j_theme`
--
ALTER TABLE `nts93j_theme`
  ADD PRIMARY KEY (`theme_id`);

--
-- Indices de la tabla `nts93j_theme_style`
--
ALTER TABLE `nts93j_theme_style`
  ADD PRIMARY KEY (`theme_style_id`);

--
-- Indices de la tabla `nts93j_theme_to_store`
--
ALTER TABLE `nts93j_theme_to_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`,`theme_id`);

--
-- Indices de la tabla `nts93j_url_alias`
--
ALTER TABLE `nts93j_url_alias`
  ADD PRIMARY KEY (`url_alias_id`),
  ADD UNIQUE KEY `keyword` (`keyword`,`language_id`),
  ADD UNIQUE KEY `slug` (`object_id`,`language_id`,`object_type`);

--
-- Indices de la tabla `nts93j_user`
--
ALTER TABLE `nts93j_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `nts93j_user_activity`
--
ALTER TABLE `nts93j_user_activity`
  ADD PRIMARY KEY (`user_activity_id`);

--
-- Indices de la tabla `nts93j_user_group`
--
ALTER TABLE `nts93j_user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- Indices de la tabla `nts93j_user_property`
--
ALTER TABLE `nts93j_user_property`
  ADD PRIMARY KEY (`user_property_id`),
  ADD UNIQUE KEY `key` (`user_id`,`group`,`key`);

--
-- Indices de la tabla `nts93j_weight_class`
--
ALTER TABLE `nts93j_weight_class`
  ADD PRIMARY KEY (`weight_class_id`);

--
-- Indices de la tabla `nts93j_weight_class_description`
--
ALTER TABLE `nts93j_weight_class_description`
  ADD PRIMARY KEY (`weight_class_id`,`language_id`);

--
-- Indices de la tabla `nts93j_widget`
--
ALTER TABLE `nts93j_widget`
  ADD PRIMARY KEY (`widget_id`);

--
-- Indices de la tabla `nts93j_widget_landing_page`
--
ALTER TABLE `nts93j_widget_landing_page`
  ADD PRIMARY KEY (`widget_landing_page_id`);

--
-- Indices de la tabla `nts93j_zone`
--
ALTER TABLE `nts93j_zone`
  ADD PRIMARY KEY (`zone_id`);

--
-- Indices de la tabla `nts93j_zone_to_geo_zone`
--
ALTER TABLE `nts93j_zone_to_geo_zone`
  ADD PRIMARY KEY (`zone_to_geo_zone_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `nts93j_address`
--
ALTER TABLE `nts93j_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_balance`
--
ALTER TABLE `nts93j_balance`
  MODIFY `balance_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_bank`
--
ALTER TABLE `nts93j_bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_bank_account`
--
ALTER TABLE `nts93j_bank_account`
  MODIFY `bank_account_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_bank_account_to_store`
--
ALTER TABLE `nts93j_bank_account_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_banner`
--
ALTER TABLE `nts93j_banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_banner_item`
--
ALTER TABLE `nts93j_banner_item`
  MODIFY `banner_item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_banner_item_description`
--
ALTER TABLE `nts93j_banner_item_description`
  MODIFY `banner_item_description_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_banner_property`
--
ALTER TABLE `nts93j_banner_property`
  MODIFY `banner_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_banner_to_store`
--
ALTER TABLE `nts93j_banner_to_store`
  MODIFY `banner_to_store_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_campaign`
--
ALTER TABLE `nts93j_campaign`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_campaign_contact`
--
ALTER TABLE `nts93j_campaign_contact`
  MODIFY `campaign_contact_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_campaign_link`
--
ALTER TABLE `nts93j_campaign_link`
  MODIFY `campaign_link_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_campaign_link_stat`
--
ALTER TABLE `nts93j_campaign_link_stat`
  MODIFY `campaign_link_stat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_campaign_property`
--
ALTER TABLE `nts93j_campaign_property`
  MODIFY `campaign_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_campaign_stat`
--
ALTER TABLE `nts93j_campaign_stat`
  MODIFY `campaign_stat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_category`
--
ALTER TABLE `nts93j_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_category_property`
--
ALTER TABLE `nts93j_category_property`
  MODIFY `category_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_category_to_store`
--
ALTER TABLE `nts93j_category_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_contact`
--
ALTER TABLE `nts93j_contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_contact_list`
--
ALTER TABLE `nts93j_contact_list`
  MODIFY `contact_list_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_contact_property`
--
ALTER TABLE `nts93j_contact_property`
  MODIFY `contact_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_contact_to_list`
--
ALTER TABLE `nts93j_contact_to_list`
  MODIFY `contact_to_list_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_country`
--
ALTER TABLE `nts93j_country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_coupon`
--
ALTER TABLE `nts93j_coupon`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_coupon_history`
--
ALTER TABLE `nts93j_coupon_history`
  MODIFY `coupon_history_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_coupon_product`
--
ALTER TABLE `nts93j_coupon_product`
  MODIFY `coupon_product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_coupon_to_store`
--
ALTER TABLE `nts93j_coupon_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_crm_sale_opportunity_property`
--
ALTER TABLE `nts93j_crm_sale_opportunity_property`
  MODIFY `sale_opportunity_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_crm_sale_opportunity_status`
--
ALTER TABLE `nts93j_crm_sale_opportunity_status`
  MODIFY `sale_opportunity_status_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	';
--
-- AUTO_INCREMENT de la tabla `nts93j_crm_sale_product`
--
ALTER TABLE `nts93j_crm_sale_product`
  MODIFY `sale_product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_crm_sale_product_property`
--
ALTER TABLE `nts93j_crm_sale_product_property`
  MODIFY `sale_product_property_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	';
--
-- AUTO_INCREMENT de la tabla `nts93j_crm_sale_step`
--
ALTER TABLE `nts93j_crm_sale_step`
  MODIFY `sale_step_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_currency`
--
ALTER TABLE `nts93j_currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_customer`
--
ALTER TABLE `nts93j_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_customer_group`
--
ALTER TABLE `nts93j_customer_group`
  MODIFY `customer_group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_customer_group_property`
--
ALTER TABLE `nts93j_customer_group_property`
  MODIFY `customer_group_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_customer_property`
--
ALTER TABLE `nts93j_customer_property`
  MODIFY `customer_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_customer_to_store`
--
ALTER TABLE `nts93j_customer_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_download`
--
ALTER TABLE `nts93j_download`
  MODIFY `download_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_download_to_store`
--
ALTER TABLE `nts93j_download_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_extension`
--
ALTER TABLE `nts93j_extension`
  MODIFY `extension_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_geo_zone`
--
ALTER TABLE `nts93j_geo_zone`
  MODIFY `geo_zone_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_im_attachment`
--
ALTER TABLE `nts93j_im_attachment`
  MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '\n\n';
--
-- AUTO_INCREMENT de la tabla `nts93j_im_conversation`
--
ALTER TABLE `nts93j_im_conversation`
  MODIFY `conversation_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_im_conversation_channel`
--
ALTER TABLE `nts93j_im_conversation_channel`
  MODIFY `conversation_channel_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '		';
--
-- AUTO_INCREMENT de la tabla `nts93j_im_conversation_property`
--
ALTER TABLE `nts93j_im_conversation_property`
  MODIFY `conversation_property_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	';
--
-- AUTO_INCREMENT de la tabla `nts93j_im_conversation_status`
--
ALTER TABLE `nts93j_im_conversation_status`
  MODIFY `conversation_status_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	';
--
-- AUTO_INCREMENT de la tabla `nts93j_im_message`
--
ALTER TABLE `nts93j_im_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_im_message_object`
--
ALTER TABLE `nts93j_im_message_object`
  MODIFY `message_object_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '\n';
--
-- AUTO_INCREMENT de la tabla `nts93j_language`
--
ALTER TABLE `nts93j_language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_layer_slider`
--
ALTER TABLE `nts93j_layer_slider`
  MODIFY `layer_slider_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_layer_slider_item`
--
ALTER TABLE `nts93j_layer_slider_item`
  MODIFY `layer_slider_item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_length_class`
--
ALTER TABLE `nts93j_length_class`
  MODIFY `length_class_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_length_class_description`
--
ALTER TABLE `nts93j_length_class_description`
  MODIFY `length_class_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_manufacturer`
--
ALTER TABLE `nts93j_manufacturer`
  MODIFY `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_manufacturer_property`
--
ALTER TABLE `nts93j_manufacturer_property`
  MODIFY `manufacturer_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_manufacturer_to_store`
--
ALTER TABLE `nts93j_manufacturer_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_mediafile_permission`
--
ALTER TABLE `nts93j_mediafile_permission`
  MODIFY `mediafile_permission_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_mediafile_property`
--
ALTER TABLE `nts93j_mediafile_property`
  MODIFY `mediafile_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_menu`
--
ALTER TABLE `nts93j_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_menu_link`
--
ALTER TABLE `nts93j_menu_link`
  MODIFY `menu_link_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_menu_property`
--
ALTER TABLE `nts93j_menu_property`
  MODIFY `menu_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_menu_to_store`
--
ALTER TABLE `nts93j_menu_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_message`
--
ALTER TABLE `nts93j_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_message_to_customer`
--
ALTER TABLE `nts93j_message_to_customer`
  MODIFY `message_to_customer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_movement`
--
ALTER TABLE `nts93j_movement`
  MODIFY `movement_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_newsletter`
--
ALTER TABLE `nts93j_newsletter`
  MODIFY `newsletter_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_notification`
--
ALTER TABLE `nts93j_notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_object_to_store`
--
ALTER TABLE `nts93j_object_to_store`
  MODIFY `object_to_store_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_order`
--
ALTER TABLE `nts93j_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_order_download`
--
ALTER TABLE `nts93j_order_download`
  MODIFY `order_download_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_order_history`
--
ALTER TABLE `nts93j_order_history`
  MODIFY `order_history_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_order_option`
--
ALTER TABLE `nts93j_order_option`
  MODIFY `order_option_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_order_payment`
--
ALTER TABLE `nts93j_order_payment`
  MODIFY `order_payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_order_payment_status`
--
ALTER TABLE `nts93j_order_payment_status`
  MODIFY `order_payment_status_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_order_product`
--
ALTER TABLE `nts93j_order_product`
  MODIFY `order_product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_order_property`
--
ALTER TABLE `nts93j_order_property`
  MODIFY `order_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_order_status`
--
ALTER TABLE `nts93j_order_status`
  MODIFY `order_status_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_order_total`
--
ALTER TABLE `nts93j_order_total`
  MODIFY `order_total_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_post`
--
ALTER TABLE `nts93j_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_post_category`
--
ALTER TABLE `nts93j_post_category`
  MODIFY `post_category_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_post_category_description`
--
ALTER TABLE `nts93j_post_category_description`
  MODIFY `post_category_description_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_post_category_property`
--
ALTER TABLE `nts93j_post_category_property`
  MODIFY `post_category_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_post_category_to_store`
--
ALTER TABLE `nts93j_post_category_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_post_description`
--
ALTER TABLE `nts93j_post_description`
  MODIFY `post_description_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_post_property`
--
ALTER TABLE `nts93j_post_property`
  MODIFY `post_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_post_to_category`
--
ALTER TABLE `nts93j_post_to_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_post_to_store`
--
ALTER TABLE `nts93j_post_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product`
--
ALTER TABLE `nts93j_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_attribute`
--
ALTER TABLE `nts93j_product_attribute`
  MODIFY `product_attribute_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_attribute_group`
--
ALTER TABLE `nts93j_product_attribute_group`
  MODIFY `product_attribute_group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_attribute_to_category`
--
ALTER TABLE `nts93j_product_attribute_to_category`
  MODIFY `product_attribute_to_category_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_description`
--
ALTER TABLE `nts93j_product_description`
  MODIFY `product_description_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_discount`
--
ALTER TABLE `nts93j_product_discount`
  MODIFY `product_discount_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_featured`
--
ALTER TABLE `nts93j_product_featured`
  MODIFY `product_featured_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_image`
--
ALTER TABLE `nts93j_product_image`
  MODIFY `product_image_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_option`
--
ALTER TABLE `nts93j_product_option`
  MODIFY `product_option_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_option_value`
--
ALTER TABLE `nts93j_product_option_value`
  MODIFY `product_option_value_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_property`
--
ALTER TABLE `nts93j_product_property`
  MODIFY `product_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_special`
--
ALTER TABLE `nts93j_product_special`
  MODIFY `product_special_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_to_store`
--
ALTER TABLE `nts93j_product_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_product_to_zone`
--
ALTER TABLE `nts93j_product_to_zone`
  MODIFY `product_to_zone_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_property`
--
ALTER TABLE `nts93j_property`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_review`
--
ALTER TABLE `nts93j_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_review_likes`
--
ALTER TABLE `nts93j_review_likes`
  MODIFY `review_likes_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_search`
--
ALTER TABLE `nts93j_search`
  MODIFY `search_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_setting`
--
ALTER TABLE `nts93j_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_stat`
--
ALTER TABLE `nts93j_stat`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_stock_status`
--
ALTER TABLE `nts93j_stock_status`
  MODIFY `stock_status_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_store`
--
ALTER TABLE `nts93j_store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_task`
--
ALTER TABLE `nts93j_task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_task_exec`
--
ALTER TABLE `nts93j_task_exec`
  MODIFY `task_exec_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_task_queue`
--
ALTER TABLE `nts93j_task_queue`
  MODIFY `task_queue_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_tax_class`
--
ALTER TABLE `nts93j_tax_class`
  MODIFY `tax_class_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_tax_rate`
--
ALTER TABLE `nts93j_tax_rate`
  MODIFY `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_template`
--
ALTER TABLE `nts93j_template`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_template_to_store`
--
ALTER TABLE `nts93j_template_to_store`
  MODIFY `template_to_store_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_theme`
--
ALTER TABLE `nts93j_theme`
  MODIFY `theme_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_theme_style`
--
ALTER TABLE `nts93j_theme_style`
  MODIFY `theme_style_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_theme_to_store`
--
ALTER TABLE `nts93j_theme_to_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_url_alias`
--
ALTER TABLE `nts93j_url_alias`
  MODIFY `url_alias_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_user`
--
ALTER TABLE `nts93j_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_user_activity`
--
ALTER TABLE `nts93j_user_activity`
  MODIFY `user_activity_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_user_group`
--
ALTER TABLE `nts93j_user_group`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_user_property`
--
ALTER TABLE `nts93j_user_property`
  MODIFY `user_property_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_weight_class`
--
ALTER TABLE `nts93j_weight_class`
  MODIFY `weight_class_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_weight_class_description`
--
ALTER TABLE `nts93j_weight_class_description`
  MODIFY `weight_class_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_widget`
--
ALTER TABLE `nts93j_widget`
  MODIFY `widget_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_widget_landing_page`
--
ALTER TABLE `nts93j_widget_landing_page`
  MODIFY `widget_landing_page_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_zone`
--
ALTER TABLE `nts93j_zone`
  MODIFY `zone_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nts93j_zone_to_geo_zone`
--
ALTER TABLE `nts93j_zone_to_geo_zone`
  MODIFY `zone_to_geo_zone_id` int(11) NOT NULL AUTO_INCREMENT;
  
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
