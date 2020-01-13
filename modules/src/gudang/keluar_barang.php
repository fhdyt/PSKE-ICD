<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}

$input = $params['input_option'];
$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = "SELECT * FROM ICD_TRANSAKSI_INVENTORI WHERE ICD_NO_INVENTORI='" . $input['NO_INVENTORI'] . "' AND ICD_TRANSAKSI_INVENTORI_STATUS='A' ";
$result_a = $this->MYSQL->data() [0];
$sisa = $result_a['ICD_TRANSAKSI_INVENTORI_STOK_SISA'] - $input['JUMLAH_KELUAR'];

$data_detail3 = array(
	'ICD_TRANSAKSI_INVENTORI_STATUS' => "O"
);
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_TRANSAKSI_INVENTORI";
$this->MYSQL->record = $data_detail3;
$this->MYSQL->dimana = "where ICD_NO_INVENTORI='" . $input['NO_INVENTORI'] . "' AND ICD_TRANSAKSI_INVENTORI_STATUS='A'";
$this->MYSQL->ubah();

$data_detail = array(
	'ICD_NO_INVENTORI' => $input['NO_INVENTORI'],
	'ICD_TRANSAKSI_INVENTORI_ID' => waktu_decimal(Date("Y-m-d H:i:s")) ,
	'ICD_TRANSAKSI_INVENTORI_BPB' => $input['BPB'],
	'ICD_TRANSAKSI_INVENTORI_WO' => $input['WO'],
	'PERSONAL_NIK' => $input['PENANGGUNG_JAWAB'],
	'ICD_TRANSAKSI_INVENTORI_TANGGAL' => $input['TANGGAL_KELUAR_GUDANG'],
	'ICD_TRANSAKSI_INVENTORI_STOK_KELUAR' => $input['JUMLAH_KELUAR'],
	'ICD_TRANSAKSI_INVENTORI_STOK_SISA' => $sisa,
  'ICD_TRANSAKSI_INVENTORI_LOKASI' => $input['LOKASI_STOK'],
	'ICD_TRANSAKSI_INVENTORI_KETERANGAN' => $input['KETERANGAN_KELUAR'],
	'ICD_TRANSAKSI_INVENTORI_STATUS' => "A",
	'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
	'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
	'RECORD_STATUS' => "A"
);
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_TRANSAKSI_INVENTORI";
$this->MYSQL->record = $data_detail;

if ($this->MYSQL->simpan() == true)
	{
	$this->callback['respon']['pesan'] = "sukses";
	$this->callback['respon']['text_msg'] = "Tersimpan";
	}
  else
	{
	$this->callback['respon']['pesan'] = "gagal";
	$this->callback['respon']['text_msg'] = "Gagal Simpan";
	}

?>
