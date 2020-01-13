<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

    $INVENTORY_CONFIG=new INVENTORY_CONFIG();
    $barang_id = $INVENTORY_CONFIG->barang_id();

$input = $params['input_option'];
if (empty($input['KODE_BARANG_MASTER']) || $input['KODE_BARANG_MASTER'] == ""){
  $data_detail = array(
    'ICD_BARANG_KODE' => $barang_id,
    'ICD_BARANG_NAMA' => $input['BARANG_NAMA'],
    'ICD_BARANG_JENIS' => $input['BARANG_JENIS'],
    'ICD_JENIS_KARTU_STOK' => $input['KARTU_STOK'],
    'WO_UNIT_ID' => $input['SATUAN'],
    'ICD_BARANG_SPESIFIKASI' => $input['BARANG_SPESIFIKASI'],
    'ICD_BARANG_MERK' => $input['BARANG_MERK'],
    'ICD_BARANG_TYPE' => $input['BARANG_TYPE'],
    'ICD_BARANG_KETERANGAN' => $input['BARANG_KETERANGAN'],
    'ENTRI_WAKTU' => date("Y-m-d H:i:s") ,
    'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "A"
);
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_BARANG_MASTER";
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
}

else
{
  $data_detail3 = array(
  	'EDIT_WAKTU' => date("Y-m-d H:i:s") ,
  	'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
  	'RECORD_STATUS' => "E"
  );
  $this->MYSQL = new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel = "ICD_BARANG_MASTER";
  $this->MYSQL->record = $data_detail3;
  $this->MYSQL->dimana = "where ICD_BARANG_KODE='".$input['KODE_BARANG_MASTER']."' AND RECORD_STATUS='A'";
  $this->MYSQL->ubah();

  $data_detail = array(
    'ICD_BARANG_KODE' => $input['KODE_BARANG_MASTER'],
    'ICD_BARANG_NAMA' => $input['BARANG_NAMA'],
    'ICD_BARANG_JENIS' => $input['BARANG_JENIS'],
    'ICD_JENIS_KARTU_STOK' => $input['KARTU_STOK'],
    'WO_UNIT_ID' => $input['SATUAN'],
    'ICD_BARANG_SPESIFIKASI' => $input['BARANG_SPESIFIKASI'],
    'ICD_BARANG_MERK' => $input['BARANG_MERK'],
    'ICD_BARANG_TYPE' => $input['BARANG_TYPE'],
    'ICD_BARANG_KETERANGAN' => $input['BARANG_KETERANGAN'],
    'ENTRI_WAKTU' => date("Y-m-d H:i:s") ,
    'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "A"
);
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_BARANG_MASTER";
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
}
?>
