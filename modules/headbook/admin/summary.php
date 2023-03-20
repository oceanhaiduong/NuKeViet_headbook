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

if ($nv_Request->isset_request('delete_summary_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $summary_id = $nv_Request->get_int('delete_summary_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($summary_id > 0 and $delete_checkss == md5($summary_id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_summary  WHERE summary_id = ' . $db->quote($summary_id));
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Summary', 'ID: ' . $summary_id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();
$row['summary_id'] = $nv_Request->get_int('summary_id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['week_id'] = $nv_Request->get_int('week_id', 'post', 0);
    $row['headbook_id'] = $nv_Request->get_int('headbook_id', 'post', 0);
    $row['headmaster_id'] = $nv_Request->get_int('headmaster_id', 'post', 0);
    $row['comment'] = $nv_Request->get_title('comment', 'post', '');
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('add_time', 'post'), $m))     {
        $_hour = 0;
        $_min = 0;
        $row['add_time'] = mktime($_hour, $_min, 0, $m[2], $m[1], $m[3]);
    }
    else
    {
        $row['add_time'] = 0;
    }
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('update_time', 'post'), $m))     {
        $_hour = 0;
        $_min = 0;
        $row['update_time'] = mktime($_hour, $_min, 0, $m[2], $m[1], $m[3]);
    }
    else
    {
        $row['update_time'] = 0;
    }

    if (empty($row['week_id'])) {
        $error[] = $lang_module['error_required_week_id'];
    } elseif (empty($row['headbook_id'])) {
        $error[] = $lang_module['error_required_headbook_id'];
    } elseif (empty($row['headmaster_id'])) {
        $error[] = $lang_module['error_required_headmaster_id'];
    } elseif (empty($row['comment'])) {
        $error[] = $lang_module['error_required_comment'];
    } elseif (empty($row['add_time'])) {
        $error[] = $lang_module['error_required_add_time'];
    } elseif (empty($row['update_time'])) {
        $error[] = $lang_module['error_required_update_time'];
    }

    if (empty($error)) {
        try {
            if (empty($row['summary_id'])) {
                $stmt = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_summary (week_id, headbook_id, headmaster_id, comment, add_time, update_time) VALUES (:week_id, :headbook_id, :headmaster_id, :comment, :add_time, :update_time)');
            } else {
                $stmt = $db->prepare('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_summary SET week_id = :week_id, headbook_id = :headbook_id, headmaster_id = :headmaster_id, comment = :comment, add_time = :add_time, update_time = :update_time WHERE summary_id=' . $row['summary_id']);
            }
            $stmt->bindParam(':week_id', $row['week_id'], PDO::PARAM_INT);
            $stmt->bindParam(':headbook_id', $row['headbook_id'], PDO::PARAM_INT);
            $stmt->bindParam(':headmaster_id', $row['headmaster_id'], PDO::PARAM_INT);
            $stmt->bindParam(':comment', $row['comment'], PDO::PARAM_STR);
            $stmt->bindParam(':add_time', $row['add_time'], PDO::PARAM_INT);
            $stmt->bindParam(':update_time', $row['update_time'], PDO::PARAM_INT);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['summary_id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Summary', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Summary', 'ID: ' . $row['summary_id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['summary_id'] > 0) {
    $row = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_summary WHERE summary_id=' . $row['summary_id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['summary_id'] = 0;
    $row['week_id'] = 0;
    $row['headbook_id'] = 0;
    $row['headmaster_id'] = 0;
    $row['comment'] = '';
    $row['add_time'] = 0;
    $row['update_time'] = 0;
}

if (empty($row['add_time'])) {
    $row['add_time'] = '';
}
else
{
    $row['add_time'] = date('d/m/Y', $row['add_time']);
}

if (empty($row['update_time'])) {
    $row['update_time'] = '';
}
else
{
    $row['update_time'] = date('d/m/Y', $row['update_time']);
}
$array_week_id_headbook = array();
$_sql = 'SELECT week_id,week_name FROM nv4_headbook_week';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_week_id_headbook[$_row['week_id']] = $_row;
}

$array_headbook_id_headbook = array();
$_sql = 'SELECT headbook_id,headbook_name FROM nv4_headbook_headbook';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_headbook_id_headbook[$_row['headbook_id']] = $_row;
}

$array_headmaster_id_headbook = array();
$_sql = 'SELECT teacher_id,teacher_name FROM nv4_headbook_teacher';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_headmaster_id_headbook[$_row['teacher_id']] = $_row;
}


// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . $db_config['prefix'] . '_' . $module_data . '_summary');
    $sth = $db->prepare($db->sql());
    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('summary_id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());
    $sth->execute();
}

$xtpl = new XTemplate('summary.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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

foreach ($array_week_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['week_id'],
        'title' => $value['week_name'],
        'selected' => ($value['week_id'] == $row['week_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_week_id');
}
foreach ($array_headbook_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['headbook_id'],
        'title' => $value['headbook_name'],
        'selected' => ($value['headbook_id'] == $row['headbook_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_headbook_id');
}
foreach ($array_headmaster_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['teacher_id'],
        'title' => $value['teacher_name'],
        'selected' => ($value['teacher_id'] == $row['headmaster_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_headmaster_id');
}

if ($show_view) {
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }
    $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
    while ($view = $sth->fetch()) {
        $view['number'] = $number++;
        $view['add_time'] = (empty($view['add_time'])) ? '' : nv_date('d/m/Y', $view['add_time']);
        $view['update_time'] = (empty($view['update_time'])) ? '' : nv_date('d/m/Y', $view['update_time']);
        $view['week_id'] = $array_week_id_headbook[$view['week_id']]['week_name'];
        $view['headbook_id'] = $array_headbook_id_headbook[$view['headbook_id']]['headbook_name'];
        $view['headmaster_id'] = $array_headmaster_id_headbook[$view['headmaster_id']]['teacher_name'];
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;summary_id=' . $view['summary_id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_summary_id=' . $view['summary_id'] . '&amp;delete_checkss=' . md5($view['summary_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
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

$page_title = $lang_module['summary'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
