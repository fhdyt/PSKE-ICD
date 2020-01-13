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

$sql                   = "SELECT *,C.COMPANY_UNIT_NAME AS DEPT FROM ICD_STATION_ID AS I, COMPANY_UNIT AS C, PERSONAL AS P, ICD_IP_ADDRESS AS IP
								WHERE
								I.COMPANY_UNIT_ID=C.COMPANY_UNIT_ID AND I.PERSONAL_NIK=P.PERSONAL_NIK AND I.RECORD_STATUS='A' AND P.RECORD_STATUS='A' AND
								I.ICD_STATION_ID=IP.ICD_STATION_ID AND I.ICD_STATION_ID='".$input['ICD_STATION_ID']."'";
$this->MYSQL           = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri    = $sql;
$result_a              = $this->MYSQL->data();
//-- >>
$no                    = $posisi + 1;
foreach ($result_a as $r)
{
    $result[] = $r;
    $no++;
}


if (empty($result_a))
{
    $this->callback['respon']['pesan']    = "gagal";
    $this->callback['respon']['text_msg'] = "Data tidak ada";
    $this->callback['filter']             = $params;
    $this->callback['result']             = $result;
} else
{
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
