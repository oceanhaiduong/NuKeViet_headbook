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
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Contents', 'ID: ' . $content_id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();

$q = $nv_Request->get_title('q', 'post,get');

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . $db_config['prefix'] . '_' . $module_data . '_contents');

    if (!empty($q)) {
        $db->where('headbook_id LIKE :q_headbook_id OR week_id LIKE :q_week_id OR order_name LIKE :q_order_name OR session LIKE :q_session OR times LIKE :q_times OR subject_id LIKE :q_subject_id OR times_id LIKE :q_times_id OR lesson_id LIKE :q_lesson_id OR comment LIKE :q_comment OR point LIKE :q_point OR teacher_id LIKE :q_teacher_id');
    }
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_headbook_id', '%' . $q . '%');
        $sth->bindValue(':q_week_id', '%' . $q . '%');
        $sth->bindValue(':q_order_name', '%' . $q . '%');
        $sth->bindValue(':q_session', '%' . $q . '%');
        $sth->bindValue(':q_times', '%' . $q . '%');
        $sth->bindValue(':q_subject_id', '%' . $q . '%');
        $sth->bindValue(':q_times_id', '%' . $q . '%');
        $sth->bindValue(':q_lesson_id', '%' . $q . '%');
        $sth->bindValue(':q_comment', '%' . $q . '%');
        $sth->bindValue(':q_point', '%' . $q . '%');
        $sth->bindValue(':q_teacher_id', '%' . $q . '%');
    }
    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('content_id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_headbook_id', '%' . $q . '%');
        $sth->bindValue(':q_week_id', '%' . $q . '%');
        $sth->bindValue(':q_order_name', '%' . $q . '%');
        $sth->bindValue(':q_session', '%' . $q . '%');
        $sth->bindValue(':q_times', '%' . $q . '%');
        $sth->bindValue(':q_subject_id', '%' . $q . '%');
        $sth->bindValue(':q_times_id', '%' . $q . '%');
        $sth->bindValue(':q_lesson_id', '%' . $q . '%');
        $sth->bindValue(':q_comment', '%' . $q . '%');
        $sth->bindValue(':q_point', '%' . $q . '%');
        $sth->bindValue(':q_teacher_id', '%' . $q . '%');
    }
    $sth->execute();
}

$xtpl = new XTemplate('contents.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
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

$xtpl->assign('Q', $q);

if ($show_view) {
    $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
    if (!empty($q)) {
        $base_url .= '&q=' . $q;
    }
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }
    $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
    while ($view = $sth->fetch()) {
        $view['number'] = $number++;
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

$page_title = $lang_module['contents'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
