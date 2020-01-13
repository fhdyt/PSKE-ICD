<?php
//get headerbar LTE
require_once(PLATFORM_ROOT.'asset/plugins/AdminLTE-2.4.3/class/adminLTE.php');
$adminLTE=new adminLTE();
?>
<!DOCTYPE html>
<html>
<?php	
$adminLTE->header_asset($params);
?>
<body class="hold-transition skin-blue sidebar-mini adminLTE">
<div class="wrapper">
<?php	
$adminLTE->headerbar(
	array(
		'user_login'=>$cf['user_login'],
	)
);
//echo "<pre>".print_r($cf['user_login'],true)."</pre>";
?>
