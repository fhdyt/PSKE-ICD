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


//=========================================================SPL =================================
//filter
if($input['DATA_STATUS']=='log'){
	$filter_a=" and a.WO_MASTER_REVISI='".$input['WO_MASTER_REVISI']."'";
	$filter_record_status ="a.RECORD_STATUS='E'";
}else{
	$filter_a="";
	$filter_record_status ="a.RECORD_STATUS='A'";
}

if(empty($input['WO_MASTER_ID'])){
	$filter_b="???????????";
}else{
	$filter_b=" and a.WO_MASTER_ID='".$input['WO_MASTER_ID']."'";
}

$tabel="WO_MASTER a,WO_LAMPIRAN_CCD b";
$dimana_default="where a.WO_MASTER_ID=b.WO_MASTER_ID and a.WO_MASTER_NOMOR=b.WO_MASTER_NOMOR and $filter_record_status  $filter_b   $filter_a";
$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel=$tabel;
$this->MYSQL->kolom="*";
$this->MYSQL->dimana=$dimana_default;
$this->MYSQL->batas="limit $posisi,$batas";
$this->MYSQL->urut="ORDER BY a.WO_MASTER_ID ASC";
$result_wo=$this->MYSQL->data();
//-- >>

$no=$posisi+1;
foreach($result_wo as $r){
	//TANGGAL INDONESIA */
			$tgl=$r['WO_MASTER_TANGGAL'];
			$indonesia=new indonesia;
			$indonesia->tgl_indo($tgl);
			$r['WO_MASTER_TANGGAL_2']=$indonesia->tanggal."-".substr($indonesia->bulan,0,3)."-".substr($indonesia->tahun,2,2);
			$r['WO_MASTER_PAGE']="1 of 1";
	//AMBIL DATA DETAIL
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select WO_DETAIL_INDEX,WO_DETAIL_ID,WO_DETAIL_DESCRIPTION, WO_DETAIL_QUANTITY,WO_UNIT_ID,WO_UNIT_NAME,WO_DETAIL_DATE_COMPLETED,WO_DETAIL_NOREKENING,WO_DETAIL_TUJUAN 
						 from WO_DETAIL WHERE WO_MASTER_NOMOR='".$r['WO_MASTER_NOMOR']."' AND WO_MASTER_ID='".$r['WO_MASTER_ID']."' AND RECORD_STATUS='A'";	
	$result_detail=$this->MYSQL->data();
	$r['DETAIL']=$result_detail;
	
	//ambil data informasi divisi
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select PREV_LINK,COMPANY_UNIT_SHORT_NAME from COMPANY_UNIT where COMPANY_UNIT_ID='".$r['COMPANY_UNIT_ID']."' and RECORD_STATUS='A'";
	$personal_department=$this->MYSQL->data();

	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select COMPANY_UNIT_NAME from COMPANY_UNIT where COMPANY_UNIT_ID='".$personal_department[0]['PREV_LINK']."' and RECORD_STATUS='A'";
	$personal_divisi=$this->MYSQL->data();
	$r['COMPANY_UNIT_TYPE_DIVISI']=$personal_divisi[0]['COMPANY_UNIT_NAME'];
	
	//TUJUAN WO
	//CARI APAKAH YANG LOGIN ADALAH KA.DEPT CCD ATAU TIDAK
		$this->MYSQL->queri="select 
									PERSONAL_NIK,
									COMPANY_UNIT_NAME,
									COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME
										from 
										SISTEM_APPROVE 
										where 
									CONFIG_APPROVE_DETAIL_PRIORITY='1' and
									SISTEM_APPROVE_TABEL='WO_MASTER' and 
									SISTEM_APPROVE_TYPE='in' and
									COMPANY_UNIT_NAME='CC Departement' and
									PERSONAL_NIK='".$user_login['PERSONAL_NIK']."'
									order by PERSONAL_NIK ASC LIMIT 1";
		$result_cari=$this->MYSQL->data()[0];
		if(empty($result_cari))
		{
			$r['AKAN_DISETUJUI']="N";
		}else {$r['AKAN_DISETUJUI']="Y";}
	//END CARI		
	
	
	$wo_items[]=$r;
$no++;	
}	

//MENENTUKAN TUJUAN
		$data_tujuan=array("Investasi","Perawatan/Modifikasi","Pergantian","Umum");
		$jlh_data_tujuan=count($data_tujuan);
		$NOBB=1;
		for($is=0;$is<$jlh_data_tujuan;$is++)
		{
			if($data_tujuan[$is]==$r['WO_LAMPIRAN_TUJUAN'])
			{
				$cek_tujuan.='
					<tr>
						<td  width="17%">
							<input type="checkbox" class="form-check stkstatus stkstatus'.$NOBB.'" name="WO_LAMPIRAN_TUJUAN"  checked="checked" onClick=ubahstkstatus('.$NOBB.') value="'.$r['WO_LAMPIRAN_TUJUAN'].'">
						</td>
						<td width="83%">'.$r['WO_LAMPIRAN_TUJUAN'].'</td>
					</tr>';	
					
			}else
			{
				$cek_tujuan.='								
							<tr>
								<td width="17%">
									<input type="checkbox" class="form-check stkstatus stkstatus'.$NOBB.'" name="WO_LAMPIRAN_TUJUAN" onClick=ubahstkstatus('.$NOBB.') value="'.$data_tujuan[$is].'">
								</td>
								<td width="83%">'.$data_tujuan[$is].'</td>
							</tr>
							';
			}
			$NOBB++;
		}

		$tujuan_items=$cek_tujuan;
		//$r['TUJUAN']=$tujuan_items;
	//END TUJAN 
	

//nomor ref untuk cek ke tabel approve
$spl_approve_ref=$wo_items[0]['WO_MASTER_ID'];
$spl_approve_indexRef=$wo_items[0]['WO_MASTER_INDEX'];		

//filter untuk mendapatkan log tandatangan dari tabel sistem_approve
if($input['DATA_STATUS']=='log'){
	$filter_approve_log=" and RECORD_STATUS='E'";
}else{
	$filter_approve_log=" and RECORD_STATUS='A'";
}

//ambil informasi approve WO Dept
$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select 
							PERSONAL_NIK,
							PERSONAL_NAME,
							COMPANY_UNIT_NAME,
							COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME,
							CONFIG_APPROVE_DETAIL_PRIORITY,
							SISTEM_APPROVE_COMMENT,
							SISTEM_APPROVE_STATUS,
							SISTEM_APPROVE_DATE,
							SISTEM_APPROVE_NOREF 
								from 
								SISTEM_APPROVE 
								where 
							CONFIG_APPROVE_DETAIL_PRIORITY='1' and
							SISTEM_APPROVE_TABEL='WO_MASTER' and 
							SISTEM_APPROVE_TYPE='out' and
							SISTEM_APPROVE_NOREF='".$spl_approve_ref."' $filter_approve_log   
							order by CONFIG_APPROVE_DETAIL_PRIORITY ASC";
$result_wo_approve=$this->MYSQL->data();
foreach($result_wo_approve as $r){
	//ambil company_unit shot name
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select 
								COMPANY_UNIT_SHORT_NAME 
									from 
									COMPANY_UNIT 
									where 
								COMPANY_UNIT_NAME='".$r['COMPANY_UNIT_NAME']."' and RECORD_STATUS='A'
								order by COMPANY_UNIT_INDEX DESC LIMIT 1";
	$result_wo_approve_unit=$this->MYSQL->data();
	if(empty($result_wo_approve_unit))
	{
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="select 
									COMPANY_UNIT_SHORT_NAME 
										from 
										COMPANY_UNIT 
										where 
									COMPANY_UNIT_NAME='".$r['COMPANY_UNIT_NAME']."' and RECORD_STATUS='E'
									order by COMPANY_UNIT_INDEX DESC LIMIT 1";
		$result_wo_approve_unit2=$this->MYSQL->data();
		$r['COMPANY_UNIT_SHORT_NAME']=$result_wo_approve_unit2[0]['COMPANY_UNIT_SHORT_NAME'];
	}else{
	$r['COMPANY_UNIT_SHORT_NAME']=$result_wo_approve_unit[0]['COMPANY_UNIT_SHORT_NAME'];
	}
	//end
	
	
	
	if(substr($r['SISTEM_APPROVE_DATE'],0,4)=='0000'){
		$r['SISTEM_APPROVE_DATE_FORMAT']='-';
	}else{
		$r['SISTEM_APPROVE_DATE_FORMAT']=Date('d/m/Y',strtotime($r['SISTEM_APPROVE_DATE']));
	}
	//$r['SISTEM_APPROVE_TTD']=PLATFORM_ROOT."asset/platform/files/ttd/".$r['PERSONAL_NIK'].".png";
	if($r['SISTEM_APPROVE_STATUS']=='approve'){
		$r['SISTEM_APPROVE_TTD']=PLATFORM_ROOT."asset/platform/files/ttd/".$r['PERSONAL_NIK'].".png";
		$r['SISTEM_APPROVE_TTD_LINK']="asset/platform/files/ttd/".$r['PERSONAL_NIK'].".png";
	}else{
		$r['SISTEM_APPROVE_TTD']="-";
	}
	
	
	
	
	//approval for user login
	if($r['PERSONAL_NIK']!=$user_login['PERSONAL_NIK']){
		$r['APPROVE_DATA_JSON2']=array();
	}else{
		//data untuk fitur approve menggunakan modal === approve langsung oleh user yg bersangkutan
		//cek ketable approve apakah user login berhak melakukan approve dokumen ini
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="select * from SISTEM_APPROVE where SISTEM_APPROVE_NOREF='".$spl_approve_ref."'  and PERSONAL_NIK='".$user_login['PERSONAL_NIK']."'  $filter_approve_log  and SISTEM_APPROVE_TABEL='WO_MASTER'";
		$ck_approve=$this->MYSQL->data();
		
		if($ck_approve[0]['CONFIG_APPROVE_DETAIL_PRIORITY']=='1'){
			//get comment admin jika kpala departemen || pro -> 1
			$this->MYSQL=new MYSQL();
			$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->queri="select PRESENSI_LEMBUR_PROPOSAL_COMMENT from PRESENSI_LEMBUR_PROPOSAL where PRESENSI_LEMBUR_PROPOSAL_ID='".$result_wo[0]['PRESENSI_LEMBUR_PROPOSAL_ID']."'  and RECORD_STATUS='A'";
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
	
	}//end if
	
	
	//data untuk fitur approve menggunakan modal == approve as 
	$approve_data_json=array(
		'SISTEM_APPROVE_TABEL'=>"WO_MASTER",
		'SISTEM_APPROVE_NOREF'=>$spl_approve_ref,//$result_wo[0]['PRESENSI_LEMBUR_SPL_ID'],
	);
	$r['APPROVE_DATA_JSON_AS']=json_encode($approve_data_json);
	
	
	
	$result_wo_approve2[]=$r;
}
$approval=array(
	'GRAND_TOTAL'=>$wo_grand_total,
	'APPROVE'=>$result_wo_approve2,
);

//END

//ambil informasi approve WO Dept Tujuan
$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select 
							PERSONAL_NIK,
							PERSONAL_NAME,
							COMPANY_UNIT_NAME,
							COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME,
							CONFIG_APPROVE_DETAIL_PRIORITY,
							SISTEM_APPROVE_COMMENT,
							SISTEM_APPROVE_STATUS,
							SISTEM_APPROVE_DATE,
							SISTEM_APPROVE_NOREF 
								from 
								SISTEM_APPROVE 
								where 
							(CONFIG_APPROVE_DETAIL_PRIORITY='1' or CONFIG_APPROVE_DETAIL_PRIORITY='2') and
							SISTEM_APPROVE_TABEL='WO_MASTER' and 
							SISTEM_APPROVE_TYPE='in' and
							SISTEM_APPROVE_NOREF='".$spl_approve_ref."' $filter_approve_log   
							order by CONFIG_APPROVE_DETAIL_PRIORITY ASC";
$result_wo_approve_tujuan=$this->MYSQL->data();
if(empty($result_wo_approve_tujuan))
{
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select 
								PERSONAL_NIK,
								PERSONAL_NAME,
								COMPANY_UNIT_NAME,
								COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME,
								CONFIG_APPROVE_DETAIL_PRIORITY 
									from 
									CONFIG_APPROVE_DETAIL 
									where 
								CONFIG_APPROVE_DETAIL_TYPE='in' and
								CONFIG_APPROVE_DETAIL_PRIORITY='1' and
								CONFIG_APPROVE_MASTER_APLIKASI_ID='wo' and 
								CONFIG_APPROVE_DETAIL_SET_FOR='".$wo_items[0]['COMPANY_UNIT_ID_TO']."' and
								RECORD_STATUS='A'
								order by CONFIG_APPROVE_DETAIL_INDEX ASC LIMIT 1";
	$result_wo_approve_tujuan2A=$this->MYSQL->data();
	
	
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select 
								PERSONAL_NIK,
								PERSONAL_NAME,
								COMPANY_UNIT_NAME,
								COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME,
								CONFIG_APPROVE_DETAIL_PRIORITY 
									from 
									CONFIG_APPROVE_DETAIL 
									where 
								CONFIG_APPROVE_DETAIL_TYPE='in' and
								CONFIG_APPROVE_DETAIL_PRIORITY='2' and
								CONFIG_APPROVE_MASTER_APLIKASI_ID='wo' and 
								CONFIG_APPROVE_DETAIL_SET_FOR='all_unit' and
								 RECORD_STATUS='A'
								order by CONFIG_APPROVE_DETAIL_INDEX ASC LIMIT 1";
	$result_wo_approve_tujuan2B=$this->MYSQL->data();
	
	$result_wo_approve_tujuannya=array_merge($result_wo_approve_tujuan2A,$result_wo_approve_tujuan2B);
	
	
	//$result_wo_approve_tujuannya=$result_wo_approve_tujuan2A;
}else
{
	$result_wo_approve_tujuannya=$result_wo_approve_tujuan;
}

foreach($result_wo_approve_tujuannya as $r_tujuan)
{
	//ambil company_unit shot name
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select 
								COMPANY_UNIT_SHORT_NAME 
									from 
									COMPANY_UNIT 
									where 
								COMPANY_UNIT_NAME='".$r_tujuan['COMPANY_UNIT_NAME']."' and RECORD_STATUS='A'
								order by COMPANY_UNIT_INDEX DESC LIMIT 1";
	$result_wo_approve_tujuan_unit=$this->MYSQL->data();
	if(empty($result_wo_approve_tujuan_unit))
	{
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="select 
									COMPANY_UNIT_SHORT_NAME 
										from 
										COMPANY_UNIT 
										where 
									COMPANY_UNIT_NAME='".$r_tujuan['COMPANY_UNIT_NAME']."' and RECORD_STATUS='E'
									order by COMPANY_UNIT_INDEX DESC LIMIT 1";
		$result_wo_approve_tujuan_unit2=$this->MYSQL->data();
		$r_tujuan['COMPANY_UNIT_SHORT_NAME']=$result_wo_approve_tujuan_unit2[0]['COMPANY_UNIT_SHORT_NAME'];
	}else{
		$r_tujuan['COMPANY_UNIT_SHORT_NAME']=$result_wo_approve_tujuan_unit[0]['COMPANY_UNIT_SHORT_NAME'];
	}
	//end
	
	
	
	if(empty($r_tujuan['SISTEM_APPROVE_DATE']) or substr($r_tujuan['SISTEM_APPROVE_DATE'],0,4)=='0000'){
		$r_tujuan['SISTEM_APPROVE_DATE_FORMAT']='-';
	}else{
		$r_tujuan['SISTEM_APPROVE_DATE_FORMAT']=Date('d/m/Y',strtotime($r_tujuan['SISTEM_APPROVE_DATE']));
	}
	//$r_tujuan['SISTEM_APPROVE_TTD']=PLATFORM_ROOT."asset/platform/files/ttd/".$r_tujuan['PERSONAL_NIK'].".png";
	if($r_tujuan['SISTEM_APPROVE_STATUS']=='approve'){
		$r_tujuan['SISTEM_APPROVE_TTD']=PLATFORM_ROOT."asset/platform/files/ttd/".$r_tujuan['PERSONAL_NIK'].".png";
		$r_tujuan['SISTEM_APPROVE_TTD_LINK']="asset/platform/files/ttd/".$r_tujuan['PERSONAL_NIK'].".png";
	}else{
		$r_tujuan['SISTEM_APPROVE_TTD']="-";
	}
	
	
	
	
	//approval for user login
	if($r_tujuan['PERSONAL_NIK']!=$user_login['PERSONAL_NIK'])
	{
		$r_tujuan['APPROVE_DATA_JSON2']=array();
	}else
	{
		//data untuk fitur approve menggunakan modal === approve langsung oleh user yg bersangkutan
		//cek ketable approve apakah user login berhak melakukan approve dokumen ini
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="select * from SISTEM_APPROVE where SISTEM_APPROVE_NOREF='".$spl_approve_ref."'  and PERSONAL_NIK='".$user_login['PERSONAL_NIK']."'  $filter_approve_log  and SISTEM_APPROVE_TABEL='WO_MASTER'";
		$ck_approve=$this->MYSQL->data();
		
		if($ck_approve[0]['CONFIG_APPROVE_DETAIL_PRIORITY']=='1'){
			//get comment admin jika kpala departemen || pro -> 1
			$this->MYSQL=new MYSQL();
			$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->queri="select PRESENSI_LEMBUR_PROPOSAL_COMMENT from PRESENSI_LEMBUR_PROPOSAL where PRESENSI_LEMBUR_PROPOSAL_ID='".$result_wo[0]['PRESENSI_LEMBUR_PROPOSAL_ID']."'  and RECORD_STATUS='A'";
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
		$r_tujuan['APPROVE_DATA_JSON2']=array(
			'Jabatan'=>$ck_approve[0]['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'],
			'Name'=>$ck_approve[0]['PERSONAL_NAME'],
			'Unit'=>$ck_approve[0]['COMPANY_UNIT_NAME'],
			'SISTEM_APPROVE_COMMENT'=>$comment_proposal[0]['PRESENSI_LEMBUR_PROPOSAL_COMMENT'],
			'hak_approve'=>$hak_approve,		
			'json'=>json_encode($approve_data_json2),
		);
	
	}//end if
	
	
	//data untuk fitur approve menggunakan modal == approve as 
	$approve_data_json2=array(
		'SISTEM_APPROVE_TABEL'=>"WO_MASTER",
		'SISTEM_APPROVE_NOREF'=>$spl_approve_ref,//$result_wo[0]['PRESENSI_LEMBUR_SPL_ID'],
	);
	$r_tujuan['APPROVE_DATA_JSON_AS']=json_encode($approve_data_json2);
	
	
	
	$result_wo_approve_tujuan2[]=$r_tujuan;
}
$approval_tujuan=array(
	'GRAND_TOTAL'=>$wo_grand_total_tujuan,
	'APPROVE'=>$result_wo_approve_tujuan2,
);
//END

$nLIB=new nLIB();
$REVISI_NOMOR=$nLIB->nomor_urut(array('no_aktif'=>$wo_items[0]['WO_MASTER_REVISI'],'panjang'=>2));

$header=array(
	'LOGO'=>$this->CONFIG->dir()->document_root."asset/images/logo.png",
	'LOGO_LINK'=>"asset/images/logo.png",
	'WO_MASTER_NOMOR'=>$wo_items[0]['WO_MASTER_NOMOR'],
	'UNIT'=>$wo_items[0]['COMPANY_UNIT_SHORT_NAME'],
	'REVISI'=>$REVISI_NOMOR,
	'DOKUMEN_ID'=>$wo_items[0]['WO_MASTER_ID'],
	'JENIS'=>$result_proposal[0]['PRESENSI_LEMBUR_PROPOSAL_JENIS'],
);

				
if(empty($result_wo)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Data tidak ada,silahkan masukan nomor WO ".$input['WO_MASTER_INDEX'];
	$this->callback['filter']=$params;
	$this->callback['result']=$wo_items;
	$this->callback['result']['approval']=$approval;
	$this->callback['result']['approval_tujuan']=$approval_tujuan;
	//$this->callback['result']['tujuan']=$tujuan_items;
	$this->callback['header']=$header;
}else{
	$this->callback['respon']['pesan']="sukses";
	$this->callback['respon']['text_msg']="OK..";
	$this->callback['filter']=$params;
	$this->callback['result']=$wo_items;
	$this->callback['result']['approval']=$approval;
	$this->callback['result']['approval_tujuan']=$approval_tujuan;
	//$this->callback['result']['tujuan']=$tujuan_items;
	$this->callback['header']=$header;
	$this->callback['result_option']['jml_halaman']=$this->pagging(array('sql'=>$sql,'batas'=>$params['batas'],'tabel'=>$tabel,'dimana_default'=>$dimana_default))->jmlhalaman;
}
?>
