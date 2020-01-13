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
$this->MYSQL->queri="select COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME from CONFIG_APPROVE_DETAIL 
							WHERE  RECORD_STATUS='A' AND PERSONAL_NIK='".$input['PERSONAL_NIK']."' and CONFIG_APPROVE_MASTER_APLIKASI_ID='wo'";
$result_a=$this->MYSQL->data();

foreach($result_a as $r){
	$result[]=$r;
$no++;	
}
if(empty($result)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Data kosong".$input['PERSONAL_NIK'];
	$this->callback['result']=$result;
}else{
	$this->callback['respon']['pesan']="sukses";
	$this->callback['respon']['text_msg']="OK".print_r($result,true);
	$this->callback['result']=$result;
}

return;
