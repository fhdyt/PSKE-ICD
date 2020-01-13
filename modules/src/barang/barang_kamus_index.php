<?php

// crontrol

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
$this->MYSQL->queri = "SELECT * FROM ICD_GUDANG AS G, ICD_BARANG_KAMUS AS K, ICD_BARANG_MASTER AS M, ICD_BARANG_LCS AS C WHERE K.ICD_BARANG_KAMUS_INDEX=G.ICD_BARANG_KAMUS_INDEX AND K.ICD_BARANG_KODE_INVENTORI=M.ICD_BARANG_KODE_INVENTORI AND K.ICD_BARANG_LCS_KODE_INVENTORI=C.ICD_BARANG_LCS_KODE_INVENTORI AND (M.ICD_BARANG_KODE_INVENTORI LIKE '%" . $input['q'] . "%' OR M.ICD_BARANG_NAMA LIKE '%" . $input['q'] . "%') AND M.RECORD_STATUS='A' AND K.RECORD_STATUS='A' AND C.RECORD_STATUS='A' GROUP BY K.ICD_BARANG_KAMUS_INDEX";
$result_a = $this->MYSQL->data();
$no = 1;

foreach($result_a as $r)
	{
	$result[] = $r;
	$no++;
	}

if (empty($result))
	{
	$this->callback['respon']['pesan'] = "gagal";
	$this->callback['respon']['text_msg'] = "Data kosong _" . $input['q'];
	$this->callback['result'] = $result;
	}
  else
	{
	$this->callback['respon']['pesan'] = "sukses";
	$this->callback['respon']['text_msg'] = "OK" . print_r($result, true);
	$this->callback['result'] = $result;
	}

return;
?>