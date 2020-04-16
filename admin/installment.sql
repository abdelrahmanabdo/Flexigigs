-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2017 at 01:10 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `installment`
--

-- --------------------------------------------------------

--
-- Table structure for table `bonds`
--

CREATE TABLE `bonds` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `contract_id` int(11) NOT NULL,
  `investor_id` int(11) NOT NULL,
  `cash_paid` int(50) NOT NULL,
  `next_date` date NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonds`
--

INSERT INTO `bonds` (`id`, `customer_id`, `contract_id`, `investor_id`, `cash_paid`, `next_date`, `created_date`) VALUES
(1, 2, 1, 1, 3000, '2017-07-19', '2017-07-29'),
(2, 1, 2, 1, 5000, '2017-07-03', '2017-07-31'),
(3, 2, 1, 1, 1000, '2017-07-17', '2017-07-31'),
(4, 1, 2, 1, 3000, '2017-07-31', '2017-07-30'),
(6, 3, 3, 1, 5500, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `callbacks`
--

CREATE TABLE `callbacks` (
  `id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `css` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `callbacks`
--

INSERT INTO `callbacks` (`id`, `module_name`, `action`, `url`, `img_url`, `css`) VALUES
(1, 'contracts', 'أضف سند', 'admin/bonds', 'http://localhost/installment/assets/grocery_crud/themes/flexigrid/css/images/add.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `calls`
--

CREATE TABLE `calls` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `price` int(50) NOT NULL,
  `salary` int(50) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `deducted` int(11) NOT NULL COMMENT 'المبلغ المخصوم',
  `loan` varchar(255) NOT NULL COMMENT 'الغرض من القرض',
  `contact` varchar(255) NOT NULL COMMENT 'طريقة التواصل'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `columns`
--

CREATE TABLE `columns` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_rename` varchar(255) NOT NULL,
  `options` varchar(5000) NOT NULL,
  `type` int(11) NOT NULL,
  `list` int(11) NOT NULL,
  `is_required` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `columns`
--

INSERT INTO `columns` (`id`, `name`, `is_rename`, `options`, `type`, `list`, `is_required`, `module_id`) VALUES
(1, 'username', 'الاسم ', '', 1, 1, 1, 1),
(2, 'identity_no', 'رقم الهوية ', '', 10, 1, 1, 1),
(3, 'age', 'العمر ', '', 10, 1, 0, 1),
(4, 'employer', 'جهة العمل ', '', 1, 1, 0, 1),
(5, 'department', 'الادارة أو القسم ', '', 1, 1, 0, 1),
(6, 'salary', 'المرتب ', '', 10, 1, 0, 1),
(7, 'job_title', 'مسمى الوظيفة ', '', 1, 1, 0, 1),
(8, 'salary_bank', 'البنك المحول عليه الراتب ', '', 1, 1, 0, 1),
(9, 'phone_1', 'هاتف رقم 1 ', '', 1, 1, 1, 1),
(10, 'phone_2', 'هاتف رقم 2', '', 1, 1, 0, 1),
(11, 'phone_3', 'هاتف رقم 3', '', 1, 1, 0, 1),
(12, 'created_date', 'تاريخ التسجيل ', '', 8, 1, 1, 1),
(13, 'status', 'الحالة', '', 5, 1, 0, 1),
(14, 'password', 'كلمة المرور ', '', 12, 1, 0, 1),
(15, 'spons_id', 'أسم الكفيل ', '', 0, 1, 0, 1),
(16, 'username', 'الاسم ', '', 1, 1, 1, 2),
(17, 'identity_no', 'رقم الهوية ', '', 10, 1, 1, 2),
(18, 'age', 'العمر ', '', 10, 1, 0, 2),
(19, 'amount_invested', 'المبلغ المستثمر ', '', 10, 1, 0, 2),
(20, 'phone_1', 'هاتف رقم 1 ', '', 1, 1, 1, 2),
(21, 'phone_2', 'هاتف رقم 2 ', '', 1, 1, 0, 2),
(22, 'phone_3', 'هاتف رقم 3 ', '', 1, 1, 0, 2),
(23, 'created_date', 'تاريخ التسجيل ', '', 8, 1, 0, 2),
(24, 'name', 'الأسم ', '', 1, 1, 1, 7),
(25, 'phone', 'الجوال', '', 1, 1, 0, 7),
(26, 'price', 'المبلغ المطلوب', '', 10, 1, 0, 7),
(27, 'salary', 'الراتب', '', 10, 1, 0, 7),
(28, 'job_title', 'المهنة', '', 1, 1, 0, 7),
(29, 'bank', 'البنك', '', 1, 1, 0, 7),
(30, 'deducted', 'المبلغ المخصوم', '', 10, 1, 0, 7),
(31, 'loan', 'الغرض من القرض', '', 1, 1, 0, 7),
(32, 'contact', 'وسيلة التواصل', 'الجوال,البريد الالكترونى,الهاتف الأرضى', 6, 1, 0, 7),
(33, 'password', 'كلمة المرور ', '', 12, 1, 0, 2),
(34, 'status', 'الحالة ', '', 5, 1, 0, 2),
(49, 'status', 'الحالة ', '', 5, 1, 0, 3),
(50, 'username', 'الأسم ', '', 1, 1, 1, 3),
(52, 'identity_no', 'رقم الهوية ', '', 10, 1, 1, 3),
(53, 'age', 'العمر ', '', 10, 1, 0, 3),
(54, 'employer', 'جهة العمل ', '', 1, 1, 0, 3),
(55, 'job_position', 'الرتبة أو المرتبة ', '', 1, 1, 0, 3),
(56, 'phone_1', 'هاتف رقم 1 ', '', 1, 1, 1, 3),
(57, 'phone_2', 'هاتف رقم 2  ', '', 1, 1, 0, 3),
(58, 'phone_3', 'هاتف رقم 3  ', '', 1, 1, 0, 3),
(59, 'created_date', 'تاريخ التسجيل ', '', 8, 1, 0, 3),
(60, 'customer_id', 'أسم العميل - رقم الهوية ', '', 0, 1, 1, 6),
(61, 'spons_id', 'أسم الكقيل - رقم الهوية ', '', 0, 1, 1, 6),
(64, 'created_date', 'تاريخ التسجيل', '', 8, 1, 0, 6),
(65, 'customer_id', 'أسم العميل - رقم الهوية ', '', 0, 1, 1, 5),
(66, 'contract_id', 'رقم العقد ', '', 0, 1, 0, 5),
(67, 'investor_id', 'أسم المستثمر - رقم الهوية ', '', 0, 1, 1, 5),
(68, 'cash_paid', 'المبلغ المدفوع ', '', 10, 1, 1, 5),
(69, 'next_date', 'تاريخ الدفع القادم', '', 8, 1, 0, 5),
(70, 'created_date', 'تاريخ التسجيل ', '', 8, 1, 0, 5),
(71, 'cust_id', 'أسم العميل - رقم الهوية ', '', 0, 1, 1, 4),
(72, 'invest_id', 'أسم المستثمر - رقم الهوية ', '', 0, 1, 1, 4),
(73, 'total', 'المبلغ المدفوع ', '', 10, 1, 1, 4),
(74, 'installment_numbers', 'عدد الأقساط ', '', 10, 1, 0, 4),
(75, 'installment_amount', 'قيمة الأقساط', '', 10, 1, 0, 4),
(76, 'installment_created_date', 'تاريخ التسجيل ', '', 8, 1, 0, 4),
(77, 'installment_next_date', 'تاريخ القسط القادم', '', 8, 1, 0, 4),
(78, 'percent', 'النسبة المتفق عليها ', '', 10, 1, 1, 2),
(79, 'email', 'البريد الألكترونى', '', 1, 1, 0, 1),
(82, 'full_name', 'الأسم الكامل ', '', 1, 1, 1, 21),
(83, 'user_name', 'أسم المستخدم ', '', 1, 1, 1, 21),
(84, 'e_mail', 'البريد الألكترونى ', '', 1, 1, 1, 21),
(85, 'password', 'كلمة المرور ', '', 12, 1, 1, 21),
(86, 'created_by', 'المسئول ', '', 1, 1, 0, 21),
(87, 'status', 'الحالة ', '', 5, 1, 0, 21),
(88, 'last_login', 'آخر دخول ', '', 9, 1, 0, 21),
(89, 'img', 'الصورة الشخصية ', '', 7, 1, 0, 21),
(90, 'role_id', 'نوع المشرف ', '', 0, 1, 0, 21),
(91, 'start_date', 'تاريخ البداية ', '', 9, 1, 1, 21),
(92, 'end_date', 'تاريخ النهاية ', '', 9, 1, 0, 21),
(93, 'created_date', 'تاريخ التسجيل ', '', 9, 1, 1, 21),
(94, 'position', 'الوظيفة ', '', 1, 1, 0, 21),
(95, 'log_start', 'وقت بداية الدخول ', '', 9, 1, 0, 21),
(96, 'log_end', 'وقت نهاية الدخول', '', 9, 1, 0, 21),
(97, 'mobile', 'الهاتف ', '', 10, 1, 0, 21),
(98, 'branch', 'الفرع ', '', 1, 1, 0, 21),
(99, 'barcode', 'باركود ', '', 10, 0, 0, 21),
(100, 'email', 'البريد الالكترونى ', '', 12, 1, 0, 2),
(101, 'email', 'البريد الالكترونى ', '', 12, 1, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `invest_id` int(11) NOT NULL,
  `total` int(50) NOT NULL COMMENT 'المبلغ',
  `percent` varchar(3) NOT NULL,
  `installment_numbers` int(50) NOT NULL COMMENT 'عدد الأقساط',
  `installment_amount` int(50) NOT NULL COMMENT 'قيمة الأقساط',
  `installment_created_date` date NOT NULL COMMENT 'تاريخ أول قسط',
  `installment_next_date` date NOT NULL COMMENT 'تاريخ القسط القادم',
  `validity` int(11) NOT NULL COMMENT 'منتهى - غير منتهى'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `cust_id`, `invest_id`, `total`, `percent`, `installment_numbers`, `installment_amount`, `installment_created_date`, `installment_next_date`, `validity`) VALUES
(1, 3, 1, 5000, '15', 5, 2, '2017-07-25', '2017-07-17', 0),
(2, 1, 1, 9000, '8', 8, 3, '2017-07-25', '2017-07-17', 1),
(3, 1, 1, 6000, '6', 8, 3, '2017-07-25', '2017-07-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `identity_no` int(100) NOT NULL,
  `age` int(3) NOT NULL,
  `spons_id` int(11) NOT NULL,
  `employer` varchar(255) NOT NULL COMMENT 'جهة العمل',
  `department` varchar(255) NOT NULL,
  `salary` int(50) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `salary_bank` varchar(255) NOT NULL COMMENT 'البنك المحول عليه الراتب',
  `phone_1` int(50) NOT NULL,
  `phone_2` int(50) NOT NULL,
  `phone_3` int(50) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `status`, `username`, `email`, `password`, `identity_no`, `age`, `spons_id`, `employer`, `department`, `salary`, `job_title`, `salary_bank`, `phone_1`, `phone_2`, `phone_3`, `created_date`) VALUES
(1, 1, 'ramez', '', 'd9b1d7db4cd6e70935368a1efb10e377', 516516, 21, 1, 'ddddd', 'bfb', 561, 'fewf', 'fsdf', 45165, 0, 4165, '2017-07-12'),
(2, 0, 'shawky', '', 'd9b1d7db4cd6e70935368a1efb10e377', 5612, 65, 2, 'ngh', 'ngh', 451, 'ngh', 'ngh', 4651, 165, 62, '2017-07-17'),
(3, 0, 'tamer', '', '1234', 5612, 65, 2, 'ngh', 'ngh', 451, 'ngh', 'ngh', 4651, 165, 62, '2017-07-17'),
(4, 1, 'tamer2', 'tamer2@h.com', '405bc4f8442f634828d45d95c9fd700e', 6556, 65, 1, 'gfver', 'bfd', 65262, 'bdf', 'bd', 5, 0, 0, '2017-07-19');

-- --------------------------------------------------------

--
-- Table structure for table `investor`
--

CREATE TABLE `investor` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `identity_no` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `amount_invested` int(50) NOT NULL COMMENT 'فى اضافة المستثمر',
  `phone_1` int(50) NOT NULL,
  `phone_2` int(50) NOT NULL,
  `phone_3` int(50) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `investor`
--

INSERT INTO `investor` (`id`, `status`, `username`, `email`, `password`, `identity_no`, `age`, `amount_invested`, `phone_1`, `phone_2`, `phone_3`, `created_date`) VALUES
(1, 1, 'hifny', '', 'd9b1d7db4cd6e70935368a1efb10e377', '987654', 23, 10000, 645, 65, 98456, '2017-07-17'),
(2, 1, 'karem', '', 'd9b1d7db4cd6e70935368a1efb10e377', '987654', 23, 18000, 645, 65, 98456, '2017-07-17');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `the_name` varchar(255) NOT NULL,
  `icon_name` varchar(255) NOT NULL,
  `is_where` text NOT NULL,
  `is_join` varchar(5000) NOT NULL,
  `is_sort` varchar(255) NOT NULL,
  `order_by` varchar(10) NOT NULL,
  `is_limit` int(11) NOT NULL,
  `offset` int(11) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `buttons` varchar(255) NOT NULL,
  `unset` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `url`, `the_name`, `icon_name`, `is_where`, `is_join`, `is_sort`, `order_by`, `is_limit`, `offset`, `table_name`, `buttons`, `unset`) VALUES
(1, 'customers', 'العملاء', 'notebook', '[]', '[{\"table\":\"sponsors\",\"cond1\":\"spons_id\",\"cond2\":\"username\",\"type\":\"left\"}]', '', '', 0, 0, 'customers', '[]', '[]'),
(2, 'investor', 'المستثمر', 'briefcase', '[]', '[]', '', '', 0, 0, 'investor', '[]', '[\"\"]'),
(3, 'sponsors', 'الكفيل', 'users', '[]', '[]', '', '', 0, 0, 'sponsors', '[]', '[\"\"]'),
(6, 'orders', 'طلب مبدئى', 'pencil', '[]', '[{\"table\":\"customers\",\"cond1\":\"customer_id\",\"cond2\":\"{identity_no} - {username} \",\"type\":\"left\"},{\"table\":\"sponsors\",\"cond1\":\"spons_id\",\"cond2\":\"{identity_no}  - {username} \",\"type\":\"left\"}]', '', '', 0, 0, 'requests', '[]', '[]'),
(7, 'calls', 'المكالمات', 'call-end', '[]', '[]', '', '', 0, 0, 'calls', '[]', '[]');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `spons_id` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `customer_id`, `spons_id`, `created_date`) VALUES
(1, 3, 2, '2017-07-11'),
(2, 1, 2, '2017-06-13');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Editor');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `perm_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `type`) VALUES
(1, 'site_name_ar', 'هاف بوكد', 0),
(2, 'site_name_en', 'HaveBooked', 0),
(3, 'meta_description_ar', 'ورشتي تطبيق لعرض مراكز الصيانة في مدن السعودية', 1),
(4, 'meta_description_en', 'Have Booked you don`t worry', 1),
(5, 'meta_keywords_ar', '', 2),
(6, 'meta_keywords_en', '', 2),
(7, 'land_line', '0112365478', 0),
(8, 'address_ar', 'طريق الأمير بندر بن عبدالعزيز', 1),
(9, 'address_en', '300 Sudan ', 1),
(10, 'email', 'info@warshity.com', 0),
(16, 'mobile', '01112345678', 0),
(17, 'fax', '002.02.33451199', 0),
(18, 'footer', 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ... وعند موافقه العميل المبدئيه على التصميم يتم ازالة هذا النص من التصميم ويتم وضع النصوص النهائية المطلوبة للتصميم ويقول البعض ان وضع النصوص التجريبية بالتصميم قد تشغل المشاهد عن وضع الكثير من الملاحظات او الانتقادات للتصميم الاساسي.', 1),
(19, 'footer_en', 'Nile Multimedia is an Egyptian Limited Liability Company and in accordance with the provisions Act 159 of 1981, Ratified by the General Authority for Investment No. 1309 of 2007, Commercial No. 27762 and Tax card No. 266-680-976. The Enterprise oversees a group of specialists in the areas of the business activities with a history of professional', 1),
(20, 'blog', '#', 0),
(21, 'youtube', '#', 0),
(22, 'instgram', '#', 0),
(23, 'twitter', '#', 0),
(24, 'facebook', '#', 0),
(25, 'critical_currency', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `identity_no` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `employer` varchar(255) NOT NULL COMMENT 'جهة العمل',
  `job_position` varchar(255) NOT NULL,
  `phone_1` int(50) NOT NULL,
  `phone_2` int(50) NOT NULL,
  `phone_3` int(50) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `status`, `username`, `email`, `identity_no`, `age`, `employer`, `job_position`, `phone_1`, `phone_2`, `phone_3`, `created_date`) VALUES
(1, 1, 'karem', '', '5522', 45, 'karem 25', 'ghm', 14, 0, 0, '2017-07-18'),
(2, 1, 'shady', '', '65165', 54, 'shady 25', 'mmhm', 48417, 1432, 27417, '2017-07-13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(30) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `e_mail` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `img` varchar(255) NOT NULL,
  `role_id` int(1) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  `position` varchar(300) NOT NULL,
  `log_start` time NOT NULL,
  `log_end` time NOT NULL,
  `mobile` varchar(300) NOT NULL,
  `branch` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `user_name`, `e_mail`, `password`, `created_by`, `status`, `last_login`, `img`, `role_id`, `start_date`, `end_date`, `created_date`, `position`, `log_start`, `log_end`, `mobile`, `branch`, `barcode`) VALUES
(1, 'ahmed hifny', 'code', 'ahmed.hefny@mod-sa.com', '878b3c5b9f1887aa74130b03894d23cf', '', '1', '2017-05-07 00:47:22', 'sentPhoto.jpg', 1, '2015-08-01 00:00:00', '2017-07-31 00:00:00', '0000-00-00 00:00:00', 'web developer', '00:00:00', '00:00:00', '01062424309', 0, ''),
(2, 'vbnvb', 'adsdasd', 'nbvnbvnv@sad.da', 'd9b1d7db4cd6e70935368a1efb10e377', 'code', '1', '2017-05-30 10:52:55', 'ad1df-7.jpg', 2, '2017-05-16 00:00:00', '2017-05-26 00:00:00', '2017-05-30 00:00:00', 'dsad', '02:00:00', '03:00:00', 'nvbnvbnvbnnn', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `perm_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `user_id`, `perm_id`) VALUES
(803, 5, 350),
(804, 7, 338),
(788, 6, 338),
(787, 6, 259),
(802, 5, 349),
(801, 5, 348),
(800, 5, 347),
(799, 5, 346),
(798, 5, 345),
(797, 5, 343),
(796, 5, 342),
(795, 5, 337),
(794, 5, 355),
(793, 5, 261),
(792, 5, 302);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bonds`
--
ALTER TABLE `bonds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `callbacks`
--
ALTER TABLE `callbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calls`
--
ALTER TABLE `calls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `columns`
--
ALTER TABLE `columns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investor`
--
ALTER TABLE `investor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bonds`
--
ALTER TABLE `bonds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `callbacks`
--
ALTER TABLE `callbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `calls`
--
ALTER TABLE `calls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `columns`
--
ALTER TABLE `columns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `investor`
--
ALTER TABLE `investor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=805;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
