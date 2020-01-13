<?php

if (empty($params['case']))
    {
    $result['respon']['pesan'] == "gagal";
    $result['respon']['pesan'] == "Module tidak dapat di muat";
    echo json_encode($result);
    exit();
    }

$halaman = $params['halaman'];
$batas = $params['batas'];
$posisi = $this->PAGING->cariPosisi($batas, $halaman);
$input = $params['input_option'];
$date = date("Y-m-d");

if (empty($input['keyword']) or $input['keyword'] == "")
    {
    $filter_a = "";
    }
  else
    {
    $filter_a = "AND (M.ICD_BARANG_NAMA like '%" . $input['keyword'] . "%' OR  C.ICD_BARANG_LCS_NAMA_BARANG like '%" . $input['keyword'] . "%')";
    }

$sql = "SELECT   *, SUM(T.ICD_TRANSAKSI_INVENTORI_STOK_SISA) AS TOTAL
                FROM     ICD_TRANSAKSI_GUDANG   AS G,
                         ICD_TRANSAKSI_INVENTORI AS T,
                         WO_UNIT                AS W,
                         ICD_BARANG_MASTER      AS M
                WHERE    M.WO_UNIT_ID=W.WO_UNIT_ID
                AND      M.ICD_BARANG_KODE=G.ICD_BARANG_KODE
                AND      G.ICD_NO_INVENTORI=T.ICD_NO_INVENTORI
                AND      T.ICD_TRANSAKSI_INVENTORI_STATUS='A'
                AND      T.ICD_TRANSAKSI_INVENTORI_STOK_SISA > 0 " . $filter_a . "
                GROUP BY G.ICD_BARANG_KODE
                ORDER BY G.ICD_NO_INVENTORI DESC
                ";
$this->MYSQL = new MYSQL();
$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri = $sql . " limit " . $posisi . "," . $batas;
$result_a = $this->MYSQL->data();

// -- >>

$no = $posisi + 1;

foreach($result_a as $r)
    {
    $r['NO'] = $no;
    $result[] = $r;
    $no++;
    }

if (empty($result_a))
    {
    $this->callback['respon']['pesan'] = "gagal";
    $this->callback['respon']['text_msg'] = "Data item tidak ada.";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result;
    }
  else
    {
    $this->callback['respon']['pesan'] = "sukses";
    $this->callback['respon']['text_msg'] = "OK..";
    $this->callback['filter'] = $params;
    $this->callback['result'] = $result;
    $this->callback['result_option']['jml_halaman'] = $this->pagging(array(
        'sql' => $sql,
        'batas' => $batas
    ))->jmlhalaman;
    }

?>
