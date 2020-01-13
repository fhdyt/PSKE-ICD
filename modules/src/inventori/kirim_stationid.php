<?php
//crontrol
if (empty($params['case'])) {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
}
$input                 = $params['input_option'];
$data_detail           = array(
    'ICD_STATION_ID' => $input['STATION_ID'],
    // 'ENTRI_WAKTU' => date("Y-m-d H:i:s") ,
    // 'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
    // 'RECORD_STATUS' => "e"
);
// $check='1';
// $inventori = sprintf("%'.08d\n",$check);
$this->MYSQL           = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel    = "ICD_INVENTORI";
$this->MYSQL->record   = $data_detail;
$this->MYSQL->dimana="where ICD_NO_INVENTORI=".$input['NO_INVENTORI_SI']."";

if ($this->MYSQL->ubah() == true) {
    $this->callback['respon']['pesan']    = "sukses";
    $this->callback['respon']['text_msg'] = "Berhasil Simpan";
} else {
    $this->callback['respon']['pesan']    = "gagal";
    $this->callback['respon']['text_msg'] = "Gagal Simpan".$input['STATION_ID'].$input['NO_INVENTORI_SI'];
}
?>