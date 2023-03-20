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

if ($nv_Request->isset_request('delete_distribution_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $distribution_id = $nv_Request->get_int('delete_distribution_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($distribution_id > 0 and $delete_checkss == md5($distribution_id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_distribution  WHERE distribution_id = ' . $db->quote($distribution_id));
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Distribution', 'ID: ' . $distribution_id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();
$row['distribution_id'] = $nv_Request->get_int('distribution_id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['times_id'] = $nv_Request->get_int('times_id', 'post', 0);
    $row['lesson_id'] = $nv_Request->get_int('lesson_id', 'post', 0);
    $row['subject_id'] = $nv_Request->get_int('subject_id', 'post', 0);
    $row['grade_id'] = $nv_Request->get_int('grade_id', 'post', 0);
    $row['year_id'] = $nv_Request->get_int('year_id', 'post', 0);

    if (empty($row['times_id'])) {
        $error[] = $lang_module['error_required_times_id'];
    } elseif (empty($row['lesson_id'])) {
        $error[] = $lang_module['error_required_lesson_id'];
    } elseif (empty($row['subject_id'])) {
        $error[] = $lang_module['error_required_subject_id'];
    } elseif (empty($row['grade_id'])) {
        $error[] = $lang_module['error_required_grade_id'];
    } elseif (empty($row['year_id'])) {
        $error[] = $lang_module['error_required_year_id'];
    }

    if (empty($error)) {
        try {
            if (empty($row['distribution_id'])) {
                $stmt = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_distribution (times_id, lesson_id, subject_id, grade_id, year_id) VALUES (:times_id, :lesson_id, :subject_id, :grade_id, :year_id)');
            } else {
                $stmt = $db->prepare('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_distribution SET times_id = :times_id, lesson_id = :lesson_id, subject_id = :subject_id, grade_id = :grade_id, year_id = :year_id WHERE distribution_id=' . $row['distribution_id']);
            }
            $stmt->bindParam(':times_id', $row['times_id'], PDO::PARAM_INT);
            $stmt->bindParam(':lesson_id', $row['lesson_id'], PDO::PARAM_INT);
            $stmt->bindParam(':subject_id', $row['subject_id'], PDO::PARAM_INT);
            $stmt->bindParam(':grade_id', $row['grade_id'], PDO::PARAM_INT);
            $stmt->bindParam(':year_id', $row['year_id'], PDO::PARAM_INT);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['distribution_id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Distribution', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Distribution', 'ID: ' . $row['distribution_id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['distribution_id'] > 0) {
    $row = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_distribution WHERE distribution_id=' . $row['distribution_id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['distribution_id'] = 0;
    $row['times_id'] = 0;
    $row['lesson_id'] = 0;
    $row['subject_id'] = 0;
    $row['grade_id'] = 0;
    $row['year_id'] = 0;
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


$q = $nv_Request->get_title('q', 'post,get');

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . $db_config['prefix'] . '_' . $module_data . '_distribution');

    if (!empty($q)) {
        $db->where('times_id LIKE :q_times_id OR lesson_id LIKE :q_lesson_id OR subject_id LIKE :q_subject_id OR grade_id LIKE :q_grade_id OR year_id LIKE :q_year_id');
    }
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_times_id', '%' . $q . '%');
        $sth->bindValue(':q_lesson_id', '%' . $q . '%');
        $sth->bindValue(':q_subject_id', '%' . $q . '%');
        $sth->bindValue(':q_grade_id', '%' . $q . '%');
        $sth->bindValue(':q_year_id', '%' . $q . '%');
    }
    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('distribution_id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_times_id', '%' . $q . '%');
        $sth->bindValue(':q_lesson_id', '%' . $q . '%');
        $sth->bindValue(':q_subject_id', '%' . $q . '%');
        $sth->bindValue(':q_grade_id', '%' . $q . '%');
        $sth->bindValue(':q_year_id', '%' . $q . '%');
    }
    $sth->execute();
}

$xtpl = new XTemplate('distribution.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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

foreach ($array_times_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['times_id'],
        'title' => $value['times_name'],
        'selected' => ($value['times_id'] == $row['times_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_times_id');
}
foreach ($array_lesson_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['lesson_id'],
        'title' => $value['lesson_name'],
        'selected' => ($value['lesson_id'] == $row['lesson_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_lesson_id');
}
foreach ($array_subject_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['subject_id'],
        'title' => $value['subject_name'],
        'selected' => ($value['subject_id'] == $row['subject_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_subject_id');
}
foreach ($array_grade_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['grade_id'],
        'title' => $value['grade_name'],
        'selected' => ($value['grade_id'] == $row['grade_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_grade_id');
}
foreach ($array_year_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['year_id'],
        'title' => $value['year_name'],
        'selected' => ($value['year_id'] == $row['year_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_year_id');
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
        $view['times_id'] = $array_times_id_headbook[$view['times_id']]['times_name'];
        $view['lesson_id'] = $array_lesson_id_headbook[$view['lesson_id']]['lesson_name'];
        $view['subject_id'] = $array_subject_id_headbook[$view['subject_id']]['subject_name'];
        $view['grade_id'] = $array_grade_id_headbook[$view['grade_id']]['grade_name'];
        $view['year_id'] = $array_year_id_headbook[$view['year_id']]['year_name'];
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;distribution_id=' . $view['distribution_id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_distribution_id=' . $view['distribution_id'] . '&amp;delete_checkss=' . md5($view['distribution_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
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
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
