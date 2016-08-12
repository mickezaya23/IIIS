-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 22, 2016 at 01:00 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iiis_db`
--
CREATE DATABASE `iiis_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `iiis_db`;

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE IF NOT EXISTS `assessment` (
  `id` varchar(15) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `type` tinyint(2) NOT NULL,
  `attachment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_type`
--

CREATE TABLE IF NOT EXISTS `assessment_type` (
  `id` varchar(15) NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` varchar(10) NOT NULL,
  `section` varchar(15) NOT NULL,
  `semester` tinyint(1) NOT NULL,
  `acad_year` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `alias` varchar(15) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `faculty_id` varchar(10) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_assessment`
--

CREATE TABLE IF NOT EXISTS `class_assessment` (
  `class_id` varchar(10) NOT NULL,
  `assessment_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_grading_system`
--

CREATE TABLE IF NOT EXISTS `class_grading_system` (
  `id` int(4) NOT NULL,
  `gr_sys_id` varchar(10) NOT NULL,
  `class_id` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_inst_mat`
--

CREATE TABLE IF NOT EXISTS `class_inst_mat` (
  `id` int(4) NOT NULL,
  `inst_mat_id` varchar(15) NOT NULL,
  `class_id` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE IF NOT EXISTS `class_schedule` (
  `class_id` varchar(10) NOT NULL,
  `day` varchar(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_syllabus`
--

CREATE TABLE IF NOT EXISTS `class_syllabus` (
  `syllabus_id` varchar(15) NOT NULL,
  `class_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `alias` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `alias`) VALUES
('DU30', 'AB in Political Sciencess', 'AB PolSci'),
('IC69', 'Bachelor of Science in Information Technology', 'BSIT');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `id` varchar(10) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `designation` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_load`
--

CREATE TABLE IF NOT EXISTS `faculty_load` (
  `id` int(4) NOT NULL,
  `faculty_id` varchar(10) NOT NULL,
  `class_id` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grade_notation`
--

CREATE TABLE IF NOT EXISTS `grade_notation` (
  `id` tinyint(2) NOT NULL,
  `notation` float NOT NULL,
  `grade_start` float NOT NULL,
  `grade_end` float NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grade_remark`
--

CREATE TABLE IF NOT EXISTS `grade_remark` (
  `id` tinyint(1) NOT NULL,
  `name` varchar(20) NOT NULL,
  `alias` varchar(10) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grading_period`
--

CREATE TABLE IF NOT EXISTS `grading_period` (
  `id` tinyint(1) NOT NULL,
  `name` varchar(10) NOT NULL,
  `alias` varchar(10) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grading_system`
--

CREATE TABLE IF NOT EXISTS `grading_system` (
  `id` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `alias` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `template` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grading_template`
--

CREATE TABLE IF NOT EXISTS `grading_template` (
  `id` int(2) NOT NULL,
  `name` varchar(15) NOT NULL,
  `gperiod_id` tinyint(1) NOT NULL,
  `gperiod_weight` float NOT NULL,
  `assess_type` varchar(15) NOT NULL,
  `assess_weight` float NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inst_mat_type`
--

CREATE TABLE IF NOT EXISTS `inst_mat_type` (
  `id` varchar(15) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inst_material`
--

CREATE TABLE IF NOT EXISTS `inst_material` (
  `id` varchar(15) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `alias` varchar(10) NOT NULL,
  `type` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_subject_type`
--

CREATE TABLE IF NOT EXISTS `log_subject_type` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(15) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_type`
--

CREATE TABLE IF NOT EXISTS `log_type` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(15) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(5) NOT NULL,
  `subject` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `type` tinyint(2) NOT NULL,
  `log_subj_type` tinyint(2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `id` varchar(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `id` varchar(15) NOT NULL,
  `name` varchar(20) NOT NULL,
  `year_level` tinyint(1) NOT NULL,
  `class_type` varchar(10) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE IF NOT EXISTS `semester` (
  `id` tinyint(1) NOT NULL,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` varchar(20) NOT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `age` tinyint(2) NOT NULL,
  `gender` char(1) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `last_name`, `first_name`, `middle_name`, `age`, `gender`, `date_added`) VALUES
('2011-00005', 'Patalinghog', 'Rey Ann', 'B', 23, 'M', '2016-05-23 19:42:10'),
('2011-00710', 'BANTILAN', 'Junalyn', 'Sayda', 23, 'M', '2016-05-24 02:28:29'),
('2011-01902', 'BARSAL', 'Jude Norbert', 'Dano', 23, 'M', '2016-05-23 19:41:07'),
('2011-02234', 'MAGBANUA', 'Sandra', 'Suello', 23, 'M', '2016-05-23 19:41:07'),
('2011-02994', 'LASAY', 'Ma. Richelle', 'Yparraguire', 23, 'M', '2016-05-23 19:41:07'),
('2011-03004', 'JAYSON', 'Christine Joy', 'Briones', 23, 'M', '2016-05-23 19:41:07'),
('2012-03309A', 'PACANZA', 'Michelle', 'Evardo', 23, 'M', '2016-05-23 19:41:07'),
('2012-03313A', 'PASUMBAL', 'Andrea Bianca', 'Dulguime', 23, 'M', '2016-05-23 19:41:07'),
('2012-03317', 'RELEGA?O', 'Razaele', 'Bitoon', 23, 'M', '2016-05-23 19:41:07'),
('2012-03332', 'Apalacio', 'Khim Ryan', 'Pua', 23, 'M', '2016-05-23 19:42:10'),
('2012-03333', 'DUOT', 'Peter Anthony', 'Melecio', 23, 'M', '2016-05-23 19:41:07'),
('2012-0336A', 'BALANTE', 'Honey Mae', 'Marzon', 23, 'M', '2016-05-23 19:41:07'),
('2012-03371', 'MAGLINIS', 'Anna Mae', 'Rufina', 23, 'M', '2016-05-23 19:41:07'),
('2012-03463', 'PANSACALA', 'Estrella Grace', 'Cayol', 23, 'M', '2016-05-23 19:41:07'),
('2012-03470', 'RIPALDA', 'Francis Lloyd', 'Plaza', 23, 'M', '2016-05-23 19:41:07'),
('2012-03477', 'TAN', 'John Steven', 'Banson', 23, 'M', '2016-05-23 19:41:07'),
('2012-03493', 'BAJAO', 'Kristine', 'Carog', 23, 'M', '2016-05-23 19:41:07'),
('2012-03523', 'PINEDA', 'Grace', 'Diaz', 23, 'M', '2016-05-23 19:41:07'),
('2012-03529', 'SERENTAS', 'Mark John Dela', 'Cerna', 23, 'M', '2016-05-23 19:41:07'),
('2012-03675', 'REFUERZO', 'Christian Jan', 'Delfin', 23, 'M', '2016-05-23 19:41:07'),
('2012-04271', 'CORDOVA', 'Karen Faith', 'Sarda', 23, 'M', '2016-05-23 19:41:07'),
('2012-98358', 'CAGAPE', 'Mikee Allyn', 'Teorosio', 23, 'M', '2016-05-23 19:41:07'),
('2013-00198', 'Juaniza', 'Ryan Rey', 'Salazar', 23, 'M', '2016-05-23 19:42:10'),
('2013-00214', 'BURLAZA', 'Geo', 'Silagan', 23, 'M', '2016-05-23 19:41:07'),
('2013-00227', 'Ca?ones', 'Romel Bonnie', 'Rebuyon', 23, 'M', '2016-05-23 19:42:10'),
('2013-00327', 'Calumpit', 'Christian Marc', 'Malaluan', 23, 'M', '2016-05-23 19:42:10'),
('2013-00339', 'Sagun', 'Arjuna', 'Biong', 23, 'M', '2016-05-23 19:42:10'),
('2013-00441', 'ASIDOR', 'Ximdrake', 'Caf', 23, 'M', '2016-05-23 19:41:07'),
('2013-00526', 'E?IGO', 'Elgen', 'Umbayan', 23, 'M', '2016-05-23 19:41:07'),
('2013-00541', 'Pintor', 'Godwin John', 'Roa', 23, 'M', '2016-05-23 19:42:10'),
('2013-00606', 'Carreon', 'Harris', 'Bulahan', 23, 'M', '2016-05-23 19:42:10'),
('2013-00859', 'QUEVEDO', 'Jorick Basil', 'Arawiran', 23, 'M', '2016-05-23 19:41:07'),
('2013-00953', 'Cagape', 'Jaymichael Alfred', 'Teorosio', 23, 'M', '2016-05-23 19:42:10'),
('2013-01168', 'Brua', 'Sarah Colyne', 'Mercader', 23, 'M', '2016-05-23 19:42:10'),
('2013-01208', 'Sabalo', 'Queen Nahani Faith', 'Morata', 23, 'M', '2016-05-23 19:42:10'),
('2013-01245', 'GASPAR', 'Ian James', 'Villanueva', 23, 'M', '2016-05-23 19:41:07'),
('2013-01616', 'ALEMANIA', 'Dexter', 'Lape', 23, 'M', '2016-05-23 19:41:07'),
('2013-01636', 'Anore', 'Daryll John', 'Mata', 23, 'M', '2016-05-23 19:42:10'),
('2013-02280', 'QUIETA', 'Jorimel', 'Pulido', 23, 'M', '2016-05-23 19:41:07'),
('2013-98787', 'PEREZ DE TAGLE', 'Mariah Nicole', 'Potestad', 23, 'M', '2016-05-23 19:41:07'),
('2013-98954', 'DEMAFELIZ', 'Krishna', 'Pacudan', 23, 'M', '2016-05-23 19:41:07'),
('2013-99066', 'Buntas', 'Ram Milbert', '', 23, 'M', '2016-05-23 19:42:10'),
('2013-99113', 'RODILLA', 'Kerstine', 'Godito', 23, 'M', '2016-05-23 19:41:07'),
('2013-99129', 'Vergel', 'Jennifer', 'Concepcion', 23, 'M', '2016-05-23 19:42:10'),
('2013-99165', 'SABAS', 'Jonalyn', 'Lizandra', 23, 'M', '2016-05-23 19:41:07'),
('2013-99166', 'MORIONES', 'Kenneth', 'Batucan', 23, 'M', '2016-05-23 19:41:07'),
('2013-99202', 'De Guzman', 'Ronald', 'Canton', 23, 'M', '2016-05-23 19:42:10'),
('2013-99216', 'MALQUISTO', 'Gina', 'Carpen', 23, 'M', '2016-05-23 19:41:07'),
('2013-99240', 'Delos Reyes', 'Sim Jahpet', 'Caliat', 23, 'M', '2016-05-23 19:42:10'),
('2013-99366', 'Dacanay', 'Angelou', 'Lopez', 23, 'M', '2016-05-23 19:42:10'),
('2013-99375', 'NICOLAS', 'Karlo Dale', 'Adlawan', 23, 'M', '2016-05-23 19:41:07'),
('2013-99439', 'SARUCAM', 'Rosemarie', 'Bueno', 23, 'M', '2016-05-23 19:41:07'),
('2013-99507', 'Quinamot', 'Jan Enrico', 'Villanueva', 23, 'M', '2016-05-23 19:42:10'),
('2013-99748', 'Abay-Abay', 'Chersie', 'Tesoro', 23, 'M', '2016-05-23 19:42:10'),
('2013-99792', 'PONTILLAS', 'Jahzeel Irish', 'Lato', 23, 'M', '2016-05-23 19:41:07'),
('2013-99797', 'Neme?o', 'Angelica', 'Olodin', 23, 'M', '2016-05-23 19:42:10'),
('2013-99827', 'Rivas', 'Gene Anthony', 'Amoroso', 23, 'M', '2016-05-23 19:42:10'),
('2014-00265', 'LAMPARAS', 'Allen', 'Beciera', 23, 'M', '2016-05-23 19:41:07'),
('2014-00629', 'VERGARA', 'Alec Apollo De', 'Asis', 23, 'M', '2016-05-23 19:41:07'),
('2014-00756', 'SUAREZ', 'Jan Rey', 'Malasaga', 23, 'M', '2016-05-23 19:41:07'),
('2014-15219', 'Rosal', 'Robert Ross', 'Ilocso', 23, 'M', '2016-05-23 19:42:10'),
('2014-15441', 'TINGZON', 'Jose Diego', 'Pino', 23, 'M', '2016-05-23 19:41:07'),
('2014-15490', 'HANOYAN', 'Fregell', 'Toledo', 23, 'M', '2016-05-23 19:41:07'),
('2014-16104', 'ENDERES', 'Christian Jay', 'Samas', 23, 'M', '2016-05-23 19:41:07');

-- --------------------------------------------------------

--
-- Table structure for table `student_assessment`
--

CREATE TABLE IF NOT EXISTS `student_assessment` (
  `student_id` varchar(10) NOT NULL,
  `assessment_id` varchar(15) NOT NULL,
  `grade` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_class_record`
--

CREATE TABLE IF NOT EXISTS `student_class_record` (
  `id` varchar(10) NOT NULL,
  `student_id` varchar(15) NOT NULL,
  `class_id` varchar(15) NOT NULL,
  `gperiod` tinyint(1) NOT NULL,
  `final_grade` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE IF NOT EXISTS `student_course` (
  `student_id` varchar(10) NOT NULL,
  `course_id` varchar(15) NOT NULL,
  `semester` tinyint(1) NOT NULL,
  `acad_year` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_registration`
--

CREATE TABLE IF NOT EXISTS `student_registration` (
  `reg_id` bigint(20) NOT NULL,
  `student_id` varchar(15) NOT NULL,
  `class_id` varchar(15) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`reg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acad_units` float NOT NULL,
  `credit_units` float NOT NULL,
  `lab_units` float NOT NULL,
  `lab_hours` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syllabus`
--

CREATE TABLE IF NOT EXISTS `syllabus` (
  `id` varchar(15) NOT NULL,
  `name` varchar(15) NOT NULL,
  `description` text NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system_privilege`
--

CREATE TABLE IF NOT EXISTS `system_privilege` (
  `id` int(2) NOT NULL,
  `name` varchar(20) NOT NULL,
  `alias` varchar(10) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_privilege`
--

CREATE TABLE IF NOT EXISTS `user_privilege` (
  `id` tinyint(2) NOT NULL,
  `user_type` tinyint(4) NOT NULL,
  `system_privilege` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_reg_detail`
--

CREATE TABLE IF NOT EXISTS `user_reg_detail` (
  `user_id` int(4) NOT NULL,
  `reg_date` datetime NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
