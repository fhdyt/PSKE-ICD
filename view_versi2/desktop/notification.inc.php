<?php

//$aplikasi_user_aktif=$CD::aplikasi_user_aktif(array('data_http'=>$_COOKIE['data_http']));
require_once('menu_sidebar.php');

//echo "<pre>".print_r($aplikasi_user_aktif,true)."</pre>";

//$menu_user_aktif=$CD::menu_user_aktif(array('data_http'=>$_COOKIE['data_http'],'url_parameter'=>$url_parameter[1],));
//echo "<pre>".print_r($menu_user_aktif,true)."</pre>";

switch($d2){
	case 'caroad';
	break;
	default:
		require_once('notification/notification_list.php');
	break;
}
?>            
  
