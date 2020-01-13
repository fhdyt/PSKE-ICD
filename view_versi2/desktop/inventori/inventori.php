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
  width:1300px;
}

.modal-kartu_stok{
  width:1009px;
}
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="list-group">
			<div class="list-group-item">
				<div class="row">
					<div class="col-md-8">
						<h3><i class="fa fa-cubes"></i> <?php echo  $BAHASA->terjemahkan("Inventori Departemen");?></h3>
						<hr>
					</div>
					<div class="col-md-4 text-right"></div>
				</div><!--/.row-->
				<div class="row">
					<div class="col-md-12 text-left">
					</div>
				</div><br>
				<div class="row">
					<div class="col-md-12 text-left">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>No. Inventori</th>
									<th>Kode Inventori</th>
									<th>Nama Barang</th>
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


<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalKartuStok" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-kartu_stok" role="document">
		<div class="modal-content ">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Kartu Stok</h4>
			</div>
			<div class="modal-body">
        <p id="no_inventori"></p>
        <p id="nama_barang"></p>
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>No.</th>
              <th>Penanggung Jawab</th>
              <th>Tanggal</th>
              <th>Lokasi</th>
              <th>WO</th>
              <th>BPB</th>
              <th>Stok Masuk</th>
              <th>Stok Keluar</th>
              <th>Stok Sisa</th>
            </tr>
          </thead>
          <tbody id="zone_data_kartu_stok">
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

<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalRiwayat" role="dialog" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Riwayat Lokasi</h4>
			</div>
			<div class="modal-body">
        <p id="no_inventori"></p>
        <p id="nama_barang"></p>
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>No.</th>
              <th>Lokasi</th>
              <th>Tanggal</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody id="zone_data_riwayat_lokasi">
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
        <form action="javascript:download();" class="fData form-group-sm" id="fData" name="fData">
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
<script>
$(function()
{
	$(".datepicker").datepicker().on('changeDate', function(ev)
	{
		$('.datepicker').datepicker('hide');
	});
});
function inventory_list(curPage)
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
		data: 'ref=inventori_list&batas=' + $('input#REC_PER_HALAMAN').val() + '&halaman=' + curPage + '&keyword=' + $("input#keyword").val(),
		success: function(data)
		{
      console.log("Ajax Sukses");
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
          if (data.result[i].ICD_TRANSAKSI_INVENTORI_STOK_SISA == 0)
          {
            var btn_pindah = "<a class='btn btn-warning btn-sm pindah_lokasi' data-toggle='tooltip' ICD_NO_INVENTORI='"+ data.result[i].ICD_NO_INVENTORI +"' ICD_BARANG_NAMA='"+ data.result[i].ICD_BARANG_NAMA +"' title='Riwayat Lokasi' ICD_BARANG_KAMUS_ID='" + data.result[i].ICD_BARANG_KAMUS_ID + "'><i class='fa fa-exchange' aria-hidden='true'></i></a> ";
          }
          else
          {
            var btn_pindah = "";
          }
					$("tbody#zone_data").append("<tr class='detailLogId'  ICD_BARANG_KAMUS_INDEX='" + data.result[i].ICD_BARANG_KAMUS_INDEX + "'>" +
						"<td >" + data.result[i].NO + ".</td>" +
						"<td>" + data.result[i].ICD_NO_INVENTORI + "</td>" +
						"<td>" + data.result[i].ICD_INVENTORI_KODE + "</td>" +
						"<td>" + data.result[i].ICD_BARANG_NAMA + "</td>" +

						"<td>"+
						// "<a class='btn btn-primary btn-sm list'  data-toggle='tooltip' title='Detail BPG' ICD_BARANG_KAMUS_ID='" + data.result[i].ICD_BARANG_KAMUS_ID + "'><i class='fa fa-list' aria-hidden='true'></i></a> " +
						"<a class='btn btn-primary btn-sm kartu_stok' data-toggle='tooltip' ICD_NO_INVENTORI='"+ data.result[i].ICD_NO_INVENTORI +"' ICD_BARANG_NAMA='"+ data.result[i].ICD_BARANG_NAMA +"' title='Kartu Stok' ICD_BARANG_KAMUS_ID='" + data.result[i].ICD_BARANG_KAMUS_ID + "'><i class='fa fa-id-card' aria-hidden='true'></i></a> " +
            "<a class='btn btn-success btn-sm riwayat_lokasi' data-toggle='tooltip' ICD_NO_INVENTORI='"+ data.result[i].ICD_NO_INVENTORI +"' ICD_BARANG_NAMA='"+ data.result[i].ICD_BARANG_NAMA +"' title='Riwayat Lokasi' ICD_BARANG_KAMUS_ID='" + data.result[i].ICD_BARANG_KAMUS_ID + "'><i class='fa fa-history' aria-hidden='true'></i></a> " +
            btn_pindah +
						"</td>" +
						"</tr>");
				}

			}
			else if (data.respon.pesan == "gagal")
			{
				$("tbody#zone_data").html("<tr><td colspan='9'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
			}
		}, //end success
		error: function(x, e)
		{
			console.log("Error Ajax");
		} //end error
	});
}

$(function()
{
	inventory_list('1');
});

$(window).on('hashchange', function(e)
{
	inventory_list('1');
});
$("input#REC_PER_HALAMAN").on('change', function()
{
	inventory_list('1')
});

function search()
{
	inventory_list('1');
}

$('tbody#zone_data').on('click', 'a.kartu_stok', function()
{
	var detail = $(this).attr('ICD_NO_INVENTORI');
  var nama_barang = $(this).attr('ICD_BARANG_NAMA');
  $("p#no_inventori").html("No Inventori : "+detail);
  $("p#nama_barang").html("Nama Barang : " +nama_barang);
  console.log(detail);
	kartu_stok(detail);
	$(".modalKartuStok").modal('show');

});


function kartu_stok(detail){
  $.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=inventori_detail&NO_INVENTORI='+detail,
		success: function(data)
		{
			if (data.respon.pesan == "sukses")
			{
        console.log("Sukses");
  			$("tbody#zone_data_kartu_stok").empty();
				for (i = 0; i < data.result.length; i++)
				{
          if (data.result[i].PERSONAL_NAME == null)
          {
            var NAME = '';
          }
          else
          {
            var NAME = data.result[i].PERSONAL_NAME;
          }
					$("tbody#zone_data_kartu_stok").append("<tr class='detailLogId'  >" +
						"<td >" + data.result[i].NO + ".</td>" +
						"<td>" + NAME + "</td>" +
						"<td>" + data.result[i].TANGGAL + "</td>" +
            "<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_LOKASI + "</td>" +
            "<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_WO + "</td>" +
            "<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_BPB + "</td>" +
            "<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_STOK_MASUK + "</td>" +
            "<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_STOK_KELUAR + "</td>" +
            "<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_STOK_SISA + "</td>" +
						"</tr>");
				}

			}
			else if (data.respon.pesan == "gagal")
			{
				$("tbody#zone_data_kartu_stok").html("<tr><td colspan='9'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
			}
		}, //end success
		error: function(x, e)
		{
			error_handler_json(x, e, '=> barang_kamus_list()');
		} //end error
	});
}

////////////////////////////////////////////////////////////////////////////////////////
$('tbody#zone_data').on('click', 'a.riwayat_lokasi', function()
{
	var detail = $(this).attr('ICD_NO_INVENTORI');
  var nama_barang = $(this).attr('ICD_BARANG_NAMA');
  $("p#no_inventori").html("No Inventori : "+detail);
  $("p#nama_barang").html("Nama Barang : "+nama_barang);
  console.log(detail);
	riwayat_lokasi(detail);
	$(".modalRiwayat").modal('show');
});


function riwayat_lokasi(detail){
  $.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=riwayat_lokasi&NO_INVENTORI='+detail,
		success: function(data)
		{
			if (data.respon.pesan == "sukses")
			{
        console.log("Sukses");
        $("tbody#zone_data_riwayat_lokasi").empty();
				for (i = 0; i < data.result.length; i++)
				{

					$("tbody#zone_data_riwayat_lokasi").append("<tr class='detailLogId'  >" +
						"<td >" + data.result[i].NO + ".</td>" +
						"<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_LOKASI + "</td>" +
						"<td>" + data.result[i].TANGGAL + "</td>" +
						"<td>" + data.result[i].ICD_TRANSAKSI_INVENTORI_KETERANGAN + "</td>" +
						"</tr>");
				}

			}
			else if (data.respon.pesan == "gagal")
			{
				$("tbody#zone_data_kartu_stok").html("<tr><td colspan='9'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
			}
		}, //end success
		error: function(x, e)
		{
			error_handler_json(x, e, '=> barang_kamus_list()');
		} //end error
	});
}

$('tbody#zone_data').on('click', 'a.pindah_lokasi', function()
{
	var detail = $(this).attr('ICD_NO_INVENTORI');
  var nama_barang = $(this).attr('ICD_BARANG_NAMA');
  $("p#no_inventori").html("No Inventori : "+detail);
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
  var fData = $(".fData").serialize();
  console.log(fData);
  $.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=pindah_lokasi&'+fData,
		success: function(data)
		{
			if (data.respon.pesan == "sukses")
			{
        console.log("Sukses");
        inventory_list('1');
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
</script>
