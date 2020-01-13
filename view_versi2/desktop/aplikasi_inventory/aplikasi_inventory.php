<?php
$INVENTORY_CONFIG=new INVENTORY_CONFIG();
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
  width:1300px;
}
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="list-group">
			<div class="list-group-item">
				<div class="row">
					<div class="col-md-8">
						<h3><i class="fa fa-folder-open"></i> <?php echo  $BAHASA->terjemahkan("Master Aplikasi");?></h3>
						<hr>
					</div>
					<div class="col-md-4 text-right"></div>
				</div><!--/.row-->
        <div class="row">
					<div class="col-md-12 text-left">
						<button class="btn btn-primary btn-sm tambah" type="button"><i aria-hidden="true" class="fa fa-plus-square"></i> Tambah Aplikasi</button>
					</div>
				</div><br>
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
									<th>Nama Aplikasi</th>
									<th>Versi Aplikasi</th>
									<th>Jenis Aplikasi</th>
                  <th>Keterangan</th>
									<th colspan="2">Aksi</th>
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

<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalAplikasi" role="dialog" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Aplikasi</h4>
      </div>
      <div class="modal-body">
        <form action="javascript:download();" class="fData" id="fData" name="fData">
          <div class="form-group">
            <label for="ICD_APLIKASI_MASTER_NAMA">Nama Aplikasi</label>
            <input autocomplete="off" class="form-control ICD_APLIKASI_MASTER_ID" id="ICD_APLIKASI_MASTER_ID" name="ICD_APLIKASI_MASTER_ID" placeholder="ICD_APLIKASI_MASTER_ID" type="hidden">
            <input autocomplete="off" class="form-control ICD_APLIKASI_MASTER_NAMA" id="ICD_APLIKASI_MASTER_NAMA" name="ICD_APLIKASI_MASTER_NAMA" placeholder="ICD_APLIKASI_MASTER_NAMA" type="text"> <small class="help-block">Nama Barang IT</small>
          </div>
          <div class="form-group">
            <label for="ICD_APLIKASI_MASTER_VERSI">Versi Aplikasi</label>
            <input autocomplete="off" class="form-control ICD_APLIKASI_MASTER_VERSI" id="ICD_APLIKASI_MASTER_VERSI" name="ICD_APLIKASI_MASTER_VERSI" placeholder="ICD_APLIKASI_MASTER_VERSI" type="text"> <small class="help-block">Nama Barang IT</small>
          </div>
           <div class="form-group">
            <label for="ICD_APLIKASI_MASTER_JENIS">Jenis Aplikasi</label>
            <select id="ICD_APLIKASI_MASTER_JENIS" name="ICD_APLIKASI_MASTER_JENIS"  type="text" class="form-control ICD_APLIKASI_MASTER_JENIS"  placeholder="PERSONAL_GENDER"  autocomplete="off" required>
              <?php foreach($INVENTORY_CONFIG->inventory()->jenis_aplikasi as $key=>$val){ echo"<option value='$key' $sel>$val</option>"; } ?>
          </select>
             <small class="help-block">Jenis Aplikasi</small>
          </div>

          <div class="form-group">
            <label for="ICD_APLIKASI_MASTER_KETERANGAN">Keterangan</label>
            <textarea class="form-control ICD_APLIKASI_MASTER_KETERANGAN" id="ICD_APLIKASI_MASTER_KETERANGAN" name="ICD_APLIKASI_MASTER_KETERANGAN" placeholder="ICD_APLIKASI_MASTER_KETERANGAN"></textarea> <small class="help-block">Isi jika diperlukan</small>
          </div>
          <div class="form-group">
            <button class="btn btn-success btn-sm FormKirim">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$('.tambah').on('click', function()
{
	$("#fData")[0].reset();
  $('.ICD_APLIKASI_MASTER_ID').val("");
	$(".modalAplikasi").modal('show');
});
function aplikasi_list(curPage)
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
    data: 'ref=aplikasi_list&batas=' + $('input#REC_PER_HALAMAN').val() + '&halaman=' + curPage + '&keyword=' + $("input#keyword").val(),
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
          $("tbody#zone_data").append("<tr class='detailLogId' >" +
            "<td >" + data.result[i].NO + ".</td>" +
            "<td>" + data.result[i].ICD_APLIKASI_MASTER_NAMA + "</td>" +
            "<td>" + data.result[i].ICD_APLIKASI_MASTER_VERSI + "</td>" +
            "<td>" + data.result[i].ICD_APLIKASI_MASTER_JENIS + "</td>" +
            "<td>" + data.result[i].ICD_APLIKASI_MASTER_KETERANGAN + "</td>" +
            "<td><a class='btn btn-success btn-sm edit_aplikasi' ICD_APLIKASI_MASTER_ID='" + data.result[i].ICD_APLIKASI_MASTER_ID + "' ICD_APLIKASI_MASTER_NAMA='" + data.result[i].ICD_APLIKASI_MASTER_NAMA + "' ICD_APLIKASI_MASTER_JENIS='" + data.result[i].ICD_APLIKASI_MASTER_JENIS + "' ICD_APLIKASI_MASTER_VERSI='" + data.result[i].ICD_APLIKASI_MASTER_VERSI + "' ICD_APLIKASI_MASTER_KETERANGAN='" + data.result[i].ICD_APLIKASI_MASTER_KETERANGAN + "'><i class='fa fa-pencil' aria-hidden='true'></i> Edit</a></td>" +
            "<td><a class='btn btn-danger btn-sm hapus_aplikasi' ICD_APLIKASI_MASTER_ID='" + data.result[i].ICD_APLIKASI_MASTER_ID + "'><i class='fa fa-trash' aria-hidden='true'></i> Hapus</a></td>" +
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
      error_handler_json(x, e, '=> barang_kamus_list()');
    } //end error
  });
}

$(function()
{
  aplikasi_list('1');
});

$(window).on('hashchange', function(e)
{
  aplikasi_list('1');
});
$("input#REC_PER_HALAMAN").on('change', function()
{
  aplikasi_list('1')
});

function search()
{
  aplikasi_list('1');
}

$('.FormKirim').on('click', function() {
  var fData = $("#fData").serialize();
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data: 'ref=aplikasi_add&' + fData,
      success: function(data) {
        if (data.respon.pesan == "sukses") {
          $(".modalAplikasi").modal('hide');
          aplikasi_list('1');
        } else {
          alert(data.respon.text_msg);
        }
      }
    });

})

$('tbody#zone_data').on('click', 'a.edit_aplikasi', function(){
  var ICD_APLIKASI_MASTER_ID = $(this).attr("ICD_APLIKASI_MASTER_ID");
  var ICD_APLIKASI_MASTER_NAMA = $(this).attr("ICD_APLIKASI_MASTER_NAMA");
  var ICD_APLIKASI_MASTER_JENIS = $(this).attr("ICD_APLIKASI_MASTER_JENIS");
  var ICD_APLIKASI_MASTER_VERSI = $(this).attr("ICD_APLIKASI_MASTER_VERSI");
  var ICD_APLIKASI_MASTER_KETERANGAN = $(this).attr("ICD_APLIKASI_MASTER_KETERANGAN");

  $('.ICD_APLIKASI_MASTER_ID').val(ICD_APLIKASI_MASTER_ID);
  $('.ICD_APLIKASI_MASTER_NAMA').val(ICD_APLIKASI_MASTER_NAMA);
  $('.ICD_APLIKASI_MASTER_JENIS').val(ICD_APLIKASI_MASTER_JENIS);
  $('.ICD_APLIKASI_MASTER_VERSI').val(ICD_APLIKASI_MASTER_VERSI);
  $('.ICD_APLIKASI_MASTER_KETERANGAN').val(ICD_APLIKASI_MASTER_KETERANGAN);
  $(".modalAplikasi").modal('show');
})

function aplikasi_hapus(aplikasi_id) {
  console.log(aplikasi_id);
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=aplikasi_hapus&ID_APLIKASI=' + aplikasi_id,
    success: function(data) {
      if (data.respon.pesan == "sukses") {
        console.log("Sukses Hapus");
        aplikasi_list('1');
      } else {
        alert(data.respon.text_msg);
      }
    }
  });
}

$('tbody#zone_data').on('click', 'a.hapus_aplikasi', function(){
  var aplikasi_id = $(this).attr("ICD_APLIKASI_MASTER_ID");
  if(confirm("Apakah anda sudah yakin menghapus aplikasi ?"))
  {
    aplikasi_hapus(aplikasi_id);
  }

})
</script>
