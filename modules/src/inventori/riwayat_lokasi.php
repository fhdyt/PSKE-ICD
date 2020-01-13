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
$this->MYSQL->queri = "SELECT * FROM ICD_TRANSAKSI_INVENTORI WHERE ICD_NO_INVENTORI='".$input['NO_INVENTORI']."'
";
$result_a = $this->MYSQL->data();
$no = 1;

foreach($result_a as $r)
    {
    $r['NO'] = $no;
    $r['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime($r['ICD_TRANSAKSI_INVENTORI_TANGGAL'])));
    $result[] = $r;
    $no++;
    }


if (empty($result))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data kosong";
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
