<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

$input = $params['input_option'];
if (empty($input['ICD_APLIKASI_MASTER_ID']) || $input['ICD_APLIKASI_MASTER_ID'] == "")
{
$input['ICD_APLIKASI_MASTER_ID']=waktu_decimal(Date("Y-m-d H:i:s"));
$input['EDIT_OPERATOR']=$user_login['PERSONAL_NIK'];
$input['EDIT_WAKTU']=Date("Y-m-d H:i:s");
$input['RECORD_STATUS']="A";

$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_APLIKASI_MASTER";
$this->MYSQL->record = $input;

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
//////////////////////////////////////////////////////////////////////////////////////////////////////

else
{
  $data_detail3 = array(
  	'EDIT_WAKTU' => date("Y-m-d H:i:s") ,
  	'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
  	'RECORD_STATUS' => "E"
  );
  $this->MYSQL = new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel = "ICD_APLIKASI_MASTER";
  $this->MYSQL->record = $data_detail3;
  $this->MYSQL->dimana = "where ICD_APLIKASI_MASTER_ID='".$input['ICD_APLIKASI_MASTER_ID']."' AND RECORD_STATUS='A'";
  $this->MYSQL->ubah();


  $input['EDIT_OPERATOR']=$user_login['PERSONAL_NIK'];
  $input['EDIT_WAKTU']=Date("Y-m-d H:i:s");
  $input['RECORD_STATUS']="A";

  $this->MYSQL = new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel = "ICD_APLIKASI_MASTER";
  $this->MYSQL->record = $input;

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
