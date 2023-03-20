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

if ($nv_Request->isset_request('delete_week_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $week_id = $nv_Request->get_int('delete_week_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($week_id > 0 and $delete_checkss == md5($week_id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_week  WHERE week_id = ' . $db->quote($week_id));
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Week', 'ID: ' . $week_id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();
$row['week_id'] = $nv_Request->get_int('week_id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['week_name'] = $nv_Request->get_title('week_name', 'post', '');
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('start_time', 'post'), $m))     {
        $_hour = 0;
        $_min = 0;
        $row['start_time'] = mktime($_hour, $_min, 0, $m[2], $m[1], $m[3]);
    }
    else
    {
        $row['start_time'] = 0;
    }
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('end_time', 'post'), $m))     {
        $_hour = 0;
        $_min = 0;
        $row['end_time'] = mktime($_hour, $_min, 0, $m[2], $m[1], $m[3]);
    }
    else
    {
        $row['end_time'] = 0;
    }
    $row['description'] = $nv_Request->get_title('description', 'post', '');
    $row['year_id'] = $nv_Request->get_int('year_id', 'post', 0);
    $row['status'] = $nv_Request->get_int('status', 'post', 0);

    if (empty($row['week_name'])) {
        $error[] = $lang_module['error_required_week_name'];
    } elseif (empty($row['start_time'])) {
        $error[] = $lang_module['error_required_start_time'];
    } elseif (empty($row['end_time'])) {
        $error[] = $lang_module['error_required_end_time'];
    } elseif (empty($row['description'])) {
        $error[] = $lang_module['error_required_description'];
    } elseif (empty($row['year_id'])) {
        $error[] = $lang_module['error_required_year_id'];
    } elseif (empty($row['status'])) {
        $error[] = $lang_module['error_required_status'];
    }

    if (empty($error)) {
        try {
            if (empty($row['week_id'])) {
                $stmt = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_week (week_name, start_time, end_time, description, year_id, status) VALUES (:week_name, :start_time, :end_time, :description, :year_id, :status)');
            } else {
                $stmt = $db->prepare('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_week SET week_name = :week_name, start_time = :start_time, end_time = :end_time, description = :description, year_id = :year_id, status = :status WHERE week_id=' . $row['week_id']);
            }
            $stmt->bindParam(':week_name', $row['week_name'], PDO::PARAM_STR);
            $stmt->bindParam(':start_time', $row['start_time'], PDO::PARAM_INT);
            $stmt->bindParam(':end_time', $row['end_time'], PDO::PARAM_INT);
            $stmt->bindParam(':description', $row['description'], PDO::PARAM_STR);
            $stmt->bindParam(':year_id', $row['year_id'], PDO::PARAM_INT);
            $stmt->bindParam(':status', $row['status'], PDO::PARAM_INT);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['week_id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Week', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Week', 'ID: ' . $row['week_id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['week_id'] > 0) {
    $row = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_week WHERE week_id=' . $row['week_id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['week_id'] = 0;
    $row['week_name'] = '';
    $row['start_time'] = 0;
    $row['end_time'] = 0;
    $row['description'] = '';
    $row['year_id'] = 0;
    $row['status'] = 1;
}

if (empty($row['start_time'])) {
    $row['start_time'] = '';
}
else
{
    $row['start_time'] = date('d/m/Y', $row['start_time']);
}

if (empty($row['end_time'])) {
    $row['end_time'] = '';
}
else
{
    $row['end_time'] = date('d/m/Y', $row['end_time']);
}
$array_year_id_headbook = array();
$_sql = 'SELECT year_id,year_name FROM nv4_headbook_year';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_year_id_headbook[$_row['year_id']] = $_row;
}


$array_status = array();
$array_status[1] = 'Hoạt động';
$array_status[2] = 'Ngừng hoạt động';

$q = $nv_Request->get_title('q', 'post,get');

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . $db_config['prefix'] . '_' . $module_data . '_week');

    if (!empty($q)) {
        $db->where('week_name LIKE :q_week_name OR start_time LIKE :q_start_time OR end_time LIKE :q_end_time OR description LIKE :q_description OR year_id LIKE :q_year_id OR status LIKE :q_status');
    }
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_week_name', '%' . $q . '%');
        $sth->bindValue(':q_start_time', '%' . $q . '%');
        $sth->bindValue(':q_end_time', '%' . $q . '%');
        $sth->bindValue(':q_description', '%' . $q . '%');
        $sth->bindValue(':q_year_id', '%' . $q . '%');
        $sth->bindValue(':q_status', '%' . $q . '%');
    }
    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('week_id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_week_name', '%' . $q . '%');
        $sth->bindValue(':q_start_time', '%' . $q . '%');
        $sth->bindValue(':q_end_time', '%' . $q . '%');
        $sth->bindValue(':q_description', '%' . $q . '%');
        $sth->bindValue(':q_year_id', '%' . $q . '%');
        $sth->bindValue(':q_status', '%' . $q . '%');
    }
    $sth->execute();
}

$xtpl = new XTemplate('week.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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

foreach ($array_year_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['year_id'],
        'title' => $value['year_name'],
        'selected' => ($value['year_id'] == $row['year_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_year_id');
}

foreach ($array_status as $key => $title) {
    $xtpl->assign('OPTION', array(
        'key' => $key,
        'title' => $title,
        'selected' => ($key == $row['status']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_status');
}
$xtpl->assign('Q', $q);

if ($show_view) {
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
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
        $view['start_time'] = (empty($view['start_time'])) ? '' : nv_date('d/m/Y', $view['start_time']);
        $view['end_time'] = (empty($view['end_time'])) ? '' : nv_date('d/m/Y', $view['end_time']);
        $view['year_id'] = $array_year_id_headbook[$view['year_id']]['year_name'];
        $view['status'] = $array_status[$view['status']];
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;week_id=' . $view['week_id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_week_id=' . $view['week_id'] . '&amp;delete_checkss=' . md5($view['week_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
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

$page_title = $lang_module['week'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
