<?php
//crontrol
if (empty($params['case'])) {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
}

$input                 = $params['input_option'];
// $sql = "SELECT * FROM
//               ICD_STATION_ID
//           WHERE
//         			ICD_STATION_ID='".$input['STATION_ID_ID']."'
// 					AND
// 							RECORD_STATUS='A'";
// $this->MYSQL = new MYSQL();
// $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
// $this->MYSQL->queri = $sql ;
// $result_a = $this->MYSQL->data();
//
$this->MYSQL           = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri    = "select * from ICD_STATION_ID WHERE ICD_STATION_ID='".$input['STATION_ID_ID']."' and RECORD_STATUS='A'";
$result_a = $this->MYSQL->data();
if (empty($result_a))
{
  //CARI PERSONAL
	$this->MYSQL           = new MYSQL;
	$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri    = "select PERSONAL_NAME from PERSONAL WHERE PERSONAL_NIK='".$input['PENANGGUNG_JAWAB']."' and RECORD_STATUS='A'";
	$PERSONAL_NAME=$this->MYSQL->data()[0]['PERSONAL_NAME'];

	//CARI DEPT
	$this->MYSQL           = new MYSQL;
	$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri    = "select COMPANY_UNIT_NAME from COMPANY_UNIT WHERE COMPANY_UNIT_ID='".$input['DEPARTEMEN']."' and RECORD_STATUS='A'";
	$COMPANY_UNIT_NAME=$this->MYSQL->data()[0]['COMPANY_UNIT_NAME'];

	$data_detail           = array(
		'ICD_STATION_ID' => $input['STATION_ID_ID'],
		'ICD_STATION_ID_LOKASI' => $input['LOKASI'],
		'COMPANY_UNIT_ID' => $input['DEPARTEMEN'],
		'COMPANY_UNIT_NAME' => $COMPANY_UNIT_NAME,
		'PERSONAL_NIK' => $input['PENANGGUNG_JAWAB'],
		'PERSONAL_NAME' => $PERSONAL_NAME,
		'ICD_STATION_ID_KONDISI' => $input['KONDISI'],
		'ICD_STATION_ID_KETERANGAN' => $input['KETERANGAN'],
		'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
		'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
		'RECORD_STATUS' => "A"
	);
	$this->MYSQL           = new MYSQL;
	$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->tabel    = "ICD_STATION_ID";
	$this->MYSQL->record   = $data_detail;
if ($this->MYSQL->simpan() == true)
{
	$IP_ADDRESS = $input['IP_ADDRESS'];
	foreach($IP_ADDRESS as $key => $value)
	{
		$data_ip = array(
			'ICD_STATION_ID' => $data_detail['ICD_STATION_ID'],
			'ICD_IP_ADDRESS' => $input['IP_ADDRESS'][$key],
			'ICD_MAC_ADDRESS' => $input['MAC_ADDRESS'][$key],
			'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
			'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
			'RECORD_STATUS' => "A"
		);
		$this->MYSQL = new MYSQL;
		$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->tabel = "ICD_IP_ADDRESS";
		$this->MYSQL->record = $data_ip;
		$this->MYSQL->simpan();
	}

	$this->callback['respon']['pesan']    = "sukses";
	$this->callback['respon']['text_msg'] = "Berhasil Simpan";
}
else
{
	$this->callback['respon']['pesan']    = "gagal";
	$this->callback['respon']['text_msg'] = "Gagal Simpan";
}

}



else
{
  $input3['EDIT_OPERATOR']=$user_login['PERSONAL_NIK'];
  $input3['EDIT_WAKTU']=Date("Y-m-d H:i:s");
  $input3['RECORD_STATUS']="E";

  $this->MYSQL = new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel = "ICD_STATION_ID";
  $this->MYSQL->record = $input3;
  $this->MYSQL->dimana = "where ICD_STATION_ID='".$input['STATION_ID_ID']."' AND RECORD_STATUS='A'";
  $this->MYSQL->ubah();

  //CARI PERSONAL
	$this->MYSQL           = new MYSQL;
	$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri    = "select PERSONAL_NAME from PERSONAL WHERE PERSONAL_NIK='".$input['PENANGGUNG_JAWAB']."' and RECORD_STATUS='A'";
	$PERSONAL_NAME=$this->MYSQL->data()[0]['PERSONAL_NAME'];

	//CARI DEPT
	$this->MYSQL           = new MYSQL;
	$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri    = "select COMPANY_UNIT_NAME from COMPANY_UNIT WHERE COMPANY_UNIT_ID='".$input['DEPARTEMEN']."' and RECORD_STATUS='A'";
	$COMPANY_UNIT_NAME=$this->MYSQL->data()[0]['COMPANY_UNIT_NAME'];

	$data_detail           = array(
		'ICD_STATION_ID' => $input['STATION_ID_ID'],
		'ICD_STATION_ID_LOKASI' => $input['LOKASI'],
		'COMPANY_UNIT_ID' => $input['DEPARTEMEN'],
		'COMPANY_UNIT_NAME' => $COMPANY_UNIT_NAME,
		'PERSONAL_NIK' => $input['PENANGGUNG_JAWAB'],
		'PERSONAL_NAME' => $PERSONAL_NAME,
		'ICD_STATION_ID_KONDISI' => $input['KONDISI'],
		'ICD_STATION_ID_KETERANGAN' => $input['KETERANGAN'],
		'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
		'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
		'RECORD_STATUS' => "A"
	);
	$this->MYSQL           = new MYSQL;
	$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->tabel    = "ICD_STATION_ID";
	$this->MYSQL->record   = $data_detail;
  
  if ($this->MYSQL->simpan() == true)
      {
      $this->callback['respon']['pesan'] = "sukses";
      $this->callback['respon']['text_msg'] = "Berhasil Simpan";
      }
    else
      {
      $this->callback['respon']['pesan'] = "gagal";
      $this->callback['respon']['text_msg'] = "Gagal Simpan";
      }
}

?>
