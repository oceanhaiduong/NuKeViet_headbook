<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2022 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_HEADBOOK'))
    die('Stop!!!');

if ($nv_Request->isset_request('delete_content_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $content_id = $nv_Request->get_int('delete_content_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($content_id > 0 and $delete_checkss == md5($content_id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_contents  WHERE content_id = ' . $db->quote($content_id));
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Detail', 'ID: ' . $content_id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();
$array_headbook_id_headbook = array();
$_sql = 'SELECT headbook_id,headbook_name FROM nv4_headbook_headbook';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_headbook_id_headbook[$_row['headbook_id']] = $_row;
}

$array_week_id_headbook = array();
$_sql = 'SELECT week_id,week_name FROM nv4_headbook_week';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_week_id_headbook[$_row['week_id']] = $_row;
}

$array_subject_id_headbook = array();
$_sql = 'SELECT subject_id,subject_name FROM nv4_headbook_subjects';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_subject_id_headbook[$_row['subject_id']] = $_row;
}

$array_times_id_headbook = array();
$_sql = 'SELECT times_id,times_name FROM nv4_headbook_times';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_times_id_headbook[$_row['times_id']] = $_row;
}

$array_lesson_id_headbook = array();
$_sql = 'SELECT lesson_id,lesson_name FROM nv4_headbook_lessons';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_lesson_id_headbook[$_row['lesson_id']] = $_row;
}

$array_teacher_id_headbook = array();
$_sql = 'SELECT teacher_id,teacher_name FROM nv4_headbook_teacher';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_teacher_id_headbook[$_row['teacher_id']] = $_row;
}


$array_order_name = array();
$array_order_name[1] = '2';
$array_order_name[2] = '3';
$array_order_name[4] = '4';
$array_order_name[5] = '5';
$array_order_name[6] = '6';
$array_order_name[7] = '7';

$array_session = array();
$array_session[1] = 'Sáng';
$array_session[2] = 'Chiều';

$array_times = array();
$array_times[1] = 'Tiết 1';
$array_times[2] = 'Tiết 2';
$array_times[3] = 'Tiết 3';
$array_times[4] = 'Tiết 4';
$array_times[5] = 'Tiết 5';

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . $db_config['prefix'] . '_' . $module_data . '_contents');
    $sth = $db->prepare($db->sql());
    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('content_id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());
    $sth->execute();
}

$xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);


if ($show_view) {
    $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }
    $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
    while ($view = $sth->fetch()) {
        $view['number'] = $number++;
        $view['headbook_id'] = $array_headbook_id_headbook[$view['headbook_id']]['headbook_name'];
        $view['week_id'] = $array_week_id_headbook[$view['week_id']]['week_name'];
        $view['subject_id'] = $array_subject_id_headbook[$view['subject_id']]['subject_name'];
        $view['times_id'] = $array_times_id_headbook[$view['times_id']]['times_name'];
        $view['lesson_id'] = $array_lesson_id_headbook[$view['lesson_id']]['lesson_name'];
        $view['teacher_id'] = $array_teacher_id_headbook[$view['teacher_id']]['teacher_name'];
        $view['order_name'] = $array_order_name[$view['order_name']];
        $view['session'] = $array_session[$view['session']];
        $view['times'] = $array_times[$view['times']];
        $view['link_edit'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;content_id=' . $view['content_id'];
        $view['link_delete'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_content_id=' . $view['content_id'] . '&amp;delete_checkss=' . md5($view['content_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
        $xtpl->assign('VIEW', $view);
        $xtpl->parse('main.view.loop');
    }
    $xtpl->parse('main.view');
}


if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['detail'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
