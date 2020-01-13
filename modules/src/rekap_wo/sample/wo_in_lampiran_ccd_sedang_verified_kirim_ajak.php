<?php
//crontrol
if(empty($params['case'])){
	$result['respon']['pesan']=="gagal";
	$result['respon']['pesan']=="Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}

$input=$params['input_option'];

		//$this->callback['respon']['pesan']="sukses";
		//$this->callback['respon']['text_msg']="Data Berhasil diubah".print_r($input,true);
	//return;
$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select * from WO_MASTER where RECORD_STATUS='A' and WO_MASTER_ID='".$input['WO_MASTER_ID']."'";				
$ck=$this->MYSQL->data();

//$this->callback['respon']['pesan']="gagal";
//$this->callback['respon']['text_msg']="Item tidak ditemukan".print_r($record,true);
//return;


if(empty($ck)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Item tidak ditemukan".$input['WO_MASTER_ID'];
}else
{
	
	$record['WO_MASTER_COMMENT']	=$input['WO_MASTER_COMMENT'];
	$record['VERIFIKASI_OPERATOR']	=$user_login['PERSONAL_NIK'];
	$record['VERIFIKASI_WAKTU']		=date("Y-m-d H:i:s");	
	if($input['VERIFIKASI_STATUS']=='Revise')
	{
		$record['VERIFIKASI_STATUS']="Revise";
	}else
	{
		$record['VERIFIKASI_STATUS']="Passed";
	}
	# 1.b set Record Status=N menjadi A data baru yang sudah direvisi.
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->tabel="WO_MASTER";
	$this->MYSQL->record=$record;
	$this->MYSQL->dimana="where RECORD_STATUS='A' and WO_MASTER_ID='".$input['WO_MASTER_ID']."'";			
	if($this->MYSQL->ubah()==true)
	{	
		if($record['VERIFIKASI_STATUS']=="Passed")
		{
			########################### 5. Kirim permintaan approve
					$this->MYSQL=new MYSQL();
					$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->queri="select WO_MASTER_ID,WO_MASTER_NOMOR,WO_MASTER_REVISI,WO_MASTER_INDEX,COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME from WO_MASTER where RECORD_STATUS='A' and WO_MASTER_ID='".$input['WO_MASTER_ID']."'";				
					$ck_wo=$this->MYSQL->data();
					
					# cek personal approve
					$this->MYSQL=new MYSQL();
					$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->queri="select PERSONAL_NIK,PERSONAL_NAME,COMPANY_UNIT_ID,COMPANY_UNIT_NAME,COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME from CONFIG_APPROVE_DETAIL 
												WHERE  RECORD_STATUS='A' AND PERSONAL_NIK='".$input['APPROVAL_TUJUAN_PERSONAL_NIK']."' and CONFIG_APPROVE_MASTER_APLIKASI_ID='wo' AND CONFIG_APPROVE_DETAIL_TYPE='in'";
					$cek_info_approval=$this->MYSQL->data();
					
					if($ck[0]['WO_MASTER_JENIS']=="Internal")
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
							'COMPANY_UNIT_ID'=>$ck_wo[0]['COMPANY_UNIT_ID'],
							'CONFIG_APPROVE_TABEL'=>"WO_MASTER",
							'SISTEM_APPROVE_NOREF'=>$ck_wo[0]['WO_MASTER_ID'],
							'SISTEM_APPROVE_INDEXREF'=>$ck_wo[0]['WO_MASTER_INDEX'],
							'SISTEM_APPROVE_DOKUMEN_LINK'=>$linkapprove,//"?show=presensi/pdf/".$this->STORE_CONFIG->transaksi()->faktur_pdf_link_params[$input['STORE_INVOICE_TYPE']]."/".$ck[0]['STORE_INVOICE_INDEX']."/",
							'SISTEM_APPROVE_DESKRIPSI'=>"Permintaan approval WO No.".$input['WO_MASTER_NOMOR'],//$this->STORE_CONFIG->transaksi()->approve_preperti[$input['STORE_INVOICE_TYPE']]['SISTEM_APPROVE_DESKRIPSI']." ".$ck[0]['STORE_INVOICE_ID'],
							'SISTEM_APPROVE_TYPE'=>"in",
							'SISTEM_APPROVE_MODEL'=>$SISTEM_APPROVE_MODEL,//$this->STORE_CONFIG->transaksi()->approve_preperti[$input['STORE_INVOICE_TYPE']]['SISTEM_APPROVE_TYPE'], //type approve in/out
							
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
									'CONFIG_APPROVE_DETAIL_TYPE'=>"in",
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
					if($respon['respon']['pesan']=="sukses")
					{
						///////////////////////// NOTOFIKASI  
								//CARI USER YANG JABATANNYA ADMINISTRATOR DI DEPT PEMOHON
								$this->MYSQL=new MYSQL();
								$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
								$this->MYSQL->queri="select PERSONAL_NIK from COMPANY_STRUKTUR_ORGANISASI where RECORD_STATUS='A' and COMPANY_UNIT_ID='".$ck_wo[0]['COMPANY_UNIT_ID']."' AND (COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME LIKE '%administrator%' OR COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME LIKE '%Administrator%')";				
								$ck_user=$this->MYSQL->data();
								foreach($ck_user as $r_user){
										$NOTIFICATION_TO_USER			=$r_user['PERSONAL_NIK'];//"5974,5914,5909,5985,recruitment";
										$NOTIFICATION_DESCRIPTION		="WO No.".$ck[0]['WO_MASTER_NOMOR']." sudah diverifikasi dan diteruskan kepada ".$cek_info_approval[0]['PERSONAL_NAME'];
										
											$NOTIFICATION_LINK_VIEW			="?show=wo/transaction/work_order/wo_out/".$ck[0]['WO_MASTER_ID']."/".$ck[0]['WO_MASTER_INDEX']."/";
											$ENTRI_WAKTU					=date("Y-m-d H:i:s");
											$to								=explode(",",$NOTIFICATION_TO_USER);
														
												
												$RECRUITMENT_FEEDBACK_INDEX		=waktu_decimal(Date("Y-m-d H:i:s"));
												$RECRUITMENT_FEEDBACK_ID		=waktu_decimal(Date("Y-m-d H:i:s"));
												$RECRUITMENT_FEEDBACK_NAME		="Work Order Verified";
												$RECRUITMENT_FEEDBACK_COMMENT	="Work Order Verified";
													
										
										//==============================================================
										
										////=================
										#intro ->> ambil data taget notifi dari tabel default -> USER_STATIC_PRIVILEGES (group_id atau personal_nik)
										$static_response=$this->static_privileges(array('USER_MODULES_CLASS_NAME'=>"wo_master"));
										
										#1. Option bagian notifi
										$data_array_notifi=array(
											'NOTIFICATION_LINK_VIEW'=>$NOTIFICATION_LINK_VIEW, //link shortcut menuju file target yang dinotifikasikan
										);
										//'NOTIFICATION_LINK_VIEW'=>"?show=sistem/company/feedback/".$data_array['COMPANY_CUSTOMER_FEEDBACK_INDEX']."/", //link shortcut menuju file target yang dinotifikasikan
										
										
										#2. Option Bagian share
										$data_array_share=array(
											'USER_DATA_SHARE_WRITE'=>"Y", // Y or N
											'USER_DATA_SHARE_READ'=>"Y", //Y or N
											'USER_DATA_SHARE_TO'=>$r_user['PERSONAL_NIK'],//$static_response[0]['USER_STATIC_PRIVILEGES_TO'],//"5985", //dibagikan kepada (personal_nik atau group_id) # saat ini data hanya bisa diisi singgle misal nik saja atau group_id saja. /////---> tidak bisa seperti ini (5985,adminutility) ini penggabungan group id dan nik. 
											'USER_DATA_SHARE_DESTINATION_ID'=>$data_array['COMPANY_CUSTOMER_FEEDBACK_ID'], //id data yang dishare
										); 
										
										#3. Global Optional						
										$options=array(
											'PERSONAL_NIK'=>$user_login['PERSONAL_NIK'], //from user --> jika tidak ada buat aja "system"
											'NOTIFICATION_DESCRIPTION_FOR_GROUP'=>$NOTIFICATION_DESCRIPTION,
											'NOTIFICATION_DESCRIPTION_FOR_PERSON'=>$NOTIFICATION_DESCRIPTION,
										);
										//'NOTIFICATION_DESCRIPTION_FOR_GROUP'=>"Ada feedback baru di group ".$static_response[0]['USER_STATIC_PRIVILEGES_TO'],
										//'NOTIFICATION_DESCRIPTION_FOR_PERSON'=>"Ada feedback baru ke " .$static_response[0]['USER_STATIC_PRIVILEGES_TO'],
										
										#4. Gunakan fungsi 
										$response=$this->sharing($data_array_share,$data_array_notifi,$options);
										$pesan=$response['pesan'];
										$text_msg=$response['text_msg'];//."".$static_response[0]['USER_STATIC_PRIVILEGES_TO'];	 
								}
							//END CARI
						//////////////////////////END NOTOFIKASI  
						$this->callback['respon']['pesan']="sukses";
						$this->callback['respon']['text_msg']="Permintaan approval WO telah dikirim";// <br>".print_r($input_option_a,true)."<br>".$respon['respon']['pesan']."<br>".$respon['respon']['text_msg'];
					}else
					{
						$this->callback['respon']['pesan']="gagal";
						$this->callback['respon']['text_msg']=$respon['respon']['text_msg'];
					}
			
			
		}else
		{
			/////////////////////////KIRIM NOTIFIKASI
				//CARI USER YANG JABATANNYA ADMINISTRATOR DI DEPT PEMOHON
					$this->MYSQL=new MYSQL();
					$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->queri="select PERSONAL_NIK from COMPANY_STRUKTUR_ORGANISASI where RECORD_STATUS='A' and COMPANY_UNIT_ID='".$ck[0]['COMPANY_UNIT_ID']."' AND (COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME LIKE '%administrator%' OR COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME LIKE '%Administrator%')";
					$ck_user=$this->MYSQL->data();
					foreach($ck_user as $r_user){
							$NOTIFICATION_TO_USER			=$r_user['PERSONAL_NIK'];//"5974,5914,5909,5985,recruitment";
							$NOTIFICATION_DESCRIPTION		="Menyarankan revisi WO No.".$ck[0]['WO_MASTER_NOMOR'];
								$NOTIFICATION_LINK_VIEW			="?show=wo/transaction/work_order/wo_out/".$ck[0]['WO_MASTER_ID']."/".$ck[0]['WO_MASTER_INDEX']."/";
								$ENTRI_WAKTU					=date("Y-m-d H:i:s");
								$to								=explode(",",$NOTIFICATION_TO_USER);
											
									
									$RECRUITMENT_FEEDBACK_INDEX		=waktu_decimal(Date("Y-m-d H:i:s"));
									$RECRUITMENT_FEEDBACK_ID		=waktu_decimal(Date("Y-m-d H:i:s"));
									$RECRUITMENT_FEEDBACK_NAME		="Work Order Revised";
									$RECRUITMENT_FEEDBACK_COMMENT	="Work Order Revised";
										
							
							//==============================================================
							
							////=================
							#intro ->> ambil data taget notifi dari tabel default -> USER_STATIC_PRIVILEGES (group_id atau personal_nik)
							$static_response=$this->static_privileges(array('USER_MODULES_CLASS_NAME'=>"wo_master"));
							
							#1. Option bagian notifi
							$data_array_notifi=array(
								'NOTIFICATION_LINK_VIEW'=>$NOTIFICATION_LINK_VIEW, //link shortcut menuju file target yang dinotifikasikan
							);
							//'NOTIFICATION_LINK_VIEW'=>"?show=sistem/company/feedback/".$data_array['COMPANY_CUSTOMER_FEEDBACK_INDEX']."/", //link shortcut menuju file target yang dinotifikasikan
							
							
							#2. Option Bagian share
							$data_array_share=array(
								'USER_DATA_SHARE_WRITE'=>"Y", // Y or N
								'USER_DATA_SHARE_READ'=>"Y", //Y or N
								'USER_DATA_SHARE_TO'=>$r_user['PERSONAL_NIK'],//$static_response[0]['USER_STATIC_PRIVILEGES_TO'],//"5985", //dibagikan kepada (personal_nik atau group_id) # saat ini data hanya bisa diisi singgle misal nik saja atau group_id saja. /////---> tidak bisa seperti ini (5985,adminutility) ini penggabungan group id dan nik. 
								'USER_DATA_SHARE_DESTINATION_ID'=>$data_array['COMPANY_CUSTOMER_FEEDBACK_ID'], //id data yang dishare
							); 
							
							#3. Global Optional						
							$options=array(
								'PERSONAL_NIK'=>$user_login['PERSONAL_NIK'], //from user --> jika tidak ada buat aja "system"
								'NOTIFICATION_DESCRIPTION_FOR_GROUP'=>$NOTIFICATION_DESCRIPTION,
								'NOTIFICATION_DESCRIPTION_FOR_PERSON'=>$NOTIFICATION_DESCRIPTION,
							);
							//'NOTIFICATION_DESCRIPTION_FOR_GROUP'=>"Ada feedback baru di group ".$static_response[0]['USER_STATIC_PRIVILEGES_TO'],
							//'NOTIFICATION_DESCRIPTION_FOR_PERSON'=>"Ada feedback baru ke " .$static_response[0]['USER_STATIC_PRIVILEGES_TO'],
							
							#4. Gunakan fungsi 
							$response=$this->sharing($data_array_share,$data_array_notifi,$options);
							$pesan=$response['pesan'];
							$text_msg=$response['text_msg'];//."".$static_response[0]['USER_STATIC_PRIVILEGES_TO'];	 
					}
				//END CARI
			//////////////////////////END NOTOFIKASI 
			$this->callback['respon']['pesan']="sukses";
			$this->callback['respon']['text_msg']="Data Berhasil dikirim";//.print_r($data_alasan,true);
		}
		
	}else
	{
		$this->callback['respon']['pesan']="gagal";
		$this->callback['respon']['text_msg']="Gagal Mengubah";
	}
}
	
?>
