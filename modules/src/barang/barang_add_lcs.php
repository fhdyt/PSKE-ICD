<?php
if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

    $INVENTORY_CONFIG=new INVENTORY_CONFIG();
    $barang_lcs_id = $INVENTORY_CONFIG->barang_lcs_id();

$input = $params['input_option'];
$data_detail = array(
    'ICD_BARANG_LCS_KODE' => $barang_lcs_id,
    'ICD_BARANG_LCS_NAMA_BARANG' => $input['BARANG_LCS_NAMA'],
    'ICD_BARANG_LCS_KODE_OLD' => $input['BARANG_LCS_KODE_OLD'],
    'ENTRI_WAKTU' => date("Y-m-d H:i:s") ,
    'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
    'RECORD_STATUS' => "A"
);
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_BARANG_LCS";
$this->MYSQL->record = $data_detail;

if ($this->MYSQL->simpan() == true)
    {
    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "Berhasil Simpan";
    }
  else
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Gagal Simpan";
    }

?>
