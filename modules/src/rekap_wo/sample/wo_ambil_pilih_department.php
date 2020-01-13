<?php
//crontrol
if(empty($params['case'])){
	$result['respon']['pesan']="gagal";
	$result['respon']['text_msg']="Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}

###START MODULE
$input=$params['input_option'];

$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME, COMPANY_UNIT_NAME from COMPANY_UNIT WHERE  RECORD_STATUS='A' AND COMPANY_UNIT_ID='".$input['COMPANY_UNIT_ID_TO']."'";	
$result_a=$this->MYSQL->data();

foreach($result_a as $r){
	$result[]=$r;
$no++;	
}
if(empty($result)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Data kosong";
	$this->callback['result']=$result;
}else{
	$this->callback['respon']['pesan']="sukses";
	$this->callback['respon']['text_msg']="OK".print_r($result,true);
	$this->callback['result']=$result;
}

return;
