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
    $filter_a="AND (ICD_BARANG_NAMA like '%".$input['keyword']."%' OR  ICD_BARANG_KODE like '%".$input['keyword']."%' )";
}

$sql                   = "SELECT * FROM ICD_BARANG_MASTER WHERE RECORD_STATUS='A' ".$filter_a." ORDER BY ICD_BARANG_KODE DESC";
$this->MYSQL           = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri=$sql." limit ". $posisi.",".$batas;
$result_a              = $this->MYSQL->data();
//-- >>
$no                    = $posisi + 1;
foreach ($result_a as $r) {
    $r['NO']                                     = $no;

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
    $this->callback['result_option']['jml_halaman']=$this->pagging(array('sql'=>$sql,'batas'=>$batas))->jmlhalaman;
}
?>
