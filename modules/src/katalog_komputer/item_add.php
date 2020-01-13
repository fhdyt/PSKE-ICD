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
$data_detail = array(
    'ICD_BARANG_KAMUS_INDEX' => $input['KODE_BARANG'],
    'ICD_INVENTORI_IT_KETERANGAN' => $input['BARANG_KETERANGAN'],
    'ICD_INVENTORI_IT_JUMLAH' => $input['JUMLAH'],
    'ICD_STATION_ID' => $input['STATION_ID'],
    'ENTRI_WAKTU' => date("Y-m-d H:i:s") ,
    'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "A"
);
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_INVENTORI_IT";
$this->MYSQL->record = $data_detail;
$this->MYSQL->simpan();
$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = "SELECT * FROM ICD_INVENTORI_IT AS I, ICD_GUDANG AS G WHERE G.ICD_BARANG_KAMUS_INDEX=I.ICD_BARANG_KAMUS_INDEX AND G.ICD_BARANG_KAMUS_INDEX='".$input['KODE_BARANG']."' AND G.ICD_GUDANG_BPG='".$input['BPG']."' ORDER BY I.ICD_INVENTORI_IT_NO_INVENTORI DESC limit 1";
$result_a = $this->MYSQL->data() [0];

$data = array(
    'ICD_INVENTORI_IT_NO_INVENTORI' => $result_a['ICD_INVENTORI_IT_NO_INVENTORI'],
    'PERSONAL_NIK' => $input['PENANGGUNG_JAWAB'],
    'ICD_PENANGANAN_TANGGAL_PENANGANAN' => $input['TANGGAL'],
    'ICD_PENANGANAN_WO' => $input['WO'],
    'ICD_PENANGANAN_BPB' => $input['BPB'],
    'ENTRI_WAKTU' => date("Y-m-d H:i:s") ,
    'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "A"
);
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_PENANGANAN";
$this->MYSQL->record = $data;
$kurang = $result_a['ICD_GUDANG_STOK'] - $input['JUMLAH'];
if ($this->MYSQL->simpan() == true)
    {
    $data_detail = array(
        'ICD_GUDANG_STOK' => $kurang,
    );
    $this->MYSQL = new MYSQL;
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->tabel = "ICD_GUDANG";
    $this->MYSQL->record = $data_detail;
    $this->MYSQL->dimana = "where ICD_BARANG_KAMUS_INDEX='" . $input['KODE_BARANG'] . "' AND RECORD_STATUS='A' AND ICD_GUDANG_BPG = '" . $input['BPG'] . "'";
    $this->MYSQL->ubah();

    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "Tersimpan".$kurang;
    }
  else
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Gagal Simpan";
    }

?>