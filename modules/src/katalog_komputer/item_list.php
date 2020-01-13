<?php
//crontrol
if (empty($params['case'])) {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
}
$halaman = $params['halaman'];
$batas   = $params['batas'];
$posisi  = $this->PAGING->cariPosisi($batas, $halaman);
$input   = $params['input_option'];
$date    = date("Y-m-d");
/*
$sql                   = "SELECT *
                FROM   ICD_TRANSAKSI_INVENTORI AS I,
                       ICD_BARANG_MASTER AS B,
                       ICD_BARANG_KAMUS AS K
                WHERE  I.ICD_NO_INVENTORI = G.ICD_NO_INVENTORI
                       AND K.ICD_BARANG_KODE = B.ICD_BARANG_KODE
                       AND I.ICD_TRANSAKSI_INVENTORI_LOKASI='".$input['ICD_STATION_ID']."'
                       ORDER BY I.ICD_TRANSAKSI_INVENTORI_INDEX ASC
                            ";
                           */
$sql                   = "SELECT *
                FROM   ICD_TRANSAKSI_INVENTORI AS a,
                			ICD_TRANSAKSI_GUDANG AS b,
                       ICD_BARANG_MASTER AS c
                WHERE
                a.ICD_TRANSAKSI_INVENTORI_LOKASI='".$input['ICD_STATION_ID']."' AND
					 a.ICD_NO_INVENTORI = b.ICD_NO_INVENTORI AND
					 b.ICD_BARANG_KODE = c.ICD_BARANG_KODE
           AND a.RECORD_STATUS='A'
           AND b.RECORD_STATUS='A'
           AND c.RECORD_STATUS='A'
                       ORDER BY a.ICD_TRANSAKSI_INVENTORI_INDEX ASC";
$this->MYSQL           = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri    = $sql;
$result_a              = $this->MYSQL->data();
//-- >>
$no                    = $posisi + 1;
foreach ($result_a as $r) {
    $r['NO']                                     = $no;
    $r['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime($r['ICD_TRANSAKSI_INVENTORI_TANGGAL'])));

    $result[]                                    = $r;
    $no++;
}
if (empty($result_a)) {
    $this->callback['respon']['pesan']    = "gagal";
    $this->callback['respon']['text_msg'] = "Data item tidak ada.";
    $this->callback['filter']             = $params;
    $this->callback['result']             = $result;
} else {
    $this->callback['respon']['pesan']              = "sukses";
    $this->callback['respon']['text_msg']           = "OK..";
    $this->callback['filter']                       = $params;
    $this->callback['result']                       = $result;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
        'sql' => $sql,
        'batas' => $batas
    ))->jmlhalaman;
}
?>
