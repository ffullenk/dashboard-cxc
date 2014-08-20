-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2014 at 01:18 PM
-- Server version: 5.6.13
-- PHP Version: 5.3.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `muevett-proyectos`
--

-- --------------------------------------------------------

--
-- Table structure for table `proyecto`
--

CREATE TABLE IF NOT EXISTS `proyecto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `descripcion` text NOT NULL,
  `url` varchar(256) NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_proyecto_usuario1` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `twitter_id` varchar(32) DEFAULT NULL,
  `facebook_id` varchar(32) DEFAULT NULL,
  `screen_name` varchar(128) NOT NULL DEFAULT '',
  `proyecto_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `twitter_id_UNIQUE` (`twitter_id`),
  UNIQUE KEY `facebook_id` (`facebook_id`),
  KEY `fk_usuario_proyecto` (`proyecto_id`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`proyecto_id`) REFERENCES `proyecto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

