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
$this->MYSQL->queri = "     SELECT *
                            FROM   ICD_TRANSAKSI_INVENTORI LEFT JOIN PERSONAL
                            ON
                            ICD_TRANSAKSI_INVENTORI.PERSONAL_NIK=PERSONAL.PERSONAL_NIK
                            WHERE  ICD_TRANSAKSI_INVENTORI.ICD_NO_INVENTORI = '".$input['NO_INVENTORI']."'
                            AND NOT (ICD_TRANSAKSI_INVENTORI.ICD_TRANSAKSI_INVENTORI_STOK_SISA < 1 AND ICD_TRANSAKSI_INVENTORI.ICD_TRANSAKSI_INVENTORI_STOK_KELUAR < 1 AND ICD_TRANSAKSI_INVENTORI.ICD_TRANSAKSI_INVENTORI_STOK_MASUK < 1)
                            GROUP BY ICD_TRANSAKSI_INVENTORI.ICD_TRANSAKSI_INVENTORI_ID
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
