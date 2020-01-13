<?php

//crontrol
if(empty($params['case'])){
	$result['respon']['pesan']=="gagal";
	$result['respon']['pesan']=="Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}

###START MODULE
//--pagging start top--/
$input=$params['input_option'];

$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select a.PERSONAL_NIK,a.PERSONAL_NAME
					 from 
					 PERSONAL a
					 WHERE a.COMPANY_UNIT_ID='".$input['COMPANY_UNIT_ID']."' 
					 and a.RECORD_STATUS='A'";
$result_a=$this->MYSQL->data();
$no=1;
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
?>
