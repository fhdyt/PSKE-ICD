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
	$this->MYSQL->queri="select * from WO_MASTER where RECORD_STATUS='A' and WO_MASTER_ID='".$input['index']."'";				
	$ck=$this->MYSQL->data()[0];

	if(empty($ck)){
		$this->callback['respon']['pesan']="gagal";
		$this->callback['respon']['text_msg']="Item tidak ditemukan".$input['WO_MASTER_ID'];
	}else
	{
		//EDIT DATA MASTER SEBELUMNYA JADI E
		$record_womaster_edit=array(
						'EDIT_OPERATOR'			=>$user_login['PERSONAL_NIK'],
						'EDIT_WAKTU'				=>date("Y-m-d H:i:s"),
						'RECORD_STATUS'				=>"E"
						);
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->tabel="WO_MASTER";
		$this->MYSQL->record=$record_womaster_edit;
		$this->MYSQL->dimana="where RECORD_STATUS='A' and WO_MASTER_ID='".$ck['WO_MASTER_ID']."' and WO_MASTER_NOMOR='".$ck['WO_MASTER_NOMOR']."'";			
		$this->MYSQL->ubah();
		
		$record_wolampiranccd_edit=array(
						'EDIT_OPERATOR'			=>$user_login['PERSONAL_NIK'],
						'EDIT_WAKTU'				=>date("Y-m-d H:i:s"),
						'RECORD_STATUS'				=>"E"
						);
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->tabel="WO_LAMPIRAN_CCD";
		$this->MYSQL->record=$record_wolampiranccd_edit;
		$this->MYSQL->dimana="where RECORD_STATUS='A' and WO_MASTER_ID='".$ck['WO_MASTER_ID']."' and WO_MASTER_NOMOR='".$ck['WO_MASTER_NOMOR']."'";			
		$this->MYSQL->ubah();
		
		$record_woldetail_edit=array(
						'EDIT_OPERATOR'			=>$user_login['PERSONAL_NIK'],
						'EDIT_WAKTU'				=>date("Y-m-d H:i:s"),
						'RECORD_STATUS'				=>"E"
						);
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->tabel="WO_DETAIL";
		$this->MYSQL->record=$record_woldetail_edit;
		$this->MYSQL->dimana="where RECORD_STATUS='A' and WO_MASTER_ID='".$ck['WO_MASTER_ID']."' and WO_MASTER_NOMOR='".$ck['WO_MASTER_NOMOR']."'";			
		$this->MYSQL->ubah();
		//END EDIT 
		//INSERT UPDATE ITEM WO
		
		
		$WO_MASTER_INDEX	=waktu_decimal(Date("Y-m-d H:i:s"));
		$WO_MASTER_ID		=$input['WO_MASTER_ID'];//waktu_decimal(Date("Y-m-d H:i:s"));
		$WO_DETAIL_DESCRIPTION=$input['WO_DETAIL_DESCRIPTION'];
		foreach($WO_DETAIL_DESCRIPTION as $key_detail => $value_detail)
			{
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
				$data_detail=array(
													'WO_DETAIL_INDEX'			=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_DETAIL_ID'				=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_DETAIL_NO'				=>"0",
													'WO_MASTER_ID'				=>$WO_MASTER_ID,
													'WO_MASTER_NOMOR'			=>$ck['WO_MASTER_NOMOR'],
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
			}
			//END ITEM WO
		
		//ENTRI MASTER WO
			$record_master=array(
							'WO_MASTER_INDEX'			=>$WO_MASTER_INDEX,
							'WO_MASTER_ID'			=>$WO_MASTER_ID,
							'WO_MASTER_NO'			=>"",
							'WO_MASTER_NOMOR'			=>$ck['WO_MASTER_NOMOR'],
							'WO_MASTER_REVISI'			=>$ck['WO_MASTER_REVISI']+1,
							'COMPANY_UNIT_ID'			=>$ck['COMPANY_UNIT_ID'],
							'COMPANY_UNIT_NAME'			=>$ck['COMPANY_UNIT_NAME'],
							'COMPANY_UNIT_SHORT_NAME'			=>$ck['COMPANY_UNIT_SHORT_NAME'],
							'COMPANY_UNIT_ID_TO'			=>$ck['COMPANY_UNIT_ID_TO'],
							'COMPANY_UNIT_NAME_TO'			=>$ck['COMPANY_UNIT_NAME_TO'],
							'COMPANY_UNIT_SHORT_NAME_TO'			=>$ck['COMPANY_UNIT_SHORT_NAME_TO'],
							'WO_MASTER_TANGGAL'			=>$ck['WO_MASTER_TANGGAL'],
							'WO_MASTER_JENIS'			=>$ck['WO_MASTER_JENIS'],
							'WO_MASTER_LAMPIRAN'			=>$ck['WO_MASTER_LAMPIRAN'],
							'WO_MASTER_LAMPIRAN_STATUS'			=>$ck['WO_MASTER_LAMPIRAN_STATUS'],
							'DATA_STATUS'			=>$ck['DATA_STATUS'],
							'VERIFIKASI_STATUS'			=>"Check",
							'WO_MASTER_COMMENT'			=>$ck['WO_MASTER_COMMENT'],
							'ENTRI_OPERATOR'			=>$user_login['PERSONAL_NIK'],
							'ENTRI_WAKTU'				=>date("Y-m-d H:i:s"),
							'RECORD_STATUS'				=>"A"
			
			);
		//END
		
		
		# 1.b set Record Status=N menjadi A data baru yang sudah direvisi.
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->tabel="WO_MASTER";
		$this->MYSQL->record=$record_master;		
		if($this->MYSQL->simpan()==true)
		{
			//BANDINGKAN APAKAH WO ADALAH CCD
				$data_lampiran=array(
													'WO_LAMPIRAN_INDEX'		=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_LAMPIRAN_ID'		=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_LAMPIRAN_NO'		=>"",
													'WO_LAMPIRAN_REVISI'	=>"",
													'WO_MASTER_ID'			=>$WO_MASTER_ID,
													'WO_MASTER_NOMOR'		=>$ck['WO_MASTER_NOMOR'],
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
										$this->MYSQL->simpan();
			//	
				
///////////////////////////////			
				# 5. Kirim permintaan approve
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select WO_MASTER_ID,WO_MASTER_NOMOR,WO_MASTER_REVISI,WO_MASTER_INDEX,COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME,WO_MASTER_JENIS from WO_MASTER where RECORD_STATUS='A' and WO_MASTER_ID='".$WO_MASTER_ID."'";				
				$ck_wo=$this->MYSQL->data();
				
				
				# cek personal approve
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select PERSONAL_NIK,PERSONAL_NAME,COMPANY_UNIT_ID,COMPANY_UNIT_NAME,COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME from CONFIG_APPROVE_DETAIL 
											WHERE  RECORD_STATUS='A' AND PERSONAL_NIK='".$input['APPROVAL_DEPT_PERSONAL_NIK']."' and CONFIG_APPROVE_MASTER_APLIKASI_ID='wo' and CONFIG_APPROVE_DETAIL_TYPE='out'";
				$cek_info_approval=$this->MYSQL->data();
				
				
				if($ck_wo[0]['WO_MASTER_JENIS']=="Internal")
					{
						$linkapprove="?show=wo/html/transaction/work_order_lampiran_ccd/".$ck_wo[0]['WO_MASTER_ID']."/";	
						$SISTEM_APPROVE_MODEL="work_order";				
					}
					else
					{
						$linkapprove="?show=wo/html/transaction/work_order_lampiran_ccd_eksternal/".$ck_wo[0]['WO_MASTER_ID']."/";	
						$SISTEM_APPROVE_MODEL="work_order_eksternal";	
					}
				
				//DRAFT-PPKB/IT/IMS/RQS(KARYAWAN BARU)-20171226-001
				$nomorDRAFT=explode("/",$record['WO_MASTER_NOMOR']);
				$nomorDRAFT1=explode("-",$nomorDRAFT[3]);
				$nomorDRAFT2=$nomorDRAFT[1]."-".$nomorDRAFT1[1]."-".$nomorDRAFT1[2];
				
				$input_option_a=array(
						'COMPANY_UNIT_ID'=>$ck[0]['COMPANY_UNIT_ID'],
						'CONFIG_APPROVE_TABEL'=>"WO_MASTER",
						'SISTEM_APPROVE_NOREF'=>$ck_wo[0]['WO_MASTER_ID'],
						'SISTEM_APPROVE_INDEXREF'=>$ck_wo[0]['WO_MASTER_INDEX'],
						'SISTEM_APPROVE_DOKUMEN_LINK'=>$linkapprove,//"?show=wo/html/transaction/work_order_lampiran_ccd/".$ck_wo[0]['WO_MASTER_ID']."/",//"?show=presensi/pdf/".$this->STORE_CONFIG->transaksi()->faktur_pdf_link_params[$input['STORE_INVOICE_TYPE']]."/".$ck[0]['STORE_INVOICE_INDEX']."/",
						'SISTEM_APPROVE_DESKRIPSI'=>"Permintaan approval WO No.".$ck['WO_MASTER_NOMOR'],//$this->STORE_CONFIG->transaksi()->approve_preperti[$input['STORE_INVOICE_TYPE']]['SISTEM_APPROVE_DESKRIPSI']." ".$ck[0]['STORE_INVOICE_ID'],
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
								'SISTEM_DELIGASI_TO_NIK'=>$user_login['PERSONAL_NIK'],
								'SISTEM_DELIGASI_TO_NAME'=>$user_login['PERSONAL_NAME'],
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
					$this->callback['respon']['text_msg']="Permintaan approval WO telah dikirim";// <br>".print_r($input_option_a,true)."<br>".$respon['respon']['pesan']."<br>".$respon['respon']['text_msg'];
				}else{
					$this->callback['respon']['pesan']="gagal";
					$this->callback['respon']['text_msg']=$respon['respon']['text_msg'];
				}
			//END
		}else{
			$this->callback['respon']['pesan']="gagal";
			$this->callback['respon']['text_msg']="Gagal Mengubah";
		}
		###-============================================================================
		
	}
}else
{
}
?>
