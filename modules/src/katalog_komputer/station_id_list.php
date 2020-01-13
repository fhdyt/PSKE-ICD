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
if(empty($input['keyword']) or $input['keyword']=="")
{
    $filter_a="";
}
else
{
    $filter_a="AND (I.ICD_STATION_ID like '%".$input['keyword']."%' OR P.PERSONAL_NAME like '%".$input['keyword']."%')";
}

$sql                   = "SELECT *,C.COMPANY_UNIT_NAME AS DEPT FROM ICD_STATION_ID AS I, COMPANY_UNIT AS C, PERSONAL AS P, ICD_IP_ADDRESS AS IP WHERE I.COMPANY_UNIT_ID=C.COMPANY_UNIT_ID AND I.PERSONAL_NIK=P.PERSONAL_NIK AND I.ICD_STATION_ID=IP.ICD_STATION_ID AND P.RECORD_STATUS='A' AND IP.RECORD_STATUS='A' AND I.RECORD_STATUS='A' ".$filter_a." GROUP BY I.ICD_STATION_ID";
$this->MYSQL           = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri=$sql." limit ". $posisi.",".$batas;
$result_a              = $this->MYSQL->data();
//-- >>
$no                    = $posisi + 1;
foreach ($result_a as $r) {
    $r['NO']                                     = $no;
    $sql2 = "SELECT * FROM
                  ICD_TRANSAKSI_INVENTORI
              WHERE
                  ICD_TRANSAKSI_INVENTORI_LOKASI='".$r['ICD_STATION_ID']."' AND RECORD_STATUS='A'";
    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql2 ;
    $result_b = $this->MYSQL->data();

    if (empty($result_b))
    {
      $r['ITEM']='GAGAL';
    }
    else
    {
      $r['ITEM']='BERHASIL';
    }
    $sql3 = "SELECT * FROM
                  ICD_STATION_ID_APLIKASI
              WHERE
                  ICD_STATION_ID='".$r['ICD_STATION_ID']."' AND RECORD_STATUS='A'";
    $this->MYSQL = new MYSQL();
    $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
    $this->MYSQL->queri = $sql3 ;
    $result_b2 = $this->MYSQL->data();

    if (empty($result_b2))
    {
      $r['APLIKASI']='GAGAL';
    }
    else
    {
      $r['APLIKASI']='BERHASIL';
    }

    $result[]                                    = $r;
    $no++;
}
if (empty($result_a)) {
    $this->callback['respon']['pesan']    = "gagal";
    $this->callback['respon']['text_msg'] = "Data tidak ada";
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
