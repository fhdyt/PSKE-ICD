<?php
//---AJAX ---//
$ref = anti_injection($_POST['ref']);
switch ($ref) {
    case 'barang_add':
        require_once("ajax/requester/barang_add.php");
        break;
    case 'barang_hapus':
        require_once("ajax/requester/barang_hapus.php");
        break;
    case 'barang_list':
        require_once("ajax/requester/barang_list.php");
        break;
    case 'kode_inventori_it':
        require_once("ajax/requester/kode_inventori_it.php");
        break;
    case 'kode_inventori_lcs':
        require_once("ajax/requester/kode_inventori_lcs.php");
        break;
    case 'barang_add_lcs':
        require_once("ajax/requester/barang_add_lcs.php");
        break;
     case 'barang_kamus_list':
        require_once("ajax/requester/barang_kamus_list.php");
        break;
    case 'barang_kamus_add':
        require_once("ajax/requester/barang_kamus_add.php");
        break;
    case 'barang_lcs_list':
        require_once("ajax/requester/barang_lcs_list.php");
        break;
     case 'kartu_stok':
        require_once("ajax/requester/kartu_stok.php");
        break;
    case 'satuan':
        require_once("ajax/requester/satuan.php");
        break;



    case 'station_id_add':
        require_once("ajax/requester/katalog_komputer/station_id_add.php");
        break;
    case 'station_id_list':
        require_once("ajax/requester/katalog_komputer/station_id_list.php");
        break;
    case 'penanggung_jawab':
        require_once("ajax/requester/katalog_komputer/penanggung_jawab.php");
        break;
    case 'item_list':
        require_once("ajax/requester/katalog_komputer/item_list.php");
        break;
    case 'item_add':
        require_once("ajax/requester/katalog_komputer/item_add.php");
        break;
    case 'barang_kamus_index':
        require_once("ajax/requester/barang_kamus_index.php");
        break;
    case 'station_id_info':
        require_once("ajax/requester/katalog_komputer/station_id_info.php");
        break;
    case 'pindah_barang':
        require_once("ajax/requester/katalog_komputer/pindah_barang.php");
        break;
    case 'ip_list':
        require_once("ajax/requester/katalog_komputer/ip_list.php");
        break;
    case 'station_aplikasi_add':
        require_once("ajax/requester/katalog_komputer/station_aplikasi_add.php");
        break;
    case 'station_aplikasi_hapus':
        require_once("ajax/requester/katalog_komputer/station_aplikasi_hapus.php");
        break;
    case 'station_aplikasi_list':
        require_once("ajax/requester/katalog_komputer/station_aplikasi_list.php");
        break;
    case 'konfigurasi_add':
        require_once("ajax/requester/katalog_komputer/konfigurasi_add.php");
        break;
    case 'konfigurasi_list':
        require_once("ajax/requester/katalog_komputer/konfigurasi_list.php");
        break;
    case 'ip_add':
        require_once("ajax/requester/katalog_komputer/ip_add.php");
        break;
    case 'ip_hapus':
        require_once("ajax/requester/katalog_komputer/ip_hapus.php");
        break;
    case 'cek_barang_gudang':
        require_once("ajax/requester/katalog_komputer/cek_barang_gudang.php");
        break;
    case 'cek_station_id':
        require_once("ajax/requester/katalog_komputer/cek_station_id.php");
        break;
    case 'get_staion_id_data':
        require_once("ajax/requester/katalog_komputer/get_staion_id_data.php");
        break;
    case 'hapus_item':
        require_once("ajax/requester/katalog_komputer/hapus_item.php");
        break;



    case 'inventori_list':
        require_once("ajax/requester/inventori/inventori_list.php");
        break;
    case 'station_id':
        require_once("ajax/requester/inventori/station_id.php");
        break;
    case 'kirim_stationid':
        require_once("ajax/requester/inventori/kirim_stationid.php");
        break;
    case 'inventori_detail':
        require_once("ajax/requester/inventori/inventori_detail.php");
        break;
    case 'riwayat_lokasi':
        require_once("ajax/requester/inventori/riwayat_lokasi.php");
        break;
    case 'pindah_lokasi':
        require_once("ajax/requester/inventori/pindah_lokasi.php");
        break;






    case 'gudang_list':
        require_once("ajax/requester/gudang/gudang_list.php");
        break;
    case 'gudang_list_detail':
        require_once("ajax/requester/gudang/gudang_list_detail.php");
        break;
    case 'cek_stok':
        require_once("ajax/requester/gudang/cek_stok.php");
        break;
    case 'gudang_add':
        require_once("ajax/requester/gudang/gudang_add.php");
        break;
    case 'barang_kamus_index_gudang':
        require_once("ajax/requester/gudang/barang_kamus_index_gudang.php");
        break;
    case 'sel_no_inventori':
        require_once("ajax/requester/gudang/sel_no_inventori.php");
        break;
     case 'keluar_barang':
        require_once("ajax/requester/gudang/keluar_barang.php");
        break;
     case 'cek_no_inventori':
        require_once("ajax/requester/gudang/cek_no_inventori.php");
        break;





    case 'aplikasi_list':
        require_once("ajax/requester/aplikasi/aplikasi_list.php");
        break;
    case 'aplikasi_add':
        require_once("ajax/requester/aplikasi/aplikasi_add.php");
        break;
    case 'pilih_aplikasi':
        require_once("ajax/requester/aplikasi/pilih_aplikasi.php");
        break;
    case 'aplikasi_hapus':
        require_once("ajax/requester/aplikasi/aplikasi_hapus.php");
        break;

    //--------------Handle Error Page-----------------------------------
    default:
        $callback['pesan']    = "gagal";
        $callback['text_msg'] = "Case ajax not found {$ref}";
        echo json_encode($callback);
        exit;
        break;
} //---end switch
?>
