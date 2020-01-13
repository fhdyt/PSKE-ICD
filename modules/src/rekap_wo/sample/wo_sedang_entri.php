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

//filter untuk halaman grid list
if(empty($input['WO_MASTER_NOMOR'])){
	$filter_c="";
	$record_status='N';
	$owner_data="and ENTRI_OPERATOR='".$user_login['PERSONAL_NIK']."'"; //owner saat entri data
}else{
	$filter_c=" and WO_MASTER_NOMOR='".$input['WO_MASTER_NOMOR']."'";
	$record_status='A';
	$owner_data=""; 
}



$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select * from WO_MASTER where ENTRI_OPERATOR='".$user_login['PERSONAL_NIK']."' and RECORD_STATUS='N'";	
$result_a=$this->MYSQL->data();
$no=1;
foreach($result_a as $r){
	//AMBIL DATA DEPARTMENT
	if($r['COMPANY_UNIT_NAME']=="IT Departement")
	{
		$quaery_department="select COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME, COMPANY_UNIT_NAME from COMPANY_UNIT WHERE  RECORD_STATUS='A' AND (COMPANY_UNIT_TYPE='Department' OR COMPANY_UNIT_TYPE='Non-Departement')";
	}else
	{
		$quaery_department="select COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME, COMPANY_UNIT_NAME from COMPANY_UNIT WHERE  RECORD_STATUS='A' AND (COMPANY_UNIT_TYPE='Department' OR COMPANY_UNIT_TYPE='Non-Departement') AND COMPANY_UNIT_NAME='CC Departement'";
	}
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri=$quaery_department;//"select COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME, COMPANY_UNIT_NAME from COMPANY_UNIT WHERE  RECORD_STATUS='A' AND (COMPANY_UNIT_TYPE='Department' OR COMPANY_UNIT_TYPE='Non-Departement')";	
	$result_department=$this->MYSQL->data();
	$r['DEPARTMENT']=$result_department;
	
	//AMBIL APPROVAL
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select PERSONAL_NIK,PERSONAL_NAME from CONFIG_APPROVE_DETAIL 
		WHERE CONFIG_APPROVE_MASTER_APLIKASI_ID='wo' AND CONFIG_APPROVE_DETAIL_SET_FOR='".$r['COMPANY_UNIT_ID']."' AND RECORD_STATUS='A' AND CONFIG_APPROVE_DETAIL_TYPE='out'";	
	$result_approval=$this->MYSQL->data();
	$r['CONFIG_APPROVE_DETAIL']=$result_approval;
	
	
	
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select WO_UNIT_ID,WO_UNIT_NAME from WO_UNIT WHERE RECORD_STATUS='A'";	
	$result_unit=$this->MYSQL->data();
	$r['UNIT']=$result_unit;
	//
	if($r['WO_MASTER_NOMOR']=="-")
	{
		$r['WO_MASTER_TANGGAL']=Date("Y-m-d");
	}else
	{
		$r['WO_MASTER_TANGGAL']=$r['WO_MASTER_TANGGAL'];
	}
	
				
		 //TANGGAL INDONESIA */
			$tgl=$r['WO_MASTER_TANGGAL'];
			$indonesia=new indonesia;
			$indonesia->tgl_indo($tgl);
			$r['WO_MASTER_TANGGAL_2']=$indonesia->tanggal."-".substr($indonesia->bulan,0,3)."-".substr($indonesia->tahun,2,2);
		
	//AMBIL DATA NO WO TERAHIR
	/*
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select * from WO_NOTERAKHIR WHERE  RECORD_STATUS='A' AND COMPANY_UNIT_ID='".$r['COMPANY_UNIT_ID']."'";	
	$result_noterakhir=$this->MYSQL->data();
	if(empty($result_noterakhir))
	{
		$blnWo=(int)Date('m');
		$array_bulanRomawi = array(1=>'I','II','III', 'IV', 'V', 'VI','VII','VIII','IX','X', 'XI','XII');
		$bulanWo=$array_bulanRomawi[$blnWo];
		$tahunWo=Date('Y');
		$r['NOTERAKHIRNYA']=$r['COMPANY_UNIT_SHORT_NAME']."/".$bulanWo."/".$tahunWo;
		$r['NOTERAKHIR']="kosong";
		
	}else
	{
		$r['NOTERAKHIRNYA']="";
		$r['NOTERAKHIR']="ada";
	}
	*/ 
	
	
	$result[]=$r;
$no++;	
}



if(empty($result)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Data kosong";
	$this->callback['result']=$result;
}else{
	$this->callback['respon']['pesan']="sukses";
	$this->callback['respon']['text_msg']="OK".print_r($r['CONFIG_APPROVE_DETAIL'],true);
	$this->callback['result']=$result;
}

return;


