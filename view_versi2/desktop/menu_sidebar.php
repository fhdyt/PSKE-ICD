<?php
//get sidebar LTE
$aplikasi_user_aktif=$CD::aplikasi_user_aktif(array('data_http'=>$_COOKIE['data_http']));
$menu_user_aktif=$CD::menu_user_aktif(array('data_http'=>$_COOKIE['data_http'],'url_parameter'=>$url_parameter[1],));

require_once(PLATFORM_ROOT.'asset/plugins/AdminLTE-2.4.3/class/adminLTE.php');
$adminLTE=new adminLTE();
$adminLTE->menu_sidebar(
	array(
		'aplikasi_user_aktif'=>$aplikasi_user_aktif,
		'menu_user_aktif'=>$menu_user_aktif,
		'd1'=>$d1,
		'd2'=>$d2,
	)
);

?> 
