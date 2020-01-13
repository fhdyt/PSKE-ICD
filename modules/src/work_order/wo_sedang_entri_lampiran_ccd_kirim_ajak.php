<?php
//crontrol
if(empty($params['case'])){
	$result['respon']['pesan']=="gagal";
	$result['respon']['pesan']=="Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}

//$this->callback['respon']['pesan']="gagal cie dfd";
	//				$this->callback['respon']['text_msg']=$respon['respon']['text_msg'];
	//return;

$input=$params['input_option'];

//INPUT SEDANG ENTRI
if($input['proses']=="kirim")
{
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select * from WO_LAMPIRAN where RECORD_STATUS='N' and WO_MASTER_ID='".$input['WO_MASTER_ID']."'  and WO_MASTER_NOMOR='".$input['WO_MASTER_NOMOR']."'";				
	$ck=$this->MYSQL->data();
	if(empty($ck))
	{
		$data_lampiran=array(
													'WO_LAMPIRAN_INDEX'		=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_LAMPIRAN_ID'		=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_LAMPIRAN_NO'		=>"",
													'WO_LAMPIRAN_REVISI'	=>"",
													'WO_MASTER_ID'			=>$input['WO_MASTER_ID'],
													'WO_MASTER_NOMOR'		=>$input['WO_MASTER_NOMOR'],
													'WO_LAMPIRAN_JENIS'		=>$input['WO_LAMPIRAN_JENIS'],
													'WO_LAMPIRAN_FUNGSI'  	=>$input['WO_LAMPIRAN_FUNGSI'],
													'WO_LAMPIRAN_DAMPAK'	=>$input['WO_LAMPIRAN_DAMPAK'],
													'WO_LAMPIRAN_KONDISI'	=>$input['WO_LAMPIRAN_KONDISI'],
													'WO_LAMPIRAN_TUJUAN'	=>$input['WO_LAMPIRAN_TUJUAN'],
													'WO_LAMPIRAN_PRIORITAS'	=>$input['WO_LAMPIRAN_PRIORITAS'],
													'ENTRI_OPERATOR'			=>$user_login['PERSONAL_NIK'],
													'ENTRI_WAKTU'				=>date("Y-m-d H:i:s"),
													'RECORD_STATUS'				=>"A"
													);
										$this->MYSQL= new MYSQL;
										$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
										$this->MYSQL->tabel="WO_LAMPIRAN_CCD";
										$this->MYSQL->record=$data_lampiran;	
			if($this->MYSQL->simpan()==true)
			{
				
				//
				$record['WO_MASTER_LAMPIRAN_STATUS']	="Selesai";
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->tabel="WO_MASTER";
				$this->MYSQL->record=$record;
				$this->MYSQL->dimana="where RECORD_STATUS='A' and WO_MASTER_ID='".$input['WO_MASTER_ID']."'";			
				$this->MYSQL->ubah();
				//
				
				
				$this->callback['respon']['pesan']="sukses";
				$this->callback['respon']['text_msg']="Data Berhasil Disimpan".print_r($data_alasan,true);
			}else
			{
				$this->callback['respon']['pesan']="gagal";
				$this->callback['respon']['text_msg']="Gagal Disimpan";
			}
	
	}else
	{	
		
		
		
	}
	
				########################### 5. Kirim permintaan approve
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select WO_MASTER_ID,WO_MASTER_NOMOR,WO_MASTER_REVISI,WO_MASTER_INDEX,COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME from WO_MASTER where RECORD_STATUS='A' and WO_MASTER_ID='".$input['WO_MASTER_ID']."'";				
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
				
				if($input['WO_LAMPIRAN_JENIS']=="Internal")
				{
					$linkapprove="?show=wo/html/transaction/work_order_lampiran_ccd/".$ck_wo[0]['WO_MASTER_ID']."/";
				}else{
					$linkapprove="?show=wo/html/transaction/work_order_lampiran_ccd_eksternal/".$ck_wo[0]['WO_MASTER_ID']."/";
				}
				
				$input_option_a=array(
						'COMPANY_UNIT_ID'=>$ck_wo[0]['COMPANY_UNIT_ID'],
						'CONFIG_APPROVE_TABEL'=>"WO_MASTER",
						'SISTEM_APPROVE_NOREF'=>$ck_wo[0]['WO_MASTER_ID'],
						'SISTEM_APPROVE_INDEXREF'=>$ck_wo[0]['WO_MASTER_INDEX'],
						'SISTEM_APPROVE_DOKUMEN_LINK'=>$linkapprove,//"?show=presensi/pdf/".$this->STORE_CONFIG->transaksi()->faktur_pdf_link_params[$input['STORE_INVOICE_TYPE']]."/".$ck[0]['STORE_INVOICE_INDEX']."/",
						'SISTEM_APPROVE_DESKRIPSI'=>"Permintaan approval WO No.".$input['WO_MASTER_NOMOR'],//$this->STORE_CONFIG->transaksi()->approve_preperti[$input['STORE_INVOICE_TYPE']]['SISTEM_APPROVE_DESKRIPSI']." ".$ck[0]['STORE_INVOICE_ID'],
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
					$this->callback['respon']['text_msg']="Permintaan approval WO telah dikirim";// <br>".print_r($input_option_a,true)."<br>".$respon['respon']['pesan']."<br>".$respon['respon']['text_msg'];
				}else{
					$this->callback['respon']['pesan']="gagal";
					$this->callback['respon']['text_msg']=$respon['respon']['text_msg'];
				}
		###-============================================================================
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
