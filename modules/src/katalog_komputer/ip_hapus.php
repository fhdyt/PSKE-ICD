<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

$input = $params['input_option'];

  $input3['HAPUS_OPERATOR']=$user_login['PERSONAL_NIK'];
  $input3['HAPUS_WAKTU']=Date("Y-m-d H:i:s");
  $input3['RECORD_STATUS']="R";

  $this->MYSQL = new MYSQL;
  $this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
  $this->MYSQL->tabel = "ICD_IP_ADDRESS";
  $this->MYSQL->record = $input3;
  $this->MYSQL->dimana = "where ICD_IP_ADDRESS_INDEX='".$input['ICD_IP_ADDRESS_INDEX']."'";

  if ($this->MYSQL->ubah() == true)
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
