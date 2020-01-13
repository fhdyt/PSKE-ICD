<?php
//crontrol
if(empty($params['case'])){
	$result['respon']['pesan']=="gagal";
	$result['respon']['pesan']=="Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}

$input=$params['input_option'];

//INPUT SEDANG ENTRI
if($input['proses']=="kirim")
{
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select WO_MASTER_ID,WO_MASTER_NOMOR,WO_MASTER_REVISI,WO_MASTER_INDEX,COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME from WO_MASTER where RECORD_STATUS='N' and WO_MASTER_ID='".$input['index']."'";				
	$ck=$this->MYSQL->data();


	if($input['type']=='draft'){
		$record['RECORD_STATUS']="S";
		$record_edit['RECORD_STATUS']="E";
	}else{
		$record['RECORD_STATUS']="A";
		$record_edit['RECORD_STATUS']="E";
		if($ck[0]['WO_MASTER_REVISI']>=1){ }else
		{
			if($input['WO_MASTER_TYPE']=="Manual")
			{
				$record['WO_MASTER_NOMOR']=$input['WO_MASTER_NOMOR'];
			}else
			{
				$record['WO_MASTER_NOMOR']=$this->wo_nomor_create(array('COMPANY_UNIT_SHORT_NAME'=>$ck[0]['COMPANY_UNIT_SHORT_NAME']))->callback['nomor'];
			}
		}
	}

	//$this->callback['respon']['pesan']="gagal";
	//$this->callback['respon']['text_msg']="Item tidak ditemukan".print_r($record,true);
	//return;


	if(empty($ck)){
		$this->callback['respon']['pesan']="gagal";
		$this->callback['respon']['text_msg']="Item tidak ditemukan".$input['WO_MASTER_ID'];
	}else{	
		
		
		$record['COMPANY_UNIT_ID_TO']				=$input['COMPANY_UNIT_ID_TO'];
		$record['COMPANY_UNIT_NAME_TO']				=$input['COMPANY_UNIT_NAME_TO'];
		$record['COMPANY_UNIT_SHORT_NAME_TO']		=$input['COMPANY_UNIT_SHORT_NAME_TO'];
		$record['WO_MASTER_TANGGAL']				=$input['WO_MASTER_TANGGAL'];
		$record['VERIFIKASI_STATUS']				="Check";
		if(empty($input['WO_MASTER_JENIS']) or $input['WO_MASTER_JENIS']=="")
		{
			$record['WO_MASTER_JENIS']="Internal";
		}else
		{
			$record['WO_MASTER_JENIS']					=$input['WO_MASTER_JENIS'];
		}
		$record['WO_MASTER_LAMPIRAN']				=$input['WO_MASTER_LAMPIRAN'];
		
		
		
		//INSERT UPDATE ITEM WO
		$WO_DETAIL_DESCRIPTION=$input['WO_DETAIL_DESCRIPTION'];
		foreach($WO_DETAIL_DESCRIPTION as $key_detail => $value_detail)
			{
				$tabel_detail			="WO_DETAIL a";
				$dimana_default_detail	="where a.WO_MASTER_ID='".$input['WO_MASTER_ID']."' and (a.RECORD_STATUS='N' or a.RECORD_STATUS='A') 
											and a.WO_DETAIL_DESCRIPTION='".$value_detail."'";
				$this->MYSQL= new MYSQL;
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->tabel=$tabel_detail;
				$this->MYSQL->kolom="a.*";
				$this->MYSQL->dimana=$dimana_default_detail;
				$result_output_detail=$this->MYSQL->data();
				
				//unit
				$tabel_unit			="WO_UNIT a";
				$dimana_default_unit	="where a.WO_UNIT_ID='".$input['WO_UNIT_ID'][$key_detail]."' and a.RECORD_STATUS='A'";
				$this->MYSQL= new MYSQL;
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->tabel=$tabel_unit;
				$this->MYSQL->kolom="WO_UNIT_NAME";
				$this->MYSQL->dimana=$dimana_default_unit;
				$result_output_unit=$this->MYSQL->data();
				
				//end unit
				
				if(empty($result_output_detail))
				{	
					$data_detail=array(
													'WO_DETAIL_INDEX'			=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_DETAIL_ID'				=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_DETAIL_NO'				=>"0",
													'WO_MASTER_ID'				=>$input['index'],
													'WO_MASTER_NOMOR'			=>$record['WO_MASTER_NOMOR'],
													'WO_DETAIL_DESCRIPTION'		=>$value_detail,
													'WO_DETAIL_QUANTITY'		=>$input['WO_DETAIL_QUANTITY'][$key_detail],
													'WO_UNIT_ID'				=>$input['WO_UNIT_ID'][$key_detail],
													'WO_UNIT_NAME'				=>$result_output_unit[0]['WO_UNIT_NAME'],
													'WO_DETAIL_DATE_COMPLETED'	=>$input['WO_DETAIL_DATE_COMPLETED'][$key_detail],
													'WO_DETAIL_TUJUAN'			=>$input['WO_DETAIL_TUJUAN'][$key_detail],
													'WO_DETAIL_NOREKENING'			=>$input['WO_DETAIL_NOREKENING'][$key_detail],
													'ENTRI_OPERATOR'			=>$user_login['PERSONAL_NIK'],
													'ENTRI_WAKTU'				=>date("Y-m-d H:i:s"),
													'RECORD_STATUS'				=>"A"
													);
										$this->MYSQL= new MYSQL;
										$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
										$this->MYSQL->tabel="WO_DETAIL";
										$this->MYSQL->record=$data_detail;	
										$this->MYSQL->simpan();
							
				}else
				{
				}
			}
			//END ITEM WO
		
		
		# 1.b set Record Status=N menjadi A data baru yang sudah direvisi.
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->tabel="WO_MASTER";
		$this->MYSQL->record=$record;
		$this->MYSQL->dimana="where RECORD_STATUS='N' and WO_MASTER_ID='".$input['index']."'";			
		if($this->MYSQL->ubah()==true)
		{
			//BANDINGKAN APAKAH WO ADALAH CCD
			if($input['WO_MASTER_LAMPIRAN']=="Y")
			{
				//SIMPAN TEMPORARY APPROVE 
					# cek personal approve
					$this->MYSQL=new MYSQL();
					$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
					//$this->MYSQL->queri="select PERSONAL_NIK,PERSONAL_NAME,COMPANY_UNIT_ID,COMPANY_UNIT_NAME,COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME from CONFIG_APPROVE_DETAIL 
					//							WHERE  RECORD_STATUS='A' AND PERSONAL_NIK='".$input['APPROVAL_DEPT_PERSONAL_NIK']."' and CONFIG_APPROVE_MASTER_APLIKASI_ID='wo'";
												
					$this->MYSQL->queri="select 
									a.PERSONAL_NIK,
									a.PERSONAL_NAME, 
									a.CONFIG_APPROVE_DETAIL_SET_FOR,
									a.CONFIG_APPROVE_DETAIL_SET_FOR_UNIT_NAME,
									a.COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME,
									b.COMPANY_UNIT_SHORT_NAME 
										from 
										CONFIG_APPROVE_DETAIL a, COMPANY_UNIT b
									WHERE 
										a.CONFIG_APPROVE_DETAIL_SET_FOR=b.COMPANY_UNIT_ID and  
										a.PERSONAL_NIK='".$input['APPROVAL_DEPT_PERSONAL_NIK']."' and 
										a.CONFIG_APPROVE_MASTER_APLIKASI_ID='wo' and
										b.COMPANY_UNIT_ID='".$ck[0]['COMPANY_UNIT_ID']."' and 
										a.RECORD_STATUS='A'";// AND b.COMPANY_UNIT_TYPE='Department'";	
					$cek_info_approval=$this->MYSQL->data();
					
					
					$data_temporary=array(
													'WO_TEMPORARY_APPROVE_INDEX'		=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_TEMPORARY_APPROVE_ID'			=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_MASTER_ID'						=>$input['index'],
													'WO_MASTER_NOMOR'					=>$record['WO_MASTER_NOMOR'],
													'COMPANY_UNIT_ID'						=>$cek_info_approval[0]['CONFIG_APPROVE_DETAIL_SET_FOR'],
													'COMPANY_UNIT_NAME'  					=>$cek_info_approval[0]['CONFIG_APPROVE_DETAIL_SET_FOR_UNIT_NAME'],
													'COMPANY_UNIT_SHORT_NAME'				=>$cek_info_approval[0]['COMPANY_UNIT_SHORT_NAME'],
													'PERSONAL_NIK'								=>$cek_info_approval[0]['PERSONAL_NIK'],
													'PERSONAL_NAME'								=>$cek_info_approval[0]['PERSONAL_NAME'],
													'COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'	=>$cek_info_approval[0]['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'],
													'ENTRI_OPERATOR'			=>$user_login['PERSONAL_NIK'],
													'ENTRI_WAKTU'				=>date("Y-m-d H:i:s"),
													'RECORD_STATUS'				=>"A"
													);
										$this->MYSQL= new MYSQL;
										$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
										$this->MYSQL->tabel="WO_TEMPORARY_APPROVE";
										$this->MYSQL->record=$data_temporary;	
										$this->MYSQL->simpan();
					
				//END TEMPORARY APPROVE
				$this->callback['respon']['pesan']="sukses";
				$this->callback['respon']['lampiran']="Y";
				$this->callback['respon']['jenis']=$record['WO_MASTER_JENIS'];
				$this->callback['respon']['WO_MASTER_ID']=$input['index'];
				$this->callback['respon']['WO_MASTER_NOMOR']=$record['WO_MASTER_NOMOR'];
				$this->callback['respon']['text_msg']="Data Berhasil dikirim";//.print_r($data_alasan,true);
				
			}else
			{
				# 5. Kirim permintaan approve
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select WO_MASTER_ID,WO_MASTER_NOMOR,WO_MASTER_REVISI,WO_MASTER_INDEX,COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME from WO_MASTER where RECORD_STATUS='A' and WO_MASTER_ID='".$input['index']."'";				
				$ck_wo=$this->MYSQL->data();
				
				
				# cek personal approve
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select PERSONAL_NIK,PERSONAL_NAME,COMPANY_UNIT_ID,COMPANY_UNIT_NAME,COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME,SISTEM_DELIGASI_TO_NIK,SISTEM_DELIGASI_TO_NAME from CONFIG_APPROVE_DETAIL 
											WHERE  RECORD_STATUS='A' AND PERSONAL_NIK='".$input['APPROVAL_DEPT_PERSONAL_NIK']."' and CONFIG_APPROVE_MASTER_APLIKASI_ID='wo' and CONFIG_APPROVE_DETAIL_TYPE='out'";
				$cek_info_approval=$this->MYSQL->data();
				
				
				//DRAFT-PPKB/IT/IMS/RQS(KARYAWAN BARU)-20171226-001
				$nomorDRAFT=explode("/",$record['WO_MASTER_NOMOR']);
				$nomorDRAFT1=explode("-",$nomorDRAFT[3]);
				$nomorDRAFT2=$nomorDRAFT[1]."-".$nomorDRAFT1[1]."-".$nomorDRAFT1[2];
				
				$input_option_a=array(
						'COMPANY_UNIT_ID'=>$ck[0]['COMPANY_UNIT_ID'],
						'CONFIG_APPROVE_TABEL'=>"WO_MASTER",
						'SISTEM_APPROVE_NOREF'=>$ck_wo[0]['WO_MASTER_ID'],
						'SISTEM_APPROVE_INDEXREF'=>$ck_wo[0]['WO_MASTER_INDEX'],
						'SISTEM_APPROVE_DOKUMEN_LINK'=>"?show=wo/html/transaction/work_order/".$ck_wo[0]['WO_MASTER_ID']."/",//"?show=presensi/pdf/".$this->STORE_CONFIG->transaksi()->faktur_pdf_link_params[$input['STORE_INVOICE_TYPE']]."/".$ck[0]['STORE_INVOICE_INDEX']."/",
						'SISTEM_APPROVE_DESKRIPSI'=>"Permintaan approval WO No.".$record['WO_MASTER_NOMOR'],//$this->STORE_CONFIG->transaksi()->approve_preperti[$input['STORE_INVOICE_TYPE']]['SISTEM_APPROVE_DESKRIPSI']." ".$ck[0]['STORE_INVOICE_ID'],
						'SISTEM_APPROVE_TYPE'=>"out",
						'SISTEM_APPROVE_MODEL'=>"work_order",//$this->STORE_CONFIG->transaksi()->approve_preperti[$input['STORE_INVOICE_TYPE']]['SISTEM_APPROVE_TYPE'], //type approve in/out
						
						//optional data
						//'SISTEM_APPROVE_CONFIG_OPTIONAL'=>$personal_approval,
						
						'SISTEM_APPROVE_CONFIG_OPTIONAL'=>array(
								'PERSONAL_NIK'=>$cek_info_approval[0]['PERSONAL_NIK'],
								'PERSONAL_NAME'=>$cek_info_approval[0]['PERSONAL_NAME'],
								'COMPANY_UNIT_ID'=>$cek_info_approval[0]['COMPANY_UNIT_ID'],
								'COMPANY_UNIT_NAME'=>$cek_info_approval[0]['COMPANY_UNIT_NAME'],
								'COMPANY_STRUKTUR_ORGANISASI_ID'=>"",
								'COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'=>$cek_info_approval[0]['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'],
								'CONFIG_APPROVE_DETAIL_PRIORITY'=>"1",
								'SISTEM_DELIGASI_TO_NIK'=>$cek_info_approval[0]['SISTEM_DELIGASI_TO_NIK'],
								'SISTEM_DELIGASI_TO_NAME'=>$cek_info_approval[0]['SISTEM_DELIGASI_TO_NAME'],
								'OWNER_COMPANY_UNIT_ID'=>$cek_info_approval[0]['COMPANY_UNIT_ID'],
								'OWNER_COMPANY_UNIT_NAME'=>$cek_info_approval[0]['COMPANY_UNIT_NAME'],
								'CONFIG_APPROVE_DETAIL_TYPE'=>"out",
								'CONFIG_APPROVE_TABEL'=>"WO_MASTER",
							),
				);
				$params_a=array(
					'case'=>"nonlogin_sistem_approve_persiapan",//constant
					'data_http'=>$_COOKIE['data_http'],
					'token_http'=>$_COOKIE['token_http'],
					'input_option'=>$input_option_a,
				);
				$respon=$this->SISTEM->sistem_approve($params_a)->load->module;		
				if($respon['respon']['pesan']=="sukses"){
					$this->callback['respon']['pesan']="sukses";
					$this->callback['respon']['lampiran']="N";
					$this->callback['respon']['text_msg']="Permintaan approval WO telah dikirim \n".print_r($cek_info_approval,true);//." \n".print_r($cek_info_approval,true);// <br>".print_r($input_option_a,true)."<br>".$respon['respon']['pesan']."<br>".$respon['respon']['text_msg'];
				}else{
					$this->callback['respon']['pesan']="gagal";
					$this->callback['respon']['text_msg']=$respon['respon']['text_msg'];
				}
			}
			//END
		}else{
			$this->callback['respon']['pesan']="gagal";
			$this->callback['respon']['text_msg']="Gagal Mengubah";
		}
		###-============================================================================
		
		
		if($input['type']=='draft'){
			return;
		}else{}	
	}
}else
{
	//KIRIM SEDANG PROSES ENTRI
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select WO_MASTER_ID,WO_MASTER_NOMOR,WO_MASTER_REVISI,WO_MASTER_INDEX,COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME 
						from WO_MASTER where RECORD_STATUS='N' and WO_MASTER_ID='".$input['WO_MASTER_ID']."'";
	$ck=$this->MYSQL->data();
	if(empty($ck)){
		$this->callback['respon']['pesan']="gagal";
		$this->callback['respon']['text_msg']="Item tidak ditemukan".$input['WO_MASTER_ID'];
	}else
	{	
		/*
		$record['PKB_PERMINTAAAN_TANGGAL']		=$input['PKB_PERMINTAAAN_TANGGAL'];
		$record['PKB_KETERANGAN']				=$input['PKB_KETERANGAN'];
		$record['PKB_DIBUTUHKAN_JUMLAH']		=$input['PKB_DIBUTUHKAN_JUMLAH'];
		$record['VERIFIKASI_STATUS']			="Check";
		$record['PERSONAL_JABATAN_MASTER_ID']		=$input['PERSONAL_JABATAN_MASTER_ID'];
		$record['PERSONAL_JABATAN_MASTER_NAME']		=$input['PERSONAL_JABATAN_MASTER_NAME'];
		$record['TOOL_FILES_NAME']		=$input['TOOL_FILES_NAME'];
		
		*/
		
		
		# 1.b set Record Status=N menjadi A data baru yang sudah direvisi.
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->tabel="WO_MASTER";
		$this->MYSQL->record=$record;
		$this->MYSQL->dimana="where RECORD_STATUS='N' and WO_MASTER_ID='".$input['WO_MASTER_ID']."'";			
		if($this->MYSQL->ubah()==true){
			$this->callback['respon']['pesan']="sukses";
			$this->callback['respon']['text_msg']="Data Berhasil dikirim";//.print_r($data_alasan,true);
		}else{
			$this->callback['respon']['pesan']="gagal";
			$this->callback['respon']['text_msg']="Gagal Mengubah";
		}
		###-============================================================================
	}	
}
?>
