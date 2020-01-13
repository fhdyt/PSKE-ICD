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
$this->MYSQL->queri = "SELECT * FROM ICD_GUDANG WHERE ICD_BARANG_KAMUS_ID = '".$input['BARANG']." ' AND ICD_GUDANG_STOK > '0'";
$result_a = $this->MYSQL->data();

foreach($result_a as $r)
    {
    $result[] = $r;
    $no++;
    }


if (empty($result))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Stok Kosong";
    $this->callback['result'] = $result;
    }
  else
    {
    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "Stok Tersedia";
    $this->callback['result'] = $result;
    }

return;
?>
