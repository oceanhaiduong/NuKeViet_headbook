<?php

/**
 * TMS Content Management System
 * @version 4.x
 * @author Tập Đoàn TMS Holdings <contact@tms.vn>
 * @copyright (C) 2009-2021 Tập Đoàn TMS Holdings. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://tms.vn
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

$module_version = array(
    'name' => 'nvtools',
    'modfuncs' => 'main,theme,data,addfun,action,export_excel,block,themecopy,thememodulecp,compiler,copylang',
    'submenu' => 'main,theme,data,addfun,action,export_excel,block,themecopy,thememodulecp,compiler,copylang',
    'is_sysmod' => 0,
    'virtual' => 0,
    'version' => '4.0.24',
    'date' => 'Wed, 1 Nov 2021 4:50:45 GMT',
    'author' => 'TMS HOLDINGS (contact@tms.vn)',
    'uploads_dir' => array(
        $module_upload,
        $module_upload . '/compiler'
    ),
    'note' => 'Công cụ xây dựng site',
    'layoutdefault' => 'body:main,theme,data,addfun,themecopy,thememodulecp'
);
