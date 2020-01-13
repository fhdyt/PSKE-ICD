<?php $INVENTORY_CONFIG=new INVENTORY_CONFIG();

$input_option=array(
  'ICD_STATION_ID'=>$d3,
  );
foreach($_POST as $key=>$val){
	if($key=="ref"){ }else{
		$input_option["$key"]=str_replace("'","`",$val);
	}
}
$params=array(
	'case'=>"nonlogin_data_443_detail",
	'batas'=>$_POST['batas'],
	'halaman'=>$_POST['halaman'],
	'data_http'=>$_COOKIE['data_http'],
	'token_http'=>$_COOKIE['token_http'],
	'input_option'=>$input_option,
);
$respon=$INVENTORY->inventory_requester($params)->load->module;
#echo "<pre>".print_r($respon,true)."</pre>";

foreach($respon['result'] as $r){
  $station_id[]=$r;
}

?>
<style>
table {
font-size: 12px;
}

.loader {
  border: 5px solid #f3f3f3;
  border-radius: 50%;
  border-top: 5px solid #3498db;
  width: 40px;
  height: 40px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<script src="aplikasi/<?php echo $_SESSION['aplikasi']; ?>/asset/js/jquery.mask.min.js" type="text/javascript"></script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="list-group">
			<div class="list-group-item">
				<div class="row">
					<div class="col-md-8">
						<h3><i class="fa fa-id-card-o"></i> Station ID : <b><?php echo $station_id[0]['ICD_STATION_ID'] ?></b></h3>
						<hr>
					</div>
					<div class="col-md-4 text-right"></div>
				</div><!--/.row-->
				<div class="row">
					<div class="col-md-5 text-left">
            <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-institution"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Lokasi / Departemen</span>
            <span class="info-box-number"><?php echo $station_id[0]['ICD_STATION_ID_LOKASI'] ?></span>
            <span class="info-box-number"><?php echo $station_id[0]['DEPT'] ?></span>
            </div>
            </div>
					</div>
					<div class="col-md-5 text-left">
            <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Penanggung Jawab</span>
            <span class="info-box-number"><?php echo $station_id[0]['PERSONAL_NAME'] ?></span>
            <span class="info-box-number"><?php echo $station_id[0]['PERSONAL_NIK'] ?></span>
            </div>
            </div>
					</div>
					<div class="col-md-2 text-left">
						<a class="btn btn-primary edit_station_id btn-sm">Edit Station ID</a>
					</div>

				</div><br>
				<!-- <button class="btn btn-primary btn-sm tambah" type="button"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Inventori</button> -->


				<div class="row">
		<div class="col-md-12">
			<!-- Custom Tabs -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#hardware" data-toggle="tab">Hardware</a></li>
					<li><a href="#aplikasi" data-toggle="tab">Aplikasi</a></li>
					<li><a href="#konfigurasi" data-toggle="tab">Konfigurasi</a></li>
          <li><a href="#ip_address" data-toggle="tab">IP Address</a></li>

				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="hardware">
            <!-- <button class="btn btn-primary btn-sm tambah_barang" type="button"><i aria-hidden="true" class="fa fa-plus-square"></i> Tambah Barang</button><br> -->
						<table class="table table-bordered table-hover">
    							<thead>
    								<tr>
    					<th>No.</th>
    					<th>No Inventori</th>
    					<th>Kode Inventori</th>
    					<th>Nama Barang</th>
    					<th>Kode Barang</th>
    					<th>WO / PCRN Permintaan</th>
    					<th>Tanggal</th>
    					<th>Spesifikasi</th>
    					<th>Aksi</th>
    								</tr>
    							</thead>
    							<tbody id="zone_data">
    				<tr>
    					<td colspan="9">
    						<center>
    							<div class="loader"></div>
    						</center>
    					</td>
    				</tr>
    			</tbody>
    						</table>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="aplikasi">
            <button class="btn btn-primary btn-sm tambah_aplikasi" type="button"><i aria-hidden="true" class="fa fa-plus-square"></i> Tambah Aplikasi</button><br>
            <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
              <th>No.</th>
              <th>Nama Aplikasi</th>
              <th>Versi Aplikasi</th>
              <th>Lisensi Aplikasi</th>
              <th>Keterangan</th>
              <th><center>Aksi</center></th>
                    </tr>
                  </thead>
                  <tbody id="zone_aplikasi">
            <tr>
              <td colspan="9">
                <center>
                  <div class="loader"></div>
                </center>
              </td>
            </tr>
          </tbody>
                </table>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="konfigurasi">
            <button class="btn btn-primary btn-sm tambah_konfigurasi" type="button"><i aria-hidden="true" class="fa fa-plus-square"></i> Tambah Konfigurasi</button><br>
            <table class="table table-bordered table-hover">
									<thead>
										<tr>
							<th>No.</th>
							<th>Konfigurasi</th>
							<th>Nilai</th>
										</tr>
									</thead>
									<tbody id="zone_config">
						<tr>
							<td colspan="9">
								<center>
									<div class="loader"></div>
								</center>
							</td>
						</tr>
					</tbody>
								</table>
					</div>
					<!-- /.tab-pane -->
          <div class="tab-pane" id="ip_address">
            <button class="btn btn-primary btn-sm tambah_ip_address" type="button"><i aria-hidden="true" class="fa fa-plus-square"></i> Tambah IP Address</button><br>
            <table class="table table-bordered table-hover">
									<thead>
										<tr>
							<th>No.</th>
							<th>IP Address</th>
							<th>MAC Address</th>
							<th><center>Aksi</center></th>
										</tr>
									</thead>
									<tbody id="zone_ip">
						<tr>
							<td colspan="9">
								<center>
									<div class="loader"></div>
								</center>
							</td>
						</tr>
					</tbody>
								</table>
          </div>
          <!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- nav-tabs-custom -->
		</div>
		<!-- /.col -->


			</div>
		</div>
	</div>
</div>
<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalkeluarbarang" role="dialog" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Keluar Barang Departemen</h4>
			</div>
			<div class="modal-body">
				<form action="javascript:download();" class="fDataKeluarBarang form-group-sm" id="fDataKeluarBarang" name="fDataKeluarBarang">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input autocomplete="off" class="form-control LOKASI_STOK" id="LOKASI_STOK" name="LOKASI_STOK" placeholder="LOKASI_STOK" type="hidden" value="<?php echo $d3; ?>">
                <label for="NO_INVENTORI">No. Inventori</label> <select class="NO_INVENTORI selectpicker_no_inventori with-ajax-personal form-control" data-live-search="true" id="NO_INVENTORI" name="NO_INVENTORI">
    						</select> <small class="help-block">Pelaksana Penanganan</small>
    					</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="NAMA_BARANG">Nama Barang</label><input autocomplete="off" class="form-control NAMA_BARANG" id="NAMA_BARANG" name="NAMA_BARANG" placeholder="NAMA_BARANG" readonly type="text"> <small class="help-block">Nama Barang Departemen</small>
    					</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
    						<label for="TANGGAL">Tanggal</label> <input autocomplete="off" class="form-control TANGGAL datepicker" id="TANGGAL" name="TANGGAL" placeholder="TANGGAL" value="<?php echo date("Y/m/d"); ?>" type="text"> <small class="help-block">Tanggal Keluar Gudang</small>
    					</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="BARANG_JENIS">Pelaksana</label> <select class="PENANGGUNG_JAWAB selectpicker_nik with-ajax-personal form-control" data-live-search="true" id="PENANGGUNG_JAWAB" name="PENANGGUNG_JAWAB">
    						</select> <small class="help-block">Pelaksana Penanganan</small>
    					</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
    						<label for="BARANG_JENIS">WO / Purchase Reference Number</label> <input autocomplete="off" class="form-control WO" id="WO" name="WO" placeholder="WO" type="text"> <small class="help-block">Nomor WO / PCRN Permintaan</small>
    					</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="BPB">BPB</label> <input autocomplete="off" class="form-control BPB" id="BPB" name="BPB" placeholder="BPB" type="text"> <small class="help-block">Bukti Pindah Barang</small>
    					</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
    						<label for="JUMLAH_KELUAR">Jumlah</label> <input autocomplete="off" class="form-control JUMLAH_KELUAR" id="JUMLAH_KELUAR" name="JUMLAH_KELUAR" placeholder="JUMLAH_KELUAR" type="number" value=""> <small class="help-block"><span class="ck-stok_jumlah">Jumlah Inventori Keluar</span></small>
    					</div>
            </div>

            <div class="col-md-8">
              <div class="form-group">
    						<label for="KETERANGAN_KELUAR">Keterangan</label>
    						<textarea class="form-control KETERANGAN_KELUAR" id="KETERANGAN_KELUAR" name="KETERANGAN_KELUAR"></textarea> <small class="help-block">Isi jika diperlukan</small>
    					</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
    						<button class="btn btn-success btn-sm FormKirimInventori">Simpan</button>
    					</div>
            </div>
          </div>
				</form>
			</div>
		</div>
	</div>
</div>


<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalAplikasi" role="dialog" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Aplikasi</h4>
      </div>
      <div class="modal-body">
        <form action="javascript:download();" class="fData" id="fDataAplikasi" name="fDataAplikasi">
          <div class="form-group">
            <label for="ICD_STATION_ID_APLIKASI_NAMA">Nama Aplikasi</label>
            <input autocomplete="off" class="form-control ICD_STATION_ID_APLIKASI_ID" id="ICD_STATION_ID_APLIKASI_ID" name="ICD_STATION_ID_APLIKASI_ID" placeholder="ICD_STATION_ID_APLIKASI_ID" type="hidden">
            <!-- <input autocomplete="off" class="form-control ICD_APLIKASI_MASTER_NAMA" id="ICD_APLIKASI_MASTER_NAMA" name="ICD_APLIKASI_MASTER_NAMA" placeholder="ICD_APLIKASI_MASTER_NAMA" type="hidden">
            <input autocomplete="off" class="form-control ICD_APLIKASI_MASTER_VERSI" id="ICD_APLIKASI_MASTER_VERSI" name="ICD_APLIKASI_MASTER_VERSI" placeholder="ICD_APLIKASI_MASTER_VERSI" type="hidden"> -->
            <select class="ICD_APLIKASI_MASTER_ID selectpicker_aplikasi with-ajax-personal form-control" data-live-search="true" id="ICD_APLIKASI_MASTER_ID" name="ICD_APLIKASI_MASTER_ID">
              <option value="">
								--Pilih--
							</option>
									<?php
									$data = $INVENTORY_CONFIG->aplikasi();

									foreach ($data['rasult'] as $key => $value) {
									    foreach ($value as $data => $isi) {
									        ?>
							<option value="<?php echo $isi['ICD_APLIKASI_MASTER_ID']; ?>" ICD_APLIKASI_MASTER_JENIS="<?php echo $isi['ICD_APLIKASI_MASTER_JENIS']; ?>">
								<?php  echo $isi['ICD_APLIKASI_MASTER_NAMA'];?> (<?php  echo $isi['ICD_APLIKASI_MASTER_VERSI'];?>)
							</option>
									<?php
									    }

									}
									?>
            </select>
            <small class="help-block">Pilih Aplikasi.</small>
          </div>
          <div class="form-group licensi_aplikasi">
            <label for="ICD_STATION_ID_APLIKASI_LISENSI">Lisensi Aplikasi</label>
            <input autocomplete="off" class="form-control ICD_STATION_ID_APLIKASI_LISENSI" id="ICD_STATION_ID_APLIKASI_LISENSI" name="ICD_STATION_ID_APLIKASI_LISENSI" placeholder="ICD_STATION_ID_APLIKASI_LISENSI" type="text">
            <small class="help-block">Nama Barang IT</small>
          </div>
          <div class="form-group">
            <label for="ICD_STATION_ID_APLIKASI_KETERANGAN">Keterangan</label>
            <textarea class="form-control ICD_STATION_ID_APLIKASI_KETERANGAN" id="ICD_STATION_ID_APLIKASI_KETERANGAN" name="ICD_STATION_ID_APLIKASI_KETERANGAN" placeholder="ICD_STATION_ID_APLIKASI_KETERANGAN"></textarea>
            <small class="help-block">Isi jika diperlukan.</small>
          </div>
          <div class="form-group">
            <button class="btn btn-success btn-sm KirimAplikasi">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalKonfigurasi" role="dialog" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Konfigurasi</h4>
      </div>
      <div class="modal-body">
        <form action="javascript:download();" class="fData form-group-sm" id="fDataKonfigurasi" name="fDataKonfigurasi">
          <div class="form-group">
            <label for="ICD_STATION_ID_KONFIGURASI_KONFIGURASI">Konfigurasi</label>
            <input autocomplete="off" class="form-control ICD_STATION_ID_KONFIGURASI_ID" id="ICD_STATION_ID_KONFIGURASI_ID" name="ICD_STATION_ID_KONFIGURASI_ID" placeholder="ICD_STATION_ID_KONFIGURASI_ID" type="hidden">
            <input autocomplete="off" class="form-control ICD_STATION_ID_KONFIGURASI_KONFIGURASI" id="ICD_STATION_ID_KONFIGURASI_KONFIGURASI" name="ICD_STATION_ID_KONFIGURASI_KONFIGURASI" placeholder="ICD_STATION_ID_KONFIGURASI_KONFIGURASI" type="text">
            <small class="help-block">Konfigurasi Station ID</small>
          </div>
          <div class="form-group ">
            <label for="ICD_STATION_ID_KONFIGURASI_NILAI">Nilai</label>
            <input autocomplete="off" class="form-control ICD_STATION_ID_KONFIGURASI_NILAI" id="ICD_STATION_ID_KONFIGURASI_NILAI" name="ICD_STATION_ID_KONFIGURASI_NILAI" placeholder="ICD_STATION_ID_KONFIGURASI_NILAI" type="text">
            <small class="help-block">Nilai dari Konfigurasi</small>
          </div>
          <div class="form-group">
            <label for="ICD_STATION_ID_KONFIGURASI_KETERANGAN">Keterangan</label>
            <textarea class="form-control ICD_STATION_ID_KONFIGURASI_KETERANGAN" id="ICD_STATION_ID_KONFIGURASI_KETERANGAN" name="ICD_STATION_ID_KONFIGURASI_KETERANGAN" placeholder="ICD_STATION_ID_KONFIGURASI_KETERANGAN"></textarea>
            <small class="help-block">Isi jika diperlukan.</small>
          </div>
          <div class="form-group">
            <button class="btn btn-success btn-sm KirimKonfigurasi">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalIPAddress" role="dialog" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah IP Address</h4>
      </div>
      <div class="modal-body">
        <form action="javascript:download();" class="fData" id="fDataIPAddress" name="fDataIPAddress">
          <div class="form-group">
            <label for="ICD_IP_ADDRESS">IP Address</label>
            <input autocomplete="off" class="form-control ICD_IP_ADDRESS_INDEX" id="ICD_IP_ADDRESS_INDEX" name="ICD_IP_ADDRESS_INDEX" placeholder="ICD_IP_ADDRESS_INDEX" type="hidden">
            <input autocomplete="off" class="form-control ICD_IP_ADDRESS" id="ICD_IP_ADDRESS" name="ICD_IP_ADDRESS" placeholder="ICD_IP_ADDRESS" type="text">
            <small class="help-block">IP Address Station ID.</small>
          </div>
          <div class="form-group ">
            <label for="ICD_MAC_ADDRESS">MAC Address</label> <input autocomplete="off" class="form-control ICD_MAC_ADDRESS" id="ICD_MAC_ADDRESS" name="ICD_MAC_ADDRESS" placeholder="ICD_MAC_ADDRESS" type="text">
            <small class="help-block">MAC Address Station ID.</small>
          </div>
          <div class="form-group">
            <button class="btn btn-success btn-sm KirimIPAddress">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalLokasi" role="dialog" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Pindah Lokasi</h4>
			</div>
			<div class="modal-body">
        <p id="no_inventori"></p>
        <p id="nama_barang"></p>
        <form action="javascript:download();" class="fDataPindahLokasi" id="fDataPindahLokasi" name="fDataPindahLokasi">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="ICD_TRANSAKSI_INVENTORI_LOKASI">Lokasi Baru</label>
              <input autocomplete="off" class="form-control ICD_NO_INVENTORI" id="ICD_NO_INVENTORI" name="ICD_NO_INVENTORI" placeholder="ICD_NO_INVENTORI" type="hidden">
              <input autocomplete="off" class="form-control ICD_TRANSAKSI_INVENTORI_LOKASI" id="ICD_TRANSAKSI_INVENTORI_LOKASI" name="ICD_TRANSAKSI_INVENTORI_LOKASI" placeholder="ICD_TRANSAKSI_INVENTORI_LOKASI" type="text"> <small class="help-block">Bukti Pindah Gudang</small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="ICD_TRANSAKSI_INVENTORI_TANGGAL">Tanggal</label> <input autocomplete="off" class="form-control ICD_TRANSAKSI_INVENTORI_TANGGAL datepicker" id="ICD_TRANSAKSI_INVENTORI_TANGGAL" name="ICD_TRANSAKSI_INVENTORI_TANGGAL" placeholder="ICD_TRANSAKSI_INVENTORI_TANGGAL" value="<?php echo date("Y/m/d"); ?>" type="text"> <small class="help-block">Tanggal Masuk Gudang</small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="PERSONAL_NIK">Pelaksana</label><select class="PERSONAL_NIK selectpicker_nik with-ajax-personal form-control" data-live-search="true" id="PERSONAL_NIK" name="PERSONAL_NIK">
              </select><small class="help-block">Tanggal Masuk Gudang</small>
          </div>
        </div>
        <div class="col-md-6">
         <div class="form-group">
           <label for="ICD_TRANSAKSI_INVENTORI_WO">WO</label><input autocomplete="off" class="form-control ICD_TRANSAKSI_INVENTORI_WO" id="ICD_TRANSAKSI_INVENTORI_WO" name="ICD_TRANSAKSI_INVENTORI_WO" placeholder="ICD_TRANSAKSI_INVENTORI_WO" type="text"><small class="help-block">Tanggal Masuk Gudang</small>
         </div>
       </div>
       <div class="col-md-6">
          <div class="form-group">
            <label for="ICD_TRANSAKSI_INVENTORI_BPB">BPB</label><input autocomplete="off" class="form-control ICD_TRANSAKSI_INVENTORI_BPB" id="ICD_TRANSAKSI_INVENTORI_BPB" name="ICD_TRANSAKSI_INVENTORI_BPB" placeholder="ICD_TRANSAKSI_INVENTORI_BPB" type="text"><small class="help-block">Tanggal Masuk Gudang</small>
          </div>
        </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <button class="btn btn-success btn-sm FormKirim">Simpan</button>
            </div>
          </div>

        </div>
      </form>
			</div>
		</div>
	</div>
</div>

<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalForm" role="dialog" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Tambah Station ID</h4>
			</div>
			<div class="modal-body">
				<form action="javascript:download();" class="fDataStationID" id="fDataStationID" name="fDataStationID">
					<div class="form-group">
						<label for="LOKASI">Station ID</label>
            <input autocomplete="off" class="form-control STATION_ID_ID" id="STATION_ID_ID" name="STATION_ID_ID" placeholder="STATION_ID_ID" type="text" readonly>
						<small class="help-block"><span class="ck_station_id">Station ID</span></small>
					</div>
					<div class="form-group">
						<label for="LOKASI">Lokasi</label>
            <input autocomplete="off" class="form-control LOKASI" id="LOKASI" name="LOKASI" placeholder="LOKASI" type="text">
						<small class="help-block">Lokasi Station ID di Departemen</small>
					</div>
					<div class="form-group">
						<label for="DEPARTEMEN">Departemen</label>
            <select class="col-sm-2 form-control DEPARTEMEN" id="DEPARTEMEN" name="DEPARTEMEN" onchange="onchange_bh_company_unit()" required="">
							<option value="">
								--Pilih--
							</option>
									<?php
									$data = $INVENTORY_CONFIG->departemen();

									foreach ($data['rasult'] as $key => $value) {
									    foreach ($value as $data => $isi) {
									        ?>
							<option value="<?php echo $isi['COMPANY_UNIT_ID']; ?>">
								<?php  echo $isi['COMPANY_UNIT_NAME'];?>
							</option>
									<?php
									    }

									}
									?>
						</select>
						<small class="help-block">Departemen Station ID</small>
					</div>
					<div class="form-group">
						<label for="PENANGGUNG_JAWAB">Penanggung Jawab</label>
						<select name="PENANGGUNG_JAWAB" id="PENANGGUNG_JAWAB" class="PENANGGUNG_JAWAB selectpicker with-ajax-personal form-control"  data-live-search="true">
						</select>
						<small class="help-block">Penanggung Jawab Station ID</small>
					</div>
					<div class="form-group">
						<label for="KONDISI">Kondisi</label>
            <input autocomplete="off" class="form-control KONDISI" id="KONDISI" name="KONDISI" placeholder="KONDISI" stype="text">
						<small class="help-block">Kondisi</small>
					</div>
					<div class="form-group">
						<label for="KETERANGAN">Keterangan</label>
						<textarea class="form-control KETERANGAN" id="KETERANGAN" name="KETERANGAN" placeholder="KETERANGAN"></textarea>
						<small class="help-block">Isi Jika Diperlukan</small>
					</div>
					<div class="form-group">
						<button class="btn btn-success btn-sm FormKirim_Station_ID">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
$('.tambah_aplikasi').on('click', function()
{
  $("#fDataAplikasi")[0].reset();
	$(".modalAplikasi").modal('show');
});
$('.tambah_konfigurasi').on('click', function()
{
  $("#fDataKonfigurasi")[0].reset();
	$(".modalKonfigurasi").modal('show');
});
$('.tambah_ip_address').on('click', function()
{
  $("#fDataIPAddress")[0].reset();
	$(".modalIPAddress").modal('show');
});

$('.tambah_barang').on('click', function()
{
	$(".modalkeluarbarang").modal('show');
});

$(document).ready(function(){
   $('.ICD_IP_ADDRESS').mask('0ZZ.0ZZ.0ZZ.0ZZ', {translation: {'Z': {pattern: /[0-9]/, optional: true}}});
  $('.ICD_MAC_ADDRESS').mask('ZZ:ZZ:ZZ:ZZ:ZZ:ZZ', {translation: {'Z': {pattern: /[A-Za-z0-9]/, optional: true}}});
});
	$(function() {
		$(".datepicker").datepicker().on('changeDate', function(ev) {
			$('.datepicker').datepicker('hide');
		});
	});

  var options =
  {
  	ajax:
  	{
  		url: refseeAPI,
  		type: 'POST',
  		dataType: 'json',
  		data:
  		{
  			q: '{{{q}}}',
  			ref: 'cek_barang_gudang',
  		}
  	},
  	locale:
  	{
  		emptyTitle: 'Kode Barang Departemen'
  	},
  	log: 3,
  	preprocessData: function(data)
  	{
  		var i, l = data.result.length,
  			array = [];
  		if (l)
  		{
        for (i = 0; i < l; i++)
        {
          array.push($.extend(true, data.result[i],
            {
              text: data.result[i].ICD_NO_INVENTORI,
              value: data.result[i].ICD_NO_INVENTORI,
              data: {
                subtext: data.result[i].ICD_BARANG_NAMA,
                // nama_barang_it: data.result[i].ICD_BARANG_NAMA,
                // kode_barang_lcs: data.result[i].ICD_BARANG_LCS_KODE,
                // nama_barang_lcs: data.result[i].ICD_BARANG_LCS_NAMA_BARANG,
              }
            }));
          }
  		}
  		else
  		{
  		}
  		return array;
  	}
  };

  $('.selectpicker_no_inventori').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);
  $('select.selectpicker_no_inventori').on('change', function()
  {
  	var value = $('.selectpicker_no_inventori').val();
    console.log(value);

  });
	// $('.tambah').on('click', function() {
	// 	$(".modalForm").modal('show');
	// });
	// var options = {
	// 	ajax: {
	// 		url: refseeAPI,
	// 		type: 'POST',
	// 		dataType: 'json',
	// 		data: {
	// 			q: '{{{q}}}',
	// 			ref: 'barang_kamus_index',
	// 		}
	// 	},
	// 	locale: {
	// 		emptyTitle: ' '
	// 	},
	// 	log: 3,
	// 	preprocessData: function(data) {
	// 		var i, l = data.result.length,
	// 			array = [];
	// 		if (l) {
	// 			for (i = 0; i < l; i++) {
	// 				array.push($.extend(true, data.result[i], {
	// 					text: data.result[i].ICD_BARANG_KODE_INVENTORI,
	// 					value: data.result[i].ICD_BARANG_KAMUS_INDEX,
	// 					data: {
	// 						subtext: data.result[i].ICD_BARANG_NAMA
	// 					}
	// 				}));
	// 			}
	// 		} else {}
	// 		return array;
	// 	}
	// };
	// $('.selectpicker').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);
	// $('select.KODE_BARANG').on('change', function() {
	// 	var selectkodeinventori = $('.KODE_BARANG option:selected').data('subtext');
	// 	$('input.NAMA_BARANG').val(selectkodeinventori);
	// });

	function item_list(curPage) {
		$.ajax({
			type: 'POST',
			url: refseeAPI,
			dataType: 'json',
			data: 'ref=item_list&ICD_STATION_ID=<?php echo $d3; ?>',
			success: function(data) {
				if (data.respon.pesan == "sukses") {
					$("tbody#zone_data").empty();
					for (i = 0; i < data.result.length; i++) {
            if (data.result[i].ICD_TRANSAKSI_INVENTORI_STATUS == "O")
            {
              var tr = "danger";
              var btn = "";
            }
            else
            {
              var tr = "";

              var btn = "<div class='btn-group'>"+
                                  "<button class='btn btn-default btn-sm dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                  ""+
                                  "<span class='caret'></span></button>"+
                                  "<ul class='dropdown-menu dropdown-menu-right'>"+
                                  "<li><a class='pindah_lokasi' ICD_NO_INVENTORI='"+ data.result[i].ICD_NO_INVENTORI +"' ICD_BARANG_NAMA='"+ data.result[i].ICD_BARANG_NAMA +"' ICD_BARANG_KAMUS_ID='" + data.result[i].ICD_BARANG_KAMUS_ID + "'><i class='fa fa-share' aria-hidden='true'></i> Pindah</a></li>"+
                                  "<li><a class='hapus_item' ICD_NO_INVENTORI='" + data.result[i].ICD_NO_INVENTORI + "'><i class='fa fa-trash' aria-hidden='true'></i> Hapus</a></li>"+
                                  "</ul>"+
                                "</div>";
            }
						$("tbody#zone_data").append("<tr class='"+tr+"'  detailLogId='" + data.result[i].ICD_BARANG_KODE_INVENTORI + "'>" +
							"<td >" + data.result[i].NO + ".</td>" +
							"<td>" + data.result[i].ICD_NO_INVENTORI + "</td>" +
							"<td>" + data.result[i].ICD_INVENTORI_KODE + "</td>" +
							"<td>" + data.result[i].ICD_BARANG_NAMA + "</td>" +
							"<td>" + data.result[i].ICD_BARANG_KODE + "</td>" +
							"<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_WO + "</td>" +
							"<td>" + data.result[i].TANGGAL + "</td>" +
							"<td>" + data.result[i].ICD_BARANG_SPESIFIKASI + "</td>" +
							"<td>"+
              btn +
              "</td>" + "</tr>");
					}
				} else if (data.respon.pesan == "gagal") {
					$("tbody#zone_data").html("<tr><td colspan='10'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
				}
			}, //end success
			error: function(x, e) {
				error_handler_json(x, e, '=> barang_kamus_list()');
			} //end error
		});
	}
	//var send = new daftar_borongan_harian();
	$(function() {
		item_list('1');
	});

  var delay = (function()
  {
  	var timer = 0;
  	return function(callback, ms)
  	{
  		clearTimeout(timer);
  		timer = setTimeout(callback, ms);
  	};
  })();

  $('input.JUMLAH_KELUAR').keyup(function()
  {
  	var JUMLAH_STOK = $(this).val();
    console.log("Checking");
  	$("button.FormKirimInventori").attr("disabled", "disabled");
  	$(".ck-stok_jumlah").html("<span class='text-danger'>Checking...</span>");
  	delay(function()
  	{
  		cek_stok();
  	}, 500);
  });

  function cek_stok()
  {
  	var INVENTORI = $('select#NO_INVENTORI').val();
  	console.log("Nomor Inventori :" +INVENTORI);
  	var JUMLAH_STOK = $('input.JUMLAH_KELUAR').val();
  	var jumlah = Math.abs(JUMLAH_STOK);
  	console.log(INVENTORI);
  	console.log(jumlah);
  	$.ajax({
  		type: 'POST',
  		url: refseeAPI,
  		dataType: 'json',
  		data: 'ref=cek_stok&INVENTORI=' + INVENTORI,
  		success: function(data)
  		{
  			if (data.respon.pesan == "sukses")
  			{
  				for (i = 0; i < data.result.length; i++)
  				{
  					console.log(data.result[i].ICD_TRANSAKSI_INVENTORI_STOK_SISA);
  					if (jumlah < 1)
  					{
  						$("button.FormKirimInventori").attr("disabled", "disabled");
  						$(".ck-stok_jumlah").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> Stok hanya boleh lebih dari 1.</span>");
  					}
  					else if (jumlah <= data.result[i].ICD_TRANSAKSI_INVENTORI_STOK_SISA)
  					{
  						$("button.FormKirimInventori").removeAttr("disabled");
  						$(".ck-stok_jumlah").html("<span class='text-success'><i class='glyphicon glyphicon-ok-circle'></i> Stok Tersedia</span>");
  					}
  					// else if (INVENTORI == "null")
  					// {
  					// 	$("button.FormKirimInventori").attr("disabled", "disabled");
  					// 	$(".ck-stok_jumlah").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> Pilih No Inventori terlebih dahulu.</span>");
  					// }
  					else
  					{
  						$("button.FormKirimInventori").attr("disabled", "disabled");
  						$(".ck-stok_jumlah").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> Stok tidak ada. Tersedia " + data.result[i].ICD_TRANSAKSI_INVENTORI_STOK_SISA + " Unit</span>");
  					}
  				}
  			}
  			else
  			{
          $("button.FormKirimInventori").attr("disabled", "disabled");
          $(".ck-stok_jumlah").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> Gagal mengambil data.</span>");
  			}
  		}
  	});
  }

  function hapus_item(no_inventori) {
    console.log(no_inventori);
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data: 'ref=hapus_item&NO_INVENTORI=' + no_inventori,
      success: function(data) {
        if (data.respon.pesan == "sukses") {
          console.log("Sukses Hapus");
          item_list('1');
        } else {
          alert(data.respon.text_msg);
        }
      }
    });
  }

  $('tbody#zone_data').on('click', 'a.hapus_item', function(){
    var no_inventori = $(this).attr("ICD_NO_INVENTORI");
    if(confirm("Apakah anda sudah yakin menghapus Inventori ?"))
    {
      hapus_item(no_inventori);
    }

  })

  $('.FormKirimInventori').on('click', function()
  {
  	var fDataKeluarBarang = $("#fDataKeluarBarang").serialize();
  	console.info(fDataKeluarBarang);
  	$.ajax({
  		type: 'POST',
  		url: refseeAPI,
  		dataType: 'json',
  		data: 'ref=keluar_barang&' + fDataKeluarBarang,
  		success: function(data)
  		{
  			if (data.respon.pesan == "sukses")
  			{
  				$(".modalkeluarbarang").modal('hide');
  				item_list ('1');
  			}
  			else
  			{
  				alert(data.respon.text_msg);
  			}
  		}
  	});
  })
// 	$('.FormKirim').on('click', function() {
// 		var fDataKeluarBarang = $("#fData").serialize();
// 		$.ajax({
// 			type: 'POST',
// 			url: refseeAPI,
// 			dataType: 'json',
// 			data: 'ref=item_add&' + fData,
// 			success: function(data) {
// 				if (data.respon.pesan == "sukses") {
// 					$(".modalForm").modal('hide');
// 					item_list('1');
// 				} else {
// 					alert(data.respon.text_msg);
// 				}
// 			}
// 		});
// 	})
// 	var options = {
// 		ajax: {
// 			url: refseeAPI,
// 			type: 'POST',
// 			dataType: 'json',
// 			data: {
// 				q: '{{{q}}}',
// 				ref: 'penanggung_jawab',
// 			}
// 		},
// 		locale: {
// 			emptyTitle: ' '
// 		},
// 		log: 3,
// 		preprocessData: function(data) {
// 			var i, l = data.result.length,
// 				array = [];
// 			if (l) {
// 				for (i = 0; i < l; i++) {
// 					array.push($.extend(true, data.result[i], {
// 						text: data.result[i].PERSONAL_NAME,
// 						value: data.result[i].PERSONAL_NIK,
// 						data: {
// 							subtext: data.result[i].PERSONAL_NIK
// 						}
// 					}));
// 				}
// 			} else {}
// 			return array;
// 		}
// 	};
// 	$('.selectpicker_nik').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);
//
//
// function clickpindah(data)
// {
// 	var ID = $(data).attr('ICD_TRANSAKSI_INVENTORI_ID');
// 	$("#TRANSAKSI_ID").val(ID);
// 	$(".modalPindah").modal('show');
// }
//
// $('.KirimPindahBarang').on('click', function()
// {
// 	var fData = $("#fDataPindahBarang").serialize();
// 	console.log(fData);
//
// 	$.ajax({
// 		type: 'POST',
// 		url: refseeAPI,
// 		dataType: 'json',
// 		data: 'ref=pindah_barang&' + fData,
// 		success: function(data) {
// 			if (data.respon.pesan == "sukses") {
// 				$(".modalPindah").modal('hide');
// 				item_list('1');
// 			} else {
// 				alert(data.respon.text_msg);
// 			}
// 		}
// 	});
// })

//-------------------------------------------------------- IP Address --------------------------

function ip_list() {
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=ip_list&ICD_STATION_ID=<?php echo $d3; ?>',
    success: function(data) {
      if (data.respon.pesan == "sukses") {
        $("tbody#zone_ip").empty();
        for (i = 0; i < data.result.length; i++) {
          var btn = "<div class='btn-group'>"+
                              "<button class='btn btn-default btn-sm dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                              ""+
                              "<span class='caret'></span></button>"+
                              "<ul class='dropdown-menu dropdown-menu-right'>"+
                              "<li><a class='edit_ipaddress' ICD_IP_ADDRESS_INDEX='" + data.result[i].ICD_IP_ADDRESS_INDEX + "' ICD_IP_ADDRESS='" + data.result[i].ICD_IP_ADDRESS + "' ICD_MAC_ADDRESS='" + data.result[i].ICD_MAC_ADDRESS + "' ><i class='fa fa-pencil' aria-hidden='true'></i> Edit</a></li>"+
                              "<li><a class='hapus_ipaddress' ICD_IP_ADDRESS_INDEX='" + data.result[i].ICD_IP_ADDRESS_INDEX + "' ><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></li>"+
                              "</ul>"+
                            "</div>";
          $("tbody#zone_ip").append("<tr class='detailLogId'>" +
            "<td >" + data.result[i].NO + ".</td>" +
            "<td>" + data.result[i].ICD_IP_ADDRESS + "</td>" +
            "<td>" + data.result[i].ICD_MAC_ADDRESS + "</td>" +
            "<td>"+btn+"</td>" +

            "</tr>");
        }
      } else if (data.respon.pesan == "gagal") {
        $("tbody#zone_ip").html("<tr><td colspan='10'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
      }
    }, //end success
    error: function(x, e) {
      error_handler_json(x, e, '=> barang_kamus_list()');
    } //end error
  });
}
$(function() {
  ip_list();
});

$('.KirimIPAddress').on('click', function() {
  var fDataIPAddress = $("#fDataIPAddress").serialize();
  console.log(fDataIPAddress);
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data: 'ref=ip_add&ICD_STATION_ID=<?php echo $d3; ?>&' + fDataIPAddress,
      success: function(data) {
        if (data.respon.pesan == "sukses") {
          console.log("sukses");
          $(".modalIPAddress").modal('hide');
          ip_list('1');
        } else {
          alert(data.respon.text_msg);
        }
      }
    });
})

$('tbody#zone_ip').on('click', 'a.edit_ipaddress', function(){
  var ip_index = $(this).attr('ICD_IP_ADDRESS_INDEX');
  var ip = $(this).attr('ICD_IP_ADDRESS');
  var mac = $(this).attr('ICD_MAC_ADDRESS');
  console.log(ip_index);
  $('.ICD_IP_ADDRESS_INDEX').val(ip_index);
  $('.ICD_IP_ADDRESS').val(ip);
  $('.ICD_MAC_ADDRESS').val(mac);
  $('.modalIPAddress').modal('show');
})

function ip_hapus(ip_index) {
  console.log(ip_index);
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=ip_hapus&ICD_IP_ADDRESS_INDEX=' + ip_index,
    success: function(data) {
      if (data.respon.pesan == "sukses") {
        console.log("Sukses Hapus");
        ip_list('1');
      } else {
        alert(data.respon.text_msg);
      }
    }
  });
}

$('tbody#zone_ip').on('click', 'a.hapus_ipaddress', function(){
  var ip_index = $(this).attr('ICD_IP_ADDRESS_INDEX');
  if(confirm('Apakah anda yakin menghapus aplikasi ini ?')){
    ip_hapus(ip_index);
  }


})
//-------------------------------------------------------- END IP Address --------------------------


//-------------------------------------------------------- Aplikasi --------------------------
// var options =
// {
// 	ajax:
// 	{
// 		url: refseeAPI,
// 		type: 'POST',
// 		dataType: 'json',
// 		data:
// 		{
// 			q: '{{{q}}}',
// 			ref: 'pilih_aplikasi',
// 		}
// 	},
// 	locale:
// 	{
// 		emptyTitle: 'Pilih Aplikasi'
// 	},
// 	log: 3,
// 	preprocessData: function(data)
// 	{
// 		var i, l = data.result.length,
// 			array = [];
// 		if (l)
// 		{
// 			for (i = 0; i < l; i++)
// 			{
// 				array.push($.extend(true, data.result[i],
// 				{
// 					text: data.result[i].ICD_APLIKASI_MASTER_NAMA,
// 					value: data.result[i].ICD_APLIKASI_MASTER_ID,
// 					data: {
// 						subtext: data.result[i].ICD_APLIKASI_MASTER_VERSI,
// 						jenis_aplikasi: data.result[i].ICD_APLIKASI_MASTER_JENIS,
// 						nama_aplikasi: data.result[i].ICD_APLIKASI_MASTER_NAMA,
//
// 					}
// 				}));
// 			}
// 		}
// 		else
// 		{
// 		}
// 		return array;
// 	}
// };
//
// $('.selectpicker_aplikasi').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);

$('select.selectpicker_aplikasi').on('change', function()
{
	// var jenis_aplikasi = $('.selectpicker_aplikasi option:selected').data('jenis_aplikasi');
  // var versi_aplikasi = $('.selectpicker_aplikasi option:selected').data('subtext');
  // var nama_aplikasi = $('.selectpicker_aplikasi option:selected').data('nama_aplikasi');
  // $('input.ICD_APLIKASI_MASTER_VERSI').val(versi_aplikasi);
  // $('input.ICD_APLIKASI_MASTER_NAMA').val(nama_aplikasi);

  var jenis_aplikasi = $('select.ICD_APLIKASI_MASTER_ID option:selected').attr('ICD_APLIKASI_MASTER_JENIS');
  if(jenis_aplikasi == 'Licensi')
  {
    $(".licensi_aplikasi").show();
    $(".ICD_STATION_ID_APLIKASI_LISENSI").val("");
  }
  else
  {
    $(".licensi_aplikasi").hide();
    $(".ICD_STATION_ID_APLIKASI_LISENSI").val("");
  }
});


$('.KirimAplikasi').on('click', function() {
  var fDataAplikasi = $("#fDataAplikasi").serialize();
  console.log(fDataAplikasi);
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data: 'ref=station_aplikasi_add&ICD_STATION_ID=<?php echo $d3; ?>&' + fDataAplikasi,
      success: function(data) {
        if (data.respon.pesan == "sukses") {
          console.log("sukses");
          $(".modalAplikasi").modal('hide');
          station_aplikasi_list('1');
        } else {
          alert(data.respon.text_msg);
        }
      }
    });

})
function station_aplikasi_list() {
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=station_aplikasi_list&ICD_STATION_ID=<?php echo $d3; ?>',
    success: function(data) {
      if (data.respon.pesan == "sukses") {
        $("tbody#zone_aplikasi").empty();
        for (i = 0; i < data.result.length; i++) {
          var btn = "<div class='btn-group'>"+
                              "<button class='btn btn-default btn-sm dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                              ""+
                              "<span class='caret'></span></button>"+
                              "<ul class='dropdown-menu dropdown-menu-right'>"+
                              "<li><a class='edit_aplikasi' ICD_STATION_ID_APLIKASI_ID='" + data.result[i].ICD_STATION_ID_APLIKASI_ID + "' ICD_APLIKASI_MASTER_ID='" + data.result[i].ICD_APLIKASI_MASTER_ID + "' ICD_APLIKASI_MASTER_JENIS='" + data.result[i].ICD_APLIKASI_MASTER_JENIS + "' ICD_STATION_ID_APLIKASI_LISENSI='" + data.result[i].ICD_STATION_ID_APLIKASI_LISENSI + "' ICD_STATION_ID_APLIKASI_KETERANGAN='" + data.result[i].ICD_STATION_ID_APLIKASI_KETERANGAN + "' ><i class='fa fa-pencil' aria-hidden='true'></i> Edit</a></li>"+
                              "<li><a class='hapus_aplikasi' ICD_STATION_ID_APLIKASI_ID='" + data.result[i].ICD_STATION_ID_APLIKASI_ID + "' ><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></li>"+
                              "</ul>"+
                            "</div>";
          $("tbody#zone_aplikasi").append("<tr class='detailLogId'>" +
            "<td >" + data.result[i].NO + ".</td>" +
            "<td>" + data.result[i].ICD_APLIKASI_MASTER_NAMA + "</td>" +
            "<td>" + data.result[i].ICD_APLIKASI_MASTER_VERSI + "</td>" +
            "<td>" + data.result[i].ICD_STATION_ID_APLIKASI_LISENSI + "</td>" +
            "<td>" + data.result[i].ICD_STATION_ID_APLIKASI_KETERANGAN + "</td>" +
            "<td>"+btn+"</td>" +
            "<td></td>" +
            "</tr>");
        }
      } else if (data.respon.pesan == "gagal") {
        $("tbody#zone_aplikasi").html("<tr><td colspan='10'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
      }
    }, //end success
    error: function(x, e) {
      error_handler_json(x, e, '=> barang_kamus_list()');
    } //end error
  });
}
$(function() {
  station_aplikasi_list();
});

$('tbody#zone_aplikasi').on('click', 'a.edit_aplikasi', function(){
  var id_aplikasi_station_id = $(this).attr('ICD_STATION_ID_APLIKASI_ID');
  var id_aplikasi = $(this).attr('ICD_APLIKASI_MASTER_ID');
  var jenis_aplikasi = $(this).attr('ICD_APLIKASI_MASTER_JENIS');
  // var nama = $(this).attr('ICD_APLIKASI_MASTER_NAMA');
  // var versi = $(this).attr('ICD_APLIKASI_MASTER_VERSI');
  var lisensi = $(this).attr('ICD_STATION_ID_APLIKASI_LISENSI');
  var keterangan = $(this).attr('ICD_STATION_ID_APLIKASI_KETERANGAN');

  if(jenis_aplikasi == 'Licensi')
  {
    $(".licensi_aplikasi").show();
    $(".ICD_STATION_ID_APLIKASI_LISENSI").val("");
  }
  else
  {
    $(".licensi_aplikasi").hide();
    $(".ICD_STATION_ID_APLIKASI_LISENSI").val("");
  }

  console.log(jenis_aplikasi);
  $('.selectpicker_aplikasi').val(id_aplikasi)
  $('.ICD_STATION_ID_APLIKASI_LISENSI').val(lisensi)
  $('.ICD_STATION_ID_APLIKASI_KETERANGAN').val(keterangan)
  $('.ICD_STATION_ID_APLIKASI_KETERANGAN').val(keterangan)
  $('.ICD_STATION_ID_APLIKASI_ID').val(id_aplikasi_station_id)

  $(".modalAplikasi").modal('show');

})

function station_aplikasi_hapus(id_aplikasi_station_id) {
  console.log(id_aplikasi_station_id);
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=station_aplikasi_hapus&ICD_STATION_ID_APLIKASI_ID=' + id_aplikasi_station_id,
    success: function(data) {
      if (data.respon.pesan == "sukses") {
        console.log("Sukses Hapus");
        station_aplikasi_list('1');
      } else {
        alert(data.respon.text_msg);
      }
    }
  });
}

$('tbody#zone_aplikasi').on('click', 'a.hapus_aplikasi', function(){
  var id_aplikasi_station_id = $(this).attr('ICD_STATION_ID_APLIKASI_ID');
  if(confirm('Apakah anda yakin menghapus aplikasi ini ?')){
    station_aplikasi_hapus(id_aplikasi_station_id);
  }


})
//-------------------------------------------------------- END Aplikasi --------------------------
//-------------------------------------------------------- Konfigurasi --------------------------
$(".licensi_aplikasi").hide();
$('.KirimKonfigurasi').on('click', function() {
  var fDataKonfigurasi = $("#fDataKonfigurasi").serialize();
  console.log(fDataKonfigurasi);
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data: 'ref=konfigurasi_add&ICD_STATION_ID=<?php echo $d3; ?>&' + fDataKonfigurasi,
      success: function(data) {
        if (data.respon.pesan == "sukses") {
          console.log("sukses");
          $(".modalKonfigurasi").modal('hide');
          konfigurasi_list('1');
        } else {
          alert(data.respon.text_msg);
        }
      }
    });

})
function konfigurasi_list() {
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=konfigurasi_list&ICD_STATION_ID=<?php echo $d3; ?>',
    success: function(data) {
      console.log("ajax sukses");
      if (data.respon.pesan == "sukses") {
        console.log("sukses");
        $("tbody#zone_config").empty();
        for (i = 0; i < data.result.length; i++) {
          var btn = "<div class='btn-group'>"+
                              "<button class='btn btn-default btn-sm dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                              ""+
                              "<span class='caret'></span></button>"+
                              "<ul class='dropdown-menu dropdown-menu-right'>"+
                              "<li><a class='edit_konfigurasi' ICD_STATION_ID_KONFIGURASI_ID='" + data.result[i].ICD_STATION_ID_KONFIGURASI_ID + "' ICD_STATION_ID_KONFIGURASI_KONFIGURASI='" + data.result[i].ICD_STATION_ID_KONFIGURASI_KONFIGURASI + "' ICD_STATION_ID_KONFIGURASI_NILAI='" + data.result[i].ICD_STATION_ID_KONFIGURASI_NILAI + "' ICD_STATION_ID_KONFIGURASI_KETERANGAN='" + data.result[i].ICD_STATION_ID_KONFIGURASI_KETERANGAN + "'><i class='fa fa-pencil' aria-hidden='true'></i> Edit</a></li>"+
                              "<li><a class='hapus_konfigurasi' ICD_STATION_ID_KONFIGURASI_ID='" + data.result[i].ICD_STATION_ID_KONFIGURASI_ID + "' ><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></li>"+
                              "</ul>"+
                            "</div>";
          $("tbody#zone_config").append("<tr class='detailLogId'>" +
            "<td >" + data.result[i].NO + ".</td>" +
            "<td >" + data.result[i].ICD_STATION_ID_KONFIGURASI_KONFIGURASI + ".</td>" +
            "<td >" + data.result[i].ICD_STATION_ID_KONFIGURASI_NILAI + ".</td>" +
            "<td >" + data.result[i].ICD_STATION_ID_KONFIGURASI_KETERANGAN + ".</td>" +

            "<td>"+btn+"</td>" +
            "</tr>");
        }
      } else if (data.respon.pesan == "gagal") {
        $("tbody#zone_config").html("<tr><td colspan='10'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
      }
    }, //end success
    error: function(x, e) {
      error_handler_json(x, e, '=> barang_kamus_list()');
    } //end error
  });
}
$(function() {
  konfigurasi_list();
});

$('tbody#zone_config').on('click', 'a.edit_konfigurasi', function(){

  var id_konfigurasi = $(this).attr('ICD_STATION_ID_KONFIGURASI_ID');
  var konfigurasi = $(this).attr('ICD_STATION_ID_KONFIGURASI_KONFIGURASI');
  var nilai = $(this).attr('ICD_STATION_ID_KONFIGURASI_NILAI');
  var keterangan = $(this).attr('ICD_STATION_ID_KONFIGURASI_KETERANGAN');

  $('.ICD_STATION_ID_KONFIGURASI_ID').val(id_konfigurasi)
  $('.ICD_STATION_ID_KONFIGURASI_KONFIGURASI').val(konfigurasi)
  $('.ICD_STATION_ID_KONFIGURASI_NILAI').val(nilai)
  $('.ICD_STATION_ID_KONFIGURASI_KETERANGAN').val(keterangan)

  $(".modalKonfigurasi").modal('show');

})
//-------------------------------------------------------- End Konfigurasi --------------------------
//-------------------------------------------------------- Pindah Lokasi Inventori ------------------
$('tbody#zone_data').on('click', 'a.pindah_lokasi', function()
{
	var detail = $(this).attr('ICD_NO_INVENTORI');
  var nama_barang = $(this).attr('ICD_BARANG_NAMA');
  $("p#no_inventori").html("No Inventori  : "+detail);
  $("p#nama_barang").html("Nama Barang : "+nama_barang);
  $(".ICD_NO_INVENTORI").val(detail);
  // console.log(detail);
	// riwayat_lokasi(detail);
	$(".modalLokasi").modal('show');
});


var options =
{
	ajax: {
		url: refseeAPI,
		type: 'POST',
		dataType: 'json',
		data: {
			q: '{{{q}}}',
			ref: 'penanggung_jawab',
		}
	},
	locale:
	{
		emptyTitle: ' '
	},
	log: 3,
	preprocessData: function(data)
	{
		var i, l = data.result.length,
			array = [];
		if (l)
		{
			for (i = 0; i < l; i++)
			{
				array.push($.extend(true, data.result[i],
				{
					text: data.result[i].PERSONAL_NAME,
					value: data.result[i].PERSONAL_NIK,
					data:
					{
						subtext: data.result[i].PERSONAL_NIK
					}
				}));
			}
		}
		else
		{
		}
		return array;
	}
};
$('.selectpicker_nik').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);

$(".FormKirim").on('click', function(){
  var fDataPindahLokasi = $(".fDataPindahLokasi").serialize();
  console.log(fDataPindahLokasi);
  $.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=pindah_lokasi&'+fDataPindahLokasi,
		success: function(data)
		{
			if (data.respon.pesan == "sukses")
			{
        console.log("Sukses!!!!!!!!!!!!!!!!!!!!!!!!!1");
        item_list('1');
        $(".modalLokasi").modal('hide');

			}
			else if (data.respon.pesan == "gagal")
			{
        console.log("Gagal");
			}
		}, //end success
		error: function(x, e)
		{
			error_handler_json(x, e, '=> barang_kamus_list()');
		} //end error
	});

});
//-------------------------------------------------------- End Pindah Lokasi Inventori --------------
//===============================================================EDIT STATION ID===========================================
var options = {
ajax: {
  url: refseeAPI,
  type: 'POST',
  dataType: 'json',
  data: {
    q: '{{{q}}}',
    ref: 'penanggung_jawab',
  }
},
locale: {
  emptyTitle: ' '
},
log: 3,
preprocessData: function(data) {
  var i, l = data.result.length,
    array = [];

  if (l) {
    for (i = 0; i < l; i++) {
      array.push($.extend(true, data.result[i], {
        text: data.result[i].PERSONAL_NAME,
        value: data.result[i].PERSONAL_NIK,
        data: {
          subtext: data.result[i].PERSONAL_NIK +" ("+ data.result[i].COMPANY_UNIT_SHORT_NAME + ")"
        }
      }));
    }
  } else {}
  return array;
}
};
$('.selectpicker').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);

function get_staion_id_data() {
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=get_staion_id_data&ICD_STATION_ID=<?php echo $d3; ?>',
    success: function(data) {
      console.log("ajax sukses");
      if (data.respon.pesan == "sukses") {
        console.log(data.respon.pesan);
        for (i = 0; i < data.result.length; i++) {
          $('.STATION_ID_ID').val(data.result[i].ICD_STATION_ID)
          $('.LOKASI').val(data.result[i].ICD_STATION_ID_LOKASI)
          $('.DEPARTEMEN').val(data.result[i].COMPANY_UNIT_ID)
          $('.KONDISI').val(data.result[i].ICD_STATION_ID_KONDISI)
          $('.KETERANGAN').val(data.result[i].ICD_STATION_ID_KETERANGAN)
          $('select.PENANGGUNG_JAWAB').append('<option value="'+data.result[i].PERSONAL_NIK+'"  data-subtext="'+data.result[i].PERSONAL_NIK+' ('+data.result[i].COMPANY_UNIT_SHORT_NAME+')" selected="selected">'+data.result[i].PERSONAL_NAME+'</option>').selectpicker('refresh');
          $('select.PENANGGUNG_JAWAB').trigger('change');
          console.log(data.result[i].PERSONAL_NIK)
          // $(".PENANGGUNG_JAWAB").val(data.result[i].PERSONAL_NIK);
          // $(".PENANGGUNG_JAWAB").selectpicker('refresh');
        //   $("tbody#zone_config").append("<tr class='detailLogId'>" +
        //     "<td >" + data.result[i].NO + ".</td>" +
        //     "<td >" + data.result[i].ICD_STATION_ID_KONFIGURASI_KONFIGURASI + ".</td>" +
        //     "<td >" + data.result[i].ICD_STATION_ID_KONFIGURASI_NILAI + ".</td>" +
        //     "<td >" + data.result[i].ICD_STATION_ID_KONFIGURASI_KETERANGAN + ".</td>" +
        //
        //     "<td><a class='btn btn-success btn-sm pindah' onclick='clickpindah(this);' id='pindah' ICD_TRANSAKSI_INVENTORI_ID='" + data.result[i].ICD_TRANSAKSI_INVENTORI_ID + "'  data-toggle='tooltip' title='Keluar Barang'><i class='fa fa-level-up' aria-hidden='true'></i></a></td>" + "</tr>");
        }
      } else if (data.respon.pesan == "gagal") {
        console.log(data.respon.pesan);
        //$("tbody#zone_config").html("<tr><td colspan='10'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
      }
    }, //end success
    error: function(x, e) {
      error_handler_json(x, e, '=> barang_kamus_list()');
    } //end error
  });
}


$('.edit_station_id').on('click', function()
{
  $(function() {
    get_staion_id_data();
  });
	$(".modalForm").modal('show');
});

$('.FormKirim_Station_ID').on('click', function() {
	var fData = $("#fDataStationID").serialize();
  console.log(fData);
		$.ajax({
			type: 'POST',
			url: refseeAPI,
			dataType: 'json',
			data: 'ref=station_id_add&' + fData,
			success: function(data) {
				if (data.respon.pesan == "sukses") {
					$(".modalForm").modal('hide');
          location.reload();
					//station_id_list();
				} else {
					alert(data.respon.text_msg);
				}
			}
		});
});

//===============================================================EDIT STATION ID===========================================
</script>
