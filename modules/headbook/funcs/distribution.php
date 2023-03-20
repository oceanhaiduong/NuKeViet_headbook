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

if ($nv_Request->isset_request('delete_distribution_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $distribution_id = $nv_Request->get_int('delete_distribution_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($distribution_id > 0 and $delete_checkss == md5($distribution_id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_distribution  WHERE distribution_id = ' . $db->quote($distribution_id));
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Distribution', 'ID: ' . $distribution_id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();
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

$array_subject_id_headbook = array();
$_sql = 'SELECT subject_id,subject_name FROM nv4_headbook_subjects';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_subject_id_headbook[$_row['subject_id']] = $_row;
}

$array_grade_id_headbook = array();
$_sql = 'SELECT grade_id,grade_name FROM nv4_headbook_grade';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_grade_id_headbook[$_row['grade_id']] = $_row;
}

$array_year_id_headbook = array();
$_sql = 'SELECT year_id,year_name FROM nv4_headbook_year';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_year_id_headbook[$_row['year_id']] = $_row;
}


// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . $db_config['prefix'] . '_' . $module_data . '_distribution');
    $sth = $db->prepare($db->sql());
    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('distribution_id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());
    $sth->execute();
}

$xtpl = new XTemplate('distribution.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
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
        $view['times_id'] = $array_times_id_headbook[$view['times_id']]['times_name'];
        $view['lesson_id'] = $array_lesson_id_headbook[$view['lesson_id']]['lesson_name'];
        $view['subject_id'] = $array_subject_id_headbook[$view['subject_id']]['subject_name'];
        $view['grade_id'] = $array_grade_id_headbook[$view['grade_id']]['grade_name'];
        $view['year_id'] = $array_year_id_headbook[$view['year_id']]['year_name'];
        $view['link_edit'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;distribution_id=' . $view['distribution_id'];
        $view['link_delete'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_distribution_id=' . $view['distribution_id'] . '&amp;delete_checkss=' . md5($view['distribution_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
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

$page_title = $lang_module['distribution'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
