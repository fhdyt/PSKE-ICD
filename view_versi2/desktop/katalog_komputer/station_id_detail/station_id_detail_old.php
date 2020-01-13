<?php $INVENTORY_CONFIG=new INVENTORY_CONFIG();

$data=array(
  'ICD_STATION_ID'=>$d3,
);

$cr_data=array(
  'case'=>"nonlogin_data_443_detail",
  'batas'=>1,
  'halaman'=>1,
  'user_privileges_data'=>$_COOKIE['data_http'],
  'data'=>$data,
);

$SW=new SWITCH_DATA();
$SW->data_location="local"; //local,external
$SW->cr_data=$cr_data;
$SW->CLS=new INVENTORY_REQUESTER(); //nama class -> khusus untuk local data.
$SW->ref="INVENTORY_REQUESTER"; //nama file --> khusus untuk external data
$da=$SW->output();
// echo "<pre>".print_r($da,true)."</pre>";

foreach($da['refs'] as $r){
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
					<div class="col-md-4 text-left">
						<div class="info-box">
							<span class="info-box-icon bg-aqua"><i class="fa fa-institution"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Lokasi / Departemen</span> <span class="info-box-number"><?php echo $station_id[0]['ICD_STATION_ID_LOKASI'] ?></span> <span class="info-box-number"><?php echo $station_id[0]['COMPANY_UNIT_NAME'] ?></span>
							</div><!-- /.info-box-content -->
						</div>
					</div>
					<div class="col-md-4 text-left">
						<div class="info-box">
							<span class="info-box-icon bg-green"><i class="fa fa-user-circle"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Penanggung Jawab</span> <span class="info-box-number"><?php echo $station_id[0]['PERSONAL_NAME'] ?></span> <span class="info-box-number"><?php echo $station_id[0]['PERSONAL_NIK'] ?></span>
							</div><!-- /.info-box-content -->
						</div>
					</div>
					<div class="col-md-4 text-left">
						<div class="info-red">
							<span class="info-box-icon bg-red"><i class="fa fa-desktop"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">IP Address</span> <span class="info-box-number"><?php echo $station_id[0]['ICD_IP_ADDRESS'] ?></span>
							</div><!-- /.info-box-content -->
						</div>
					</div>
				</div><br>
				<!-- <button class="btn btn-primary btn-sm tambah" type="button"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Inventori</button> -->


            <table class="table table-bordered table-hover">
    							<thead>
    								<tr>
    					<th>No.</th>
    					<th>No Inventori</th>
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
		</div>
	</div>
</div>

<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalForm" role="dialog" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Tambah Barang Departemen</h4>
			</div>
			<div class="modal-body">
					<form action="javascript:download();" class="fData form-group-sm" id="fData" name="fData">
						<div class="form-group">
							<input autocomplete="off" class="form-control STATION_ID" id="STATION_ID" name="STATION_ID" placeholder="STATION_ID" type="hidden"> <input autocomplete="off" class="form-control STATION_ID" id="STATION_ID" name="STATION_ID" placeholder="STATION_ID" type="hidden" value="<?php echo $d3 ?>"> <label for="KODE_BARANG">Kode Inventori</label> <select class="KODE_BARANG selectpicker with-ajax-personal form-control" data-live-search="true" id="KODE_BARANG" name="KODE_BARANG">
							</select>
							<small class="help-block">Contoh : 00000072</small>
						</div>
						<div class="form-group">
							<label for="NAMA_BARANG">Nama Barang</label> <input autocomplete="off" class="form-control NAMA_BARANG" id="NAMA_BARANG" name="NAMA_BARANG" placeholder="NAMA_BARANG" type="text">
						<small class="help-block">Nama Barang Departemen IT</small>
						</div>
						<div class="form-group">
							<label for="TANGGAL">Tanggal Penanganan</label> <input autocomplete="off" class="form-control TANGGAL datepicker" id="TANGGAL" name="TANGGAL" placeholder="TANGGAL" type="text">
						<small class="help-block">Tanggal Penanganan Inventori</small>
						</div>
						<div class="form-group">
							<label for="BARANG_JENIS">Pelaksana</label> <select class="PENANGGUNG_JAWAB selectpicker_nik with-ajax-personal form-control" data-live-search="true" id="PENANGGUNG_JAWAB" name="PENANGGUNG_JAWAB">
							</select>
							<small class="help-block">Pelaksana Penanganan</small>
						</div>
						<div class="form-group">
							<label for="BARANG_JENIS">WO / PCRN</label> <input autocomplete="off" class="form-control WO" id="WO" name="WO" placeholder="WO" type="text">
						<small class="help-block">Nomor WO / PCRN Permintaan</small>
						</div>
						<div class="form-group">
							<label for="BPB">BPB</label> <input autocomplete="off" class="form-control BPB" id="BPB" name="BPB" placeholder="BPB" type="text">
						<small class="help-block">Bukti Pindah Barang</small>
						</div>

						<div class="form-group">
							<label for="JUMLAH">Jumlah</label> <input autocomplete="off" class="form-control JUMLAH" id="JUMLAH" name="JUMLAH" placeholder="JUMLAH" type="number" value='1'>
						<small class="help-block">Jumlah Inventori Keluar</small>
						</div>
						<div class="form-group">
							<button class="btn btn-success btn-sm FormKirim">Simpan</button>
						</div>
					</form>
			</div>
		</div>
	</div>
</div>
<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalPindah" role="dialog" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Pindah Barang Departemen</h4>
			</div>
			<div class="modal-body">
				<form action="javascript:download();" class="fDataPindahBarang form-group-sm" id="fDataPindahBarang" name="fDataPindahBarang">
					<div class="form-group">
						<input autocomplete="off" class="form-control TRANSAKSI_ID" id="TRANSAKSI_ID" name="TRANSAKSI_ID" placeholder="TRANSAKSI_ID" type="hidden"> <small class="help-block">

						<label for="LOKASI">Pindah Lokasi</label><input autocomplete="off" class="form-control LOKASI" id="LOKASI" name="LOKASI" placeholder="" lder="LOKASI" type="text"> <small class="help-block">Lokasi Barang Tujuan</small>
					</div>

					<div class="form-group">
						<button class="btn btn-success btn-sm KirimPindahBarang">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(function() {
		$(".datepicker").datepicker().on('changeDate', function(ev) {
			$('.datepicker').datepicker('hide');
		});
	});
	$('.tambah').on('click', function() {
		$(".modalForm").modal('show');
	});
	var options = {
		ajax: {
			url: refseeAPI,
			type: 'POST',
			dataType: 'json',
			data: {
				q: '{{{q}}}',
				ref: 'barang_kamus_index',
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
						text: data.result[i].ICD_BARANG_KODE_INVENTORI,
						value: data.result[i].ICD_BARANG_KAMUS_INDEX,
						data: {
							subtext: data.result[i].ICD_BARANG_NAMA
						}
					}));
				}
			} else {}
			return array;
		}
	};
	$('.selectpicker').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);
	$('select.KODE_BARANG').on('change', function() {
		var selectkodeinventori = $('.KODE_BARANG option:selected').data('subtext');
		$('input.NAMA_BARANG').val(selectkodeinventori);
	});

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
						$("tbody#zone_data").append("<tr class='detailLogId'  detailLogId='" + data.result[i].ICD_BARANG_KODE_INVENTORI + "'>" +
							"<td >" + data.result[i].NO + ".</td>" +
							"<td>" + data.result[i].ICD_NO_INVENTORI + "</td>" +
							"<td>" + data.result[i].ICD_BARANG_NAMA + "</td>" +
							"<td>" + data.result[i].ICD_BARANG_KODE + "</td>" +
							"<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_WO + "</td>" +
							"<td>" + data.result[i].TANGGAL + "</td>" +
							"<td>" + data.result[i].ICD_BARANG_SPESIFIKASI + "</td>" +
							"<td><a class='btn btn-success btn-sm pindah' onclick='clickpindah(this);' id='pindah' ICD_TRANSAKSI_INVENTORI_ID='" + data.result[i].ICD_TRANSAKSI_INVENTORI_ID + "'  data-toggle='tooltip' title='Keluar Barang'><i class='fa fa-level-up' aria-hidden='true'></i></a></td>" + "</tr>");
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
	$('.FormKirim').on('click', function() {
		var fData = $("#fData").serialize();
		$.ajax({
			type: 'POST',
			url: refseeAPI,
			dataType: 'json',
			data: 'ref=item_add&' + fData,
			success: function(data) {
				if (data.respon.pesan == "sukses") {
					$(".modalForm").modal('hide');
					item_list('1');
				} else {
					alert(data.respon.text_msg);
				}
			}
		});
	})
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
							subtext: data.result[i].PERSONAL_NIK
						}
					}));
				}
			} else {}
			return array;
		}
	};
	$('.selectpicker_nik').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);


function clickpindah(data)
{
	var ID = $(data).attr('ICD_TRANSAKSI_INVENTORI_ID');
	$("#TRANSAKSI_ID").val(ID);
	$(".modalPindah").modal('show');
}

$('.KirimPindahBarang').on('click', function()
{
	var fData = $("#fDataPindahBarang").serialize();
	console.log(fData);

	$.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=pindah_barang&' + fData,
		success: function(data) {
			if (data.respon.pesan == "sukses") {
				$(".modalPindah").modal('hide');
				item_list('1');
			} else {
				alert(data.respon.text_msg);
			}
		}
	});
})
</script>
