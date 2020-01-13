<?php
//config.local adalah configurasi yang digunakan oleh suatu aplikasi
//namun tidak digunakan oleh aplikasi lain.
//hal ini untuk mempermudah dalam memenejemen variabel dan data configurasi.
CLASS INVENTORY_CONFIG extends CONFIG{

	public function __construct(){
		$this->CONFIG=new CONFIG();
		//$this->INVENTORY_CONFIG=new INVENTORY_CONFIG();
		$this->PAGING=new Paging();
		$this->MYSQL=new MYSQL();
		$this->SISTEM=new SISTEM();
	}

	public function inventory(){
		$this->jenis_aplikasi=array(
			'Freeware'=>"Freeware",
			'Licensi'=>"Licensi",
		);
		return $this;
	}//end tools





	//link

	public function no_inventori($kolom="ICD_NO_INVENTORI",$panjang=8)
		{
		$cf=$GLOBALS['cf'];
		$db=new db();
		$db->database=$cf['db_nama'];
		$db->kolom="LPAD((RIGHT(MAX(".$kolom."),".$panjang.")+1),".$panjang.",'0') as last_id";
		$db->tabel="ICD_TRANSAKSI_GUDANG";

		$refs=$db->data();
		$last_idX=$refs[0]['last_id'];
		if(empty($refs[0]['last_id'])){
			 $last_id=str_pad(1, $panjang, '0', STR_PAD_LEFT);
		}else{
			$last_id=$last_idX;
		}
		return $last_id;
		}

		public function barang_id($kolom="ICD_BARANG_KODE",$panjang=8){
		$cf=$GLOBALS['cf'];
		$db=new db();
		$db->database=$cf['db_nama'];
		$db->kolom="LPAD((RIGHT(MAX(".$kolom."),".$panjang.")+1),".$panjang.",'0') as last_id";
		$db->tabel="ICD_BARANG_MASTER";

		$refs=$db->data();
		$last_idX=$refs[0]['last_id'];
		if(empty($refs[0]['last_id'])){
			 $last_id=str_pad(1, $panjang, '0', STR_PAD_LEFT);
		}else{
			$last_id=$last_idX;
		}
		return $last_id;
	}

	private function barang_lcs_id($kolom="ICD_BARANG_LCS_KODE",$panjang=8){
	$cf=$GLOBALS['cf'];
	$db=new db();
	$db->database=$cf['db_nama'];
	$db->kolom="LPAD((RIGHT(MAX(".$kolom."),".$panjang.")+1),".$panjang.",'0') as last_id";
	$db->tabel="ICD_BARANG_LCS";

	$refs=$db->data();
	$last_idX=$refs[0]['last_id'];
	if(empty($refs[0]['last_id'])){
		 $last_id=str_pad(1, $panjang, '0', STR_PAD_LEFT);
	}else{
		$last_id=$last_idX;
	}
	return $last_id;
}

	private function station_id($kolom="ICD_STATION_ID",$panjang=8){
	$cf=$GLOBALS['cf'];
	$db=new db();
	$db->database=$cf['db_nama'];
	$db->kolom="LPAD((RIGHT(MAX(".$kolom."),".$panjang.")+1),".$panjang.",'0') as last_id";
	$db->tabel="ICD_STATION_ID";

	$refs=$db->data();
	$last_idX=$refs[0]['last_id'];
	if(empty($refs[0]['last_id'])){
		 $last_id=str_pad(1, $panjang, '0', STR_PAD_LEFT);
	}else{
		$last_id=$last_idX;
	}
	return $last_id;
}

	public function departemen(){
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="select * from COMPANY_UNIT WHERE RECORD_STATUS='A'";
		$hasil=$this->MYSQL->data();
		foreach($hasil as $r){

		}
		$callback['rasult']=array(
			$hasil,

		);
	return $callback;


	}

	public function aplikasi(){
		$this->MYSQL=new MYSQL();
		$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri="select * from ICD_APLIKASI_MASTER WHERE RECORD_STATUS='A'";
		$hasil=$this->MYSQL->data();
		foreach($hasil as $r){

		}
		$callback['rasult']=array(
			$hasil,

		);
	return $callback;


	}

}
?>
