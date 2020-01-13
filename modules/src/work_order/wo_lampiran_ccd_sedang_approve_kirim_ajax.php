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
$this->MYSQL->queri="select * from WO_LAMPIRAN_CCD where RECORD_STATUS='A' and WO_MASTER_ID='".$input['WO_MASTER_ID']."'";				
$ck=$this->MYSQL->data();
if(empty($ck)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Item tidak ditemukan".print_r($input,true);
}else
{
	if($input['aksi']=="prioritas")
	{
		if($input['WO_LAMPIRAN_PRIORITAS']=="undefined")
		{
		}else
		{
			$record['WO_LAMPIRAN_PRIORITAS']	=$input['WO_LAMPIRAN_PRIORITAS'];
		}
	}else
	{
		if($input['WO_LAMPIRAN_TERIMA']=="undefined")
		{
		}else
		{
			$record['WO_LAMPIRAN_TERIMA']	=$input['WO_LAMPIRAN_TERIMA'];
		}
	}
	
	$record['TERIMA_PRIORITAS_OPERATOR']	=$user_login['PERSONAL_NIK'];
	$record['TERIMA_PRIORITAS_WAKTU']		=date("Y-m-d H:i:s");	
	
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->tabel="WO_LAMPIRAN_CCD";
	$this->MYSQL->record=$record;
	$this->MYSQL->dimana="where RECORD_STATUS='A' and WO_MASTER_ID='".$input['WO_MASTER_ID']."'";			
	if($this->MYSQL->ubah()==true)
	{
			$this->callback['respon']['pesan']="sukses";
			$this->callback['respon']['text_msg']="Data Berhasil dikirim";//.print_r($data_alasan,true);		
	}else
	{
		$this->callback['respon']['pesan']="gagal";
		$this->callback['respon']['text_msg']="Gagal Mengubah";
	}
}
	
?>
