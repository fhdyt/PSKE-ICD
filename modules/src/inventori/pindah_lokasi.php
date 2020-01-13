<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

    $input_inventori['ICD_TRANSAKSI_INVENTORI_ID']=waktu_decimal(Date("Y-m-d H:i:s"));
    $input_inventori['ICD_TRANSAKSI_INVENTORI_STATUS']="O";
    $input_inventori['EDIT_OPERATOR']=$user_login['PERSONAL_NIK'];
		$input_inventori['EDIT_WAKTU']=Date("Y-m-d H:i:s");
		$input_inventori['RECORD_STATUS']="A";
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_TRANSAKSI_INVENTORI";
$this->MYSQL->record = $input_inventori;
$this->MYSQL->dimana = "where ICD_NO_INVENTORI='" . $input['ICD_NO_INVENTORI'] . "' AND ICD_TRANSAKSI_INVENTORI_STATUS='A'";
$this->MYSQL->ubah();

    $input['ICD_TRANSAKSI_INVENTORI_ID']=waktu_decimal(Date("Y-m-d H:i:s"));
    $input['ICD_TRANSAKSI_INVENTORI_STATUS']="A";
    $input['ENTRI_OPERATOR']=$user_login['PERSONAL_NIK'];
		$input['ENTRI_WAKTU']=Date("Y-m-d H:i:s");
		$input['RECORD_STATUS']="A";
$this->MYSQL = new MYSQL;
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->tabel = "ICD_TRANSAKSI_INVENTORI";
$this->MYSQL->record = $input;

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
