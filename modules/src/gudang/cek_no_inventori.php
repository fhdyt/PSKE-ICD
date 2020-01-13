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
$this->MYSQL->queri = "SELECT * FROM ICD_TRANSAKSI_GUDANG AS G
                            LEFT JOIN ICD_TRANSAKSI_INVENTORI AS I
                            ON G.ICD_NO_INVENTORI=I.ICD_NO_INVENTORI
                            WHERE G.ICD_NO_INVENTORI='" . $input['NO_INVENTORI'] . "' AND G.RECORD_STATUS='A'";
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
