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

$lang_translator['author'] = 'Ho Anh Tuan (anhtuana2k422001@gmail.com)';
$lang_translator['createdate'] = '27/11/2022, 09:22';
$lang_translator['copyright'] = '@Copyright (C) 2022 Ho Anh Tuan All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

$lang_module['action'] = 'Chức năng';

$lang_module['main'] = 'Quản lý sổ đầu bài';
$lang_module['organizations'] = 'Sở giáo dục';
$lang_module['department'] = 'Phòng đào tạo';
$lang_module['schools'] = 'Trường';
$lang_module['grade'] = 'Khối';
$lang_module['teacher'] = 'Giáo viên';
$lang_module['times'] = 'Tiết';
$lang_module['class'] = 'Quản lý lớp học';
$lang_module['subjects'] = 'Quản lý môn học';
$lang_module['lessons'] = 'Quản lý bài học';
$lang_module['distribution'] = 'Phân phối chương trình';
$lang_module['year'] = 'Năm học';
$lang_module['week'] = 'Tuần';
$lang_module['contents'] = 'Nội dung sổ đầu bài';
$lang_module['summary'] = 'Tổng kết tuần';
$lang_module['setting'] = 'Cấu hình';
$lang_module['save'] = 'Lưu lại';

//Lang for function organizations
$lang_module['add'] = 'Thêm mới';
$lang_module['edit'] = 'Sửa';
$lang_module['delete'] = 'Xóa';
$lang_module['number'] = 'STT';
$lang_module['active'] = 'Trạng thái';
$lang_module['search_title'] = 'Nhập từ khóa tìm kiếm';
$lang_module['search_submit'] = 'Tìm kiếm';
$lang_module['organization_name'] = 'Tên sở giáo dục';
$lang_module['update_time'] = 'Thời gian cập nhật';
$lang_module['error_required_organization_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên sở giáo dục';
$lang_module['error_required_update_time'] = 'Lỗi: bạn cần nhập dữ liệu cho Thời gian cập nhật';

//Lang for function organizations
$lang_module['add_time'] = 'Thời gian thêm';
$lang_module['error_required_add_time'] = 'Lỗi: bạn cần nhập dữ liệu cho Thời gian thêm';

//Lang for function department
$lang_module['department_name'] = 'Tên phòng đào tạo';
$lang_module['organizations_id'] = 'Tên sở giáo dục';
$lang_module['error_required_department_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên phòng đào tạo';
$lang_module['error_required_organizations_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Mã sở giáo dục';

//Lang for function department
// $lang_module['department_id'] = 'Mã phòng đào tạo';
$lang_module['department_id'] = 'Tên phòng đào tạo';

//Lang for function schools
$lang_module['school_name'] = 'Tên trường';
$lang_module['error_required_school_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên trường';
$lang_module['error_required_department_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Mã phòng đào tạo';

//Lang for function grade
$lang_module['grade_name'] = 'Tên khối';
$lang_module['school_id'] = 'Tên trường';
$lang_module['error_required_grade_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên khối';
$lang_module['error_required_school_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên trường';

//Lang for function teacher
$lang_module['userid'] = 'Tài khoản';
$lang_module['teacher_name'] = 'Tên giáo viên';
$lang_module['status'] = 'Trạng thái';

//Lang for function teacher
$lang_module['error_required_userid'] = 'Lỗi: bạn cần nhập dữ liệu cho Tài khoản';
$lang_module['error_required_teacher_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên giáo viên';

//Lang for function times
$lang_module['times_name'] = 'Số thứ tự tiết';
$lang_module['minutes'] = 'Số phút';
$lang_module['error_required_times_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Số thứ tự tiết';
$lang_module['error_required_minutes'] = 'Lỗi: bạn cần nhập dữ liệu cho Số phút';

//Lang for function class
$lang_module['class_name'] = 'Tên lớp';
$lang_module['grade_id'] = 'Khối';
$lang_module['amount'] = 'Sĩ số';
$lang_module['teacher_id'] = 'Giáo viên chủ nhiệm';
$lang_module['error_required_class_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên lớp';
$lang_module['error_required_grade_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Khối';
$lang_module['error_required_amount'] = 'Lỗi: bạn cần nhập dữ liệu cho Sĩ số';
$lang_module['error_required_teacher_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Giáo viên chủ nhiệm';

//Lang for function subjects
$lang_module['subject_name'] = 'Tên môn học';
$lang_module['error_required_subject_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên môn học';
$lang_module['error_required_status'] = 'Lỗi: bạn cần nhập dữ liệu cho Trạng thái';

//Lang for function lessons
$lang_module['lesson_name'] = 'Tên bài học';
$lang_module['lesson_order'] = 'Tiết';
$lang_module['error_required_lesson_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên bài học';
$lang_module['error_required_lesson_order'] = 'Lỗi: bạn cần nhập dữ liệu cho Tiết';

//Lang for function year
$lang_module['year_name'] = 'Tên năm học';
$lang_module['description'] = 'Mô tả';
$lang_module['error_required_year_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên năm học';
$lang_module['error_required_description'] = 'Lỗi: bạn cần nhập dữ liệu cho Mô tả';

//Lang for function week
$lang_module['week_name'] = 'Tuần';
$lang_module['start_time'] = 'Thời gian bắt đầu';
$lang_module['end_time'] = 'Thời gian kết thúc';
$lang_module['year_id'] = 'Mã năm';
$lang_module['error_required_week_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tuần';
$lang_module['error_required_start_time'] = 'Lỗi: bạn cần nhập dữ liệu cho Thời gian bắt đầu';
$lang_module['error_required_end_time'] = 'Lỗi: bạn cần nhập dữ liệu cho Thời gian kết thúc';
$lang_module['error_required_year_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Mã năm';

//Lang for function distribution
$lang_module['times_id'] = 'Tiết';
$lang_module['lesson_id'] = 'Bài học';
$lang_module['subject_id'] = 'Môn học';
$lang_module['error_required_times_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Tiết';
$lang_module['error_required_lesson_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Bài học';
$lang_module['error_required_subject_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Môn họcc';

//Lang for function contents
$lang_module['session'] = 'Buổi';
$lang_module['week_id'] = 'Tuần';
$lang_module['headbook_id'] = 'Mã sổ đầu bài';
$lang_module['note'] = 'Ghi chú';
$lang_module['comment'] = 'Nhận xét';
$lang_module['point'] = 'Điểm';
$lang_module['error_required_session'] = 'Lỗi: bạn cần nhập dữ liệu cho Buổi';
$lang_module['error_required_times'] = 'Lỗi: bạn cần nhập dữ liệu cho Tiết';
$lang_module['error_required_week_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Tuần';
$lang_module['error_required_headbook_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Mã sổ đầu bài';
$lang_module['error_required_note'] = 'Lỗi: bạn cần nhập dữ liệu cho Ghi chú';
$lang_module['error_required_comment'] = 'Lỗi: bạn cần nhập dữ liệu cho Nhận xét';
$lang_module['error_required_point'] = 'Lỗi: bạn cần nhập dữ liệu cho Điểm';

//Lang for function headbook
$lang_module['headbook'] = 'headbook';
$lang_module['headbook_name'] = 'Tên sổ đầu bài';
$lang_module['class_id'] = 'Lớp';
$lang_module['error_required_headbook_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên sổ đầu bài';
$lang_module['error_required_class_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Lớp';

//Lang for function contents
$lang_module['order_name'] = 'Thứ';
$lang_module['error_required_order_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Thứ';
$lang_module['times_id_order'] = 'Tiết CT';
$lang_module['teacher_id_content'] = 'Giáo viên';


//Lang for function summary
$lang_module['headmaster_id'] = 'Giáo viên chủ nhiêm';
$lang_module['error_required_headmaster_id'] = 'Lỗi: bạn cần nhập dữ liệu cho Giáo viên chủ nhiêm';

//Lang for function setting
$lang_module['setting_name'] = 'Tên cấu hình';
$lang_module['error_required_setting_name'] = 'Lỗi: bạn cần nhập dữ liệu cho Tên cấu hình';
