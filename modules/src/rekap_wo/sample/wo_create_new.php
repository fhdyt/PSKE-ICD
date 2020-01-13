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


//ambil data informasi Company Unit
$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select COMPANY_UNIT_NAME,COMPANY_UNIT_SHORT_NAME from COMPANY_UNIT where COMPANY_UNIT_ID='".$input['COMPANY_UNIT_ID']."' and RECORD_STATUS='A'";	
$unit=$this->MYSQL->data();


//config data untuk tabel master
$master_input['WO_MASTER_INDEX']=waktu_decimal(Date("Y-m-d H:i:s"));
$master_input['WO_MASTER_ID']=waktu_decimal(Date("Y-m-d H:i:s"));
$master_input['WO_MASTER_NO']="";//$this->pkb_no();
$master_input['WO_MASTER_NOMOR']="-";//$this->pkb_no();
$master_input['COMPANY_UNIT_ID']=$input['COMPANY_UNIT_ID'];
$master_input['WO_MASTER_TYPE']=$input['WO_MASTER_TYPE'];
$master_input['COMPANY_UNIT_NAME']=$unit[0]['COMPANY_UNIT_NAME'];
$master_input['COMPANY_UNIT_SHORT_NAME']=$unit[0]['COMPANY_UNIT_SHORT_NAME'];
$master_input['ENTRI_OPERATOR']=$user_login['PERSONAL_NIK'];
$master_input['ENTRI_WAKTU']=Date("Y-m-d H:i:s");
$master_input['RECORD_STATUS']="N";

$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select * from WO_MASTER where ENTRI_OPERATOR='".$user_login['PERSONAL_NIK']."' and RECORD_STATUS='N'";	
$ck=$this->MYSQL->data();
if(empty($ck)){
	//insert new
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->tabel="WO_MASTER";	
	$this->MYSQL->record=$master_input;	
	if($this->MYSQL->simpan()==true){
		//$datanya="tersimpan";		
	}else{
		//$datanya="gagal tersimpan";
		
	}
}else{
	//update existing
	
}	
$this->callback['respon']['pesan']="sukses";
$this->callback['respon']['text_msg']="Data kosong ".$datanya."<br>".print_r($master_input,true);
return;


if(empty($input['RECORD_STATUS'])){
	$filter_a="";
}else{
	$filter_a="and RECORD_STATUS='".$input['RECORD_STATUS']."'";
}			
//search --> periksa apakah data yang sama sudah ada berdasarkan INDEX
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel="WO_MASTER";
$this->MYSQL->kolom="*";					
$this->MYSQL->dimana="where RECORD_STATUS='A'  $filter_a";	
$result_a=$this->MYSQL->data();
$no=1;

foreach($result_a as $r){
	$r['NO']=$no;
	$result[]=$r;
$no++;	
}

if(empty($result)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Data kosong";
	$this->callback['result']=$result;
}else{
	$this->callback['respon']['pesan']="sukses";
	$this->callback['respon']['text_msg']="OK";
	$this->callback['result']=$result;
}
								
//end search
