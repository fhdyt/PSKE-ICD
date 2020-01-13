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
  $this->MYSQL->tabel = "ICD_APLIKASI_MASTER";
  $this->MYSQL->record = $data_detail3;
  $this->MYSQL->dimana = "where ICD_APLIKASI_MASTER_ID='".$input['ID_APLIKASI']."' AND RECORD_STATUS='A'";

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
