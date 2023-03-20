<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS HOLDINGS (contact@tms.vn)
 * @Copyright (C) 2021 TMS HOLDINGS. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 01/01/2021 09:47
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$id = $nv_Request->get_int('id', 'get', 0);
$area = $nv_Request->get_int('area', 'get', 0);

// Sử dụng $id và $area để truy vấn vào CSDL, xác định ra dữ liệu của bài viết


// Ví dụ
//>>
$rowcontent = $db_slave->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id)->fetch();
if (!empty($rowcontent)) {
    // Chuyển hướng trình duyệt đến trang chi tiết bài viết
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $rowcontent['alias'] . '-' . $rowcontent['id'] . $global_config['rewrite_exturl']);
}
//<<

// Thông báo lỗi không tồn tại bài viết
nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['admin_no_allow_func'], 404);
