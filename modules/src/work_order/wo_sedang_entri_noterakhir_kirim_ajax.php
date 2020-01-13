<?php
//crontrol
if(empty($params['case'])){
	$result['respon']['pesan']=="gagal";
	$result['respon']['pesan']=="Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}

$input=$params['input_option'];
$data_detail=array(
													'WO_NOTERAKHIR_INDEX'			=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_NOTERAKHIR_ID'				=>waktu_decimal(Date("Y-m-d H:i:s")),
													'WO_NOTERAKHIR_NO'				=>"0",
													'WO_MASTER_NOMOR'				=>$input['WO_MASTER_NOMOR_TERAKHIR']."/".$input['WO_MASTER_NOMOR_TERAKHIR_LANJUT'],
													'COMPANY_UNIT_ID'				=>$input['COMPANY_UNIT_ID'],
													'COMPANY_UNIT_NAME'				=>$input['COMPANY_UNIT_NAME'],
													'COMPANY_UNIT_SHORT_NAME'		=>$input['COMPANY_UNIT_SHORT_NAME'],
													'ENTRI_OPERATOR'			=>$user_login['PERSONAL_NIK'],
													'ENTRI_WAKTU'				=>date("Y-m-d H:i:s"),
													'RECORD_STATUS'				=>"A"
													);
										$this->MYSQL= new MYSQL;
										$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
										$this->MYSQL->tabel="WO_NOTERAKHIR";
										$this->MYSQL->record=$data_detail;	
		if($this->MYSQL->simpan()==true)
		{
					$this->callback['respon']['pesan']="sukses";
		
					$this->callback['respon']['text_msg']="Berhasil dikirim";// <br>".print_r($input_option_a,true)."<br>".$respon['respon']['pesan']."<br>".$respon['respon']['text_msg'];
		}else{
					$this->callback['respon']['pesan']="gagal";
					$this->callback['respon']['text_msg']="Gagal Kirim";
			}
?>
