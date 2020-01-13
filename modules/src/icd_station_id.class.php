<?php
/**
 * Cara melakukan bypass privileges modul gunakan kata 'open' pada case modul
 * Misal : open_data_443
 *
 *
 */

CLASS ICD_STATION_ID extends USER_PRIVILEGES{

	public function __construct(){
		$this->CONFIG=new CONFIG();
		$this->INVENTORY_CONFIG=new INVENTORY_CONFIG();
		$this->PAGING=new Paging();
		$this->MYSQL=new MYSQL();
		$this->SISTEM=new SISTEM();
	}


	#######################################################
	//Model penulisan  code develop versi  Oktober 2016

	private function control($params){

		$result=$this->user_login($params['data_http']);
		if(empty($result['USER_NAME']) and (!in_array('nonlogin',explode('_',$params['case'])))){
			$this->text_msg="Pengguna tidak dikenal";
			$this->pesan="gagal";
			return $this;
			exit();
		}//end

		//--PRIVILEGES CEK---//
		$user_privileges=$this->user_privileges($params['data_http'],strtolower(get_class($this)),$params['case']);
		if($user_privileges['pesan']=="gagal"){
			$this->text_msg=$user_privileges['text_msg'];
			$this->pesan=$user_privileges['pesan'];
			$this->queries=$user_privileges['queries'];
			$this->queries['modul']=$user_privileges['queries']['modul'];
		}else{
			$this->text_msg="OK";
			$this->pesan="sukses";
		}
		return $this;
		exit;
		//--END PRIVILEGES CEK---//
	}//end control


	private function pagging($params){
		//--PAGGING BOTTON-->
		if(empty($params['sql']))
		{
			$this->MYSQL=new MYSQL();
			$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->tabel=$params['tabel'];
			$this->MYSQL->kolom="count(RECORD_STATUS) as JUMLAH";
			$this->MYSQL->dimana=$params['dimana_default'];
			$result=$this->MYSQL->data()[0];
			$this->jmlhalaman = $this->PAGING->jumlahHalaman($result['JUMLAH'], $params['batas']);
		}else
		{
			$this->MYSQL=new MYSQL();
			$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->queri=$params['sql'];
			$result=$this->MYSQL->data();
			$this->jmlhalaman = $this->PAGING->jumlahHalaman(count($result), $params['batas']);
		}
		return $this;
	}//end pagging


	 private function auto_increatement_number($params){
	 	$n=new auto_nomor();
	 	$n->no_aktif=$params['aktif'];
	 	$n->panjang=3;
	 	$no=$n->nomor_urut();
	 	return $no;
	 }


	//FUNTION CREATE KODE INVENTORI
	private function inventori_kode_create($params){

		$jenis_barang=$params['ICD_BARANG_JENIS'];
		$tahunWo=Date('Y');
			$this->MYSQL=new MYSQL();
			$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->queri="select ICD_INVENTORI_KODE from ICD_TRANSAKSI_GUDANG where (ICD_INVENTORI_KODE like'%".$tahunWo."%' and ICD_INVENTORI_KODE like'%".$jenis_barang."%') and RECORD_STATUS='A' order by ICD_INVENTORI_KODE desc";
			$cek_nomor=$this->MYSQL->data();
			if(empty($cek_nomor))
			{
				$nomor=$jenis_barang.'/001/'.$tahunWo;
			}else
			{
				//CEK NOMOR TERAKHIR DI TAHUN YANG SAMA
				$this->MYSQL=new MYSQL();
				$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri="select ICD_INVENTORI_KODE from ICD_TRANSAKSI_GUDANG where (ICD_INVENTORI_KODE like'%".$tahunWo."%' and ICD_INVENTORI_KODE like'%".$jenis_barang."%') and RECORD_STATUS='A' order by ICD_INVENTORI_KODE desc LIMIT 1";
				$cek_nomor2=$this->MYSQL->data();
				$nomorBaru=explode("/",$cek_nomor2[0]['ICD_INVENTORI_KODE']);
				$nomorBaruNya=($nomorBaru[1])+1;
				$nomor=$jenis_barang.'/'.$this->auto_increatement_number(array('aktif'=>$nomorBaruNya)).'/'.$tahunWo;
			}
		/*
		}
		*/
		$this->callback['nomor']=$nomor;
		return $this;
	}//end presensi_proposal_nomor_create()
		//CONTOH PANGGIL DI MODUL
		 //$ICD_INVENTORI_KODE=$this->inventori_kode_create(array('ICD_BARANG_JENIS'=>$input['ICD_BARANG_JENIS']))->callback['nomor'];
		//

	//END

	private function module($params){

		//ambil informasi user login
		$user_login=$this->SISTEM->user(array('data_http'=>$params['data_http']))->login_info;
		$input=$params['input_option'];

		//perintah sql, logika program, dll
		switch(strtolower($params['case'])){
			case 'nonlogin_barang_add':
				require_once("barang/barang_add.php");
			break;

			case 'nonlogin_barang_hapus':
				require_once("barang/barang_hapus.php");
			break;
			case 'nonlogin_barang_list':
				require_once("barang/barang_list.php");
			break;
			case 'nonlogin_barang_kamus_index':
				require_once("barang/barang_kamus_index.php");
			break;
			case 'nonlogin_kode_inventori_it':
				require_once("barang/kode_inventori_it.php");
			break;
			case 'nonlogin_kode_inventori_lcs':
				require_once("barang/kode_inventori_lcs.php");
			break;
			case 'nonlogin_barang_add_lcs':
				require_once("barang/barang_add_lcs.php");
			break;
			case 'nonlogin_barang_kamus_add':
				require_once("barang/barang_kamus_add.php");
			break;
			case 'nonlogin_barang_lcs_list':
				require_once("barang/barang_lcs_list.php");
			break;
			case 'nonlogin_barang_kamus_list':
				require_once("barang/barang_kamus_list.php");
			break;
			case 'nonlogin_kartu_stok':
				require_once("barang/kartu_stok.php");
			break;
			case 'nonlogin_satuan':
				require_once("barang/satuan.php");
			break;



			case 'nonlogin_cek_station_id':
				require_once("katalog_komputer/cek_station_id.php");
			break;
			case 'nonlogin_station_id_add':
				require_once("katalog_komputer/station_id_add.php");
			break;
			case 'nonlogin_station_id_list':
				require_once("katalog_komputer/station_id_list.php");
			break;
			case 'nonlogin_data_443_detail' :
				require_once("katalog_komputer/station_id_detail.php");
			break;

			case 'nonlogin_penanggung_jawab':
				require_once("katalog_komputer/penanggung_jawab.php");
			break;
			case 'nonlogin_item_list':
				require_once("katalog_komputer/item_list.php");
			break;
			case 'nonlogin_ip_list':
				require_once("katalog_komputer/ip_list.php");
			break;
			case 'nonlogin_item_add':
				require_once("katalog_komputer/item_add.php");
			break;
			case 'nonlogin_station_id_info':
				require_once("katalog_komputer/station_id_info.php");
			break;
			case 'nonlogin_pindah_barang':
				require_once("katalog_komputer/pindah_barang.php");
			break;
			case 'nonlogin_station_aplikasi_add':
				require_once("katalog_komputer/station_aplikasi_add.php");
			break;
			case 'nonlogin_station_aplikasi_hapus':
				require_once("katalog_komputer/station_aplikasi_hapus.php");
			break;
			case 'nonlogin_station_aplikasi_list':
				require_once("katalog_komputer/station_aplikasi_list.php");
			break;
			case 'nonlogin_konfigurasi_add':
				require_once("katalog_komputer/konfigurasi_add.php");
			break;
			case 'nonlogin_konfigurasi_list':
				require_once("katalog_komputer/konfigurasi_list.php");
			break;
			case 'nonlogin_ip_add':
				require_once("katalog_komputer/ip_add.php");
			break;
			case 'nonlogin_ip_hapus':
				require_once("katalog_komputer/ip_hapus.php");
			break;
			case 'nonlogin_cek_barang_gudang':
				require_once("katalog_komputer/cek_barang_gudang.php");
			break;
			case 'nonlogin_get_staion_id_data':
				require_once("katalog_komputer/get_staion_id_data.php");
			break;
			case 'nonlogin_hapus_item':
				require_once("katalog_komputer/hapus_item.php");
			break;




			case 'nonlogin_inventori_list':
				require_once("inventori/inventori_list.php");
			break;
			case 'nonlogin_station_id':
				require_once("inventori/station_id.php");
			break;
			case 'nonlogin_kirim_stationid':
				require_once("inventori/kirim_stationid.php");
			break;
			case 'nonlogin_inventori_detail':
				require_once("inventori/inventori_detail.php");
			break;
			case 'nonlogin_riwayat_lokasi':
				require_once("inventori/riwayat_lokasi.php");
			break;
			case 'nonlogin_pindah_lokasi':
				require_once("inventori/pindah_lokasi.php");
			break;



			case 'nonlogin_gudang_list':
				require_once("gudang/gudang_list.php");
			break;
			case 'nonlogin_gudang_list_detail':
				require_once("gudang/gudang_list_detail.php");
			break;
			case 'nonlogin_cek_stok':
				require_once("gudang/cek_stok.php");
			break;
			case 'nonlogin_gudang_add':
				require_once("gudang/gudang_add.php");
			break;
			case 'nonlogin_barang_kamus_index_gudang':
				require_once("gudang/barang_kamus_index_gudang.php");
			break;
			case 'nonlogin_sel_no_inventori':
				require_once("gudang/sel_no_inventori.php");
			break;
			case 'nonlogin_keluar_barang':
				require_once("gudang/keluar_barang.php");
			break;
			case 'nonlogin_cek_no_inventori':
				require_once("gudang/cek_no_inventori.php");
			break;





			case 'nonlogin_aplikasi_list':
				require_once("aplikasi/aplikasi_list.php");
			break;
			case 'nonlogin_aplikasi_add':
				require_once("aplikasi/aplikasi_add.php");
			break;
			case 'nonlogin_pilih_aplikasi':
				require_once("aplikasi/pilih_aplikasi.php");
			break;
			case 'nonlogin_aplikasi_hapus':
				require_once("aplikasi/aplikasi_hapus.php");
			break;

			//---------------------end case-----------------------------//
			default:
				$this->callback['respon']['pesan']="gagal";
				$this->callback['respon']['text_msg']="Case tidak ditemukan ";
				$this->callback['respon']['help']="Sistem tidak menemukan case ".$params['case'];
			break;
		}//end switch case

		return $this;
	}//end modul

	public function load($params){
		if($this->control($params)->pesan=='sukses'){
			//ambil module
			$result=$this->module($params)->callback;
		}else{
			//hak akses tidak ada
			$result['respon']['pesan']=$this->control($params)->pesan;
			$result['respon']['text_msg']=$this->control($params)->text_msg;
		}
		return $result;
	}//end load


}//--END CLASS---//


?>
