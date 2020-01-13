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
$this->MYSQL->queri = " SELECT *
                        FROM   ICD_TRANSAKSI_GUDANG AS G,
                               ICD_BARANG_MASTER AS M,
                               ICD_TRANSAKSI_INVENTORI AS T,
                               WO_UNIT AS W
                        WHERE  M.WO_UNIT_ID = W.WO_UNIT_ID
                               AND M.ICD_BARANG_KODE = G.ICD_BARANG_KODE
                               AND G.ICD_NO_INVENTORI=T.ICD_NO_INVENTORI
                               AND T.ICD_TRANSAKSI_INVENTORI_STATUS='A'
                               AND M.RECORD_STATUS='A'
                               AND T.ICD_TRANSAKSI_INVENTORI_STOK_SISA > 0
                               AND G.ICD_BARANG_KODE = ".$input['ICD_BARANG_KODE']."
                               ORDER BY G.ICD_NO_INVENTORI DESC
";
$result_a = $this->MYSQL->data();
$no = 1;

foreach($result_a as $r)
    {
    $r['NO'] = $no;
    $r['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime($r['ICD_TRANSAKSI_GUDANG_TANGGAL'])));
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
