
<?php
$INVENTORY_CONFIG=new INVENTORY_CONFIG();
$no_inventori = $INVENTORY_CONFIG->no_inventori();
?>
<style>
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

table{
font-size: 12px;
}
table-detail{
font-size: 9px;
}

.modal-gudang{
  width:1000px;
}
</style>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="list-group">
			<div class="list-group-item">
				<div class="row">
					<div class="col-md-8">
						<h3><i class="fa fa-cubes"></i> <?php echo  $BAHASA->terjemahkan("Gudang Departemen");?></h3>
						<hr>
					</div>
					<div class="col-md-4 text-right"></div>
				</div><!--/.row-->
				<div class="row">
					<div class="col-md-12 text-left">
						<button class="btn btn-primary btn-sm tambah" type="button"><i aria-hidden="true" class="fa fa-plus-square"></i> Tambah Barang Departemen</button>
					</div>
				</div><br>
				<div class="row">
					<div class="col-md-12 text-left">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Kode Barang Departemen</th>
									<th>Nama Barang Departemen</th>
									<th>Jenis</th>
									<th>Spesifikasi</th>
									<th>Merk</th>
									<th>Stok Tersedia</th>
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
				</div>
				<div class="row">
					<div class="col-md-9">
						<div class="pagination-holder clearfix">
							<div class="pagination" id="tujuan-light-pagination"></div>
						</div>
					</div>
					<div class="col-md-3 text-right">
						<label>Jumlah Baris Per Halaman</label> <input class="form-control" id="REC_PER_HALAMAN" max='1000' min="1" name="REC_PER_HALAMAN" required="" type="number" value="10">
					</div>
				</div><!--/row-->
			</div><!--/.list-group-item-->
		</div><!--/.list-group-->
	</div><!--/.col-->
</div><!--/.row-->

<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalForm" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-gudang" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Tambah Barang Departemen</h4>
			</div>
			<div class="modal-body">
				<form action="javascript:download();" class="fData" id="fData" name="fData">
          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
    						<label for="LOKASI">Jenis Lokasi</label>
                <select class="col-sm-2 form-control JENIS_LOKASI" id="JENIS_LOKASI" name="JENIS_LOKASI" onchange="lokasi_barang()">
  								<option value="">--Pilih--</option>
  								<option value="GUDANG">Gudang</option>
  								<option value="LAINNYA">Lainnya</option>
  							</select>
                <small class="help-block">Lokasi Stok Barang</small>
    					</div>
            </div>
            <div class="col-md-6 lokasi_input" hidden>
              <div class="form-group">
    						<label for="LOKASI">Lokasi</label>
                <input autocomplete="off" class="form-control LOKASI_STOK" id="LOKASI_STOK" name="LOKASI_STOK" type="text">
                <small class="help-block">Lokasi Stok Barang</small>
    					</div>
            </div>
          </div>
          <div class="form_input_tambah_barang" hidden>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
    			<label for="NO_INVENTORI_NEW">Nomor Inventori</label>
    			<input autocomplete="off" class="form-control NO_INVENTORI_NEW" id="NO_INVENTORI_NEW" name="NO_INVENTORI_NEW" type="text" >
    			<small class="help-block"><span class="ck_no_inventori">Ex:0000001</span></small>
    		  </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    				<label for="KODE_BARANG_INVENTORI_NEW">Kode Inventory</label>
    				<input autocomplete="off" class="form-control KODE_BARANG_INVENTORI_NEW" id="KODE_BARANG_INVENTORI_NEW" name="KODE_BARANG_INVENTORI_NEW" type="text">
    				<small class="help-block">Ex: CPU/012/2018</small>
    		  </div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
    						<label for="KODE_BARANG_IT">Kode Barang Departemen</label> <select class="KODE_BARANG_IT selectpicker with-ajax-personal form-control" data-live-search="true" id="KODE_BARANG_IT" name="KODE_BARANG_IT">
    						</select> <small class="help-block">Kode Barang pada Departemen IT</small>
    					</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="NAMA_BARANG_IT">Nama Barang</label> <input autocomplete="off" class="form-control NAMA_BARANG_IT" id="NAMA_BARANG_IT" name="NAMA_BARANG_IT" readonly type="text"> <small class="help-block">Field akan terisi secara otomatis</small>
    					</div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
    						<label for="">Spesifikasi</label>
                <input autocomplete="off" class="form-control SPESIFIKASI" id="SPESIFIKASI" name="SPESIFIKASI" readonly type="text">
                <!-- <small class="help-block">Kode Barang pada Departemen IT</small> -->
    					</div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
    						<label for="">Merk</label>
                <input autocomplete="off" class="form-control MERK" id="MERK" name="MERK" readonly type="text">
                <!-- <small class="help-block">Field akan terisi secara otomatis</small> -->
    					</div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
    						<label for="">Type</label>
                <input autocomplete="off" class="form-control TYPE_BARANG" id="TYPE_BARANG" name="TYPE_BARANG" readonly type="text">
                <!-- <small class="help-block">Field akan terisi secara otomatis</small> -->
    					</div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
    						<label for="KODE_BARANG_LCS">Kode Barang LCS</label>
                <input autocomplete="off" class="form-control KODE_BARANG_LCS" id="KODE_BARANG_LCS" name="KODE_BARANG_LCS" readonly type="text">
                <input autocomplete="off" class="form-control KODE_BARANG_INVENTORI" id="KODE_BARANG_INVENTORI" name="KODE_BARANG_INVENTORI" readonly type="hidden">
                <small class="help-block">Field akan terisi secara otomatis</small>
    					</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="NAMA_BARANG_LCS">Nama Barang LCS</label> <input autocomplete="off" class="form-control NAMA_BARANG_LCS" id="NAMA_BARANG_LCS" name="NAMA_BARANG_LCS" readonly type="text"> <small class="help-block">Field akan terisi secara otomatis</small>
    					</div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
    						<label for="TANGGAL">Tanggal</label> <input autocomplete="off" class="form-control TANGGAL datepicker" id="TANGGAL" name="TANGGAL" value="<?php echo date("Y/m/d"); ?>" type="text"> <small class="help-block">Tanggal Masuk Gudang</small>
    					</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="WO">WO / PCRN</label> <input autocomplete="off" class="form-control WO" id="WO" name="WO" type="text"> <small class="help-block">Nomor W0 atau Permintaan</small>
    					</div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
    						<label for="PPB">PPB</label> <input autocomplete="off" class="form-control PPB" id="PPB" name="PPB" type="text"> <small class="help-block">Permintaan Pemesanan Barang</small>
    					</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="BPG">BPG</label> <input autocomplete="off" class="form-control BPG" id="BPG" name="BPG"  type="text"> <small class="help-block">Bukti Pindah Gudang</small>
    					</div>
            </div>

          </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
      						<label for="BTB">BTB</label> <input autocomplete="off" class="form-control BTB" id="BTB" name="BTB" type="text"> <small class="help-block">Bukti Terima Barang</small>
      					</div>
              </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="JUMLAH">Jumlah</label> <input autocomplete="off" class="form-control JUMLAH" id="JUMLAH" name="JUMLAH" type="number" value="1"> <small class="help-block">Jumlah Stok Barang</small>
    					</div>
            </div>


          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
    						<label for="KETERANGAN">Keterangan</label>
    						<textarea class="form-control KETERANGAN" id="KETERANGAN" name="KETERANGAN"></textarea> <small class="help-block">Isi jika diperlukan</small>
    					</div>
            </div>
          </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <button class="btn btn-success btn-sm FormKirim">Simpan</button>
                <button class="btn btn-default btn-sm BatalTambahBarang">Batal</button>
              </div>
            </div>
          </div>

				</form>
			</div>
		</div>
	</div>
</div>
<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalkeluarbarang" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-gudang" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Keluar Barang Departemen</h4>
			</div>
			<div class="modal-body">
				<form action="javascript:download();" class="fDataKeluarBarang" id="fDataKeluarBarang" name="fDataKeluarBarang">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
    						<label for="NO_INVENTORI">No. Inventori</label><input autocomplete="off" class="form-control NO_INVENTORI" id="NO_INVENTORI" name="NO_INVENTORI" readonly type="text"> <small class="help-block">Nomor Inventori Barang</small>
    					</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="NAMA_BARANG">Nama Barang</label><input autocomplete="off" class="form-control NAMA_BARANG" id="NAMA_BARANG" name="NAMA_BARANG" readonly type="text"> <small class="help-block">Nama Barang Departemen</small>
    					</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
    						<label for="TANGGAL">Tanggal</label> <input autocomplete="off" class="form-control TANGGAL_KELUAR_GUDANG datepicker" id="TANGGAL_KELUAR_GUDANG" name="TANGGAL_KELUAR_GUDANG" value="<?php echo date("Y/m/d"); ?>" type="text"> <small class="help-block">Tanggal Keluar Gudang</small>
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
    						<label for="BARANG_JENIS">WO / Purchase Reference Number</label> <input autocomplete="off" class="form-control WO" id="WO" name="WO" type="text"> <small class="help-block">Nomor WO / PCRN Permintaan</small>
    					</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="BPB">BPB</label> <input autocomplete="off" class="form-control BPB" id="BPB" name="BPB" type="text"> <small class="help-block">Bukti Pindah Barang</small>
    					</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
    						<label for="JUMLAH_KELUAR">Jumlah</label> <input autocomplete="off" class="form-control JUMLAH_KELUAR" id="JUMLAH_KELUAR" name="JUMLAH_KELUAR" type="number" value=""> <small class="help-block"><span class="ck-stok_jumlah">Jumlah Inventori Keluar</span></small>
    					</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
    						<label for="LOKASI_STOK">Lokasi Stok</label> <input autocomplete="off" class="form-control LOKASI_STOK" id="LOKASI_STOK" name="LOKASI_STOK" type="text" value=""> <small class="help-block">Lokasi Barang</small>
    					</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
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
    						<button class="btn btn-default btn-sm BatalKeluarBarang">Batal</button>
    					</div>
            </div>
          </div>
				</form>
			</div>
		</div>
	</div>
</div>
<div aria-labelledby="myLargeModalLabel" class="modal bs-example-modal-lg fade modalFormGudang" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg modal-gudang" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Gudang Departemen</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-hover table-gudang">
					<thead>
						<tr>
							<th>No.</th>
							<th>No. Invetori</th>
							<th>Nama Barang Departemen</th>
							<th>Jenis</th>
							<th>Spesifikasi</th>
							<th>Merk</th>
							<th>Tanggal</th>
							<th>WO / PCRN Permintaan</th>
							<th>PPB</th>
							<th>BPG</th>
							<th>BTB</th>
							<th>Stok Tersedia</th>
						</tr>
					</thead>
					<tbody id="zone_gudang">
						<tr>
							<td colspan="9">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div aria-labelledby="myLargeModalLabel" class="modal bs-example-modal-lg fade modalKartuStok" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Kartu Stok</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-hover table-gudang">
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode Barang Departemen</th>
							<th>Nama Barang Departemen</th>
							<th>Keterangan</th>
							<th>Tanggal</th>
							<th>Masuk</th>
							<th>Keluar</th>
						</tr>
					</thead>
					<tbody id="zone_kartu_stok">
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
<script>
$(function()
{
	$(".datepicker").datepicker().on('changeDate', function(ev)
	{
		$('.datepicker').datepicker('hide');
	});
});

$('.tambah').on('click', function()
{
	$("#fData")[0].reset();
	$(".modalForm").modal('show');
});

$('.BatalTambahBarang').on('click', function()
{
	$(".modalForm").modal('hide');
});

$('.BatalKeluarBarang').on('click', function()
{
	$(".modalkeluarbarang").modal('hide');
});

$('tbody#zone_data').on('click', 'a.list', function()
{
	var detail = $(this).attr('ICD_BARANG_KODE');
	gudang_list_detail(detail);
	$(".modalFormGudang").modal('show');
});

function gudang_list(curPage)
{
	var url = window.location.href;
	var pageA = url.split("#");
	if (pageA[1] == undefined)
	{
	}
	else
	{
		var pageB = pageA[1].split("page-");
		if (pageB[1] == '')
		{
			var curPage = curPage;
		}
		else
		{
			var curPage = pageB[1];
		}
	}
	$.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=gudang_list&batas=' + $('input#REC_PER_HALAMAN').val() + '&halaman=' + curPage + '&keyword=' + $("input#keyword").val(),
		success: function(data)
		{
			if (data.respon.pesan == "sukses")
			{
				$("tbody#zone_data").empty();
				$('#tujuan-light-pagination').pagination({
					pages: data.result_option.jml_halaman,
					cssStyle: 'light-theme',
					currentPage: curPage,
				});
				for (i = 0; i < data.result.length; i++)
				{
					$("tbody#zone_data").append("<tr class='detailLogId'  ICD_BARANG_KAMUS_INDEX='" + data.result[i].ICD_BARANG_KAMUS_INDEX + "'>" +
						"<td >" + data.result[i].NO + ".</td>" +
						"<td>" + data.result[i].ICD_BARANG_KODE + "</td>" +
						"<td>" + data.result[i].ICD_BARANG_NAMA + "</td>" +
						"<td>" + data.result[i].ICD_BARANG_JENIS + "</td>" +
						"<td>" + data.result[i].ICD_BARANG_SPESIFIKASI + "</td>" +
						"<td>" + data.result[i].ICD_BARANG_MERK + "</td>" +
						"<td>" + data.result[i].TOTAL + " " + data.result[i].WO_UNIT_NAME + "</td>" +
						"<td>"+
						// "<a class='btn btn-primary btn-sm list'  data-toggle='tooltip' title='Detail BPG' ICD_BARANG_KAMUS_ID='" + data.result[i].ICD_BARANG_KAMUS_ID + "'><i class='fa fa-list' aria-hidden='true'></i></a> " +
						"<a class='btn btn-primary btn-sm dropdown'  onclick='clickdropdown(this);' data-toggle='tooltip' title='Detail Barang' ICD_BARANG_KODE='" + data.result[i].ICD_BARANG_KODE + "'><i class='fa fa-sort-down' aria-hidden='true'></i></a> " +

						"</td>" +
						"</tr>");

				$("tbody#zone_data").append("<tr class='barang_detail hidden' id='barang_detail" + data.result[i].ICD_BARANG_KODE + "'><td colspan='8'>"+
					"<table class='table table-detail table-bordered'>"+
					"<thead class='warning'>"+
							"<th>No.</th>"+
							"<th>No. Invetori</th>"+
							"<th>Kode Invetori</th>"+
							"<th>Tanggal</th>"+
							"<th>WO / PCRN Permintaan</th>"+
							"<th>PPB</th>"+
							"<th>BPG</th>"+
							"<th>BTB</th>"+
							"<th>Stok Tersedia</th>"+
							"<th>Aksi</th>"+
							"</thead>"+
							"<tbody class='barang_detail' id='barang_detail2" + data.result[i].ICD_BARANG_KODE + "'>"+
							"<tbody><table></td></tr>"

				);
				}

			}
			else if (data.respon.pesan == "gagal")
			{
				$("tbody#zone_data").html("<tr><td colspan='9'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
			}
		}, //end success
		error: function(x, e)
		{
			error_handler_json(x, e, '=> barang_kamus_list()');
		} //end error
	});
}

$(function()
{
	gudang_list('1');
});

$(window).on('hashchange', function(e)
{
	gudang_list('1');
});
$("input#REC_PER_HALAMAN").on('change', function()
{
	gudang_list('1')
});

function search()
{
	gudang_list('1');
}

function gudang_list_detail(test)
{
	$.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=gudang_list_detail&ICD_BARANG_KODE=' + test,
		success: function(data) {
			if (data.respon.pesan == "sukses")
			{
				$("tbody#barang_detail2"+test).empty();
				for (i = 0; i < data.result.length; i++)
				{
					$("tbody#barang_detail2"+test).append("<tr>"+
						"<td>" + data.result[i].NO + ".</td>" +
						"<td>" + data.result[i].ICD_NO_INVENTORI + "</td>" +
						"<td>" + data.result[i].ICD_INVENTORI_KODE + "</td>" +
						"<td>" + data.result[i].TANGGAL + "</td>" +
						"<td>" + data.result[i].ICD_TRANSAKSI_GUDANG_WO + "</td>" +
						"<td>" + data.result[i].ICD_TRANSAKSI_GUDANG_PPB + "</td>" +
						"<td>" + data.result[i].ICD_TRANSAKSI_GUDANG_BPG + "</td>" +
						"<td>" + data.result[i].ICD_TRANSAKSI_GUDANG_BTB + "</td>" +
						"<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_STOK_SISA + " " + data.result[i].WO_UNIT_NAME + "</td>" +
						"<td><a class='btn btn-success btn-sm keluar' onclick='clickkeluar(this);' id='keluar' ICD_NO_INVENTORI='" + data.result[i].ICD_NO_INVENTORI + "' ICD_BARANG_NAMA='" + data.result[i].ICD_BARANG_NAMA + "'  data-toggle='tooltip' title='Keluar Barang'><i class='fa fa-sign-out' aria-hidden='true'></i></a></td></tr>"
						);
				}
			}
			else if (data.respon.pesan == "gagal")
			{
				$("tbody#zone_data").html("<tr><td colspan='9'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
			}
		}, //end success
		error: function(x, e)
		{
			error_handler_json(x, e, '=> barang_kamus_list()');
		} //end error
	});
}

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
			ref: 'barang_kamus_index_gudang',
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
            text: data.result[i].ICD_BARANG_KODE,
            value: data.result[i].ICD_BARANG_KODE,
            data: {
              subtext: data.result[i].ICD_BARANG_NAMA,
              nama_barang_it: data.result[i].ICD_BARANG_NAMA,
              kode_barang_lcs: data.result[i].ICD_BARANG_LCS_KODE,
              nama_barang_lcs: data.result[i].ICD_BARANG_LCS_NAMA_BARANG,
              kode_barang_inventori: data.result[i].ICD_BARANG_JENIS,
              spesifikasi: data.result[i].ICD_BARANG_SPESIFIKASI,
              merk: data.result[i].ICD_BARANG_MERK,
              type: data.result[i].ICD_BARANG_TYPE,
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

$('.selectpicker').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);
$('select.KODE_BARANG_IT').on('change', function()
{
  console.log($(this).val());
	var nama_barang_it = $('.KODE_BARANG_IT option:selected').data('nama_barang_it');
	$('input.NAMA_BARANG_IT').val(nama_barang_it);
	var kode_barang_lcs = $('.KODE_BARANG_IT option:selected').data('kode_barang_lcs');
	$('input.KODE_BARANG_LCS').val(kode_barang_lcs);
	var nama_barang_lcs = $('.KODE_BARANG_IT option:selected').data('nama_barang_lcs');
	$('input.NAMA_BARANG_LCS').val(nama_barang_lcs);
	var kode_barang_inventori = $('.KODE_BARANG_IT option:selected').data('kode_barang_inventori');
	$('input.KODE_BARANG_INVENTORI').val(kode_barang_inventori);

  var spesifikasi = $('.KODE_BARANG_IT option:selected').data('spesifikasi');
	$('input.SPESIFIKASI').val(spesifikasi);
	var merk = $('.KODE_BARANG_IT option:selected').data('merk');
	$('input.MERK').val(merk);
	var type = $('.KODE_BARANG_IT option:selected').data('type');
	$('input.TYPE_BARANG').val(type);
});

function lokasi_barang(){
  console.log("Onchange lokasi");

if($('.JENIS_LOKASI').val() == "LAINNYA")
{
  $('div.lokasi_input').attr('hidden', false);
  $('.KODE_BARANG_INVENTORI_NEW').attr('readonly', false);
  $('.KODE_BARANG_INVENTORI_NEW').val('');
  $('.NO_INVENTORI_NEW').val('');
  $('.NO_INVENTORI_NEW').attr('readonly', false);
  $('div.form_input_tambah_barang').attr('hidden', false);
}

else if($('.JENIS_LOKASI').val() == "")
{
  $('div.form_input_tambah_barang').attr('hidden', true);
  $('div.lokasi_input').attr('hidden', true);
}
else if($('.JENIS_LOKASI').val() == "GUDANG")
{
  $('div.lokasi_input').attr('hidden', true);
  $('.LOKASI_STOK').val('');
  //$('.KODE_BARANG_INVENTORI_NEW').attr('readonly', true);
  $('.KODE_BARANG_INVENTORI_NEW').val('');
  $('.NO_INVENTORI_NEW').val('');
  //$('.NO_INVENTORI_NEW').attr('readonly', true);
  $('div.form_input_tambah_barang').attr('hidden', false);
}
}

$('.FormKirim').on('click', function()
{
  $(this).attr('disabled','disabled');
	var fData = $("#fData").serialize();
	console.info(fData);
  $.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=gudang_add&' + fData,
		success: function(data)
		{
			console.log("Ajax");
			if (data.respon.pesan == "sukses")
			{
				console.log(data.respon.text_msg);
        alert("Berhasil");
						$(".modalForm").modal('hide');
				window.location.href = "?show=inventory_dept/inventory_condept/gudang";
			}
			else
			{
				alert('xxx');

			}
		},
		error: function(data)
		{
			console.log("Gagal Ajax");
		} //end error
	});

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
	$("button.FormKirimInventori").attr("disabled", "disabled");
	$(".ck-stok_jumlah").html("<span class='text-danger'>Checking...</span>");
	delay(function()
	{
		cek_stok();
	}, 500);
});

function cek_stok()
{
	var INVENTORI = $('input#NO_INVENTORI').val();
	console.log(INVENTORI);
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
					else
					{
						$("button.FormKirimInventori").attr("disabled", "disabled");
						$(".ck-stok_jumlah").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> Stok tidak ada. Tersedia " + data.result[i].ICD_TRANSAKSI_INVENTORI_STOK_SISA + " Unit</span>");
					}
				}
			}
			else
			{
				alert(data.respon.text_msg);
			}
		}
	});
}

$('.FormKirimInventori').on('click', function()
{
	var fData = $("#fDataKeluarBarang").serialize();
	console.info(fData);
	//alert(fData);
	$.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=keluar_barang&' + fData,
		success: function(data)
		{
			if (data.respon.pesan == "sukses")
			{
				$(".modalkeluarbarang").modal('hide');
				gudang_list('1');
			}
			else
			{
				alert(data.respon.text_msg);
			}
		}
	});
})

$('tbody#zone_data').on('click', 'a.kartu_stok', function()
{
	var detail = $(this).attr('ICD_BARANG_KODE');
	kartu_stok(detail);
	$(".modalKartuStok").modal('show');
});

function clickdropdown(data)
{
	console.info(data);
	var test = $(data).attr("ICD_BARANG_KODE");
	gudang_list_detail(test);
	// $('tbody#zone_data tr#barang_detail'+test).toggleClass('hidden');
	$('tbody#zone_data tr#barang_detail'+test).toggleClass('hidden');

};

function clickkeluar(data)
{
	var no_inventori = $(data).attr('ICD_NO_INVENTORI');
	var nama = $(data).attr('ICD_BARANG_NAMA');
	console.log(no_inventori);
	console.log(nama);
	$(".NAMA_BARANG").val(nama);
	$(".NO_INVENTORI").val(no_inventori);

	$(".modalkeluarbarang").modal('show');
}

function kartu_stok(detail)
{
	$.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=kartu_stok_list&ICD_BARANG_KODE=' + detail,
		success: function(data)
		{
			if (data.respon.pesan == "sukses")
			{
				$("tbody#zone_kartu_stok").empty();
				for (i = 0; i < data.result.length; i++)
				{
					$("#check").html(data.respon.text_msg);
					$("tbody#zone_kartu_stok").append("<tr class='detailLogId'>" + "<td >" + data.result[i].NO + ".</td>" + "<td>" + data.result[i].ICD_BARANG_KODE + "</td>" + "<td>" + data.result[i].ICD_BARANG_NAMA + "</td>" + "<td>" + data.result[i].ICD_KARTU_STOK_KET + "</td>" + "<td>" + data.result[i].TANGGAL + "</td>" + "<td>" + data.result[i].ICD_KARTU_STOK_IN + "</td>" + "<td>" + data.result[i].ICD_KARTU_STOK_OUT + "</td>" + "</tr>");
				}
			}
			else if (data.respon.pesan == "gagal")
			{
				$("tbody#zone_kartu_stok").html("<tr><td colspan='9'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
			}
		}, //end success
		error: function(x, e)
		{
			error_handler_json(x, e, '=> barang_kamus_list()');
		} //end error
	});
}

var options =
{
	ajax: {
		url: refseeAPI,
		type: 'POST',
		dataType: 'json',
		data: {
			q: '{{{q}}}',
			ref: 'barang_kamus_index_gudang',
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
					value: data.result[i].ICD_BARANG_KODE,
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
$('.KODE_BARANG_IT').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);




var delay = (function()
{
	var timer = 0;
	return function(callback, ms)
	{
		clearTimeout(timer);
		timer = setTimeout(callback, ms);
	};
})();

$('input.NO_INVENTORI_NEW').keyup(function()
{
	var NO_INVENTORI = $(this).val();
	$("button.FormKirim").attr("disabled", "disabled");
	$(".ck_no_inventori").html("<span class='text-danger'>Checking...</span>");

    delay(function()
    {
      if (NO_INVENTORI.length > 7)
      {
        $("button.FormKirim").attr("disabled", "disabled");
        $(".ck_no_inventori").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> No Inventori Tidak Valid</span>");
      }
      else if (NO_INVENTORI.length < 7)
      {
        $("button.FormKirim").attr("disabled", "disabled");
        $(".ck_no_inventori").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> No Inventori Tidak Valid</span>");
      }
      else
      {
      cek_no_inventori(NO_INVENTORI);
      }
    }, 500);

});

function cek_no_inventori(NO_INVENTORI)
{

	console.log(NO_INVENTORI);
	$.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=cek_no_inventori&NO_INVENTORI=' + NO_INVENTORI,
		success: function(data)
		{
      console.log(data.respon.pesan);
			if (data.respon.pesan == "sukses")
			{
				for (i = 0; i < data.result.length; i++)
				{

						$("button.FormKirim").attr("disabled", "disabled");
						$(".ck_no_inventori").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> No Inventori telah terdaftar. <a href='?show=inventory_dept/inventory_condept/station_id_detail/"+data.result[i].ICD_TRANSAKSI_INVENTORI_LOKASI+"'>Edit</a></span>");

				}
			}
			else
			{
        $("button.FormKirim").removeAttr("disabled");
        $(".ck_no_inventori").html("<span class='text-success'><i class='glyphicon glyphicon-ok-circle'></i> No Inventori Tersedia.</span>");
			}
		}
	});
}

</script>
