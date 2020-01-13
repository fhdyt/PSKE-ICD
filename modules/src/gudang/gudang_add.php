<?php
$INVENTORY_CONFIG=new INVENTORY_CONFIG();
if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

$input = $params['input_option'];

// if(empty($input['LOKASI_STOK']))
// {
// 	$ICD_INVENTORI_KODE=$this->inventori_kode_create(array('ICD_BARANG_JENIS'=>$input['KODE_BARANG_INVENTORI']))->callback['nomor'];
//   $no_inventori = $INVENTORY_CONFIG->no_inventori();
//   $jumlah = $input['JUMLAH'];
// }
// else
// {
// 	$ICD_INVENTORI_KODE=$input['KODE_BARANG_INVENTORI_NEW'];
//   $no_inventori = $input['NO_INVENTORI_NEW'];
//   $jumlah = "0";
// }

if(empty($input['LOKASI_STOK']))
{
$ICD_INVENTORI_KODE=$input['KODE_BARANG_INVENTORI_NEW'];
$no_inventori = $input['NO_INVENTORI_NEW'];
$jumlah = $input['JUMLAH'];
}
else
{
	$ICD_INVENTORI_KODE=$input['KODE_BARANG_INVENTORI_NEW'];
  $no_inventori = $input['NO_INVENTORI_NEW'];
  $jumlah = "0";
}

$data_detail = array(
    'ICD_NO_INVENTORI' => $no_inventori,
    'ICD_TRANSAKSI_GUDANG_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
    'ICD_BARANG_KODE' => $input['KODE_BARANG_IT'],
    'ICD_INVENTORI_KODE' => $ICD_INVENTORI_KODE,
    'ICD_TRANSAKSI_GUDANG_TANGGAL' => $input['TANGGAL'],
    'ICD_TRANSAKSI_GUDANG_WO' => $input['WO'],
    'ICD_TRANSAKSI_GUDANG_PPB' => $input['PPB'],
    'ICD_TRANSAKSI_GUDANG_BPG' => $input['BPG'],
    'ICD_TRANSAKSI_GUDANG_BTB' => $input['BTB'],
    'ICD_TRANSAKSI_GUDANG_KETERANGAN' => $input['KETERANGAN'],
    'ENTRI_WAKTU' => date("Y-m-d H:i:s") ,
    'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "A"
);
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_TRANSAKSI_GUDANG";
$this->MYSQL->record = $data_detail;
$this->MYSQL->simpan();

if (empty($input['LOKASI_STOK']))
{
  $lokasi="GUDANG";
}
else
{
  $lokasi=$input['LOKASI_STOK'];
}
$data = array(
    'ICD_NO_INVENTORI' => $no_inventori,
    'ICD_TRANSAKSI_INVENTORI_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
    'ICD_TRANSAKSI_INVENTORI_STOK_MASUK' => $input['JUMLAH'],
    'ICD_TRANSAKSI_INVENTORI_STOK_SISA' => $jumlah,
    'ICD_TRANSAKSI_INVENTORI_LOKASI' => $lokasi,
    'ICD_TRANSAKSI_INVENTORI_TANGGAL' => $input['TANGGAL'],
    'ICD_TRANSAKSI_INVENTORI_STATUS' => "A",
    'ICD_TRANSAKSI_INVENTORI_KETERANGAN' => $input['KETERANGAN'],
    'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
    'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "A"
);
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_TRANSAKSI_INVENTORI";
$this->MYSQL->record = $data;

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
