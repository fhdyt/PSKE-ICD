<?php
//crontrol
if (empty($params['case'])) {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
}
$input                 = $params['input_option'];
$no_inventori = $this->no_inventori();
$data_detail           = array(
    'ICD_NO_INVENTORI' => $no_inventori,
    'ICD_BARANG_KAMUS_ID' => $input['KODE_BARANG_IT'],
    'ICD_GUDANG_TANGGAL' => $input['TANGGAL'],
    'ICD_GUDANG_WO' => $input['WO'],
    'ICD_GUDANG_PPB' => $input['PPB'],
    'ICD_GUDANG_BPG' => $input['BPG'],
    'ICD_GUDANG_BTB' => $input['BTB'],
    'ICD_GUDANG_STOK' => $input['JUMLAH'],
    'ICD_GUDANG_KETERANGAN' => $input['KETERANGAN'],
    'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
    'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "A"
);
$this->MYSQL           = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel    = "ICD_GUDANG";
$this->MYSQL->record   = $data_detail;
if ($this->MYSQL->simpan() == true) {
    $data_detail           = array(
    'ICD_KARTU_STOK_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
    'ICD_BARANG_KAMUS_ID' => $input['KODE_BARANG_IT'],
    'ICD_KARTU_STOK_TANGGAL' => date("Y-m-d H:i:s"),
    'ICD_KARTU_STOK_IN' => $input['JUMLAH'],

);
$this->MYSQL           = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel    = "ICD_KARTU_STOK";
$this->MYSQL->record   = $data_detail;
$this->MYSQL->simpan();
    $this->callback['respon']['pesan']    = "sukses";
    $this->callback['respon']['text_msg'] = "Berhasil Simpan";
} else {
    $this->callback['respon']['pesan']    = "gagal";
    $this->callback['respon']['text_msg'] = "Gagal Simpan";
}
?>