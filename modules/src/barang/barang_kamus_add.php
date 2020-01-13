<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

$input = $params['input_option'];
$data_detail = array(
    'ICD_BARANG_KAMUS_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
    'ICD_BARANG_KODE' => $input['KODE_INVENTORI_IT'],
    'ICD_BARANG_LCS_KODE' => $input['KODE_INVENTORI_LCS'],
    'ENTRI_WAKTU' => date("Y-m-d H:i:s") ,
    'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "A"
);
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_BARANG_KAMUS";
$this->MYSQL->record = $data_detail;

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