<?php

//$aplikasi_user_aktif=$CD::aplikasi_user_aktif(array('data_http'=>$_COOKIE['data_http']));
require_once('menu_sidebar.php');

//echo "<pre>".print_r($aplikasi_user_aktif,true)."</pre>";

//$menu_user_aktif=$CD::menu_user_aktif(array('data_http'=>$_COOKIE['data_http'],'url_parameter'=>$url_parameter[1],));
//echo "<pre>".print_r($menu_user_aktif,true)."</pre>";

switch($d2){
	case 'wiget';
		require_once('dash_setting/wiget.php');
	break;
	case 'theme';
		require_once('dash_setting/theme.php');
	break;
	default:
		require_once('dash_setting/theme.php');
	break;
}
?>            
  
