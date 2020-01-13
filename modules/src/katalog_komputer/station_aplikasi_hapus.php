<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }


$input = $params['input_option'];

$input3['HAPUS_OPERATOR']=$user_login['PERSONAL_NIK'];
$input3['HAPUS_WAKTU']=Date("Y-m-d H:i:s");
$input3['RECORD_STATUS']="R";

$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_STATION_ID_APLIKASI";
$this->MYSQL->record = $input3;
$this->MYSQL->dimana = "where ICD_STATION_ID_APLIKASI_ID='".$input['ICD_STATION_ID_APLIKASI_ID']."' AND RECORD_STATUS='A'";

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
