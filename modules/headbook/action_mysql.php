<?php

/**
 * @Project TMS HOLDINGS
 * @Author Ho Anh Tuan <anhtuana2k422001@gmail.com>
 * @Copyright (C) 2022 Ho Anh Tuan. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 27 Nov 2022 09:22:25 GMT
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_organizations";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_department";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_schools";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_grade";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_teacher";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_times";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_class";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_subjects";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_lessons";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_distribution";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_year";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_week";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_headbook";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_contents";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_summary";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_setting";

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_organizations (
  organizations_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã sở giáo dục',
  organization_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên sở giáo dục',
  add_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian thêm',
  update_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (organizations_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_department (
  department_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã phòng đào tạo',
  department_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên phòng đào tạo',
  organizations_id smallint(4) NOT NULL COMMENT 'Mã sở giáo dục',
  add_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian thêm',
  update_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (department_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_schools (
  school_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã trường',
  school_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên trường',
  department_id smallint(4) NOT NULL COMMENT 'Mã phòng đào tạo',
  add_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian thêm',
  update_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (school_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_grade (
  grade_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã khối',
  grade_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên khối',
  school_id smallint(4) NOT NULL COMMENT 'Mã trường',
  add_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian thêm',
  update_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (grade_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_teacher (
  teacher_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã giáo viên',
  userid mediumint(8) NOT NULL COMMENT 'Mã tài khoản',
  teacher_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên giáo viên',
  status tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái',
  add_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian thêm',
  update_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (teacher_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_times (
  times_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã môn học',
  times_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Số thứ tự tiết',
  minutes smallint(4) NOT NULL DEFAULT 45 COMMENT 'Số phút',
  PRIMARY KEY (times_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_class (
  class_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã lớp',
  class_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên lớp',
  grade_id smallint(4) NOT NULL COMMENT 'Mã khối',
  amount smallint(4) NOT NULL DEFAULT 0 COMMENT 'Sĩ số',
  teacher_id smallint(4) NOT NULL COMMENT 'Mã giáo viên',
  add_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian thêm',
  update_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (class_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_subjects (
  subject_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã môn học',
  subject_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên môn học',
  status tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái',
  add_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian thêm',
  update_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (subject_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_lessons (
  lesson_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã bài học',
  lesson_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên bài học',
  status tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái',
  add_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian thêm',
  update_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (lesson_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_distribution (
  distribution_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã phân PPCT',
  times_id tinyint(4) NOT NULL COMMENT 'Mã tiết',
  lesson_id smallint(4) NOT NULL COMMENT 'Mã bài học',
  subject_id smallint(4) NOT NULL COMMENT 'Mã môn học',
  grade_id smallint(4) NOT NULL COMMENT 'Mã khối',
  year_id smallint(4) NOT NULL COMMENT 'Mã năm',
  PRIMARY KEY (distribution_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_year (
  year_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã năm',
  year_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên năm học',
  description varchar(200) NOT NULL DEFAULT '' COMMENT 'Mô tả',
  PRIMARY KEY (year_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_week (
  week_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã tuần ',
  week_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tuần',
  start_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian bắt đầu',
  end_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian kết thúc',
  description varchar(200) NOT NULL DEFAULT '' COMMENT 'Mô tả',
  year_id smallint(4) NOT NULL DEFAULT 0 COMMENT 'Mã năm',
  status tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái',
  PRIMARY KEY (week_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_headbook (
  headbook_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã sổ đầu bài',
  headbook_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên sổ đầu bài ',
  class_id smallint(4) NOT NULL COMMENT 'Mã lớp',
  year_id int(4) NOT NULL COMMENT 'Mã năm',
  status tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái',
  add_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian thêm',
  update_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (headbook_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_contents (
  content_id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Mã nội dung',
  headbook_id smallint(4) NOT NULL COMMENT 'Mã sổ đầu bài',
  week_id smallint(4) NOT NULL COMMENT 'Mã tuần',
  order_name smallint(4) NOT NULL COMMENT 'Thứ',
  session tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Buổi',
  times smallint(4) NOT NULL COMMENT 'STT Tiết',
  subject_id smallint(4) NOT NULL COMMENT 'Mã môn học',
  times_id tinyint(4) NOT NULL COMMENT 'Mã tiết',
  lesson_id smallint(4) NOT NULL COMMENT 'Mã bài học',
  comment varchar(200) NOT NULL DEFAULT '' COMMENT 'Nhận xét',
  point smallint(4) NOT NULL COMMENT 'Điểm',
  teacher_id smallint(4) NOT NULL COMMENT 'Mã giáo viên',
  PRIMARY KEY (content_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_summary (
  summary_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã tổng kết tuần',
  week_id smallint(4) NOT NULL COMMENT 'Mã tuần',
  headbook_id smallint(4) NOT NULL COMMENT 'Mã sổ đầu bài',
  headmaster_id smallint(4) NOT NULL COMMENT 'Mã gv chủ nhiệm',
  comment varchar(200) NOT NULL DEFAULT '' COMMENT 'Nhận xét',
  add_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian thêm',
  update_time int(11) NOT NULL DEFAULT 0 COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (summary_id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_setting (
  setting_id smallint(4) NOT NULL AUTO_INCREMENT COMMENT 'Mã cấu hình ',
  setting_name varchar(200) NOT NULL DEFAULT '' COMMENT 'Tên cấu hình',
  status tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái',
  PRIMARY KEY (setting_id)
) ENGINE=MyISAM;";


// +++++++++++++++++++++++++++ Thêm dữ liệu mẫu +++++++++++++++++++++++++++

/* Sở GD&ĐT  */
$sql_create_module[] = "INSERT INTO `nv4_headbook_organizations` (`organizations_id`, `organization_name`, `add_time`, `update_time`) VALUES
(1, 'Sở GD&ĐT TP.HCM', 1669482000, 1669482000),
(2, 'Sở GD&ĐT Hà Nội', 1669482000, 1668963600),
(3, 'Sở GD&ĐT Nghệ An', 1669482000, 1668963600)";

/* Phòng GD&ĐT  */
$sql_create_module[] = "INSERT INTO `nv4_headbook_department` (`department_id`, `department_name`, `organizations_id`, `add_time`, `update_time`) VALUES
(1, 'Phòng GD&ĐT Thành phố Vinh', 3, 1669568400, 1669568400),
(2, 'Phòng GD&ĐT Huyện Quỳnh Lưu', 3, 1669568400, 1669568400),
(3, 'Phòng GD&ĐT Thị xã Cửa Lò', 3, 1669568400, 1669568400)";


/* Trường  */
$sql_create_module[] = "INSERT INTO `nv4_headbook_schools` (`school_id`, `school_name`, `department_id`, `add_time`, `update_time`) VALUES
(1, 'Trường THPT Quỳnh Lưu 1', 2, 1669568400, 1669568400),
(2, 'Trường THPT Quỳnh Lưu 2', 2, 1669568400, 1669568400),
(3, 'Trường THPT Quỳnh Lưu 3', 2, 1669568400, 1669568400),
(4, 'Trường THPT Quỳnh Lưu 4', 2, 1669568400, 1669568400)";

/* khối*/
$sql_create_module[] = "INSERT INTO `nv4_headbook_grade` (`grade_id`, `grade_name`, `school_id`, `add_time`, `update_time`) VALUES
(1, 'Khối 10', 4, 1669568400, 1669568400),
(2, 'Khối 11', 4, 1669568400, 1669568400),
(3, 'Khối 12', 4, 1669568400, 1669568400)";

/* Tài khoản  */
// $sql_create_module[] = "INSERT INTO `nv4_users` (`userid`, `group_id`, `username`, `md5username`, `password`, `email`, `first_name`, `last_name`, `gender`, `photo`, `birthday`, `sig`, `regdate`, `question`, `answer`, `passlostkey`, `view_mail`, `remember`, `in_groups`, `active`, `active2step`, `secretkey`, `checknum`, `last_login`, `last_ip`, `last_agent`, `last_openid`, `last_update`, `idsite`, `safemode`, `safekey`, `email_verification_time`, `active_obj`) VALUES
// (2, 3, 'hoanhtuan', '7b2cc47330e28464b7d1b80da9a8f1e1', '{SSHA512}CbR4Zsii4HdOpLJBZLtP1J2VLxdVc2VOmgi5GQlZAQ8xMVW5eYNg+EPE2bMyO9Zy2N73Bid+ERhAwy7j2YbYFzI1YjI=', 'anhtuana2k422001@gmail.com', 'Tuấn', 'Hồ Anh', 'M', 'uploads/users/avata_hoanhtuan_s2bqgoch_1.jpg', 978886800, 'tuấn', 1669650066, 'Cầu thủ yếu thích nhất', 'ronaldo', '', 0, 1, '3,4', 1, 0, '', '4dadbb8a8efa83df4d36b2c13694c883', 1669650319, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '', 1669655077, 0, 0, '', 0, 'SYSTEM'),
// (3, 3, 'nguyenhaiduong', 'b34ebdf72d9213357c061064b61d6fb3', '{SSHA512}AHgMUprZA+z1Rad4Ke/+rQgXTA7GC+A1vGNGlsK1M6Q8aaCdMuiL/afCYrKk0SHaw4DQyaOuCkzLGCp8RkAjh2NiYWM=', 'nguyenhaiduong190801@gmail.com', 'Dương', 'Nguyễn Hải', 'M', 'uploads/users/pngtree-cartoon-flat-math-teacher-avatar-design-png-image_4429178_s1ulda35_1.jpg', 998154000, 'dương', 1669654982, 'Cầu thủ yếu thích nhất', 'ronaldo', '', 0, 1, '3,4', 1, 0, '', '', 0, '', '', '', 1669655139, 0, 0, '', -1, 'SYSTEM'),
// (4, 3, 'voanhquan', '16c2c1c20d2c61d8f1a37a2eb2792b87', '{SSHA512}bBER00/is5ee8cK3rWBfsFC1KdTCMjqkKnkNXRPn9rPGJeItPp6Q7HAGGkwPVar1lfJcxY70SP3+s8I7rI2YjDU5NTM=', '01642027120q@gmail.com', 'Quân', 'Võ Anh', 'M', 'uploads/users/pngtree-cartoon-flat-math-teacher-avatar-design-png-image_4429178_z181rzaw_1.jpg', 1003770000, 'quân', 1669659205, 'Cầu thủ yếu thích nhất', 'ronaldo', '', 0, 1, '4,3', 1, 0, '', '', 0, '', '', '', 0, 0, 0, '', -1, 'SYSTEM')";

/* Giáo viên  */
$sql_create_module[] = "INSERT INTO `nv4_headbook_teacher` (`teacher_id`, `userid`, `teacher_name`, `status`, `add_time`, `update_time`) VALUES
(2, 3, 'Nguyễn Hải Dương', 1, 1669568400, 1669568400),
(3, 4, 'Võ Anh Quân', 1, 1669568400, 1669568400),
(4, 2, 'Hồ Anh tuấn', 1, 1669568400, 1669568400)";

/* Tiết dạy  */
$sql_create_module[] = "INSERT INTO `nv4_headbook_times` (`times_id`, `times_name`, `minutes`) VALUES
(1, 'Tiết 1', 45),
(2, 'Tiết 2', 45),
(3, 'Tiết 3', 45),
(4, 'Tiết 4', 45),
(5, 'Tiết 5', 45),
(6, 'Tiết 6', 45),
(7, 'Tiết 7', 45),
(8, 'Tiết 8', 45),
(9, 'Tiết 9', 45),
(10, 'Tiết 10', 45),
(11, 'Tiết 11', 45),
(12, 'Tiết 12', 45),
(13, 'Tiết 13', 45),
(14, 'Tiết 14', 45),
(15, 'Tiết 15', 45),
(16, 'Tiết 16', 45),
(17, 'Tiết 17', 45),
(18, 'Tiết 18', 45),
(19, 'Tiết 19', 45),
(20, 'Tiết 20', 45),
(21, 'Tiết 21', 45),
(22, 'Tiết 22', 45),
(23, 'Tiết 23', 45),
(24, 'Tiết 24', 45),
(25, 'Tiết 25', 45),
(26, 'Tiết 26', 45),
(27, 'Tiết 27', 45),
(28, 'Tiết 28', 45),
(29, 'Tiết 29', 45),
(30, 'Tiết 30', 45)";

/* Lớp học  */
$sql_create_module[] = "INSERT INTO `nv4_headbook_class` (`class_id`, `class_name`, `grade_id`, `amount`, `teacher_id`, `add_time`, `update_time`) VALUES
(1, 'Lớp 12A1', 3, 34, 4, 1670000400, 1670000400),
(3, 'Lớp 11A1', 2, 32, 3, 1670000400, 1670000400),
(4, 'Lớp 10A1', 1, 35, 2, 1670000400, 1670000400),
(5, 'Lớp 12A2', 3, 34, 4, 1670346000, 1670346000),
(6, 'Lớp 12A3', 3, 32, 3, 1670346000, 1670346000),
(7, 'Lớp 12A4', 3, 34, 2, 1670346000, 1670346000),
(8, 'Lớp 12A5', 3, 35, 4, 1670346000, 1670346000),
(9, 'Lớp 12A6', 3, 44, 3, 1670346000, 1670346000),
(10, 'Lớp 12A7', 3, 36, 2, 1670346000, 1670346000),
(11, 'Lớp 12A8', 3, 35, 4, 1670346000, 1670346000),
(13, 'Lớp 12A9', 3, 35, 4, 1670346000, 1670346000),
(14, 'Lớp 12A10', 3, 36, 3, 1670346000, 1670346000),
(15, 'Lớp 11A2', 2, 34, 4, 1670346000, 1670346000),
(16, 'Lớp 11A3', 2, 23, 3, 1670346000, 1670346000),
(17, 'Lớp 11A4', 2, 24, 2, 1670346000, 1670346000),
(18, 'Lớp 11A5', 2, 36, 4, 1670346000, 1670346000),
(19, 'Lớp 11A6', 2, 43, 4, 1670346000, 1670346000),
(20, 'Lớp 11A7', 2, 34, 3, 1670346000, 1670346000),
(21, 'Lớp 11A8', 2, 23, 2, 1670346000, 1670346000),
(22, 'Lớp 11A9', 2, 42, 4, 1670346000, 1670346000),
(23, 'Lớp 11A10', 2, 34, 2, 1670346000, 1670346000),
(24, 'Lớp 10A2', 1, 35, 2, 1670346000, 1670346000),
(25, 'Lớp 10A3', 1, 42, 3, 1670346000, 1670346000),
(26, 'Lớp 10A4', 1, 42, 4, 1670346000, 1670346000),
(27, 'Lớp 10A5', 1, 35, 4, 1670346000, 1670346000),
(28, 'Lớp 10A6', 1, 31, 4, 1670346000, 1670346000),
(29, 'Lớp 10A7', 1, 42, 3, 1670346000, 1670346000),
(30, 'Lớp 10A8', 1, 35, 2, 1670346000, 1670346000),
(31, 'Lớp 10A9', 1, 32, 4, 1670346000, 1670346000),
(32, 'Lớp 10A10', 1, 31, 4, 1670346000, 1670346000)";

/* Môn học  */
$sql_create_module[] = "INSERT INTO `nv4_headbook_subjects` (`subject_id`, `subject_name`, `status`, `add_time`, `update_time`) VALUES
(1, 'Tin học lớp 12', 1, 1670000400, 1670000400),
(2, 'Công nghệ lớp 12', 1, 1670000400, 1670000400),
(3, 'Sinh học Lớp 12', 1, 1670000400, 1670000400),
(4, 'Vật Lý Lớp 12', 1, 1670000400, 1670000400),
(5, 'Hóa học Lớp 12', 1, 1670000400, 1670000400),
(6, 'Lịch Sử lớp 12', 1, 1670000400, 1670000400),
(7, 'Địa Lý lớp 12', 1, 1670000400, 1670000400),
(8, 'GDCD lớp 12', 1, 1670000400, 1670000400),
(9, 'Toán học lớp 12', 1, 1670000400, 1670000400),
(10, 'Ngoại ngữ lớp 12', 1, 1670000400, 1670000400),
(11, 'Ngữ văn lớp 12', 1, 1670000400, 1670000400)";

/* Bài học  */
$sql_create_module[] = "INSERT INTO `nv4_headbook_lessons` (`lesson_id`, `lesson_name`, `status`, `add_time`, `update_time`) VALUES
(1, 'Đọc văn. KHÁI QUÁT VĂN HỌC VIỆT NAM  TỪ CÁCH MẠNG THÁNG TÁM NĂM 1945 ĐẾN HẾT THẾ KỈ XX', 1, 1670000400, 1670000400),
(2, 'Làm văn. NGHỊ LUẬN VỀ MỘT TƯ TƯỞNG, ĐẠO LÍ', 1, 1670000400, 1670000400),
(3, 'Đọc văn. TUYÊN NGÔN ĐỘC LẬP - HỒ CHÍ MINH', 1, 1670000400, 1670000400),
(4, 'Tiếng Việt. GIỮ GÌN SỰ TRONG SÁNG CỦA TIẾNG VIỆT', 1, 1670000400, 1670000400),
(5, 'Làm văn. BÀI LÀM VĂN SỐ 1 (NGHỊ LUẬN XÃ HỘI)', 1, 1670000400, 1670000400),
(6, 'Đọc văn. TUYÊN NGÔN ĐỘC LẬP (Hồ Chí Minh) (Phần 2. TÁC PHẨM)', 1, 1670000400, 1670000400),
(7, 'Tiếng Việt.  GIỮ GÌN SỰ TRONG SÁNG CỦA TIẾNG VIỆT (tiếp)', 1, 1670000400, 1670000400),
(8, 'Đọc văn.  NGUYỄN ĐÌNH CHIỂU, NGÔI SAO SÁNG TRONG VĂN NGHỆ CỦA DÂN TỘC', 1, 1670000400, 1670000400),
(9, 'Bài 1. Sự đồng biến, nghich biến của hàm số', 1, 1670000400, 1670000400),
(10, 'Bài 2. Cực trị của hàm số', 1, 1670000400, 1670000400),
(11, 'Bài 3. Giá trị lớn nhất và giá trị nhỏ nhất của hàm số', 1, 1670000400, 1670000400),
(12, 'Bài 4. Đường tiệm cận', 1, 1670000400, 1670000400),
(13, 'Bài 5. Khảo sát sự biến thiên và vẽ đồ thị của hàm số', 1, 1670000400, 1670000400),
(14, 'Bài 1. Kim loại kiềm', 1, 1670346000, 1670346000),
(15, 'Bài 2. Kim loại kiềm thổ và một số hợp chất quan trọng của kim loại kiềm thổ', 1, 1670346000, 1670346000),
(16, 'Bài 3. Luyện tập: Tính chất của kim loại kiềm, kim loại kiềm thổ và hợp chất của chúng', 1, 1670346000, 1670346000),
(17, 'Bài 4. Nhôm và một số hợp chất quan trọng của nhôm', 1, 1670346000, 1670346000),
(18, 'Bài 5. Luyện tập: Tính chất của nhôm và hợp chất của nhôm', 1, 1670346000, 1670346000),
(19, 'Bài 1. Ôn tập/ Kiểm tra đầu năm', 1, 1670346000, 1670346000),
(20, 'Bài 2. Unit 1: Reading', 1, 1670346000, 1670346000),
(21, 'Bài 3. Speaking: gộp Task 2, Task 3 thành 1 Hoạt động', 1, 1670346000, 1670346000),
(22, 'Bài 4.Tự chọn 1- Reading- Home Life', 1, 1670346000, 1670346000),
(23, 'Bài 5. Listening', 1, 1670346000, 1670346000),
(24, 'Bài 1. Dao động điều hòa', 1, 1670346000, 1670346000),
(25, 'Bài 2. Bài tập', 1, 1670346000, 1670346000),
(26, 'Bài 3. Con lắc lò xo', 1, 1670346000, 1670346000),
(27, 'Bài 4. Bài tập', 1, 1670346000, 1670346000),
(28, 'Bài 5. Con lắc đơn', 1, 1670346000, 1670346000)";

/* Năm học*/
$sql_create_module[] = "INSERT INTO `nv4_headbook_year` (`year_id`, `year_name`, `description`) VALUES
(1, '2022 - 2023', 'Năm học 2022- 2023'),
(2, '2021 - 2022', 'Năm học 2021- 2022')";

/* Tuần*/
$sql_create_module[] = "INSERT INTO `nv4_headbook_week` (`week_id`, `week_name`, `start_time`, `end_time`, `description`, `year_id`, `status`) VALUES
(1, 'Tuấn 1', 1669568400, 1670000400, 'Tuần 1', 1, 1),
(2, 'Tuấn 2', 1670173200, 1670605200, 'Tuần 2', 1, 1),
(3, 'Tuấn 3', 1670778000, 1671210000, 'Tuần 3', 1, 1),
(4, 'Tuấn 4', 1671382800, 1671814800, 'Tuần 4', 1, 1),
(5, 'Tuấn 5', 1671987600, 1672419600, 'Tuần 5', 1, 1)";

/* Phân phối chương trình */
$sql_create_module[] = "INSERT INTO `nv4_headbook_distribution` (`distribution_id`, `times_id`, `lesson_id`, `subject_id`, `grade_id`, `year_id`) VALUES
(1, 1, 1, 11, 3, 1),
(2, 2, 1, 11, 3, 1),
(3, 3, 2, 11, 3, 1),
(4, 4, 3, 11, 3, 1),
(5, 5, 4, 11, 3, 1),
(6, 6, 5, 11, 3, 1),
(7, 7, 6, 11, 3, 1),
(8, 8, 6, 11, 3, 1),
(9, 9, 7, 11, 3, 1),
(10, 10, 8, 10, 3, 1),
(11, 1, 9, 9, 3, 1),
(12, 2, 10, 9, 3, 1),
(13, 3, 11, 9, 3, 1),
(14, 4, 12, 9, 3, 1),
(15, 1, 14, 5, 3, 1),
(16, 2, 15, 5, 3, 1),
(17, 3, 16, 5, 3, 1),
(18, 4, 17, 5, 3, 1),
(19, 5, 18, 5, 3, 1),
(20, 1, 19, 10, 3, 1),
(21, 2, 20, 10, 3, 1),
(22, 3, 21, 10, 3, 1),
(23, 4, 22, 10, 3, 1),
(24, 5, 23, 10, 3, 1),
(25, 1, 24, 4, 3, 1),
(26, 2, 25, 4, 3, 1),
(27, 3, 26, 4, 3, 1),
(28, 4, 27, 4, 3, 1),
(29, 5, 28, 4, 3, 1)";


/* Sổ đầu bài */
$sql_create_module[] = "INSERT INTO `nv4_headbook_headbook` (`headbook_id`, `headbook_name`, `class_id`, `year_id`, `status`, `add_time`, `update_time`) VALUES
(1, 'SĐB lớp 12A1', 1, 1, 1, 1670086800, 1670086800),
(2, 'SĐB lớp 11A1', 3, 1, 1, 1670086800, 1670086800),
(3, 'SĐB lớp 10A1', 4, 1, 1, 1670086800, 1670086800),
(4, 'SĐB lớp 12A2', 5, 1, 1, 1670346000, 1670346000),
(5, 'SĐB lớp 12A3', 6, 1, 1, 1670346000, 1670346000),
(6, 'SĐB lớp 12A4', 7, 1, 1, 1670346000, 1670346000),
(7, 'SĐB lớp 12A5', 8, 1, 1, 1670346000, 1670346000),
(8, 'SĐB lớp 12A6', 9, 1, 1, 1670346000, 1670346000),
(9, 'SĐB lớp 12A7', 10, 1, 1, 1670346000, 1670346000),
(10, 'SĐB lớp 12A8', 11, 1, 1, 1670346000, 1670346000),
(11, 'SĐB lớp 12A9', 13, 1, 1, 1670346000, 1670346000),
(12, 'SĐB lớp 12A10', 14, 1, 1, 1670346000, 1670346000),
(13, 'SĐB lớp 11A2', 15, 1, 1, 1670346000, 1670346000),
(14, 'SĐB lớp 11A3', 16, 1, 1, 1670346000, 1670346000),
(15, 'SĐB lớp 11A4', 17, 1, 1, 1670346000, 1670346000),
(16, 'SĐB lớp 11A5', 18, 1, 1, 1670346000, 1670346000),
(17, 'SĐB lớp 11A6', 19, 1, 1, 1670346000, 1670346000),
(18, 'SĐB lớp 11A7', 20, 1, 1, 1670346000, 1670346000),
(19, 'SĐB lớp 11A8', 21, 1, 1, 1670346000, 1670346000),
(20, 'SĐB lớp 11A9', 22, 1, 1, 1670346000, 1670346000),
(21, 'SĐB lớp 11A10', 23, 1, 1, 1670346000, 1670346000),
(22, 'SĐB lớp 10A2', 24, 1, 1, 1670346000, 1670346000),
(23, 'SĐB lớp 10A3', 25, 1, 1, 1670346000, 1670346000),
(24, 'SĐB lớp 10A4', 26, 1, 1, 1670346000, 1670346000),
(25, 'SĐB lớp 10A5', 27, 1, 1, 1670346000, 1670346000),
(26, 'SĐB lớp 10A6', 28, 1, 1, 1670346000, 1670346000),
(27, 'SĐB lớp 10A7', 29, 1, 1, 1670346000, 1670346000),
(28, 'SĐB lớp 10A8', 30, 1, 1, 1670346000, 1670346000),
(29, 'SĐB lớp 10A9', 31, 1, 1, 1670346000, 1670346000),
(30, 'SĐB lớp 10A10', 32, 1, 1, 1670346000, 1670346000)";

/* Nội dung sổ đầu bài */
$sql_create_module[] = "INSERT INTO `nv4_headbook_contents` (`content_id`, `headbook_id`, `week_id`, `order_name`, `session`, `times`, `subject_id`, `times_id`, `lesson_id`, `comment`, `point`, `teacher_id`) VALUES
(1, 1, 1, 1, 1, 1, 11, 1, 1, 'Lớp học tốt', 10, 4),
(2, 1, 1, 1, 1, 2, 9, 1, 9, 'Lớp học nghiêm túc', 10, 3),
(3, 1, 1, 1, 1, 3, 5, 1, 14, 'Một số học sinh chưa làm bài tập', 9, 2),
(4, 1, 1, 1, 1, 4, 10, 1, 20, 'Lớp hoạt đồng sôi nổi', 10, 4),
(5, 1, 1, 1, 1, 5, 4, 1, 24, 'Lớp chú ý xây dựng bài', 10, 3)";

/* Tổng kết tuần */
$sql_create_module[] = "INSERT INTO `nv4_headbook_summary` (`summary_id`, `week_id`, `headbook_id`, `headmaster_id`, `comment`, `add_time`, `update_time`) VALUES
(1, 1, 1, 4, 'Lớp đạt điểm tuyệt đối', 1670086800, 1670086800)";
