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
$this->MYSQL->queri="select RECORD_STATUS from WO_MASTER where ENTRI_OPERATOR='".$user_login['PERSONAL_NIK']."' and RECORD_STATUS='N'";	
$result_a=$this->MYSQL->data();
if(empty($result_a)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Data kosong";
}else{
	//flag data menjadi D
	$input_flag['RECORD_STATUS']='D';
	$input_flag['HAPUS_OPERATOR']=$user_login['PERSONAL_NIK'];
	$input_flag['HAPUS_WAKTU']=Date('Y-m-d H:i:s');
	
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->tabel="WO_MASTER";
	$this->MYSQL->record=$input_flag;					
	$this->MYSQL->dimana="where RECORD_STATUS='N'  and  ENTRI_OPERATOR='".$user_login['PERSONAL_NIK']."'";	
	if($this->MYSQL->ubah()==true){
		$this->callback['respon']['pesan']="sukses";
		$this->callback['respon']['text_msg']="OK";
	}else{
		$this->callback['respon']['pesan']="gagal";
		$this->callback['respon']['text_msg']="Gagal mengubah";
	}
	
}
return;
