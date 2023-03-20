<?php

/**
 * @Project TMS HOLDINGS
 * @Author Ho Anh Tuan <anhtuana2k422001@gmail.com>
 * @Copyright (C) 2022 Ho Anh Tuan. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 27 Nov 2022 09:22:25 GMT
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

$module_version = array(
    'name' => 'Headbook',
    'modfuncs' => 'main,detail,search,distribution,subject',
    'change_alias' => 'main,detail,search,distribution,subject',
    'submenu' => 'main,detail,search,distribution,subject',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '4.0.00',
    'date' => 'Sun, 27 Nov 2022 09:22:26 GMT',
    'author' => 'Ho Anh Tuan (anhtuana2k422001@gmail.com)',
    'uploads_dir' => array($module_name),
    'note' => ''
);
