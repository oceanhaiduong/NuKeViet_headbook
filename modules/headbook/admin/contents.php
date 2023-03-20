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

if ($nv_Request->isset_request('delete_content_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $content_id = $nv_Request->get_int('delete_content_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($content_id > 0 and $delete_checkss == md5($content_id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_contents  WHERE content_id = ' . $db->quote($content_id));
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Contents', 'ID: ' . $content_id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();
$row['content_id'] = $nv_Request->get_int('content_id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['headbook_id'] = $nv_Request->get_int('headbook_id', 'post', 0);
    $row['week_id'] = $nv_Request->get_int('week_id', 'post', 0);
    $row['order_name'] = $nv_Request->get_int('order_name', 'post', 0);
    $row['session'] = $nv_Request->get_int('session', 'post', 0);
    $row['times'] = $nv_Request->get_int('times', 'post', 0);
    $row['subject_id'] = $nv_Request->get_int('subject_id', 'post', 0);
    $row['times_id'] = $nv_Request->get_int('times_id', 'post', 0);
    $row['lesson_id'] = $nv_Request->get_int('lesson_id', 'post', 0);
    $row['comment'] = $nv_Request->get_title('comment', 'post', '');
    $row['point'] = $nv_Request->get_int('point', 'post', 0);
    $row['teacher_id'] = $nv_Request->get_int('teacher_id', 'post', 0);

    if (empty($row['headbook_id'])) {
        $error[] = $lang_module['error_required_headbook_id'];
    } elseif (empty($row['week_id'])) {
        $error[] = $lang_module['error_required_week_id'];
    } elseif (empty($row['order_name'])) {
        $error[] = $lang_module['error_required_order_name'];
    } elseif (empty($row['session'])) {
        $error[] = $lang_module['error_required_session'];
    } elseif (empty($row['times'])) {
        $error[] = $lang_module['error_required_times'];
    } elseif (empty($row['subject_id'])) {
        $error[] = $lang_module['error_required_subject_id'];
    } elseif (empty($row['times_id'])) {
        $error[] = $lang_module['error_required_times_id'];
    } elseif (empty($row['lesson_id'])) {
        $error[] = $lang_module['error_required_lesson_id'];
    } elseif (empty($row['comment'])) {
        $error[] = $lang_module['error_required_comment'];
    } elseif (empty($row['point'])) {
        $error[] = $lang_module['error_required_point'];
    } elseif (empty($row['teacher_id'])) {
        $error[] = $lang_module['error_required_teacher_id'];
    }

    if (empty($error)) {
        try {
            if (empty($row['content_id'])) {
                $stmt = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_contents (headbook_id, week_id, order_name, session, times, subject_id, times_id, lesson_id, comment, point, teacher_id) VALUES (:headbook_id, :week_id, :order_name, :session, :times, :subject_id, :times_id, :lesson_id, :comment, :point, :teacher_id)');
            } else {
                $stmt = $db->prepare('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_contents SET headbook_id = :headbook_id, week_id = :week_id, order_name = :order_name, session = :session, times = :times, subject_id = :subject_id, times_id = :times_id, lesson_id = :lesson_id, comment = :comment, point = :point, teacher_id = :teacher_id WHERE content_id=' . $row['content_id']);
            }
            $stmt->bindParam(':headbook_id', $row['headbook_id'], PDO::PARAM_INT);
            $stmt->bindParam(':week_id', $row['week_id'], PDO::PARAM_INT);
            $stmt->bindParam(':order_name', $row['order_name'], PDO::PARAM_INT);
            $stmt->bindParam(':session', $row['session'], PDO::PARAM_INT);
            $stmt->bindParam(':times', $row['times'], PDO::PARAM_INT);
            $stmt->bindParam(':subject_id', $row['subject_id'], PDO::PARAM_INT);
            $stmt->bindParam(':times_id', $row['times_id'], PDO::PARAM_INT);
            $stmt->bindParam(':lesson_id', $row['lesson_id'], PDO::PARAM_INT);
            $stmt->bindParam(':comment', $row['comment'], PDO::PARAM_STR);
            $stmt->bindParam(':point', $row['point'], PDO::PARAM_INT);
            $stmt->bindParam(':teacher_id', $row['teacher_id'], PDO::PARAM_INT);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['content_id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Contents', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Contents', 'ID: ' . $row['content_id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['content_id'] > 0) {
    $row = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_contents WHERE content_id=' . $row['content_id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['content_id'] = 0;
    $row['headbook_id'] = 0;
    $row['week_id'] = 0;
    $row['order_name'] = 0;
    $row['session'] = 1;
    $row['times'] = 0;
    $row['subject_id'] = 0;
    $row['times_id'] = 0;
    $row['lesson_id'] = 0;
    $row['comment'] = '';
    $row['point'] = 0;
    $row['teacher_id'] = 0;
}
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

$xtpl = new XTemplate('contents.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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

foreach ($array_headbook_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['headbook_id'],
        'title' => $value['headbook_name'],
        'selected' => ($value['headbook_id'] == $row['headbook_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_headbook_id');
}
foreach ($array_week_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['week_id'],
        'title' => $value['week_name'],
        'selected' => ($value['week_id'] == $row['week_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_week_id');
}
foreach ($array_subject_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['subject_id'],
        'title' => $value['subject_name'],
        'selected' => ($value['subject_id'] == $row['subject_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_subject_id');
}
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
foreach ($array_teacher_id_headbook as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['teacher_id'],
        'title' => $value['teacher_name'],
        'selected' => ($value['teacher_id'] == $row['teacher_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_teacher_id');
}

foreach ($array_order_name as $key => $title) {
    $xtpl->assign('OPTION', array(
        'key' => $key,
        'title' => $title,
        'selected' => ($key == $row['order_name']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_order_name');
}

foreach ($array_session as $key => $title) {
    $xtpl->assign('OPTION', array(
        'key' => $key,
        'title' => $title,
        'selected' => ($key == $row['session']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_session');
}

foreach ($array_times as $key => $title) {
    $xtpl->assign('OPTION', array(
        'key' => $key,
        'title' => $title,
        'selected' => ($key == $row['times']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_times');
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
        $view['headbook_id'] = $array_headbook_id_headbook[$view['headbook_id']]['headbook_name'];
        $view['week_id'] = $array_week_id_headbook[$view['week_id']]['week_name'];
        $view['subject_id'] = $array_subject_id_headbook[$view['subject_id']]['subject_name'];
        $view['times_id'] = $array_times_id_headbook[$view['times_id']]['times_name'];
        $view['lesson_id'] = $array_lesson_id_headbook[$view['lesson_id']]['lesson_name'];
        $view['teacher_id'] = $array_teacher_id_headbook[$view['teacher_id']]['teacher_name'];
        $view['order_name'] = $array_order_name[$view['order_name']];
        $view['session'] = $array_session[$view['session']];
        $view['times'] = $array_times[$view['times']];
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;content_id=' . $view['content_id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_content_id=' . $view['content_id'] . '&amp;delete_checkss=' . md5($view['content_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
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
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
