<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

$input = $params['input_option'];

$input['ICD_STATION_ID_KONFIGURASI_ID']=waktu_decimal(Date("Y-m-d H:i:s"));
$input['ENTRI_OPERATOR']=$user_login['PERSONAL_NIK'];
$input['ENTRI_WAKTU']=Date("Y-m-d H:i:s");
$input['RECORD_STATUS']="A";

$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_STATION_ID_KONFIGURASI";
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

?>
