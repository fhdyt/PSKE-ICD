<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

$input = $params['input_option'];

  $data_detail3 = array(
  	'HAPUS_WAKTU' => date("Y-m-d H:i:s") ,
  	'HAPUS_OPERATOR' => $user_login['PERSONAL_NIK'],
  	'RECORD_STATUS' => "R"
  );
  $this->MYSQL = new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel = "ICD_TRANSAKSI_GUDANG";
  $this->MYSQL->record = $data_detail3;
  $this->MYSQL->dimana = "where ICD_NO_INVENTORI='".$input['NO_INVENTORI']."' AND RECORD_STATUS='A'";
  $this->MYSQL->ubah();

  $data_detail2 = array(
  	'HAPUS_WAKTU' => date("Y-m-d H:i:s") ,
  	'HAPUS_OPERATOR' => $user_login['PERSONAL_NIK'],
  	'RECORD_STATUS' => "R"
  );
  $this->MYSQL = new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel = "ICD_TRANSAKSI_INVENTORI";
  $this->MYSQL->record = $data_detail2;
  $this->MYSQL->dimana = "where ICD_NO_INVENTORI='".$input['NO_INVENTORI']."' AND RECORD_STATUS='A'";
  if ($this->MYSQL->ubah() == true)
    {
    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "Berhasil Simpan";
    }
  else
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Gagal Simpan";
    }

?>
