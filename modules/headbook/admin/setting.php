<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2022 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

if ($nv_Request->isset_request('delete_setting_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $setting_id = $nv_Request->get_int('delete_setting_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($setting_id > 0 and $delete_checkss == md5($setting_id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_setting  WHERE setting_id = ' . $db->quote($setting_id));
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Setting', 'ID: ' . $setting_id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();
$row['setting_id'] = $nv_Request->get_int('setting_id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['setting_name'] = $nv_Request->get_title('setting_name', 'post', '');
    $row['status'] = $nv_Request->get_int('status', 'post', 0);

    if (empty($row['setting_name'])) {
        $error[] = $lang_module['error_required_setting_name'];
    } elseif (empty($row['status'])) {
        $error[] = $lang_module['error_required_status'];
    }

    if (empty($error)) {
        try {
            if (empty($row['setting_id'])) {
                $stmt = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_setting (setting_name, status) VALUES (:setting_name, :status)');
            } else {
                $stmt = $db->prepare('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_setting SET setting_name = :setting_name, status = :status WHERE setting_id=' . $row['setting_id']);
            }
            $stmt->bindParam(':setting_name', $row['setting_name'], PDO::PARAM_STR);
            $stmt->bindParam(':status', $row['status'], PDO::PARAM_INT);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['setting_id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Setting', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Setting', 'ID: ' . $row['setting_id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['setting_id'] > 0) {
    $row = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_setting WHERE setting_id=' . $row['setting_id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['setting_id'] = 0;
    $row['setting_name'] = '';
    $row['status'] = 1;
}

$array_status = array();
$array_status[1] = 'Hoạt động';
$array_status[2] = 'Ngừng hoạt động';

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $db->sqlreset()
        ->select('*')
        ->from('' . $db_config['prefix'] . '_' . $module_data . '_setting')
        ->order('setting_id DESC');
    $sth = $db->prepare($db->sql());
    $sth->execute();
}

$xtpl = new XTemplate('setting.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);


foreach ($array_status as $key => $title) {
    $xtpl->assign('OPTION', array(
        'key' => $key,
        'title' => $title,
        'selected' => ($key == $row['status']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_status');
}

if ($show_view) {
    $number = 0;
    while ($view = $sth->fetch()) {
        $view['number'] = $number++;
        $view['status'] = $array_status[$view['status']];
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;setting_id=' . $view['setting_id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_setting_id=' . $view['setting_id'] . '&amp;delete_checkss=' . md5($view['setting_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
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

$page_title = $lang_module['setting'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
