-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        10.4.24-MariaDB - mariadb.org binary distribution
-- 서버 OS:                        Win64
-- HeidiSQL 버전:                  11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- u20_db 데이터베이스 구조 내보내기
CREATE DATABASE IF NOT EXISTS `u20_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `u20_db`;

-- 테이블 u20_db.list_admin 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '관리자 고유넘버',
  `admin_account` varchar(32) NOT NULL COMMENT '관리자 아이디',
  `admin_password` char(64) NOT NULL COMMENT '관리자 비밀번호',
  `admin_name` varchar(32) NOT NULL COMMENT '관리자 이름',
  `admin_level` text NOT NULL DEFAULT 'authSchedulesRead' COMMENT '관리자레벨 권한',
  `admin_datetime` datetime NOT NULL COMMENT '관리자 생성날짜',
  `admin_latest_datetime` datetime DEFAULT NULL COMMENT '관리자 최근접속날짜',
  `admin_latest_ip` varchar(64) DEFAULT NULL COMMENT '관리자 최근접속IP',
  `admin_session` varchar(64) DEFAULT NULL COMMENT '관리자 최근접속세션',
  `admin_password_datetime` datetime DEFAULT NULL COMMENT '관리자 비밀번호 변경일',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_admin:~10 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_admin` DISABLE KEYS */;
INSERT INTO `list_admin` (`admin_id`, `admin_account`, `admin_password`, `admin_name`, `admin_level`, `admin_datetime`, `admin_latest_datetime`, `admin_latest_ip`, `admin_session`, `admin_password_datetime`) VALUES
	(4, 'admin02', '634999f11f6eb3ddff57fffb6b47a0b86a58d73c70c4a56b0e6bc90c512e72da', '관리자2', 'authEntrysRead,authEntrysCreate', '2021-08-02 16:00:02', '2021-08-02 16:00:20', '210.178.101.186', 'b68a179ce1a91ce625c0617735e09c64', NULL),
	(5, 'admin1', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '관리자1', 'authEntrysRead,authEntrysDelete,authSchedulesRead,authSchedulesDelete,authRecordsRead,authRecordsDelete', '2021-09-29 21:40:52', '2021-09-30 15:41:02', '14.46.34.33', '80269f421465acdcfcc8eca3e41009c3', NULL),
	(6, 'admin2', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '관리자2', 'authEntrysRead,authEntrysUpdate,authSchedulesRead,authSchedulesUpdate', '2021-09-29 21:41:19', '2021-09-30 15:41:15', '14.46.34.33', '906d026a5695876c42652cb2bd176dec', NULL),
	(8, 'admin4', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '관리자4', 'authEntrysRead', '2021-09-29 21:42:03', '2021-09-29 21:58:06', '14.46.40.156', '6f39b2ac928082904f7d5fc58d6b3b35', NULL),
	(9, 'admin5', '1718c24b10aeb8099e3fc44960ab6949ab76a267352459f203ea1036bec382c2', '관리자5', 'authEntrysRead,authEntrysUpdate,authEntrysDelete,authEntrysCreate,authSchedulesRead,authSchedulesUpdate,authSchedulesDelete,authSchedulesCreate,authRecordsRead,authRecordsUpdate,authRecordsDelete,authRecordsCreate,authStaticsRead,authStaticsUpdate,authStaticsDelete,authStaticsCreate,authAccountsRead,authAccountsUpdate,authAccountsDelete,authAccountsCreate', '2021-09-29 21:42:17', '2023-01-16 16:35:30', '127.0.0.1', '83a1b0d899540ea09aab8c4a3565861c', '2023-01-16 10:29:46'),
	(10, 'admin6', '1718c24b10aeb8099e3fc44960ab6949ab76a267352459f203ea1036bec382c2', '관리자6', 'authEntrysRead,authEntrysUpdate,authEntrysDelete,authEntrysCreate,authSchedulesRead,authSchedulesUpdate,authSchedulesDelete,authSchedulesCreate,authRecordsRead,authRecordsUpdate,authRecordsDelete,authRecordsCreate,authStaticsRead,authStaticsUpdate,authStaticsDelete,authStaticsCreate,authAccountsRead,authAccountsUpdate,authAccountsDelete,authAccountsCreate', '2023-01-02 14:04:53', '2023-01-16 10:20:47', '220.69.240.252', '349e4e3aac611b2e70dbfb420185c76c', NULL),
	(11, 'admin7', '1718c24b10aeb8099e3fc44960ab6949ab76a267352459f203ea1036bec382c2', '관리자7', 'authEntrysRead,authEntrysUpdate,authEntrysDelete,authEntrysCreate,authSchedulesRead,authSchedulesUpdate,authSchedulesDelete,authSchedulesCreate,authRecordsRead,authRecordsUpdate,authRecordsDelete,authRecordsCreate,authStaticsRead,authStaticsUpdate,authStaticsDelete,authStaticsCreate,authAccountsRead,authAccountsUpdate,authAccountsDelete,authAccountsCreate', '2023-01-02 14:06:23', '2023-01-16 09:37:29', '220.69.240.199', 'f316589f07a12519a0042080e4728f82', NULL),
	(12, 'admin8', '1718c24b10aeb8099e3fc44960ab6949ab76a267352459f203ea1036bec382c2', '관리자8', 'authEntrysRead,authEntrysUpdate,authEntrysDelete,authEntrysCreate,authSchedulesRead,authSchedulesUpdate,authSchedulesDelete,authSchedulesCreate,authRecordsRead,authRecordsUpdate,authRecordsDelete,authRecordsCreate,authStaticsRead,authStaticsUpdate,authStaticsDelete,authStaticsCreate,authAccountsRead,authAccountsUpdate,authAccountsDelete,authAccountsCreate', '2023-01-02 14:06:51', '2023-01-16 10:24:58', '220.69.240.250', '11aca26e935c6c7e78613ea94ab6d9b6', NULL),
	(23, 'admin9', '1718c24b10aeb8099e3fc44960ab6949ab76a267352459f203ea1036bec382c2', '관리자9', 'authEntrysRead,authAccountsRead,authAccountsCreate', '2023-01-12 11:44:47', '2023-01-12 14:35:22', '127.0.0.1', '0d4bfae204df4398a266c610b1905f35', NULL),
	(25, 'admin0101', '1718c24b10aeb8099e3fc44960ab6949ab76a267352459f203ea1036bec382c2', '관리자', 'authEntrysRead,authEntrysUpdate', '2023-01-12 13:34:36', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `list_admin` ENABLE KEYS */;

-- 테이블 u20_db.list_athlete 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_athlete` (
  `athlete_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '선수 고유넘버',
  `athlete_name` varchar(64) NOT NULL COMMENT '선수 이름',
  `athlete_country` char(3) NOT NULL COMMENT '선수 국가',
  `athlete_region` varchar(64) NOT NULL COMMENT '선수 지역',
  `athlete_division` varchar(64) NOT NULL COMMENT '선수 소속',
  `athlete_gender` enum('m','f') NOT NULL DEFAULT 'm' COMMENT '선수 성별(m:남성,f:여성)',
  `athlete_birth` date NOT NULL COMMENT '선수 생년월일',
  `athlete_age` tinyint(3) unsigned NOT NULL COMMENT '선수 나이',
  `athlete_profile` varchar(128) DEFAULT NULL COMMENT '선수 프로필사진',
  `athlete_schedule` varchar(128) NOT NULL COMMENT '선수 참가 경기(경기종목 고유번호)',
  `athlete_attendance` varchar(32) NOT NULL COMMENT '선수 참석 여부',
  PRIMARY KEY (`athlete_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22231 DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_athlete:~17 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_athlete` DISABLE KEYS */;
INSERT INTO `list_athlete` (`athlete_id`, `athlete_name`, `athlete_country`, `athlete_region`, `athlete_division`, `athlete_gender`, `athlete_birth`, `athlete_age`, `athlete_profile`, `athlete_schedule`, `athlete_attendance`) VALUES
	(1, '1', 'KOR', '1', '1', 'm', '2023-01-04', 20, '1', '200m', ''),
	(11, 'Tanvir', 'BGD', '참치', '참치', 'm', '2001-01-01', 21, '', '200m', ''),
	(22, 'Junaid', 'BGD', '참치', '참치', 'm', '2001-01-01', 23, '', '200m', ''),
	(111, 'Eliza', 'KHM', '참치', '참치', 'm', '2001-01-01', 25, '', '100m', ''),
	(222, 'Jackie Chan', 'CHN', '참치', '참치', 'm', '2001-01-01', 25, '', '200m', ''),
	(1111, 'Saif', 'BGD', '참치', '참치', 'm', '2001-01-01', 22, '', '100m', ''),
	(2222, 'Jet Li', 'CHN', '참치', '참치', 'm', '2001-01-01', 25, '', '200m', ''),
	(11111, 'Jam', 'KHM', '참치', '참치', 'm', '2001-01-01', 24, '', '100m', ''),
	(22222, 'Leslie Cheung', 'CHN', '참치', '참치', 'm', '2001-01-01', 25, '', '200m', ''),
	(22223, 'wow', 'BGD', '참치', '참치', 'm', '2001-01-01', 21, '', '100m', ''),
	(22224, 'bab', 'BGD', '참치', '참치', 'm', '2001-01-01', 23, '', '200m', ''),
	(22225, 'good', 'KHM', '참치', '참치', 'm', '2001-01-01', 25, '', '100m', ''),
	(22226, 'oh', 'CHN', '참치', '참치', 'm', '2001-01-01', 25, '', '200m', ''),
	(22227, 'kim', 'BGD', '참치', '참치', 'm', '2001-01-01', 22, '', '100m', ''),
	(22228, 'hs', 'CHN', '참치', '참치', 'm', '2001-01-01', 25, '', '200m', ''),
	(22229, 'Jam', 'KHM', '참치', '참치', 'm', '2001-01-01', 24, '', '100m', ''),
	(22230, 'Leslie Cheung', 'CHN', '참치', '참치', 'm', '2001-01-01', 25, '', '200m', '');
/*!40000 ALTER TABLE `list_athlete` ENABLE KEYS */;

-- 테이블 u20_db.list_coach 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_coach` (
  `coach_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '코치 고유넘버',
  `coach_name` varchar(64) NOT NULL COMMENT '코치 이름',
  `coach_country` char(3) NOT NULL COMMENT '코치 국가',
  `coach_region` varchar(64) NOT NULL COMMENT '코치 지역',
  `coach_division` varchar(64) NOT NULL COMMENT '코치 소속',
  `coach_duty` enum('h','s') NOT NULL DEFAULT 'h' COMMENT '코치 직무(h:헤드,s:서브)',
  `coach_gender` enum('m','f') NOT NULL DEFAULT 'm' COMMENT '코치 성별(m:남성,f:여성)',
  `coach_birth` date NOT NULL COMMENT '코치 생년월일',
  `coach_age` tinyint(3) unsigned NOT NULL COMMENT '코치 나이',
  `coach_profile` varchar(128) DEFAULT NULL COMMENT '코치 프로필사진',
  `coach_schedule` varchar(128) NOT NULL COMMENT '코치 참가 경기',
  `coach_attendance` varchar(32) NOT NULL COMMENT '코치 참석 여부',
  PRIMARY KEY (`coach_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_coach:~0 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_coach` DISABLE KEYS */;
INSERT INTO `list_coach` (`coach_id`, `coach_name`, `coach_country`, `coach_region`, `coach_division`, `coach_duty`, `coach_gender`, `coach_birth`, `coach_age`, `coach_profile`, `coach_schedule`, `coach_attendance`) VALUES
	(2, 's', '1', 's', 's', 'h', 'm', '2023-01-10', 11, NULL, '1', '');
/*!40000 ALTER TABLE `list_coach` ENABLE KEYS */;

-- 테이블 u20_db.list_country 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '국가 고유아이디',
  `country_code` varchar(4) NOT NULL COMMENT '국가 코드',
  `country_name` varchar(64) NOT NULL COMMENT '국가 이름',
  `country_name_kr` varchar(32) NOT NULL COMMENT '국가 이름(한글)',
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `country_code` (`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_country:~38 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_country` DISABLE KEYS */;
INSERT INTO `list_country` (`country_id`, `country_code`, `country_name`, `country_name_kr`) VALUES
	(1, 'BGD', 'Bangladesh', '방글라데시'),
	(2, 'KHM', 'Cambodia', '캄보디아'),
	(3, 'CHN', 'China', '중국'),
	(4, 'HKG', 'Hong Kong', '홍콩'),
	(5, 'IDN', 'Indonesia', '인도네시아'),
	(6, 'IND', 'India', '인도'),
	(7, 'IRN', 'Iran', '이란'),
	(8, 'IRQ', 'Iraq', '이라크'),
	(9, 'JOR', 'Jordan', '요르단'),
	(10, 'JPN', 'Japan', '일본'),
	(11, 'KAZ', 'Kazakhstan', '카자흐스탄'),
	(12, 'KGZ', 'Kyrgyzstan', '키르기스스탄'),
	(13, 'KOR', 'Korea', '대한민국'),
	(14, 'SAU', 'Saudi Arabia', '사우디아라비아'),
	(15, 'KWT', 'Kuwait', '쿠웨이트'),
	(16, 'LAO', 'Laos', '라오스'),
	(17, 'LBN', 'Lebanon', '레바논'),
	(18, 'MAC', 'Macau', '마카오'),
	(19, 'MYS', 'Malaysia', '말레이시아'),
	(20, 'MDV', 'Maldive Islands', '몰디브'),
	(21, 'MMR', 'Myanmar', '미얀마'),
	(22, 'OMN', 'Oman', '오만'),
	(23, 'PAK', 'Pakistan', '파키스탄'),
	(24, 'PHL', 'Philippines', '필리핀'),
	(25, 'QAT', 'Qatar', '카타르'),
	(26, 'SGP', 'Singapore', '싱가포르'),
	(27, 'LKA', 'Sri Lanka', '스리랑카'),
	(28, 'SYR', 'Syria', '시리아'),
	(29, 'THA', 'Thailand', '태국'),
	(30, 'TJK', 'Tajikistan', '타지키스탄'),
	(31, 'TKM', 'Turkmenistan', '투르크메니스탄'),
	(32, 'TWN', 'Chinese Taipei', '대만'),
	(33, 'UZB', 'Uzbekistan', '우즈베키스탄'),
	(34, 'VNM', 'Vietnam', '베트남'),
	(35, 'YEM', 'Yemen', '예멘'),
	(36, 'XXX', 'Testt', '테스트요'),
	(37, 'aaa', 'test', '테스트'),
	(38, 'ㄴㄴㄴ', 'ㄴㄴㄴㄴ', 'ㄴㄴㄴㄴㄴ');
/*!40000 ALTER TABLE `list_country` ENABLE KEYS */;

-- 테이블 u20_db.list_director 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_director` (
  `director_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '임원 고유넘버',
  `director_name` varchar(64) NOT NULL COMMENT '임원 이름',
  `director_country` char(3) NOT NULL COMMENT '임원 국가',
  `director_division` varchar(64) NOT NULL COMMENT '임원 소속',
  `director_gender` enum('m','f') NOT NULL DEFAULT 'm' COMMENT '임원 성별(m:남성,f:여성)',
  `director_birth` date NOT NULL COMMENT '임원 생년월일',
  `director_age` tinyint(3) unsigned NOT NULL COMMENT '임원 나이',
  `director_duty` varchar(64) NOT NULL COMMENT '임원 직무',
  `director_schedule` varchar(128) NOT NULL COMMENT '임원 배정 경기(경기종목 고유번호)',
  `director_attendance` varchar(32) NOT NULL COMMENT '임원 참석 여부',
  `director_profile` varchar(128) DEFAULT NULL COMMENT '임원 프로필 사진',
  PRIMARY KEY (`director_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_director:~0 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_director` DISABLE KEYS */;
/*!40000 ALTER TABLE `list_director` ENABLE KEYS */;

-- 테이블 u20_db.list_judge 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_judge` (
  `judge_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '심판 고유넘버',
  `judge_name` varchar(64) NOT NULL COMMENT '심판 이름',
  `judge_country` char(3) NOT NULL COMMENT '심판 국가',
  `judge_division` varchar(64) NOT NULL COMMENT '심판 소속',
  `judge_gender` enum('m','f') NOT NULL DEFAULT 'm' COMMENT '심판 성별(m:남성,f:여성)',
  `judge_birth` date NOT NULL COMMENT '심판 생년월일',
  `judge_age` tinyint(3) unsigned NOT NULL COMMENT '심판 나이',
  `judge_duty` varchar(64) NOT NULL COMMENT '심판 직무',
  `judge_schedule` varchar(128) NOT NULL COMMENT '심판 배정 경기(경기종목 고유번호)',
  `judge_profile` varchar(128) DEFAULT NULL COMMENT '심판 프로필사진',
  `judge_account` varchar(32) NOT NULL COMMENT '심판 아이디',
  `judge_password` char(64) NOT NULL COMMENT '심판 비밀번호',
  `judge_latest_datetime` datetime DEFAULT NULL COMMENT '심판 최근접속날짜',
  `judge_latest_ip` varchar(64) DEFAULT NULL COMMENT '심판 최근접속IP',
  `judge_latest_session` varchar(64) DEFAULT NULL COMMENT '심판 최근접속세션',
  `judge_attendance` varchar(32) NOT NULL COMMENT '심판 참석여부',
  PRIMARY KEY (`judge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_judge:~0 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_judge` DISABLE KEYS */;
/*!40000 ALTER TABLE `list_judge` ENABLE KEYS */;

-- 테이블 u20_db.list_log 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '로그 고유넘버',
  `log_account` varchar(32) NOT NULL COMMENT '로그 아이디(관리자/심판)',
  `log_name` varchar(32) NOT NULL COMMENT '로그 이름(관리자/심판)',
  `log_ip` varchar(32) NOT NULL COMMENT '로그 IP(관리자/심판)',
  `log_division` enum('a','j') NOT NULL DEFAULT 'a' COMMENT '로그 구분(a:관리자, j:심판)',
  `log_activity` varchar(128) NOT NULL COMMENT '로그 활동내역',
  `log_sub_activity` varchar(256) DEFAULT NULL COMMENT '로그 세부 활동내역',
  `log_datetime` datetime NOT NULL COMMENT '로그 사용시간',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_log:~104 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_log` DISABLE KEYS */;
INSERT INTO `list_log` (`log_id`, `log_account`, `log_name`, `log_ip`, `log_division`, `log_activity`, `log_sub_activity`, `log_datetime`) VALUES
	(1, 'admin5', '관리자5', '199.111.111.111', 'a', '기록 삭제', 'admin4', '2023-01-04 10:28:24'),
	(2, 'admin4', '관리자4', '199.100.100.100', 'a', '국가 수정', 'KOR', '2023-01-04 10:38:59'),
	(6, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-04 14:12:10'),
	(7, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 생성', 'admin00', '2023-01-04 14:17:33'),
	(12, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin02', '2023-01-04 14:28:52'),
	(13, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin02', '2023-01-04 14:28:59'),
	(14, 'admin5', '관리자5', '127.0.0.1', 'a', '로그아웃', '', '2023-01-04 14:31:04'),
	(15, 'admin7', 'sdsad', '127.0.0.1', 'a', '로그인', '', '2023-01-04 14:32:55'),
	(16, 'admin7', 'sdsad', '127.0.0.1', 'a', '로그아웃', '', '2023-01-04 14:45:38'),
	(17, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-04 14:45:56'),
	(18, 'admin5', '관리자5', '127.0.0.1', 'a', '로그아웃', '', '2023-01-04 14:45:57'),
	(19, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-04 14:46:36'),
	(20, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin00', '2023-01-05 16:10:07'),
	(21, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin5', '2023-01-05 16:10:28'),
	(22, 'admin5', '관리자5', '::1', 'a', '계정 권한 수정', 'admin5', '2023-01-05 16:10:51'),
	(23, 'admin5', '관리자5', '::1', 'a', '계정 권한 수정', 'admin5', '2023-01-05 16:12:33'),
	(24, 'admin5', '관리자5', '::1', 'a', '로그아웃', '', '2023-01-06 15:36:14'),
	(25, 'admin5', '관리자5', '::1', 'a', '로그인', '', '2023-01-06 15:36:28'),
	(26, 'admin6', '관리자6', '220.69.240.121', 'a', '로그인', '', '2023-01-06 16:05:12'),
	(27, 'admin5', '관리자5', '::1', 'a', '계정 권한 수정', 'admin4', '2023-01-06 17:51:53'),
	(28, 'admin5', '관리자5', '::1', 'a', '계정 권한 수정', 'admin4', '2023-01-06 17:52:36'),
	(29, 'admin5', '관리자5', '::1', 'a', '일정 생성', '트랙경기-100m-1', '2023-01-10 14:06:18'),
	(30, 'admin5', '관리자5', '::1', 'a', '일정 생성', '트랙경기-100m-1', '2023-01-10 14:16:56'),
	(31, 'admin5', '관리자5', '::1', 'a', '일정 생성', '트랙경기-100m-1', '2023-01-10 14:17:02'),
	(32, 'admin5', '관리자5', '::1', 'a', '계정 생성', 'admin9', '2023-01-10 15:49:14'),
	(33, 'admin5', '관리자5', '220.69.240.100', 'a', '로그인', '', '2023-01-10 15:50:43'),
	(34, 'admin5', '관리자5', '220.69.240.100', 'a', '로그아웃', '', '2023-01-10 15:52:59'),
	(35, 'admin5', '관리자5', '::1', 'a', '로그인', '', '2023-01-10 15:53:05'),
	(36, 'admin5', '관리자5', '::1', 'a', '로그인', '', '2023-01-10 15:53:26'),
	(37, 'admin5', '관리자5', '::1', 'a', '로그아웃', '', '2023-01-10 15:53:51'),
	(38, 'admin5', '관리자5', '::1', 'a', '로그인', '', '2023-01-10 15:54:05'),
	(39, 'admin5', '관리자5', '::1', 'a', '로그아웃', '', '2023-01-10 15:54:48'),
	(40, 'admin5', '관리자5', '::1', 'a', '로그인', '', '2023-01-10 15:54:56'),
	(41, 'admin5', '관리자5', '::1', 'a', '로그아웃', '', '2023-01-10 15:54:59'),
	(42, 'admin5', '관리자5', '::1', 'a', '로그인', '', '2023-01-10 15:55:39'),
	(43, 'admin5', '관리자5', '::1', 'a', '로그아웃', '', '2023-01-10 16:26:40'),
	(44, 'admin5', '관리자5', '::1', 'a', '로그인', '', '2023-01-10 16:27:08'),
	(45, 'admin5', '관리자5', '::1', 'a', '로그아웃', '', '2023-01-10 16:27:15'),
	(46, 'admin5', '관리자5', '::1', 'a', '로그인', '', '2023-01-10 16:27:21'),
	(47, 'admin5', '관리자5', '::1', 'a', '로그아웃', '', '2023-01-10 16:27:24'),
	(48, 'admin5', '관리자5', '::1', 'a', '로그인', '', '2023-01-10 16:27:31'),
	(49, 'admin5', '관리자5', '::1', 'a', '계정 생성', 'admin0000', '2023-01-10 16:29:59'),
	(50, 'admin5', '관리자5', '::1', 'a', '계정 권한 수정', 'admin0000', '2023-01-10 16:30:55'),
	(51, 'admin6', '관리자6', '220.69.240.252', 'a', '로그인', '', '2023-01-11 10:21:55'),
	(52, 'admin7', 'sdsad', '220.69.240.199', 'a', '로그인', '', '2023-01-11 10:40:56'),
	(53, 'admin7', 'sdsad', '220.69.240.199', 'a', '로그인', '', '2023-01-11 11:31:24'),
	(54, 'admin5', '관리자5', '::1', 'a', '계정 권한 수정', 'admin02', '2023-01-11 11:45:09'),
	(55, 'admin5', '관리자5', '::1', 'a', '계정 권한 수정', 'admin8', '2023-01-11 11:45:17'),
	(56, 'admin5', '관리자5', '::1', 'a', '계정 권한 수정', 'admin6', '2023-01-11 11:46:15'),
	(57, 'admin7', 'sdsad', '220.69.240.199', 'a', '로그인', '', '2023-01-12 09:19:37'),
	(58, 'admin5', '관리자5', '::1', 'a', '로그인', '', '2023-01-12 09:28:19'),
	(59, 'admin5', '관리자5', '::1', 'a', '계정 생성', 'admin9', '2023-01-12 11:04:50'),
	(60, 'admin5', '관리자5', '::1', 'a', '계정 생성', 'admin9', '2023-01-12 11:20:15'),
	(61, 'admin5', '관리자5', '::1', 'a', '계정 생성', 'admin9', '2023-01-12 11:21:11'),
	(62, 'admin5', '관리자5', '::1', 'a', '계정 생성', 'admin9', '2023-01-12 11:44:47'),
	(63, 'admin5', '관리자5', '::1', 'a', '계정 생성', 'admin', '2023-01-12 12:03:17'),
	(64, 'admin5', '관리자5', '::1', 'a', '계정 생성', 'admin0101', '2023-01-12 13:34:36'),
	(65, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 생성', 'admin0202', '2023-01-12 13:34:55'),
	(66, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 생성', 'admin0202', '2023-01-12 13:36:13'),
	(67, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 생성', 'admin01', '2023-01-12 13:36:35'),
	(68, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 생성', 'admin01', '2023-01-12 13:37:52'),
	(69, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 생성', 'admin01', '2023-01-12 13:39:09'),
	(70, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 생성', 'admin01', '2023-01-12 13:39:30'),
	(71, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 생성', 'admin01', '2023-01-12 13:40:35'),
	(72, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin5', '2023-01-12 13:43:55'),
	(73, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin0101', '2023-01-12 13:48:59'),
	(74, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin0101', '2023-01-12 13:49:27'),
	(75, 'admin5', '관리자5', '127.0.0.1', 'a', '로그아웃', '', '2023-01-12 14:25:17'),
	(76, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-12 14:25:24'),
	(77, 'admin9', 'ddd', '127.0.0.1', 'a', '로그인', '', '2023-01-12 14:35:22'),
	(78, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin9', '2023-01-12 14:44:48'),
	(79, 'admin5', '관리자5', '220.69.240.252', 'a', '로그인', '', '2023-01-13 13:38:10'),
	(80, 'admin5', '관리자5', '220.69.240.252', 'a', '로그아웃', '', '2023-01-13 13:46:37'),
	(81, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-13 13:46:54'),
	(82, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin0101', '2023-01-13 16:16:51'),
	(83, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin5', '2023-01-13 16:16:51'),
	(84, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin0101', '2023-01-13 16:17:31'),
	(85, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 삭제', '24', '2023-01-13 16:18:40'),
	(86, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin8', '2023-01-16 09:19:54'),
	(87, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin2', '2023-01-16 09:20:03'),
	(88, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin1', '2023-01-16 09:20:14'),
	(89, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin02', '2023-01-16 09:20:19'),
	(90, 'admin5', '관리자5', '127.0.0.1', 'a', '로그아웃', '', '2023-01-16 09:32:01'),
	(91, 'admin7', 'sdsad', '220.69.240.199', 'a', '로그인', '', '2023-01-16 09:37:29'),
	(92, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-16 09:53:12'),
	(93, 'admin6', '관리자6', '220.69.240.252', 'a', '로그인', '', '2023-01-16 10:20:47'),
	(94, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-16 10:24:04'),
	(95, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin8', '2023-01-16 10:24:27'),
	(96, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin7', '2023-01-16 10:24:43'),
	(97, 'admin8', 'ddd', '220.69.240.250', 'a', '로그인', '', '2023-01-16 10:24:58'),
	(98, 'admin5', '관리자5', '127.0.0.1', 'a', '로그아웃', '', '2023-01-16 10:24:59'),
	(99, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-16 10:25:10'),
	(100, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 생성', 'admin10', '2023-01-16 10:35:40'),
	(102, 'admin5', '관리자5', '127.0.0.1', 'a', '계정 권한 수정', 'admin10', '2023-01-16 10:59:25'),
	(104, 'admin5', '관리자5', '127.0.0.1', 'a', '로그아웃', '', '2023-01-16 13:43:33'),
	(105, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-16 13:43:38'),
	(106, 'admin5', '관리자5', '127.0.0.1', 'a', '로그아웃', '', '2023-01-16 15:36:56'),
	(107, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-16 15:37:05'),
	(108, 'admin5', '관리자5', '127.0.0.1', 'a', '로그아웃', '', '2023-01-16 15:47:02'),
	(109, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-16 16:09:32'),
	(110, 'admin5', '관리자5', '127.0.0.1', 'a', '로그아웃', '', '2023-01-16 16:21:41'),
	(111, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-16 16:21:47'),
	(112, 'admin5', '관리자5', '127.0.0.1', 'a', '로그아웃', '', '2023-01-16 16:35:24'),
	(113, 'admin5', '관리자5', '127.0.0.1', 'a', '로그인', '', '2023-01-16 16:35:30');
/*!40000 ALTER TABLE `list_log` ENABLE KEYS */;

-- 테이블 u20_db.list_record 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_record` (
  `record_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '성적 고유넘버',
  `record_athlete_id` smallint(5) unsigned NOT NULL COMMENT '선수 고유넘버',
  `record_schedule_id` smallint(5) unsigned NOT NULL COMMENT '경기 고유넘버',
  `record_pass` enum('p','l','d','w','n') NOT NULL DEFAULT 'n' COMMENT '경기 통과(p:통과, l:탈락, d:실격, w:기권, n:시작안함)',
  `record_result` tinyint(3) unsigned NOT NULL COMMENT '경기 결과등수',
  `record_record` varchar(32) NOT NULL COMMENT '경기 성적',
  `record_new` enum('n','y') NOT NULL DEFAULT 'n' COMMENT '경기 신기록여부(n:아님, y:신기록)',
  `record_memo` varchar(64) NOT NULL COMMENT '경기 비고',
  `record_medal` smallint(5) unsigned NOT NULL COMMENT '경기 메달(10000-금, 100-은, 1-동, 0-없음)',
  `record_order` tinyint(3) unsigned NOT NULL COMMENT '선수 리스팅순서',
  `record_judge` smallint(5) unsigned NOT NULL COMMENT '성적을 작성한 심판 고유넘버',
  `record_trial` tinyint(4) DEFAULT NULL COMMENT '경기 시도 횟수',
  `record_wind` float DEFAULT NULL COMMENT '경기 풍향',
  `record_weight` float unsigned DEFAULT NULL COMMENT '경기 필드 경기 무게',
  `record_group` tinyint(5) DEFAULT NULL COMMENT '경기 팀(팀전 경기만 해당)',
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_record:~8 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_record` DISABLE KEYS */;
INSERT INTO `list_record` (`record_id`, `record_athlete_id`, `record_schedule_id`, `record_pass`, `record_result`, `record_record`, `record_new`, `record_memo`, `record_medal`, `record_order`, `record_judge`, `record_trial`, `record_wind`, `record_weight`, `record_group`) VALUES
	(1, 11, 1, 'n', 1, '10', 'n', '.', 10000, 0, 0, NULL, NULL, NULL, NULL),
	(2, 111, 1, 'n', 2, '20', 'n', '.', 100, 0, 0, NULL, NULL, NULL, NULL),
	(3, 1111, 1, 'n', 3, '30', 'n', '.', 1, 0, 0, NULL, NULL, NULL, NULL),
	(4, 11111, 1, 'n', 4, '40', 'n', '.', 0, 0, 0, NULL, NULL, NULL, NULL),
	(5, 22, 2, 'n', 1, '10', 'n', '..', 10000, 0, 0, NULL, NULL, NULL, NULL),
	(6, 222, 2, 'n', 2, '20', 'n', '..', 100, 0, 0, NULL, NULL, NULL, NULL),
	(7, 2222, 2, 'n', 3, '30', 'n', '..', 1, 0, 0, NULL, NULL, NULL, NULL),
	(8, 22222, 2, 'n', 4, '40', 'n', '..', 0, 0, 0, NULL, NULL, NULL, NULL),
	(9, 22230, 3, 'n', 1, '30', 'n', '', 100, 0, 0, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `list_record` ENABLE KEYS */;

-- 테이블 u20_db.list_schedule 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_schedule` (
  `schedule_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '경기 고유넘버',
  `schedule_sports` varchar(32) NOT NULL COMMENT '경기 종목',
  `schedule_name` varchar(64) NOT NULL COMMENT '경기 이름',
  `schedule_gender` enum('m','f','c') NOT NULL DEFAULT 'm' COMMENT '경기 성별(m:남성,f:여성,c:혼성)',
  `schedule_round` varchar(32) NOT NULL COMMENT '경기 라운드',
  `schedule_location` varchar(64) NOT NULL COMMENT '경기 장소',
  `schedule_start` datetime NOT NULL COMMENT '경기 시작시간',
  `schedule_status` enum('n','c','o','y') NOT NULL DEFAULT 'n' COMMENT '경기 상태(n:준비, c:취소됨, o:경기중, y:마감)',
  `schedule_date` datetime NOT NULL COMMENT '경기 날짜',
  `schedule_division` enum('b','s') NOT NULL DEFAULT 'b' COMMENT '경기 분류(b:대분류, s:소분류)',
  `schedule_result` enum('o','l') NOT NULL DEFAULT 'l' COMMENT '경기 결과(o:official result, l:live result)',
  PRIMARY KEY (`schedule_id`),
  UNIQUE KEY `schedule_sports` (`schedule_sports`,`schedule_name`,`schedule_gender`,`schedule_round`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_schedule:~11 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_schedule` DISABLE KEYS */;
INSERT INTO `list_schedule` (`schedule_id`, `schedule_sports`, `schedule_name`, `schedule_gender`, `schedule_round`, `schedule_location`, `schedule_start`, `schedule_status`, `schedule_date`, `schedule_division`, `schedule_result`) VALUES
	(1, '트랙경기', '100m', 'm', '1', '중앙트랙', '2023-01-03 09:19:03', 'n', '2023-01-03 09:19:09', 'b', 'l'),
	(2, '트랙경기', '200m', 'm', '2', '중앙트랙', '2023-01-03 09:19:20', 'n', '2023-01-03 09:19:22', 'b', 'l'),
	(4, '필드경기', '멀리뛰기', 'f', '1', 'A필드', '2023-06-02 00:00:00', 'n', '2023-06-02 00:00:00', 'b', 'l'),
	(5, '필드경기', '높이뛰기', 'm', '1', 'A필드', '2023-06-04 00:00:00', 'y', '2023-06-04 00:00:00', 'b', 'l'),
	(6, '필드경기', '장대높이뛰기', 'f', '3', 'B필드', '2023-06-03 00:00:00', 'n', '2023-06-03 00:00:00', 'b', 'l'),
	(7, '필드경기', '삼단뛰기', 'f', '1', 'A필드', '0000-00-00 00:00:00', 'c', '2023-06-03 00:00:00', 'b', 'l'),
	(8, '트랙경기', '200m', 'f', '1', '중앙트랙', '0000-00-00 00:00:00', 'n', '2023-06-02 00:00:00', 'b', 'l'),
	(9, '트랙경기', '400m', 'm', '1', '중앙트랙', '0000-00-00 00:00:00', 'n', '2023-06-02 00:00:00', 'b', 'l'),
	(10, '트랙경기', '800m', 'm', '2', '중앙트랙', '0000-00-00 00:00:00', 'c', '2023-06-01 00:00:00', 'b', 'l'),
	(11, '필드경기', '투포환', 'f', '1', 'B필드', '0000-00-00 00:00:00', 'n', '2023-06-01 00:00:00', 'b', 'l'),
	(12, '필드경기', '원반던지기', 'm', '1', 'A필드', '0000-00-00 00:00:00', 'n', '2023-06-02 00:00:00', 'b', 'l');
/*!40000 ALTER TABLE `list_schedule` ENABLE KEYS */;

-- 테이블 u20_db.list_sports 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_sports` (
  `sports_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '경기종목 고유번호',
  `sports_code` varchar(64) NOT NULL COMMENT '경기종목 코드',
  `sports_name` varchar(64) NOT NULL COMMENT '경기종목 이름',
  `sports_name_kr` varchar(64) NOT NULL COMMENT '경기종목 이름(한글)',
  PRIMARY KEY (`sports_id`),
  UNIQUE KEY `sports_code` (`sports_code`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_sports:~25 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_sports` DISABLE KEYS */;
INSERT INTO `list_sports` (`sports_id`, `sports_code`, `sports_name`, `sports_name_kr`) VALUES
	(1, '100m', '100m', '100m'),
	(2, '200m', '200m', '200m'),
	(3, '400m', '400m', '400m'),
	(4, '800m', '800m', '800m'),
	(5, '1500m', '1500m', '1500m'),
	(6, '3000m', '3000m', '3000m'),
	(7, '5000m', '5000m', '5000m'),
	(8, '10000m', '10000m', '10000m'),
	(9, '3000mSC', '3000m Steeplechase', '3000m 장애물'),
	(10, '100mh', '100m Hurdles', '100m 허들'),
	(11, '110mh', '110m Hurdles', '110m 허들'),
	(12, '400mh', '400m Hurdles', '400m 허들'),
	(13, 'highjump', 'High Jump', '높이뛰기'),
	(14, 'polevault', 'Pole Vault', '장대 높이뛰기'),
	(15, 'longjump', 'Long Jump', '멀리뛰기'),
	(16, 'triplejump', 'Triple Jump', '세단뛰기'),
	(17, 'shotput', 'Shot Put', '투포환'),
	(18, 'discusthrow', 'Discus Throw', '원반던지기'),
	(19, 'hammerthrow', 'Hammer Throw', '해머던지기'),
	(20, 'javelinthrow', 'Javelin Throw', '창던지기'),
	(21, 'heptathlon', 'Heptathlon', '7종경기(여)'),
	(22, 'decathlon', 'Decathlon', '10종경기(남)'),
	(23, 'racewalk', 'Race Walk', '경보'),
	(24, '4x100relay', '4x100 Relay', '4x100 릴레이'),
	(25, '4x400relay', '4x400 Relay', '4x400 릴레이');
/*!40000 ALTER TABLE `list_sports` ENABLE KEYS */;

-- 테이블 u20_db.list_worldrecord 구조 내보내기
CREATE TABLE IF NOT EXISTS `list_worldrecord` (
  `worldrecord_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '세계기록 고유번호',
  `worldrecord_sports_id` smallint(5) unsigned NOT NULL COMMENT '경기종목 고유번호',
  `worldrecord_location` varchar(256) NOT NULL COMMENT '세계기록 대회 장소',
  `worldrecord_gender` enum('m','f','c') NOT NULL DEFAULT 'm' COMMENT '선수 성별(m:남성, f:여성,c:혼성)',
  `worldrecord_athlete_name` varchar(32) NOT NULL COMMENT '세계기록 선수 이름',
  `worldrecord_athletics` enum('c','u','s','a','w') NOT NULL COMMENT '기록(a:아시아신기록, s:아시아u20신기록, w:세계신기록, u:세계u20신기록, c:대회신기록)',
  `worldrecord_wind` double unsigned NOT NULL COMMENT '풍향',
  `worldrecord_datetime` date NOT NULL COMMENT '기록 날짜',
  `worldrecord_country_code` char(3) NOT NULL COMMENT '기록자 나라 고유번호',
  `worldrecord_record` varchar(32) NOT NULL COMMENT '세계기록 성적',
  PRIMARY KEY (`worldrecord_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 테이블 데이터 u20_db.list_worldrecord:~0 rows (대략적) 내보내기
/*!40000 ALTER TABLE `list_worldrecord` DISABLE KEYS */;
/*!40000 ALTER TABLE `list_worldrecord` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
