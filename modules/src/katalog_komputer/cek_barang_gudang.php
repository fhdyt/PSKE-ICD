<?php

//crontrol
if(empty($params['case'])){
	$result['respon']['pesan']=="gagal";
	$result['respon']['pesan']=="Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}

$input=$params['input_option'];

$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="SELECT * FROM ICD_BARANG_KAMUS AS K,
													ICD_BARANG_MASTER AS M,
													ICD_TRANSAKSI_GUDANG AS G,
													ICD_TRANSAKSI_INVENTORI AS I
										WHERE
													I.ICD_NO_INVENTORI=G.ICD_NO_INVENTORI
													AND G.ICD_BARANG_KAMUS_ID=K.ICD_BARANG_KAMUS_ID
													AND K.ICD_BARANG_KODE=M.ICD_BARANG_KODE
													AND (I.ICD_NO_INVENTORI LIKE '%".$input['q']."%'
																	OR M.ICD_BARANG_NAMA LIKE '%".$input['q']."%')
													AND M.RECORD_STATUS='A'
													AND I.ICD_TRANSAKSI_INVENTORI_STOK_SISA > 0
													AND I.ICD_TRANSAKSI_INVENTORI_STATUS ='A'
									";


$result_a=$this->MYSQL->data();
$no=1;
foreach($result_a as $r){

	$result[]=$r;

$no++;
}
if(empty($result)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Data kosong _".$input['q'];
	$this->callback['result']=$result;
}else{
	$this->callback['respon']['pesan']="sukses";
	$this->callback['respon']['text_msg']="OK".print_r($result,true);
	$this->callback['result']=$result;
}

return;
?>
