-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2018 at 02:59 AM
-- Server version: 5.6.17
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `idcart` int(11) NOT NULL,
  `customerid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `flag` tinyint(4) NOT NULL,
  PRIMARY KEY (`idcart`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `idcategory` int(11) NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(100) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `isavailable` tinyint(4) DEFAULT NULL,
  `design_position` varchar(45) DEFAULT NULL,
  `orderid` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idcategory`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`idcategory`, `categoryname`, `description`, `level`, `isavailable`, `design_position`, `orderid`, `status`) VALUES
(1, 'category1', 'category1', 0, 1, 'category1', 1, 1),
(2, 'category2', 'category2', 1, 1, 'category2', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE IF NOT EXISTS `collections` (
  `idcollections` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `subcatid` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `default_image` varchar(45) NOT NULL,
  `meta_title` varchar(45) NOT NULL,
  `meta_description` varchar(45) NOT NULL,
  `meta_keywords` varchar(45) NOT NULL,
  `permalink` varchar(45) NOT NULL,
  `designposition` varchar(45) NOT NULL,
  `orderid` int(11) NOT NULL,
  PRIMARY KEY (`idcollections`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `idcustomer` int(11) NOT NULL,
  `fullname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `fbid` varchar(45) DEFAULT NULL,
  `twitterid` varchar(45) DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `image` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idcustomer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `idorder` int(11) NOT NULL,
  `orderdetailid` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `billing_address` varchar(200) NOT NULL,
  `billing_contact_no` varchar(45) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `cost` float NOT NULL,
  `discount` float NOT NULL,
  `currentcost` float NOT NULL,
  `payment_method` varchar(45) NOT NULL,
  `payment_status` varchar(45) NOT NULL,
  `transactionid` varchar(45) NOT NULL,
  `shipmentid` varchar(45) NOT NULL,
  `bill_date` datetime NOT NULL,
  `deliverydate` datetime NOT NULL,
  `totalproducts` int(11) NOT NULL,
  `cart` tinyint(4) NOT NULL,
  PRIMARY KEY (`idorder`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE IF NOT EXISTS `orderdetail` (
  `idorderdetail` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_price` float NOT NULL,
  `discount_price` float NOT NULL,
  `taxrate` float NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`idorderdetail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_return`
--

CREATE TABLE IF NOT EXISTS `order_return` (
  `idorder_return` int(11) NOT NULL,
  `description` varchar(45) NOT NULL,
  `orderid` int(11) NOT NULL,
  `customerid` int(11) NOT NULL,
  `transactionid` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `cartid` int(11) NOT NULL,
  PRIMARY KEY (`idorder_return`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `idproduct` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `defaultimage` varchar(45) NOT NULL,
  `permalink` varchar(45) NOT NULL,
  `catid` int(11) NOT NULL,
  `subcatid` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `meta_title` varchar(45) NOT NULL,
  `meta_description` varchar(45) NOT NULL,
  `meta_keywords` varchar(45) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idproduct`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`idproduct`, `sku`, `name`, `description`, `defaultimage`, `permalink`, `catid`, `subcatid`, `quantity`, `price`, `discount`, `meta_title`, `meta_description`, `meta_keywords`, `status`) VALUES
(1, 'test123', 'product1', 'product1', 'product1.img', 'product1', 1, 1, 1, 11, 1, '1', '1', '1', 1),
(2, 'test234', 'product2', 'product1', 'product1.img', 'product1', 1, 1, 1, 11, 1, '1', '1', '1', 1),
(3, 'test345', 'product3', 'product3', 'product3.img', 'product1', 1, 1, 1, 11, 1, '1', '1', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `idsearch` int(11) NOT NULL,
  `keyword` varchar(45) DEFAULT NULL,
  `results` text,
  `COUNT` int(11) DEFAULT NULL,
  PRIMARY KEY (`idsearch`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `idstock` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `productid` int(11) DEFAULT NULL,
  `hubid` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idstock`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `idstore` int(11) NOT NULL,
  `storename` varchar(100) DEFAULT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `logitude` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`idstore`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE IF NOT EXISTS `wishlist` (
  `idwishlist` int(11) NOT NULL,
  `description` varchar(45) NOT NULL,
  `customerid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `storeid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  PRIMARY KEY (`idwishlist`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
