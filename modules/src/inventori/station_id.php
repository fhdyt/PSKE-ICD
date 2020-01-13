<?php

//crontrol
if(empty($params['case'])){
	$result['respon']['pesan']=="gagal";
	$result['respon']['pesan']=="Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}

$input=$params['input_option'];

$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select * from ICD_IP_ADDRESS AS IP, ICD_STATION_ID AS S, PERSONAL AS P, COMPANY_UNIT AS C WHERE S.PERSONAL_NIK=P.PERSONAL_NIK AND S.COMPANY_UNIT_ID=C.COMPANY_UNIT_ID AND S.ICD_STATION_ID LIKE '%".$input['q']."%' AND S.RECORD_STATUS='A'";


$result_a=$this->MYSQL->data();
$no=1;
foreach($result_a as $r){
	$r['ICD_BARANG_KODE_INVENTORI'] = sprintf('%07d',$r['ICD_BARANG_KODE_INVENTORI']);
	$result[]=$r;

$no++;
}
if(empty($result)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Data kosong _".$input['q'];
	$this->callback['result']=$result;
}else{
	$this->callback['respon']['pesan']="sukses";
	$this->callback['respon']['text_msg']="OK".print_r($result,true);
	$this->callback['result']=$result;
}

return;
?>
