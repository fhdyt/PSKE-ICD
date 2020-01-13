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
$halaman=$params['halaman'];
$batas = $params['batas'];
$posisi = $this->PAGING->cariPosisi($batas,$halaman);
//-- >>	

	//$this->callback['respon']['pesan']="gagal";
	//$this->callback['respon']['text_msg']="Data tidak ada, silahkan pilih tanggal".print_r($input,true);
	//return;
//filter
if(empty($input['keyword']) or $input['keyword']==""){
	$filter_a="";
}else{
	//$filter_a="and (WO_MASTER_NOMOR like '%".$input['keyword']."%' or  COMPANY_UNIT_NAME like '%".$input['keyword']."%' )";
	$filter_a="and (a.WO_MASTER_NOMOR like '%".$input['keyword']."%' OR a.COMPANY_UNIT_NAME like '%".$input['keyword']."%' OR b.WO_DETAIL_DESCRIPTION like '%".$input['keyword']."%')";
}


//filter WO_REKAP_APPROVE_PROSES
if(empty($input['WO_REKAP_APPROVE_PROSES'])){
	$filter_b="";
}else{
	$filter_b=" and c.WO_REKAP_APPROVE_PROSES='".$input['WO_REKAP_APPROVE_PROSES']."'";
}
//filter WO_REKAP_APPROVE_MGT
if(empty($input['WO_REKAP_APPROVE_MGT'])){
	$filter_c="";
}else{
	$filter_c=" and c.WO_REKAP_APPROVE_MGT='".$input['WO_REKAP_APPROVE_MGT']."'";
}


//filter data dari unit terkait---> berdasarkan informasi jabatan
//$user_login_array=print_r($user_login['PROPERTIES']['unit'],true);
foreach($user_login['PROPERTIES']['unit'] as  $unitku){
	$unitku_filter .="OR a.COMPANY_UNIT_ID_TO='".$unitku['COMPANY_UNIT_ID']."' ";
}
$unitku_filter =substr($unitku_filter,2);


if(empty($input['DATA_sDATE']) and empty($input['DATA_eDATE'])){
	$filter_d="";
}else
{
	$filter_d="and substring(a.ENTRI_WAKTU,1,10)>='".Date('Y-m-d',strtotime($input['DATA_sDATE']))."'  and substring(a.ENTRI_WAKTU,1,10)<='".Date('Y-m-d',strtotime($input['DATA_eDATE']))."'";
}
			
//mysql query
$tabel="WO_MASTER a, WO_DETAIL b, WO_LAMPIRAN_CCD c";
//$dimana_default="where RECORD_STATUS='".$record_status_value."'  and ($unitku_filter)    $filter_b   $filter_a  $filter_c";
$dimana_default="where 
					a.SISTEM_APPROVE_STATUS='approve' and 
					a.VERIFIKASI_STATUS='Passed' and 
					a.WO_MASTER_NOMOR=b.WO_MASTER_NOMOR and 
					a.WO_MASTER_NOMOR=c.WO_MASTER_NOMOR and 
					a.RECORD_STATUS='A' and b.RECORD_STATUS='A' and 
					c.RECORD_STATUS='A' and ($unitku_filter)".$filter_b.$filter_c.$filter_d.$filter_a;
$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel=$tabel;
$this->MYSQL->kolom="a.*,b.WO_DETAIL_DESCRIPTION,c.*";
$this->MYSQL->dimana=$dimana_default;
$this->MYSQL->batas="limit $posisi,$batas";
$this->MYSQL->urut="ORDER BY a.WO_MASTER_ID DESC";
$result_a=$this->MYSQL->data();
//-- >>


$no=$posisi+1;
foreach($result_a as $r){
	$r['NO']=$no;
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select WO_DETAIL_DESCRIPTION from WO_DETAIL where WO_MASTER_ID='".$r['WO_MASTER_ID']."' AND WO_MASTER_NOMOR='".$r['WO_MASTER_NOMOR']."' and RECORD_STATUS='A'";
	$detail=$this->MYSQL->data();
	foreach($detail as $rd){
		$r['DETAIL'] .=$rd['WO_DETAIL_DESCRIPTION']."<br>";
	}
	//end detail
	$r['WO_MASTER_TANGGALNYA']	=tanggal_format(substr($r['WO_MASTER_TANGGAL'],0,10));
	
	
	$r['TANGGAL']=Date('d/m/Y',strtotime($detail[0]['PRESENSI_LEMBUR_SPL_DETAIL_WAKTU_CHECKIN']));
	
	$spl_approve_status=$this->convertApproveStatus($r);
	//if($approve_status['FLAG']==''
	
	$r['APPROVE_STATUS']=$spl_approve_status['APPROVE_STATUS'];
	$r['ESTIMATED']=$total_jam[$no];
	//$r['DETAIL']=$details[$no];
	
	//BKL Approve Status dan HRD Verification
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select SISTEM_APPROVE_STATUS,SISTEM_APPROVE_PERSEN,PRESENSI_LEMBUR_BKL_HRD_VERIFICATION_STATUS from PRESENSI_LEMBUR_BKL where PRESENSI_LEMBUR_PROPOSAL_NOMOR='".$r['PRESENSI_LEMBUR_PROPOSAL_NOMOR']."' and RECORD_STATUS='A'";
	$bkl=$this->MYSQL->data();
	
	$bkl_approve_status=$this->convertApproveStatus($bkl[0]);
	$r['BKL_APPROVE_STATUS']=$bkl_approve_status['APPROVE_STATUS'];
	//$r['HRD_VERIFICATION']=$bkl[0]['PRESENSI_LEMBUR_BKL_HRD_VERIFICATION_STATUS'];
	
	if($bkl[0]['PRESENSI_LEMBUR_BKL_HRD_VERIFICATION_STATUS']=='approve'){
		$r['HRD_VERIFICATION']="<strong class='text-muted'><i class='fa fa-check-circle-o text-success'></i> Verified</strong>";
	}else{
		$r['HRD_VERIFICATION']=$bkl[0]['PRESENSI_LEMBUR_BKL_HRD_VERIFICATION_STATUS'];
	}
	
	
	//data untuk fitur approve menggunakan modal == approve as 
	$approve_data_json=array(
		'SISTEM_APPROVE_TABEL'=>"WO_MASTER",
		'SISTEM_APPROVE_NOREF'=>$r['WO_MASTER_ID'],
	);
	$r['APPROVE_DATA_JSON']=json_encode($approve_data_json);
	
	//-----------------------------------------------------------
	
	//data untuk fitur approve menggunakan modal === approve langsung oleh user yg bersangkutan
	//cek ketable approve apakah user login berhak melakukan approve dokumen ini
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select * from SISTEM_APPROVE where SISTEM_APPROVE_NOREF='".$r['PRESENSI_LEMBUR_SPL_ID']."' and PERSONAL_NIK='".$user_login['PERSONAL_NIK']."' and RECORD_STATUS='A'  and SISTEM_APPROVE_TABEL='PRESENSI_LEMBUR_SPL'";
	$ck_approve=$this->MYSQL->data();
	
	
	if($ck_approve[0]['CONFIG_APPROVE_DETAIL_PRIORITY']=='1'){
		//get comment admin jika kpala departemen || pro -> 1
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="select PRESENSI_LEMBUR_PROPOSAL_COMMENT from PRESENSI_LEMBUR_PROPOSAL where PRESENSI_LEMBUR_PROPOSAL_ID='".$r['PRESENSI_LEMBUR_PROPOSAL_ID']."'  and RECORD_STATUS='A'";
		$comment_proposal=$this->MYSQL->data();
	}else{ }
	
	if(empty($ck_approve)){
		$hak_approve='N';
	}else{
		$hak_approve='Y';
	}
	$approve_data_json2=array(
		'SISTEM_APPROVE_INDEX'=>$ck_approve[0]['SISTEM_APPROVE_INDEX'],
		'SISTEM_APPROVE_TABEL'=>$ck_approve[0]['SISTEM_APPROVE_TABEL'],
		'SISTEM_APPROVE_NOREF'=>$ck_approve[0]['SISTEM_APPROVE_NOREF'],
	);
	$r['APPROVE_DATA_JSON2']=array(
		'Jabatan'=>$ck_approve[0]['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'],
		'Name'=>$ck_approve[0]['PERSONAL_NAME'],
		'Unit'=>$ck_approve[0]['COMPANY_UNIT_NAME'],
		'SISTEM_APPROVE_COMMENT'=>$comment_proposal[0]['PRESENSI_LEMBUR_PROPOSAL_COMMENT'],
		'hak_approve'=>$hak_approve,		
		'json'=>json_encode($approve_data_json2),
	);
	
	
	$logs[$no]=array();
	//ambil data log
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select PRESENSI_LEMBUR_PROPOSAL_NOMOR,PRESENSI_LEMBUR_PROPOSAL_REVISI,PRESENSI_LEMBUR_PROPOSAL_ID from PRESENSI_LEMBUR_SPL where PRESENSI_LEMBUR_PROPOSAL_ID='".$r['PRESENSI_LEMBUR_PROPOSAL_ID']."' and RECORD_STATUS='E' group by PRESENSI_LEMBUR_PROPOSAL_ID,PRESENSI_LEMBUR_PROPOSAL_REVISI";
	$log[$no]=$this->MYSQL->data();
	foreach($log[$no] as $rl){
		$logs[$no][]=$rl;
	}
	$r['logs']=$logs[$no];
	
	$result[]=$r;
$no++;	
}		

					
if(empty($result_a)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Data tidak ada".$posisi.$batas;
	$this->callback['filter']=$params;
	$this->callback['result']=$result;
	//$this->callback['log']=$log;
}else{
	$this->callback['respon']['pesan']="sukses";
	$this->callback['respon']['text_msg']="OK..";
	$this->callback['filter']=$params;
	$this->callback['result']=$result;
	//$this->callback['log']=$log;
	$this->callback['result_option']['jml_halaman']=$this->pagging(array('sql'=>$sql,'batas'=>$params['batas'],'tabel'=>$tabel,'dimana_default'=>$dimana_default))->jmlhalaman;
}
?>
