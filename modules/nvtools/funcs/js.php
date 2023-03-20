<?php

/**
 * TMS Content Management System
 * @version 4.x
 * @author Tập Đoàn TMS Holdings <contact@tms.vn>
 * @copyright (C) 2009-2021 Tập Đoàn TMS Holdings. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://tms.vn
 */
if( ! defined( 'NV_IS_MOD_NVTOOLS' ) ) die( 'Stop!!!' );

if ( $sys_info['allowed_set_time_limit'] )
{
	set_time_limit( 0 );
}
if ( $sys_info['ini_set_support'] )
{
	$memoryLimitMB = ( integer )ini_get( 'memory_limit' );
	if ( $memoryLimitMB < 1024 )
	{
		ini_set( 'memory_limit', '1024M' );
	}
}

$jsfile = trim( $_POST['jsfile'] );
$jsfile = nv_base64_decode( $jsfile );

$jarPath = NV_ROOTDIR . '/modules/' . $module_file . '/compiler.jar';
$jsPath = NV_SOURCE . '/' . $jsfile;
$jsMinPath = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/min.js';

if( file_exists( $jsPath ) )
{
	// You need the Java Runtime Environment version 7: https://developers.google.com/closure/compiler/docs/gettingstarted_app
	$compilerCommand = sprintf( 'java -jar %s --js %s --js_output_file %s', $jarPath, $jsPath, $jsMinPath );
	if( $sys_info['os'] != 'LINUX' )
	{
		$compilerCommand = str_replace( "/", "\\", $compilerCommand );
	}

	exec( $compilerCommand, $return, $code );

	$js_min = file_get_contents( $jsMinPath );
	@unlink( $jsMinPath );

	if( $code == 0 and ! empty( $js_min ) and file_put_contents( $jsPath, $js_min, LOCK_EX ) )
	{
		die( 'OK_' . $response );
	}
	else
	{
		die( 'Error write file:' . $jsfile );
	}
}
else
{
	die( 'No_OK:' . $jsPath );
}